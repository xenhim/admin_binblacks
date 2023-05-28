<div class='page-header'><h1>My Packs <small> open</small></h1></div></div></div><table class='table table-striped table-bordered table-hover'>
<tr><td><b>Id</b></td><td><b>Name</b></td><td><b>Category</b></td><td><b>Type</b></td><td><b>Level</b></td><td><b>Class</b><td><b>Code</b></td><td><b>Counry</b></td><td><b>Quantity</b></td></td><td><b>Date</b></td><td>Action</td></tr>
{% if  (listCard|keys)|length>0 %}
{% for card in listCard %}
<tr>
<td class='tdCol' style='font-size:12px;'><center>
{{card.id}}
</center></td>
<td class='tdCol' style='font-size:12px;'><center>
{{card.name}}
</center></td>
<td class='tdCol' style='font-size:12px;'><center>
{% if card.categoryname == '0' %}
<span class="label label-default"> All</span>
{% else %}
<span class="label label-default"> {{card.categoryname}}</span>
{% endif %}
</center></td>
<td class='tdCol' style='font-size:12px;'><center>
{% if card.type == '0' %}
<span class="label label-info"> All</span>
{% else %}
<span class="label label-info"> {{card.type}}</span>
{% endif %}
</center></td>
<td class='tdCol' style='font-size:12px;'><center>
{% if card.level == '0' %}
<span class="label label-success"> All</span>
{% else %}
<span class="label label-success"> {{card.level}}</span>
{% endif %}
</center></td>
<td class='tdCol' style='font-size:12px;'><center>
{% if card.class == '0' %}
<span class="label label-warning"> All</span>
{% else %}
<span class="label label-warning"> {{card.class}}</span>
{% endif %}
</center></td>
<td class='tdCol' style='font-size:12px;'><center>
{% if card.code == '0' %}
<span class="label label-danger"> All</span>
{% else %}
<span class="label label-danger"> {{card.code}}</span>
{% endif %}
</center></td>
<td class='tdCol' style='font-size:12px;'><center>
{% if card.country == '0' %}
<span class="label label-inverse"> All</span>
{% else %}
<span class="label label-inverse"> {{card.country}}</span>
{% endif %}
</center></td>
<td class='tdCol' style='font-size:12px;'><center>
<span class='badge'>{{card.value}}</span>
</center></td>
<td class='tdCol' style='font-size:12px;'><center>
{{card.sdate}}
</center></td>
<td class='tdCol' style='font-size:12px;'><center>
<a type="button" onclick="showpage('packs.php?act=open&id={{card.id}}');" class="btn btn-success">Open</a>
</center></td></tr>
{% endfor %}
{% else %}
<tr><th colspan='11'>No packs found.</th></tr>
{% endif %}
</table><th>