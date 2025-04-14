<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{



    //Register User  
    
public function register(Request $request){


    //Validate

$fields = $request->validate([
    'username' => ['required','max:255'],
    'email'=>['required','max:255','email','unique:users'],
    'password'=>['required','min:8','confirmed'],
]);




    //Register

   $user = User::create($fields);
    // dd('Ok');

    //Login
Auth::login($user);

    //Redirect

return  redirect() ->route('home');

}



//Login User 

public function login(Request $request){

// validate login
    $fields = $request->validate([
   
        'email'=>['required','max:255','email'],
        'password'=>['required'],
    ]);

    // dd($request);

    // Try to login user
    if(Auth::attempt($fields, $request->remember)){
        return redirect()->intended('dashboard');
    } else{
        return back()->withErrors([
            'failed' => 'The provided credentials do not match to our records.'
        ]);
    }
}


//Logout User

public function logout(Request $request){

    //logout the user 
Auth::logout();
 
 //Invalidate the user session
$request->session()->invalidate();

//Renegerate CSRF token
$request->session()->regenerateToken();


 //Redirect to home

 return redirect('/');

}

}
