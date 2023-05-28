{% if type == 'head' %}
<div class="page-header"><h1>FAQ<small>  add / edit / remove</small></h1></div></div></div>
<div class="row"><div class="col-md-12">
{% endif %}

{% if type == 'menu' %}
<div class="tabbable tabs-left">
<ul id="myTab3" class="nav nav-tabs tab-teal" style="width:250px">
{% for key, category in listCategory %}
{% if key == '0' %}
<li class="active"><a href="#faq_{{category.categoryId}}" data-toggle="tab"><i class="{{category.categoryIcon}}"></i> {{category.categoryName}} &nbsp&nbsp<span onclick="if (confirm('Are you sure?')) {showpage('faq.php?act=delete&categoryid={{category.categoryId}}');}" class="btn btn-xs btn-bricky tooltips" style = 'float: right; margin-right: 5px; margin-top: -4px;' data-placement="top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></span> <span onclick="showpage('faq.php?act=edit&categoryid={{category.categoryId}}');" class="btn btn-xs btn-teal tooltips" style = 'float: right; margin-right: 5px; margin-top: -4px;' data-placement="top" data-original-title="Edit"><i class="fa fa-edit"></i></span>
</a></li>
{% else %}
<li class=""><a href="#faq_{{category.categoryId}}" data-toggle="tab"><i class="{{category.categoryIcon}}"></i> {{category.categoryName}} &nbsp&nbsp<span onclick="if (confirm('Are you sure?')) {showpage('faq.php?act=delete&categoryid={{category.categoryId}}');}" class="btn btn-xs btn-bricky tooltips" style = 'float: right; margin-right: 5px; margin-top: -4px;' data-placement="top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></span> <span onclick="showpage('faq.php?act=edit&categoryid={{category.categoryId}}');" class="btn btn-xs btn-teal tooltips" style = 'float: right; margin-right: 5px; margin-top: -4px;' data-placement="top" data-original-title="Edit"><i class="fa fa-edit"></i></span>
</a></li>
{% endif %}
{% endfor %}
<li><p><center><span class='btn btn-green' onclick="showpage('faq.php?act=add');"> <i class='fa fa-plus'></i> Add new Category</span></center></p></li>
</ul><div class="tab-content">
{% endif %}

{% if type == 'content' %}
{% if active == '1' %}
<div class="tab-pane active" id="faq_{{category.categoryId}}">
{% else %}
<div class="tab-pane" id="faq_{{category.categoryId}}">
{% endif %}
<div id="accordion" class="panel-group accordion accordion-custom accordion-teal">
{% if found == '1' %}
{% for key, answer in answers %}
{% if key == '0' %}
<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a href="#faq_{{answer.categoryId}}_{{answer.Id}}" data-parent="#accordion" data-toggle="collapse" class="accordion-toggle"><i class="icon-arrow"></i>
{{answer.question | raw}}
<span onclick="if (confirm('Are you sure?')) {showpage('faq.php?act=deleteanswer&answerid={{answer.Id}}');}" class="btn btn-xs btn-bricky tooltips" style = 'float: right; margin-right: 5px; margin-top: -4px;' data-placement="top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></span> <span onclick="showpage('faq.php?act=editanswer&answerid={{answer.Id}}');" class="btn btn-xs btn-teal tooltips" style = 'float: right; margin-right: 5px; margin-top: -4px;' data-placement="top" data-original-title="Edit"><i class="fa fa-edit"></i></span>
</a></h4></div><div class="panel-collapse in" id="faq_{{answer.categoryId}}_{{answer.Id}}"><div class="panel-body">
{{answer.answer | raw}}
</div></div></div>
{% else %}
<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a href="#faq_{{answer.categoryId}}_{{answer.Id}}" data-parent="#accordion" data-toggle="collapse" class="accordion-toggle collapsed"><i class="icon-arrow"></i>
{{answer.question | raw}}
<span onclick="if (confirm('Are you sure?')) {showpage('faq.php?act=deleteanswer&answerid={{answer.Id}}');}" class="btn btn-xs btn-bricky tooltips" style = 'float: right; margin-right: 5px; margin-top: -4px;' data-placement="top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></span> <span onclick="showpage('faq.php?act=editanswer&answerid={{answer.Id}}');" class="btn btn-xs btn-teal tooltips" style = 'float: right; margin-right: 5px; margin-top: -4px;' data-placement="top" data-original-title="Edit"><i class="fa fa-edit"></i></span>
</a></h4></div><div class="panel-collapse collapse" id="faq_{{answer.categoryId}}_{{answer.Id}}"><div class="panel-body">
{{answer.answer | raw}}
</div></div></div>
{% endif %}
{% endfor %}
{% else %}
<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a href="#faq_{{category.categoryId}}" data-parent="#accordion" data-toggle="collapse" class="accordion-toggle"><i class="icon-arrow"></i>
No Answer found.
</a></h4></div><div class="panel-collapse collapse in" id="faq_{{category.categoryId}}"><div class="panel-body">
No Answer found.
</div></div></div>
{% endif %}
<p><center><a href='#' class='btn btn-info btn-lg btn-block' onclick="showpage('faq.php?act=addanswer');">Add New Answer</a></center></p>
</div></div>
{% endif %}

{% if type == 'footer' %}
</div></div></div>
{% endif %}