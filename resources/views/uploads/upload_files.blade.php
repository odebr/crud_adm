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
                        <i class="fa fa-upload"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        Upload contrato e laudo
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions" id="upload_portlet_actions">
                            <a href="/upload" class="btn btn-success btn-elevate">
                                <i class="fa fa-reply"></i> De volta
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @csrf

            <div class="kt-portlet__body">
                <!--begin: Upload file form -->
                
                <h1 class="m-title">Upload contrato</h1>
                <input type="file" class="form-control" id="sel_contrato_file">
                <button class="btn btn-brand btn-elevate" id="btn_upload_contrato">Upload</button>
                <div class="kt-divider"><span></span></div>

                <h1 class="m-title">Upload laudo</h1>
                <input type="file" class="form-control" id="sel_laudo_file">
                <button class="btn btn-brand btn-elevate" id="btn_upload_laudo">Upload</button>
                <!--end: Upload file form -->
                <!--end::Portlet-->
            </div>

            <!-- end:: Content -->
        </div>
    </div>
</div>
@endsection @section('body_last') @if (session('status')) @endif
<script src="{{ url('js/uploads/upload_files.js') }}" type="text/javascript"></script>
<script>
    var id_imovel = {{$id}};
</script>
<link href="{{ url('css/uploads/uploads.css') }}" rel="stylesheet" type="text/css" /> @endsection