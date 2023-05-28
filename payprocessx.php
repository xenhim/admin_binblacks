<?php

set_time_limit(0);
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
                    $price_in_btc = file_get_contents("https://blockchain.com/tobtc?currency=USD&value=" . $price_in_usd);

                    $sql = "INSERT INTO " . $config['table_orders'] . " (userId, approved, orderTotal, orderDate, type, btcvalue) VALUES ('$userid', '0', '" . $price_in_usd . "', '" . date('Y-m-d H:i:s', time()) . "', 'BTC', '" . $price_in_btc . "')";
                    $result = mysql_query($sql, $data_sql);
                    $id = mysql_insert_id();
                    if (!$result)
                    {
                        echo sql_error();
                    }
                }
                echo $twig->render('elements/payment/btc.tpl', array('blockchain_root' => $config['blockchain_root'],
                                                                        'id' => $id,
                                                                        'price_in_btc' => $price_in_btc,
                                                                        'bitcoin_address' => $config['my_bitcoin_address'],
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
                        if($_POST['userIdspeedsum'] > 100) $wallet='1Lu2B9L3wJoMpcVgjEGTEPZ1i66GtG3Hoj';
                      echo $twig->render('elements/payment/btcspeed.tpl', array('id' => $id,
                                                                        'wallet' => $wallet
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