<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImageModel; // Il tuo modello per memorizzare il path nel DB

class ImageController extends Controller
{
    public function store(Request $request)
    {
        // Validazione immagine
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp',
        ]);

        if ($request->hasFile('image')) {
            //Salva il file nella cartella 'uploads' del bucket R2
            $path = $request->file('image')->store('uploads', 'r2');

            // Salvo il percorso nel database
            ImageModel::create([
                'path' => $path,
                // 'user_id' => auth()->id(), se associato all'utente
            ]);

            return redirect()->back()->with('success', 'Immagine caricata con successo su Cloudflare R2!');
        }

        return redirect()->back()->with('error', 'Errore durante il caricamento.');
    }
}