<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public $fillable = ['name','user_id','area','above_area','above_open_ratio','below_area','below_open_ratio','reference_price','intro','attachment'];


    public function itemIds()
    {
        return $this->hasMany(ProjectItem::class)->where('status',1);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class,'project_items','project_id','item_id')->withPivot('status')->wherePivot('status',1)->withTimestamps();
    }

    public function getAttachmentAttribute($value)
    {
        return $value?url(\Storage::url($value)):'';
    }
}
