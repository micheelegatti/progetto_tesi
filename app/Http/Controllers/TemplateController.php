<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;

class TemplateController extends Controller
{
    //Metodo per andare alla pagine dei template (con la lista)
    public function index(){
        $templates = Template::all();
        return view('template',compact('templates'));
    }

    //Metodo per aprire la pagina con il nuovo template
    public function nuovoTemplate(){
        return view('builderTemplate');
    }

    //salvataggio nuovo template a db
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'blocks' => 'required|array',
        ]);

        $template = Template::create([
            'user_id' => auth()->id(), // Associa il template all'utente loggato
            'name' => $validated['name'],
            'content' => $validated['blocks'], // Laravel converte l'array in JSON automaticamente
        ]);

        return response()->json([
            'message' => 'Template salvato con successo!',
            'template' => $template
        ], 201);
    }

    //Metodo per aggiornare un template esistente 
    public function update(Request $request, $id)
    {

        logger('TEMPLATE ID NEL CONTROLLER: ' . $id);

        // Trova il template o restituisce un errore 404 se non esiste
        $template = Template::findOrFail($id);

        if (!$template) {
            return response()->json([
                'error' => "Il template con ID {$id} non esiste nel database!"
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'blocks' => 'required|array',
        ]);

        $template->update([
            'name' => $validated['name'],
            'content' => $validated['blocks'],
        ]);

        return response()->json([
            'message' => 'Template aggiornato con successo!',
            'template' => $template
        ]);
    }

    //Apre in modifica un template esistente
    public function edit($id)
    {
        // Trova il template nel database (o mostra un errore 404 se non esiste)
        $template = Template::findOrFail($id);

        // Restituisce la vista Blade dell'editor passando il template
        return view('builderTemplate', compact('template'));
    }

    //Metodo per eliminare un template
    public function delete($id)
    {
        $template = Template::findOrFail($id);
        $template->delete();

        return redirect(url('dashboard/template'));
    }
}
