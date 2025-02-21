<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function about(){
        return view ('user.about');
    }

    public function lists(){
        return view('user.lists');
    }

    public function booking(){
        return view('user.booking');
    }

    public function contact(){
        return view('user.contact');
    }
    public function home(){
        return view('user.index');
    }
}