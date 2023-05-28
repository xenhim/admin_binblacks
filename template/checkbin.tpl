{% if type == 'page' %}
<div class="page-header"><h1>Bin checker<small> 1 line = 1 bin</small></h1></div></div></div>
<div class='col-md-12'>
<div class="row">
<div class="col-sm-8">
<h4>Example:</h4>
<div class="well">
<span>5457497</span><br>
<span>5457497921800000</span><br>
<span>5457497921800000|03|15|416</span><br>
<span>5457497921800000|0315|416</span><br>
<span>5457497921800000/0315/416</span><br>
<span>5457497921800000;0315;416;Maria De La Torre;Canada;ON;Brampton;L6Z0C7;5 Copperfield</span><br>
<span>5457497921800000|0315|416|Maria De La Torre|Canada|ON|Brampton|L6Z0C7|5 Copperfield</span>
</div>
</div>
<div class="col-sm-4">
<h4>Price:</h4>
<div class="well">
<center><h1 class="pulse">FREE</h1></center>
</div>
<p><center><h4>1 bin = 1 line</h4></center></p>
</div>
</div>
<hr>
<center><div class='panel panel-default'><div class='panel-heading'>Bin Checker</div>
<form action="" >
<textarea class="form-control" id="listcc" cols="120" rows="10"></textarea>
</div>
<p><button type=submit onclick="bincheck();" class="btn btn-green btn-lg btn-block">CHECK NOW</button>
</form></p></div>
{% endif %}

{% if type == 'result' %}
<div class="page-header"><h1>Bin checker<small> Result</small></h1></div></div></div>
<p><div class="panel-heading"><i class="fa fa-external-link-square"></i>BIN INFO</div>
<table class='table table-striped table-bordered table-hover'><tr><th>Card Number</th><th>Bank Name</th><th>Card Type</th><th>Country</th><th>Bank Phone</th></tr>
{{info | raw}}


</table>
<script src="assets/plugins/bootstrap-modal/js/bootstrap-modal.js"></script>
		<script src="assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js"></script>
		<script src="assets/js/ui-modals.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script>
			jQuery(document).ready(function() {
				UIModals.init();
			});
		</script>
        <div id="ajax-modal" class="modal fade" tabindex="-1" style="display: none;"></div>
{% endif %}