<?php

set_time_limit(0);
session_start();
require_once 'lib/Twig/Autoloader.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('template');
$twig = new Twig_Environment($loader, array('cache' => 'template/cache', 'auto_reload' => true));
include_once ("includes/global.php");
db_connection();
function getStr($string, $start, $end) {
    $str = explode($start, $string);
    $str = explode($end, $str[1]);
    return $str[0];
}
if (!is_login())
{
    header("location: login.php");
} else
{
    if ($config['btcdeposit'] == '1' && $config['btcspeed'] != '1')
    {
        $invoice_id = intval($_GET['invoice_id']);
        $paymentid = clean($invoice_id);
        $sql = "SELECT * FROM " . $config['table_orders'] . " WHERE orderId = '" . $paymentid . "'";
        $result = mysql_query($sql, $data_sql);
        $price_usd = file_get_contents("https://blockchain.info/tobtc?currency=USD&value=1");

        if ($result)
        {
            $payment = mysql_fetch_assoc($result);
        } else
        {
            echo sql_error();
        }
        
$apikey = "NoXyCr9fSiRF4cBEHV2WN2iXPcJbKfpRc6sqTHfW0hQ";
    $options = array(
        'http' => array(
            'header'  => 'Authorization: Bearer '.$apikey,
            'method'  => 'POST',
            'content' => '{"addr":"'.$payment['wallet'].'"}',
            'ignore_errors' => true
        )
    );
$context  = stream_context_create($options);
$result = file_get_contents('https://www.blockonomics.co/api/searchhistory', false, $context);

            //$response = json_decode($result, 1);
            $transaction_hash = trim(strip_tags(getStr($result,'"txid": "','"}')));
            $value_btc = trim(strip_tags(getStr($result,'"value": ',',')));
            //echo $value_btc;
            //echo $result;
            //print_r($response)."\n";
            //print_r($result)."\n";
            //print_r($transaction_hash)."\n";
            //$received = $response->total_received;
            $callback_url = file_get_contents("https://sellcc.net/callback.php?invoice_id=" . $invoice_id . "&secret=" . $config['blockchain_secret'] . "&value=" . $value_btc . "&address=" .$payment['wallet']. "&transaction_hash=" . $transaction_hash . "&confirmations=3");

        /*
        $received = $payment['btcvalue'];
        $addbal = $received - $walletbalance;
        $price_usd = file_get_contents("https://blockchain.info/tobtc?currency=USD&value=1");
        $value_btc = $addbal / 100000000;
        $addusd = $value_btc / $price_usd;
        $priceusd = round($addusd, 2);
        //echo $received."\n";
        //echo $addbal."\n";
        //echo $price_usd."\n";
        echo $value_btc."\n";
        echo $addusd."\n";
        echo $priceusd."\n";
        */
        /*
        if ($payment['userId'] == $_SESSION["userId"])
            {
                if ($payment['type'] == 'BTC')
                {
                    $wallet = $payment['wallet'];
                    //$walletbalance = $payment['walletbalance'];
                    //$userid = $payment['userId'];
                    $callback_url = $config['homeUrl'] . "callback.php?invoice_id=" . $invoice_id . "&secret=" . $config['blockchain_secret'];
                    $urlC = "https://www.blockonomics.co/api/searchhistory";
            $jsonData = '{"addr":"'.$wallet.'"}';

            //$jsonData = '{"key":"1770d5d9-bcea-4d28-ad21-6cbd5be018a8","addr":"'.$wallet.'","callback":"'.$callback_url.'","onNotification":"KEEP", "op":"RECEIVE", "confs": 3}';
            $options = array(
            'http' => array(
            'method'  => 'POST',
            'content' => $jsonData,
            'header'=>  "Content-Type: text/plain\r\n"
            )
        );
            $context = stream_context_create($options);
            $result = file_get_contents($urlC, false, $context );
            $response = json_decode($result, 1);
            $txid = trim(strip_tags(getStr($response,'"txid": "','"}')));

                    //print_r($response)."\n";
                    
                    $callbacklog = "https://api.blockchain.info/v2/receive/callback_log?callback=" . urlencode($callback_url) . "&key=1770d5d9-bcea-4d28-ad21-6cbd5be018a8";
                    $callbackg = "$callbacklog";
                    //echo "$callbackg";
                    $response = file_get_contents($callbackg);
                    //print_r($response);
                    //print ($response);
                }
            }
            */
        echo $twig->render('elements/btc_status.tpl', array(
            'invoice' => $invoice_id,
            'priceusd' => $payment['orderTotal'],
            'pricebtc' => $payment['btcvalue'],
            'wallet' => $payment['wallet'],
            //'statusval' => $payment['approved'],
            'approved' => $payment['approved']));

    } else
        if ($config['btcspeed'] == '1')
        {
            $invoice_id = intval($_GET['invoice_id']);
            $paymentid = clean($invoice_id);
            $sql = "SELECT * FROM " . $config['table_orders'] . " WHERE orderId = '" . $paymentid . "'";
            $result = mysql_query($sql, $data_sql);
            if ($result)
            {
                $payment = mysql_fetch_assoc($result);
            } else
            {
                echo sql_error();
            }

            if ($payment['userId'] == $_SESSION["userId"])
            {
                if ($payment['type'] == 'BTC SPEED')
                {
                    $wallet = $payment['wallet'];
                    $walletbalance = $payment['walletbalance'];
                    $userid = $payment['userId'];
                    $callback_url = $config['homeUrl'] . "callback.php?invoice_id=" . $invoice_id . "&secret=" . $config['blockchain_secret'];
                    

                    //$response = json_decode(file_get_contents($config['blockchain_root'] . "ru/merchant/" . urlencode($config['bcguid']) . "/address_balance?password=" . urlencode($config['bcmainpass']) . "&address=" . urlencode($wallet) . "&confirmations=" . urlencode($config['btconfirm'])));
            $urlC = "https://api.blockchain.info/v2/receive/balance_update";
            $jsonData = '{"key":"1770d5d9-bcea-4d28-ad21-6cbd5be018a8","addr":"'.$wallet.'","callback":"'.$callback_url.'","onNotification":"KEEP", "op":"RECEIVE", "confs": 3}';
            $options = array(
            'http' => array(
            'method'  => 'POST',
            'content' => $jsonData,
            'header'=>  "Content-Type: text/plain\r\n"
            )
        );
            $context = stream_context_create($options);
            $result = file_get_contents($urlC, false, $context );
            $response = json_decode($result, 1);

                   // print_r($response)."\n";

                    //print_r($response)."\n";
                    $received = $response->total_received;
                    if ($received != $walletbalance)
                    {
                        if ($received > $walletbalance)
                        {
                            $received = $payment['btcvalue'];
                            $addbal = $received - $walletbalance;
                            $price_usd = file_get_contents("https://blockchain.info/tobtc?currency=USD&value=1");
                            $value_btc = $addbal / 100000000;
                            $addusd = $value_btc / $price_usd;
                            $addusd = round($addusd, 2);
                            if ($addusd < $config['mindeposit'])
                            {
                                $smalldep = '1';
                            } else
                            {
                                //Add balance database
                                $sql = "SELECT * FROM " . $config['table_users'] . " WHERE userid = '$userid'";
                                $result = mysql_query($sql, $data_sql);
                                if ($result)
                                {
                                    $user = mysql_fetch_assoc($result);
                                } else
                                {
                                    echo sql_error();
                                }
                                $sql = "UPDATE " . $config['table_users'] . " SET credit = '" . ($user["credit"] + $addusd) . "' WHERE userid = '$userid'";
                                $result = mysql_query($sql, $data_sql);
                                if ($result)
                                {
                                    //add balance
                                    $addusd = $payment['orderTotal'] + $addusd;
                                    $value_btc = $payment['btcvalue'] + $value_btc;
                                    $sql = "UPDATE " . $config['table_orders'] . " SET confirmations = '" . $config['btconfirm'] . "', walletbalance = '" . $received . "', approved = '2', orderTotal = '" . $addusd . "', btcvalue = '" . $value_btc . "' WHERE orderId = '$paymentid'";
                                    $result = mysql_query($sql, $data_sql);
                                    if (!$result)
                                    {
                                        echo sql_error();
                                    } else
                                    {
                                        $sql = "SELECT * FROM " . $config['table_orders'] . " WHERE orderId = '" . $paymentid . "'";
                                        $result = mysql_query($sql, $data_sql);
                                        if ($result)
                                        {
                                            $payment = mysql_fetch_assoc($result);
                                        } else
                                        {
                                            echo sql_error();
                                        }
                                    }
                                } else
                                {
                                    echo sql_error();
                                }
                            }
                        }
                    }

                    echo $twig->render('elements/btcspeed_status.tpl', array(
                        'invoice' => $invoice_id,
                        'wallet' => $wallet,
                        'smalldep' => $smalldep,
                        'priceusd' => $addusd,
                        'addusd' => $addusd,
                        'mindeposit' => $config['mindeposit'],
                        'approved' => $payment['approved']));
                }
                //other//
                else
                    if ($payment['type'] == 'Unitaco PM' or $payment['type'] == 'Unitaco WMZ' or $payment['type'] == 'Unitaco PAYMER')
                    {
                        if ($payment['approved'] == '0')
                        {
                            $paramsArray = array('data' => '<request>
	<user>
	<login>' . $config['UMERCH'] . '</login>
	<pass>' . $config['UPASS'] . '</pass>
	</user>
	<order>' . $payment['uorderid'] . '</order>
	</request>');
                            $vars = http_build_query($paramsArray);
                            $options = array('http' => array(
                                    'method' => 'POST',
                                    'header' => 'Content-type: application/x-www-form-urlencoded',
                                    'content' => $vars,
                                    ));
                            $context = stream_context_create($options);
                            $result = file_get_contents('https://unitaco.com/api/history', false, $context);
                            $xml = simplexml_load_string($result);
                            if ($xml->records_count == '1' && $xml->result->message == 'success')
                            {
                                if ($xml->records->record->status == 'success' && $xml->records->record->type == 'pay' && $xml->records->record->currency == 'USD' && $xml->records->record->result == 'success' && $xml->records->record->info->sum == $payment['orderTotal'] && $xml->records->record->info->order == $payment['uorderid'])
                                {

                                    //Add balance database
                                    $userid = $payment['userId'];
                                    $sql = "SELECT * FROM " . $config['table_users'] . " WHERE userid = '$userid'";
                                    $result = mysql_query($sql, $data_sql);
                                    if ($result)
                                    {
                                        $user = mysql_fetch_assoc($result);
                                    } else
                                    {
                                        echo sql_error();
                                    }
                                    $sql = "UPDATE " . $config['table_users'] . " SET credit = '" . ($user["credit"] + $payment['orderTotal']) . "' WHERE userid = '$userid'";
                                    $result = mysql_query($sql, $data_sql);
                                    if ($result)
                                    {
                                        //add balance
                                        $sql = "UPDATE " . $config['table_orders'] . " SET approved = '1' WHERE orderId = '$paymentid'";
                                        $result = mysql_query($sql, $data_sql);
                                        if (!$result)
                                        {
                                            echo sql_error();
                                        } else
                                        {
                                            $sql = "SELECT * FROM " . $config['table_orders'] . " WHERE orderId = '" . $paymentid . "'";
                                            $result = mysql_query($sql, $data_sql);
                                            if ($result)
                                            {
                                                $payment = mysql_fetch_assoc($result);
                                            } else
                                            {
                                                echo sql_error();
                                            }
                                        }
                                    } else
                                    {
                                        echo sql_error();
                                    }
                                }
                            }
                        }
                        echo $twig->render('elements/unitaco_status.tpl', array('invoice' => $invoice_id, 'approved' => $payment['approved']));
                    }
            }
        } else
        {
            echo 'Deposit method is OFF';
        }
}
db_close();

?>
