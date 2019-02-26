<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('category.index',compact('categories'));
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
            'name' => 'required|min:3|max:20',
            'type' => 'required',
            'status' => 'required',
        ]);
        $input = $request->all();
        $status = false;
        if($input['status'] == 'Enable'){
            $status = true;
        }
        $category = new Category();
        $category->name = $input['name'];
        $category->description = $input['description'];
        $category->type = $input['type'];
        $category->status = $status;
        $category->save();
        return redirect()->route('category.index')
            ->with('success','New Category Created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required|min:3|max:20',
            'type' => 'required',
            'status' => 'required',
        ]);
        $input = $request->all();
        $status = false;
        if($input['status'] == 'Enable'){
            $status = true;
        }
        $category = Category::find($id);
        $category->name = $input['name'];
        $category->description = $input['description'];
        $category->type = $input['type'];
        $category->status = $status;
        $category->save();
        return redirect()->route('category.index')
            ->with('success','Category Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
