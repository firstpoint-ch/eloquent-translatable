<?php

namespace FirstpointCh\Translatable\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as Orchestra;
use Illuminate\Support\Facades\Config;

abstract class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();
        $this->setUpConfig();
    }

    protected function getPackageProviders($app)
    {
        return [TestTranslatableServiceProvider::class];
    }

    protected function setUpDatabase()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->translatable('name')->nullable();
            $table->string('category')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    protected function setUpConfig()
    {
        Config::set('app.fallback_locale', 'en');
    }
}
