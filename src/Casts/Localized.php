<?php

namespace FirstpointCh\Translatable\Casts;

use Illuminate\Support\Facades\App;
use FirstpointCh\Translatable\LocalizedValue;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Localized implements CastsAttributes
{
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
        $value = (array)json_decode($value);

        return new LocalizedValue($model, $key, $value);
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
        // Override all translations
        if (is_array($value)) {
            return json_encode($value);
        }

        // dd($model, $key, $value, $attributes);

        // Merge translations
        $locale = $model->locale ?? App::getLocale();

        $modelValue = array_key_exists($key, $attributes)
            ? (array)json_decode($attributes[$key])
            : [];

        $modelValue[$locale] = $value;

        return json_encode($modelValue);
    }
}
