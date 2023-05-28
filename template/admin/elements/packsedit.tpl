<div class="page-header"><h1>Edit Pack <small>admin panel</small></h1></div></div></div>
<div class="row"><div class="col-sm-12"><div class="panel panel-default"><div class="panel-heading"><i class="fa fa-external-link-square"></i> Edit Pack</div>
<div class="panel-body">
<div class="row"><div class="col-md-12"><form action="packs.php?act=save&id={{pack.Id}}" method="POST" target="result"><div class="col-md-6">
<div class="col-md-12"><div class="form-group"><label class="control-label">Title <span class="symbol required"></span></label><input class="form-control" value="{{pack.name}}" name="title"></div>
<div class="form-group"><label class="control-label">Comment 1 </label><input class="form-control" value="{{pack.comment1}}" name="comm1"></div>
<div class="form-group"><label class="control-label">Comment 2 </label><input class="form-control" value="{{pack.comment2}}" name="comm2"></div></div>
<div class="col-md-6"><div class="form-group"><label class="control-label">Category </label><select name="category" class="form-control">
<option value='0'>All</option>
{% for category in listCategory %}
<option value='{{category.categoryId}}'{% if category.categoryId == pack.categoryId %} selected {% endif %} >{{category.categoryName}}</option>
{% endfor %}
</select></div>
<div class="form-group"><label class="control-label">Country </label><select name="country" class="form-control">
<option value='0'>All</option>
{% for country in listCou %}
<option value='{{country.dumpCou}}'{% if country.dumpCou == pack.country %} selected {% endif %} >{{country.dumpCou}} ({{country.count}})</option>
{% endfor %}
</select></div>
<div class="form-group"><label class="control-label">Code </label><select name="code" class="form-control">
<option value='0'>All</option>
{% for code in listcode %}
<option value='{{code.dumpcode}}'{% if code.dumpcode == pack.code %} selected {% endif %} >{{code.dumpcode}} ({{code.count}})</option>
{% endfor %}
</select></div></div><div class="col-md-6">
<div class="form-group"><label class="control-label">Type </label><select name="type" class="form-control">
<option value='0'>All</option>
{% for type in listtype %}
<option value='{{type.dumptype}}'{% if type.dumptype == pack.type %} selected {% endif %} >{{type.dumptype}} ({{type.count}})</option>
{% endfor %}
</select></div>
<div class="form-group"><label class="control-label">Class </label><select name="class" class="form-control">
<option value='0'>All</option>
{% for dumpclass in listclass %}
<option value='{{dumpclass.dumpclass}}'{% if dumpclass.dumpclass == pack.class %} selected {% endif %} >{{dumpclass.dumpclass}} ({{dumpclass.count}})</option>
{% endfor %}
</select></div>
<div class="form-group"><label class="control-label">Level </label><select name="level" class="form-control">
<option value='0'>All</option>
{% for level in listlevel %}
<option value='{{level.dumplevel}}'{% if level.dumplevel == pack.level %} selected {% endif %} >{{level.dumplevel}} ({{level.count}})</option>
{% endfor %}
</select></div></div>
<div class="col-md-6"><div class="form-group"><label class="control-label">Quantity <span class="symbol required"></span></label><input class="form-control" value="{{pack.value}}" name="quantity"></div>
<div class="form-group"><label class="control-label">Price <span class="symbol required"></span></label><input class="form-control" value="{{pack.price}}" name="price"></div><p><hr></div>
<div class="col-md-6"><div class="form-group"><label class="control-label">Seller </label><select name="seller" class="form-control">
<option value='0'>All</option>
<option value='1'>Admin Only</option>
{% for seller in listSeller %}
<option value='{{seller.userId}}'{% if seller.userId == pack.seller %} selected {% endif %} >{{seller.username}}</option>
{% endfor %}
</select></div></div>
<div class="col-md-3"><div class="form-group"><label class="control-label">Seller precent <span class="symbol required"></span></label><input class="form-control" value="{{pack.sellerprc}}" name="sellerprc"></div></div><div class="col-md-3"><div class="form-group">
<label class="control-label">No check (All Live) </label><select name="refund" class="form-control">
<option value="0"{% if pack.norefund == '0' %} selected {% endif %} >No</option>
<option value="1"{% if pack.norefund == '1' %} selected {% endif %} >YES</option>
</select></div><p><hr></div>
<div id="row"><div class="col-md-6"><a href="#" class="btn btn-bricky btn-lg btn-block" onclick="showpage('packs.php');">Cancel</a></div><div class="col-md-6"><input type="submit" name="save" class="btn btn-green btn-lg btn-block" value="Save"></div></div><iframe name="result" id="result" src="" style="border:none;height:40px;"></iframe></form>
</div><div class="col-md-6"><center><h2>Example:</h2><hr></center>
<div id="pricing_table_example2" class="row"><div class="col-md-2"></div>
<div class="col-md-8">
<div class="pricing-table" style="margin:10px">
												<div class="top">
													<h2>{{pack.name}}</h2>
												</div>
												<ul>
													<li>
														<strong>{{pack.value}}</strong> Dumps
													</li>
													<li>
														<strong>
                                                        {% if pack.country == '0' %}
                                                        Mix Country
                                                        {% else %}
                                                        {{pack.country}}
                                                        {% endif %}
                                                        </strong>
													</li>
													<div class="well">
	<table style="width:100%">
    <tbody><tr>
        <td><h4 class="text-success">Type: <b>{% if pack.type == '0' %}
                                                        All
                                                        {% else %}
                                                        {{pack.type}}
                                                        {% endif %}
                                                        </b></h4></td>
            <td><h4 class="text-warning">Code: <b>{% if pack.code == '0' %}
                                                        All
                                                        {% else %}
                                                        {{pack.code}}
                                                        {% endif %}</b></h4></td>
    </tr>
    <tr>
        <td><h4 class="text-info">Class: <b>{% if pack.class == '0' %}
                                                        All
                                                        {% else %}
                                                        {{pack.class}}
                                                        {% endif %}</b></h4></td>
        <td><h4 class="text-primary">Level: <b>{% if pack.level == '0' %}
                                                        All
                                                        {% else %}
                                                        {{pack.level}}
                                                        {% endif %}</b></h4></td>
    </tr>
</tbody></table>
													</div>
												</ul>
{% if pack.comment1|length>0 %}
<div style="margin-left:20px; margin-right:20px" class="alert alert-success"><center><strong>{{pack.comment1}}</strong></center></div>
{% endif %}
{% if pack.comment2|length>0 %}
<div style="margin-left:20px; margin-right:20px" class="alert alert-info"><center><strong>{{pack.comment2}}</strong></center></div>
{% endif %}
												<hr>
												<h1><sup>$</sup>{{pack.price}}</h1>
												
												<p></p>
												<a href="#" class="btn btn-bricky">
													Buy
												</a>
											</div></div>
<div class="col-md-2"></div></div>
</div><div></div>
</div></div></div>