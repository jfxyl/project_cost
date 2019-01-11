<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $timestamps = false;

    public function catalogs()
    {
        return $this->hasMany(Catalog::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
