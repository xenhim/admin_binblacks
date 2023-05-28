$(document).ready(function() {
  var currentDate = new Date();
  currentDate.setMinutes(currentDate.getMinutes() + 120);
  currentDate = new Date(currentDate);
    $('#expirationTime').countdown(currentDate, function(event) {
      $(this).html(event.strftime('%H:%M:%S'));
    })
    .on('finish.countdown', function(event) {
      swal.fire({
          "title": "Topup Failed",
          "text": "Timer has reached the countdown.",
          "type": "warning",
          "confirmButtonClass": "btn btn-secondary btn-warning m-btn m-btn--wide"
      }).then((result) => {
        if (result.value) {
          location.reload();
        }
      })
    });
});
