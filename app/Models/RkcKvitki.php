<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RkcKvitki extends Model
{
    use HasFactory;

    protected $table = 'rkc_kvitki';


    public function links()
    {
        return $this->belongsTo(RkcLs::class, 'ls', 'ls');
    }

}
