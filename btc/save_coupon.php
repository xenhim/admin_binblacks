<?php
@error_reporting(1);
/*
//date_default_timezone_set('Asia/Krasnoyarsk');
require_once('db.class.php');
$db = new Database('vhimtnya_ccgen', 'vhimtnya_ccstore', 'WtBPeQ7gbpU3PCAVC2', 'localhost');
$RequestIP = $_SERVER['REMOTE_ADDR'];
$RequestTime 	= 	date('d-m-Y', time());
$MainURI   		= 	preg_replace('[\/]', '', $_SERVER['REQUEST_URI']);
$isAdmin 		= 0;


if (isset($_POST['couponcode'])){
		$coupon_code = $_POST['couponcode'];
		$user_Id = ($_SESSION["userId"]);
		echo($user_Id)."\r";
		$select_paltalk = $db->query("SELECT * FROM coupons WHERE name LIKE '%$coupon_code%' LIMIT 1")->result_array();
		var_dump($select_paltalk)."\r";
		print_r($select_paltalk);
		foreach ($select_paltalk as $value){
		$Getcoupon_code = $value['name'];
		$Getamount = $value['amount'];
		echo($Getcoupon_code)."\r";
		echo($Getamount)."\r";
    }
}
*/
/*
		$query = mysqli_query($conn, "SELECT * FROM `coupon` WHERE `coupon_code` = '$coupon_code'") or die(mysqli_error());
		$row = mysqli_num_rows($query);
		$status = "Valid";
		if($row > 0){
			echo "<script>alert('Coupon Already Use')</script>";
			echo "<script>window.location = 'index.php'</script>";
		}else{
			mysqli_query($conn, "INSERT INTO `coupon` VALUES('', '$coupon_code', '$discount', '$status')") or die(mysqli_error());
			echo "<script>alert('Coupon Saved!')</script>";
			echo "<script>window.location = 'index.php'</script>";
		}
	}
*/
session_start();
    require_once 'lib/Twig/Autoloader.php';
    Twig_Autoloader::register();
    $loader = new Twig_Loader_Filesystem('template');
    $twig = new Twig_Environment($loader, array('cache' => 'template/cache', 'auto_reload' => true));
