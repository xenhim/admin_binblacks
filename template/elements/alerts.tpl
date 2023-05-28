{% if respond['type'] == 'success' %}
<div class="alert alert-success"><button data-dismiss="alert" class="close">&times;</button>{{respond['text'] | raw}}</div>
{% elseif respond['type'] == 'info' %}
<div class="alert alert-info"><button data-dismiss="alert" class="close">&times;</button>{{respond['text'] | raw}}</div>
{% elseif respond['type'] == 'warning' %}
<div class="alert alert-warning"><button data-dismiss="alert" class="close">&times;</button>{{respond['text'] | raw}}</div>
{% elseif respond['type'] == 'danger' %}
<div class="alert alert-danger"><button data-dismiss="alert" class="close">&times;</button>{{respond['text'] | raw}}</div>
{% endif %}