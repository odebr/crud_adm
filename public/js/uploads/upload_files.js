"use strict";

var datatable;
var contrato_file = null;
var laudo_file = null;

$(document).ready(function() {
    // ----------------------------------------------------------------------- //
    // init upload contrato button
    $("#btn_upload_contrato").click(function() {
        if (contrato_file == null) {
            toastr.error('Selecione o arquivo por favor');
            return;
        }

        let data = new FormData();
        data.append('file', contrato_file);
        data.append('id_imovel', id_imovel);

        showWait($("#kt_content"));
        $.ajax({
            url: '/upload/upload_contrato',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            dataType: 'json',
            contentType: false,
            processData: false,
            data: data,
            success: function(res) {
                toastr.success('Carregado com sucesso!');
                closeWait($("#kt_content"));
            }
        });
    });

    // init upload laudo button
    $("#btn_upload_laudo").click(function() {
        if (laudo_file == null) {
            toastr.error('Selecione o arquivo por favor');
            return;
        }

        let data = new FormData();
        data.append('file', laudo_file);
        data.append('id_imovel', id_imovel);

        showWait($("#kt_content"));
        $.ajax({
            url: '/upload/upload_laudo',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            dataType: 'json',
            contentType: false,
            processData: false,
            data: data,
            success: function(res) {
                toastr.success('Carregado com sucesso!');
                closeWait($("#kt_content"));
            }
        });
    });

    // init select contrato file
    $("#sel_contrato_file").change(function(event) {
        contrato_file = event.target.files[0];
    });

    // init select laudo file
    $("#sel_laudo_file").change(function(event) {
        laudo_file = event.target.files[0];
    });
});