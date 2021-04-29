"use strict";

var flag_type = true;
var flag_date = true;
var flag_val = true;
var files = [];

$(document).ready(function() {
    // init select imovel
    $("#sel_imovel").select2().change(function() {
        if ($(this).val() != 0) {
            $("h4.m-title.m-blank-title").hide();

            let origin_option = $(this).find('option[value=' + $(this).val() + ']');
            let proprietario = origin_option.attr('proprietario');
            let inquilino = origin_option.attr('inquilino');
            let imobiliaria = origin_option.attr('imobiliaria');

            if (proprietario) {
                $("h4.m-title.m-detail-title[for=proprietario]").css('display', 'inline-block');
                $("span.m-span-imovel-info[for=proprietario]").html(proprietario).css('display', 'inline');
            }

            if (inquilino) {
                $("h4.m-title.m-detail-title[for=inquilino]").css('display', 'inline-block');
                $("span.m-span-imovel-info[for=inquilino]").html(inquilino).css('display', 'inline');
            }

            // if (imobiliaria) {
            //     $("h4.m-title.m-detail-title[for=imobiliaria]").css('display', 'inline-block');
            //     $("span.m-span-imovel-info[for=imobiliaria]").html(imobiliaria).css('display', 'inline');
            // }
        } else {
            $("h4.m-title.m-blank-title").show();
            $("h4.m-title.m-detail-title").hide();
            $("span.m-span-imovel-info").hide();
        }
    });

    // init insert button
    $("#btn_insert").click(function() {
        if ($("#sel_imovel").val() == 0) {
            toastr.error('Selecione imóvel por favor');
            return;
        }

        m_init();

        $("tbody tr:not(#clone_tr)").remove();
        for (let i = 0; i < $("#sel_total_num").val(); i++) {
            append_tr(i);
        }
    });

    // init save button
    $("#btn_save").click(function() {
        if ($("#sel_imovel").val() == 0) {
            toastr.error('Selecione imóvel por favor');
            return;
        }

        let data = new FormData();
        $("tbody tr:not(#clone_tr)").each(function() {
            let idx = $(this).attr('for');
            let file = null;

            if (files[idx] != undefined && files[idx] != null) {
                file = files[idx];
            }

            data.append('type_' + idx, $(".sel_type", $(this)).val());
            data.append('date_' + idx, $(".sel_date", $(this)).val());
            data.append('value_' + idx, $(".input_val", $(this)).val());
            data.append('file_' + idx, file);
        });

        data.append('imovel', $("#sel_imovel").val());

        showWait($("#kt_content"));
        $.ajax({
            url: '/payments/save_payment',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            dataType: 'json',
            contentType: false,
            processData: false,
            data: data,
            success: function(res) {
                toastr.success('Salvo com sucesso!');
                m_init();
                closeWait($("#kt_content"));
            }
        });
    });

    // first clone 12 tr
    for (let i = 0; i < 12; i++) {
        append_tr(i);
    }
});

function append_tr(i) {
    let clone_tr = $("tr#clone_tr").clone();

    // set values
    $("th", clone_tr).html(i + 1);
    clone_tr.removeAttr("id");
    clone_tr.css("display", "table-row");
    clone_tr.attr('for', i);

    // set event handler
    $(".sel_type", clone_tr).select2();

    $('.sel_date', clone_tr).datepicker({
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

        if (flag_date == true) {
            flag_date = false;
            var cur_val = $(this).val();
            var cur_idx = parseInt($(this).parents('tr').attr('for'));
            var year = parseInt(cur_val.substr(0, 4));
            var month = parseInt(cur_val.substr(5, 2));
            var day = cur_val.substr(8, 2);
            $(`tbody tr:not(#clone_tr):not(tr[for=${cur_idx}]) .sel_date`).each(function() {
                let val = '';
                let idx = parseInt($(this).parents('tr').attr('for'));

                let buff_year = (month + idx - cur_idx - 1) / 12;
                let buff_month = parseInt((month + idx - cur_idx) % 12);

                buff_year = year + Math.floor(buff_year);

                if (buff_month == 0) {
                    buff_month = 12;
                } else if (buff_month < 0) {
                    buff_month += 12;
                }

                val = `${buff_year}-${formatDateNumber(buff_month)}-${day}`;

                $(this).datepicker('setDate', val);
            });
        }
    });

    $(".input_val").keyup(function() {
        if (flag_val == true) {
            var cur_idx = parseInt($(this).parents('tr').attr('for'));
            $(`tbody tr:not(#clone_tr):not(tr[for=${cur_idx}]) .input_val`).val($(this).val());
        }
    }).blur(function() {
        flag_val = false;
    });

    $(".sel_type").change(function() {
        if (flag_type == true) {
            flag_type = false;
            var cur_idx = parseInt($(this).parents('tr').attr('for'));
            $(`tbody tr:not(#clone_tr):not(tr[for=${cur_idx}]) .sel_type`).select2('destroy').val($(this).val()).select2();
        }
    });

    $(".sel_file").change(function(event) {
        var cur_idx = parseInt($(this).parents('tr').attr('for'));
        files[cur_idx] = event.target.files[0];
    });

    $("#tbody_payment").append(clone_tr);
}

function m_init() {
    // initialize
    flag_type = true;
    flag_date = true;
    flag_val = true;

    files = [];
}