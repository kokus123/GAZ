<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'commande_id',
        'numero_transaction',
        'montant',
        'methode',
        'statut',
        'numero_telephone',
        'operateur',
        'details_transaction',
        'date_validation',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'date_validation' => 'datetime',
    ];

    /**
     * Relations
     */
    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function reçus()
    {
        return $this->hasMany(Reçu::class);
    }

    /**
     * Scopes
     */
    public function scopeValides($query)
    {
        return $query->where('statut', 'valide');
    }

    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    public function scopeEchecs($query)
    {
        return $query->where('statut', 'echec');
    }

    public function scopeMobileMoney($query)
    {
        return $query->where('methode', 'mobile_money');
    }

    public function scopeCarteBancaire($query)
    {
        return $query->where('methode', 'carte_bancaire');
    }

    /**
     * Helpers
     */
    public function generateNumeroTransaction(): string
    {
        return 'TXN-' . date('YmdHis') . '-' . strtoupper(substr(md5(uniqid()), 0, 8));
    }

    public function isValide(): bool
    {
        return $this->statut === 'valide';
    }

    public function isEnAttente(): bool
    {
        return $this->statut === 'en_attente';
    }

    public function isEchec(): bool
    {
        return $this->statut === 'echec';
    }

    public function valider(): void
    {
        $this->update([
            'statut' => 'valide',
            'date_validation' => now(),
        ]);
    }

    public function marquerEchec(): void
    {
        $this->update(['statut' => 'echec']);
    }
}
