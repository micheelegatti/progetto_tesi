<?php

namespace App\Http\Controllers;

use App\Models\Invio;
use App\Models\Campagna;
use App\Models\Liste;
use App\Models\Destinatario;
use App\Enum\TipoInvio;
use Illuminate\Support\Facades\Mail;
use App\Mail\CampagnaMail;
use Illuminate\Http\Request;

class InvioController extends Controller
{
    /**
     * Mostra il form per la configurazione dell'invio di una campagna
     */
    public function index($id)
    {
        $campagna = Campagna::findOrFail($id);
        //Recupera tutte le liste destinatari
        $liste = Liste::all();

        return view('riepilogoInvio', compact('campagna', 'liste'));
    }

    //Metodo per salvare a database i metadati dell'invio, e inviare tramite il canale la campagna
    public function store(Request $request)
    {
        // Validazione dei campi in italiano corrispondenti al form
        $validated = $request->validate([
            'campagna_id'    => 'required|exists:campagnas,id',
            'oggetto'        => 'required|string|max:255',
            'sommario'       => 'required|string|max:100',
            'note'           => 'nullable|string',
            'tag'            => 'nullable|string',
            'email_mittente' => 'required|email|max:255',
            'email_risposta' => 'nullable|email|max:255',
            'liste_id'       => 'required|array|min:1',
            'liste_id.*'     => 'exists:listes,id',
        ]);

        // Salvataggio diretto sul DB con le colonne in italiano
        $invioCampagna = Invio::create([
            'campagna_id'    => $validated['campagna_id'],
            'tipo'           => TipoInvio::Ordinario->value,
            'oggetto'        => $validated['oggetto'],
            'sommario'       => $validated['sommario'] ?? null,
            'note'           => $validated['note'] ?? null,
            'tag'            => $validated['tag'] ?? null,
            'email_mittente' => $validated['email_mittente'],
            'email_risposta' => $validated['email_risposta'] ?? null,
        ]);

        // Sincronizzazione delle liste multiple nella tabella pivot
        $invioCampagna->listes()->sync($validated['liste_id']);

        // Recupero della campagna e dei destinatari unici dalle liste selezionate
        $campagna = Campagna::findOrFail($validated['campagna_id']);

        $destinatari = Destinatario::whereHas('liste', function ($query) use ($validated) {
            $query->whereIn('listes.id', $validated['liste_id']);
        })->get()->unique('id');

        // Invio effettivo delle email
        foreach ($destinatari as $destinatario) {
            Mail::to($destinatario->email)->send(new CampagnaMail($campagna, $invioCampagna));
        }

        return redirect(url('dashboard/campagna'));
    }
}