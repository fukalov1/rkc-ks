<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{

    protected $fillable = ['name', 'url', 'order'];

    public function sub_pages()
    {
        return $this->hasMany(Page::class,'parent_id','id')->where('order', '>', 0)->orderBy('order');
    }

    public function page_blocks()
    {
        return $this->hasMany(PageBlock::class);
    }

    public function getMenu()
    {
        return Page::where('parent_id', 0)->where('order', '>', 0)->get()->sortBy('order');
    }

//    public function news()
//    {
//        return $this->hasMany(CenterNew::class)->orderBy('date', 'desc')->limit(4);
//    }
//
//    public function allnews()
//    {
//        return $this->hasMany(CenterNew::class)->orderBy('date', 'desc');
//    }

}
