$(document).ready(function() {
    $('#tickets_table').DataTable( {
      responsive: true
    });

    $(document).on('click', 'button[data-role=reply]',function(){

      var id = $(this).data('id');

      $.ajax({
        url    : 'index.php?page=cp_tickets',
        method : 'POST',
        data   : {
                'id': id,
                'replyTicket': 1
        },
        success : function(response) {
          if(response.match(/ticket reply redirect/i)){
            setTimeout(function(){location.href="index.php?page=cp_replyticket&ti=" + id} , 1000);
          } else{
            swal.fire("Ticket Error!", "Refreshing your browser in 3 seconds", "error");
            setTimeout(function() {
                location.reload();
            }, 2000);
          }
        }
      });
    });

    $(document).on('click', 'button[data-role=solved]',function(e){
      var id = $(this).data('id');
      $('#solvedId').val(id);
      var solvedId = $('#solvedId').val();
      swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, mark as solved!'
      }).then(function(result) {
          if (result.value) {
            $.ajax({
              url    : 'index.php?page=cp_tickets',
              method : 'POST',
              data   : {
                      'solvedId': solvedId,
                      'solveTicket': 1
              },
              success : function(response) {
                if(response.match(/solve success/i)){
                  swal.fire("Success!", "Ticket marked as solved!", "success");
                  setTimeout(function() {
                      location.reload();
                  }, 2000);
                } else{
                  swal.fire("Failed!", "Failed to mark. Refreshing browser!", "error");
                  setTimeout(function() {
                      location.reload();
                  }, 2000);
                }
              }
            });
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
          confirmButtonText: 'Yes, delete ticket!'
      }).then(function(result) {
          if (result.value) {
            $.ajax({
              url    : 'index.php?page=cp_tickets',
              method : 'POST',
              data   : {
                      'deleteId': deleteId,
                      'deleteTicket': 1
              },
              success : function(response) {
                if(response.match(/delete success/i)){
                  swal.fire("Success!", "Ticket has been deleted!", "success");
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
});
