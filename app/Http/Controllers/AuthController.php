<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OtpVerification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{


    public function ShowRegister(){
        return view('auth.register');
    }

    public function ShowLogin(){
        return view('auth.login');
    }





    public function Login(Request $request){
        $request->validate([
            'phone'=>'required|string',
            'password'=>'required|string',
        ]);


        $phone = $request->phone;
        // Remove any existing prefix and add +880
        $phone = preg_replace('/^(\+880|880)?/', '', $phone);
        $phone = '+880' . $phone;

        if(Auth::attempt(['phone'=>$phone,'password'=>$request->password])){
            $request->session()->regenerate();
            

            if(!auth()->user()->is_verified){
                Auth::logout();
                return back()->withErrors(['phone' => 'Please verify your phone number first. Check your SMS for OTP.']);
            }
            
            if(auth()->user()->role === 'admin'){
                return redirect()->route('admin.dashboard')->with('success', 'Login successful.');
            }
            return redirect()->route('home')->with('success', 'Login successful.');
        }

        return back()->withErrors(['error' => 'Invalid Phone or Password.']);
    }




    public function Logout(Request $request){
        Auth::Logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
        }
}
