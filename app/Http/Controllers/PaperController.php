<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaperController extends Controller
{
    public function index()
    {
        return view('papers.index');
    }
}
