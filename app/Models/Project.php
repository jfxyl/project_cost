<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public $fillable = ['name','user_id','area','above_area','above_open_ratio','below_area','below_open_ratio','reference_price','intro','attachment'];
}
