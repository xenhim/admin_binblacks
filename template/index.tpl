<!DOCTYPE html>
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
	<!--<![endif]-->
    {% include "head.tpl" %}
	<body>
	    <!--<body class="pace-done modal-open" style="padding-right: 0px;">-->
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
						<span class="clip-list-2"></span>
					</button>
					<!-- start: LOGO -->
                    <div class="fadeIn">
					<a class="navbar-brand" href="{{homeurl}}">
						{{logo | raw}}
					</a>
                    </div>
					<!-- end: LOGO -->
				</div>
				{% include "navbar.tpl" %}
			</div>
		</div>
		<div class="main-container">
			{% include "menu.tpl" %}
			<div class="main-content">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<ol class="breadcrumb">
								<li>
									<i class="clip-file"></i>
                                {% if session['userType'] == '3' %}
                                Seller Panel 
                                {% else %}
                                User Panel
                                {% endif %}
								</li>
							</ol>
                    <div id="main"></div>
				</div>
			</div>
		</div>
        {% include "footer.tpl" %}
		{% include "scripts.tpl" %}
        {{page | raw}}
	</body>
</html>