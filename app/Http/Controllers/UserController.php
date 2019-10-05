<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index(User $user)
    {
        return view('users/index',[
            'user_id' => $user->id,
        ]);
    }

    public function showEditForm()
    {
        return view('users/edit');
    }

    public function edit()
    {

    }
}
