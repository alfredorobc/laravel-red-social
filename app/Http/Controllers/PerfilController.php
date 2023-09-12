<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {

        $request->request->add(['username' => Str::slug($request->username)]);


        $this->validate($request,[
            'username' => [
                'required',
                Rule::unique('users','username')->ignore(auth()->user()),
                'min:3',
                'max:20',
                'not_in:twitter,editar-perfil'
                ]
        ]);

        if($request->imagen){
            $uploadsPath = public_path('profiles');
            if (!File::exists($uploadsPath)) {
                File::makeDirectory($uploadsPath, 0755, true);
            }
            $imagen = $request->file('imagen');
            $nombreImagen = Str::uuid() . "." . $imagen->extension();
            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000,1000);
            $imagenPath = $uploadsPath . DIRECTORY_SEPARATOR . $nombreImagen;
            $imagenServidor->save($imagenPath);
        }

        $usuario = User::find(auth()->user()->id);

        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
        $usuario->save();

        return redirect()->route('post.index',$usuario->username);
    }
}
