<div class="page-header"><h1>News <small>admin panel</small></h1></div></div></div>
<div class="col-md-12"><div class="row">
<div class="col-sm-6"><div class="panel panel-default"><div class="panel-heading"><i class="fa fa-info-circle"></i> Dump News</div>
<div class="panel-body"><table class="table table-hover" id="sample-table-1"><thead><tr><th class="center" style="width:100px">Date</th><th>Info</th></tr></thead>
<tbody>
{% for dumpnews in listdumpnews %}
<tr><td class="center"><span class="label" style="background-color:{{dumpnews.color}}">{{dumpnews.date}}</span></td><td style="color:{{dumpnews.color}}" class="text">{{dumpnews.text}}
<a href="#" style="float:right" onclick="if (confirm('Are you sure?')) {showpage('news.php?act=delete&id={{dumpnews.id}}');}" class="btn btn-xs btn-bricky tooltips" data-placement="top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></a>
</td></tr>
{% endfor %}
</tbody></table><hr><p>
<div class="col-md-2"><input data-date-format="dd.mm.yyyy" placeholder="Date..." data-date-viewmode="years" id="date" class="form-control date-picker" type="text"></div><div class="col-md-8"><input id="text" placeholder="Enter text..." class="form-control" type="text"></div><div class="col-md-2"><input id="newsco" data-colorpicker-guid="1" value="#555" class="form-control color-picker" type="text"></div>
<div class="col-md-12"><button onclick="showpage('./news.php?act=addnewsdump&date='+document.getElementById('date').value+'&text='+document.getElementById('text').value+'&color='+encodeURIComponent(document.getElementById('newsco').value)+'&save=Save');" type='button' style='float: right; margin-top:10px;' class='btn btn-success'>Save</button></div></div></div></div>

<div class="col-sm-6"><div class="panel panel-default"><div class="panel-heading"><i class="fa fa-credit-card"></i>Dumps Valid</div><div class="panel-body">
{% for dumpbase in listdumpbase %}
<div class="col-md-6">
<div class="easy-pie-chart">
<span class="basedump{{dumpbase.category | raw}} number" data-percent="{{dumpbase.precent | raw}}"> 
<span class="percent">{{dumpbase.precent | raw}}</span> </span>
</div><div style="margin: 10px;"><center><button type="button" onclick="showpage('dumps.php?cat={{dumpbase.category | raw}}&bin=&page=1&perpage=10');" class="btn btn-default btn-squared">{{dumpbase.categoryName | raw}}</button> 
<a href="#" onclick="if (confirm('Are you sure?')) {showpage('news.php?act=basedelete&id={{dumpbase.id}}');}" class="btn btn-bricky btn-squared"><i class="fa fa-times fa fa-white"></i></a>
</center></div></div>
{% endfor %}
<hr><p>
<div class="col-md-6"><select id="dcategory" style="width: 100%;">
{% for category in listCategory %}
<option value='{{category.categoryId}}'>{{category.categoryName}}</option>
{% endfor %}
</select></div>
<div class="col-md-3"><input id="dprecent" placeholder="Precent..." style="margin-top:3px" class="form-control" type="text"></div>
<div class="col-md-3"><input id="dbcolor" data-colorpicker-guid="1" style="margin-top:3px" value="#8fff00" class="form-control color-picker" type="text"></div>
<div class="col-md-12"><button onclick="showpage('./news.php?act=addbasedump&dprecent='+document.getElementById('dprecent').value+'&dcategory='+document.getElementById('dcategory').options[document.getElementById('dcategory').selectedIndex].value+'&dcolor='+encodeURIComponent(document.getElementById('dbcolor').value)+'&save=Save');" type='button' style='float: right; margin-top:10px;' class='btn btn-success'>Save</button>
</div></div></div></div></div>

<hr>

<div class="row">
<div class="col-sm-6"><div class="panel panel-default"><div class="panel-heading"><i class="fa fa-info-circle"></i> Credit Card News</div>
<div class="panel-body"><table class="table table-hover" id="sample-table-1"><thead><tr><th class="center" style="width:100px">Date</th><th>Info</th></tr></thead>
<tbody>
{% for ccnews in listccnews %}
<tr><td class="center"><span class="label" style="background-color:{{ccnews.color | raw}}">{{ccnews.date}}</span></td><td style="color:{{ccnews.color | raw}}" class="text">{{ccnews.text | raw}}
<a href="#" style="float:right" onclick="if (confirm('Are you sure?')) {showpage('news.php?act=delete&id={{ccnews.id}}');}" class="btn btn-xs btn-bricky tooltips" data-placement="top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></a>
</td></tr>
{% endfor %}
</tbody></table>
<hr><p>
<div class="col-md-2"><input id="ccdate" data-date-format="dd.mm.yyyy" placeholder="Date..." data-date-viewmode="years" class="form-control date-picker" type="text"></div><div class="col-md-8"><input id="cctext" placeholder="Enter text..." class="form-control" type="text"></div><div class="col-md-2"><input id="cccolor" data-colorpicker-guid="1" value="#555" class="form-control color-picker" type="text"></div>
<div class="col-md-12"><button onclick="showpage('./news.php?act=addnewscc&date='+document.getElementById('ccdate').value+'&text='+document.getElementById('cctext').value+'&color='+encodeURIComponent(document.getElementById('cccolor').value)+'&save=Save');" type='button' style='float: right; margin-top:10px;' class='btn btn-success'>Save</button></div></div></div></div>

