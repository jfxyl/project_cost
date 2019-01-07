<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSupplyCate extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id','supply_cate_id'];
}
