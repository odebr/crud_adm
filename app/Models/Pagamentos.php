<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagamentos extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pagamentos';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_imovel',
        'id_proprietario',
        'id_inquilino',
        'id_imobiliaria',
        'tipo',
        'valor',
        'data_vencimento',
        'data_pagamento',
        'pagamento_realizado',
        'pagamento_notificado',
        'recibo_ctr',
    ];
}
