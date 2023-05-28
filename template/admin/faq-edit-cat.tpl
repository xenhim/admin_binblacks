<div class="page-header"><h1>FAQ Category<small>edit</small></h1></div></div></div>
<center><div class='panel panel-default' style='width:650px'><div class='panel-heading'>Category Edit</div>
<form action='faq.php?act=edit' method='POST' target='result'><table class='table table-bordered table-striped'>
<tr><th width='150px'>Name</th><th width='500px'>Value</th></tr>
{% if  (category|keys)|length>0 %}
<tr><td class='tdCol' width='150px'>Category Id</td><td class='tdCol' width='500px'>{{category.categoryId}}<input type='hidden' class='form-control' name='categoryid' value='{{category.categoryId}}' /></td></tr>
<tr><td class='tdCol' width='150px'>Category Name</td><td class='tdCol' width='500px'><input class='form-control' name='categoryname' value='{{category.categoryName}}' /></td></tr>
<tr><td class='tdCol' width='150px'>Icon (name)</td><td class='tdCol' width='500px'><input class='form-control' name='categoryicon' value='{{category.categoryIcon}}' /> <p style = 'margin-top: 10px;'><span class='btn btn-xs btn-primary' onclick="window.open('icons.html','top=15, left=20, width=600, height=300')"><i class='fa fa-dropbox'></i>| See all icons</span> (Copy icon name)</p><p class='text-info'>Example: "fa fa-credit-card" (double fa)</p> <p class='text-success'>Example 2: "clip-busy"</p></td></tr>
<tr><th colspan='2'><center><input type='button' class='btn btn-bricky' name='save' onclick="showpage('faq.php');" value='Cancel' /> <input type='submit' class='btn btn-green' name='save' value='Save' /></center></th></tr>
<tr><th colspan='2'><iframe name='result' id='result' src='' style='border:none;height:30px;' ></iframe></th></tr>
{% else %}
<tr><th colspan='2'><div class='errorMsg'>This FAQ category is not available</div></th></tr>
{% endif %}
</table></form></center></div>