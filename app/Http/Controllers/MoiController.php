<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MoiController extends Controller
{
    public function index()
    {
        return view('moi');
    }
}

