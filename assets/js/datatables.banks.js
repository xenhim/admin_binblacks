$(document).ready(function() {
    $('#banks_table').DataTable( {
      responsive: true
    });

    $(document).on('click', 'button[data-role=purchase]',function(){

      var id = $(this).data('id');

      var bankType = $('#'+id).children('td[data-target=bankType]').text();
      var bankScreenshot = $('#'+id).children('td[data-target=bankScreenshot]').text();
      var bankTelepin = $('#'+id).children('td[data-target=bankTelepin]').text();
      var bankPrice = $('#'+id).children('td[data-target=bankPrice]').text();

      $('#bankType').val(bankType);
      $('#bankScreenshot').val(bankScreenshot);
      $('#bankTelepin').val(bankTelepin);
      $('#bankPrice').val(bankPrice);
      $('#transId').val(id);
      $('#purchaseModal').modal('toggle');
    });

    $('#buyBtn').click(function(){
      var id = $('#transId').val();
      $.ajax({
        url    : 'index.php?page=banks',
        method : 'POST',
        data   : {
                'id': id,
                'purchaseBank': 1
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
            $('table#banks_table tr#'+ id).fadeOut(300, function(){
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
