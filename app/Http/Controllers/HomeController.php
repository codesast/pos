<?php

namespace App\Http\Controllers;

use App\Record;
use App\Stock;
use App\Table;
use App\Order;
use App\TransactionDetail;
use App\Transaction;
use App\DeliveryStatus;
use Validator;
use Redirect;
use Carbon\Carbon;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;
use Exception;

use Illuminate\Http\Request;

use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tableFree  = Table::where('mode','FREE')->get();
        $tableBusy = Table::where('mode','BUSY')->get();
        $tableWaiting = Table::where('mode','WAITING')->get();
        foreach ($tableBusy as $table){
            $table->orders = $table->order()->get();
        }
        foreach ($tableWaiting as $table){
            $table->orders = $table->order()->select(DB::raw("SUM(qty) as qty"),'menu_id')->groupby('menu_id')->get();
            //$table->orders = $table->order()->get();
        }
        return view('dashboard',compact('tableFree','tableBusy','tableWaiting'));
    }

    public function checkoutTable(Request $request,$id){
        $orders = Order::where('table_id',$id)->with('delivery_status')->get();
        //return $orders;
         $validator = Validator::make($request->all(), [
            'discount' => 'required | numeric',
            'service_charge' => 'required | numeric',
            //'discount' => 'required | dimensions:ratio=3/2'
            
            //alternative way validation rule digits_between:1,10  
        ]);

        if ($validator->fails()) {
            $error=$validator->errors();
           //return $error;
             return redirect('/')->with('errors',$error);
        }


        $transaction = new Transaction;
        $transaction->table_id = $id;
        $transaction->total = 0;
        $transaction->name = "Transaction";
        $transaction->save();
        $total = 0;
        $gtotal=0;
        $orders_group = Order::where('table_id',$id)->select(DB::raw("SUM(qty) as qty"),'menu_id')->groupby('menu_id')->get();
        $bill=Transaction::where('table_id',$id)->get();
        //return $bill[count($bill)-1];
        $bill_id=$bill[count($bill)-1]->id;
        $date=$bill[count($bill)-1]->created_at->toDateString();  

        $print_data='SN  Item        Price Qty  Total'."\n";
        $index=01;
        foreach($orders_group as $key => $value){
            $trans_detail = new TransactionDetail;
            $trans_detail->transction_id = $transaction->id;
            $trans_detail->item_name = $value->menu->name;
            $trans_detail->item_price = $value->menu->price;
            $trans_detail->item_quantity = $value->qty;
            $trans_detail->item_rate = $value->menu->price * $value->qty;
            $trans_detail->extra_charge = 0;
            $trans_detail->isdiscount = 0;
            $trans_detail->save();
            $total += $value->menu->price * $value->qty;
            $gtotal += $total;
            $length =strlen($value->menu->name);
            $truncatedname=$value->menu->name;
            $truncatedprice=$value->menu->price;
            $truncatedqty=$value->qty;
            if(strlen($truncatedprice)<4){
                    for($j=strlen($truncatedprice); $j<4; $j++){
                                $truncatedprice .= ' ';
                            }
            }
            if(strlen($truncatedqty)<4){
                 for($k=strlen($truncatedqty); $k<=4; $k++){
                                $truncatedqty .= ' ';
                            }
                
            }

            if($length<12){
                            for($i=$length; $i<12; $i++){
                                $truncatedname .= ' ';
                            }
                        }else{

                        $truncatedname = str_limit($value->menu->name, 12,'');
                    }
                    //return $truncated;
                    if($index<10)  
                        $index ="0".$index;

            $print_data .= $index.'.'. $truncatedname.' '.$truncatedprice. '  '. $truncatedqty. '' . $total."\n";
            $index++;
            $total=0;

        }
        //return $print_data;
        $print_data .= '                          ------';
        $print_data .= "\n" .'Total                 Rs.'.$gtotal."/-\n";
        
        
        
        $trans_detail = new TransactionDetail;
        $trans_detail->transction_id = $transaction->id;
        $trans_detail->item_name = "Service Charge";
        $trans_detail->item_price = $request->get('service_charge');
        $trans_detail->item_quantity = 1;
        $trans_detail->item_rate = $request->get('service_charge');
        $trans_detail->extra_charge = 1;
        $trans_detail->isdiscount = 0;
        $trans_detail->save();
        $total = $total + $request->get('service_charge');
        $gtotal=$gtotal+ $request->get('service_charge');

        $trans_detail = new TransactionDetail;
        $trans_detail->transction_id = $transaction->id;
        $trans_detail->item_name = "Discount";
        $trans_detail->item_price = $request->get('discount');
        $trans_detail->item_quantity = 1;
        $trans_detail->item_rate = $request->get('discount');
        $trans_detail->extra_charge = 0;
        $trans_detail->isdiscount = 1;
        $trans_detail->save();
        $total = $total - $request->get('discount');
        $gtotal=$gtotal- $request->get('discount');


        $transaction->total = $gtotal;
        $transaction->save();

        $print_data .= "\n" .'Discount  ------- '.$request->get('discount')."\n";
        $index++;
        $print_data .= 'Service Charge -- '.$request->get('service_charge')."\n";

        $print_data .= 'Grand Total -- Rs.'.$gtotal."/-\n";
        // 
        //return $print_data;

        //call printer 
        $this->printData($id,$print_data,$date,$bill_id);

        foreach ($orders as $order){
            /*Reducing item stock if menu item is stockable*/
            if($order->menu->stockable){
                $stock = $order->menu->stock;
                $stock->qty = $stock->qty - $order->qty;
                $stock->save();
            }
            /*Saving data to record for reporting*/
            $record = new Record();
            $record->menu_id = $order->menu_id;
            $record->qty = $order->qty;
            $record->note = $order->note;
            $record->table_id = $order->table_id;
            $record->created_at = $order->created_at;
            $record->save();
        }
        foreach ($orders as $order){
            $order->delivery_status->delete();
            $order->delete();
        }
        $table = Table::findOrFail($id);
        $table->mode = 'FREE';
        $table->save();

        
        return redirect()->route('home');
    }

    public function editOrder($id){
        $table = Table::findOrFail($id);
        $table->order = $table->order()->get();
        return view('editorder', compact('table'));
    }

    public function showupdateform($id){
        $order = Order::findOrFail($id);
        return view('editorder1')
        ->with('order',$order);
    }

    public function updateorder(Request $request){
        $input = $request->all();
        //return $input;
        $order = Order::find($input['order_id']);
        $order->qty=$input['qty'];  
        $order->save();
        return redirect('/home');
    }

    public function deleteOrder($id){
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('home');
    }

    public function changeTableStatus($id){
        $table = Table::findOrFail($id);
        $table->mode = 'WAITING';
        $table->save();

        return back();
    }
    public function movetable(Request $request,$origin){
            $origin_table_no=$origin;
            $destination_table_no = $request->get('moveto');
            $table = Table::where('table_no' ,'=' ,$origin_table_no)->with('order')->get();
            $maketablebusy = Table::where('table_no','=',$destination_table_no)->get();
            $maketablebusy[0]->mode="BUSY";
            $maketablebusy[0]->save();
                foreach($table as $tbl){
                            $tbl->mode = "FREE";
                                foreach($tbl['order'] as $oldorder){
                                        $oldorder->table_id=$destination_table_no;
                                        $oldorder->save();
                                    }
                            $tbl->save();
                        }

            return back();
   }
    public function viewtransaction(){
        $transactions=Transaction::where(DB::raw('date(created_at)'), Carbon::today())->with('trans_detail')->get();
        $total=Transaction::where(DB::raw('date(created_at)'),Carbon::today())->sum('total');;
        //return $total;

        // $transc_item_details=Transaction::where(DB::raw('date(created_at)'), Carbon::today())->with('trans_detail')->get();
        $itemdetails =TransactionDetail::where(DB::raw('date(created_at)'), Carbon::today())
                 ->select('item_name', DB::raw('SUM(item_quantity) as quantity'))
                 ->groupBy('item_name')
                 ->get();
        //return $getData;

        return view ('view_bill',compact('transactions','itemdetails','total'));
    }

    public function printData($id,$print_data,$billingdate,$bill_id){
    $printerAddress = "192.168.1.50";
        try {
            $connector = new NetworkPrintConnector($printerAddress, 9100);
            $printer = new Printer($connector);
            $printer ->text("Date:$billingdate            $bill_id");
            $printer->feed(2);

            $printer ->text("****** Gandaki Trout Farm ******");
            $printer -> feed(1);
            $printer -> text("-------- Service Voucher --------");
            $printer -> feed(1);
            $printer -> text("*******   Table No  $id  *******");
            $printer -> feed(1);
            $printer -> text($print_data);
            $printer -> feed(1);
            $printer -> text("< < < < < <  See  You  > > > > >");
            $printer -> feed(3);
            $printer -> cut();
            $printer -> close();

            return "true";
        } catch (Exception $e) {
            //echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
            return "false";
        }
    }

}
