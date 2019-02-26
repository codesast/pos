<?php

namespace App\Http\Controllers;

use App\Record;
use App\Menu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Transaction;
use \Excel;
class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $endDate = Carbon::now()->addDay();
        /*For productoin make start date 7 days earlier than now() by subDays(7)*/
        $startDate = Carbon::now()->subMonth();
        $reports = Record::whereBetween('created_at', [$startDate, $endDate])->get();
        $total = Transaction::whereBetween('created_at',[$startDate, $endDate])->sum('total');
        return view('reports.report',compact('reports'))
        ->with('total',$total);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function search(Request $request){
        $this->validate($request,[
            'menu_type' => 'required',
            'startDate' => 'required|date',
            'endDate' => 'required|date'
        ]);
        $input = $request->all();
        $startDate = Carbon::parse($input['startDate']);
        $endDate = Carbon::parse($input['endDate'])->addDay();
        if($input['menu_type'] == 0){
             $reports = Record::whereBetween('created_at', [$startDate, $endDate])
        ->get();
        }
        else{
             $reports = Record::whereBetween('created_at', [$startDate, $endDate])->get()->filter(function($value, $key) use($input){
            return $value->menu->category_id == $input['menu_type'];
        });     
        }
       
        $total = Transaction::whereBetween('created_at',[$startDate, $endDate])->sum('total');
        return view('reports.report',compact('reports'))
        ->with('total',$total);
    }

    public function savetoexcel(){
        // Execute the query used to retrieve the data. In this example
    // we're joining hypothetical users and payments tables, retrieving
    // the payments table's primary key, the user's first and last name, 
    // the user's e-mail address, the amount paid, and the payment
    // timestamp.

    $allrecord = Record::where('id','>=',1)->get();
    //return $allrecord;

    // Initialize the array which will be passed into the Excel
    // generator.
    $recordArray = []; 
    // Define the Excel spreadsheet headers
    $recordArray[] = ['menu name', 'categoryy','category type','quantity','note','date'];

    // Convert each member of the returned collection into an array,
    // and append it to the payments array.
    foreach ($allrecord as $key => $record) {
            $qty=$record->qty;
            $note=$record->note;
            $date=Carbon::parse($record->created_at)->toDateString();
            $menuname=$record->menu->name;
            $cat=$record->menu->category->name;
            $cattype=$record->menu->category->type;
            $temp=[ 'menuname'=>$menuname,
                    'category'=>$cat,
                    'type'=>$cattype,
                    'qty'=>$qty,
                    'note'=>$note,
                    'date'=>$date
                ];
            array_push($recordArray,$temp);
    }
    //return $recordArray;

    // Generate and return the spreadsheet
    $excel=new Excel;


    $excel->create('Laravel Excel', function($excel) use ($recordArray) {
        $excel->sheet('sheet1', function($sheet) use ($recordArray) {
            $sheet->fromArray($recordArray, null, 'A1', false, false);
        });

    })->download('xlsx');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function show(Record $record)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function edit(Record $record)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Record $record)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function destroy(Record $record)
    {
        //
    }
}
