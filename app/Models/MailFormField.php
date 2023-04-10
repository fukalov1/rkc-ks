<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MailFormField extends Model
{
    protected $table = 'mailform_fields';
    protected $fillable = ['mailform_id','orders','field_name','field_value'];

    public function mailform()
    {
        return $this->belongsTo(MailForm::class);
    }
}
