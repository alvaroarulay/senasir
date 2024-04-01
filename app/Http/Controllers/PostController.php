<?php

namespace App\Http\Controllers;

use App\Events\PostEvent;
use App\Notifications\PostNotification;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request){
        $mensajes = Post::where('user_id','=',\Auth::user()->id)->paginate(5);
        $postNotifications = Auth::user()->unreadNotifications();
        return [
            'pagination' => [
                'total'        => $mensajes->total(),
                'current_page' => $mensajes->currentPage(),
                'per_page'     => $mensajes->perPage(),
                'last_page'    => $mensajes->lastPage(),
                'from'         => $mensajes->firstItem(),
                'to'           => $mensajes->lastItem(),
            ],
            'mensajes' => $mensajes,
            'noleidas' => $postNotifications
        ];
    }
    public function notificaction()
    {
        $postNotifications = auth()->user()->unreadNotifications;
        return view('post.notifications', compact('postNotifications'));
    }

    public function store(Request $request)
    {
        try {
            $post = new Post();
            $post->title = $request->title;
            $post->description = $request->description;
            $post->user_id = \Auth::user()->id;
            $post->save();

            event(new PostEvent($post));
        } 
        catch (Exception $e) {
            return response()->json(['message' => 'Excepción capturada: '+  $e->getMessage()]);
        }
        return response()->json(['message' => 'Mensaje enviado satisfactoriamente!']);
        
    }

    public function markNotification(Request $request)
    {
        auth()->user()->unreadNotifications
                ->when($request->input('id'), function($query) use ($request){
                    return $query->where('id', $request->input('id'));
                })->markAsRead();
        return response()->noContent();
    }
}