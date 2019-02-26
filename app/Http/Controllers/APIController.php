<?php

namespace App\Http\Controllers;

use App\Category;
use App\Menu;
use App\Order;
use App\Table;
use App\User;
use App\DeliveryStatus;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;
use Exception;
use Carbon\Carbon;


class APIController extends Controller
{
    public function login(Request $request){
        $input = $request::all();
        if(Auth::attempt(['email' => $input['email'],'password' => $input['password']])){
            $user =  User::where('email',$input['email'])->first();
            if($user->status){
                if($user->role != 'Waiter'){
                    $response = [
                        'success' => false,
                        'message' => 'Role not authorized for this action!'
                    ];
                }else{
                    $response = [
                        'success' => true,
                        'message' => 'User Logged In!',
                        'user' => [
                            'id' => $user->id,
                            'name' => $user->name,
                            'username' => $user->username,
                            'email' => $user->email,
                            'phone' => $user->phone,
                            'address' => $user->address
                        ]
                    ];
                }
            }else{
                $response = [
                    'success' => false,
                    'message' => 'User is Disabled!'
                ];
            }

        }else{
            $response = [
                'success' => false,
                'message' => 'Credentials Mismatch!'
            ];
        }
        return $response;
    }

    public function getTables(){
        $tables = Table::where('status', true)->get();
        if(!$tables){
            $response = [
                'success' => false,
                'message' => 'No Table found!',
                'tables' => [
                ]
            ];
        }else{
            $response = [
                'success' => true,
                'message' => 'Table Successfully Loaded!',
                'tables' => $tables
            ];
        }
        return $response;
    }

    public function getMenus(){
        $menus = Menu::where('status', true)->with('category')->get();
        if(!$menus){
            $response = [
                'success' => false,
                'message' => 'No Menu found!',
                'menus' => [
                ]
            ];
        }else{
            $response = [
                'success' => true,
                'message' => 'Menu Successfully Loaded!',
                'menus' => $menus
            ];
        }
        return $response;
    }

    public function getCategories(){
        $categories = Category::where('status', true)->get();
        if(!$categories){
            $response = [
                'success' => false,
                'message' => 'No Menu found!',
                'categories' => [
                ]
            ];
        }else{
            $response = [
                'success' => true,
                'message' => 'Menu Successfully Loaded!',
                'categories' =>$categories
            ];
        }
        return $response;
    }

