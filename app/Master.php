<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    protected $table ='public.master_user';
    public function kepala()
    {
        return $this->hasOne('App\Posisi','user_id');
    }
}
