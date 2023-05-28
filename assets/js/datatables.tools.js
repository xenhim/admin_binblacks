$(document).ready(function() {
    $('#tools_table').DataTable( {
      responsive: true
    });

    $(document).on('click', 'button[data-role=purchase]',function(){

      var id = $(this).data('id');
      var etInfo = $('#'+id).children('td[data-target=etInfo]').text();
      var etPreview = $('#'+id).children('td[data-target=etPreview]').text();
      var etPrice = $('#'+id).children('td[data-target=etPrice]').text();

      $('#etInfo').val(etInfo);
      $('#etPreview').val(etPreview);
      $('#etPrice').val(etPrice);
      $('#transId').val(id);
      $('#purchaseModal').modal('toggle');
    });

    $('#buyBtn').click(function(){
      var id = $('#transId').val();
      $.ajax({
        url    : 'index.php?page=tools',
        method : 'POST',
        data   : {
                'id': id,
                'purchaseTool': 1
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
            $('table#tools_table tr#'+ id).fadeOut(300, function(){
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
