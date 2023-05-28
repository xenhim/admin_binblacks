<div class='page-header'><h1>My Credit Cards <small>checking</small></h1></div></div></div><table class='table table-striped table-bordered table-hover'>
<th><b>Id</b></th><th><b>Credit card full info</b></th><th>Date</th><th>Check</th></tr>
{% if  (listCard|keys)|length>0 %}
{% for card in listCard %}
<tr><td class='tdCol' style='font-size:16px;'>{{card.cardId}}</td>
<td class='tdCol' style='font-size:16px;'>{{card.cardContent}}</td>
<td class='tdCol' style='font-size:16px;'>{{card.sdate}}</td>
<td class='tdCol' id='cardResult{{card.cardId}}' style='font-size:16px;'>
{% if card.status == '0' %}
<a href='#' class='checkcc' item_id='{{card.cardId}}' onclick="checki('{{card.cardId}}')"><span class='label label-info'>CHECK</span></a>
{% endif %}
{% if card.status == '1' %}
<span class='label label-success'>CVV Live</span>
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
<span class='label label-success'>CCN Live</span>
{% endif %}
{% if card.status == '6' %}
<span class='label label-info'>Time Off</span>
{% endif %}
</td></tr>
{% endfor %}
{% else %}
<tr><th colspan='4'>No card found.</th></tr>
{% endif %}
</table><th>
<input value="Check All Credit Cards" onclick="masscheck();" style="margin-top: 20px; margin-bottom: 20px;" class="btn btn-green btn-lg btn-block" type="submit">
