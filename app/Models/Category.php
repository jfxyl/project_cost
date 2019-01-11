<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
