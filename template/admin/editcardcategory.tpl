<div class="page-header"><h1>Category<small>edit</small></h1></div></div></div>
<center><div class='panel panel-default' style='width:650px'><div class='panel-heading'>Category Edit</div>
<form action='category.php?act=edit' method='POST' target='result'><table class='table table-bordered table-striped'>
<tr><th width='150px'>Name</th><th width='500px'>Value</th></tr>
{% if  (category|keys)|length>0 %}
<tr><td class='tdCol' width='150px'>Category Id</td><td class='tdCol' width='500px'>{{category.categoryId}}<input type='hidden' class='form-control' name='categoryid' value='{{category.categoryId}}' /></td></tr>
<tr><td class='tdCol' width='150px'>Category Name</td><td class='tdCol' width='500px'><input class='form-control' name='categoryname' value='{{category.categoryName}}' /></td></tr>
<tr><td class='tdCol' width='150px'>Category Description</td><td class='tdCol' width='500px'><input class='form-control' name='categoryinfo' value='{{category.categoryInfo}}' /></td></tr>
<tr><th colspan='2'><center><input type='button' class='btn btn-bricky' name='save' onclick="showpage('category.php');" value='Cancel' /> <input type='submit' class='btn btn-green' name='save' value='Save' /></center></th></tr>
<tr><th colspan='2'><iframe name='result' id='result' src='' style='border:none;height:30px;' ></iframe></th></tr>
{% else %}
<tr><th colspan='2'><div class='errorMsg'>This category is not available</div></th></tr>
{% endif %}
</table></form></center></div>