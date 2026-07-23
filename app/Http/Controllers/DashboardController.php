<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //Chiamato al login per andare su dashboard
    public function index(){
        
        return view('dashboard');
    }
}
