<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    public $timestamps = FALSE;
    protected $table = 'activity_log';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User','causer_id','id');
    }
}
