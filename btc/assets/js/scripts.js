function useCouponCode() 
{
    $("#btnUseCouponCode").on("click", function() {
        var $this           = $(this); //submit button selector using ID
        var $caption        = $this.html();// We store the html content of the submit button
        var form            = "#useCouponCodeForm"; //defined form ID
        var formData        = $(form).serializeArray(); //serialize the form into array
        var route           = $(form).attr('action'); //get the route using attribute action

        // Ajax config
        $.ajax({
            type: "POST", //we are using POST method to submit the data to the server side
            url: route, // get the route value
            data: formData, // our serialized array data for server side
            beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                $this.attr('disabled', true).html("Processing...");
            },
            success: function (response) {//once the request successfully process to the server side it will return result here
               response = JSON.parse(response);

                // Check if there is no validation error
                if(!response.hasOwnProperty('has_error')) {

                    // We will display the result using alert
                    Swal.fire({
                      icon: 'success',
                      title: 'Success.',
                      text: response.response
                    });

                    // Reset form
                    resetForm(form);
                } else {
                    // We will display the result using alert
                    validationForm(form, response.errors);
                }
            },
            complete: function() {
                $this.attr('disabled', false).html($caption);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                // You can put something here if there is an error from submitted request
            }
        });
    });
}