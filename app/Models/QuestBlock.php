<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class QuestBlock extends Model
{
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function page()
    {
        return$this->belongsTo(Page::class);
    }
}
