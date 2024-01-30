<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    function getMessages($sale)
    {
        $messages = Message::with(['user'])->where('sale_id', $sale)->orderBy('id', 'asc')->get();

        return response()->json([
            'messages' => MessageResource::collection($messages),
        ]);
    }

    function sendMessage(Request $request)
    {
        $request->validate([
            'type' => 'required|in:text,image',
            'content' => 'required|' . ($request->input('type') == 'image' ? 'image|mimes:jpeg,png,jpg,gif,svg' : 'string'),
            'sale_id' => 'required|exists:sales,id',
            'user_id' => 'required|exists:users,id',
        ], [], [
            'type' => 'Tipo de Mensaje',
            'content' => 'Contenido del Mensaje',
            'sale_id' => 'ID de Venta',
            'user_id' => 'ID de Usuario',
        ]);

        if ($request->type == 'image') {
            $fileName = Str::uuid() . '.' . $request->file('content')->getClientOriginalExtension();
            $path = $request->file('content')->storeAs("messages", $fileName);
        }

        $message = Message::create([
            'type' => $request->type,
            'content' => $request->type == 'image' ? $path : $request->content,
            'sale_id' => $request->sale_id,
            'user_id' => $request->user_id,
        ]);

        return response()->json([
            'message' => MessageResource::make($message),
        ]);
    }

    function deleteMessage(Message $message)
    {

        if ($message->type == 'image') {
            Storage::delete($message->content);
        }

        $message->delete();

        return response()->json([
            'message' => 'Mensaje eliminado',
        ]);
    }
}
