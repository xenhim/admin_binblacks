<!DOCTYPE html>
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
	<!--<![endif]-->
	<!-- start: HEAD -->
    {% include "admin/head.tpl" %}
	<body>
		<!-- start: HEADER -->
		<div class="navbar navbar-inverse navbar-fixed-top">
			<!-- start: TOP NAVIGATION CONTAINER -->
			<div class="container">
				<div class="navbar-header">
					<!-- start: RESPONSIVE MENU TOGGLER -->
					<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
						<span class="clip-list-2"></span>
					</button>
					<!-- end: RESPONSIVE MENU TOGGLER -->
					<!-- start: LOGO -->
					<a class="navbar-brand" href="./index.php">
						{{logo | raw}}
					</a>
					<!-- end: LOGO -->
				</div>
				{% include "admin/navbar.tpl" %}
			</div>
		</div>
		<div class="main-container">
			{% include "admin/menu.tpl" %}
			<div class="main-content">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<ol class="breadcrumb">
								<li>
									<i class="clip-file"></i>
                                Admin Panel 
								</li>
							</ol>
                    <div id="main"></div>
				</div>
			</div>
		</div>
        {% include "admin/footer.tpl" %}
		{% include "admin/scripts.tpl" %}
        {{page | raw}}
	</body>
</html>