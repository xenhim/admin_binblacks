<div class="page-header"><h1>News <small>and Updates</small></h1></div></div></div>
<div class="col-md-12">
{% if saledump == '1' %}
<div class="row">
<div class="col-sm-6"><div class="panel panel-default"><div class="panel-heading"><i class="fa fa-info-circle"></i> Dump News</div>
<div class="panel-body"><table class="table table-hover" id="sample-table-1"><thead><tr><th class="center" style="width:100px">Date</th><th>Info</th></tr></thead>
<tbody>
{% for dumpnews in listdumpnews %}
<tr>
<td class="center"><span class="label" style="background-color:{{dumpnews.color | raw}}">{{dumpnews.date | raw}}</span></td>
<td style="color:{{dumpnews.color | raw}}" class="text">{{dumpnews.text | raw}}</td>
</tr>
{% endfor %}
</tbody></table>
</div></div></div>
<div class="col-sm-6"><div class="panel panel-default"><div class="panel-heading"><i class="fa fa-credit-card"></i>Dumps Valid</div><div class="panel-body">
{% for dumpbase in listdumpbase %}
<div class="col-md-6">
<div class="easy-pie-chart">
<span class="basedump{{dumpbase.category | raw}} number" data-percent="{{dumpbase.precent | raw}}"> 
<span class="percent">{{dumpbase.precent | raw}}</span> </span>
</div><div style="margin: 10px;"><center><button type="button" onclick="showpage('dumps.php?cat={{dumpbase.category | raw}}&bin=&page=1&perpage=10');" class="btn btn-default btn-squared">{{dumpbase.categoryName | raw}}</button> </center></div></div>
{% endfor %}
</div></div></div></div><hr>
{% endif %}


{% if salecc == '1' %}
<center>
<div class="row">
<div class="col-sm"><div class="center panel panel-default">
    <!--<div class="panel-heading"><i class="fa fa-info-circle"></i>SELLCC.NET NEWS</div>-->
<div class="panel-body"><table class="table table-hover" id="sample-table-1"><thead><tr><th class="center" style="width:100px; color: #060101;">Date</th><th class="center" style="color: #060101;">Info</th></tr></thead>
<tbody>
    
{% for ccnews in listccnews %}

<tr>
<td class="center">
    <span class="label" style="background-color:{{ccnews.color | raw}}">{{ccnews.date | raw}}</span></td>
<td style="color:{{ccnews.color | raw}}" class="text"><type onclick="showpage('card.php?cat={{ccbase.category | raw}}&bin=&page=1&perpage=10');">{{ccbase.text | raw}}✅
{{ccnews.text | raw}}</type> 

</td>
</tr></center>
{% endfor %}
</tbody></table>
</div></div></div>
<!--
<div class="col-sm-6"><div class="panel panel-default"><div class="panel-heading"><i class="fa fa-credit-card"></i>Credit Cards Valid</div><div class="panel-body">
{% for ccbase in listccbase %}

<div class="col-md-6">
<div class="easy-pie-chart">
<span class="ccdump{{ccbase.category | raw}} number" data-percent="{{ccbase.precent | raw}}"> 
<span class="percent">{{ccbase.precent | raw}}</span> </span>
</div><div style="margin: 10px;"><center><button type="button" onclick="showpage('card.php?cat={{ccbase.category | raw}}&bin=&page=1&perpage=10');" class="btn btn-default btn-squared">{{ccbase.categoryName | raw}}</button> </center></div></div>

{% endfor %}
</div></div></div></div><hr>
{% endif %}
-->
<script src="/assets/plugins/bootstrap-colorpicker/js/commits.js"></script>
<script src="/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script src="/assets/plugins/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
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
                                $('.easy-pie-chart .basedump{{dumpbase.category | raw}}').easyPieChart({
									animate: 6000,
									lineWidth: 5,
									barColor: '{{dumpbase.color | raw}}',
									size: 80
									
								});
                                {% endfor %}
                                {% for ccbase in listccbase %}
                                $('.easy-pie-chart .ccdump{{ccbase.category | raw}}').easyPieChart({
									animate: 6000,
									lineWidth: 5,
									barColor: '{{ccbase.color | raw}}',
									size: 80
									
								});
                                {% endfor %}
							});
</script>