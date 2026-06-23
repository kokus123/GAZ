<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CatalogueController extends Controller
{
    /**
     * Le vendeur gère son propre catalogue de bouteilles (avec photos).
     */
    public function index()
    {
        $stocks = Stock::where('vendeur_id', Auth::id())->latest()->get();

        return view('vendeur.catalogue', compact('stocks'));
    }

    public function create()
    {
        return view('vendeur.catalogue-creer');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_gaz' => 'required|string|max:255',
            'unite' => 'required|string|max:50',
            'quantite_disponible' => 'required|integer|min:0',
            'quantite_minimum' => 'nullable|integer|min:0',
            'prix_unitaire' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $cheminPhoto = null;

        if ($request->hasFile('photo')) {
            $cheminPhoto = $request->file('photo')->store('bouteilles', 'public');
        }

        Stock::create([
            'vendeur_id' => Auth::id(),
            'type_gaz' => $request->type_gaz,
            'unite' => $request->unite,
            'quantite_disponible' => $request->quantite_disponible,
            'quantite_minimum' => $request->quantite_minimum ?? 10,
            'prix_unitaire' => $request->prix_unitaire,
            'description' => $request->description,
            'photo' => $cheminPhoto,
            'disponible' => true,
        ]);

        return redirect()->route('vendeur.catalogue.index')
            ->with('success', 'Produit ajouté à votre catalogue avec succès !');
    }

    public function edit(Stock $stock)
    {
        $this->autoriserProprietaire($stock);

        return view('vendeur.catalogue-editer', compact('stock'));
    }

    public function update(Request $request, Stock $stock)
    {
        $this->autoriserProprietaire($stock);

        $request->validate([
            'type_gaz' => 'required|string|max:255',
            'unite' => 'required|string|max:50',
            'quantite_disponible' => 'required|integer|min:0',
            'quantite_minimum' => 'nullable|integer|min:0',
            'prix_unitaire' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'disponible' => 'nullable|boolean',
        ]);

        $donnees = $request->only([
            'type_gaz', 'unite', 'quantite_disponible', 'quantite_minimum',
            'prix_unitaire', 'description',
        ]);
        $donnees['disponible'] = $request->boolean('disponible');

        if ($request->hasFile('photo')) {
            if ($stock->photo) {
                Storage::disk('public')->delete($stock->photo);
            }
            $donnees['photo'] = $request->file('photo')->store('bouteilles', 'public');
        }

        $stock->update($donnees);

        return redirect()->route('vendeur.catalogue.index')
            ->with('success', 'Produit mis à jour avec succès !');
    }

    public function destroy(Stock $stock)
    {
        $this->autoriserProprietaire($stock);

        if ($stock->photo) {
            Storage::disk('public')->delete($stock->photo);
        }

        $stock->delete();

        return redirect()->route('vendeur.catalogue.index')
            ->with('success', 'Produit supprimé du catalogue.');
    }

    private function autoriserProprietaire(Stock $stock): void
    {
        if ($stock->vendeur_id !== Auth::id()) {
            abort(403, 'Accès refusé');
        }
    }
}
