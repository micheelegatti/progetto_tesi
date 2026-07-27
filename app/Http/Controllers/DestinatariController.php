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
}
