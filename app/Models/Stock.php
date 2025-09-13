<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendeur_id',
        'type_gaz',
        'quantite_disponible',
        'quantite_minimum',
        'prix_unitaire',
        'unite',
        'description',
        'disponible',
    ];

    protected $casts = [
        'prix_unitaire' => 'decimal:2',
        'disponible' => 'boolean',
    ];

    /**
     * Relations
     */
    public function vendeur()
    {
        return $this->belongsTo(User::class, 'vendeur_id');
    }

    /**
     * Scopes
     */
    public function scopeDisponibles($query)
    {
        return $query->where('disponible', true);
    }

    public function scopeEnRupture($query)
    {
        return $query->whereColumn('quantite_disponible', '<=', 'quantite_minimum');
    }

    public function scopeParType($query, $type)
    {
        return $query->where('type_gaz', $type);
    }

    /**
     * Helpers
     */
    public function isEnRupture(): bool
    {
        return $this->quantite_disponible <= $this->quantite_minimum;
    }

    public function isDisponible(): bool
    {
        return $this->disponible && $this->quantite_disponible > 0;
    }

    public function decrementerStock(int $quantite): bool
    {
        if ($this->quantite_disponible >= $quantite) {
            $this->decrement('quantite_disponible', $quantite);

            return true;
        }

        return false;
    }

    public function incrementerStock(int $quantite): void
    {
        $this->increment('quantite_disponible', $quantite);
    }
}
