{% if minimal == '0' %}
<!-- <script type="text/javascript" src="{{blockchain_root}}Resources/js/pay-now-button-v2.js"></script> -->
<script type="text/javascript">
	$(document).ready(function() {
		$('.stage-paid').on('show', function() {
			showpage('order_status.php?invoice_id={{id}}');
		});
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
    window.location='order_status.php?invoice_id={{id}}';
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
        <div class="blockchain-btn" style="width:auto" data-create-url=""> 
            <div class="blockchain stage-begin pulse">
                <img src="images/bitcoin_pay_now_64.png">
            </div>
            <div class="blockchain stage-loading" style="text-align:center">
                <img src="https://sellcc.net/images/load.gif">
            </div>
            <div class="blockchain stage-ready" style="text-align:center">
            <div id="row" class="invoice"><div class="col-sm-3"></div><div class="col-sm-6">
								<center><h4>Please send:</h4></center>
								<div class="well">
	<center><h1 class="text-success">{{price_in_btc}} BTC</h1></center>
								</div>
<center><h4>To:</h4></center>
<div class="well">
	<center><h5><span id="address">{{bitcoin_address}}</span></h5></center>
								</div>
                                <center><h4>and press:</h4></center>
                                <center><button class="btn btn-success btn-lg" onclick="showpage('./order_status.php?invoice_id={{id}}')" type="button">I paid</button></center>
							</div><div class="col-sm-3"><div class="qr-code" style="margin-top:85px"><img style="margin: 5px" id="qrsend" src="https://chart.googleapis.com/chart?cht=qr&chs=125x125&chl={{bitcoin_address}}&amount={{price_in_btc}}&label=Bitcoin&size=125&choe=UTF-8" alt=""/></div></div></div>
            </div>
            <div class="blockchain stage-paid">
                Payment Received <b>{{price_in_btc}} BTC</b>. Thank You.
            </div>
            <div class="blockchain stage-error">
                <font color="red">{{error}}</font>
            </div>
        </div>
{% else %}
Minimal deposit = {{mindeposit}}$
{% endif %}