<!-- start: MAIN JAVASCRIPTS -->
		<!--[if lt IE 9]>
		<script src="../assets/plugins/respond.min.js"></script>
		<script src="../assets/plugins/excanvas.min.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<![endif]-->
		<!--[if gte IE 9]><!-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
		<!--<![endif]-->
		<script src="../assets/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
		<script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="../assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"></script>
		<script src="../assets/plugins/blockUI/jquery.blockUI.js"></script>
		<script src="../assets/plugins/iCheck/jquery.icheck.min.js"></script>
		<script src="../assets/plugins/perfect-scrollbar/src/jquery.mousewheel.js"></script>
		<script src="../assets/plugins/perfect-scrollbar/src/perfect-scrollbar.js"></script>
		<script src="../assets/plugins/less/less-1.5.0.min.js"></script>
		<script src="../assets/plugins/jquery-cookie/jquery.cookie.js"></script>
		<script src="../assets/plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js"></script>
        <script src="../assets/plugins/select2/select2.min.js"></script>
		<script src="../assets/js/main.js"></script>
		<!-- end: MAIN JAVASCRIPTS -->
				<script>
					$(".main-navigation-menu").find("li").click(function(){    
					if ($(this).find("ul").length){
					return false;
					} else {
						$(".main-navigation-menu .active").removeClass("active open");
						$(this).addClass("active open");
					}});
				</script>
		<script>
			jQuery(document).ready(function() {
				Main.init();
			});
		</script>