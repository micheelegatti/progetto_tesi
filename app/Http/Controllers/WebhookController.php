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
        // 1. Log di debug per vedere esattamente cosa arriva da Brevo
        Log::info('Webhook Marketing Brevo ricevuto:', $request->all());

        $event = $request->input('event');
        $email = $request->input('email');
        // Usiamo date_event come standard per le campagne marketing
        $date = $request->input('date_event') ?? $request->input('date') ?? now();

        if (!$email) {
            return response()->json(['status' => 'ignored', 'message' => 'Email non presente nel payload'], 200);
        }

        // Cerchiamo il log più recente associato a quell'indirizzo email
        $log = LogInvio::where('email_destinatario', $email)->latest()->first();

        if (!$log) {
            return response()->json(['status' => 'ignored', 'message' => 'Log non trovato per questa email'], 200);
        }

        // Casistiche dei webhook Marketing di Brevo
        switch ($event) {
            case 'delivered':
                $log->update([
                    'esito_consegna' => 'consegnato',
                    'consegnato_il' => $date
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

            case 'unsubscribe':
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