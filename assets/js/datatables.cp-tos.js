$(document).ready(function() {
    $('#tos_table').DataTable( {
      responsive: true
    });


    $('#tosAddBtn').click(function(){
      $('#genModal').modal('toggle');
    });

    $(document).on('click', 'button[data-role=edit]',function(){
      var id = $(this).data('id');
      var etTitle = $('#'+id).children('td[data-target=etTitle]').text();
      var etDescription = $('#'+id).children('td[data-target=etDescription]').text();

      $('#etId').val(id);
      $('#etTitle').val(etTitle);
      $('#etDescription').val(etDescription);
      $('#editModal').modal('toggle');
    });

    $('#editBtn').click(function(){

      var editId = $('#etId').val();
      var title = $('#etTitle').val();
      var description = $('#etDescription').val();

      $.ajax({
        url    : 'index.php?page=cp_tos',
        method : 'POST',
        data   : {
                'title': title,
                'description': description,
                'editId': editId,
                'editTos': 1
        },
        success : function(response) {
          if(response.match(/edit success/i)){
            $('#editModal').modal('hide');
            swal.fire("Success!", "Tos changes has been saved!", "success");
            setTimeout(function() {
                location.reload();
            }, 1700);
          } else{
            $('#editModal').modal('hide');
            swal.fire("Failed!", "Failed to update. Refreshing browser!", "error");
            setTimeout(function() {
                location.reload();
            }, 1700);
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
          confirmButtonText: 'Yes, delete tos!'
      }).then(function(result) {
          if (result.value) {
            $.ajax({
              url    : 'index.php?page=cp_tos',
              method : 'POST',
              data   : {
                      'deleteId': deleteId,
                      'deleteTos': 1
              },
              success : function(response) {
                if(response.match(/delete success/i)){
                  swal.fire("Success!", "Tos has been removed!", "success");
                  setTimeout(function() {
                      location.reload();
                  }, 1700);
                } else{
                  swal.fire("Failed!", "Failed to delete. Refreshing browser!", "error");
                  setTimeout(function() {
                      location.reload();
                  }, 1700);
                }
              }
            });
          }
      });
    });

    $(document).on('click', '#genBtn',function(e){
      var tosData = $('#genForm').serialize();
      $.ajax({
        url    : 'index.php?page=cp_tos',
        method : 'POST',
        data   : tosData,
        success : function(response) {
          if(response.match(/publish success/i)){
            $('#genModal').modal('hide');
            swal.fire("Success!", "Tos has been published!", "success");
            setTimeout(function() {
                location.reload();
            }, 1700);
          } else{
            $('#genModal').modal('hide');
            swal.fire("Failed!", "Failed to publish. Refreshing browser!", "error");
            setTimeout(function() {
                location.reload();
            }, 1700);
          }
        }
      });
    });
});
