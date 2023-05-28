<div class="page-header"><h1>Dumps Category<small>add / edit / remove</small></h1></div></div></div>
<center><div class='panel panel-default' style='width:750px'><div class='panel-heading'>Category</div>
<table class='table table-bordered table-striped'>
<tr><td class='tdColTitle' width='100px'>Category Id</td><td class='tdColTitle' width='150px'>Category Name</td><td class='tdColTitle' width='200px'>Category Description</td><td class='tdColTitle' width='100px'>Action</td></tr>
{% if  (listCategory|keys)|length>0 %}
{% for category in listCategory %}
<tr>
<td class='tdCol' >{{category.categoryId}}</td>
<td class='tdCol' >{{category.categoryName}}</td>
<td class='tdCol' >{{category.categoryInfo}}</td>
<td class='tdCol' ><a href="#" onclick="showpage('dumpcategory.php?act=edit&categoryid={{category.categoryId}}');" class="btn btn-xs btn-teal tooltips" data-placement="top" data-original-title="Edit"><i class="fa fa-edit"></i></a> <a href="#" onclick="if (confirm('Are you sure?')) {showpage('dumpcategory.php?act=delete&categoryid={{category.categoryId}}');}" class="btn btn-xs btn-bricky tooltips" data-placement="top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></a></td>
</tr>
{% endfor %}
{% else %}
<tr><th colspan='4'><div class='errorMsg'>No category found.</div></th></tr>
{% endif %}
</table></div>
<div id='admin_card_menu'><a href='#' style='width:750px' class='btn btn-green btn-lg btn-block' onclick="showpage('dumpcategory.php?act=add');">Add Category</a></div></center>