<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectItem extends Model
{
    protected $fillable = [
        'project_id','item_id','status','remark'
    ];

//    public function setRemarkAttribute($value)
//    {
//        if($value == null){
//            $value = '';
//        }
//        $this->attributes['remark'] = $value;
//    }
}
