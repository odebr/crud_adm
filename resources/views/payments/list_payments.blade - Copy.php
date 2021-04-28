@extends('layouts.default') @section('title', '| Pagamento') @section('bodyClass', '__job-list-page') @section('head') @parent
<!-- Custom head here -->
@endsection @section('main_content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Content -->
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

        <!-- Add Content -->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="fa fa-money-check"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        Pagamento
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions" id="payments_portlet_actions">
                            <select id="sel_imovel">
                                <option value="0">
                                    Todos
                                </option>
                                @foreach($imovel as $row)
                                    <option value="{{$row->id}}">{{$row->endereco_resumido}}</option>
                                @endforeach
                            </select>
                            <a href="/payments/create_payment" class="btn btn-brand btn-elevate" id="btn_add_payments">
                                <i class="fas fa-plus"></i> Novo Pagamento
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @csrf

            <div class="kt-portlet__body">
                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable" id="list_payments_table">
                    <thead>
                        <tr>
                            <th>Imóvel</th>
                            <th>Tipo</th>
                            <th>Proprietario</th>
                            <th>Inquilino</th>
                            <th>Imobiliaria</th>
                            <th>Valor</th>
                            <th>Vencimento</th>
                            <th>Pagamento</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>

                <!--end: Datatable -->
                <!--end::Portlet-->

                <!--begin::Upload file Modal-->
                <div class="modal fade" id="modal_file_upload" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Subir Arquivo</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
                            </div>
                            <div class="modal-body">
                                <div class="kt-scroll" data-scroll="true">
                                    <div class="dropzone dropzone-default" id="dropzone_file_upload">
                                        <div class="dropzone-msg dz-message needsclick">
                                            <h3 class="dropzone-msg-title">Solte os arquivos aqui ou clique para enviar.</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btn_upload" class="btn btn-brand">Envio</button>
                                <button type="button" class="btn btn-secondary btn-hover-success" data-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Modal-->

                <!--begin::Edit Payment Modal-->
                <div class="modal fade" id="modal_edit_payment" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Editar Pagamento</h5>
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
                                        <div class="col-xs-2 col-md-2 col-lg-2">
                                            <h5 class="m-title">Tipo:</h5>
                                        </div>
                                        <input type="hidden" id="id_edit">
                                        <div class="col-xs-10 col-md-10 col-lg-10">
                                            <select id="sel_type">
                                                <option value="1">Aluguel</option>
                                                <option value="2">IPTU</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-2 col-md-2 col-lg-2">
                                            <h5 class="m-title">Valor:</h5>
                                        </div>
                                        <div class="col-xs-10 col-md-10 col-lg-10">
                                            <input type="number" class="form-control" id="input_val">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-2 col-md-2 col-lg-2">
                                            <h5 class="m-title">Data:</h5>
                                        </div>
                                        <div class="col-xs-10 col-md-10 col-lg-10">
                                            <input type="text" class="form-control" id="sel_date">
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
            </div>

            <!-- end:: Content -->
        </div>
    </div>
</div>
@endsection @section('body_last') @if (session('status')) @endif
<script src="{{ url('js/payments/list_payments.js') }}" type="text/javascript"></script>
<link href="{{ url('assets/css/payments/list_payments.css') }}" rel="stylesheet" type="text/css" /> @endsection