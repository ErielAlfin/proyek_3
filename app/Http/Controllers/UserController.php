<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\Barber;
use App\Models\Gallery;

class UserController extends Controller
{
    public function index()
    {
        $layanans = Layanan::all();
        $barbers = Barber::all();
        $galleries = Gallery::all();

        return view('user.home', compact('layanans', 'barbers', 'galleries'));
    }
}
