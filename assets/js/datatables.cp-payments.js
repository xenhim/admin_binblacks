$(document).ready(function() {
    $('#payments_table').DataTable( {
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

    $(document).on('click', 'button[data-role=view]',function(){
      var id = $(this).data('id');
      var epStatus = $('#'+id).children('td[data-target=epStatus]').text();
      var epFromCurrency = $('#'+id).children('td[data-target=epFromCurrency]').text();
      var epEnteredAmount = $('#'+id).children('td[data-target=epEnteredAmount]').text();
      var epToCurrency = $('#'+id).children('td[data-target=epToCurrency]').text();
      var epAmount = $('#'+id).children('td[data-target=epAmount]').text();
      var epGatewayId = $('#'+id).children('td[data-target=epGatewayId]').text();
      var epGatewayUrl = $('#'+id).children('td[data-target=epGatewayUrl]').text();
      var epCreatedAt = $('#'+id).children('td[data-target=epCreatedAt]').text();
      var epUpdatedAt = $('#'+id).children('td[data-target=epUpdatedAt]').text();

      $('#epId').val(id);
      $('#epStatus').val(epStatus);
      $('#epFromCurrency').val(epFromCurrency);
      $('#epEnteredAmount').val(epEnteredAmount);
      $('#epToCurrency').val(epToCurrency);
      $('#epAmount').val(epAmount);
      $('#epGatewayId').val(epGatewayId);
      $('#epGatewayUrl').val(epGatewayUrl);
      $('#epCreatedAt').val(epCreatedAt);
      $('#epUpdatedAt').val(epUpdatedAt);
      $('#viewModal').modal('toggle');
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
          confirmButtonText: 'Yes, delete transaction!'
      }).then(function(result) {
          if (result.value) {
            $.ajax({
              url    : 'index.php?page=cp_payments',
              method : 'POST',
              data   : {
                      'deleteId': deleteId,
                      'deletePayment': 1
              },
              success : function(response) {
                if(response.match(/delete success/i)){
                  swal.fire("Success!", "Transaction has been deleted!", "success");
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
});
