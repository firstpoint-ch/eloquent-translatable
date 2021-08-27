<?php

namespace FirstpointCh\Translatable\Casts;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Dictonary implements CastsAttributes
{
    public $dictonary;

    public function __construct($dictonary = null)
    {
        $this->dictonary = $dictonary;
    }

    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return \App\Models\Address
     */
    public function get($model, $key, $value, $attributes)
    {
        if ($model->locale === '*') {
            return $value;
        }

        if (!is_null($this->dictonary)) {
            return Lang::get($this->dictonary . '.' . $value);
        }

        return Lang::get($value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  \App\Models\Address  $value
     * @param  array  $attributes
     * @return string
     */
    public function set($model, $key, $value, $attributes)
    {
        return $value;
    }
}
