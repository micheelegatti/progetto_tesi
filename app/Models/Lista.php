<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lista extends Model
{
    protected $fillable =[
        'nome',
        'descrizione',
    ]

    public function liste(): BelongsToMany
    {
        return $this->belongsToMany(Lista::class, 'destinatario_lista', 'destinatario_id', 'lista_id');
    }
}
