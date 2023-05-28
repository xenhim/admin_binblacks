$(document).ready(function() {
    $('#fullz_table').DataTable( {
      responsive: true
    });

    $(document).on('click', 'button[data-role=purchase]',function(){

      var id = $(this).data('id');

      var pcType = $('#'+id).children('td[data-target=pcType]').text();
      var pcBin = $('#'+id).children('td[data-target=pcBin]').text();
      var pcName = $('#'+id).children('td[data-target=pcName]').text();
      var pcYear = $('#'+id).children('td[data-target=pcYear]').text();
      var pcPostcode = $('#'+id).children('td[data-target=pcPostcode]').text();
      var pcPhone = $('#'+id).children('td[data-target=pcPhone]').text();
      var pcPrice = $('#'+id).children('td[data-target=pcPrice]').text();

      $('#pcType').val(pcType);
      $('#pcBin').val(pcBin);
      $('#pcName').val(pcName);
      $('#pcYear').val(pcYear);
      $('#pcPostcode').val(pcPostcode);
      $('#pcPhone').val(pcPhone);
      $('#pcPrice').val(pcPrice);
      $('#transId').val(id);
      $('#purchaseModal').modal('toggle');
    });

    $(document).on('click', 'button[data-role=info]',function(){
      var id = $(this).data('id');
      var pcBin = $('#'+id).children('td[data-target=pcBin]').text();
      $('#binModal').modal('toggle');
      $.ajax({
        url    : 'https://lookup.binlist.net/' + pcBin,
        method : 'GET',
        contentType: "application/json",
        beforeSend: function()
        {
          $('#type').val("");
          $('#brand').val("");
          $('#prepaid').val("");
          $('#country-name').val("");
          $('#country-currency').val("");
          $('#bank-name').val("");
          $('#bank-url').val("");
          $('#bank-city').val("");
          $('#binLoader').fadeIn(500);
        }
      }).done(function(response) {
        if(response['type']) {
          $('#type').val(response['type']);
        }
        else {
          $('#type').val("null");
        }
        if(response['brand']) {
          $('#brand').val(response['brand']);
        }
        else {
          $('#brand').val("null");
        }
        if(response['prepaid']) {
          $('#prepaid').val(response['prepaid']);
        }
        else {
          $('#prepaid').val("null");
        }
        if(response['prepaid']) {
          $('#prepaid').val(response['prepaid']);
        }
        else {
          $('#prepaid').val("null");
        }
        if(response['country']['name']) {
          $('#country-name').val(response['country']['name']);
        }
        else {
          $('#country-name').val("null");
        }
        if(response['country']['currency']) {
          $('#country-currency').val(response['country']['currency']);
        }
        else {
          $('#country-currency').val("null");
        }
        if(response['bank']['name']) {
          $('#bank-name').val(response['bank']['name']);
        }
        else {
          $('#bank-name').val("null");
        }
        if(response['bank']['site']) {
          $('#bank-url').val(response['bank']['site']);
        }
        else {
          $('#bank-url').val("null");
        }
        if(response['bank']['city']) {
          $('#bank-city').val(response['bank']['city']);
        }
        else {
          $('#bank-city').val("null");
        }
        $('#binLoader').fadeOut();
        $('#binHide').fadeIn(500);
      }).fail(function() {
        $('#binModal').modal('hide');
        swal.fire("Failed!", "Error fetching bin information.", "error");
        setTimeout(function() {
            location.reload();
        }, 1700);
      });
    });
    $('#buyBtn').click(function(){
      var id = $('#transId').val();
      $.ajax({
        url    : 'index.php?page=fullz',
        method : 'POST',
        data   : {
                'id': id,
                'purchaseFullz': 1
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
            $('table#fullz_table tr#'+ id).fadeOut(300, function(){
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
