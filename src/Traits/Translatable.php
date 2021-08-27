<?php

namespace FirstpointCh\Translatable\Traits;

trait Translatable
{
    public ?string $locale = null;

    /**
     * Set the locale for this specific model
     * Hint: use '*' to get raw data
     *
     * @param ?string $locale
     * @return self
     */
    public function in(?string $locale = null): self
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get the raw value without changing the locale
     *
     * @param string $attribute
     * @return string|array
     */
    public function raw(string $attribute)
    {
        $locale = $this->locale;

        $value = $this->in('*')->{$attribute};

        $this->in($locale);

        return $value;
    }
}
