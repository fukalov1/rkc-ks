<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Photoset extends Model
{
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function page()
    {
        return$this->belongsTo(Page::class);
    }

}
