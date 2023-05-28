<div class="page-header"><h1>Faq <small> frequently asked questions</small></h1></div></div></div>
<div class="row"><div class="col-md-12"><div class="tabbable tabs-left">
<ul id="myTab3" class="nav nav-tabs tab-teal">
{% for key, category in listCategory %}
{% if key == '0' %}
<li class="active"><a href="#faq_{{category.categoryId | raw}}" data-toggle="tab"><i class="{{category.categoryIcon | raw}}"></i> {{category.categoryName | raw}}</a></li>
{% else %}
<li class=""><a href="#faq_{{category.categoryId | raw}}" data-toggle="tab"><i class="{{category.categoryIcon | raw}}"></i> {{category.categoryName | raw}}</a></li>
{% endif %}
{% endfor %}
</ul><div class="tab-content">
{{msghtml | raw}}
</div></div></div>