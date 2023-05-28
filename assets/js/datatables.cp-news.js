$(document).ready(function() {
    $('#news_table').DataTable( {
      responsive: true
    });


    $('#genOpen').click(function(){
      $('#genModal').modal('toggle');
    });

    $(document).on('click', 'button[data-role=edit]',function(){
      var id = $(this).data('id');
      var enTitle = $('#'+id).children('td[data-target=enTitle]').text();
      var enDescription = $('#'+id).children('td[data-target=enDescription]').text();
      var enDate = $('#'+id).children('td[data-target=enDate]').text();

      $('#enId').val(id);
      $('#enTitle').val(enTitle);
      $('#enDescription').val(enDescription);
      $('#enDate').val(enDate);
      $('#editModal').modal('toggle');
    });

    $('#editBtn').click(function(){

      var editId = $('#enId').val();
      var title = $('#enTitle').val();
      var description = $('#enDescription').val();

      $.ajax({
        url    : 'index.php?page=cp_news',
        method : 'POST',
        data   : {
                'enTitle': title,
                'enDescription': description,
                'editId': editId,
                'editNews': 1
        },
        success : function(response) {
          if(response.match(/edit success/i)){
            $('#editModal').modal('hide');
            swal.fire("Success!", "News changes has been saved!", "success");
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
          confirmButtonText: 'Yes, delete news!'
      }).then(function(result) {
          if (result.value) {
            $.ajax({
              url    : 'index.php?page=cp_news',
              method : 'POST',
              data   : {
                      'deleteId': deleteId,
                      'deleteNews': 1
              },
              success : function(response) {
                if(response.match(/delete success/i)){
                  swal.fire("Success!", "News has been removed!", "success");
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

    $(document).on('click', '#genBtn',function(e){
      var newsData = $('#genForm').serialize();
      $.ajax({
        url    : 'index.php?page=cp_news',
        method : 'POST',
        data   : newsData,
        success : function(response) {
          if(response.match(/publish success/i)){
            $('#genModal').modal('hide');
            swal.fire("Success!", "News has been published!", "success");
            setTimeout(function() {
                location.reload();
            }, 2000);
          } else{
            $('#genModal').modal('hide');
            swal.fire("Failed!", "Failed to publish. Refreshing browser!", "error");
            setTimeout(function() {
                location.reload();
            }, 2000);
          }
        }
      });
    });
});
