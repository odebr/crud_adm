<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imobiliaria extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'imobiliaria';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'nome',
        'email',
        'telefone1',
        'telefone2',
        'url',
        'reg',
        'creci'
    ];
}
