<?php
namespace App\Http\Controllers;

use App\Models\Invio;
use App\Models\Campagna;
use App\Models\Liste;
use App\Models\Destinatario;
use App\Models\LogInvio; 
use App\Enum\TipoInvio;
use Illuminate\Support\Facades\Mail;
use App\Mail\BrevoMail; 
use Illuminate\Http\Request;

class InvioController extends Controller
{
    public function index($id)
    {
        $campagna = Campagna::findOrFail($id);
        $liste = Liste::all();

        return view('riepilogoInvio', compact('campagna', 'liste'));
    }

    public function store(Request $request)
    {
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

        //Salvataggio della sessione d'invio
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

        // Recupero della campagna
        $campagna = Campagna::findOrFail($validated['campagna_id']);

        // Recupero dei destinatari unici dalle liste selezionate
        $destinatari = Destinatario::whereHas('liste', function ($query) use ($validated) {
            $query->whereIn('listes.id', $validated['liste_id']);
        })->get()->unique('id');

        // Ciclo di invio
        foreach ($destinatari as $destinatario) {
            
            // Creiamo il log dell'invio e imposto come consegna (in attesa)
            $logInvio = LogInvio::create([
                'invio_id' => $invioCampagna->id,
                'email_destinatario' => $destinatario->email,
                'esito_consegna' => 'in_attesa',
            ]);

            // Passiamo campagna, invio e log al Mailable
            Mail::to($destinatario->email)->send(new BrevoMail($campagna, $invioCampagna, $logInvio));
        }
        
        return redirect(url('dashboard/campagna'))->with('success', 'Campagna avviata con successo!');
    }
}