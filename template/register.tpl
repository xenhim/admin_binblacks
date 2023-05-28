<!DOCTYPE html>
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
	<!--<![endif]-->
<!--	<head>
		<title>{{sitename}}</title>
		<meta charset="utf-8" /> -->
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
		<!--<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="assets/fonts/style.css">
		<link rel="stylesheet" href="assets/css/main.css">
		<link rel="stylesheet" href="assets/css/main-responsive.css">
		<link rel="stylesheet" href="assets/plugins/iCheck/skins/all.css">
		<link rel="stylesheet" href="assets/plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css">
		<link rel="stylesheet" href="assets/plugins/perfect-scrollbar/src/perfect-scrollbar.css">
		<link rel="stylesheet" href="assets/css/theme_light.css" type="text/css" id="skin_color">
		<link rel="stylesheet" href="assets/css/print.css" type="text/css" media="print"/>
        <link rel="stylesheet" href="assets/plugins/css3-animation/animations.css"> -->
		<!--[if IE 7]>
		<link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome-ie7.min.css">
		<![endif]-->
<!--	</head>-->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>{{sitename}}</title>
        <meta name="description" content="{{sitename}}">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="resources/vendors/zwicon/zwicon.min.css">
        <link rel="stylesheet" href="resources/vendors/animate.css/animate.min.css">
        <link rel="stylesheet" href="resources/vendors/overlay-scrollbars/OverlayScrollbars.min.css">
        <link rel="stylesheet" href="resources/vendors/select2/css/select2.min.css">
        <link rel="stylesheet" href="resources/vendors/sweetalert2/sweetalert2.min.css">
        <link rel="stylesheet" type="text/css" href="css/flags.min.css">
                                        <link rel="stylesheet" href="resources/css/app.min.css">
        <link rel="stylesheet" href="resources/vendors/rateyo/jquery.rateyo.min.css">
        <link rel="stylesheet" href="resources/css/font-awesome/all.min.css">
        <script src="resources/vendors/jquery/jquery.min.js"></script>
        <script src="resources/vendors/popper.js/popper.min.js"></script>
        <script src="resources/vendors/bootstrap/js/bootstrap.min.js"></script>
        <!--JSLIDE-->
        <link rel="stylesheet" href="resources/vendors/jslider/bin/jquery.slider.min.css">
        <script src="resources/vendors/jslider/bin/jquery.slider.min.js"></script>
        <script src="resources/vendors/jslider/bin/jqueryfix.js"></script>
        <!--END-->
        </head>
        <style type="text/css">
            body{
                background-color: #736a5b;
                background-size: cover;
                background-attachment: fixed;
                background-position: center;
                background-image: url("resources/background/usd.jpg");            }
            .login__block{
                background-color:#000;
            }
            .btn-theme{
                background-color: rgba(136, 158, 130, 0.9);
                color: #111;
                font-size: 1.1rem;
            }
            .btn-theme:hover{
                background-color: rgb(90, 100, 87) !important;
                color: #000 !important;
                font-size: 1.1rem !important;
            }
        </style>
	<body class="login example1">
		<div class="main-login col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
			<div class="fadeIn">
			<div class="logo">{{logo | raw}}
            </div>
			</div>
			<div class="box-register">
            <div class="stretchRight">
				<h3>Sign Up</h3>
				<p>
					Enter your personal details below:
				</p>
                </div>
				<form class="form-register" name="register" action="" method="POST">
					<div class="errorHandler alert alert-danger no-display">
						<i class="fa fa-remove-sign"></i> You have some form errors. Please check below.
					</div>
                    {% include "elements/alerts.tpl" %}
					<fieldset>
						<div class="form-group">
                        <span class="input-icon">
							<input type="text" class="form-control" name="username" placeholder="Username">
                            <i class="fa fa-user"></i> </span>
						</div>

						<div class="form-group">
							<span class="input-icon">
								<input type="email" class="form-control" name="jabber" placeholder="Jabber ID">
								<i class="fa fa-envelope"></i> </span>
						</div>
						<div class="form-group">
							<span class="input-icon">
								<input type="password" class="form-control" id="password" name="password" placeholder="Password">
								<i class="fa fa-lock"></i> </span>
						</div>
						<div class="form-group">
						<img src="captcha/captcha.php" alt="captcha" />
							<span class="input-icon" style="width:200px; float: right;">
								<input type="text" class="form-control" name="captcha">
								<i class="fa fa-key"></i> </span>
						</div>
						<div class="form-group">
							<div>
								<label for="agree" class="checkbox-inline">
									<input type="checkbox" class="grey agree" id="agree" name="agree">
									I agree to the Terms of Service and Privacy Policy
								</label>
							</div>
						</div>
						<div class="form-actions"><div class="slideExpandUp">
							<a href='index.php' class="btn btn-light-grey go-back">
								<i class="fa fa-circle-arrow-left"></i> Back
							</a>
							<button name="submit" type="submit" class="btn btn-bricky pull-right">
								Register <i class="fa fa-arrow-circle-right"></i>
							</button></div>
						</div>
					</fieldset>
				</form>
			</div>
			<div class="copyright">
				2022 {{sitename}} &copy;
			</div>
		</div>
		<!--[if lt IE 9]>
		<script src="assets/plugins/respond.min.js"></script>
		<script src="assets/plugins/excanvas.min.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<![endif]-->
		<!--[if gte IE 9]><!-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
		<!--<![endif]-->
		<script src="assets/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
		<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"></script>
		<script src="assets/plugins/blockUI/jquery.blockUI.js"></script>
		<script src="assets/plugins/iCheck/jquery.icheck.min.js"></script>
		<script src="assets/plugins/perfect-scrollbar/src/jquery.mousewheel.js"></script>
		<script src="assets/plugins/perfect-scrollbar/src/perfect-scrollbar.js"></script>
		<script src="assets/plugins/less/less-1.5.0.min.js"></script>
		<script src="assets/plugins/jquery-cookie/jquery.cookie.js"></script>
		<script src="assets/plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js"></script>
		<script src="assets/js/main.js"></script>
		<script src="assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
		<script src="assets/js/login.js"></script>
		<script src="assets/js/ui-elements.js"></script>
		<script>
			jQuery(document).ready(function() {
				Main.init();
				Login.init();
			});
		</script>
	</body>
</html>