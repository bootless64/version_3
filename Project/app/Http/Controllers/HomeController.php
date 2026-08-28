<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $slides = Slider::orderBy('slide_number')->get();
        return view('home', compact('slides'));
    }
}
