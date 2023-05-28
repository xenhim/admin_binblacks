<?php
	require_once 'conn.php';
 
	if(ISSET($_POST['save'])){
		$product_name = $_POST['product_name'];
		$product_price = $_POST['product_price'];
		$image_name = $_FILES['product_image']['name'];
		$image_temp = $_FILES['product_image']['tmp_name'];
		$image_size = $_FILES['product_image']['size'];
 
 
		if($image_size > 500000){
			echo "<script>alert('File too large to upload')</script>";
			echo "<script>window.location = 'index.php'</script>";
		}else{
			$file = explode(".", $image_name);
			$file_ext = end($file);
			$ext = array("png", "jpg", "jpeg");
 
			if(in_array($file_ext, $ext)){
				$location = "upload/".$image_name;
				if(move_uploaded_file($image_temp, $location)){
					mysqli_query($conn, "INSERT INTO `product` VALUES('', '$product_name', '$product_price', '$location')") or die(mysqli_error());
					echo "<script>alert('Product Saved!')</script>";
					echo "<script>window.location = 'index.php'</script>";
				}
			}else{
				echo "<script>alert('Only images allowed')</script>";
				echo "<script>window.location = 'index.php'</script>";
			}
		}
 
 
	}
?>