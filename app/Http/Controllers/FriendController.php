<?php

namespace App\Http\Controllers;



use App\Models\User;
use Illuminate\Support\Facades\DB;

class FriendController extends Controller
{
    public function store($id)
    {
        $user = User::find($id);
        if (!auth()->user()->friends()->where('friend_id', $user->id)->exists()) {
            // Если не являются, то добавляем друга
            auth()->user()->friends()->attach($user);
            return redirect()->route('chats.index');
        } else {
            return redirect()->route('chats.index');
        }

    }
    public function destroy($id)
    {
        $user = User::find($id);

        auth()->user()->friends()->detach($user);


        return redirect()->route('chats.index');
    }
}

