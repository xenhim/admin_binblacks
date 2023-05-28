{% if check['type'] == 'success' %}
<span class='label label-success'>{{check['text'] | raw}}</span>
{% elseif check['type'] == 'danger' %}
<span class='label label-danger'>{{check['text'] | raw}}</span>
{% elseif check['type'] == 'warning' %}
<span class='label label-warning'>{{check['text'] | raw}}</span>
{% elseif check['type'] == 'info' %}
<span class='label label-info'>{{check['text'] | raw}}</span>
{% endif %}