{% if type == 'head' %}
<div class="page-header"><h1>Checker Dumps Statics<small> Full info</small></h1></div></div></div>
<center><div class="btn-group btn-group-justified"><a href="#" class="btn btn-default" onclick="showpage('dumpstat.php?act=ALL');">ALL</a> <a href="#" class="btn btn-success" onclick="showpage('dumpstat.php?act=LIVE');">LIVE</a> <a href="#" class="btn btn-danger" onclick="showpage('dumpstat.php?act=DIE');">DIE</a> <a href="#" class="btn btn-warning" onclick="showpage('dumpstat.php?act=ERROR');">ERROR</a> <a href="#" class="btn btn-primary" onclick="showpage('dumpstat.php?act=UNKNOWN');">UNKNOWN</a> <a href="#" class="btn btn-info" onclick="showpage('dumpstat.php?act=TIMEOFF');">TIME OFF</a></div>
{% elseif type == 'table' %}
<p><div class="panel-heading"><i class="fa fa-external-link-square"></i>FULL INFO</div>
<table class='table table-striped table-bordered table-hover' style='text-align:center'>
<tr><td width='30px'>Dump Id</td><td>Card Number</td><td>Exp Date</td><td>Category</td><td>Country</td><td>Time</td><td>Used by</td><td>STATUS</td></td></tr>
{% if  (listCard|keys)|length>0 %}
{% for card in listCard %}
<tr><td class='tdCol' >{{card.dumpId}}</td>
<td class='tdCol' >{{card.dumpNum}}</td>
<td class='tdCol' >{{card.dumpMon}}/{{card.dumpYea}}</td>
<td class='tdCol' >{{card.categoryName}}</td>
<td class='tdCol' >{{card.dumpCou}}</td>
<td class='tdCol' >{{card.date}}</td>
<td class='tdCol' >{{card.username}}</td>
<td class='tdCol' >
{% if card.status == '1' %}
<span class='label label-success'>Live</span>
{% elseif card.status == '2' %}
<span class='label label-danger'>Dead</span>
{% elseif card.status == '3' %}
<span class='label label-warning'>Error</span>
{% elseif card.status == '4' %}
<span class='label label-primary'>Unknown</span>
{% elseif card.status == '5' %}
<span class='label label-info'>Time Off</span>
{% else %}
<span class='label label-inverse'>None</span>
{% endif %}
</td></tr>
{% endfor %}
{% else %}
<tr><th colspan='8'><div class='errorMsg'>No dump found.</div></th></tr>
{% endif %}
</table>
{% elseif type == 'footer' %}
</center>
{% endif %}