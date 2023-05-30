<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{

    protected $table = 'planning_conge';

    protected $fillable = [
        'direction_id',
        'sousdirection_id',
        'service_id',
        'demandeur_id',
        'demandeur_level',
        'interim',
        'date_depart',
        'date_retour',
        'date_reprise',
        'duree',
        'created_at',
        'updated_at',
        'state'
    ];
}
