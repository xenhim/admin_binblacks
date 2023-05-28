$('document').ready(function()
{
  $("#editButton").click(function(){
    $("#editButton").hide();
    $("#invisible").hide();
    $("#updateButton").fadeIn();
    $("#cancelButton").fadeIn();
    $("#updateEmail").removeAttr('disabled');
    $("#updatePass").removeAttr('disabled');
    $("#validatePass").removeAttr('disabled');
    $("#updatePass").val('');
    $("#validatePass").val('');
  });

  $("#cancelButton").click(function(){
    $("#updateButton").hide();
    $("#cancelButton").hide();
    $("#invisible").show();
    $("#editButton").fadeIn();
    $("#updateEmail").attr('disabled', true);
    $("#updatePass").attr('disabled', true);
    $("#validatePass").attr('disabled', true);
    $("#updatePass").val("******");
    $("#validatePass").val("******");
    if($("#updateSuccess").is(":visible")) {
      $("#updateSuccess").fadeOut();
    }
    if($("#emailUsed").is(":visible")) {
      $("#emailUsed").fadeOut();
    }
    if($("#updateFail").is(":visible")) {
      $("#updateFail").fadeOut();
    }
    $('#updateButton').val("Update");
    $('#updateButton').attr("disabled", false);
    $('#updateButton').removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light");
    $("#updateEmail").removeClass('is-valid');
    $("#updatePass").removeClass('is-valid');
    $("#validatePass").removeClass('is-valid');
    $("#updateEmail").removeClass('is-invalid');
    $("#updatePass").removeClass('is-invalid');
    $("#validatePass").removeClass('is-invalid');

  });


  function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
  }

  $('#updateEmail').keyup(function(e){

    var updateEmail = $("#updateEmail").val();

    if(updateEmail.length  == '') {
      $("#updateEmail").addClass('is-invalid');
    } else {
      if(validateEmail(updateEmail)) {
        $("#updateEmail").removeClass('is-invalid');
        $("#updateEmail").addClass('is-valid');
      }
      else {
        $("#updateEmail").addClass('is-invalid');
      }
    }
  });

  $('#updatePass').keyup(function(e){

    var passForm = $("#updatePass").val();

    if(passForm.length  == '') {
      $("#updatePass").addClass('is-invalid');
    } else if(passForm.length < 5) {
      $("#updatePass").addClass('is-invalid');
    } else if(passForm.length > 20) {
      $("#updatePass").addClass('is-invalid');
    } else {
      $("#updatePass").removeClass('is-invalid');
      $("#updatePass").addClass('is-valid');
    }
  });

  $('#validatePass').keyup(function(e){

    var validateForm = $("#validatePass").val();
    var passwordForm = $("#updatePass").val();

    if(validateForm.length  == '') {
      $("#validatePass").addClass('is-invalid');
    } else if(validateForm == passwordForm) {
      $("#validatePass").removeClass('is-invalid');
      $("#validatePass").addClass('is-valid');
      $('#updateButton').removeAttr('disabled');
    } else {
      $("#validatePass").addClass('is-invalid');
    }
  });

  $("#updateButton").click(function(){
    $("#profileForm").validate({
      submitHandler: submitForm
         });

      function submitForm()
      {
      var data = $("#profileForm").serialize();
       $.ajax({

       type : 'POST',
       url  : 'index.php?page=adminprofile',
       data : data,
       beforeSend: function()
       {
         if($("#updateSuccess").is(":visible")) {
           $("#updateSuccess").fadeOut();
         }
         if($("#emailUsed").is(":visible")) {
           $("#emailUsed").fadeOut();
         }
         if($("#updateFail").is(":visible")) {
           $("#updateFail").fadeOut();
         }
         $('#updateButton').val('');
         $('#updateButton').attr("disabled", true);
         $('#updateButton').addClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light");
       },
       success :  function(response)
          {
         if(response.match(/successfully updated/i)){
           $('#updateSuccess').fadeIn();
           $("#updateButton").hide();
           $("#cancelButton").hide();
           $("#invisible").show();
           $("#editButton").fadeIn();
           $("#updateEmail").attr('disabled', true);
           $("#updatePass").attr('disabled', true);
           $("#validatePass").attr('disabled', true);
           $('#updateButton').val("Update");
           $('#updateButton').attr("disabled", false);
           $('#updateButton').removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light");
           $("#updateEmail").removeClass('is-valid');
           $("#updatePass").removeClass('is-valid');
           $("#validatePass").removeClass('is-valid');
         }
         else if(response.match(/email already used/i)) {
           $('#emailUsed').fadeIn();
           $('#updateButton').val("Update");
           $('#updateButton').attr("disabled", false);
           $('#updateButton').removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light");
         }
         else{
           $('#updateFail').fadeIn();
           $('#updateButton').val("Update");
           $('#updateButton').attr("disabled", false);
           $('#updateButton').removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light");
         }
         }
       });
      return false;
    }
  });

});
