<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ImagenController extends Controller
{
    public function store(Request $request)
    {
        // Validar si la carpeta 'uploads' existe, y si no, crearla
        $uploadsPath = public_path('uploads');
        if (!File::exists($uploadsPath)) {
            File::makeDirectory($uploadsPath, 0755, true);
        }
        $imagen = $request->file('file');
        $nombreImagen = Str::uuid() . "." . $imagen->extension();
        $imagenServidor = Image::make($imagen);
        $imagenServidor->fit(1000,1000);
        $imagenPath = $uploadsPath . DIRECTORY_SEPARATOR . $nombreImagen;
        $imagenServidor->save($imagenPath);

        return response()->json(['imagen'=>$nombreImagen]);
    }

}
