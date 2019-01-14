<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectUserCatalog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'project_id','user_id','catalog_id','amount','unit_price','remark'
    ];
}
