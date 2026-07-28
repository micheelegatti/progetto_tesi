<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;
use App\Models\Campagna;
use App\Enum\StatoCampagna;

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
            'stato' => StatoCampagna::Bozza->value,
            'content' => $template->content, //Salvo la copia del content del template
        ]);

        //Reindirizzamento al builder della campagna - passa dal metodo sotto nuovaCampagna
        return redirect(url('dashboard/campagna/' . $campagna->id));
    }


    //Metodo per aprire il builder della nuova campagna
    public function getCampagna($id){
        //recupero il template selezionato
        $campagna = Campagna::findOrFail($id);
        return view('builderCampagna', compact('campagna'));
    }

    //Metodo per aggiornare i dati di una campagna esistente 
    public function update(Request $request, $id)
    {
        logger('Qui sei arrivato');
        logger('CAMPAGNA ID NEL CONTROLLER: ' . $id);
        // Trova la campagna o restituisce un errore 404 se non esiste
        $campagna = Campagna::findOrFail($id);

        if (!$campagna) {
            return response()->json([
                'error' => "La campagna con ID {$id} non esiste nel database!"
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'blocks' => 'required|array',
        ]);

        $campagna->update([
            'name' => $validated['name'],
            'content' => $validated['blocks'],
        ]);

        return response()->json([
            'message' => 'Campagna aggiornata con successo!',
            'template' => $campagna
        ]);
    }

    //metodo per eliminare una campagna
    public function delete($id)
    {
        $campagna = Campagna::findOrFail($id);
        $campagna->delete();

        return redirect(url('dashboard/campagna'));
    }
}
