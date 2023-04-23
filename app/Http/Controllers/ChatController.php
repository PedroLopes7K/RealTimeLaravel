<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\GreetingSent;
use App\Events\MessageSent;
use App\Events\MessagePrivate;
use App\Models\Chat;
use App\Models\User;
use Laravel\Ui\Presets\React;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showChat()
    {
        return view('chat.show');
    }

    public function chatPrivate()
    {
        return view('chat.private');
    }

    public function messageReceived(Request $request)
    {
        $rules = [
            'message' => 'required',
        ];

        $request->validate($rules);

        broadcast(new MessageSent($request->user(), $request->message));
        return response()->json('Message Send!');
    }

    public function messagePrivate(Request $request)
    {
        $rules = [
            'message' => 'required',
        ];

        $request->validate($rules);

        if ($request->user()->id == 1 || $request->user()->id == 7) {

            broadcast(new MessagePrivate($request->user(), $request->message));
            return response()->json('Message Send!');
        }
        return response()->json('Message Failed!');
    }

    public function greetReceived(Request $request, User $user)
    {
        broadcast(new GreetingSent($user, "{$request->user()->name} greeted you"));
        broadcast(new GreetingSent($request->user(), "You greeted {$user->name}"));

        return "Greeting {$user->name} from {$request->user()->name}";
    }
}
