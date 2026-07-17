<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;

class TemplateController extends Controller
{
    public function index(){

        $templates = Template::all();
        return view('template',compact('templates'));
    }

    public function nuovoTemplate(){
        return view('builderTemplate');
    }
}
