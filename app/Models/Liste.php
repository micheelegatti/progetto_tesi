<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Liste extends Model
{
    use HasFactory;

    protected $table = 'listes';

    protected $fillable = [
        'nome',
        'descrizione',
    ];

    public function destinatari(): BelongsToMany
    {
        return $this->belongsToMany(
            Destinatario::class, 
            'destinatario_listas', 
            'lista_id', 
            'destinatario_id'
            );
    }
}