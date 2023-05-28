<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h3>Edit card</h3></div>
<center><div class='modal-body'><div class='panel-heading'><i class='fa fa-credit-card'></i>Edit Credit Card</div>
<form id='editcard' action='card.php?act=edit' method='POST' target='result'><table class='table table-bordered table-striped'>
<tr><th width='150px'>Name</th><th colspan='2'>Value</th></tr>
{% if found == '1' %}
<tr><td class='tdCol' width='150px'>Card Id</td><td colspan='2' class='tdCol'>{{cardid}}</td></tr>
<tr><td class='tdCol' width='150px'>Card content (*)</td><th colspan='2' class='tdCol' width='500px'><textarea name='content' style='width:100%;height:100px;'>{{card.cardContent}}</textarea><input name='id' type='hidden' value='{{cardid}}' /></th></tr>
<tr><td class='tdCol' width='150px'>Used by<br /><font color='#ff0000'>(UserID, 0 = Unused)</font></td><td class='tdCol'><input class='form-control' name='used' value='{{card.cardUsed}}' /></td><td class='tdCol' width='250px'></td></tr>
<tr><td class='tdCol' width='150px'>Category (*)</td><td class='tdCol'><select name='category' class='form-control'>
{% for category in listCategory %}
<option {% if card.categoryId == category.categoryId %} selected {% endif %}
value='{{category.categoryId}}'>{{category.categoryName}}</option>
{% endfor %}
</select></td></tr>
<tr><td class='tdCol' width='150px'>Spliter (*)</td><td class='tdCol'><input class='form-control' name='spliter' value='{{card.cardSpliter}}' /></td><td style='text-align:center' ></td></tr>
<tr><td class='tdCol' width='150px'>CCNum position (*)</td><td class='tdCol'><input class='form-control' name='numpost' value='{{card.cardNumPost}}' /><td style='text-align:center' >{{card.cardNum}}</td></tr>
<tr><td class='tdCol' width='150px'>CVV position</td><td class='tdCol'><input class='form-control' name='cvvpost' value='{{card.cardCvvPost}}' /></td><td style='text-align:center' >{{card.cardCvv}}</td></tr>
<tr><td class='tdCol' width='150px'>Month position (*)</td><td class='tdCol'><input class='form-control' name='monpost' value='{{card.cardMonPost}}' /></td><td style='text-align:center' >{{card.cardMon}}</td></tr>
<tr><td class='tdCol' width='150px'>Year position (*)</td><td class='tdCol'><input class='form-control' name='yeapost' value='{{card.cardYeaPost}}' /></td><td style='text-align:center' >{{card.cardYea}}</td></tr>
<tr><td class='tdCol' width='150px'>Country position</td><td class='tdCol'><input class='form-control' name='coupost' value='{{card.cardCouPost}}' /></td><td style='text-align:center' >{{card.cardCou}}</td></tr>
<tr><td class='tdCol' width='150px'>State position</td><td class='tdCol'><input class='form-control' name='statepost' value='{{card.CardStatePost}}' /></td><td style='text-align:center' >{{card.CardState}}</td></tr>
<tr><td class='tdCol' width='150px'>City position</td><td class='tdCol'><input class='form-control' name='citypost' value='{{card.CardCityPost}}' /></td><td style='text-align:center' >{{card.CardCity}}</td></tr>
<tr><td class='tdCol' width='150px'>Zip position</td><td class='tdCol'><input class='form-control' name='zippost' value='{{card.CardZipPost}}' /></td><td style='text-align:center' >{{card.CardZip}}</td></tr>
<tr><td class='tdCol' width='150px'>Status (*)</td><input name='save' value='save' type='hidden'><td class='tdCol'><select name='status' class='form-control'>
<option value='0' {% if card.status == '0' %} selected {% endif %} >None</option>
<option value='1' {% if card.status == '1' %} selected {% endif %} >Live</option>
<option value='2' {% if card.status == '2' %} selected {% endif %} >Dead</option>
<option value='3' {% if card.status == '3' %} selected {% endif %} >Error</option>
<option value='4' {% if card.status == '4' %} selected {% endif %} >Unknown</option>
<option value='5' {% if card.status == '5' %} selected {% endif %} >Time Off</option>
</select></td><td style='text-align:center' >
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
</td></tr>
<tr><td class='tdCol' width='150px'>Price (*)</td><td class='tdCol'><input class='form-control' name='price' value='{{card.price}}' /></td><td style='text-align:center' >{{card.price}}</td></tr>
<tr><td class='tdCol' width='150px'>Seller (*)</td><td class='tdCol'><select name='seller' class='form-control'>
<option value='1'>Admin (ID = 1)</option>
{% for seller in listseller %}
<option {% if card.seller == seller.userId %} selected {% endif %}
value='{{seller.userId}}'>{{seller.username}} (ID ={{seller.userId}})</option>
{% endfor %}
</select></td><td style='text-align:center' >Seller id = {{card.seller}}</td></tr>
<tr><td class='tdCol' width='150px'>Seller precent* (0.01-1) </td><td class='tdCol'><input class='form-control' name='sellerprc' value='{{card.sellerprc}}' /></td><td style='text-align:center' >{{card.sellerprc}}</td></tr>
{% else %}
<tr><th colspan='2'>This card is not available</th></tr>
{% endif %}
</table></form></center>
<div class="modal-footer"><button type="button" data-dismiss="modal" class="btn">Close</button><input form="editcard" type="submit" class="btn btn-primary" name="save" value="Save" /></div>
</div>
<script>$(function(){
$('#editcard').submit(function(e){
e.preventDefault();
var m_method=$(this).attr('method');
var m_action=$(this).attr('action');
var m_data=$(this).serialize();
$.ajax({
type: m_method,
url: m_action,
data: m_data,
success: function(msg){
$('button.close').trigger('click');
editcard('card.php?act=edit&cardid={{cardid}}');
}
});
});
});</script>