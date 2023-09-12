<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

    public function index() {
        return view('auth.register');
    }

    public function store(Request $request){

        //cambiamos el valor que llega del request con el de la validacion para
        //que se pueda validar
        $request->request->add(['username' => Str::slug($request->username)]);

        $this->validate($request,[
            'name' => 'required|min:1|max:30',
            'username' => 'required|unique:users|min:3|max:20',
            'email'=>'required|email|unique:users|email|max:60',
            'password'=>'required|confirmed|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'username'=> $request->username,
            'email'=>strtolower($request->email),
            'password'=> Hash::make($request->password)
        ]);

        //autenticar un usuario
        /* auth()->attempt([
            'email' => $request->email,
            'password'=>$request->password
        ]); */

        //Otra forma de autenticacion
        auth()->attempt($request->only('email','password'));

        return redirect()->route('post.index', auth()->user()->username);

    }
}
