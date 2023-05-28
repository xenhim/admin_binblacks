<div class="page-header"><h1>Create Pack <small>admin panel</small></h1></div></div></div>
<div class="row"><div class="col-sm-12"><div class="panel panel-default"><div class="panel-heading"><i class="fa fa-external-link-square"></i> Create Pack</div>
<div class="panel-body">
<div class="row"><div class="col-md-12"><form action="packs.php?act=add" method="POST" target="result"><div class="col-md-6">
<div class="col-md-12"><div class="form-group"><label class="control-label">Title <span class="symbol required"></span></label><input class="form-control" name="title"></div>
<div class="form-group"><label class="control-label">Comment 1 </label><input class="form-control" name="comm1"></div>
<div class="form-group"><label class="control-label">Comment 2 </label><input class="form-control" name="comm2"></div></div>
<div class="col-md-6"><div class="form-group"><label class="control-label">Category </label><select name="category" class="form-control">
<option value='0'>All</option>
{% for category in listCategory %}
<option value='{{category.categoryId}}'>{{category.categoryName}}</option>
{% endfor %}
</select></div>
<div class="form-group"><label class="control-label">Country </label><select name="country" class="form-control">
<option value='0'>All</option>
{% for country in listCou %}
<option value='{{country.dumpCou}}'>{{country.dumpCou}} ({{country.count}})</option>
{% endfor %}
</select></div>
<div class="form-group"><label class="control-label">Code </label><select name="code" class="form-control">
<option value='0'>All</option>
{% for code in listcode %}
<option value='{{code.dumpcode}}'>{{code.dumpcode}} ({{code.count}})</option>
{% endfor %}
</select></div></div><div class="col-md-6">
<div class="form-group"><label class="control-label">Type </label><select name="type" class="form-control">
<option value='0'>All</option>
{% for type in listtype %}
<option value='{{type.dumptype}}'>{{type.dumptype}} ({{type.count}})</option>
{% endfor %}
</select></div>
<div class="form-group"><label class="control-label">Class </label><select name="class" class="form-control">
<option value='0'>All</option>
{% for dumpclass in listclass %}
<option value='{{dumpclass.dumpclass}}'>{{dumpclass.dumpclass}} ({{dumpclass.count}})</option>
{% endfor %}
</select></div>
<div class="form-group"><label class="control-label">Level </label><select name="level" class="form-control">
<option value='0'>All</option>
{% for level in listlevel %}
<option value='{{level.dumplevel}}'>{{level.dumplevel}} ({{level.count}})</option>
{% endfor %}
</select></div></div>
<div class="col-md-6"><div class="form-group"><label class="control-label">Quantity <span class="symbol required"></span></label><input class="form-control" name="quantity"></div>
<div class="form-group"><label class="control-label">Price <span class="symbol required"></span></label><input class="form-control" name="price"></div><p><hr></div>
<div class="col-md-6"><div class="form-group"><label class="control-label">Seller </label><select name="seller" class="form-control">
<option value='0'>All</option>
<option value='1'>Admin Only</option>
{% for seller in listSeller %}
<option value='{{seller.userId}}'>{{seller.username}}</option>
{% endfor %}
</select></div></div>
<div class="col-md-3"><div class="form-group"><label class="control-label">Seller precent <span class="symbol required"></span></label><input class="form-control" name="sellerprc"></div></div><div class="col-md-3"><div class="form-group">
<label class="control-label">No check (All Live) </label><select name="refund" class="form-control"><option value="0">No</option><option value="1">YES</option></select></div><p><hr></div>
<div id="row"><div class="col-md-6"><a href="#" class="btn btn-bricky btn-lg btn-block" onclick="showpage('packs.php');">Cancel</a></div><div class="col-md-6"><input type="submit" name="save" class="btn btn-green btn-lg btn-block" value="Save"></div></div><iframe name="result" id="result" src="" style="border:none;height:40px;"></iframe></form>
</div><div class="col-md-6"><center><h2>Example:</h2><hr></center>
<div id="pricing_table_example2" class="row"><div class="col-md-2"></div>
<div class="col-md-8">
<div class="pricing-table" style="margin:10px">
												<div class="top">
													<h2>BASIC VISA 101 PACK</h2>
												</div>
												<ul>
													<li>
														<strong>100</strong> Dumps
													</li>
													<li>
														<strong>Mix</strong> Country
													</li>
													<div class="well">
	<table style="width:100%">
    <tbody><tr>
        <td><h4 class="text-success">Type: <b>Visa</b></h4></td>
            <td><h4 class="text-warning">Code: <b>101</b></h4></td>
    </tr>
    <tr>
        <td><h4 class="text-info">Class: <b>All</b></h4></td>
        <td><h4 class="text-primary">Level: <b>All</b></h4></td>
    </tr>
</tbody></table>
													</div>
												</ul>
<div style="margin-left:20px; margin-right:20px" class="alert alert-success"><center><strong>Comment # 1</strong></center></div>
<div style="margin-left:20px; margin-right:20px" class="alert alert-info"><center><strong>Comment # 2</strong></center></div>
												<hr>
												<h1><sup>$</sup>499</h1>
												
												<p></p>
												<a href="#" class="btn btn-bricky">
													Buy
												</a>
											</div></div>
<div class="col-md-2"></div></div>
</div><div></div>
</div></div></div>