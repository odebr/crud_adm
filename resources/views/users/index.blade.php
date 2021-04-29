@extends('layouts.default') @section('title', '| Pagamento') @section('bodyClass', '__job-list-page') @section('head') @parent
<!-- Custom head here -->
@endsection @section('main_content')
<div class="kt-content content-back  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Content -->
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

        <!-- Add Content -->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="fa fa-address-card"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        Usuários Configuração
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions" id="users_portlet_actions">
                            <select id="sel_role">
                                <option value="0">
                                    Todos
                                </option>
                                <option value="2">
                                    Inquilino
                                </option>
                                <option value="1">
                                    Proprietario
                                </option>
                                <option value="3">
                                    Imobiliaria
                                </option>
                            </select>
                            <a href="#" class="btn btn-brand btn-elevate" id="btn_add_user">
                                <i class="fas fa-plus"></i> Criar Usuário
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @csrf

            <div class="kt-portlet__body">
                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable" id="list_users">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tipo</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone1</th>
                            <th>Telefone2</th>
                            <th>Reg</th>
                            <th>Url</th>
                            <th>Creci</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>

                <!--end: Datatable -->
                <!--end::Portlet-->

                <!--begin::Edit User Modal-->
                <div class="modal fade" id="modal_user" role="dialog" aria-hidden="true">
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
                                    <h4 id="user_name" class="kt-font-success"></h4>
                                    <div class="kt-divider">
                                        <span></span>
                                        <span>Informação</span>
                                        <span></span>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-2 col-md-2 col-lg-2">
                                            <h5 class="m-title">Cusuários:</h5>
                                        </div>
                                        <input type="hidden" id="id_edit">
                                        <div class="col-xs-10 col-md-10 col-lg-10">
                                            <select id="sel_role_modal">
                                                <option value="2">
                                                    Inquilino
                                                </option>
                                                <option value="1">
                                                    Proprietario
                                                </option>
                                                <option value="3">
                                                    Imobiliaria
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-2 col-md-2 col-lg-2">
                                            <h5 class="m-title">ID:</h5>
                                        </div>
                                        <div class="col-xs-10 col-md-10 col-lg-10">
                                            <input type="text" class="form-control" id="input_username">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-2 col-md-2 col-lg-2">
                                            <h5 class="m-title">Nome:</h5>
                                        </div>
                                        <div class="col-xs-10 col-md-10 col-lg-10">
                                            <input type="text" class="form-control" id="input_name">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-2 col-md-2 col-lg-2">
                                            <h5 class="m-title">Password:</h5>
                                        </div>
                                        <div class="col-xs-10 col-md-10 col-lg-10">
                                            <input type="password" class="form-control" id="input_pass">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-2 col-md-2 col-lg-2">
                                            <h5 class="m-title">Email:</h5>
                                        </div>
                                        <div class="col-xs-10 col-md-10 col-lg-10">
                                            <input type="email" class="form-control" id="input_email">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-2 col-md-2 col-lg-2">
                                            <h5 class="m-title">Telefone1:</h5>
                                        </div>
                                        <div class="col-xs-10 col-md-10 col-lg-10">
                                            <input type="text" class="form-control" id="input_tel1">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-2 col-md-2 col-lg-2">
                                            <h5 class="m-title">Telefone2:</h5>
                                        </div>
                                        <div class="col-xs-10 col-md-10 col-lg-10">
                                            <input type="text" class="form-control" id="input_tel2">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-2 col-md-2 col-lg-2">
                                            <h5 class="m-title">Reg:</h5>
                                        </div>
                                        <div class="col-xs-10 col-md-10 col-lg-10">
                                            <input type="text" class="form-control" id="input_reg">
                                        </div>
                                    </div>
                                    <div class="row" id="modal_url_wrapper" style="display: none;">
                                        <div class="col-xs-2 col-md-2 col-lg-2">
                                            <h5 class="m-title">Url:</h5>
                                        </div>
                                        <div class="col-xs-10 col-md-10 col-lg-10">
                                            <input type="text" class="form-control" id="input_url">
                                        </div>
                                    </div>
                                    <div class="row" id="modal_creci_wrapper" style="display: none;">
                                        <div class="col-xs-2 col-md-2 col-lg-2">
                                            <h5 class="m-title">Creci:</h5>
                                        </div>
                                        <div class="col-xs-10 col-md-10 col-lg-10">
                                            <input type="text" class="form-control" id="input_creci">
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
<script src="{{ url('js/users/users.js') }}" type="text/javascript"></script>
<link href="{{ url('css/users/users.css') }}" rel="stylesheet" type="text/css" /> @endsection