    public function postOrder(Request $request){
        $input = $request::all();

        if(empty($input['orders'])){
            $response=[     
                            'success'=>false,
                            'message'=>'please enter order'
                        ];
                    
            return $response;
            }
            
        $table = Table::find($input['table_no']);
        $kotOrder = array();
        $botOrder = array();
        $message = "Order placed successfully.";
        $table->mode = 'BUSY';
        $table->save();
        foreach ($input['orders'] as $orderItem){
            $order = new Order();
            $delivery_status= new DeliveryStatus();
            //order
            $order->menu_id = $orderItem['item_id'];
            $order->table_id = $input['table_no'];
            $order->qty = $orderItem['qty'];
            $order->note = $orderItem['note'];
            $order->save();
            //order status
            $delivery_status->order_id=$order->id;
            $delivery_status->status = false;
            $delivery_status->save();

            if(($order->menu->category->type) == 'KOT'){
                array_push($kotOrder, $order);
            }else{
                array_push($botOrder, $order);
            }
        }
        $tableNo = $table->table_no;
        if(sizeof($kotOrder) != 0){
           $printData = '';
           $index = 1;
           foreach ($kotOrder as $kotOrderItem){
               //dd($kotOrderItem->note);
               if($kotOrderItem->note == null || $kotOrderItem->note == ''){
                   $printData = $printData.$index.'. '. $kotOrderItem->menu->name.' ----- '.$kotOrderItem->qty."\n";
               }else{
                   $printData = $printData.$index.'. '. $kotOrderItem->menu->name.' ----- '.$kotOrderItem->qty."\n (".$kotOrderItem->note.") \n";
               }
               $index++;
           }
           if($this->printData($tableNo, $printData, 'KOT') == false){
               $message = 'Failed to print at KOT printer';
           }
        }
        if(sizeof($botOrder) != 0){
            $printData = '';
            $index = 1;
            foreach ($botOrder as $botOrderItem){
                if($botOrderItem->note == null || $botOrderItem->note == ''){
                    $printData =$printData.$index.'. '. $botOrderItem->menu->name." ----- ".$botOrderItem->qty." \n";
                }else{
                    $printData =$printData.$index.'. '. $botOrderItem->menu->name." ----- ".$botOrderItem->qty." \n (".$botOrderItem->note.") \n";
                }
                $index++;
            }
            if($this->printData($tableNo, $printData, 'BOT') == false){
                $message = 'Failed to print at BOT printer';
            }
        }
        $response = [
            'success' => true,
            'message' => $message
        ];
        return $response;
    }
    public function getOrder(Request $request , $id){
            $orderdetails=Order::where('table_id',$id)->with('menu')->get();
            //return $orderdetails;
            $response= [
                        'success' => false,
                        'message' => 'no data'
                            ];
            if(empty($orderdetails)){
                $response = [
                            'success' => false,
                            'message' => 'no data'
                            ];
                return $response;
                        }
                else{

                    $message=[];
            foreach($orderdetails as $order){
                if($order->table->mode=="BUSY"){
                        $msg=[
                            'order_id' => $order->id,
                            'qty' => $order->qty,
                            'item_name'=>$order->menu->name,
                            'item_price'=>$order->menu->price,
                            'time'=> $order->created_at->toDateTimeString()
                        ];
                        array_push($message, $msg);    
                }
                else{   
                        $message=['success'=>false,
                                    'message'=>'table not in busy mode'];   
                        } 
                $response = [
                            'success' => true,
                            'message' => $message
                        ];
    }
    return $response;
}

}

    public function postCheckout(Request $request){
        $input = $request::all();
        $table = Table::find($input['table_no']);
        $table->mode = 'WAITING';
        $table->save();
        $response = [
            'success' => true,
            'message' => 'Checkout successful.'
        ];
        return $response;
    }
    public function tabledetails($id){
        $response = [];
        $tabledetails=Order::where('table_id',$id)->with('delivery_status')->with('menu')->get();
       //return $tabledetails;

        if(count($tabledetails)<1){
            $res=[
                    "status"=>false,
                    "message"=>"fail to find table details"
                ];
                    array_push($response,$res);
                    
        }else{
        foreach ($tabledetails as $tabledetail){
             $msg=[
                    'menu name'=>$tabledetail->menu->name,
                    'qunatity'=>$tabledetail->qty,
                    'price'=>$tabledetail->menu->price,
                    'order date'=>($tabledetail->created_at)->toDateTimeString(),
                    'order status'=>!!$tabledetail->delivery_status->status
                    ];
            array_push($response, $msg);


        }
    }
       

        return $response;
    }
    public function changedeliverstatus(Request $request){
        $response=  [];
        $inputdata = $request::all();
        if(empty($inputdata['orders'])){
            $response=[
                        "status"=>false,
                        "message"=>"no order found"
                        ];
        }
        else{
        foreach($inputdata['orders'] as $input){

            $changestatus=DeliveryStatus::where('order_id',$input['order_id'])->update(['status' => $input['status']]);
            
        }
        $response=[
                        "status"=>true,
                        "message"=>"update successfully"
                        ];
    }
    return $response;
}

    public function printData($pTableN0, $pData, $pType){
        if($pType == 'KOT'){
            $printerAddress = "192.168.1.252";
        }else{
            $printerAddress = "192.168.1.253";
        }
        try {
            $connector = new NetworkPrintConnector($printerAddress, 9100);
            $printer = new Printer($connector);
            $printer -> feed(2);
            $printer -> text("*******   Table No $pTableN0   *******");
            $printer -> feed(2);
            $printer -> text($pData);
            $printer -> feed(1);
            $printer -> text("< < < < < < < END > > > > > >");
            $printer -> feed(3);
            $printer -> close();
            return true;
        } catch (Exception $e) {
            //echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
            return false;
        }


    }


}
