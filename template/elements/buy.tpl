{% if result['type'] == 'info' %}
<span class='label label-info'>{{result['text'] | raw}}</span>
{% elseif result['type'] == 'danger' %}
<span class='label label-danger'>{{result['text'] | raw}}</span>
{% elseif result['type'] == 'result' %}
<textarea style='width:360px;height:100px;'>{{result['text'] | raw}}</textarea>
{% elseif result['type'] == 'warning' %}
<span class='label label-warning'>{{result['text'] | raw}}</span>
<span class='label label-warning'><p id="demo"></p></span>
{% endif %}