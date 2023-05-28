<div class="page-header"><h1>Dump Category<small>add</small></h1></div></div></div>
<center><div class='panel panel-default' style='width:650px'><div class='panel-heading'>Add category</div>
<form action='dumpcategory.php?act=add' method='POST' target='result'><table class='table table-bordered table-striped'>
<tr><th width='150px'>Name</th><th width='500px'>Value</th></tr>
<tr><td class='tdCol' width='150px'>Category Name</td><td class='tdCol' width='500px'><input class='form-control' name='categoryname' value='' /></td></tr>
<tr><td class='tdCol' width='150px'>Category Description</td><td class='tdCol' width='500px'><input class='form-control' name='categoryinfo' value='' /></td></tr>
<tr><th colspan='2'><center><input type='button' class='btn btn-bricky' name='save' onclick="showpage('dumpcategory.php');" value='Cancel' /> <input type='submit' class='btn btn-green' name='save' value='Save' /></center></th></tr>
<tr><th colspan='2'><iframe name='result' id='result' src='' style='border:none;height:30px;' ></iframe></th></tr>
</table></form></div></center>