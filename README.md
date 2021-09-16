# Laravel Eloquent Translatable

Make your Eloquent Models translatable.

## Installation

You can install this package via composer by running:

```bash
composer require firstpoint-ch/eloquent-translatable
```

Then you can publish the config file:

```bash
php artisan vendor:publish --provider="FirstpointCh\\Translatable\\TranslatableServiceProvider"
```

## Configure models

Models can be translated in two different ways:

1. **Database:** It stores translations as JSON in the database
2. **Dictonary:** It stores keys and retrieve translations from the global ```/resources/lang/[locale].json``` or any specific file in ```/resources/lang/[locale]/[dictonary].php```.

First you should store any database translated field as a ```json``` column. This package provide a ```translatable``` macro so you can quickly see which fields are translatable. Fields using the dictonary mode could be set to ```string```.

```php
Schema::create('products', function ($table) {
    $table->id();
    $table->translatable('name'); // Outputs $table->json('name');
    $table->string('category'); // Will be used as a dictonary
    $table->decimal('price');
    $table->timestamps();
})
```

Then you should add the ```Translatable``` trait to the model and cast attributes using ```Localized```or ```Dictonary```

```php
use FirstpointCh\Translatable\Casts\Dictonary;
use FirstpointCh\Translatable\Casts\Localized;
use FirstpointCh\Translatable\Traits\Translatable;

class Product extends Model
{
    use Translatable;

    protected $casts = [
        // Database
        'name' => Localized::class,
        'description' => Localized::class,

        // Dictonary:
        //get value from /resources/lang/[locale].json
        'category' => Dictonary::class,

        // or get value from /resources/lang/[locale]/categories.php
        'category' => Dictonary::class.':categories',
    ];
}
```

## Basic example

Here's a quick look of what this package can do, check our [extended documentation](https://docs.firstpoint.ch/eloquent-translatable) for all the details.

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
