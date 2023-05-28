<div class="page-header"><h1>Shopping Cart<small> Credit Cards</small></h1></div></div></div>
<div class="row"><div class="col-sm-12"><table class="table table-striped table-hover">
<thead><tr><th>Bin</th><th>Exp Date</th><th>Category</th><th>Country</th><th>State</th><th>City</th><th>Zip</th><th>Price</th><th>Action</th></tr></thead>
<tbody>
{% for card in cardinfo %}
<tr><td>{{card.cardNum | slice(0,6)}}</td>
<td>{{card.cardMon}}/{{card.cardYea}}</td>
<td>{{card.categoryName}}</td>
<td>{{card.cardCou}}</td>
<td>{{card.CardState}}</td>
<td>{{card.CardCity}}</td>
<td>{{card.CardZip}}</td>
<td>{{card.price}}</td>
<td id="cardResult{{card.cardId}}" class="card" item_id="{{card.cardId}}">
<div class="delete"><a href="#" onclick="remove_from_cart('{{card.cardId}}')" class="btn btn-xs btn-bricky tooltips" data-placement="top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></a></div></td></tr>
{% endfor %}
</tbody></table></div></div><hr>
<div class="row"><div class="col-sm-12">
<div class="col-sm-8"></div><div class="col-sm-4"><div class="well">
<div id="totalcart">{% include "elements/cc-cart-total.tpl" %}</div><hr>
<p align="right"><a onclick="clear_all_cc();" class="btn btn-bricky btn-lg">Clear Cart <i class="fa fa-shopping-cart"></i></a>&nbsp&nbsp<a onclick="buy_all_cc()" class="btn btn-lg btn-green hidden-print">Buy CC <i class="fa fa-check"></i></a></div></p>
</div></div>
<script>
$(document).ready(function() {
$('.delete').click(function(){
    $(this).closest('tr').remove();
});
});
</script>