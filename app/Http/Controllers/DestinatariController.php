<?php

namespace App\Http\Controllers;

use App\Enum\StatoIscrizione;
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


    //Mi apre la pagina la view dell'import singolo
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

    //Metodo per eliminare un contatto
    public function delete($id)
    {
        $contatto= Destinatario::findOrFail($id);
        
        // Rimuove i collegamenti nella tabella pivot (senza cancellare i contatti)
        $contatto->liste()->detach();
        
        // Elimina la lista
        $contatto->delete();

        return redirect(url('dashboard/destinatari/contatti'));
    }


    // Mostra la vista di importazione con le liste esistenti
    public function showImport()
    {
        $liste = Liste::all();
        return view('importLista', compact('liste'));
    }

    // Esegue l'importazione del CSV
    public function storeImport(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|extensions:csv',
            'lista_id' => 'nullable|exists:liste,id',
            'nuova_lista_nome' => 'nullable|string|max:255',
        ]);

        //recupero file e apertura in modalità lettura
        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');
        
        // Legge la prima riga (intestazione) per saltarla
        $header = fgetcsv($handle, 1000, ',');
        
        $importedIds = [];

        // Legge riga per riga il CSV (Formato atteso: Nome, Cognome, Email)
        while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
            //Colonne < 3
            if (count($row) < 3) continue;

            $nome = trim($row[0]);
            $cognome = trim($row[1]);
            $email = trim($row[2]);

            //Controllo e validazione email e salto le righe con email non valide
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                continue;
            }

            // Crea o aggiorna il contatto in base all'email (evita duplicati)
            $destinatario = Destinatario::updateOrCreate(
                ['email' => $email],
                [
                    'nome' => $nome,
                    'cognome' => $cognome,
                    'stato' => StatoIscrizione::Iscritto, // O il tuo valore di default
                ]
            );

            $importedIds[] = $destinatario->id;
        }
        fclose($handle);    //chiusura

        // Gestione della lista (Gruppo)
        $listaId = $request->lista_id;

        // Se l'utente ha scritto il nome per una nuova lista, la creiamo
        if ($request->filled('nuova_lista_nome')) {
            $nuovaLista = Liste::create([
                'nome' => $request->nuova_lista_nome,
                'descrizione' => 'Creata tramite importazione CSV',
            ]);
            $listaId = $nuovaLista->id;
        }

        // Se è stata selezionata o creata una lista, associamo i contatti importati
        if ($listaId && !empty($importedIds)) {
            $lista = Liste::findOrFail($listaId);
            // syncWithoutDetaching aggiunge i nuovi contatti senza rimuovere quelli eventualmente già presenti
            $lista->destinatari()->syncWithoutDetaching($importedIds);
        }

        return redirect('dashboard/destinatari/contatti')->with('success', 'Contatti importati con successo!');
    }
}
