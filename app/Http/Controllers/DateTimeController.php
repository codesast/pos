<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;
use App\Transaction;
use App\TransactionDetail;
use DB;

class DateTimeController extends Controller
{
    //
    public function showdatetime(){

    	$itemdetails="";



    		//   	$now = Carbon::now();
			// echo "now ".$now."<br/>"; 									// 2018-03-20 11:14:05

			// $yesterday = Carbon::yesterday();
			// echo "yesterday ".$yesterday."<br/>";                         // 2018-03-19 00:00:00

			// $today = Carbon::today();
			// echo "today date".$today."<br/>";                             // 2018-03-20 00:00:00
			// $tomorrow = Carbon::tomorrow('Europe/London');
			// echo "tomorrow".$tomorrow."<br/>";                          // 2018-03-21 00:00:00

			// $dt = new \DateTime('first day of January 2008'); // <== instance from another API
			// $carbon = Carbon::instance($dt);
			// echo get_class($carbon);                               // 'Carbon\Carbon'
			// echo $carbon->toDateTimeString();                      // 2008-01-01 00:00:00

			// $date = new DateTime('now');
			// echo "<br/> date time format".$date->format('u');

			// echo "mocri time ".Carbon::now()->micro; // microtime in all PHP version
			

    	return view('datetime.index')->with('itemdetails',$itemdetails);
    }
    public function viewreport(Request $request){
    	$carbon = new Carbon;
    	$inputdate=$request->all();
    	$startdate = Carbon::parse($inputdate['startdate']);
    	$enddate = Carbon::parse($inputdate['enddate'])->addDay();
    	
    	$itemdetails =TransactionDetail::whereBetween('created_at', [$startdate, $enddate])->select('item_name',
                     DB::raw('SUM(item_quantity) as quantity'))
                 ->groupBy('item_name')
                 ->get();
        //return $itemdetails;
        //data for bar chart
        // $itemdetails =TransactionDetail::whereBetween('created_at', [$startdate, $enddate])->select('item_name',
        //              DB::raw('SUM(item_quantity) as quantity'),DB::raw('DATE(created_at) as date'))
        //          ->groupBy('item_name','date')
        //          ->get();
        // return $itemdetails;


        $interval = $startdate->diff($enddate);
        $days = $interval->format('%a');//now do whatever you like with $days
        //return $days;

        $date=array();
        for($i=0; $i<=$days; $i++){
                 $adddate = '';
                $adddate = $startdate->addDays(1)->toDateString();
                array_push($date,$adddate);
            }
    	return view ('datetime.index')->with('itemdetails',$itemdetails);
    }
public function chartdata(){
    $results =TransactionDetail::select('item_name',
                     DB::raw('SUM(item_quantity) as quantity'))
                 ->groupBy('item_name')
                 ->get();
     return response()->json($results);
    
}
public function showajaxpostform(){
    return view('datetime.datetime');
}
public function ajaxpost(Request $request){
    $inputdata = $request->all();

    $startdate = Carbon::parse($inputdata['startDate']);
    $enddate = Carbon::parse($inputdata['endDate'])->addDay();
    //return $enddate;

    $itemdetails =TransactionDetail::whereBetween('created_at', [$startdate, $enddate])->select('item_name',
                     DB::raw('SUM(item_quantity) as quantity'))
                 ->groupBy('item_name')
                 ->get();

    return $itemdetails;
}
}