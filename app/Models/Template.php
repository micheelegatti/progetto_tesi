<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'content',
    ];

    // Converte automaticamente la colonna JSON del database in un array PHP (e viceversa)
    protected $casts = [
        'content' => 'array',
    ];

    //Associo un template al suo utente che lo ha fatto
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}