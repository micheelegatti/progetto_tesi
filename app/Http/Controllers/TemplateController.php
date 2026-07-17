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

    public function store(){
        // Validazione dati inviati dal frontend
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'blocks' => 'required|array', // Ci assicuriamo che arrivi la struttura dei blocchi
        ]);

        // 2. Eloquent fa l'INSERT. Grazie al cast json nel Modello, 
        // l'array PHP viene ricodificato in stringa JSON ed inserito nel DB.
        $template = Template::create([
            'name' => $validated['name'],
            'blocks' => $validated['blocks'],
        ]);

        // 3. Rispondiamo a Vue con un feedback di successo senza ricaricare la pagina
        return response()->json([
            'success' => true,
            'message' => 'Template salvato con successo!',
            'id' => $template->id
        ], 201); // 201 è lo status HTTP corretto per una "Risorsa Creata"
    }

    public function update(){

    }
}
