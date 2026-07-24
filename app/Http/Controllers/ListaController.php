<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ListaController extends Controller
{
    //mi torna la view delle liste
    public function index(){
        return view(liste);
    }
}
