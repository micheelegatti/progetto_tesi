<?php

namespace App\Http\Controllers;

use App\Enum\StatoIscrizione;
use App\Models\Liste;
use Illuminate\Http\Request;

class ListaController extends Controller
{
    //mi torna la view delle liste
    public function index()
    {
        // Recupera le liste dal database con il conteggio di iscritti e disiscritti
        $liste = Liste::withCount([
            'destinatari as iscritti_count' => function ($query) {
                $query->where('stato', StatoIscrizione::Iscritto);
            },
            'destinatari as disiscritti_count' => function ($query) {
                $query->where('stato', StatoIscrizione::Disiscritto);
            }
        ])->get();
        
        return view('liste', compact('liste'));
    }
}
