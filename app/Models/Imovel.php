<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imovel extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'imovel';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_proprietario',
        'id_inquilino',
        'id_imobiliaria',
        'data_contrato',
        'data_vencimento',
        'tempo_contrato',
        'contrato',
        'endereco',
        'endereco_resumido',
        'cidade',
        'estado',
        'extras'
    ];
}
