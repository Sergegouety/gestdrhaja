<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActionBck extends Model
{

    protected $table = 'action_bck';

    protected $fillable = [
        'direction_id',
        'sousdirection_id',
        'extrant_id',
        'action',
        'responsable',
        'cible_glo',
        'cout_glo',
        'cible_t1',
        'cout_t1',
        'cible_t2',
        'cout_t2',
        'cible_t3',
        'cout_t3',
        'cible_t4',
        'cout_t4',
        'entite_prenante',
        'action_entite',
        'periode_execution',
        'zone_exection'
    ];
}
