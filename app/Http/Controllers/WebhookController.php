<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogInvio;

class WebhookController extends Controller
{
    //GESTIONE DEI WEBHOOK PER BREVO
    public function handleBrevo(Request $request)
    {
        $event = $request->input('event');
        $email = $request->input('email');
        $date = $request->input('date') ?? now();
        
        // Recuperiamo l'ID del log passato tramite l'header personalizzato di Brevo
        $logId = $request->input('X-Mailin-custom');

        // Cerchiamo il log in modo univoco tramite ID (fallback sull'email se manca)
        $log = LogInvio::find($logId) ?? LogInvio::where('email_destinatario', $email)->latest()->first();

        if (!$log) {
            return response()->json(['status' => 'ignored', 'message' => 'Log non trovato'], 200);
        }

        //Casisttiche dei webhook Brevo
        switch ($event) {
            case 'sent':
                // Se era in attesa, lo consideriamo comunque tracciato
                break;

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

            case 'hardBounce':
            case 'softBounce':
                $log->update([
                    'esito_consegna' => 'rimbalzato'
                ]);
                break;

            case 'blocked':
                $log->update([
                    'esito_consegna' => 'bloccato'
                ]);
                break;

            case 'unsubscribed':
                $log->update([
                    'is_disiscritto' => true,
                    'disiscritto_il' => $date
                ]);
                // Imposto lo stato del contatto a disiscritto
                Destinatario::where('email', $email)->update(['is_disiscritto' => true]);
                break;

            case 'complaint':
            case 'spam':
                $log->update([
                    'is_spam' => true
                ]);
                break;
        }

        return response()->json(['status' => 'success'], 200);
    }
}