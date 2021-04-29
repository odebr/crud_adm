"use strict";

var datatable;
var cur_imovel_id = null;

$(document).ready(function() {
    // ----------------------------------------------------------------------- //
    // init datatable
    KTDatatablesDataSourceAjaxServer.init();

    // ----------------------------------------------------------------------- //
    // init modal forms
    $('#sel_inquilino').select2();
    $('#sel_proprietario').select2();
    $('#sel_imobiliaria').select2();
    $('#sel_data_contrato').datepicker({
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

    $('#sel_data_vencimento').datepicker({
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

    // init create imovel button
    $("#btn_add_imovel").click(function() {
        cur_imovel_id = null;
        $("#modal_title").html('Criar Imovel');
        $("#modal_imovel").modal('show');

        $("#imovel_name").html('');
        $('#sel_inquilino').select2('destroy').val(0).select2();
        $('#sel_proprietario').select2('destroy').val(0).select2();
        $('#sel_imobiliaria').select2('destroy').val(0).select2();
        $('#sel_data_contrato').datepicker('setDate', '');
        $('#sel_data_vencimento').datepicker('setDate', '');
        $('#input_tempo_contrato').val(0);
        $('#input_contrato').val('');
        $('#input_endereco').val('');
        $('#input_endereco_resumido').val('');
        $('#input_cidade').val('');
        $('#input_estado').val('');
        $('#input_extras').val('');
    });

    // init modal save button
    $("#btn_save").click(function() {
        showWait($("body"));
        $.post('imovel/edit_imovel', {
            _token: csrfToken,
            id: cur_imovel_id,
            inquilino: $('#sel_inquilino').val(),
            proprietario: $('#sel_proprietario').val(),
            imobiliaria: $('#sel_imobiliaria').val(),
            data_contrato: $('#sel_data_contrato').val(),
            data_vencimento: $('#sel_data_vencimento').val(),
            tempo_contrato: $('#input_tempo_contrato').val(),
            contrato: $('#input_contrato').val(),
            endereco: $('#input_endereco').val(),
            endereco_resumido: $('#input_endereco_resumido').val(),
            cidade: $('#input_cidade').val(),
            estado: $('#input_estado').val(),
            extras: $('#input_extras').val(),
        }, function(data, status) {
            closeWait($("body"));
            if (status == 'success') {
                toastr.success('Salvo com sucesso!');
                $("#modal_imovel").modal('hide');
                datatable.ajax.reload();
            } else {
                toastr.error('Ocorreu um erro ao tentar processar o banco de dados');
            }
        });
    });
});

var KTDatatablesDataSourceAjaxServer = function() {

    var initTable = function() {
        var table = $('#list_imovel');
        // list table
        datatable = table.DataTable({
            responsive: true,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            ajax: {
                url: '/imovel/get_imovel_list',
                type: 'POST',
                data: function(data, e) {
                    return $.extend({}, data, {
                        "_token": csrfToken,
                    });
                },
            },
            columns: [
                { data: 'endereco_resumido' },
                { data: 'inquilino_name' },
                { data: 'proprietario_name' },
                { data: 'imobiliaria_name' },
                { data: 'data_contrato' },
                { data: 'data_vencimento' },
                { data: 'tempo_contrato' },
                { data: 'contrato' },
                { data: 'endereco' },
                { data: 'cidade' },
                { data: 'estado' },
                { data: 'extras' },
                { data: 'actions', responsivePriority: -1 },
            ],
            columnDefs: [{
                targets: -1,
                title: 'Ações',
                width: '8%',
                orderable: false,
                render: function(data, type, full, meta) {
                    console.log(full);
                    let result = `
                            <a href="#" 
                                onclick="editImovel(${full.id}, ${full.id_inquilino}, ${full.id_proprietario}, ${full.id_imobiliaria}, '${full.data_contrato}', '${full.data_vencimento}', ${full.tempo_contrato}, '${full.contrato}', '${full.endereco}', '${full.endereco_resumido}', '${full.cidade}', '${full.estado}', '${full.extras}')"
                                class="btn btn-sm btn-clean btn-icon btn-icon-md" 
                                title="Editar">
                                <i class="la la-pencil kt-font-info"></i>
                            </a>
                            <a href="#" 
                                onclick="deleteImovel(${full.id})"
                                class="btn btn-sm btn-clean btn-icon btn-icon-md" 
                                title="Excluir">
                                <i class="la la-trash-o kt-font-danger"></i>
                            </a>`;

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

function editImovel(id, id_inquilino, id_proprietario, id_imobiliaria, data_contrato, data_vencimento, tempo_contrato, contrato, endereco, endereco_resumido, cidade, estado, extras) {
    cur_imovel_id = id;
    $("#modal_title").html('Editar Imovel');
    $("#modal_imovel").modal('show');

    $("#imovel_name").html(endereco_resumido);
    $('#sel_inquilino').select2('destroy').val(formatNumber(id_inquilino)).select2();
    $('#sel_proprietario').select2('destroy').val(formatNumber(id_proprietario)).select2();
    $('#sel_imobiliaria').select2('destroy').val(formatNumber(id_imobiliaria)).select2();
    $('#sel_data_contrato').datepicker('setDate', formatString(data_contrato));
    $('#sel_data_vencimento').datepicker('setDate', formatString(data_vencimento));
    $('#input_tempo_contrato').val(formatString(tempo_contrato));
    $('#input_contrato').val(formatString(contrato));
    $('#input_endereco').val(formatString(endereco));
    $('#input_endereco_resumido').val(formatNumber(endereco_resumido));
    $('#input_cidade').val(formatString(cidade));
    $('#input_estado').val(formatString(estado));
    $('#input_extras').val(formatString(extras));
}

function deleteImovel(id) {
    alertConfirm('Você tem certeza que quer deletar?', function() {
        showWait($("#kt_content"));

        $.post('/imovel/delete_imovel', {
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

function formatNumber(num) {
    if (num == null) {
        return 0
    }

    return num;
}

function formatString(str) {
    if (str == null) {
        return '';
    }

    return str;
}