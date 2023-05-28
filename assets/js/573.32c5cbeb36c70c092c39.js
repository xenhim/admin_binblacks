$('document').ready(function()
{

  $('#authId').keyup(function(e){

    var authId = $("#authId").val();

    if(authId.length  == '') {
      $('.minUser').hide();
      $('.maxUser').hide();
      $('.userField').show();
    } else if(authId.length < 5) {
      $('.minUser').show();
      $('.maxUser').hide();
      $('.userField').hide();
    } else if(authId.length > 20) {
      $('.minUser').hide();
      $('.maxUser').show();
      $('.userField').hide();
    } else {
      $('.minUser').hide();
      $('.maxUser').hide();
      $('.userField').hide();
    }
  });

  function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
  }

    $('#emailId').keyup(function(e){

      var emailId = $("#emailId").val();

      if(emailId.length  == '') {
        $('.invalidEmail').hide();
        $('.emailField').show();
      } else {
        if(validateEmail(emailId)) {
          $('.invalidEmail').hide();
          $('.emailField').hide();
        }
        else {
          $('.emailField').hide();
          $('.invalidEmail').show();
        }
      }
    });

    $('#authPass').keyup(function(e){

      var authPass = $("#authPass").val();

      if(authPass.length  == '') {
        $('.minPass').hide();
        $('.maxPass').hide();
        $('.passField').show();
      } else if(authId.length < 5) {
        $('.minPass').show();
        $('.maxPass').hide();
        $('.passField').hide();
      } else if(authId.length > 20) {
        $('.minPass').hide();
        $('.maxPass').show();
        $('.passField').hide();
      } else {
        $('.minPass').hide();
        $('.maxPass').hide();
        $('.passField').hide();
      }
    });

    $('#repeatPass').keyup(function(e){

      var repeatPass = $("#repeatPass").val();
      var passField = $("#authPass").val();

      if(repeatPass.length  == '') {
        $('.passMismatch').hide();
        $('.repeatField').show();
      } else if(repeatPass == passField) {
        $('.passMismatch').hide();
        $('.repeatField').hide();
        $('form').removeClass('ng-invalid').addClass('ng-valid');
        $('#submitButton').removeAttr('disabled');
      } else {
        $('.repeatField').hide();
        $('.passMismatch').show();
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
     url  : 'user.php?page=register',
     data : data,
     beforeSend: function()
     {
       $('.freeze-ui').show();
     },
     success :  function(response)
        {
       if(response.match(/successful registration/i)){
         $('.freeze-ui').hide();
         $("#successModal").removeAttr('hidden');
         $('#successModal').show();
       }
       else if(response.match(/-captchaError-/i)) {
         $('.freeze-ui').hide();
         $("#captchaError").removeAttr('hidden');
         $('#captchaError').show();
       }
       else if(response.match(/fail to register/i)) {
         $('.freeze-ui').hide();
         $("#userModal").removeAttr('hidden');
         $('#userModal').show();
       }
       else{
         $('.freeze-ui').hide();
         $("#failedModal").removeAttr('hidden');
         $('#failedModal').show();
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
  $("#dismissFail").click(function(){
    $("#failedModal").fadeOut();
  });
  $("#dismissUser").click(function(){
    $("#userModal").fadeOut();
  });
})()
