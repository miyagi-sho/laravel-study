<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\EditUser;

class UserController extends Controller
{
    public function index(User $user)
    {
        return view('users/index', [
            'user_id' => $user->id,
        ]);
    }

    public function showEditForm(User $user)
    {
        return view('users/edit', [
            'user' => $user,
        ]);
    }

    public function edit(User $user, EditUser $request)
    {
        $user->name = $request->name;
        $user->save();

        return redirect()->route('users.index', [
            'id' => $user->id,
        ]);
    }
}
