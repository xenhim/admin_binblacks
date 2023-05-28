<div class="page-header"><h1>BTC<small> paid</small></h1></div></div></div>
<div class="col-md-4"></div><div class="col-md-4">
<center><h2>Invoice {{invoice}} </h2></center>
<div class="well">
	<center><h5><span id="address">{{wallet}}</span></h5></center>
								</div>
<div class="well">
<p><center>Amount Due : {{priceusd}} USD ({{pricebtc}} BTC) </center></p>
{% if approved == '0' %}
<center>Payment not approved.</center>
<p><center>Waiting for Payment Confirmation: </center></p>
<!-- <p><a href="#" class="btn btn-green btn-lg btn-block" onclick="showpage('order_status.php?invoice_id={{invoice}}');";>Refresh</a></p> -->
<p><center><div id="countdown-1"></div></center>
<script src="js/jquery.timeTo.min.js"></script>
	<script>
	$('#countdown-1').timeTo(180,
	function(){
		showpage('order_status.php?invoice_id={{invoice}}');
        });
	</script>
<script type="text/javascript">
        var status = -1
        // Create socket variables
        if(status < 2 && status != -2){
        var addr =  document.getElementById("address").innerHTML;
        var wsuri2 = "wss://www.blockonomics.co/payment/"+ addr;
        // Create socket and monitor
        var socket = new WebSocket("wss://www.blockonomics.co/payment/"+ addr);
    socket.onmessage = function(event){
        console.log(event.data);
    response = JSON.parse(event.data);
    if (response.status > status)
    window.location='order_status.php?invoice_id={{invoice}}';
        setTimeout(function(){window.location.reload() }, 1000); 
    }
        }
        
/*
        var socket = new WebSocket(wsuri2, "protocolOne")
            socket.onmessage = function(event){
                console.log(event.data);
                response = JSON.parse(event.data);
                //Refresh page if payment moved up one status
                if (response.status > status)
                  setTimeout(function(){ window.location=window.location }, 1000);
            }
            */

        
    </script>
    
	</p><p><center>Please do not close this page until your payment is credited.
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

