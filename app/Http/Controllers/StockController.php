<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    /**
     * Afficher la liste des stocks
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            $stocks = Stock::with('vendeur')->paginate(15);
        } else {
            $stocks = Stock::where('vendeur_id', $user->id)->paginate(15);
        }

        return view('stocks.index', compact('stocks'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('stocks.create');
    }

    /**
     * Créer un nouveau stock
     */
    public function store(Request $request)
    {
        $request->validate([
            'type_gaz' => 'required|string|max:255',
            'quantite_disponible' => 'required|integer|min:0',
            'quantite_minimum' => 'required|integer|min:0',
            'prix_unitaire' => 'required|numeric|min:0',
            'unite' => 'required|string|max:50',
            'description' => 'nullable|string|max:1000'
        ]);

        Stock::create([
            'vendeur_id' => Auth::id(),
            'type_gaz' => $request->type_gaz,
            'quantite_disponible' => $request->quantite_disponible,
            'quantite_minimum' => $request->quantite_minimum,
            'prix_unitaire' => $request->prix_unitaire,
            'unite' => $request->unite,
            'description' => $request->description,
            'disponible' => true
        ]);

        return redirect()->route('stocks.index')
            ->with('success', 'Stock créé avec succès !');
    }

    /**
     * Afficher un stock spécifique
     */
    public function show(Stock $stock)
    {
        $this->authorize('view', $stock);
        $stock->load('vendeur');
        return view('stocks.show', compact('stock'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Stock $stock)
    {
        $this->authorize('update', $stock);
        return view('stocks.edit', compact('stock'));
    }

    /**
     * Mettre à jour un stock
     */
    public function update(Request $request, Stock $stock)
    {
        $this->authorize('update', $stock);
        
        $request->validate([
            'type_gaz' => 'required|string|max:255',
            'quantite_disponible' => 'required|integer|min:0',
            'quantite_minimum' => 'required|integer|min:0',
            'prix_unitaire' => 'required|numeric|min:0',
            'unite' => 'required|string|max:50',
            'description' => 'nullable|string|max:1000',
            'disponible' => 'boolean'
        ]);

        $stock->update($request->all());

        return redirect()->route('stocks.index')
            ->with('success', 'Stock mis à jour avec succès !');
    }

    /**
     * Supprimer un stock
     */
    public function destroy(Stock $stock)
    {
        $this->authorize('delete', $stock);
        
        $stock->delete();

        return redirect()->route('stocks.index')
            ->with('success', 'Stock supprimé avec succès !');
    }
}