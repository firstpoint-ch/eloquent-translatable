<?php

namespace FirstpointCh\Translatable\Tests;

use FirstpointCh\Translatable\Tests\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DictionaryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        app()->setLocale('en');
    }

    /** @test */
    public function it_translates_dictionary_with_the_global_json_file()
    {
        $product = Product::create([
            'category' => 'Garden',
        ]);

        $this->assertEquals('Garden', $product->category);

        app()->setLocale('fr');

        $this->assertEquals('Jardin', $product->category);
    }

    /** @test */
    public function it_outputs_value_from_a_specific_dictionary()
    {
        $product = Product::create([
            'status' => 'in_stock',
        ]);

        $this->assertEquals('In stock', $product->status);

        app()->setLocale('fr');

        $this->assertEquals('En stock', $product->status);

        // Fallback
        app()->setLocale('ru');

        $this->assertEquals('In stock', $product->status);
    }

    /** @test */
    public function it_outputs_a_raw_value()
    {
        $product = Product::create([
            'status' => 'in_stock',
        ]);

        $this->assertEquals('in_stock', $product->raw('status'));
    }
}
