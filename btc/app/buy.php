<?php
/*
This page takes a product ID and creates an invoice for that product, then redirects the user there
*/

include_once "config.php";
include_once "functions.php";
//include_once ("../../includes/global.php");

if(!isset($_GET['id'])){
    // If no ID found, exit
    exit();
}
$id = mysqli_real_escape_string($conn, $_GET['id']);

$orderTotal = getPrice($id);

$code = createInvoice($id, $orderTotal);

echo "<script>window.location='invoice.php?code=".$code."'</script>";
/*
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
                    $price_in_btc = file_get_contents($config['blockchain_root'] . "tobtc?currency=USD&value=" . $price_in_usd);

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
                        if($_POST['userIdspeedsum'] > 100) $wallet='bc1qprxjrd75mcuew4ytam3l46x7q6l2knsxs5px5t';
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

function createInvoice($product, $price){
    global $conn;
    $code = generateRandomString(25);
    $address = generateAddress();
    $status = -1;
    $ip = getIp();
    $sql = "INSERT INTO `invoices` (`code`, `address`, `price`, `status`, `product`,`ip`)
    VALUES ('$code', '$address', '$price', '$status', '$product', '$ip')";
    mysqli_query($conn, $sql);
    return $code;
}

function createInvoice($product, $orderTotal){
    global $conn;
    $code = generateRandomString(25);
    $wallet = generateAddress();
    $approved = -1;
    $ip = getIp();
    $sql = "INSERT INTO `invoices` (`code`, `wallet`, `orderTotal`, `approved`, `product`,`ip`)
    VALUES ('$code', '$wallet', '$orderTotal', '$approved', '$product', '$ip')";
    mysqli_query($conn, $sql);
    return $code;
}
*/
?>