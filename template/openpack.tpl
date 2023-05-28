<div class='page-header'><h1>PACK # {{id}} <small> {{pack['name']}}</small></h1></div></div></div><table class='table table-striped table-bordered table-hover'>
<th><b>Id</b></th><th><b>Dump full info</b></th><th>Date</th><th>Check</th></tr>
{% if  (listCard|keys)|length>0 %}
{% for card in listCard %}
<tr><td class='tdCol' style='font-size:12px;'>{{card.dumpId}}</td>
<td class='tdCol' style='font-size:12px;'>{{card.dumpContent}}</td>
<td class='tdCol' style='font-size:12px;'>{{card.sdate}}</td>
<td class='tdCol' id='cardResult{{card.dumpId}}' style='font-size:12px;'>
{% if card.status == '0' %}
<a href='#' class='checkdump' item_id='{{card.dumpId}}' onclick="packchecki('{{card.dumpId}}')"><span class='label label-info'>CHECK</span></a>
{% endif %}
{% if card.status == '1' %}
<span class='label label-success'>Live</span>
{% endif %}
{% if card.status == '2' %}
<span class='label label-danger'>Dead</span>
{% endif %}
{% if card.status == '3' %}
<span class='label label-warning'>Error</span>
{% endif %}
{% if card.status == '4' %}
<span class='label label-info'>Unknown</span>
{% endif %}
{% if card.status == '5' %}
<span class='label label-info'>Time Off</span>
{% endif %}
</td></tr>
{% endfor %}
{% else %}
<tr><th colspan='4'>No dump found.</th></tr>
{% endif %}
</table><th>
<input value="Check All Dumps" onclick="packcheck();" style="margin-top: 20px; margin-bottom: 20px;" class="btn btn-green btn-lg btn-block" type="submit">