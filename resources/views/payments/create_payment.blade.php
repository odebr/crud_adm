@extends('layouts.default') @section('title', '| Pagamento') @section('bodyClass', '__job-list-page') @section('head') @parent
<!-- Custom head here -->
@endsection @section('main_content')
<div class="kt-content content-back kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Content -->
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

        <!-- Add Content -->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        Crio Pagamento
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions" id="payments_portlet_actions">
                            <a href="/payments" class="btn btn-success btn-elevate">
                                <i class="fa fa-reply"></i> De volta
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @csrf

            <div class="kt-portlet__body">
                <div class="row">
                    <div class="col-xs-1 col-md-1 col-lg-1">
                        <h5 class="m-title">Imovel</h4>
                    </div>
                    <div class="col-xs-3 col-md-3 col-lg-3">
                        <select id="sel_imovel">
                            <option value="0">&nbsp;</option>
                            @foreach($imovel as $row)
                                <option 
                                    value="{{$row->id}}" 
                                    proprietario="{{$row->proprietario}}"
                                    inquilino="{{$row->inquilino}}"
                                    imobiliaria="{{$row->imobiliaria}}"
                                >
                                    {{$row->endereco_resumido}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xs-8 col-md-8 col-lg-8">
                        <h4 class="kt-font-boldest kt-font-success m-title m-blank-title">
                            Informação Inovadora
                        </h4>

                        <h4 class="kt-font-boldest kt-font-success m-title m-detail-title" for="proprietario">
                            Proprietario:
                        </h4>
                        <span class="m-span-imovel-info" for="proprietario"></span>

                        <h4 class="kt-font-boldest kt-font-success m-title m-detail-title" for="inquilino">
                            Inquilino:
                        </h4>
                        <span class="m-span-imovel-info" for="inquilino"></span>

                        <!-- <h4 class="kt-font-boldest kt-font-success m-title m-detail-title" for="imobiliaria">
                            Imobiliaria:
                        </h4>
                        <span class="m-span-imovel-info" for="imobiliaria"></span>  -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-1 col-md-1 col-lg-1">
                        <h5 class="m-title">Contagem</h4>
                    </div>
                    <div class="col-xs-3 col-md-3 col-lg-3">
                        <input id="sel_total_num" class="form-control" type="number" value="12">
                    </div>
                    <div class="col-xs-8 col-md-8 col-lg-8">
                        <button class="btn btn-brand btn-elevate" id="btn_insert">
                            <i class="fa fa-paste"></i>Crio
                        </button>
                        <button class="btn btn-brand btn-elevate" id="btn_save">
                            <i class="fa fa-save"></i>Salve
                        </button>
                    </div>
                </div>
                <div class="kt-divider">
                    <span></span>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Tipo</th>
                                        <th>Data vencimento</th>
                                        <th>Valor</th>
                                        <th>Subir arquivo</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_payment">
                                    <tr id="clone_tr">
                                        <th scope="row">1</th>
                                        <td>
                                            <select class="sel_type">
                                                <option value="1">Aluguel</option>
                                                <option value="2">IPTU</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control sel_date">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control input_val">
                                        </td>
                                        <td>
                                            <input type="file" class="form-control sel_file">
                                        </td>
                                    </tr>
                                </tbody>
                                <thead class="thead-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Tipo</th>
                                        <th>Data vencimento</th>
                                        <th>Valor</th>
                                        <th>Subir arquivo</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- end:: Content -->
        </div>
    </div>
</div>
@endsection @section('body_last') @if (session('status')) @endif
<script src="{{ url('js/payments/create_payment.js') }}" type="text/javascript"></script>
<link href="{{ url('assets/css/payments/create_payment.css') }}" rel="stylesheet" type="text/css" /> @endsection