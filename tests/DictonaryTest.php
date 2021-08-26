<?php

namespace FirstpointCh\Translatable\Tests;

use FirstpointCh\Translatable\Tests\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;

class DictonaryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        app()->setLocale('en');
    }

    /** @test */
    public function it_translates_dictonary_with_the_global_json_file()
    {
        $product = Product::create([
            'category' => 'Garden',
        ]);

        $this->assertEquals('Garden', $product->category);

        app()->setLocale('fr');

        $this->assertEquals('Jardin', $product->category);
    }

    /** @test */
    public function it_outputs_value_from_a_specific_dictonary()
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
}
