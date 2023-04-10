<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PageBlock extends Model
{
    protected $fillable = ['page_id', 'orders', 'header', 'image', 'text'];

    public function pages()
    {
        return $this->belongsTo(Page::class);
    }

    public function  quest_blocks()
    {
        return $this->hasMany(QuestBlock::class);
    }

    public function  maps()
    {
        return $this->hasMany(Map::class);
    }

    public function  photosets()
    {
        return $this->hasMany(Photoset::class);
    }

    public function  sliders()
    {
        return $this->hasMany(Slider::class);
    }

    public function  mail_forms()
    {
        return $this->hasMany(MailForm::class);
    }

}
