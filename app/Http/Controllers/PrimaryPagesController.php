<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrimaryPagesController extends Controller
{
    public function index ()
    {
        return view('welcome');
    }
}
