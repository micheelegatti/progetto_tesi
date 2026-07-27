<?php

namespace App\Models;

use App\Enum\StatoIscrizione;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Destinatario extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cognome',
        'email',
        'stato',
    ];

    protected $casts = [
        'stato' => StatoIscrizione::class
    ];

    public function liste(): BelongsToMany
    {
        return $this->belongsToMany(
            Liste::class, 
            'destinatario_listas', 
            'destinatario_id', 
            'lista_id'
            );
    }
}