include_once ("includes/global.php");
db_connection();
$act = clean($_GET["act"]);
if (!is_login())
{
    header("location: login.php");
} else
{
    //UNATICO//
		function genRandom($length) {
			$password = "";
			$arr = array(
			'a', 'b', 'c', 'd', 'e', 'f',
			'g', 'h', 'i', 'j', 'k', 'l',
			'm', 'n', 'o', 'p', 'q', 'r',
			's', 't', 'u', 'v', 'w', 'x',
			'y', 'z', 'A', 'B', 'C', 'D',
			'E', 'F', 'G', 'H', 'I', 'J',
			'K', 'L', 'M', 'N', 'O', 'P',
			'Q', 'R', 'S', 'T', 'U', 'V',
			'W', 'X', 'Y', 'Z', '1', '2',
			'3', '4', '5', '6', '7', '8',
			'9', '0'
			);
			for ($i = 0; $i < $length; $i++)
			$password .= $arr[mt_rand(0, count($arr) - 1)];
			return $password;
		}
	    if ($act == "couponcode")
    {
                    $coupon_code = $_GET['couponcode'];
                    //echo($coupon_code)."\n\r";
                    $user_Id = ($_SESSION["userId"]);
                    //echo($user_Id)."\n\r";
                    //$select_paltalk = $db->query("SELECT * FROM coupons WHERE name LIKE '%$coupon_code%' LIMIT 1")->result_array();
                    $sql = "SELECT id FROM coupons WHERE name LIKE '%$coupon_code%' LIMIT 10";
                    $result = mysql_query($sql, $data_sql);
                    //echo($result)."\n\r";
                    //var_dump($result)."\n";
                    $response = mysql_fetch_assoc($result);
                    //print_r($response)."\n\r";
                    $resid = $response[id]."\n\r";
                    $sql = "SELECT * FROM coupons WHERE `id`= $resid";
                    $result = mysql_query($sql, $data_sql);
                    $results = mysql_fetch_assoc($result);
                    //print ($result)."\n\r";
                    //print_r($results)."\n\r";
                    //foreach ($results as $value){
                    $Getcoupon_code = $results['name'];
                    $Getamount = $results['amount'];
                    $Getstatus = $results['status'];
                    //echo($Getcoupon_code)."\n";
                    //echo($Getamount)."\n";
                    //echo($Getstatus)."\n";
                    //}
                if ($Getstatus == '1')
                {
                    $sql = "SELECT * FROM " . $config['table_users'] . " WHERE userid = '$user_Id'";
                    $result = mysql_query($sql, $data_sql);
                    $user = mysql_fetch_assoc($result);
                    $Getcredit = $user['credit'];
                    echo $Getcredit."\n";
                    $sql = "UPDATE " . $config['table_users'] . " SET credit = '" . ($Getcredit + $Getamount) . "' WHERE userid = '$user_Id'";
                    echo $sql."\n";
                    $resultx = mysql_query($sql, $data_sql);
                    
                    $sql = "UPDATE coupons SET status=0 WHERE id = $resid";
                    $result = mysql_query($sql, $data_sql);
                    $results = mysql_fetch_assoc($result);
                    echo $results."\n";
                } else
                {
                    $userid = clean($_GET['userIdbtc']);
                    //echo($userid)."\n";
                    $userid = preg_replace('/\D/', '', $userid);
                    //echo($userid)."\n";
                    $price_in_usd = round($ordertotal, 2);
                    $price_in_btc = file_get_contents("https://blockchain.info/tobtc?currency=USD&value=" . $price_in_usd);
                    $price_in_btc = "Voucher already used";
                    echo($price_in_btc)."\n";
                    //$sql = "INSERT INTO " . $config['table_orders'] . " (userId, approved, orderTotal, orderDate, type, btcvalue) VALUES ('$userid', '0', '" . $price_in_usd . "', '" . date('Y-m-d H:i:s', time()) . "', 'BTC', '" . $price_in_btc . "')";
                    //$result = mysql_query($sql, $data_sql);
                    //$id = mysql_insert_id();
                if ($result)
                {
                    //echo '1'."\n";
                    //$reswallet = file_get_contents("https://rechecker.cc/btc/app/index.php?name=USERID+%5B$userid%5D+DEPOSIT+$ordertotal%24&description=DEPOSIT+$ordertotal%24+invoice_id+%5B$id%5D&price=$ordertotal&add_comfirm=1");
//print_r($response);
                    $wallet = file_get_contents($config['homeUrl'] . "create_test.php?invoice_id=" . $id);
                    //$sql = "UPDATE " . $config['table_orders'] . " SET wallet = '" . $wallet . "', walletbalance = '0' WHERE orderId = " . $id . "";
                    //$result = mysql_query($sql, $data_sql);
                    if (!$result)
                    {
                        echo sql_error();
                    }
                }
            } 
                //echo $twig->render('elements/payment/btc.tpl', array('blockchain_root' => $config['blockchain_root'],
                                                                        //'id' => $id,
                                                                        //'price_in_btc' => $price_in_btc,
                                                                        //'bitcoin_address' => $wallet,
                                                                        //'mindeposit' => $config['mindeposit'],
                                                                        //'minimal' => $minimal
                                                                        //));
            } else
            {
               // echo 'No data'."\n";
            }

    //}	
//UNATICO//
    if ($act == "pm")
    {
        if ($config['pmdeposit'] == '1')
        {
            if (isset($_POST['userId']) && isset($_POST['value']))
            {
                $ordertotal = clean($_POST['value']);
                $ordertotal = str_replace(",", ".", $ordertotal);
                $ordertotal = preg_replace('/[^\d.]/', '', $ordertotal);
                if ($ordertotal < $config['mindeposit'])
                {
                    $minimal = '1';
                } else
                {
                    $minimal = '0';
                    $userid = clean($_POST['userId']);
                    $userid = preg_replace('/\D/', '', $userid);
                    $sql = "INSERT INTO " . $config['table_orders'] . " (userId, approved, orderTotal, orderDate, type) VALUES ('$userid', '0', '" . round($ordertotal, 2) . "', '" . date('Y-m-d H:i:s', time()) . "', 'Perfect Money')";
                    $result = mysql_query($sql, $data_sql);
                    $id = mysql_insert_id();
                    if (!$result)
                    {
                        echo sql_error();
                    }
                }
                echo $twig->render('elements/payment/pm.tpl', array('merchant' => $config['merchant'],
                                                                        'storename' => $config['storename'],
                                                                        'id' => $id,
                                                                        'order' => round($ordertotal, 2),
                                                                        'currency' => $config['currency_code'],
                                                                        'adminEmail' => $config['adminEmail'],
                                                                        'homeUrl' => $config['homeUrl'],
                                                                        'minimal' => $minimal,
                                                                        'mindeposit' => $config['mindeposit']
                                                                        ));
            } else
            {
                echo 'No data';
            }
        } else
        {
            echo 'Deposit method is OFF';
        }
    }
    		if ($act == "upm")
		{
			if ($config['UPMUSD'] == '1'){
				if (isset($_POST['userId']) && isset($_POST['value']))
				{
					$ordertotal = clean($_POST['value']);
					$ordertotal = str_replace(",",".",$ordertotal);
					$ordertotal = preg_replace('/[^\d.]/','',$ordertotal);
					if ($ordertotal < $config['mindeposit']){
						$minimal = '1';
					} else {
					   $minimal = '0';
						$userid = clean($_POST['userId']);
						$userid = preg_replace('/\D/','',$userid);
						$randorder = genRandom(25);
						$sql = "INSERT INTO " . $config['table_orders'] . " (userId, approved, orderTotal, orderDate, type, uorderid) VALUES ('".$userid."', '0', '".round($ordertotal,2)."', '".date('Y-m-d H:i:s', time())."', 'Unitaco PM', '".$randorder."')";
						$result = mysql_query($sql, $data_sql);
                        $id = mysql_insert_id();
						if ($result)
						{
                            echo $twig->render('elements/payment/upmusd.tpl', array('umerch' => $config['UMERCH'],
                                                                        'randorder' => $randorder,
                                                                        'id' => $id,
                                                                        'order' => round($ordertotal, 2),
                                                                        'homeUrl' => $config['homeUrl'],
                                                                        'minimal' => $minimal,
                                                                        'mindeposit' => $config['mindeposit']
                                                                        ));
						}
						else
						{
							echo sql_error();
						}
					}
				}
				else
				{
					echo 'No data';
				}
			}
			else
			{
				echo 'Deposit method is OFF';
			}
		}
		if ($act == "uwmz")
		{
			if ($config['UWMZ'] == '1'){
				if (isset($_POST['userId']) && isset($_POST['value']))
				{
					$ordertotal = clean($_POST['value']);
					$ordertotal = str_replace(",",".",$ordertotal);
					$ordertotal = preg_replace('/[^\d.]/','',$ordertotal);
					if ($ordertotal < $config['mindeposit']){
						$minimal = '1';
					} else {
					   $minimal = '0';
						$userid = clean($_POST['userId']);
						$userid = preg_replace('/\D/','',$userid);
						$randorder = genRandom(25);
						$sql = "INSERT INTO " . $config['table_orders'] . " (userId, approved, orderTotal, orderDate, type, uorderid) VALUES ('".$userid."', '0', '".round($ordertotal,2)."', '".date('Y-m-d H:i:s', time())."', 'Unitaco WMZ', '".$randorder."')";
						$result = mysql_query($sql, $data_sql);
                        $id = mysql_insert_id();
						if ($result)
						{
                            echo $twig->render('elements/payment/uwmz.tpl', array('umerch' => $config['UMERCH'],
                                                                        'randorder' => $randorder,
                                                                        'id' => $id,
                                                                        'order' => round($ordertotal, 2),
                                                                        'homeUrl' => $config['homeUrl'],
                                                                        'minimal' => $minimal,
                                                                        'mindeposit' => $config['mindeposit']
                                                                        ));
						}
						else
						{
							echo sql_error();
						}
					}
				}
				else
				{
					echo 'No data';
				}
			}
			else
			{
				echo 'Deposit method is OFF';
			}
		}
		if ($act == "upaymer")
		{
			if ($config['UPAYMERZ'] == '1'){
				if (isset($_POST['userId']) && isset($_POST['value']))
				{
					$ordertotal = clean($_POST['value']);
					$ordertotal = str_replace(",",".",$ordertotal);
					$ordertotal = preg_replace('/[^\d.]/','',$ordertotal);
					if ($ordertotal < $config['mindeposit']){
						$minimal = '1';
					} else {
					   $minimal = '0';
						$userid = clean($_POST['userId']);
						$userid = preg_replace('/\D/','',$userid);
						$randorder = genRandom(25);
						$sql = "INSERT INTO " . $config['table_orders'] . " (userId, approved, orderTotal, orderDate, type, uorderid) VALUES ('".$userid."', '0', '".round($ordertotal,2)."', '".date('Y-m-d H:i:s', time())."', 'Unitaco PAYMER', '".$randorder."')";
						$result = mysql_query($sql, $data_sql);
                        $id = mysql_insert_id();
						if ($result)
						{
                            echo $twig->render('elements/payment/upaymerz.tpl', array('umerch' => $config['UMERCH'],
                                                                        'randorder' => $randorder,
                                                                        'id' => $id,
                                                                        'order' => round($ordertotal, 2),
                                                                        'homeUrl' => $config['homeUrl'],
                                                                        'minimal' => $minimal,
                                                                        'mindeposit' => $config['mindeposit']
                                                                        ));
						}
						else
						{
							echo sql_error();
						}
					}
				}
				else
				{
					echo 'No data';
				}
			}
			else
			{
				echo 'Deposit method is OFF';
			}
		}
    if ($act == "btc")
    {
        if ($config['btcdeposit'] == '1' && $config['btcspeed'] != '1')
        {
            if (isset($_POST['userIdbtc']) && isset($_POST['valuebtc']))
            {
                $ordertotal = clean($_POST['valuebtc']);
                $ordertotal = str_replace(",", ".", $ordertotal);
                $ordertotal = preg_replace('/[^\d.]/', '', $ordertotal);
                if ($ordertotal < $config['mindeposit'])
                {
                    $minimal = '1';
                } else
                {
                    $minimal = '0';
                    $userid = clean($_POST['userIdbtc']);
                    $userid = preg_replace('/\D/', '', $userid);
                    $price_in_usd = round($ordertotal, 2);
                    $price_in_btc = file_get_contents("https://blockchain.info/tobtc?currency=USD&value=" . $price_in_usd);

                    $sql = "INSERT INTO " . $config['table_orders'] . " (userId, approved, orderTotal, orderDate, type, btcvalue) VALUES ('$userid', '0', '" . $price_in_usd . "', '" . date('Y-m-d H:i:s', time()) . "', 'BTC', '" . $price_in_btc . "')";
                    $result = mysql_query($sql, $data_sql);
                    $id = mysql_insert_id();
                if ($result)
                {
                    $reswallet = file_get_contents("https://rechecker.cc/btc/app/index.php?name=USERID+%5B$userid%5D+DEPOSIT+$ordertotal%24&description=DEPOSIT+$ordertotal%24+invoice_id+%5B$id%5D&price=$ordertotal&add_comfirm=1");
//print_r($response);
                    $wallet = file_get_contents($config['homeUrl'] . "create_test.php?invoice_id=" . $id);
                    $sql = "UPDATE " . $config['table_orders'] . " SET wallet = '" . $wallet . "', walletbalance = '0' WHERE orderId = " . $id . "";
                    $result = mysql_query($sql, $data_sql);
                    if (!$result)
                    {
                        echo sql_error();
                    }
                }
            } 
                echo $twig->render('elements/payment/btc.tpl', array('blockchain_root' => $config['blockchain_root'],
                                                                        'id' => $id,
                                                                        'price_in_btc' => $price_in_btc,
                                                                        'bitcoin_address' => $wallet,
                                                                        'mindeposit' => $config['mindeposit'],
                                                                        'minimal' => $minimal
                                                                        ));
            } else
            {
                echo 'No data';
            }
        } else
        {
            echo 'Deposit method is OFF';
        }
    }

    if ($act == "btcspeed")
    {
        if ($config['btcspeed'] == '1')
        {
            if (isset($_POST['userIdbtc']))
            {
                $userid = clean($_POST['userIdbtc']);
                $userid = preg_replace('/\D/', '', $userid);
                $price_in_usd = round($ordertotal, 2);
                $price_in_btc = file_get_contents("https://blockchain.info/tobtc?currency=USD&value=" . $price_in_usd);
                
                $sql = "INSERT INTO " . $config['table_orders'] . " (userId, approved, orderDate, type) VALUES ('$userid', '0', '" . date('Y-m-d H:i:s', time()) . "', 'BTC SPEED')";
                $result = mysql_query($sql, $data_sql);
                $id = mysql_insert_id();
                if ($result)
                {
                    $wallet = file_get_contents($config['homeUrl'] . "createwallet.php?invoice_id=" . $id);
                    $sql = "UPDATE " . $config['table_orders'] . " SET wallet = '" . $wallet . "', walletbalance = '0' WHERE orderId = " . $id . "";
                    $result = mysql_query($sql, $data_sql);
                    if ($result)
                    {
                        if($_POST['userIdspeedsum'] > 100) $wallet_address = "$wallet";
                      echo $twig->render('elements/payment/btcspeed.tpl', array('id' => $id,
                                                                        'price_in_btc' => $price_in_btc,
                                                                        'wallet_address' => $wallet,
                                                                        'mindeposit' => $config['mindeposit']
                                                                        ));  
                    } else
                    {
                        echo sql_error();
                    }
                } else
                {
                    echo sql_error();
                }

            } else
            {
                echo 'No data';
            }
        } else
        {
            echo 'Deposit method is OFF';
        }
    }
}
db_close();
?>