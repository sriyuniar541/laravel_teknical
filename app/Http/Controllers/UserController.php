<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index()
    {
       return view('users.register');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'email'     =>'required|email|unique:users,email',
            'password'  =>'required|min:8',
            'name'      => 'required',
            'role'      =>'required'
            
        ], [
            'email.required'    => 'Email wajib diisi',
            'password.required' => ' Password wajib diisi',
            'email.unique'      => 'Email sudah terdaftar',
            'name.required'    => 'name wajib diisi',
            'role.required' => ' role wajib diisi'
        ]);

        $data = [
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'name'      => $request->name,
            'role'      => $request->role
        ]; 

        $user = User::create($data);

        event(new Registered($user));

        Auth::login($user);
        
        $request->session()->flash('success', 'Register Berhasil');

        return redirect ('/user/login');

      
    }


    public function viewLogin()
    {
       return view('users.login');
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'     => 'required',
            'password'  => 'required'
        ]);


        if(Auth::attempt($credentials)) {

            $request->session()->regenerate();
            return redirect('/');
        }

        return back()->withErrors([' email' => 'Password atau email salah']);
    }

    public function logout()
    {
      Auth::logout();
      return redirect('/user/login')->with('success', 'Berhasil logout'); 
    }

    public function profile()
    {
        return view('users.profile');
    }
}
