<?php
namespace App\Http\Controllers;

use App\Models\Invio;
use App\Models\LogInvio;
use Illuminate\Http\Request;

class StatisticheController extends Controller
{
    
    //Apertura pagina storico invio Campagne
    public function index()
    {
        $invii = Invio::with('campagna')->withCount('logInvii')->latest()->get();

        // Calcoliamo la percentuale di consegna reale per ogni invio
        $invii->each(function ($invio) {
            $totali = $invio->log_invii_count;
            
            if ($totali > 0) {
                $consegnati = $invio->logInvii()->where('esito_consegna', 'consegnato')->count();
                $invio->tasso_consegna = round(($consegnati / $totali) * 100, 1);
            } else {
                $invio->tasso_consegna = 0;
            }
        });

        // ... resto delle KPI globali ...
        $totaleInviati = LogInvio::count();
        $totaleAperti = LogInvio::where('is_aperto', true)->count();
        $totaleCliccati = LogInvio::where('is_cliccato', true)->count();
        $totaleRimbalzati = LogInvio::where('esito_consegna', 'rimbalzato')->count();

        $openRateMedio  = $totaleInviati > 0 ? round(($totaleAperti / $totaleInviati) * 100, 1) . '%' : '0%';
        $clickRateMedio = $totaleInviati > 0 ? round(($totaleCliccati / $totaleInviati) * 100, 1) . '%' : '0%';
        $rimbalziTotali = $totaleInviati > 0 ? round(($totaleRimbalzati / $totaleInviati) * 100, 1) . '%' : '0%';

        return view('storicoInviiCampagne', compact(
            'invii',
            'totaleInviati',
            'openRateMedio',
            'clickRateMedio',
            'rimbalziTotali'
        ));
    }

    //Prende il dettaglio dell'invio e passa alla pagina corrrispondente
    public function statisticheInvio($id)
    {
        $invio = Invio::with('campagna', 'logInvii')->findOrFail($id);

        $totali = $invio->logInvii->count();
        $consegnati = $invio->logInvii->where('esito_consegna', 'Consegnato')->count();
        $aperti = $invio->logInvii->where('is_aperto', true)->count();
        $cliccati = $invio->logInvii->where('is_cliccato', true)->count();
        $rimbalzati = $invio->logInvii->where('esito_consegna', 'Rimbalzato')->count();
        
        // Nuove metriche di feedback negativo
        $disiscritti = $invio->logInvii->where('is_disiscritto', true)->count();
        $spam = $invio->logInvii->where('is_spam', true)->count();

        // Calcoli percentuali
        $deliveryRate = $totali > 0 ? round(($consegnati / $totali) * 100, 1) : 0;
        $openRate     = $totali > 0 ? round(($aperti / $totali) * 100, 1) : 0;
        $clickRate    = $totali > 0 ? round(($cliccati / $totali) * 100, 1) : 0;
        $bounceRate   = $totali > 0 ? round(($rimbalzati / $totali) * 100, 1) : 0;
        $unsubRate    = $totali > 0 ? round(($disiscritti / $totali) * 100, 1) : 0;
        $spamRate     = $totali > 0 ? round(($spam / $totali) * 100, 1) : 0;

        return view('dettaglioStatisticheInvio', compact(
            'invio',
            'totali',
            'consegnati',
            'aperti',
            'cliccati',
            'rimbalzati',
            'disiscritti',
            'spam',
            'deliveryRate',
            'openRate',
            'clickRate',
            'bounceRate',
            'unsubRate',
            'spamRate'
        ));
    }
}
