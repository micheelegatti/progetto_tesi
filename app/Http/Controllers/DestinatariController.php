<?php

namespace App\Http\Controllers;

use App\Models\Destinatario;
use Illuminate\Http\Request;

class DestinatariController extends Controller
{
    //Mi apre la pagina la view con i contatti
    public function index()
    {
        $contatti = Destinatario::all();
        
        return view('contatti', compact('contatti'));
    }

    //Mi apre la pagina la view degli import
    public function indexImport()
    {
        return view('import');
    }
}
