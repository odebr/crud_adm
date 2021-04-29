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
                        <i class="fa fa-hotel"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        Imovel
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions" id="imovel_portlet_actions">
                            <a href="#" class="btn btn-brand btn-elevate" id="btn_add_imovel">
                                <i class="fas fa-plus"></i> Criar Imovel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @csrf

            <div class="kt-portlet__body">
                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable" id="list_imovel">
                    <thead>
                        <tr>
                            <th>Endereco resumido</th>
                            <th>Inquilino</th>
                            <th>Proprietario</th>
                            <th>Imobiliaria</th>
                            <th>Data contrato</th>
                            <th>Data vencimento</th>
                            <th>Tempo contrato</th>
                            <th>Contrato</th>
                            <th>Endereco</th>
                            <th>Cidade</th>
                            <th>Estado</th>
                            <th>Extras</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>

                <!--end: Datatable -->
                <!--end::Portlet-->
            </div>

            <!--begin::Edit Imovel Modal-->
            <div class="modal fade" id="modal_imovel" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal_title"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"></span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <div class="kt-scroll" data-scroll="true">
                                    <h4 id="imovel_name" class="kt-font-success"></h4>
                                    <div class="kt-divider">
                                        <span></span>
                                        <span>Informação</span>
                                        <span></span>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-3 col-md-3 col-lg-3">
                                            <h5 class="m-title">Inquilino:</h5>
                                        </div>
                                        <input type="hidden" id="id_edit">
                                        <div class="col-xs-9 col-md-9 col-lg-9">
                                            <select id="sel_inquilino">
                                                <option value="0">&nbsp;</option>
                                                @foreach($inquilino as $row)
                                                    <option value="{{$row->id}}">{{$row->nome}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-3 col-md-3 col-lg-3">
                                            <h5 class="m-title">Proprietario:</h5>
                                        </div>
                                        <input type="hidden" id="id_edit">
                                        <div class="col-xs-9 col-md-9 col-lg-9">
                                            <select id="sel_proprietario">
                                                <option value="0">&nbsp;</option>
                                                @foreach($proprietario as $row)
                                                    <option value="{{$row->id}}">{{$row->nome}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-3 col-md-3 col-lg-3">
                                            <h5 class="m-title">Imobiliaria:</h5>
                                        </div>
                                        <input type="hidden" id="id_edit">
                                        <div class="col-xs-9 col-md-9 col-lg-9">
                                            <select id="sel_imobiliaria">
                                                <option value="0">&nbsp;</option>
                                                @foreach($imobiliaria as $row)
                                                    <option value="{{$row->id}}">{{$row->nome}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-3 col-md-3 col-lg-3">
                                            <h6 class="m-title">Data contrato:</h6>
                                        </div>
                                        <div class="col-xs-9 col-md-9 col-lg-9">
                                            <input type="text" class="form-control" id="sel_data_contrato">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-3 col-md-3 col-lg-3">
                                            <h6 class="m-title">Data vencimento:</h6>
                                        </div>
                                        <div class="col-xs-9 col-md-9 col-lg-9">
                                            <input type="text" class="form-control" id="sel_data_vencimento">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-3 col-md-3 col-lg-3">
                                            <h6 class="m-title">Tempo contrato:</h6>
                                        </div>
                                        <div class="col-xs-9 col-md-9 col-lg-9">
                                            <input type="number" class="form-control" id="input_tempo_contrato">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-3 col-md-3 col-lg-3">
                                            <h5 class="m-title">Contrato:</h5>
                                        </div>
                                        <div class="col-xs-9 col-md-9 col-lg-9">
                                            <input type="text" class="form-control" id="input_contrato">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-3 col-md-3 col-lg-3">
                                            <h5 class="m-title">Endereco:</h5>
                                        </div>
                                        <div class="col-xs-9 col-md-9 col-lg-9">
                                            <input type="text" class="form-control" id="input_endereco">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-3 col-md-3 col-lg-3">
                                            <h5 class="m-title">Resumido:</h5>
                                        </div>
                                        <div class="col-xs-9 col-md-9 col-lg-9">
                                            <input type="text" class="form-control" id="input_endereco_resumido">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-3 col-md-3 col-lg-3">
                                            <h5 class="m-title">Cidade:</h5>
                                        </div>
                                        <div class="col-xs-9 col-md-9 col-lg-9">
                                            <input type="text" class="form-control" id="input_cidade">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-3 col-md-3 col-lg-3">
                                            <h5 class="m-title">Estado:</h5>
                                        </div>
                                        <div class="col-xs-9 col-md-9 col-lg-9">
                                            <input type="text" class="form-control" id="input_estado">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-3 col-md-3 col-lg-3">
                                            <h5 class="m-title">Extras:</h5>
                                        </div>
                                        <div class="col-xs-9 col-md-9 col-lg-9">
                                            <input type="text" class="form-control" id="input_extras">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btn_save" class="btn btn-brand">Salve</button>
                                <button type="button" class="btn btn-secondary btn-hover-success" data-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!--end::Modal-->

            <!-- end:: Content -->
        </div>
    </div>
</div>
@endsection @section('body_last') @if (session('status')) @endif
<script src="{{ url('js/imovel/imovel.js') }}" type="text/javascript"></script>
<link href="{{ url('css/imovel/imovel.css') }}" rel="stylesheet" type="text/css" /> @endsection