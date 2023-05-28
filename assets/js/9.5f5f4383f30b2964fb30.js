$('document').ready(function()
{
  $("#kt_login_form").validate({
    submitHandler: submitForm
       });

    function submitForm()
    {
    var username = $("#username").val();
    var password = $("#password").val();
    var recaptcha = $("#g-recaptcha-response").val();

     $.ajax({

     type : 'POST',
     url  : 'user.php?page=admin',
     data   : {
             'username': username,
             'password': password,
             'g-recaptcha-response': recaptcha,
             'adminLogin': 1
     },
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
         setTimeout(function(){location.href="index.php?page=cp_dashboard"} , 1000);
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
