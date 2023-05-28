$(document).ready(function() {
    $('#accounts_table').DataTable( {
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
      var eaType = $('#'+id).children('td[data-target=eaType]').text();
      var eaInfo = $('#'+id).children('td[data-target=eaInfo]').text();
      var eaPrice = $('#'+id).children('td[data-target=eaPrice]').text();
      var eaStatus = $('#'+id).children('td[data-target=eaStatus]').text();
      var eaUsername = $('#'+id).children('td[data-target=eaUsername]').text();
      var eaPassword = $('#'+id).children('td[data-target=eaPassword]').text();

      $('#eaId').val(id);
      $('#eaType').val(eaType);
      $('#eaInfo').val(eaInfo);
      $('#eaPrice').val(eaPrice);
      $('#eaStatus').val(eaStatus);
      $('#eaUsername').val(eaUsername);
      $('#eaPassword').val(eaPassword);
      $('#editModal').modal('toggle');
    });

    $('#editBtn').click(function(){

      var editId = $('#eaId').val();
      var type = $('#eaType').val();
      var info = $('#eaInfo').val();
      var price = $('#eaPrice').val();
      var status = $('#eaStatus').val();
      var username = $('#eaUsername').val();
      var password = $('#eaPassword').val();

      $.ajax({
        url    : 'index.php?page=cp_accounts',
        method : 'POST',
        data   : {
                'type': type,
                'info': info,
                'price': price,
                'username': username,
                'password': password,
                'editId': editId,
                'editAccount': 1
        },
        success : function(response) {
          if(response.match(/edit success/i)){
            $('#editModal').modal('hide');
            swal.fire("Success!", "Account changes has been saved!", "success");
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
          confirmButtonText: 'Yes, delete account!'
      }).then(function(result) {
          if (result.value) {
            $.ajax({
              url    : 'index.php?page=cp_accounts',
              method : 'POST',
              data   : {
                      'deleteId': deleteId,
                      'deleteAccount': 1
              },
              success : function(response) {
                if(response.match(/delete success/i)){
                  swal.fire("Success!", "Account log has been removed!", "success");
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
        url    : 'index.php?page=cp_accounts',
        method : 'POST',
        data   : fullzData,
        success : function(response) {
          if(response.match(/generate success/i)){
            swal.fire("Success!", "Account has been generated!", "success");
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
