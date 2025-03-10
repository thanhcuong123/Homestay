<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;


class UserController extends Controller
{
    public function lists()
    {
        return view('user.lists');
    }

    public function home()
    {
        return view('user.index');
    }
}