$('document').ready(function()
{

  function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
  }

    $('#emailId').keyup(function(e){

      var emailId = $("#emailId").val();

      if(emailId.length  == '') {
        $('.invalidEmail').hide();
        $('.fieldRequired').show();
      } else {
        if(validateEmail(emailId)) {
          $('.invalidEmail').hide();
          $('.fieldRequired').hide();
          $('form').removeClass('ng-invalid').addClass('ng-valid');
          $('#submitButton').removeAttr('disabled');
        }
        else {
          $('.fieldRequired').hide();
          $('.invalidEmail').show();
        }
      }
    });

  $(".kt-form").validate({
    submitHandler: submitForm
       });

    function submitForm()
    {
    var data = $(".kt-form").serialize();
     $.ajax({

     type : 'POST',
     url  : 'user.php?page=forgot',
     data : data,
     beforeSend: function()
     {
       $('.freeze-ui').show();
     },
     success :  function(response)
        {
       if(response.match(/successfully sent/i)){
         $('.freeze-ui').hide();
         $("#successModal").removeAttr('hidden');
         $('#successModal').show();
       }
       else if(response.match(/-captchaError-/i)) {
         $('.freeze-ui').hide();
         $("#captchaError").removeAttr('hidden');
         $('#captchaError').show();
       }
       else{
         $('.freeze-ui').hide();
         $("#successModal").removeAttr('hidden');
         $('#successModal').show();
       }
       }
     });
    return false;
  }

});

(function() {
  grecaptcha.ready(function() {
      grecaptcha.execute('6LeRA6wUAAAAABX67-bwdP4Qd5shjur6RlhHlv4_', {action: 'login'}).then(function(token) {
         document.getElementById("g-recaptcha-response").value = token;
      });
  });

  $("#dismissModal").click(function(){
    $("#successModal").fadeOut();
  });
  $("#captchaDismiss").click(function(){
    $("#captchaError").fadeOut();
  });
})()
