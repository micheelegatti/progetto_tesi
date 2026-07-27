<?php

namespace App\Http\Controllers;

use App\Enum\StatoIscrizione;
use App\Models\Liste;
use App\Models\Destinatario;
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

    //Apertura blade per nuova lista
    public function create()
    {
        $destinatari = Destinatario::all(); //Recupero tutti i contatti
        return view('formLista', compact('destinatari'));
    }

    //Creazione e salvataggio di una nuova lista
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descrizione' => 'nullable|string',
            'destinatari' => 'nullable|array',
            'destinatari.*' => 'exists:destinatarios,id',
        ]);

        // Crea la lista
        $lista = Liste::create([
            'nome' => $validated['nome'],
            'descrizione' => $validated['descrizione'] ?? null,
        ]);

        // Associa i contatti selezionati (se ce ne sono)
        $lista->destinatari()->sync($request->input('destinatari', []));

        return redirect(url('dashboard/destinatari/liste'));
    }

    //Apertura form per modifica di una lista esistente
    //Devo recuperare sia i contatti già aggiunti che quelli inseriti nel sistema
    public function edit($id)
    {
        $lista = Liste::findOrFail($id);       //tutti i contatti
        $destinatari = Destinatario::all();
        
        // Estrae gli ID dei contatti già associati a questa lista
        $contattiSelezionati = $lista->destinatari->pluck('id')->toArray();

        return view('formLista', compact('lista', 'destinatari', 'contattiSelezionati'));
    }

    //Aggiornamento e salvataggio della lista pre-esistente
    public function update(Request $request, $id)
    {
        $lista = Liste::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descrizione' => 'nullable|string',
            'destinatari' => 'nullable|array',
            'destinatari.*' => 'exists:destinatarios,id',
        ]);

        // Aggiorna i dati della lista
        $lista->update([
            'nome' => $validated['nome'],
            'descrizione' => $validated['descrizione'] ?? null,
        ]);

        // Sincronizza i contatti: aggiunge i nuovi e rimuove i deselezionati
        $lista->destinatari()->sync($request->input('destinatari', []));

        return redirect(url('dashboard/destinatari/liste'));
    }
}
