// JavaScript Document

$(document).ready(function() {
var maxLength = 160;
$('#pretext').keyup(function () {
var txt = $(this).val();
$('.txtspeech').html(txt);
 var textlen = maxLength - $(this).val().length;
$('#count').text(textlen);
});
});


$(document).ready(function(){
    $("#choose_who").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue){
                $(".boxy").not("." + optionValue).hide();
                $("." + optionValue).show();
            } else{
                $(".boxy").hide();
            }
        });
    }).change();
});



$(function () {
  $('.iconselect4').change(function () {
    $('.box4').hide();
    $('#' + $(this).val()).show();
  });
});


    $(function () {
        $("#schedule").click(function () {
            if ($(this).is(":checked")) {
                $("#set-schedule").show();
            } else {
                $("#set-schedule").hide();
            }
        });
    });

    $(function () {
        $("#sendwithlink").click(function () {
            if ($(this).is(":checked")) {
                $("#chooselink").show();
            } else {
                $("#chooselink").hide();
            }
        });
    });

                            $(function() {

                                $('#leads_list').change(function(){
                                    $('.campaign').hide();
                                    $('#' + $(this).val()).show();
                                });

                            }); 


                            $(function() { 

                                $('#contact_list').change(function(){
                                    $('.lists').hide();
                                    $('#' + $(this).val()).show();
                                });

                            }); 

								$(function() {
											$('.iconselect').change(function(){
												$('.box').hide();
												$('#' + $(this).val()).show();
											});
										});	