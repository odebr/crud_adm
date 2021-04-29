"use strict";

var datatable;

$(document).ready(function() {
    // ----------------------------------------------------------------------- //
    // init datatable
    KTDatatablesDataSourceAjaxServer.init();
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
                { data: 'id' },
                { data: 'endereco_resumido' },
                { data: 'inquilino_name' },
                { data: 'proprietario_name' },
                { data: 'imobiliaria_name' },
                { data: 'data_contrato' },
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
                            <a href="/upload/upload_files/${full.id}"
                                class="btn btn-sm btn-clean btn-icon btn-icon-md" 
                                title="Subir arquivo">
                                <i class="la la-cloud-upload kt-font-success"></i>
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