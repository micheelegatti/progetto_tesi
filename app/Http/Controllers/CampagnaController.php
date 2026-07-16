<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CampagnaController extends Controller
{
    public function index()
    {
        //Qui dentro prenderò i dati
        return view('campagna');
    }
}
