<div class="page-header"><h1>Seller<small> stats</small></h1></div></div></div><div class="col-sm-12">
<div class="col-sm-8">
<h4>Payment Stats</h4>
<div class="well">
<div class="panel panel-default">
<div class='panel-heading'><i class='clip-user-5'></i>Payment Stats</div>
<table class="table table-bordered table-striped">
<tr><td><strong>Balance</strong></td><td><strong>{{balance}}$</strong></td></tr>
<tr><td><strong>Earned</strong></td><td><strong>{{earned}}$</strong></td></tr>
<tr><td><strong>Total Paid</strong></td><td><strong>{{totalpaid}}$</strong></td></tr>
<tr><td colspan="2"><button class="btn btn-green btn-lg btn-block" data-toggle="modal" href="#" onclick="showpage('support.php');">Contact Admin</button></td></tr>
</table></div></div></div>
<div class="col-sm-4"><h4>Card Stats</h4><div class="well"><div class="panel panel-default"><div class="panel-heading"><i class="fa fa-credit-card"></i>Card Stats</div>
<table class="table table-bordered table-striped">
<tr><td><strong>Total cards</strong></td><td><strong>{{totalcards}}</strong></td></tr>
<tr><td><strong>Unused cards</strong></td><td><strong>{{unusedcards}}</strong></td></tr>
<tr><td><strong>Used cards</strong></td><td><strong>{{usedcards}}</strong></td></tr>
</table></div></div></div>
<div class="col-sm-8"><div class="well"><div class="panel panel-default"><div class="panel-heading"><i class="fa fa-credit-card"></i>Checker Pie</div><div><center>
{{chart | raw}}
</center></div></div></div></div>
<div class="col-sm-4"><h4>Checker Stats</h4><div class="well"><div class="panel panel-default"><div class="panel-heading"><i class="fa fa-credit-card"></i>Checker Stats</div>
<table class="table table-bordered table-striped">
<tr><td><span class='label label-success'>Live</span></td><td><strong>{{livecards}}</strong></td></tr>
<tr><td><span class='label label-danger'>Die</span></td><td><strong>{{diecards}}</strong></td></tr>
<tr><td><span class='label label-warning'>Error</span></td><td><strong>{{errorcards}}</strong></td></tr>
<tr><td><span class='label label-primary'>Unknown</span></td><td><strong>{{unknowncards}}</strong></td></tr>
<tr><td><span class='label label-info'>Time off</span></td><td><strong>{{timeoffcards}}</strong></td></tr>
</table></div></div></div>

<div class='col-md-12'><div class='panel panel-default'><div class='panel-heading'><i class='fa fa-external-link-square'></i>CARDS INFO</div>
<div class='panel-body'>
{% if  (fullsales|keys)|length>0 %}
<table class='table table-striped table-bordered table-hover table-full-width' id='seller_{{sellerid}}'>
<thead><tr><th>Card Id</th><th>Card Number</th><th>Price (USD)</th><th>Seller Precent</th><th>Status</th><th>Paid</th></tr></thead><tbody>
{% for salles in fullsales %}
<tr><td>{{salles.cardId}}</td>
<td>{{salles.cardNum}}</td>
<td>{{salles.price}} $</td>
<td>{{salles.sellerprc * 100}} %</td>
<td>
{% if salles.status == '1' %}
<span class='label label-success'>Live</span>
{% endif %}
{% if salles.status == '2' %}
<span class='label label-danger'>Dead</span>
{% endif %}
{% if salles.status == '3' %}
<span class='label label-warning'>Error</span>
{% endif %}
{% if salles.status == '4' %}
<span class='label label-primary'>Unknown</span>
{% endif %}
{% if salles.status == '5' %}
<span class='label label-info'>Time Off</span>
{% endif %}
</td>
<td>
{% if salles.status == '1' or salles.status =='5' %}
{{salles.price * salles.sellerprc}} $
{% else %}
0 $
{% endif %}
</td>
</tr>
{% endfor %}
</tbody></table>
{% endif %}
</div></div></div>
        {% if  (fullsales|keys)|length>0 %}
        <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script type="text/javascript" src="assets/plugins/select2/select2.min.js"></script>
		<script type="text/javascript" src="assets/plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="assets/plugins/DataTables/media/js/DT_bootstrap.js"></script>
		<script src="assets/js/table-data.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY --><script>
			jQuery(document).ready(function() {
				TableData.init();
			});
		</script>
        {% endif %}