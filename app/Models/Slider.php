<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    public function items()
    {
        return $this->hasMany(SliderItem::class);
    }

    public function page()
    {
        return$this->belongsTo(Page::class);
    }

}
