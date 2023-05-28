<div class="page-header"><h1>Seller<small> stats</small></h1></div></div></div><div class="col-sm-12">
<div class="col-sm-8">
<h4>Payment Stats</h4>
<div class="well">
<div class="panel panel-default">
<div class='panel-heading'><i class='clip-user-5'></i>Payment Stats</div>
<table class="table table-bordered table-striped">
<tr><td><strong>Balance</strong></td><td><strong>{{balance|round(1, 'floor')}}$</strong></td></tr>
<tr><td><strong>Total Earn</strong></td><td><strong>{{earned|round(1, 'floor')}}$</strong></td></tr>
<tr><td><strong>Earned CC</strong></td><td><strong>{{earnedcc|round(1, 'floor')}}$</strong></td></tr>
<tr><td><strong>Earned DUMPS</strong></td><td><strong>{{earneddumps|round(1, 'floor')}}$</strong></td></tr>
<tr><td><strong>Total Paid</strong></td><td><strong>{{totalpaid}}$</strong>
<tr><td colspan="2"><button class="btn btn-green btn-lg btn-block" data-toggle="modal" href="#" onclick="showpage('support.php');">Contact Admin</button></td></tr>
</td></tr></table></div></div></div>

<div class="col-sm-4"><h4>Card & Dump Stats</h4><div class="well">
<div class="panel panel-default"><div class="panel-heading"><i class="fa fa-credit-card"></i>Cards Stats</div>
<table class="table table-bordered table-striped">
<tr><td><strong>Total cards</strong></td><td><strong>{{totalcards}}</strong></td></tr>
<tr><td><strong>Unused cards</strong></td><td><strong>{{unusedcards}}</strong></td></tr>      
<tr><td><strong>Used cards</strong></td><td><strong>{{usedcards}}</strong></td></tr></table></div>

<div class="panel panel-default"><div class="panel-heading"><i class="fa fa-credit-card"></i>Dumps Stats</div>
<table class="table table-bordered table-striped">
<tr><td><strong>Total dumps</strong></td><td><strong>{{totaldumps}}</strong></td></tr>
<tr><td><strong>Unused dumps</strong></td><td><strong>{{unuseddumps}}</strong></td></tr>
<tr><td><strong>Used dumps</strong></td><td><strong>{{useddumps}}</strong></td></tr>
</table></div></div></div>
     
<div class="col-sm-6"><h4>Checker CC</h4><div class="well"><div class="panel panel-default"><div class="panel-heading"><i class="fa fa-credit-card"></i>Checker Cards</div>
<table class="table table-bordered table-striped">
<tr><td><span class='label label-success'>Live</span></td><td><strong>{{livecards}}</strong></td></tr>
<tr><td><span class='label label-danger'>Die</span></td><td><strong>{{diecards}}</strong></td></tr>
<tr><td><span class='label label-warning'>Error</span></td><td><strong>{{errorcards}}</strong></td></tr>
<tr><td><span class='label label-primary'>Unknown</span></td><td><strong>{{unknowncards}}</strong></td></tr>
<tr><td><span class='label label-info'>Time off</span></td><td><strong>{{timeoffcards}}</strong></td></tr>
</table></div></div></div>

<div class="col-sm-6"><h4>Checker Dumps</h4><div class="well"><div class="panel panel-default"><div class="panel-heading"><i class="fa fa-credit-card"></i>Checker Cards</div>
<table class="table table-bordered table-striped">
<tr><td><span class='label label-success'>Live</span></span></td><td><strong>{{livedumps}}</strong></td></tr>
<tr><td><span class='label label-danger'>Die</span></td><td><strong>{{diedumps}}</strong></td></tr>
<tr><td><span class='label label-warning'>Error</span></span></td><td><strong>{{errordumps}}</strong></td></tr>
<tr><td><span class='label label-primary'>Unknown</span></td><td><strong>{{unknowndumps}}</strong></td></tr>
<tr><td><span class='label label-info'>Time off</span></td><td><strong>{{timeoffdumps}}</strong></td></tr>
</table></div></div></div>

<div class="col-sm-6"><div class="well"><div class="panel panel-default"><div class="panel-heading"><i class="fa fa-credit-card"></i>Credit Cards</div><div><center>
{{cardchart | raw}}
</center></div></div></div></div>
<div class="col-sm-6"><div class="well"><div class="panel panel-default"><div class="panel-heading"><i class="fa fa-credit-card"></i>Dumps</div><div><center>
{{dumpchart | raw}}
</center></div></div></div></div>


<div class='col-md-12'><div class='panel panel-default'><div class='panel-heading'><i class='fa fa-external-link-square'></i>CARDS INFO</div>
<div class='panel-body'>
{% if  (fullsales|keys)|length>0 %}
<table class='table table-striped table-bordered table-hover table-full-width' id='seller_{{sellerid}}'>
<thead><tr><th>Card Id</th><th>Card Number</th><th>Price (USD)</th><th>Seller Precent</th><th>Status</th><th>Paid</th></tr></thead><tbody>
{% for salles in fullsales %}
<tr><td>{{salles.cardId}}</td>
<td>{{salles.cardNum}}</td>
<td>{{salles.price|round(1, 'floor')}} $</td>
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

<div class='col-md-12'><div class='panel panel-default'><div class='panel-heading'><i class='fa fa-external-link-square'></i>DUMPS INFO</div>
<div class='panel-body'>
{% if  (fullsalesdump|keys)|length>0 %}
<table class='table table-striped table-bordered table-hover table-full-width' id='seller_{{sellerid}}'>
<thead><tr><th>Dump Id</th><th>Dump Number</th><th>Price (USD)</th><th>PACK</th><th>Seller Precent</th><th>Status</th><th>Paid</th></tr></thead><tbody>
{% for sallesdump in fullsalesdump %}
<tr>
<td>{{sallesdump.dumpId}}</td>
<td>{{sallesdump.dumpNum}}</td>
<td>{{sallesdump.price|round(1, 'floor')}} $</td>
<td>
{% if sallesdump.pack == '' or sallesdump.pack =='0' %}
<span class='label label-default'>No</span>
{% else %}
<span class='label label-inverse'>Yes</span>
{% endif %}
</td>
<td>{{sallesdump.sellerprc * 100}} %</td>
<td>
{% if sallesdump.status == '1' %}
<span class='label label-success'>Live</span>
{% endif %}
{% if sallesdump.status == '2' %}
<span class='label label-danger'>Dead</span>
{% endif %}
{% if sallesdump.status == '3' %}
<span class='label label-warning'>Error</span>
{% endif %}
{% if sallesdump.status == '4' %}
<span class='label label-primary'>Unknown</span>
{% endif %}
{% if sallesdump.status == '5' %}
<span class='label label-info'>Time Off</span>
{% endif %}
</td>
<td>
{% if sallesdump.status == '1' or sallesdump.status =='5' %}
{{sallesdump.price * sallesdump.sellerprc}} $
{% else %}
0 $
{% endif %}
</td>
</tr>
{% endfor %}
</tbody></table>
{% endif %}
</div></div></div></div>

{% if  (fullsales|keys)|length>0 or (fullsalesdump|keys)|length>0 %}
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