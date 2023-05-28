{% if type == 'head' %}

<div class="page-header"><h1>Dumps <small>edit price</small></h1></div></div></div>
<div id="row"><div id="result"></div></div>

{% elseif type == 'table' %}
<center><div class='panel panel-default' style='width:850px'><div class='panel-heading'><i class='fa fa-credit-card'></i>{{category.categoryName}}</div>
<table class='table table-bordered table-striped'>
<tr><th width='175px'><center>Country</center></th><th width='50px'><center>Code</center></th><th width='90px'><center>Class</center></th><th width='60px'><center>Level</center></th><th width='175px'><center>Value</center></th><th width='200px'><center>Action/Result</center></th></tr>

{% if  (listprice|keys)|length>0 %}
{% for price in listprice %}
<tr>
<td class='tdCol' ><center>{{price.dumpCou}} <span class='badge badge-danger'> {{price.count}}</span></center></td>
<td class='tdCol' ><center>{{price.dumpcode}}</center></td>
<td class='tdCol' ><center>{{price.dumpclass}}</center></td>
<td class='tdCol' ><center>{{price.dumplevel}}</center></td>
<td class='tdCol' ><input class='form-control' id='{{price.dumpCou}}-{{category.categoryId}}-{{price.price}}-{{price.dumpcode}}-{{price.dumpclass}}-{{price.dumplevel}}' name='planprice' value='{{price.price}}' /></td></td>
<td class='tdCol' ><center><button onclick="showresult('./dumpeditprice.php?act=set&lastprice={{price.price | url_encode}}&category={{category.categoryId | url_encode}}&price='+document.getElementById('{{price.dumpCou}}-{{category.categoryId}}-{{price.price}}-{{price.dumpcode}}-{{price.dumpclass}}-{{price.dumplevel}}').value+'&country={{price.dumpCou | url_encode}}&code={{price.dumpcode | url_encode}}&class={{price.dumpclass | url_encode}}&level={{price.dumplevel | url_encode}}');" type='button' class='btn btn-success'>Set Price</button></center></td>
</tr>
{% endfor %}
{% else %}
<tr><td colspan='6'>No dumps.</td></tr>
{% endif %}
{% endif %}
</table></center></div>