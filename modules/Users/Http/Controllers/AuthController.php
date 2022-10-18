<?php


namespace Modules\Users\Http\Controllers;


use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function index()
    {
        return view('users::index');
    }

    public function getLogin()
    {
        return view('users::login');
    }
}
