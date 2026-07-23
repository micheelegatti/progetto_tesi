<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;
use App\Models\Campagna;

class CampagnaController extends Controller
{
    //Mi apre la pagina delle campagna con la lista
    public function index()
    {
        $campagne = Campagna::all();
        return view('campagna', compact('campagne'));
    }

    //Metodo per aprire il form per la nuova campagna
    public function infoCampagna(){
        //Recupero i template da db
        $templates = Template::all();
        return view('infoCampagna', compact('templates'));
    }

    public function storeInfo(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'template_id' => 'required|exists:templates,id',
        ]);

        // Recupero il template recuperandolo dal forma
        $template = Template::findOrFail($validated['template_id']);

        // Creo l'istanza della campagna come bozza
        $campagna = Campagna::create([
            'user_id' => auth()->id(),      // Associa il template all'utente loggato
            'name' => $validated['name'],
            'template_id' => $template->id,
            'stato' => 'bozza',
            'content' => $template->content, //Salvo la copia del content del template
        ]);

        //Reindirizzamento al builder della campagna - passa dal metodo sotto nuovaCampagna
        return redirect(url('dashboard/campagna/' . $campagna->id . '/crea'));
    }


    //Metodo per aprire il builder della nuova campagna
    public function nuovaCampagna($id){
        //recupero il template selezionato
        $campagna = Campagna::findOrFail($id);
        return view('builderCampagna', compact('campagna'));
    }
}
