<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'vendeur_id',
        'numero_commande',
        'nom_client',
        'telephone',
        'email',
        'quantite',
        'prix_unitaire',
        'prix_total',
        'adresse_livraison',
        'latitude',
        'longitude',
        'statut',
        'notes',
        'date_livraison_prevue',
        'date_livraison_effective',
    ];

    protected $casts = [
        'date_livraison_prevue' => 'datetime',
        'date_livraison_effective' => 'datetime',
        'prix_unitaire' => 'decimal:2',
        'prix_total' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    /**
     * Relations
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function vendeur()
    {
        return $this->belongsTo(User::class, 'vendeur_id');
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    public function livraisons()
    {
        return $this->hasMany(Livraison::class);
    }

    public function reçus()
    {
        return $this->hasMany(Reçu::class);
    }

    public function signalements()
    {
        return $this->hasMany(Signalement::class);
    }

    /**
     * Scopes
     */
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    public function scopeConfirmees($query)
    {
        return $query->where('statut', 'confirmee');
    }

    public function scopeEnCours($query)
    {
        return $query->where('statut', 'en_cours');
    }

    public function scopeLivrees($query)
    {
        return $query->where('statut', 'livree');
    }

    public function scopeAnnulees($query)
    {
        return $query->where('statut', 'annulee');
    }

    /**
     * Helpers
     */
    public function generateNumeroCommande(): string
    {
        return 'CMD-'.date('Ymd').'-'.str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->statut, ['en_attente', 'confirmee']);
    }

    public function isPaid(): bool
    {
        return $this->paiements()->where('statut', 'valide')->exists();
    }
}
