<?php

namespace App\Http\Controllers;

use App\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tables = Table::all();
        if(sizeof($tables) == 0){
            $tableNo = 1;
        }else{
            $tableNo = $tables[sizeof($tables)-1]->table_no + 1;
        }
        return view('table.index', compact('tables'))->with('tableNo', $tableNo);
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
            'table_no' => 'required|numeric|unique:tables,table_no',
            'name' => 'required',
            'mode' => 'required',
            'status' => 'required'
        ]);
        $input = $request->all();
        $status = false;
        if($input['status'] == 'Enable'){
            $status = true;
        }
        $table = new Table();
        $table->table_no = $input['table_no'];
        $table->table_name = $input['name'];
        $table->mode = $input['mode'];
        $table->status = $status;
        $table->save();
        return redirect()->route('table.index')
            ->with('success','New Table Created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function show(Table $table)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $table = Table::findOrFail($id);
        return view('table.edit', compact('table'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'table_no' => 'required|numeric',
            'name' => 'required',
            'status' => 'required'
        ]);
        $input = $request->all();
        $status = false;
        if($input['status'] == 'Enable'){
            $status = true;
        }
        $table = Table::findOrFail($id);
        $table->table_no = $input['table_no'];
        $table->table_name = $input['name'];
        $table->status = $status;
        $table->save();
        return redirect()->route('table.index')
            ->with('success','Table Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function destroy(Table $table)
    {
        //
    }
}
