<div class="page-header"><h1>Dump Packs <small> sale</small></h1></div></div></div>
<div id="row"><div id="result"></div></div>
<div id="pricing_table_example2" class="row">
{% for packs in listpack %}
<div class="col-md-4">
<div class="pricing-table" style="margin:10px;">
<div class="top">
<h2>{{packs.name}}</h2>
</div>
<ul>
<li>
<strong>{{packs.value}}</strong> Dumps
</li>
<li>
<strong>{{packs.country}}</strong>
</li>
<div class="well">
	<table style="width:100%">
    <tbody><tr>
        <td><h4 class="text-success">Type: <b>{{packs.type}}</b></h4></td>
            <td><h4 class="text-warning">Code: <b>{{packs.code}}</b></h4></td>
    </tr>
    <tr>
        <td><h4 class="text-info">Class: <b>{{packs.class}}</b></h4></td>
        <td><h4 class="text-primary">Level: <b>{{packs.level}}</b></h4></td>
    </tr>
</tbody></table>
</div>
</ul>
{% if  (packs.comment1)|length>0 %}
<div style="margin-left:20px; margin-right:20px" class="alert alert-success"><center><strong>{{packs.comment1}}</strong></center></div>
{% endif %}
{% if  (packs.comment2)|length>0 %}
<div style="margin-left:20px; margin-right:20px" class="alert alert-info"><center><strong>{{packs.comment2}}</strong></center></div>
{% endif %}
<hr>
<h1><sup>$</sup>{{packs.price}}</h1>	
<p></p>
<a href="#" onclick="showpage('packs.php?act=get&id={{packs.Id}}');" class="btn btn-bricky">
Buy
</a>
</div></div>
{% endfor %}
</div>