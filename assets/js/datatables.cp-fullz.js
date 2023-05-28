$(document).ready(function() {
    $('#fullz_table').DataTable( {
      responsive: true
    });

    $('#showForm').click(function(){
      $('#liShow').fadeOut();
      $('#liHide').fadeIn();
      $('#liAdd').fadeIn();
      $('#liGenerate').fadeIn();
      $('.group').fadeIn(500);
    });

    $('.formGroup').multifield({
        section: '.group',
        btnAdd:'#add',
        btnRemove:'.btnRemove',
    });

    $('#hideForm').click(function(){
      $('#liShow').fadeIn();
      $('#liHide').fadeOut();
      $('#liAdd').fadeOut();
      $('#liGenerate').fadeOut();
      $('.group').fadeOut(500);
    });

    $(document).on('click', 'button[data-role=edit]',function(){
      var id = $(this).data('id');
      var flStatus = $('#'+id).children('td[data-target=flStatus]').text();
      var flPrice = $('#'+id).children('td[data-target=flPrice]').text();
      var flCategory = $('#'+id).children('td[data-target=flCategory]').text();
      var flFirstName = $('#'+id).children('td[data-target=flFirstName]').text();
      var flLastName = $('#'+id).children('td[data-target=flLastName]').text();
      var flMmn = $('#'+id).children('td[data-target=flMmn]').text();
      var flDob = $('#'+id).children('td[data-target=flDob]').text();
      var flTelephone = $('#'+id).children('td[data-target=flTelephone]').text();
      var flAddress = $('#'+id).children('td[data-target=flAddress]').text();
      var flPostcode = $('#'+id).children('td[data-target=flPostcode]').text();
      var flCardHolder = $('#'+id).children('td[data-target=flCardHolder]').text();
      var flCardNumber = $('#'+id).children('td[data-target=flCardNumber]').text();
      var flCardBin = $('#'+id).children('td[data-target=flCardBin]').text();
      var flCardExp = $('#'+id).children('td[data-target=flCardExp]').text();
      var flCcv = $('#'+id).children('td[data-target=flCcv]').text();
      var flAccountNo = $('#'+id).children('td[data-target=flAccountNo]').text();
      var flUsername = $('#'+id).children('td[data-target=flUsername]').text();
      var flPassword = $('#'+id).children('td[data-target=flPassword]').text();
      var flTypeAcc = $('#'+id).children('td[data-target=flTypeAcc]').text();
      var flUserAgent = $('#'+id).children('td[data-target=flUserAgent]').text();
      var flEmail = $('#'+id).children('td[data-target=flEmail]').text();
      var flSortcode = $('#'+id).children('td[data-target=flSortcode]').text();
      var flVictimIp = $('#'+id).children('td[data-target=flVictimIp]').text();

      $('#flId').val(id);
      $('#flStatus').val(flStatus);
      $('#flPrice').val(flPrice);
      $('#flCategory').val(flCategory);
      $('#flFirstName').val(flFirstName);
      $('#flLastName').val(flLastName);
      $('#flMmn').val(flMmn);
      $('#flDob').val(flDob);
      $('#flTelephone').val(flTelephone);
      $('#flAddress').val(flAddress);
      $('#flPostcode').val(flPostcode);
      $('#flCardHolder').val(flCardHolder);
      $('#flCardNumber').val(flCardNumber);
      $('#flCardBin').val(flCardBin);
      $('#flCardExp').val(flCardExp);
      $('#flCcv').val(flCcv);
      $('#flAccountNo').val(flAccountNo);
      $('#flUsername').val(flUsername);
      $('#flPassword').val(flPassword);
      $('#flTypeAcc').val(flTypeAcc);
      $('#flUserAgent').val(flUserAgent);
      $('#flEmail').val(flEmail);
      $('#flSortcode').val(flSortcode);
      $('#flVictimIp').val(flVictimIp);
      $('#editModal').modal('toggle');
    });

    $('#editBtn').click(function(){

      var price = $('#flPrice').val();
      var firstname = $('#flFirstName').val();
      var lastname = $('#flLastName').val();
      var mmn = $('#flMmn').val();
      var dob = $('#flDob').val();
      var telephone = $('#flTelephone').val();
      var address = $('#flAddress').val();
      var postcode = $('#flPostcode').val();
      var cardholdername = $('#flCardHolder').val();
      var cardnumber = $('#flCardNumber').val();
      var cardbin = $('#flCardBin').val();
      var cardexp = $('#flCardExp').val();
      var ccv = $('#flCcv').val();
      var accountno = $('#flAccountNo').val();
      var username = $('#flUsername').val();
      var password = $('#flPassword').val();
      var typeacc = $('#flTypeAcc').val();
      var useragent = $('#flUserAgent').val();
      var email = $('#flEmail').val();
      var sortcode = $('#flSortcode').val();
      var victimip = $('#flVictimIp').val();
      var editId = $('#flId').val();

      $.ajax({
        url    : 'index.php?page=cp_fullz',
        method : 'POST',
        data   : {
                'price': price,
                'firstname': firstname,
                'lastname': lastname,
                'mmn': mmn,
                'dob': dob,
                'telephone': telephone,
                'address': address,
                'postcode': postcode,
                'cardholdername': cardholdername,
                'cardnumber': cardnumber,
                'cardbin': cardbin,
                'cardexp': cardexp,
                'ccv': ccv,
                'accountno': accountno,
                'username': username,
                'password': password,
                'typeacc': typeacc,
                'useragent': useragent,
                'email': email,
                'sortcode': sortcode,
                'victimip': victimip,
                'editId': editId,
                'editFullz': 1
        },
        success : function(response) {
          if(response.match(/edit success/i)){
            $('#editModal').modal('hide');
            swal.fire("Success!", "Fullz changes has been saved!", "success");
            setTimeout(function() {
                location.reload();
            }, 2000);
          } else{
            $('#editModal').modal('hide');
            swal.fire("Failed!", "Failed to update. Refreshing browser!", "error");
            setTimeout(function() {
                location.reload();
            }, 2000);
          }
        }
      });

    });

    $(document).on('click', 'button[data-role=delete]',function(e){
      var id = $(this).data('id');
      $('#deleteId').val(id);
      var deleteId = $('#deleteId').val();
      swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete fullz!'
      }).then(function(result) {
          if (result.value) {
            $.ajax({
              url    : 'index.php?page=cp_fullz',
              method : 'POST',
              data   : {
                      'deleteId': deleteId,
                      'deleteFullz': 1
              },
              success : function(response) {
                if(response.match(/delete success/i)){
                  swal.fire("Success!", "Fullz records has been removed!", "success");
                  setTimeout(function() {
                      location.reload();
                  }, 2000);
                } else{
                  swal.fire("Failed!", "Failed to delete. Refreshing browser!", "error");
                  setTimeout(function() {
                      location.reload();
                  }, 2000);
                }
              }
            });
          }
      });
    });

    $(document).on('click', '#generate',function(e){
      var fullzData = $('.formGroup').serialize();
      $.ajax({
        url    : 'index.php?page=cp_fullz',
        method : 'POST',
        data   : fullzData,
        success : function(response) {
          if(response.match(/generate success/i)){
            swal.fire("Success!", "Fullz has been generated!", "success");
            setTimeout(function() {
                location.reload();
            }, 2000);
          } else{
            swal.fire("Failed!", "Failed to generate. Refreshing browser!", "error");
            setTimeout(function() {
                location.reload();
            }, 2000);
          }
        }
      });
    });
});
