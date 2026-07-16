<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index(){

        //Qui dentro passerò i dati che mi servono
        return view('template');
    }
}
