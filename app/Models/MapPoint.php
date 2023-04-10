<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MapPoint extends Model
{
    public function sub_points()
    {
        return $this->hasMany(MapPoint::class,'parent_id','id');
    }

    public function map()
    {
        return $this->belongsTo(Map::class);
    }

}
