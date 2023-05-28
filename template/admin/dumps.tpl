<div class="page-header"><h1>Dumps <small>admin panel</small></h1></div></div></div>
<div class="panel-heading"><i class="fa fa-credit-card"></i>Dumps</div><div class="panel-body"><div class="form-inline">

{% include "admin/elements/dumpsort.tpl" %}

<table class='table table-striped table-bordered table-hover'>
<tr><td><b>Card Id</b></td><td><b>Number</b></td><td><b>Type</b></td><td><b>Level</b></td><td><b>Class</b></td><td><b>Code</b></td><td><b>Exp Date</b></td><td><b>Category</b></td><td><b>Country</b></td><td><b>Bank</b></td><td><b>User</b></td><td><b>Status</b></td><td><b>Action</b></td></tr>
{% if found == '1' %}
{% for card in listCard %}
<tr>
<td class='tdCol' >{{card.dumpId}}</td>
<td class='tdCol' >{{card.dumpNum | slice(0,6)}}</td>
<td class='tdCol' >{{card.dumptype}}</td>
<td class='tdCol' >{{card.dumplevel}}</td>
<td class='tdCol' >{{card.dumpclass}}</td>
<td class='tdCol' >{{card.dumpcode}}</td>
<td class='tdCol' >{{card.dumpMon}}/{{card.dumpYea}}</td>
<td class='tdCol' >{{card.categoryName}}</td>
<td class='tdCol' >{{card.dumpCou}}</td>
<td class='tdCol' >{{card.dumpbank}}</td>
<td class='tdCol' >{{card.username}}</td>
<td class='tdCol' >
{% if card.status == '1' %}
<span class='label label-success'>Live</span>
{% elseif card.status == '2' %}
<span class='label label-danger'>Dead</span>
{% elseif card.status == '3' %}
<span class='label label-warning'>Error</span>
{% elseif card.status == '4' %}
<span class='label label-info'>Unknown</span>
{% elseif card.status == '5' %}
<span class='label label-info'>Time Off</span>
{% else %}
<span class='label label-inverse'>None</span>
{% endif %}
</td>
<td class='tdCol' ><a href="#" onclick="editcard('dumps.php?act=edit&cardid={{card.dumpId}}');" class="btn btn-xs btn-teal tooltips" data-placement="top" data-original-title="Edit"><i class="fa fa-edit"></i></a> <a href="#" onclick="if (confirm('If u delete this, user will can\'t see it in \'My dumps\' list. Are you sure?')) {showpage('dumps.php?act=delete&cardid={{card.dumpId}}');}" class="btn btn-xs btn-bricky tooltips" data-placement="top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></a>
</td></tr>
{% endfor %}
{% else %}
<tr><th colspan='13'><div class='errorMsg'>No card found.</div></th></tr>
{% endif %}
</table></div></div></div>
<script> $(document).ready(function() { 
				$("#catid").select2(); 
				$("#type").select2();
                $("#code").select2();
                $("#level").select2();
                $("#class").select2();
                $("#cardcountry").select2();
                $("#bank").select2();
                $("#cardpage").select2();
                $("#showUsed").select2(); 
                $("#cardPerPage").select2(); 
                $("#cardbin").select2({
    tags:[],
    containerCssClass: "massbin",
    tokenSeparators: [",", " "]});
				});
                </script>
                <script src="../assets/plugins/bootstrap-modal/js/bootstrap-modal.js"></script>
                <script src="../assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js"></script>
                <div id="ajax-modal" class="modal fade" tabindex="-1" style="display: none;"></div>
                <div><a href='#' class='btn btn-green btn-lg btn-block' style='margin-top:20px' onclick="showpage('dumps.php?act=add');">Import Dumps</a><p></div>