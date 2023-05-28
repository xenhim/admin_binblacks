$('document').ready(function()
{
  $(".kt-form").validate({
    submitHandler: submitForm
       });

    function submitForm()
    {
    var data = $(".kt-form").serialize();
     $.ajax({

     type : 'POST',
     url  : 'user.php?page=login',
     data : data,
     beforeSend: function()
     {
       $('.freeze-ui').show();
     },
     success : function(response)
        {
       if(response.match(/-captchaError-/i)){
         $('.freeze-ui').hide();
         $("#captchaError").removeAttr('hidden');
         $('#captchaError').show();
       }
       else if(response.match(/invalid response/i)) {
         $('.freeze-ui').hide();
         $("#errorModal").removeAttr('hidden');
         $('#errorModal').show();
       }
       else if(response.match(/continue response/i)) {
         setTimeout(function(){
           location.href="index.php?page=home"} , 1000);
       }
       else{
         $('.freeze-ui').hide();
         $("#captchaError").removeAttr('hidden');
         $('#captchaError').show();
       }
      }
     });
    return false;
  }

});

(function() {

$('form input').keyup(function() {
    var empty = false;
    $('form input').each(function() {
        if ($(this).val() == '') {
            empty = true;
        }
    });
    if (empty) {
        $('#authButton').attr('disabled', 'disabled');
    } else {
        $('form').removeClass('ng-invalid').addClass('ng-valid');
        $('#authButton').removeAttr('disabled');
    }
});

  grecaptcha.ready(function() {
      grecaptcha.execute('6LeRA6wUAAAAABX67-bwdP4Qd5shjur6RlhHlv4_', {action: 'login'}).then(function(token) {
         document.getElementById("g-recaptcha-response").value = token;
      });
  });

  $("#dismissModal").click(function(){
    $("#errorModal").fadeOut();
  });
  $("#captchaDismiss").click(function(){
    $("#captchaError").fadeOut();
  });
})()
