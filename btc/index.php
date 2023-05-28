<!doctype html>
<html lang="en">
<head>
  	<title>Coupon Code Generator</title>

  	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

	<!-- Sweetalert 2 CSS -->
	<link rel="stylesheet" href="assets/plugins/sweetalert2/sweetalert2.min.css">
  	
  	<!-- Page CSS -->
  	<link rel="stylesheet" href="assets/css/styles.css">
</head>
  
<body>
   
	<div class="container">

		<br><br>

	    <h1>Coupon Code Generator in PHP/MySQL using Ajax & jQuery</h1>

	    <br><br>
	    
	    <div class="row">
	    	<div class="col-md-6">
	    		<h3>Generate Coupon Code</h3>

			    <form action="generate-coupon.php" id="generateCouponCodeForm">
			    	<div class="form-group">
					    <label for="email">Coupon Code</label>
					    <input class="form-control" type="text" name="coupon-code" readonly="readonly">
				  	</div>
				  	<button type="button" class="btn btn-primary" id="btnSubmit">Generate Coupon</button>
				</form>
	    	</div>

	    	<div class="col-md-6">
	    		<h3>Apply Coupon Code</h3>
	    		<form action="use-coupon.php" id="useCouponCodeForm">
			    	<div class="form-group">
					    <label for="email">Coupon Code</label>
					    <input class="form-control" type="text" name="coupon-code">
				  	</div>
				  	<button type="button" class="btn btn-primary" id="btnUseCouponCode">Use Coupon</button>
				</form>
	    	</div>
	    </div>
	</div>

	<!-- The Modal -->
	<div class="modal" id="edit-employee-modal">
	  	<div class="modal-dialog">
		    <div class="modal-content">

		      	<!-- Modal Header -->
		      	<div class="modal-header">
			        <h4 class="modal-title">Edit Employee</h4>
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
		      	</div>

		      	<!-- Modal body -->
		      	<div class="modal-body">
		        	<form action="update.php" id="edit-form">
		        		<input class="form-control" type="hidden" name="id">
				    	<div class="form-group">
						    <label for="email">Email</label>
						    <input class="form-control" type="text" name="email">
					  	</div>
					  	<div class="form-group">
						    <label for="first_name">First Name</label>
						    <input class="form-control" type="text" name="first_name">
					  	</div>
					  	<div class="form-group">
						    <label for="last_name">Last Name</label>
						    <input class="form-control" type="text" name="last_name">
					  	</div>
					  	<div class="form-group">
						    <label for="address">Address</label>
						    <textarea class="form-control" type="text" name="address" rows="3"></textarea>
					  	</div>
					  	<button type="button" class="btn btn-primary" id="btnUpdateSubmit">Update</button>
					  	<button type="button" class="btn btn-danger float-right" data-dismiss="modal">Close</button>
					</form>


		      	</div>

		    </div>
	  	</div>
	</div>


	<!-- Must put our javascript files here to fast the page loading -->
	
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<!-- Bootstrap JS -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<!-- Sweetalert2 JS -->
	<script src="assets/plugins/sweetalert2/sweetalert2.min.js"></script>
	<!-- Page Script -->
	<script src="assets/js/scripts.js"></script>

</body>
  
</html>