<div class="page-header"><h1>PM / WMZ / PAYMER<small> paid</small></h1></div></div></div>
<div class="col-md-4"></div><div class="col-md-4">
<center><h2>Invoice {{invoice}} </h2></center>
{% if approved == '0' %}
<div class="well">
<center><span class="label label-sm label-warning">Payment not approved.</span></center>
<p><center><span class="label label-sm label-danger">Waiting for Payment Confirmation:</span> </center></p><p><center><div id="countdown-1"></div></center><script src="js/jquery.timeTo.min.js"></script>
		<script>
		$('#countdown-1').timeTo(15,
		function(){
		showpage('order_status.php?invoice_id={{invoice}}');
		});
		</script></p><p><center>Please do not close this page until your payment is credited.
		If the page for some reason closed, click it again and wait for confirmation.
		Approximate time of confirmation of 1-3 minutes. <br>Please be patient!</center></p>
{% else %}
<div class="well"><p><center><span class="label label-sm label-green">Update credit successful.</span></center></p></div>
{% endif %}