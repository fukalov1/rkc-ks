<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'rkc_clients';

    protected $fillable = ['clientid', 'value_new', 'value_date'];

    public $timestamps = false;

    public function accounts()
    {
        return $this->belongsTo(RkcLs::class, 'ls', 'clientid');
    }



}
