<div class="page-header"><h1>Credit Cards <small>import cards</small></h1></div></div></div>
<center><div class='panel panel-default' style='width:650px'><div class='panel-heading'><i class='fa fa-credit-card'></i>Import Credit Card</div>
<form action='card.php?act=add' method='POST' target='_new' ><table class='table table-bordered table-striped'>
<tr><th width='150px'>Name</th><th width='500px'>Value</th></tr>
<tr><td class='tdCol' width='150px'>List card (*)</td><td class='tdCol' width='500px'><textarea name='listcard' style='width:100%;height:100px;'></textarea></td></tr>
<tr><td class='tdCol' width='150px'>Category (*)</td><td class='tdCol' width='500px'><select class='form-control' name='category' >
{% for category in listCategory %}
<option value='{{category.categoryId}}'>{{category.categoryName}}</option>
{% endfor %}
</select></td></tr>
<tr><td class='tdCol' width='150px'>Spliter (*)</td><td class='tdCol' width='500px'><input class='form-control' name='spliter' /></td></tr>
<tr><td class='tdCol' width='150px'>CCNum position (*)</td><td class='tdCol' width='500px'><input class='form-control' name='numpost' /></td></tr>
<tr><td class='tdCol' width='150px'>CVV position</td><td class='tdCol' width='500px'><input class='form-control' name='cvvpost' /></td></tr>
<tr><td class='tdCol' width='150px'>Month position (*)</td><td class='tdCol' width='500px'><input class='form-control' name='monpost' /></td></tr>
<tr><td class='tdCol' width='150px'>Year position (*)</td><td class='tdCol' width='500px'><input class='form-control' name='yeapost' /></td></tr>
<tr><td class='tdCol' width='150px'>Country position</td><td class='tdCol' width='500px'><input class='form-control' name='coupost' /></td></tr>
<tr><td class='tdCol' width='150px'>State position</td><td class='tdCol' width='500px'><input class='form-control' name='statepost' /></td></tr>
<tr><td class='tdCol' width='150px'>City position</td><td class='tdCol' width='500px'><input class='form-control' name='citypost' /></td></tr>
<tr><td class='tdCol' width='150px'>Zip position</td><td class='tdCol' width='500px'><input class='form-control' name='zippost' /></td></tr>
<tr><td class='tdCol' width='150px'>Seller (*)</td><td class='tdCol' width='500px'><select class='form-control' name='seller' >
<option value='1'>Admin (ID = 1)</option>
{% for seller in listseller %}
<option value='{{seller.userId}}'>{{seller.username}} (ID ={{seller.userId}})</option>
{% endfor %}
</select></td></tr>
<tr><td class='tdCol' width='150px'>Sellet precent* (0.01-1) <--[dot!]</td><td class='tdCol' width='500px'><input class='form-control' name='sellerprc' /></td></tr>
<tr><td class='tdCol' width='150px'>No refund (*)<p>(all card is Live)</p></td><td class='tdCol' width='500px'>
<div class='make-switch' data-on='success' data-off='warning'><input name='norefund' value='1' type='checkbox'>
</td></tr>
<tr><th colspan='2'><center><input class='btn btn-bricky' type='button' name='save' onclick="showpage('card.php');" value='Cancel' /> <input class='btn btn-green' type='submit' name='save' value='Save' /></center></th></tr>
</table></form></div>
<script src="../assets/plugins/bootstrap-switch/static/js/bootstrap-switch.min.js"></script>