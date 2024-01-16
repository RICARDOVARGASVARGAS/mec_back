<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    // Image upload
    function uploadFile(Request $request)
    {
        $request->validate([
            'file' => ['required', 'image'],
            'model' => ['required'],
            'id' => ['required'],
            'storage' => ['required']
        ], [], [
            'file' => 'Archivo',
            'model' => 'Modelo',
            'id' => 'Id',
            'storage' => 'Ubicación',
        ]);

        $item = app("App\\Models\\$request->model")->find($request->id);

        // Eliminar la imagen
        if ($item->image) {
            Storage::delete($item->image);
            $item->image = null;
            $item->update();
        }

        // Guardar la imagen
        $fileName = Str::uuid() . '.' . $request->file('file')->getClientOriginalExtension();
        $path = $request->file('file')->storeAs("{$request->storage}", $fileName);
        $item->image = $path;
        $item->update();

        return response()->json([
            'message' => 'Archivo subido',
            'path' => $path,
            'item' => $item
        ]);
    }

    // Image Polymorphic
    function uploadImageMany(Request $request)
    {
        $request->validate([
            'file' => ['required', 'image'],
            'model' => ['required'],
            'id' => ['required'],
            'storage' => ['required']
        ], [], [
            'file' => 'Archivo',
            'model' => 'Modelo',
            'id' => 'Id',
            'storage' => 'Ubicación',
        ]);

        // Guardar la imagen
        $fileName = Str::uuid() . '.' . $request->file('file')->getClientOriginalExtension();
        $path = $request->file('file')->storeAs("{$request->storage}", $fileName);
        $image = Image::create([
            'path' => $path,
            'imageable_id' => $request->id,
            'imageable_type' => 'App\\Models\\' . $request->model,
        ]);

        return response()->json([
            'message' => 'Archivo subido',
            'path' => $path,
            'item' => $image
        ]);
    }

    function deleteImageMany(Request $request)
    {
        $request->validate([
            'id' => ['required'],
        ], [], [
            'id' => 'Id de la imagen',
        ]);

        $image = Image::find($request->id);

        Storage::delete($image->path);

        $image->delete();

        return response()->json([
            'message' => 'Imagen eliminada',
        ]);
    }
}
