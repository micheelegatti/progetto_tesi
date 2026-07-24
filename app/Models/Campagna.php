<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campagna extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'template_id',
        'name',
        'stato',
        'content', 
    ];

    // Converte automaticamente il JSON in array PHP e viceversa
    protected $casts = [
        'content' => 'array',
        'stato'   => StatoCampagna::class
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }
}