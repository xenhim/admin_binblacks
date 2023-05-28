<?php

set_time_limit(0);
session_start();
require_once 'lib/Twig/Autoloader.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('template');
$twig = new Twig_Environment($loader, array('cache' => 'template/cache', 'auto_reload' => true));
include_once ("includes/global.php");
db_connection();
if (!is_login())
{
    header("location: login.php");
} else
{
    $price_in_btc = file_get_contents("https://blockchain.com/tobtc?currency=USD&value=1");
    if ($config['btcspeed'] == '1' || $config['UPMUSD'] == '1' || $config['UWMZ'] == '1' || $config['UPAYMERZ'] == '1')
    {
        $sql = "SELECT *,DATE_FORMAT(orderDate, '%d.%m.%Y') as sdate FROM " . $config['table_orders'] . " WHERE userId = '" . clean($_SESSION["userId"]) . "' AND (type = 'BTC SPEED' OR type = 'Unitaco PM' OR type = 'Unitaco WMZ' OR type = 'Unitaco PAYMER') ORDER BY orderId DESC";
        $result = mysql_query($sql, $data_sql);
        if ($result)
        {
            while ($orders = mysql_fetch_assoc($result))
            {
                $listOrders[] = $orders;
            }
        } else
        {
            echo sql_error();
        }
    }
    echo $twig->render('deposit.tpl', array(
        'mindeposit' => $config['mindeposit'],
        'btcdeposit' => $config['btcdeposit'],
        'pmdeposit' => $config['pmdeposit'],
        'btcspeed' => $config['btcspeed'],
        'upmusd' => $config['UPMUSD'],
        'uwmz' => $config['UWMZ'],
        'upaymerz' => $config['UPAYMERZ'],
        'credit' => $credit,
        'userid' => $_SESSION["userId"],
        'listOrders' => $listOrders,
        'btcprice' => $price_in_btc,
        ));
}
db_close();

?>