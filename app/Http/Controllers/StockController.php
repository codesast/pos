<?php

namespace App\Http\Controllers;

use App\Stock;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stocks = Stock::all();
        return view('stock.index',compact('stocks'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'stock_id' => 'required',
            'quantity' => 'required|numeric'
        ]);
        $input = $request->all();
        $stock = Stock::find($input['stock_id']);
        $stock->qty = $input['quantity']+$stock->qty;
        $stock->save();
        return redirect()->route('stock.index')
            ->with('success','Stock Updated successfully');
    }

    public function report()
    {
        $endDate = Carbon::now()->addDay();
        /*For productoin make start date 7 days earlier than now() by subDays(7)*/
        $startDate = Carbon::now()->subMonth();
        $reports = Stock::whereBetween('created_at', [$startDate, $endDate])->get();
        //return $reports;
        return view('reports.stock',compact('reports'));
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
        $reports = Stock::whereBetween('created_at', [$startDate, $endDate])->get();
        return view('reports.stock',compact('reports'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
        //
    }
}
