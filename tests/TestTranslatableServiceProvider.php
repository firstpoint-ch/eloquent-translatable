<?php

namespace FirstpointCh\Translatable\Tests;

use FirstpointCh\Translatable\TranslatableServiceProvider;

class TestTranslatableServiceProvider extends TranslatableServiceProvider
{
    public function boot()
    {
        parent::boot();

        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'test');
        $this->loadJSONTranslationsFrom(__DIR__.'/resources/lang');
    }
}
