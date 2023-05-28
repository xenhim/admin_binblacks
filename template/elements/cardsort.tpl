<div class="form-inline">
<div class='cardoption'><div id='row'><div class='well'><div class='row'><div class='col-sm-3'><label for='catid'>Category:</label>
<select id='catid' style='width: 100%;' name='catid' onchange="showpage('./card.php?cat='+document.getElementById('catid').options[document.getElementById('catid').selectedIndex].value+'&bin='+document.getElementById('cardbin').value+'&page=1&perpage='+document.getElementById('cardPerPage').options[document.getElementById('cardPerPage').selectedIndex].value);">
<option {% if categoryId == '0' %} selected {% endif %} value="">All</option>
{% for category in listCategory %}
<option {% if categoryId == category.categoryId %} selected {% endif %}
value='{{category.categoryId}}'>{{category.categoryName}}</option>
{% endfor %}
</select></div>
<div class='col-sm-3'><label for='cardbin'>Bin:</label><div class='input-group' style='margin-top:3px;'><input id='cardbin' type='hidden' style='width: 100%;' value="{{get['bin']}}"  /> <span class='input-group-btn'><button type='button' onclick="showpage('./card.php?cat='+document.getElementById('catid').options[document.getElementById('catid').selectedIndex].value+'&bin='+document.getElementById('cardbin').value+'&country='+document.getElementById('cardcountry').options[document.getElementById('cardcountry').selectedIndex].value+'&state='+document.getElementById('cardstate').options[document.getElementById('cardstate').selectedIndex].value+'&city='+document.getElementById('cardcity').options[document.getElementById('cardcity').selectedIndex].value+'&zip='+document.getElementById('cardzip').value+'&page=1&perpage='+document.getElementById('cardPerPage').options[document.getElementById('cardPerPage').selectedIndex].value+'&type='+document.getElementById('cardtype').options[document.getElementById('cardtype').selectedIndex].value);" class='btn btn-default'><i class='fa fa-angle-double-right'></i> Go!</button></span> </div>
</div>
<div class='col-sm-3'><label for='cardcountry'>Country:</label><select id='cardcountry' style='width: 100%;' name='cardcountry' onchange="showpage('./card.php?cat='+document.getElementById('catid').options[document.getElementById('catid').selectedIndex].value+'&bin='+document.getElementById('cardbin').value+'&country='+document.getElementById('cardcountry').options[document.getElementById('cardcountry').selectedIndex].value+'&state='+document.getElementById('cardstate').options[document.getElementById('cardstate').selectedIndex].value+'&city='+document.getElementById('cardcity').options[document.getElementById('cardcity').selectedIndex].value+'&zip='+document.getElementById('cardzip').value+'&page=1&perpage='+document.getElementById('cardPerPage').options[document.getElementById('cardPerPage').selectedIndex].value+'&type='+document.getElementById('cardtype').options[document.getElementById('cardtype').selectedIndex].value);">"

<option {% if inscountry == '0' %} selected {% endif %} value="">All</option>
{% for icountry in listCou %}
<option {% if inscountry == icountry.cardCou %} selected {% endif %}
value='{{icountry.cardCou}}'>{{icountry.cardCou}} ({{icountry.count}})</option>
{% endfor %}

</select></div>
<div class='col-sm-3'><label for='cardstate'>State:</label><select id='cardstate' style='width: 100%;' name='cardstate' onchange="showpage('./card.php?cat='+document.getElementById('catid').options[document.getElementById('catid').selectedIndex].value+'&bin='+document.getElementById('cardbin').value+'&country='+document.getElementById('cardcountry').options[document.getElementById('cardcountry').selectedIndex].value+'&state='+document.getElementById('cardstate').options[document.getElementById('cardstate').selectedIndex].value+'&city='+document.getElementById('cardcity').options[document.getElementById('cardcity').selectedIndex].value+'&zip='+document.getElementById('cardzip').value+'&page=1&perpage='+document.getElementById('cardPerPage').options[document.getElementById('cardPerPage').selectedIndex].value+'&type='+document.getElementById('cardtype').options[document.getElementById('cardtype').selectedIndex].value);">

<option {% if insstate == '0' %} selected {% endif %} value="">All</option>
{% for istate in liststate %}
<option {% if insstate == istate.CardState %} selected {% endif %}
value='{{istate.CardState}}'>{{istate.CardState}} ({{istate.count}})</option>
{% endfor %}

</select></div></div>
<div class='row' style='margin-top:10px'><div class='col-sm-3'><label for='cardcity'>City:</label><select id='cardcity' style='width: 100%;' name='cardcity' onchange="showpage('./card.php?cat='+document.getElementById('catid').options[document.getElementById('catid').selectedIndex].value+'&bin='+document.getElementById('cardbin').value+'&country='+document.getElementById('cardcountry').options[document.getElementById('cardcountry').selectedIndex].value+'&state='+document.getElementById('cardstate').options[document.getElementById('cardstate').selectedIndex].value+'&city='+document.getElementById('cardcity').options[document.getElementById('cardcity').selectedIndex].value+'&zip='+document.getElementById('cardzip').value+'&page=1&perpage='+document.getElementById('cardPerPage').options[document.getElementById('cardPerPage').selectedIndex].value+'&type='+document.getElementById('cardtype').options[document.getElementById('cardtype').selectedIndex].value);">

