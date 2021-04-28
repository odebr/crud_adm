<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proprietario extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'proprietario';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'nome',
        'email',
        'telefone1',
        'telefone2',
        'reg',
    ];
}
