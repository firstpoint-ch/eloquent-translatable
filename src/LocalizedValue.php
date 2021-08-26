<?php

namespace FirstpointCh\Translatable;

use Stringable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Contracts\Support\Arrayable;

class LocalizedValue implements Stringable, Arrayable
{
    public $model;

    public $attribute;

    public $rawValue;

    public function __construct(&$model, $attribute, $value)
    {
        $this->model = $model;
        $this->attribute = $attribute;
        $this->rawValue = $value;
    }

    public function __toString()
    {
        $locale = $this->model->locale ?? App::getLocale();
        $fallback = Config::get('translatable.fallback_locale');

        if (array_key_exists($locale, $this->rawValue)) {
            return $this->rawValue[$locale];
        }

        if (array_key_exists($fallback, $this->rawValue)) {
            return $this->rawValue[$fallback];
        }

        return null;
    }

    public function __get($name)
    {
        return $this->in($name);
    }

    public function __set($name, $value)
    {
        $locale = $this->model->locale;

        $this->model->in($name)->{$this->attribute} = $value;
        $this->model->in($locale);
    }

    public function toArray()
    {
        if (!empty($this->model->locale)) {
            return $this->in($this->model->locale);
        }

        return $this->rawValue;
    }

    public function in($locale)
    {
        if (array_key_exists($locale, $this->rawValue)) {
            return $this->rawValue[$locale];
        }

        return null;
    }
}
