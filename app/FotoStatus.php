<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FotoStatus extends Model
{
    protected $fillable = [
        'id_foto', 'nip','nama_file', 'status',
    ];
}
