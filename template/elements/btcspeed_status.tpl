<div class="page-header"><h1>BTC SPEED<small> paid</small></h1></div></div></div>
<div class="col-md-4"></div><div class="col-md-4">
<center><h2>Invoice {{invoice}} </h2></center>
<div class="well">
<p><center>Wallet : {{wallet}} </center></p>
{% if approved == '0' %}
<center><span class="label label-sm label-warning">Payment not approved.</span></center>
<p><center><span class="label label-sm label-danger">Waiting for Payment Confirmation:</span> </center></p>
<p><center><div id="countdown-1"></div></center>
<script src="js/jquery.timeTo.min.js"></script>
	<script>
	$('#countdown-1').timeTo(180,
	function(){
		showpage('order_status.php?invoice_id={{invoice}}');
        });
	</script></p><p><center>Please do not close this page until your payment is credited.
	If the page for some reason closed, click it again and wait for confirmation.
	Approximate time of confirmation of 5-20 minutes. <br>Please be patient!</center></p>
{% else %}
<p><center><span class="label label-sm label-green">Update credit successful.</span></center></p>
{% endif %}
{% if smalldep == '1' %}
<div class="alert alert-danger">
<button data-dismiss="alert" class="close">
&times;
</button>
<i class="fa fa-times-circle"></i>
<strong>You send $ {{addusd}}</strong> Your deposit is less than the minimum. ($ {{mindeposit}}) Send missing this same wallet and click "Refresh"</div>
{% endif %}
</div></div>