@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Passer une commande</h1>
    <form action="{{ route('commande.store') }}" method="POST">
        @csrf
        <div>
            <label for="company_name">Nom de l'entreprise :</label>
            <input type="text" id="company_name" name="company_name" required>
        </div>
        <div>
            <label for="contact_name">Nom du contact :</label>
            <input type="text" id="contact_name" name="contact_name" required>
        </div>
        <div>
            <label for="email">Adresse e-mail :</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="phone">Téléphone :</label>
            <input type="text" id="phone" name="phone" required>
        </div>
        <div>
            <label for="address">Adresse :</label>
            <input type="text" id="address" name="address" required>
        </div>
        <div>
            <label for="product">Produit :</label>
            <select id="product" name="product" required>
                <option value="">Sélectionnez un produit</option>
                <option value="gaz">Gaz</option>
                <option value="accessoires">Accessoires</option>
            </select>
        </div>
        <div>
            <label for="quantity">Quantité :</label>
            <input type="number" id="quantity" name="quantity" min="1" required>
        </div>
        <div>
            <label for="message">Message :</label>
            <textarea id="message" name="message"></textarea>
        </div>
        <button type="submit">Envoyer la commande</button>
    </form>
</div>
@endsection