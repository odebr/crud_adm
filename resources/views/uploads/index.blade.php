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
                        <i class="fa fa-upload"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        Upload contrato e laudo
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions" id="upload_portlet_actions">
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
                            <th>ID</th>
                            <th>Endereco resumido</th>
                            <th>Inquilino</th>
                            <th>Proprietario</th>
                            <th>Imobiliaria</th>
                            <th>Data contrato</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>

                <!--end: Datatable -->
                <!--end::Portlet-->
            </div>

            <!-- end:: Content -->
        </div>
    </div>
</div>
@endsection @section('body_last') @if (session('status')) @endif
<script src="{{ url('js/uploads/uploads.js') }}" type="text/javascript"></script>
<link href="{{ url('css/uploads/uploads.css') }}" rel="stylesheet" type="text/css" /> @endsection