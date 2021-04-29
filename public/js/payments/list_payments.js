"use strict";

var datatable;
var dropzone;

Dropzone.autoDiscover = false;
$(document).ready(function() {
    // ----------------------------------------------------------------------- //
    // init datatable
    KTDatatablesDataSourceAjaxServer.init();

    // init filter select
    $("#sel_imovel").select2({
        width: 300
    }).change(function() {
        datatable.ajax.reload();
    });

    // ----------------------------------------------------------------------- //
    // init modal select type
    $("#sel_type").select2({
        width: '100%'
    });

    // init modal save button
    $("#btn_save").click(function() {
        showWait($("body"));
        $.post('/payments/edit_payment', {
            id: $("#id_edit").val(),
            type: $("#sel_type").val(),
            value: $("#input_val").val(),
            date: $("#sel_date").val(),
            _token: csrfToken
        }, function(data, status) {
            closeWait($("body"));
            if (status == 'success') {
                toastr.success('Atualizado com sucesso!');
                datatable.ajax.reload();
                $("#modal_edit_payment").modal('hide');
            } else {
                toastr.error('Ocorreu um erro ao tentar processar o banco de dados');
            }
        });
    });

    // init modal select date
    $("#sel_date").datepicker({
        rtl: KTUtil.isRTL(),
        todayHighlight: true,
        orientation: "top left",
        format: "yyyy-mm-dd",
        templates: {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }
    }).change(function() {
        $(this).datepicker('hide');
    });

    // ----------------------------------------------------------------------- //
    // init dropzone
    dropzone = new Dropzone('#dropzone_file_upload', {
        url: "/payments/upload_file",
        type: 'post',
        paramName: "file",
        maxFiles: 1,
        maxFilesize: 1024,
        addRemoveLinks: true,
        autoProcessQueue: false,
        headers: {
            'X_CSRF_TOKEN': csrfToken
        },
        params: {
            id: 0
        },
        sending: function() {
            showWait($("body"));
        },
        success: function() {
            toastr.success('Carregado com sucesso');
            $("#modal_file_upload").modal('hide');
            datatable.ajax.reload();
        },
        error: function() {
            toastr.error('Ocorreu um erro ao tentar processar o banco de dados');
        },
        complete: function() {
            closeWait($("body"));
        }
    });

    // init confirm upload button
    $("#btn_upload").click(function(e) {
        dropzone.processQueue();
    });
});

var KTDatatablesDataSourceAjaxServer = function() {

    var initTable = function() {
        var table = $('#list_payments_table');
        // list table
        datatable = table.DataTable({
            responsive: true,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            ajax: {
                url: '/payments/get_payments_list',
                type: 'POST',
                data: function(data, e) {
                    return $.extend({}, data, {
                        "_token": csrfToken,
                        "id_imovel": $("#sel_imovel").val()
                    });
                },
            },
            columns: [
                { data: 'imovel_name' },
                { data: 'tipo_name' },
                { data: 'proprietario_name' },
                { data: 'inquilino_name' },
                { data: 'imobiliaria_name' },
                { data: 'valor' },
                { data: 'data_vencimento' },
                { data: 'data_pagamento' },
                { data: 'actions', responsivePriority: -1 },
            ],
            columnDefs: [{
                targets: -1,
                title: 'Ações',
                width: '13%',
                orderable: false,
                render: function(data, type, full, meta) {
                    let result = `<a href="#" 
                                onclick="show_upload_modal(${full.id})"
                                class="btn btn-sm btn-clean btn-icon btn-icon-md" 
                                title="Subir arquivo">
                                <i class="la la-cloud-upload kt-font-success"></i>
                            </a>
                            <a href="#" 
                                onclick="show_edit_modal(${full.id}, '${full.imovel_name}', ${full.tipo}, ${full.valor}, '${full.data_vencimento}')"
                                class="btn btn-sm btn-clean btn-icon btn-icon-md" 
                                title="Editar">
                                <i class="la la-pencil kt-font-info"></i>
                            </a>
                            <a href="#" 
                                onclick="deletePayment(${full.id})"
                                class="btn btn-sm btn-clean btn-icon btn-icon-md" 
                                title="Excluir">
                                <i class="la la-trash-o kt-font-danger"></i>
                            </a>`;

                    // let filepath = full.recibo_ctr;
                    // if (filepath != null && filepath != '') {
                    //     result += `<a href="/payments/show_file/${full.id}"
                    //                 target="_blank" 
                    //                 class="btn btn-sm btn-clean btn-icon btn-icon-md" 
                    //                 title="Arquivo carregado">
                    //                 <i class="la la-paperclip kt-font-warning"></i>
                    //             </a>`;
                    // }

                    return result;
                }
            }],
        });
    };

    return {
        //main function to initiate the module
        init: function() {
            initTable();
        },
    };
}();

function show_upload_modal(id) {
    dropzone.options.params.id = id;
    dropzone.removeAllFiles();
    $("#modal_file_upload").modal('show');
}

function show_edit_modal(id, imovel_name, type, value, date) {
    $("#id_edit").val(id);
    $("#imovel_name").html(imovel_name);
    $("#input_val").val(value);
    $("#sel_type").select2('destroy').val(type).select2({
        width: '100%'
    });

    if (date == null || date == 'null') {
        $("#sel_date").datepicker('setDate', '');
    } else {
        $("#sel_date").datepicker('setDate', date);
    }
    $("#modal_edit_payment").modal('show');
}

function deletePayment(id) {
    alertConfirm('Você tem certeza que quer deletar?', function() {
        showWait($("#kt_content"));

        $.post('/payments/delete_payment', {
            id,
            _token: csrfToken
        }, function(data, status) {
            closeWait($("#kt_content"));
            if (data == true) {
                toastr.success('Excluído com sucesso!');
                datatable.ajax.reload();
            } else {
                toastr.error('Ocorreu um erro ao tentar processar o banco de dados');
            }
        });
    });
}