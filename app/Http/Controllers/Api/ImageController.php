<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    function uploadFile(Request $request)
    {
        $request->validate([
            'file' => ['required', 'image'],
            'model' => ['required'],
            'id' => ['required'],
            'storage' => ['required']
        ], [
            'file.required' => 'Archivo es requerido',
            'file.image' => 'Archivo debe ser una imagen',
            'model.required' => 'Modelo es requerido',
            'id.required' => 'Id  es requerido',
            'storage.required' => 'Ubicación es requerido',
        ]);

        $item = app("App\\Models\\$request->model")->find($request->id);

        $fileName = $item->id . '.' . $request->file('file')->getClientOriginalExtension();
        $path = $request->file('file')->storeAs("{$request->storage}", $fileName);
        $item->image = $path;
        $item->update();

        return response()->json([
            'message' => 'Archivo subido',
            'path' => $path,
            'item' => $item
        ]);
    }
}
