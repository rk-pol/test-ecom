<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\RestorerRequest;
use App\Mail\ResetPasswordMail;
use App\Services\AnimalService;
use App\Models\User;


class AuthController extends Controller
{
    //
    public function showLoginForm()
    {
         $animals_arr = AnimalService::dataForMainNavPanel(); 
 
         return view('auth.login', ['animals_arr' => $animals_arr]);
    }
    //
    public function showRegisterForm()
    {
        $animals_arr = AnimalService::dataForMainNavPanel(); 
 
         return view('auth.register', ['animals_arr' => $animals_arr]);
    }
    //
    public function showRestoreForm()
    {
        $animals_arr = AnimalService::dataForMainNavPanel(); 
 
         return view('auth.restore', ['animals_arr' => $animals_arr]);
    }

    public function registerProcess(RegisterRequest $request)
    {
        
        $validated = $request->validated();
        //
        $storeData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),   
                'remember_token' => Str::random(10)
        ];
        //
        $user = User::create($storeData);

        if(Auth::loginUsingId($user->id)){

            $request->session()->regenerate();

            return redirect('/');
        }
        
        return redirect('login'); 
    }
    //
    public function loginProcess(LoginRequest $request)
    {     
        $validated = $request->validated();

        if (auth('web')->attempt($validated)) {
            return redirect('/');
        }
        
        return redirect('login')->withErrors(['email' => 'Email does not exist']);
    }
     //
     public function restoreProcess(RestorerRequest $request)
     {     
        $validated = $request->validated();
 
        $user = User::where('email', $validated['email'])->first();
         
        $password = uniqid();
        $user->password = bcrypt($password);
        $user->save();

        Mail::to($user)->send(new ResetPasswordMail($password, $validated['email']));
         
        return redirect('/');
     }
    //
    public function logout()
    {
        auth('web')->logout();

        return redirect('/');
    }

}
