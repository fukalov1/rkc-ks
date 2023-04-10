<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['quest_block_id', 'sort', 'type', 'hide', 'quest', 'answer', 'email', 'name'];

    public function quest_block()
    {
        return $this->belongsTo(QuestBlock::class);
    }
}
