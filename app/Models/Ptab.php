<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ptab extends Model
{

    protected $table = 'ptab';

    protected $fillable = [
        'champ1',
        'champ2',
    ];
}
