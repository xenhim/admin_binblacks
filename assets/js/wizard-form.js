var KTWizardDemo = function () {
    var wizardEl;
    var formEl;
    var validator;
    var wizard;
    var initWizard = function () {
        wizard = new KTWizard('addFunds', {
            startStep: 1,
            clickableSteps: false
        });
        wizard.on('change', function(wizard) {
            KTUtil.scrollTop();
        });
    }

    var initValidation = function() {
        validator = formEl.validate({
            ignore: ":hidden",
            rules: {
                //= Client Information(step 1)
                amount: {
                    required: true,
                    min: 10
                },
            },

            // Validation messages
            messages: {
                amount: {
                    min: "Minimum topup is 10$. Please topup an amount greater than or equal to 10$"
                }
            },
            invalidHandler: function(event, validator) {
                KTUtil.scrollTop();
                swal.fire({
                    "title": "Error",
                    "text": "There are some errors in your submission.",
                    "type": "error",
                    "confirmButtonClass": "btn btn-secondary btn-danger m-btn m-btn--wide"
                });
            },
            submitHandler: function (form) {

            }
        });
    }

    return {
        init: function() {
            wizardEl = KTUtil.get('addFunds');
            formEl = $('#kt_form');
            initWizard();
            initValidation();
        }
    };
}();

jQuery(document).ready(function() {
    KTWizardDemo.init();
});
