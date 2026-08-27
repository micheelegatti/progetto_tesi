<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogInvio extends Model
{
    use HasFactory;

    protected $table = 'log_invii';

    protected $fillable = [
        'invio_id',
        'email_destinatario',
        'esito_consegna',
        'is_aperto',
        'is_cliccato',
        'is_disiscritto',
        'is_spam',
        'consegnato_il',
        'aperto_il',
        'cliccato_il',
        'disiscritto_il',
    ];

    public function invio()
    {
        return $this->belongsTo(Invio::class, 'invio_id');
    }
}