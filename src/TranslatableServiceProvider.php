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

        $this->publishes([
            __DIR__.'/../config/translatable.php' => App::configPath('translatable.php'),
        ]);
    }

    private function registerMacros()
    {
        Blueprint::macro('translatable', function ($column) {
            /** @var Blueprint $this */
            return $this->text($column);
        });

        Blueprint::macro('mediumTranslatable', function ($column) {
            /** @var Blueprint $this */
            return $this->mediumText($column);
        });

        Blueprint::macro('longTranslatable', function ($column) {
            /** @var Blueprint $this */
            return $this->longText($column);
        });
    }
}
