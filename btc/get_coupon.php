<?php
@error_reporting(1);
//date_default_timezone_set('Asia/Krasnoyarsk');
require_once('db.class.php');
$db = new Database('sgroydmz_ccgen', 'sgroydmz_ccgen90', 'WtBPeQ7gbpU3PCAVC2', 'localhost');
$RequestIP = $_SERVER['REMOTE_ADDR'];
$RequestTime 	= 	date('d-m-Y', time());
$MainURI   		= 	preg_replace('[\/]', '', $_SERVER['REQUEST_URI']);
$isAdmin 		= 0;


 

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        extract($_POST);
    } elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
        extract($_GET);
    }
    
	function coupon($l){
		$coupon = "SELLCCNET".substr(str_shuffle(str_repeat('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',$l-2)),0,$l-2);
 
		return $coupon;
	}
	$namecoup = coupon(10);
	print_r($namecoup)."\n";

	
if (isset($_GET['coup'])){
	$insert_array = array(
		"name" => $namecoup,
		"amount" => $amount,
		"status" => $status,

	);
	$db->insert('coupons', $insert_array);
	//echo($db)."\n";
	//print_r($db)."\n";
}

?>