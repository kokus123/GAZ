<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reçu extends Model
{
    use HasFactory;

    protected $fillable = [
        'commande_id',
        'paiement_id',
        'numero_reçu',
        'chemin_fichier',
        'date_generation',
        'telecharge',
        'date_telechargement',
    ];

    protected $casts = [
        'date_generation' => 'datetime',
        'date_telechargement' => 'datetime',
        'telecharge' => 'boolean',
    ];

    /**
     * Relations
     */
    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function paiement()
    {
        return $this->belongsTo(Paiement::class);
    }

    /**
     * Helpers
     */
    public function generateNumeroReçu(): string
    {
        return 'REC-' . date('Ymd') . '-' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }

    public function marquerTelecharge(): void
    {
        $this->update([
            'telecharge' => true,
            'date_telechargement' => now(),
        ]);
    }

    public function getCheminCompletAttribute(): string
    {
        return storage_path('app/' . $this->chemin_fichier);
    }

    public function existe(): bool
    {
        return file_exists($this->chemin_complet);
    }
}
