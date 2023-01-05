<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        return redirect()->route('tournaments.index');
    }

    public function procedure()
    {
        return view('procedure');
    }
}
