$(document).ready(function() {
    $('#replies_table').DataTable( {
      responsive: true
    });

    $("#replySubmit").click(function(){

      var id = $("#replyMessage").data('id');
      var message = $("#replyMessage").val();

      $.ajax({
        url    : 'index.php?page=cp_replyticket&ti=' + id,
        method : 'POST',
        data   : {
                'id': id,
                'message': message,
                'replyTicket': 1
        },
        success : function(response) {
          if(response.match(/ticket reply success/i)){
            swal.fire("Reply Submitted!", "Reply has been submitted to user.", "success");
            setTimeout(function(){
              location.reload();
            } , 1700);
          } else{
            swal.fire("Reply Failed!", "Refreshing browser in seconds", "error");
            setTimeout(function(){
              location.reload();
            } , 1700);
          }
        }
      });
    });

});
