<div class="page-header"><h1>Credit Cards <small>admin panel</small></h1></div></div></div>
<div class="panel panel-default"><div class="panel-heading"><i class="fa fa-credit-card"></i>Credit cards</div><div class="panel-body">

{% include "admin/elements/cardsort.tpl" %}

<table class='table table-striped table-bordered table-hover'>
<tr><td><b>Id</b></td><td><b>Type</b></td><td><b>Bin</b></td><td><b>Exp Date</b></td><td><b>Category</b></td><td><b>Country</b></td><td><b>State</b></td><td><b>City</b></td><td><b>Zip</b></td><td><b>User</b></td><td><b>Status</b></td><td><b>Action</b></td></tr>
{% if found == '1' %}
{% for card in listCard %}
<tr><td class='tdCol' >{{card.cardId}}</td>
<td class='tdCol' ><center>
{% if card.cardNum|slice(0,1) == '3' %}
<img src="../images/amex.png">
{% elseif card.cardNum|slice(0,1) == '4' %}
<img src="../images/visa.png">
{% elseif card.cardNum|slice(0,1) == '5' %}
<img src="../images/mc.png">
{% elseif card.cardNum|slice(0,1) == '6' %}
<img src="../images/disc.png">
{% else %}
<img src="../images/none.png">
{% endif %}
</center></td>
<td class='tdCol' >{{card.cardNum | slice(0,6)}}</td>
<td class='tdCol' >{{card.cardMon}}/{{card.cardYea}}</td>
<td class='tdCol' >{{card.categoryName}}</td>
<td class='tdCol' >{{card.cardCou}}</td>
<td class='tdCol' >{{card.CardState}}</td>
<td class='tdCol' >{{card.CardCity}}</td>
<td class='tdCol' >{{card.CardZip}}</td>
<td class='tdCol' >{{card.username}}</td>
<td class='tdCol' >
{% if card.status == '1' %}
<span class='label label-success'>Live</span>
{% elseif card.status == '2' %}
<span class='label label-danger'>Dead</span>
{% elseif card.status == '3' %}
<span class='label label-warning'>Error</span>
{% elseif card.status == '4' %}
<span class='label label-info'>Unknown</span>
{% elseif card.status == '5' %}
<span class='label label-info'>Time Off</span>
{% else %}
<span class='label label-inverse'>None</span>
{% endif %}
</td>
<td class='tdCol' ><a href="#" onclick="editcard('card.php?act=edit&cardid={{card.cardId}}');" class="btn btn-xs btn-teal tooltips" data-placement="top" data-original-title="Edit"><i class="fa fa-edit"></i></a> <a href="#" onclick="if (confirm('If u delete this, user will can\'t see it in \'My cards\' list. Are you sure?')) {showpage('card.php?act=delete&cardid={{card.cardId}}');}" class="btn btn-xs btn-bricky tooltips" data-placement="top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></a></td></tr>
{% endfor %}
{% else %}
<tr><th colspan='11'><div class='errorMsg'>No card found.</div></th></tr>
{% endif %}
</table>
<script> $(document).ready(function() { 
				$("#catid").select2(); 
				$("#cardcountry").select2(); 
				$("#cardstate").select2();
				$("#cardcity").select2(); 
				$("#cardpage").select2(); 
				$("#cardPerPage").select2(); 
                $("#cardtype").select2();
				$("#showUsed").select2(); 
                $("#cardbin").select2({
    tags:[],
    containerCssClass: "massbin",
    tokenSeparators: [",", " "]});
				});
                </script>
<script src="../assets/plugins/bootstrap-modal/js/bootstrap-modal.js"></script>
<script src="../assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js"></script>
<div id="ajax-modal" class="modal fade" tabindex="-1" style="display: none;"></div>
<div><a href='#' style='margin-top:20px' class='btn btn-green btn-lg btn-block' onclick="showpage('card.php?act=add');">Import cards</a><p></div>