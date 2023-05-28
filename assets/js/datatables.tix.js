$(document).ready(function() {
    $('#tickets_table').DataTable( {
      responsive: true
    });

    $("#replySubmit").click(function(){

      var id = $("#replyMessage").data('id');
      var message = $("#replyMessage").val();

      $.ajax({
        url    : 'index.php?page=showticket&ti=' + id,
        method : 'POST',
        data   : {
                'id': id,
                'message': message,
                'replyTicket': 1
        },
        success : function(response) {
          if(response.match(/ticket reply success/i)){
            swal.fire("Reply Submitted!", "Kindly wait for our team response.", "success");
            setTimeout(function(){
              location.reload();
            } , 1700);
          } else{
            swal.fire("Reply Failed!", "Please refresh your browser!", "error");
            setTimeout(function(){
              location.reload();
            } , 1700);
          }
        }
      });
    });
});