<option {% if inscity == '0' %} selected {% endif %} value="">All</option>
{% for icity in listcity %}
<option {% if inscity == icity.CardCity %} selected {% endif %}
value='{{icity.CardCity}}'>{{icity.CardCity}} ({{icity.count}})</option>
{% endfor %}

</select></div>
<div class='col-sm-3'><label for='cardzip'>Zip:</label><input id='cardzip' type='text' class='form-control' style='width: 100%; margin-top:3px; margin-bottom:10px;' value="{{get['zip'] | slice(0,7)}}" size="7" onchange="showpage('./card.php?cat='+document.getElementById('catid').options[document.getElementById('catid').selectedIndex].value+'&bin='+document.getElementById('cardbin').value+'&country='+document.getElementById('cardcountry').options[document.getElementById('cardcountry').selectedIndex].value+'&state='+document.getElementById('cardstate').options[document.getElementById('cardstate').selectedIndex].value+'&city='+document.getElementById('cardcity').options[document.getElementById('cardcity').selectedIndex].value+'&zip='+document.getElementById('cardzip').value+'&page=1&perpage='+document.getElementById('cardPerPage').options[document.getElementById('cardPerPage').selectedIndex].value+'&type='+document.getElementById('cardtype').options[document.getElementById('cardtype').selectedIndex].value);" maxlength="7" /></div>
<div class='col-sm-2'><label for='cardtype'>Type:</label><select id='cardtype' style='width: 100%;' name='cardtype' onchange="showpage('./card.php?cat='+document.getElementById('catid').options[document.getElementById('catid').selectedIndex].value+'&bin='+document.getElementById('cardbin').value+'&country='+document.getElementById('cardcountry').options[document.getElementById('cardcountry').selectedIndex].value+'&state='+document.getElementById('cardstate').options[document.getElementById('cardstate').selectedIndex].value+'&city='+document.getElementById('cardcity').options[document.getElementById('cardcity').selectedIndex].value+'&zip='+document.getElementById('cardzip').value+'&page=1&perpage='+document.getElementById('cardPerPage').options[document.getElementById('cardPerPage').selectedIndex].value+'&type='+document.getElementById('cardtype').options[document.getElementById('cardtype').selectedIndex].value);">

<option {% if instype == '' %} selected {% endif %} value="">All</option>
<option {% if instype == '3' %} selected {% endif %} value="3">AMEX</option>
<option {% if instype == '4' %} selected {% endif %} value="4">VISA</option>
<option {% if instype == '5' %} selected {% endif %} value="5">MASTER CARD</option>
<option {% if instype == '6' %} selected {% endif %} value="6">DISCOVER</option>

</select></div>
<div class='col-sm-2'><label for='cardPerPage'>Cards per page:</label><select id='cardPerPage' style='width: 100%;' name='cardPerPage' onchange="showpage('./card.php?cat='+document.getElementById('catid').options[document.getElementById('catid').selectedIndex].value+'&bin='+document.getElementById('cardbin').value+'&country='+document.getElementById('cardcountry').options[document.getElementById('cardcountry').selectedIndex].value+'&state='+document.getElementById('cardstate').options[document.getElementById('cardstate').selectedIndex].value+'&city='+document.getElementById('cardcity').options[document.getElementById('cardcity').selectedIndex].value+'&zip='+document.getElementById('cardzip').value+'&page=1&perpage='+document.getElementById('cardPerPage').options[document.getElementById('cardPerPage').selectedIndex].value+'&type='+document.getElementById('cardtype').options[document.getElementById('cardtype').selectedIndex].value);">

<!--<option {% if cardPerPage == '10' %} selected {% endif %} value="10">10</option>
<option {% if cardPerPage == '20' %} selected {% endif %} value="20">20</option>-->
<option {% if cardPerPage == '50' %} selected {% endif %} value="50">50</option>
<option {% if cardPerPage == '100' %} selected {% endif %} value="100">100</option>

</select></div>

<div class='col-sm-2'><label for='cardpage'>Page:</label><select id='cardpage' name='cardpage' style='width: 100%;' onchange="showpage('./card.php?cat='+document.getElementById('catid').options[document.getElementById('catid').selectedIndex].value+'&bin='+document.getElementById('cardbin').value+'&country='+document.getElementById('cardcountry').options[document.getElementById('cardcountry').selectedIndex].value+'&state='+document.getElementById('cardstate').options[document.getElementById('cardstate').selectedIndex].value+'&city='+document.getElementById('cardcity').options[document.getElementById('cardcity').selectedIndex].value+'&zip='+document.getElementById('cardzip').value+'&page='+document.getElementById('cardpage').options[document.getElementById('cardpage').selectedIndex].value+'&perpage='+document.getElementById('cardPerPage').options[document.getElementById('cardPerPage').selectedIndex].value+'&type='+document.getElementById('cardtype').options[document.getElementById('cardtype').selectedIndex].value);">

<option {% if currentPage == '1' %} selected {% endif %} value="1">1</option>
{% if pages > '1' %}
{% for i in range(2, pages) %}
<option {% if currentPage == i %} selected {% endif %} value="{{i}}">{{i}}</option>
{% endfor %}
{% endif %}

</select></div>
</div></div></div></div>