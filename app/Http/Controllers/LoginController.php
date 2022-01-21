<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use Illuminate\Support\Facades\Auth;

interface ILoginController
{
    public function index();
    public function loginvalidation($request);
    public function login(Request $request);
}

class LoginController extends Controller implements ILoginController
{
    public function index(){
        return view('login');
    }

    public function loginvalidation($request){
        $validated = $request->validate([
            'user_name' => 'required',
            'password' => 'required'
        ]);
    }

     public function login(Request $request){
        $validate=$this->loginvalidation($request);
        $credentials = $request->only('user_name', 'password');
        if (Auth::attempt(['user_name'=>$request['user_name'],'password'=>$request['password']])) {
            return redirect('customer');
        }
        return redirect("login");
    }

}
