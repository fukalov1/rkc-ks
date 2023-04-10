<?php

namespace App\Models;
use App\MapPoint;
use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    public function points() {
        return $this->hasMany(MapPoint::class);
    }

    public function page()
    {
        return$this->belongsTo(Page::class);
    }

}
