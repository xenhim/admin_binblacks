<div class="page-header"><h1>Users<small> View / Add / Edit</small></h1></div></div></div>
<center><div class='panel panel-default' style='width:950px'><div class='panel-heading'>Add User</div>
<div class='panel-body'><table class='table table-striped table-bordered table-hover table-full-width' id='seller_1'>
<thead><tr><th width='150px'>User Id</th><th width='150px'>Username</th><th width='150px'>User Type</th><th width='150px'>Credit</th><th width='150px'>Reg Date</th><th width='150px'>Action</th></tr></thead><tbody>
{% if  (listUser|keys)|length>0 %}
{% for user in listUser %}
<tr>
<td class='tdCol' >{{user.userId}}</td>
<td class='tdCol' >{{user.username}}</td>
<td class='tdCol' ><font color='{{user.typeColor | raw}}'>{{user.typeName}}</font></td>
<td class='tdCol' >{{user.credit}}</td>
<td class='tdCol' >{{user.regDate}}</td>
<td class='tdCol' ><a href='#' onclick="showpage('user.php?act=edit&userid={{user.userId}}');" class="btn btn-xs btn-teal tooltips" data-placement="top" data-original-title="Edit"><i class="fa fa-edit"></i></a> 
<a href='#' onclick="if (confirm('Are you sure?')) {showpage('user.php?act=delete&userid={{user.userId}}');}"class="btn btn-xs btn-bricky tooltips" data-placement="top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></a></td>
</tr>
{% endfor %}
{% else %}
<tr><th colspan='4'><div class='errorMsg'>No user found.</div></th></tr>
{% endif %}
</tbody></table><center></div>
<center><a href='#' class="btn btn-green btn-lg btn-block" style="margin:10px; width:600px" onclick="showpage('user.php?act=add');">Add user</a></center>
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script type="text/javascript" src="../assets/plugins/select2/select2.min.js"></script>
		<script type="text/javascript" src="../assets/plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="../assets/plugins/DataTables/media/js/DT_bootstrap.js"></script>
		<script src="../assets/js/table-data.js"></script>
        <script src="../assets/plugins/bootstrap-modal/js/bootstrap-modal.js"></script>
		<script src="../assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js"></script>
		<script src="../assets/js/ui-modals.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY --><script>
			jQuery(document).ready(function() {
				TableData.init();
                UIModals.init();
			});
		</script>