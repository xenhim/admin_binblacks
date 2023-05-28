<div class="page-header"><h1>Users<small> Add user</small></h1></div></div></div>
<center><div class='panel panel-default' style='width:650px'><div class='panel-heading'>Add User</div>
<form action='user.php?act=add' method='POST' target='result'><table class='table table-bordered table-striped'>
<tr><th width='150px'>Name</th><th width='500px'>Value</th></tr>
{% if  (listType|keys)|length>0 %}
<tr><td class='tdCol' width='150px'>Username</td><td class='tdCol' width='500px'><input class='form-control' name='username' value='' /></td></tr>
<tr><td class='tdCol' width='150px'>Jabber</td><td class='tdCol' width='500px'><input class='form-control' name='email' value='' /></td></tr>
<tr><td class='tdCol' width='150px'>Password</td><td class='tdCol' width='500px'><input class='form-control' name='password' value='' /></td></tr>
<tr><td class='tdCol' width='150px'>User Type</td><td class='tdCol' width='500px'><select class='form-control' name='typeid' >
{% for type in listType %}
<option value='{{type.typeId}}'>{{type.typeName}}</option>
{% endfor %}
</select></td></tr>
<tr><td class='tdCol' width='150px'>Credit</td><td class='tdCol' width='500px'><input class='form-control' name='credit' value='' /></td></tr>
<tr><th colspan='2'><center><input type='button' class='btn btn-bricky' name='save' onclick="showpage('user.php');" value='Cancel' /> <input type='submit' class='btn btn-green' name='save' value='Save' /></center></th></tr>
<tr><th colspan='2'><iframe name='result' id='result' src='' style='border:none;height:30px;' ></iframe></th></tr>
{% else %}
<tr><th colspan='2'><div class='errorMsg'>No user type found.</div></th></tr>
{% endif %}
</table></form></center></div>