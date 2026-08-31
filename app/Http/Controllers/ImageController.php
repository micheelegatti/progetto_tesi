<?php
namespace App\Http\Controllers;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image; // <-- Usiamo il nome pulito
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function index()
    {
        $images = Image::latest()->get()->map(function ($img) {
            return [
                'id' => $img->id,
                'url' => Storage::disk('r2')->url($img->path),
            ];
        });

        return response()->json($images);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', 'r2');
            $url = Storage::disk('r2')->url($path);

            // Salvataggio pulito
            Image::create([
                'path' => $path,
            ]);

            return response()->json([
                'success' => true,
                'url' => $url,
                'path' => $path,
                'message' => 'Immagine caricata con successo!'
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Nessun file selezionato.'], 400);
    }
}