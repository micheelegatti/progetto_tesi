<?php

namespace App\Http\Controllers;

use App\Models\Destinatario;
use App\Models\Liste;
use Illuminate\Http\Request;

class DestinatariController extends Controller
{
    //Mi apre la pagina la view con i contatti
    public function index(Request $request)
{
    $query = Destinatario::query();

    // Filtro per email (cerca se l'email contiene il testo inserito)
    if ($request->filled('email')) {
        $query->where('email', 'like', '%' . $request->input('email') . '%');
    }

    // Filtro per stato
    if ($request->filled('stato')) {
        $query->where('stato', $request->input('stato'));
    }

    // Prendo i contatti filtrati
    $contatti = $query->get();

    return view('contatti', compact('contatti'));
}


    //Mi apre la pagina la view degli import
    public function indexImport()
    {
        return view('importa');
    }

    //Mi apre la pagina con il form dedicato all'import di un nuovo contatto
    public function create()
    {
        return view('importContatto');
    }

    //Import e creazione di un nuovo contatto
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'cognome' => 'required|string|max:255',
            'email' => 'required|email|unique:destinatarios,email',
            'stato' => 'required|string',
        ]);

        Destinatario::create($validated);

        return redirect(url('dashboard/destinatari/contatti'));
    }

    //Apertura pagina per modifica di un contatto
    public function edit($id)
    {
        $destinatario = Destinatario::findOrFail($id);

        return view('importContatto', compact('destinatario'));
    }

    //Modifica del contatto
    public function update(Request $request, $id)
    {
        $destinatario = Destinatario::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'cognome' => 'required|string|max:255',
            // Passiamo l'id alla regola unique per ignorare il record corrente in fase di modifica
            'email' => 'required|email|unique:destinatarios,email,' . $id,
            'stato' => 'required|string',
        ]);

        $destinatario->update($validated);

        return redirect(url('dashboard/destinatari/contatti'));
    }

    //Restituisce il form per aggiungere il contatto a delle liste
    public function listeContatto($id)
    {
        $contatto = Destinatario::findOrFail($id);
        $liste = Liste::all(); 
        
        // ID delle liste a cui questo contatto è già associato
        $listeSelezionate = $contatto->liste?->pluck('id')->toArray() ?? [];

        return view('listeContatto', compact('contatto', 'liste', 'listeSelezionate'));
    }

    //Aggiorna aggiungendo il contatto alle liste
    public function updateListeContatto(Request $request, $id)
    {
        $contatto = Destinatario::findOrFail($id);

        // Sincronizza le liste del contatto
        $contatto->liste()->sync($request->input('liste', []));

        return redirect(url('dashboard/destinatari/contatti'));
    }
}
