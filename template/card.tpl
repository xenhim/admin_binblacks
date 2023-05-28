<div class="page-header"><h1>Credit Cards <small>select category</small></h1></div></div></div>
<div class="panel panel-default"><div class="panel-body">

{% include "elements/cardsort.tpl" %}

<table class='table table-striped table-bordered table-hover'>
<tr><td><center><input class='allcart' onchange = 'all_add_to_cart();' type='checkbox'></center></td><td><b>Type</b></td><td><b>Bin</b></td><td><b>Exp Date</b></td><td><b>Category</b></td><td><b>Country</b></td><td><b>State</b></td><td><b>City</b></td><td><b>Zip</b></td><td><b>Action/Result</b></td></tr>
{% if found == '1' %}
{% for card in listCard %}
<tr><td class='tdCol' ><center><input class='card' id='card-{{card.cardId}}' onchange = 'cart_select("{{card.cardId}}");' type='checkbox' item_id='{{card.cardId}}' 
{% if session['cards'][card.cardId] is empty %}
{% else %}
 checked 
{% endif %}
>
</center></td><td class='tdCol' ><center>
{% if card.cardNum|slice(0,1) == '3' %}
<img src="images/amex.png">
{% elseif card.cardNum|slice(0,1) == '4' %}
<img src="images/visa.png">
{% elseif card.cardNum|slice(0,1) == '5' %}
<img src="images/mc.png">
{% elseif card.cardNum|slice(0,1) == '6' %}
<img src="images/disc.png">
{% else %}
<img src="images/none.png">
{% endif %}
</center></td>
<td class='tdCol' >{{card.cardNum | slice(0,6)}}</td>
<td class='tdCol' >{{card.cardMon}}/{{card.cardYea}}</td>
<td class='tdCol' >{{card.categoryName}}</td>
<td class='tdCol' >{{card.cardCou}}</td>
<td class='tdCol' >{{card.CardState}}</td>
<td class='tdCol' >{{card.CardCity}}</td>
<td class='tdCol' >{{card.CardZip}}</td>
<td align='center' class='tdCol' id='cardResult{{card.cardId}}' >
<button type="button" onclick="getCard('{{card.cardId}}')" class="btn btn-green">
{% if buyandcheck == '1' %}
Buy&Check
{% else %}
Buy
{% endif %}
 ({{card.price}}$)</button></a></td></tr>
{% endfor %}
{% else %}
<tr><th colspan='9'><div class='errorMsg'>No card found.</div></th></tr>
{% endif %}

</table></div></div></div>
<script> $(document).ready(function() { 
				$("#catid").select2(); 
				$("#cardcountry").select2(); 
				$("#cardstate").select2();
				$("#cardcity").select2(); 
				$("#cardpage").select2(); 
				$("#cardPerPage").select2(); 
				$("#cardtype").select2(); 
                $("#cardbin").select2({
    tags:[],
    containerCssClass: "massbin",
    tokenSeparators: [",", " "]});
				});
                </script>
                <script> $(document).ready( function() {
$(".allcart").click( function() {
                if(!$(".allcart").is(":checked")){
                $(".card").prop("checked", false);
            } else {
                $(".card").prop("checked", true);
            }});
            });</script>