$(document).ready(function() {
    $('#accounts_table').DataTable( {
      responsive: true
    });

    $(document).on('click', 'button[data-role=purchase]',function(){

      var id = $(this).data('id');

      var accountType = $('#'+id).children('td[data-target=accountType]').text();
      var accountInfo = $('#'+id).children('td[data-target=accountInfo]').text();
      var accountPrice = $('#'+id).children('td[data-target=accountPrice]').text();

      $('#accountType').val(accountType);
      $('#accountInfo').val(accountInfo);
      $('#accountPrice').val(accountPrice);
      $('#transId').val(id);
      $('#purchaseModal').modal('toggle');
    });

    $('#buyBtn').click(function(){
      var id = $('#transId').val();
      $.ajax({
        url    : 'index.php?page=accounts',
        method : 'POST',
        data   : {
                'id': id,
                'purchaseAccount': 1
        },
        beforeSend: function()
        {
          if($("#kt_toast_3").is(":visible")) {
            $("#kt_toast_3").toast('hide');
          }
          if($("#kt_toast_2").is(":visible")) {
            $("#kt_toast_2").toast('hide');
          }
          if($("#kt_toast_1").is(":visible")) {
            $("#kt_toast_1").toast('hide');
          }
        },
        success : function(response) {
          if(response.match(/purchase error/i)){
            $('#purchaseModal').modal('hide');
            $('#kt_toast_3').toast('show');
          } else if (response.match(/not enough balance/i)) {
            $('#purchaseModal').modal('hide');
            $('#kt_toast_2').toast('show');
          } else if (response.match(/purchase success/i)) {
            $('#purchaseModal').modal('hide');
            $('#kt_toast_1').toast('show');
            $('table#accounts_table tr#'+ id).fadeOut(300, function(){
                $(this).remove();
              });
          } else{
            $('#purchaseModal').modal('hide');
            $('#kt_toast_3').toast('show');
          }
        }
      });

    });
});
