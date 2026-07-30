<?php

namespace App\Models;

use App\Enum\TipoInvio;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Invio extends Model
{
    use HasFactory;

    protected $table = 'invios';

    protected $fillable = [
        'campagna_id',
        'oggetto',
        'sommario',
        'note',
        'tags',
        'tipo',
        'email_mittente',
        'email_risposta',
        'data_invio',
    ];

    protected $casts = [
        'tipo' => TipoInvio::class,
        'data_invio' => 'datetime',
        'tags' => 'array', // Converte automaticamente l'array PHP in JSON sul DB e viceversa
    ];

    /**
     * L'invio appartiene a una Campagna
     */
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * Relazione Many-to-Many: Un invio può essere associato a più liste
     */
    public function listes(): BelongsToMany
    {
        return $this->belongsToMany(Liste::class, 'invio_listes', 'invio_id', 'liste_id');
    }
}