<div class="col-sm-6"><div class="panel panel-default"><div class="panel-heading"><i class="fa fa-credit-card"></i>Credit Cards Valid</div><div class="panel-body">
{% for ccbase in listccbase %}
<div class="col-md-6"><div class="easy-pie-chart"><span class="ccdump{{ccbase.category | raw}} number" data-percent="{{ccbase.precent | raw}}"> <span class="percent">{{ccbase.precent | raw}}</span> </span></div><div style="margin: 10px;"><center><button type="button" onclick="showpage('card.php?cat={{ccbase.category | raw}}&bin=&page=1&perpage=10');" class="btn btn-default btn-squared">{{ccbase.categoryName}}</button>
<a href="#" onclick="if (confirm('Are you sure?')) {showpage('news.php?act=basedelete&id={{ccbase.id}}');}" class="btn btn-bricky btn-squared"><i class="fa fa-times fa fa-white"></i></a>
</center></div></div>
{% endfor %}
<hr><p>

<div class="col-md-6"><select id="cccategory" style="width: 100%;">
{% for dumpcategory in dumplistCategory %}
<option value='{{dumpcategory.categoryId}}'>{{dumpcategory.categoryName}}</option>
{% endfor %}
</select></div>
<div class="col-md-3"><input id="ccprecent" placeholder="Precent..." class="form-control" style="margin-top:3px" type="text"></div>
<div class="col-md-3"><input id="bcccolor" data-colorpicker-guid="1" style="margin-top:3px" value="#8fff00" class="form-control color-picker" type="text"></div>
<div class="col-md-12"><button onclick="showpage('./news.php?act=addbasecc&ccprecent='+document.getElementById('ccprecent').value+'&cccategory='+document.getElementById('cccategory').options[document.getElementById('cccategory').selectedIndex].value+'&cccolor='+encodeURIComponent(document.getElementById('bcccolor').value)+'&save=Save');" type='button' style='float: right; margin-top:10px;' class='btn btn-success'>Save</button>
</div></div></div></div></div>
<script src="../assets/plugins/bootstrap-colorpicker/js/commits.js"></script>
<script src="../assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="../assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script src="../assets/plugins/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
<script>
$('.date-picker').datepicker({
autoclose: true
});
$('.color-picker').colorpicker({
format: 'hex'
});
</script>
<script> $(document).ready(function() { 
$("#dcategory").select2();
$("#cccategory").select2();
});
</script>
<script type="text/javascript">
							$(function () {
								if (isIE8 || isIE9) {
									if (!Function.prototype.bind) {
										Function.prototype.bind = function (oThis) {
											if (typeof this !== "function") {
												// closest thing possible to the ECMAScript 5 internal IsCallable function
												throw new TypeError("Function.prototype.bind - what is trying to be bound is not callable");
											}
											var aArgs = Array.prototype.slice.call(arguments, 1),
											fToBind = this,
											fNOP = function () {}, fBound = function () {
												return fToBind.apply(this instanceof fNOP && oThis ? this : oThis, aArgs.concat(Array.prototype.slice.call(arguments)));
											};
											fNOP.prototype = this.prototype;
											fBound.prototype = new fNOP();
											return fBound;
										};
									}
								}
                                {% for dumpbase in listdumpbase %}
                                $('.easy-pie-chart .basedump{{dumpbase.category}}').easyPieChart({
									animate: 6000,
									lineWidth: 5,
									barColor: '{{dumpbase.color | raw}}',
									size: 80
									
								});
                                {% endfor %}
                                {% for ccbase in listccbase %}
                                $('.easy-pie-chart .ccdump{{ccbase.category}}').easyPieChart({
									animate: 6000,
									lineWidth: 5,
									barColor: '{{ccbase.color | raw}}',
									size: 80
									
								});
                                {% endfor %}
							});
</script>