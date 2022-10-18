<?php


namespace Modules\Core\Http\Controllers;


use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    public function index()
    {
        return view('core::index');
    }
}
