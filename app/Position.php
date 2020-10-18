<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table ='public.schema_akses';

    public function user()
    {
    	return $this->belongsTo('App\Master');
    }
}
