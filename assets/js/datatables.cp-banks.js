$(document).ready(function() {
    $('#banks_table').DataTable( {
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
      var blStatus = $('#'+id).children('td[data-target=blStatus]').text();
      var blPrice = $('#'+id).children('td[data-target=blPrice]').text();
      var blType = $('#'+id).children('td[data-target=blType]').text();
      var blAbout = $('#'+id).children('td[data-target=blAbout]').text();
      var blFirstName = $('#'+id).children('td[data-target=blFirstName]').text();
      var blDob = $('#'+id).children('td[data-target=blDob]').text();
      var blPrintscreen = $('#'+id).children('td[data-target=blPrintscreen]').text();
      var blTelepin = $('#'+id).children('td[data-target=blTelepin]').text();
      var blLink = $('#'+id).children('td[data-target=blLink]').text();

      $('#blId').val(id);
      $('#blStatus').val(blStatus);
      $('#blPrice').val(blPrice);
      $('#blType').val(blType);
      $('#blAbout').val(blAbout);
      $('#blFirstName').val(blFirstName);
      $('#blDob').val(blDob);
      $('#blPrintscreen').val(blPrintscreen);
      $('#blTelepin').val(blTelepin);
      $('#blLink').val(blLink);
      $('#editModal').modal('toggle');
    });

    $('#editBtn').click(function(){

      var editId = $('#blId').val();
      var price = $('#blPrice').val();
      var accountType = $('#blType').val();
      var about = $('#blAbout').val();
      var firstName = $('#blFirstName').val();
      var dob = $('#blDob').val();
      var printscreen = $('#blPrintscreen').val();
      var telepin = $('#blTelepin').val();
      var link = $('#blLink').val();

      $.ajax({
        url    : 'index.php?page=cp_banks',
        method : 'POST',
        data   : {
                'price': price,
                'accountType': accountType,
                'about': about,
                'firstName': firstName,
                'dob': dob,
                'printscreen': printscreen,
                'telepin': telepin,
                'link': link,
                'editId': editId,
                'editBank': 1
        },
        success : function(response) {
          if(response.match(/edit success/i)){
            $('#editModal').modal('hide');
            swal.fire("Success!", "Bank log changes has been saved!", "success");
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
          confirmButtonText: 'Yes, delete bank!'
      }).then(function(result) {
          if (result.value) {
            $.ajax({
              url    : 'index.php?page=cp_banks',
              method : 'POST',
              data   : {
                      'deleteId': deleteId,
                      'deleteBank': 1
              },
              success : function(response) {
                if(response.match(/delete success/i)){
                  swal.fire("Success!", "Bank log has been removed!", "success");
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
        url    : 'index.php?page=cp_banks',
        method : 'POST',
        data   : fullzData,
        success : function(response) {
          if(response.match(/generate success/i)){
            swal.fire("Success!", "Bank has been generated!", "success");
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
