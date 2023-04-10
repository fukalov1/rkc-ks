<?php

namespace App;namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SliderItem extends Model
{
    protected $fillable = ['slider_id','title','text','url','image','orders'];
}
