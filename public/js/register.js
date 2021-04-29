"use strict";

// Class definition
var KTWizard1 = function () {
	// Base elements
	var wizardEl;
	var formEl;
	var validator;
	var wizard;

	// Private functions
	var initWizard = function () {
		// Initialize form wizard
		wizard = new KTWizard('kt_wizard_v1', {
			startStep: 1, // initial active step number
			clickableSteps: true  // allow step clicking
		});

		// Validation before going to next page
		wizard.on('beforeNext', function(wizardObj) {
			if (validator.form() !== true) {
				wizardObj.stop();  // don't go to the next step
			}
		});

		wizard.on('beforePrev', function(wizardObj) {
			if (validator.form() !== true) {
				wizardObj.stop();  // don't go to the next step
			}
		});

		// Change event
		wizard.on('change', function(wizard) {
			setTimeout(function() {
				KTUtil.scrollTop();
			}, 500);
		});
	}

	var initValidation = function() {
		
		validator = formEl.validate({
			// Validate only visible fields
			ignore: ":hidden",

			// Validation rules
			rules: {
				password_confirmation:{
                    required: true,
                    equalTo: "#password"
                },
                phone:{
                    required: true,
                    digits: true
                },
                bizphone:{
                    digits: true
                },
                expmonth:{
                    min: 1,
                    max:12
                },
                expyear:{
                    min: 20,
					max: 2100
                },
                cvv:{
                    min: 100,
					max: 9999
                },
				cardnumber: {
					digits: true,
					minlength: 15,
					maxlength: 16
				}
			},

			// Display error
			invalidHandler: function(event, validator) {
				KTUtil.scrollTop();

				swal.fire({
					"title": "",
					"html": "There are some errors in your submission.<br> Please correct them.",
					"type": "error",
					"confirmButtonClass": "btn btn-secondary"
				});
			},

			// Submit valid form
			submitHandler: function (form) {

			}
		});
	}

	var initSubmit = function() {
		var btn = formEl.find('[data-ktwizard-type="action-submit"]');

		btn.on('click', function(e) {
			e.preventDefault();

			if (validator.form()) {
				// See: src\js\framework\base\app.js
				KTApp.progress(btn);

				KTApp.block(formEl, {
					type: 'loader',
					state: 'brand',
					message: 'Please wait...',
					opacity: 0.2,
                	size: 'lg'
				});
	
				// See: http://malsup.com/jquery/form/#ajaxSubmit
				formEl.ajaxSubmit({
					success: function(res) {
						console.log(res);
						KTApp.unprogress(btn);
						KTApp.unblock(formEl);
						var status = res.status;
						var id = res.id;
						if (id) {
							alertSuccess(`Congratulations! You have been successfully signed up. 
								A welcome email has been sent to your email address.`,
								"Now You Are a Member of bTru Leads CRM".toUpperCase(),
								function(result) {
									if (result.value) {
										location.href = '/login';
									} else if (result.dismiss === 'cancel') {
									}
							});
						} else if (status == 'error') {
							var errMsg = '';
							if (res.msg)
								errMsg = res.msg;

							alertError(errMsg, "ERROR");
						}

					},
					error: function (res) {
						KTApp.unprogress(btn);
						KTApp.unblock(formEl);
						console.log(res);

						var errMsg = '';
						var errors = res.responseJSON.errors;
						if (errors) {
							for (var key in errors) {
								var val = errors[key];
								errMsg += val[0] + "<br>";
							}
						}
						alertError(errMsg, "ERROR");
						// swal.fire({
						// 	title: "ERROR",
						// 	buttonsStyling: false,
						//
						// 	html: errMsg,
						// 	// html: "Your request could not be completed because there was some error while processing your form.",
						// 	type: "error",
						//
						// 	confirmButtonText: "OK",
						// 	confirmButtonClass: "btn btn-sm btn-bold btn-brand",
						//
						// 	showCancelButton: false,
						// 	cancelButtonText: "No, cancel",
						// 	cancelButtonClass: "btn btn-sm btn-bold btn-default"
						// });

					}
				});
			}
		});
	}

	return {
		// public functions
		init: function() {
			wizardEl = KTUtil.get('kt_wizard_v1');
			formEl = $('#kt_form');
			
			initWizard();
			initValidation();
			initSubmit();
		}
	};
}();

jQuery(document).ready(function() {
    KTWizard1.init();
    $('.kt-pricing-2__item').click(function(){
        $(this).parent().find('.kt-pricing-2__item').removeClass('active_status');
        $(this).addClass('active_status');
        $('#plan_code').val($(this).index()+1);
   });
   $('.pay').click(function(){
        $('.pay').removeClass('active');
        $(this).addClass('active');
		$('.payment_info').hide();
		console.log($(this).index());
        var nm = $(this).index();
        if(nm==2){
            $('#card_payment').show();
        }
   });
   $('.mem_btn').click(function(){
        $('#mem_ym').val($(this).index());
   });
});
