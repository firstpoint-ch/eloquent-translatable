<?php

namespace FirstpointCh\Translatable\Traits;

trait Translatable
{
    public $locale;

    public function in($locale)
    {
        $this->locale = $locale;

        return $this;
    }
}
