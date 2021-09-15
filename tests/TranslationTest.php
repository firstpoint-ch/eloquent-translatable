<?php

namespace FirstpointCh\Translatable\Tests;

use FirstpointCh\Translatable\Tests\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TranslationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        app()->setLocale('en');
    }

    /** @test */
    public function it_stores_translation_in_the_current_locale()
    {
        Product::create(['name' => 'test']);

        $this->assertDatabaseHas('products', [
            'name' => json_encode(['en' => 'test']),
        ]);
    }

    /** @test */
    public function it_stores_multiple_locale_when_using_array()
    {
        Product::create(['name' => ['en' => 'test en', 'fr' => 'test fr']]);

        $this->assertDatabaseHas('products', [
            'name' => json_encode(['en' => 'test en', 'fr' => 'test fr']),
        ]);
    }

    /** @test */
    public function it_stores_multiple_locale_using_array_notation()
    {
        Product::create([
            'name->en' => 'test en',
            'name->fr' => 'test fr'
        ]);

        $this->assertDatabaseHas('products', [
            'name' => json_encode(['en' => 'test en', 'fr' => 'test fr']),
        ]);
    }

    /** @test */
    public function it_outputs_attributes_in_the_current_locale()
    {
        $product = Product::create([
            'name->en' => 'test en',
            'name->fr' => 'test fr'
        ]);

        $this->assertEquals('test en', $product->name);
    }

    /** @test */
    public function it_outputs_attributes_in_a_specific_locale()
    {
        $product = Product::create([
            'name->en' => 'test en',
            'name->fr' => 'test fr'
        ]);

        $this->assertEquals('test en', $product->name);
        $this->assertEquals('test fr', $product->in('fr')->name);
    }

    /** @test */
    public function it_outputs_raw_attributes()
    {
        $product = Product::create([
            'name->en' => 'test en',
            'name->fr' => 'test fr'
        ]);

        $this->assertEquals(['en' => 'test en', 'fr' => 'test fr'], $product->raw('name'));
    }

    /** @test */
    public function it_outputs_locales_as_array()
    {
        $product = Product::create([
            'name->en' => 'test en',
            'name->fr' => 'test fr'
        ]);

        $this->assertEquals('test en', $product->toArray()['name']);
        $this->assertEquals('test fr', $product->in('fr')->toArray()['name']);
    }

    /** @test */
    public function it_uses_fallback_locale_when_translation_is_missing()
    {
        $product = Product::create([
            'name->en' => 'test en',
        ]);

        $this->assertEquals('test en', $product->name);
    }

    /** @test */
    public function it_sets_the_value_for_the_current_locale()
    {
        $product = Product::create([
            'name' => 'test',
        ]);

        $product->name = 'changed';

        $product->save();

        $this->assertDatabaseHas('products', [
            'name' => json_encode(['en' => 'changed']),
        ]);
    }

    /** @test */
    public function it_sets_the_value_for_a_specific_locale()
    {
        $product = Product::create([
            'name' => 'test',
        ]);

        $product->in('fr')->name = 'test fr';

        $product->save();

        $this->assertDatabaseHas('products', [
            'name' => json_encode(['en' => 'test', 'fr' => 'test fr']),
        ]);
    }

    /** @test */
    public function it_updates_value_for_the_current_locale()
    {
        $product = Product::create([
            'name' => 'test',
        ]);

        $product->update([
            'name' => 'changed',
        ]);

        $this->assertDatabaseHas('products', [
            'name' => json_encode(['en' => 'changed']),
        ]);
    }

    /** @test */
    public function it_updates_value_for_a_specific_locale()
    {
        $product = Product::create([
            'name' => 'test',
        ]);

        $product->update(['name->fr' => 'test fr']);

        $this->assertDatabaseHas('products', [
            'name' => json_encode(['en' => 'test', 'fr' => 'test fr']),
        ]);

        $product->in('fr')->update(['name' => 'changed']);

        $this->assertDatabaseHas('products', [
            'name' => json_encode(['en' => 'test', 'fr' => 'changed']),
        ]);
    }

    /** @test */
    public function it_overrides_value_when_passing_an_array()
    {
        $product = Product::create([
            'name' => 'test',
        ]);

        $product->update([
            'name' => ['fr' => 'test fr'],
        ]);

        $this->assertDatabaseHas('products', [
            'name' => json_encode(['fr' => 'test fr']),
        ]);
    }
}
