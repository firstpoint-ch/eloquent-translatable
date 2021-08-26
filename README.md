# Laravel Eloquent Translatable

Make your Eloquent Models translatable.

## Installation

```bash
composer install firstpoint-ch/laravel-translatable-model
```

Then you can publish the config file:

```bash
php artisan vendor:publish --provider="FirstpointCh\\Translatable\\TranslatableServiceProvider"
```

## Getting started

With this package, you can translate model on two different ways:

1. Database: It stores all translations in the same table column using json serialization
2. Dictonary: It store keys and retrieve translations from ```/resources/lang/[locale].json``` or any files in ```/resources/lang/[locale]/[dictonary].php```

### Configure the model

First you should store any database translated field as a ```text```, ```mediumText``` or ```longText```. You can use ```translatable``` macro so you can quickly see which fields are translatable. Fields using the dictonary method can be set to ```string```.

```php
Schema::create('products', function ($table) {
    $table->id();
    $table->translatable('name'); // Outputs $table->text('name');
    $table->longTranslatable('description'); // Outputs $table->longText('description');
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
        'name' => Localized::class,
        'description' => Localized::class,
        'category' => Dictonary::class, // Will get value from /resources/lang/[locale].json
    ];
}
```

You can specify a dictonary by appending the name as a parameter.

```php
class Product extends Model
{
    protected $casts = [
        'category' => Dictonary::class.':categories', // Will get value from /resources/lang/[locale]/categories.php
    ];
}
```

## Using the model

### Get translations

```php
// Output the name in the curent locale or fallback to the default locale
echo $product->name;

// Output the name in a specific locale or null
echo $product->name->in('fr');

// This is an alias for ->in('fr')
echo $product->name->fr;

// Or you can specify the locale on the model itself
echo $product->in('fr')->name;
echo $product->description; // Still in french
```

### Using arrays

```php
// As array
$product->toArray();

// Outputs
[
    'id' => 1,
    'name' => [
        'en' => 'Product name',
        'fr' => 'Nom du produit',
    ],
    // ...
]

// Use a specific locale
$product->in('en')->toArray();

// Outputs
[
    'id' => 1,
    'name' => 'Product name',
    // ...
]
```

### Creating / Updating

```php
// Create product in the current locale
Product::create([
    'name' => 'Product name',
    'description' => 'Description ...',
]);

// Create a product with multiple translatons
Product::create([
    'name' => [
        'en' => 'Product name',
        'fr' => 'Nom du produit',
    ],
    'description' => 'Description ...', // description will be set in the current locale only
]);

// Using arrow notation
Product::create([
    'name->en' => 'Product name',
    'name->fr' => 'Nom du produit',
    'description' => 'Description ...', // description will be set in the current locale only
]);

// Update translation for the current locale
$product->update([
    'name' => 'test'
]);

// Update translation for a specific locale
$product->in('fr')->update([
    'name' => 'test'
]);

// Update translations for multiple locales
$product->update([
    'name' => [
        'en' => 'Product name',
        'fr' => 'Nom du produit',
    ],
]);

// Using arrow notation
$product->update([
    'name->en' => 'Product name',
    'name->fr' => 'Nom du produit',
]);

// Set translation for current locale
$product->name = 'The name';

// Set translation for a specific locale
$product->name->fr = 'Nom';

// Or
$product->in('fr')->name = 'Nom';

// Using the fill method
$product->fill([
    'name->fr' => 'Nom',
    'name->en' => 'Name',
])

$product->save();
```
