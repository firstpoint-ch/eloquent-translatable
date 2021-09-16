<?php

namespace FirstpointCh\Translatable;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class TranslatableServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->registerMacros();
    }

    private function registerMacros()
    {
        Blueprint::macro('translatable', function ($column) {
            /** @var Blueprint $this */
            return $this->json($column);
        });
    }
}
