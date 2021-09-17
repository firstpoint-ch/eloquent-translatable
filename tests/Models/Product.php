<?php

namespace FirstpointCh\Translatable\Tests\Models;

use FirstpointCh\Translatable\Casts\Dictionary;
use FirstpointCh\Translatable\Casts\Localized;
use FirstpointCh\Translatable\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Translatable;

    protected $guarded = [];

    protected $casts = [
        'name' => Localized::class,
        'category' => Dictionary::class,
        'status' => Dictionary::class.':test::statuses',
    ];
}
