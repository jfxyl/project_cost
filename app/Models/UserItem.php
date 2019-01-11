<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserItem extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id','item_id'];
}
