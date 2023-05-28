<div class="page-header"><h1>Credit Cards <small>set price</small></h1></div></div></div>
<div id="row"><div id="result"></div></div>
<center><div class='panel panel-default' style='width:650px'><div class='panel-heading'><i class='fa fa-credit-card'></i>Set Country Price</div>
<table class='table table-bordered table-striped'>
<tr><th width='175px'><center>Country</center></th><th width='175px'><center>Value</center></th><th width='200px'><center>Action/Result</center></th></tr>
{% if  (listprice|keys)|length>0 %}
{% for price in listprice %}
<tr>
<td class='tdCol' ><center>{{price.cardCou}} <span class='badge badge-danger'> {{price.count}}</span></center></td>
<td class='tdCol' ><input class='form-control' id='{{price.cardCou}}' name='planprice' value='' /></td></td>
<td class='tdCol' ><center><button onclick="showresult('./addprice.php?act=set&price='+document.getElementById('{{price.cardCou}}').value+'&country={{price.cardCou}}');" type='button' class='btn btn-success'>Set Price</button></center></td>
</tr>
{% endfor %}
{% else %}
<tr><td colspan='3'>No unset price cards.</td></tr>
{% endif %}
</table></center></div>
