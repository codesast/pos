<?php

namespace App\Http\Controllers;

use App\Category;
use App\Menu;
use App\Stock;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::all();
        $categories = Category::all();
        return view('menu.index',compact('menus','categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|min:3|max:20',
            'category' => 'required',
            'price' => 'required',
            'stockable' => 'required',
        ]);
        $input = $request->all();
        if($input['stockable']=='Stockable'){
            $input['stockable'] = true;
        }else{
            $input['stockable'] = false;
        }
        if($input['status']=='Enable'){
            $input['status'] = true;
        }else{
            $input['status'] = false;
        }
        if($request->file('image') != null){
            $photoName = time().'.'.$request->file('image')->getClientOriginalExtension();
        }
        $menu = new Menu();
        $menu->name = $input['name'];
        $menu->category_id = $input['category'];
        $menu->price = $input['price'];
        if($request->file('image') != null){
            $menu->image = $photoName;
        }
        $menu->stockable = $input['stockable'];
        $menu->status = $input['status'];
        $menu->save();
        if($request->file('image') != null){
            $request->file('image')->move(public_path('images/menu'), $photoName);
        }
        if($input['stockable']){
            $stock = new Stock();
            $stock->menu_id = $menu->id;
            $stock->qty = 0;
            $stock->save();
        }
        return redirect()->route('menu.index')
            ->with('success','New Menu Created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $categories = Category::all();
        return view('menu.edit', compact('menu','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required|min:3|max:20',
            'category' => 'required',
            'price' => 'required',
            'stockable' => 'required',
        ]);
        $input = $request->all();
        if($input['stockable']=='Stockable'){
            $input['stockable'] = true;
        }else{
            $input['stockable'] = false;
        }
        if($input['status']=='Enable'){
            $input['status'] = true;
        }else{
            $input['status'] = false;
        }
        if($request->file('image') != null){
            $photoName = time().'.'.$request->file('image')->getClientOriginalExtension();
        }
        $menu = Menu::find($id);
        $menu->name = $input['name'];
        $menu->category_id = $input['category'];
        $menu->price = $input['price'];
        if($request->file('image') != null){
            $menu->image = $photoName;
        }
        $menu->stockable = $input['stockable'];
        $menu->status = $input['status'];
        $menu->save();
        if($request->file('image') != null){
            $request->file('image')->move(public_path('images/menu'), $photoName);
        }
        if($input['stockable']){
            $stock = Stock::where('menu_id',"=",$id)->first();
            if($stock == null){
                $stock = new Stock();
                $stock->menu_id = $id;
                $stock->qty = 0;
                $stock->save();
            }
        }
        return redirect()->route('menu.index')
            ->with('success','Menu Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        //
    }
}
