<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogInvio;
use App\Models\Destinatario;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    // GESTIONE DEI WEBHOOK PER LE CAMPAGNE MARKETING DI BREVO
    public function handleBrevo(Request $request)
    {
        //Log di debug per vedere esattamente cosa arriva da Brevo
        Log::info('Webhook Marketing Brevo ricevuto:', $request->all());

        $event = $request->input('event');
        $email = $request->input('email');
        // Usiamo date_event come standard per le campagne marketing
        $date = $request->input('date_event') ?? $request->input('date') ?? now();

        //Recupero l'X-Mailin-custom dove ho salvato l'istanza del log del db
        $logId = $request->input('X-Mailin-custom');

        $log = null;

        //Se l'X-mailin esiste
        if ($logId) {
            $log = LogInvio::find($logId);
        }

        // Fallback di sicurezza: se per qualche motivo l'ID non c'è, proviamo con l'email
        if (!$log && $email) {
            $log = LogInvio::where('email_destinatario', $email)->latest()->first();
        }

        //Non c'è nessun dato
        if (!$log) {
            return response()->json(['status' => 'ignored', 'message' => 'Log non trovato per questo ID o email'], 200);
        }

        // Casistiche dei webhook Marketing di Brevo
        switch ($event) {
            case 'request':
                $log->update([
                    'esito_consegna' => 'Inviato',
                ]);
                break;

            case 'delivered':
                $log->update([
                    'esito_consegna' => 'Consegnato',
                    'consegnato_il' => $date
                ]);
                break;

            case 'error':
                $log->update([
                    'esito_consegna' => 'Invio Bloccato',
                ]);
                break;

            case 'opened':
                $log->update([
                    'is_aperto' => true,
                    'aperto_il' => $date
                ]);
                break;

            case 'click':
                $log->update([
                    'is_cliccato' => true,
                    'cliccato_il' => $date
                ]);
                break;

            case 'hard_bounce':
            case 'soft_bounce':
                $log->update([
                    'esito_consegna' => 'rimbalzato'
                ]);
                break;

            case 'unsubscribed':
                $log->update([
                    'is_disiscritto' => true,
                    'disiscritto_il' => $date
                ]);
                // Aggiorna lo stato del contatto nella tabella destinatari
                Destinatario::where('email', $email)->update(['is_disiscritto' => true]);
                break;

            case 'spam':
                $log->update([
                    'is_spam' => true
                ]);
                break;
        }

        return response()->json(['status' => 'success'], 200);
    }
}