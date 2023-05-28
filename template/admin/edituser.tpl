<div class="page-header"><h1>Users<small> edit user</small></h1></div></div></div>
<center><div class='panel panel-default' style='width:650px'><div class='panel-heading'>Edit User</div>
<form action='user.php?act=edit' method='POST' target='result'><table class='table table-bordered table-striped'>
<tr><th width='150px'>Name</th><th width='500px'>Value</th></tr>
{% if found == '1' %}
<tr><td class='tdCol' width='150px'>User Id</td><td class='tdCol' width='500px'><input class='form-control' name='userid' type='hidden' value='{{userid}}' />{{userid}}</td></tr>
<tr><td class='tdCol' width='150px'>Username</td><td class='tdCol' width='500px'>{{user.username}}<input type='hidden' class='form-control' name='username' value='{{user.username}}' /></td></tr>
<tr><td class='tdCol' width='150px'>Password<br /><font color='#ff0000'>(Leave it blank if don't want change)</font></td><td class='tdCol' width='500px'><input class='form-control' name='password' value='' /></td></tr>
<tr><td class='tdCol' width='150px'>Jabber<br /></td><td class='tdCol' width='500px'><input class='form-control' name='email' value='{{user.jabber}}' /></td></tr>
<tr><td class='tdCol' width='150px'>User Type</td><td class='tdCol' width='500px'>
<select name='typeid' class='form-control' >
{% for type in listType %}
<option value='{{type.typeId}}' {% if user.typeId == type.typeId %} selected {% endif %}>{{type.typeName}}</option>
{% endfor %}
</select>
</td></tr>
<tr><td class='tdCol' width='150px'>Credit</td><td class='tdCol' width='500px'><input class='form-control' name='credit' value='{{user.credit}}' /></td></tr>
<tr><th colspan='2'><center><input type='button' class='btn btn-bricky' name='save' onclick="showpage('user.php');" value='Cancel' /> <input type='submit' class='btn btn-green' name='save' value='Save' /></center></th></tr>
<tr><th colspan='2'><iframe name='result' id='result' src='' style='border:none;height:30px;' ></iframe></th></tr>
{% else %}
<tr><th colspan='2'><div class='errorMsg'>This user is not available</div></th></tr>
{% endif %}
</table></form></center></div>