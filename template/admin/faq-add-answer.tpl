<div class="page-header"><h1>Answer<small>add</small></h1></div></div></div>
<center><div class='panel panel-default' style='width:650px'><div class='panel-heading'>Add category</div>
<form action='faq.php?act=addanswer' method='POST' target='result'><table class='table table-bordered table-striped'>
<tr><th width='150px'>Name</th><th width='500px'>Value</th></tr>
<tr><td class='tdCol' width='150px'>Question</td><td class='tdCol' width='500px'><input class='form-control' name='question' value='' /></td></tr>
<tr><td class='tdCol' width='150px'>Answer</td><td class='tdCol' width='500px'><textarea name='answer' style='width:100%;height:100px;'></textarea></td></tr>
<tr><td class='tdCol' width='150px'>Category (*)</td><td class='tdCol' width='500px'><select class='form-control' name='category' >
{% for category in listCategory %}
<option value='{{category.categoryId}}'>{{category.categoryName}}</option>
{% endfor %}
</select></td></tr>
<tr><th colspan='2'><center><input type='button' class='btn btn-bricky' name='save' onclick="showpage('faq.php');" value='Cancel' /> <input type='submit' class='btn btn-green' name='save' value='Save' /></center></th></tr>
<tr><th colspan='2'><iframe name='result' id='result' src='' style='border:none;height:30px;' ></iframe></th></tr>
</table></form></div></center>