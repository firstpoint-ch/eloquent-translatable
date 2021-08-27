# Laravel Eloquent Translatable

Make your Eloquent Models translatable.

## Installation

```bash
composer require firstpoint-ch/laravel-translatable-model
```

Then you can publish the config file:

```bash
php artisan vendor:publish --provider="FirstpointCh\\Translatable\\TranslatableServiceProvider"
```

## Getting started

With this package, you can translate model in two different ways:

1. Database: It stores all translations in the same table column using json serialization
2. Dictonary: It stores keys and retrieve translations from ```/resources/lang/[locale].json``` or any files in ```/resources/lang/[locale]/[dictonary].php```.

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
        // Database
        'name' => Localized::class,
        'description' => Localized::class,

        // Dictonary: get value from /resources/lang/[locale].json
        'category' => Dictonary::class,
    ];
}
```

You can specify a dictonary by appending the name as a parameter.

```php
class Product extends Model
{
    protected $casts = [
        // Will get value from /resources/lang/[locale]/categories.php
        'category' => Dictonary::class.':categories',
    ];
}
```

## Using the model

### Get translations

```php
// Output the name in the curent locale or fallback to the default locale
echo $product->name;

// Output the name in a specific locale or null, no fallback.
echo $product->in('fr')->name;
echo $product->description; // Still in french

// Get the underlying value
echo $product->in('*')->name; // ['en' => 'name']
echo $product->raw('name'); // ['en' => 'name']
```

### Using arrays

```php
// As array
$product->toArray();

// Outputs
[
    'id' => 1,
    'name' => 'Product name',
    // ...
]

// As array
$product->in('fr')->toArray();

// Outputs
[
    'id' => 1,
    'name' => 'Nom du produit',
    // ...
]
```

### Creating

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
```

### Updating

```php
// Update translation for the current locale
$product->update([
    'name' => 'test'
]);

// Update translation for a specific locale
$product->in('fr')->update([
    'name' => 'test'
]);

// Using arrow notation
$product->update([
    'name->en' => 'Product name',
    'name->fr' => 'Nom du produit',
]);

// Override all translations by using an array
$product->update([
    'name' => [
        'en' => 'Product name',
        'fr' => 'Nom du produit',
    ],
]);

// Set translation for current locale
$product->name = 'The name';

// Set translation for a specific locale
$product->in('fr')->name = 'Nom';

// Using the fill method
$product->fill([
    'name->fr' => 'Nom',
    'name->en' => 'Name',
])

$product->save();
```
