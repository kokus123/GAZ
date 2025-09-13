<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signalement extends Model
{
    use HasFactory;

    protected $fillable = [
        'commande_id',
        'client_id',
        'type',
        'service',
        'description',
        'adresse_incident',
        'latitude',
        'longitude',
        'statut',
        'numero_signalement',
        'reponse_service',
        'date_traitement',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'date_traitement' => 'datetime',
    ];

    /**
     * Relations
     */
    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Scopes
     */
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    public function scopeTraites($query)
    {
        return $query->where('statut', 'traite');
    }

    public function scopeResolus($query)
    {
        return $query->where('statut', 'resolu');
    }

    public function scopePolice($query)
    {
        return $query->where('service', 'police');
    }

    public function scopePompiers($query)
    {
        return $query->where('service', 'pompiers');
    }

    public function scopeNonLivraison($query)
    {
        return $query->where('type', 'non_livraison');
    }

    public function scopeIncendie($query)
    {
        return $query->where('type', 'incendie');
    }

    /**
     * Helpers
     */
    public function generateNumeroSignalement(): string
    {
        return 'SIG-'.date('Ymd').'-'.str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }

    public function isEnAttente(): bool
    {
        return $this->statut === 'en_attente';
    }

    public function isTraite(): bool
    {
        return $this->statut === 'traite';
    }

    public function isResolu(): bool
    {
        return $this->statut === 'resolu';
    }

    public function traiter(): void
    {
        $this->update([
            'statut' => 'traite',
            'date_traitement' => now(),
        ]);
    }

    public function resoudre(): void
    {
        $this->update(['statut' => 'resolu']);
    }
}
