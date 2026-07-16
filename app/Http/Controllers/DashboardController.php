<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;

class DashboardController extends Controller
{
    //Chiamato al login per andare su dashboard
    public function index(){
        //Recupero le selezioni del menu
        $menuItems = MenuItem::get();
        return view('dashboard', compact('menuItems'));
    }
}
