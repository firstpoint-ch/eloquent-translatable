---
title: Laravel Eloquent Translatable
---

## Make your Eloquent Models translatable.

This page offers an easy way to add localization to your Eloquent Models.

## Installation

You can install this package via composer by running:

```bash
composer require firstpoint-ch/eloquent-translatable
```

## Basic example

Here's a quick look of what this package can do.

```php
app()->setLocale('en');

// Set translation in the current locale
$product = Product::create(['name' => 'Product name']);

// Get translation in the current locale
echo $product->name; // Product name

// Get array in the current locale
dd($product->toArray()); // ['name' => 'Product name']

// Update the current locale
$product->update(['name' => 'New name']);

// Update a specific locale
$product->update(['name->fr' => 'Nom du produit']);

// Force a locale
echo $product->in('fr')->name; // Nom du produit

// Get raw value
dd($product->raw('name')); // ['en' => 'Product name', 'fr' => 'Nom du produit']
dd($product->in('*')->toArray()); // ['name' => ['en' => 'Product name', 'fr' => 'Nom du produit']]
```
