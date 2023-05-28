<div class="page-header"><h1>Dumps <small>select category</small></h1></div></div></div>
<div class="panel-heading"><i class="fa fa-credit-card"></i>Dumps</div><div class="panel-body"><div class="form-inline">

{% include "elements/dumpsort.tpl" %}

<table class='table table-striped table-bordered table-hover'>
<tr><td><center><input class='dumpallcart' onchange = 'dump_all_add_to_cart();' type='checkbox'></center></td><td><b>Number</b></td><td><b>Type</b></td><td><b>Level</b></td><td><b>Class</b></td><td><b>Code</b></td><td><b>Exp Date</b></td><td><b>Category</b></td><td><b>Country</b></td><td><b>Bank</b></td><td><b>Action/Result</b></td></tr>
{% if found == '1' %}
{% for card in listCard %}

<tr><td><center><input class='dump' id='card-{{card.dumpId}}' onchange = 'dump_cart_select("{{card.dumpId}}");' type='checkbox' item_id='{{card.dumpId}}' 
{% if session['dumps'][card.dumpId] is empty %}
{% else %}
 checked 
{% endif %}
>
</center></td>
<td class='tdCol' >{{card.dumpNum | slice(0,6)}}</td>
<td class='tdCol' >{{card.dumptype}}</td>
<td class='tdCol' >{{card.dumplevel}}</td>
<td class='tdCol' >{{card.dumpclass}}</td>
<td class='tdCol' >{{card.dumpcode}}</td>
<td class='tdCol' >{{card.dumpMon}}/{{card.dumpYea}}</td>
<td class='tdCol' >{{card.categoryName}}</td>
<td class='tdCol' >{{card.dumpCou}}</td>
<td class='tdCol' >{{card.dumpbank}}</td>
<td align='center' class='tdCol' id='cardResult{{card.dumpId}}' >
<button type="button" onclick="getDump('{{card.dumpId}}')" class="btn btn-green">
{% if buyandcheck == '1' %}
Buy&Check
{% else %}
Buy
{% endif %}
 ({{card.price}}$)</button></a></td></tr>
{% endfor %}
{% else %}
<tr><th colspan='11'><div class='errorMsg'>No dump found.</div></th></tr>
{% endif %}
</table></div></div></div>
<script> $(document).ready(function() { 
				$("#catid").select2(); 
				$("#type").select2();
                $("#code").select2();
                $("#level").select2();
                $("#class").select2();
                $("#cardcountry").select2();
                $("#bank").select2();
                $("#cardpage").select2(); 
                $("#cardPerPage").select2(); 
                $("#cardbin").select2({
    tags:[],
    containerCssClass: "massbin",
    tokenSeparators: [",", " "]});
				});
                </script>
                <script> $(document).ready( function() {
$(".dumpallcart").click( function() {
                if(!$(".dumpallcart").is(":checked")){
                $(".dump").prop("checked", false);
            } else {
                $(".dump").prop("checked", true);
            }});
            });</script> 