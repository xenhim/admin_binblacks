<div class="page-header"><h1>Orders<small> see orders</small></h1></div></div></div>
<center>
<div class="btn-group btn-group-justified">
<a href="#" class="btn btn-default" onclick="showpage('order.php?act=lastweek');">Last 7 Days</a> 
<a href="#" class="btn btn-primary" onclick="showpage('order.php?act=lastmonth');">Last 30 Days</a> 
<a href="#" class="btn btn-danger" onclick="showpage('order.php');">All Orders</a> 
</div></center><p></p>
<center><div class='panel panel-default'><div class='panel-heading'>Orders</div>
{% if  (listOrder|keys)|length>0 %}
<div class='panel-body'><table class='table table-striped table-bordered table-hover table-full-width' id='seller_1'>
<thead><tr><th>Id</th><th>Approved</th><th>Username</th><th>Amount</th><th>Type</th><th>Order Date</th><th>BTC VALUE</th><th>BTC Received</th><th>BTC Confirmations</th><th>TX Hash</th><th width='70px'>Action</th></tr></thead><tbody>
{% for order in listOrder %}
<tr>
<td class='tdCol' >{{order.orderId}}</td>
<td class='tdCol' >
{% if order.approved == '1' %}
<span class='label label-success'>Paid</span>
{% elseif order.approved == '2' %}
<span class='label label-primary'>Speed Paid</span>
{% else %}
<span class='label label-danger'>Not Paid</span>
{% endif %}
</td>
<td class='tdCol' >{{order.username}}</td>
<td class='tdCol' >{{order.orderTotal}} USD</td>
<td class='tdCol' >{{order.type}}</td>
<td class='tdCol' >{{order.orderDate}}</td>
<td class='tdCol' >{{order.btcvalue}}</td>
<td class='tdCol' >{{order.btcreceived}}</td>
<td class='tdCol' >{{order.confirmations}}</td>
<td class='tdCol' >
{% if order.txhash|length>0 %}
<span onclick="window.open('https://blockchain.info/ru/tx/{{order.txhash}}')" class="label label-success">Open</span>
{% else %}
<span class="label label-danger">No hash</span>
{% endif %}
</td>
<td class='tdCol' ><a href="#" onclick="if (confirm('Are you sure?')) {showpage('order.php?act=delete&orderid={{order.orderId}}');}" class="btn btn-xs btn-bricky tooltips" data-placement="top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></a></td>
</tr>
{% endfor %}
{% else %}
<tr><th colspan='6'><div class='errorMsg'>No order found.</div></th></tr>
{% endif %}
</tbody></table></center></div>
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script type="text/javascript" src="../assets/plugins/select2/select2.min.js"></script>
		<script type="text/javascript" src="../assets/plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="../assets/plugins/DataTables/media/js/DT_bootstrap.js"></script>
		<script src="../assets/js/table-data.js"></script>
        <script src="../assets/plugins/bootstrap-modal/js/bootstrap-modal.js"></script>
		<script src="../assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js"></script>
		<script src="../assets/js/ui-modals.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY --><script>
			jQuery(document).ready(function() {
				TableData.init();
                UIModals.init();
			});
		</script>

<p></p><div class="well"><center>
<p><h2>Delete <span class="text-danger">not paid</span> invoices:</h2></p>
<div class="btn-group btn-group-justified">
<a href="#" class="btn btn-info" onclick="if (confirm('Are you sure?')) {showpage('order.php?act=delete30');}">Older than 30 Days</a> 
<a href="#" class="btn btn-yellow" onclick="if (confirm('Are you sure?')) {showpage('order.php?act=delete7');}">Older than 7 Days</a> 
<a href="#" class="btn btn-orange" onclick="if (confirm('Are you sure?')) {showpage('order.php?act=delete3');}">Older than 3 Days</a> 
</div></center></div><p></p>