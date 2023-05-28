$(document).ready(function() {
    $('#tickets_table').DataTable( {
      responsive: true
    });

    $("#tixAddBtn").click(function() {
      $("#ticketSubmit").modal('show');
    });

    $("#submitTix").click(function(){

      var title = $("#tixTitle").val();
      var message = $("#tixMessage").val();

      $.ajax({
        url    : 'index.php?page=tickets',
        method : 'POST',
        data   : {
                'title': title,
                'message': message,
                'submitTicket': 1
        },
        success : function(response) {
          if(response.match(/ticket add success/i)){
            $("#ticketSubmit").modal('hide');
            swal.fire("Ticket Submitted!", "Kindly wait for our team response.", "success");
            setTimeout(function() {
                location.reload();
            }, 1700);
          } else{
            $("#ticketSubmit").modal('hide');
            swal.fire("Ticket Failed!", "Refreshing your browser in 3 seconds", "error");
            setTimeout(function() {
                location.reload();
            }, 1700);
          }
        }
      });
    });

    $(document).on('click', 'button[data-role=reply]',function(){

      var id = $(this).data('id');
      $.ajax({
        url    : 'index.php?page=tickets',
        method : 'POST',
        data   : {
                'id': id,
                'replyTicket': 1
        },
        success : function(response) {
          if(response.match(/ticket reply redirect/i)){
            setTimeout(function(){location.href="index.php?page=showticket&ti=" + id} , 1000);
          } else{
            swal.fire("Ticket Error!", "Refreshing your browser in 3 seconds", "error");
            setTimeout(function() {
                location.reload();
            }, 2000);
          }
        }
      });
    });
});
