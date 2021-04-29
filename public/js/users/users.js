"use strict";

var datatable;
var cur_user_id = null;

$(document).ready(function() {
    // ----------------------------------------------------------------------- //
    // init datatable
    KTDatatablesDataSourceAjaxServer.init();

    // init filter select
    $("#sel_role").select2({
        width: 300
    }).change(function() {
        datatable.ajax.reload();
    });

    // ----------------------------------------------------------------------- //
    // init create user button
    $("#btn_add_user").click(function() {
        cur_user_id = null;
        $("#modal_title").html('Criar Usuário');
        $("#modal_user").modal('show');

        $("#user_name").html('');
        $("#input_username").val('');
        $("#sel_role_modal").select2('destroy').val(2).select2().trigger('change');
        $("#input_name").val('');
        $("#input_pass").val('');
        $("#input_email").val('');
        $("#input_tel1").val('');
        $("#input_tel2").val('');
        $("#input_reg").val('');
        $("#input_url").val('');
        $("#input_creci").val('');
    });

    // init role select
    $("#sel_role_modal").select2().change(function() {
        if ($(this).val() == 3) {
            $('#modal_url_wrapper').show()
            $('#modal_creci_wrapper').show()
        } else {
            $('#modal_url_wrapper').hide();
            $('#modal_creci_wrapper').hide();
        }
    });

    // init modal save button
    $("#btn_save").click(function() {
        showWait($("#kt_content"));
        $.post('/users/save_user', {
            _token: csrfToken,
            user_id: cur_user_id,
            username: $.trim($("#input_username").val()),
            role: $("#sel_role_modal").val(),
            name: $.trim($("#input_name").val()),
            password: $.trim($("#input_pass").val()),
            email: $.trim($("#input_email").val()),
            telefone1: $.trim($("#input_tel1").val()),
            telefone2: $.trim($("#input_tel2").val()),
            reg: $.trim($("#input_reg").val()),
            url: $.trim($("#input_url").val()),
            creci: $.trim($("#input_creci").val()),
        }, function(data, status) {
            closeWait($("#kt_content"));
            if (status == 'success') {
                toastr.success('Salvo com sucesso!');
                $("#modal_user").modal('hide');
                datatable.ajax.reload();
            } else {
                toastr.error('Ocorreu um erro ao tentar processar o banco de dados');
            }
        });
    });
});

var KTDatatablesDataSourceAjaxServer = function() {

    var initTable = function() {
        var table = $('#list_users');
        // list table
        datatable = table.DataTable({
            responsive: true,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            ajax: {
                url: '/users/get_user_list',
                type: 'POST',
                data: function(data, e) {
                    return $.extend({}, data, {
                        "_token": csrfToken,
                        "role": $("#sel_role").val()
                    });
                },
            },
            columns: [
                { data: 'username' },
                { data: 'tipo_name' },
                { data: 'nome' },
                { data: 'email' },
                { data: 'telefone1' },
                { data: 'telefone2' },
                { data: 'reg' },
                { data: 'url' },
                { data: 'creci' },
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
                                onclick="editUser(${full.id}, '${full.username}', ${full.role}, '${full.nome}', '${full.email}', '${full.telefone1}', '${full.telefone2}', '${full.reg}', '${full.url}', '${full.creci}')"
                                class="btn btn-sm btn-clean btn-icon btn-icon-md" 
                                title="Editar">
                                <i class="la la-pencil kt-font-info"></i>
                            </a>
                            <a href="#" 
                                onclick="deleteUser(${full.id})"
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

function editUser(id, username, role, nome, email, telefone1, telefone2, reg, url, creci) {
    cur_user_id = id;
    $("#modal_title").html('Editar usuário');
    $("#modal_user").modal('show');

    $("#user_name").html(nome);
    $("#input_username").val(username);
    $("#sel_role_modal").select2('destroy').val(role).select2().trigger('change');
    $("#input_name").val(nome);
    $("#input_pass").val('');
    $("#input_email").val(email);
    $("#input_tel1").val(telefone1);
    $("#input_tel2").val(telefone2);
    $("#input_reg").val(reg);
    $("#input_url").val(url);
    $("#input_creci").val(creci);
}

function deleteUser(id) {
    alertConfirm('Você tem certeza que quer deletar?', function() {
        showWait($("#kt_content"));

        $.post('/users/delete_user', {
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