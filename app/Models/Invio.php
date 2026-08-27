<?php

namespace App\Models;

use App\Enum\TipoInvio;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
    public function campagna(): BelongsTo
    {
        return $this->belongsTo(Campagna::class);
    }

    /**
     * Un invio ha molti log individuali
    */
    public function logInvii(): HasMany
    {
        return $this->hasMany(LogInvio::class, 'invio_id');
    }

    /**
     * Relazione Many-to-Many: Un invio può essere associato a più liste
     */
    public function listes(): BelongsToMany
    {
        return $this->belongsToMany(Liste::class, 'invio_listes', 'invio_id', 'liste_id');
    }
}