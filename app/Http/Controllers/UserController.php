<?php

namespace App\Http\Controllers;



use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users = User::where('role','!=','admin')->get();
        return view('users.index',compact('users'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'username' => 'unique:users,username|required|min:8|max:20',
            'email' => 'unique:users,email|required',
            'name' => 'required',
            'password' => 'required|same:confirm-password',
            'role' => 'required'
        ]);
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $status = false;
        if($input['status'] == 'Enable'){
            $status = true;
        }
        $user = new User();
        $user->name = $input['name'];
        $user->username = $input['username'];
        $user->email = $input['email'];
        $user->password = $input['password'];
        $user->role = $input['role'];
        $user->address = $input['address'];
        $user->phone = $input['phone'];
        $user->status = $status;
        $user->save();
        return redirect()->route('user.index')
            ->with('success','New User Created successfully');
    }
    public function edit($id){
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'username' => 'required|min:8|max:20',
            'name' => 'required',
            'role' => 'required'
        ]);
        $input = $request->all();
        $status = false;
        if($input['status'] == 'Enable'){
            $status = true;
        }
        $user = User::findOrFail($id);
        $user->name = $input['name'];
        $user->username = $input['username'];
        $user->role = $input['role'];
        $user->address = $input['address'];
        $user->phone = $input['phone'];
        $user->status = $status;
        $user->save();
        return redirect()->route('user.index')
            ->with('success','User Updated successfully');
    }
}
