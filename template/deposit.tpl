<center><div class="page-header"><h1>Add Voucher<small></small></h1>
<tr><div class='panel panel-default' style='width:600px'>
    <div class='panel-heading'>Add Voucher</div>
<table class='table table-bordered table-striped'>
    
		<iframe class="main" frameborder="0" name="main" scrolling="no" src="https://sellcc.net/voucher.html" width="100%">
		</iframe>
</div>
</table>
</div></tr>
</center>

<div class="page-header"><h1>Add Balance<small> minimal = {{mindeposit}}$</small></h1></div></div></div>
<center><div class='panel panel-default' style='width:600px'><div class='panel-heading'>Add Balance</div>
<table class='table table-bordered table-striped'>
<tr><th width='150px'>Payment System</th><th width='150px'>Vaule</th><th width='150px'>Action</th></tr>

{% if pmdeposit == '1' %}
<tr><form action='' ><td><center><img alt='' src='images/pm.png'></center></td><td><input type='hidden' class='form-control' id='userId' value='{{userid}}' /><input placeholder='USD' id='value' class='form-control' type='text'></td><td><center><button type='submit' onclick='depositpm();' class='btn btn-danger'>Deposit</button></center></td></form></tr>
{% endif %}

{% if btcdeposit == '1' and btcspeed != '1' %}
<tr><form action='' ><td><center><img alt='' src='images/btc.png'></center></td><td><input type='hidden' class='form-control' id='userIdbtc' value='{{userid}}' /><input placeholder='USD' id='valuebtc' class='form-control' type='text'></td><td><center><button type='submit' onclick='depositbtc();' class='btn btn-warning'>Deposit</button></center></td></form></tr>
{% endif %}
<!--
<td><center><img alt='' src='images/btc-speed.png'></center></td>
<td><input type='hidden' class='form-control' id='userId' value='{{userid}}' />
<input placeholder='USD' id='couponcode' name='couponcode' class='form-control' type='text'></td>
<td><center><button type='submit' onclick='javascript:depositcp();' class='btn btn-primary'>Deposit</button></center>
<center><button onclick="javascript:apply_coupon();">Apply</button></center></td>
</form></tr>
-->


{% if btcspeed == '1' %}
<tr><form action='' ><td><center><img alt='' src='images/btc-speed.png'></center></td><td><input type='hidden' class='form-control' id='userIdspeed' value='{{userid}}' /><center> Min. deposit = {{mindeposit}}</center><!--<input placeholder='USD' id='valuebtc' class='form-control' type='text'>--></td><br><center><input placeholder='USD' id='userIdspeedsum' class='form-control' type='text'/></center></td><td><center><button type='submit' onclick='depositbtcspeed();' class='btn btn-warning'>Deposit</button></center></td></form></tr>
{% endif %}

{% if upmusd == '1' %}
<tr><form action='' ><td><center><img alt='' src='images/pm.png'></center></td><td><input type='hidden' class='form-control' id='userIdupm' value='{{userid}}' /><input placeholder='USD' id='valuepm' class='form-control' type='text'></td><td><center><button type='submit' onclick='depositupm();' class='btn btn-danger'>Deposit</button></center></td></form></tr>
{% endif %}

{% if uwmz == '1' %}
<tr><form action='' ><td><center><img alt='' src='images/wmz.png'></center></td><td><input type='hidden' class='form-control' id='userIdwmz' value='{{userid}}' /><input placeholder='USD' id='valuewmz' class='form-control' type='text'></td><td><center><button type='submit' onclick='deposituwmz();' class='btn btn-info'>Deposit</button></center></td></form></tr>
{% endif %}

{% if upaymerz == '1' %}
<tr><form action='' ><td><center><img alt='' src='images/paymer.png'></center></td><td><input type='hidden' class='form-control' id='userIdpaymer' value='{{userid}}' /><input placeholder='USD' id='valuepaymer' class='form-control' type='text'></td><td><center><button type='submit' onclick='depositupaymer();' class='btn btn-primary'>Deposit</button></center></td></form></tr>
{% endif %}

</table></center></div>

{% if btcdeposit == '1' %}
<center><div class="well"><h2>1 USD = {{btcprice}} BTC</h2></div></center>
{% endif %}
<hr><center>
{% if pmdeposit == '1' %}
<span class="label label-sm label-success">*Perfect Money - instant!</span>&nbsp;&nbsp;
{% endif %}
<span class="label label-sm label-danger">*Min. deposit = {{mindeposit}}$</span>
{% if btcdeposit == '1' %}
&nbsp;&nbsp;<span class="label label-sm label-primary">*Bitcoin - Automatically (~10min)!</span>
{% endif %}
</center>
<hr><div class='row'><center><div id='buyresult'></div></center></div>
{% if  (listOrders|keys)|length>0 %}
<div class="page-header"><h1>You Orders<small> btc</small></h1></div></div></div>
<div class="row"><center><div class="panel panel-default" style="width:860px"><div class="panel-heading"></div><table class="table table-bordered table-striped"><tbody><tr>
<th style="text-align: center;">Id</th>
<th style="text-align: center;">Status</th>
<th style="text-align: center;">Date</th>
<th style="text-align: center;">Wallet / System</th>
<th style="text-align: center;">Received BTC</th>
<th style="text-align: center;">Added to Balance</th>
<th style="text-align: center;">Action</th>
</tr>

{% for orders in listOrders %}
<tr>
<td style="text-align: center;" class="tdCol">{{orders.orderId}}</td>
<td style="text-align: center;" class="tdCol">
{% if orders.approved == '2' or orders.approved == '1' %}
<span class="label label-success">Paid</span>
{% else %}
<span class="label label-warning">Not Paid</span>
{% endif %}
</td><td style="text-align: center;" class="tdCol">
{{orders.sdate}}
</td><td style="text-align: center;" class="tdCol">
{% if orders.type == 'BTC' %}
{{orders.wallet}}
{% elseif orders.type == 'Unitaco PM' %}
<span class="label label-danger">Perfect Money</span>
{% elseif orders.type == 'Unitaco WMZ' %}
<span class="label label-info">Webmoney WMZ</span>
{% elseif orders.type == 'Unitaco PAYMER' %}
<span class="label label-default">Paymer</span>
{% endif %}
</td>
<td style="text-align: center;" class="tdCol">
{{orders.btcvalue}}</td>
<td style="text-align: center;" class="tdCol">
{% if orders.orderTotal != '0' and orders.approved != '0' %}
<span class="label label-success">{{orders.orderTotal}} $</span>
{% else %}
-
{% endif %}
</td>

<td style="text-align: center;" class="tdCol"><span class="label label-default" onclick="showpage('./order_status.php?invoice_id={{orders.orderId}};');">Open / Refresh</span></td></tr>
{% endfor %}
</tbody></table></div>
{% endif %}
</center></div>

