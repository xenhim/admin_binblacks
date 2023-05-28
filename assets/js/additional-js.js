$('document').ready(function()
{
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

});
