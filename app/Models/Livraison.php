<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livraison extends Model
{
    use HasFactory;

    protected $fillable = [
        'commande_id',
        'vendeur_id',
        'numero_livraison',
        'statut',
        'adresse_livraison',
        'latitude',
        'longitude',
        'date_livraison_prevue',
        'date_livraison_effective',
        'notes_livraison',
        'nom_livreur',
        'telephone_livreur',
    ];

    protected $casts = [
        'date_livraison_prevue' => 'datetime',
        'date_livraison_effective' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    /**
     * Relations
     */
    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function vendeur()
    {
        return $this->belongsTo(User::class, 'vendeur_id');
    }

    /**
     * Scopes
     */
    public function scopeProgrammees($query)
    {
        return $query->where('statut', 'programmee');
    }

    public function scopeEnCours($query)
    {
        return $query->where('statut', 'en_cours');
    }

    public function scopeLivrees($query)
    {
        return $query->where('statut', 'livree');
    }

    public function scopeEchecs($query)
    {
        return $query->where('statut', 'echec');
    }

    /**
     * Helpers
     */
    public function generateNumeroLivraison(): string
    {
        return 'LIV-'.date('Ymd').'-'.str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }

    public function isProgrammee(): bool
    {
        return $this->statut === 'programmee';
    }

    public function isEnCours(): bool
    {
        return $this->statut === 'en_cours';
    }

    public function isLivree(): bool
    {
        return $this->statut === 'livree';
    }

    public function isEchec(): bool
    {
        return $this->statut === 'echec';
    }

    public function demarrer(): void
    {
        $this->update(['statut' => 'en_cours']);
    }

    public function finaliser(): void
    {
        $this->update([
            'statut' => 'livree',
            'date_livraison_effective' => now(),
        ]);
    }

    public function marquerEchec(): void
    {
        $this->update(['statut' => 'echec']);
    }
}
