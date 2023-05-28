<?php
/*
set_time_limit(0);
session_start();
include_once("includes/global.php");
db_connection();
if ($config['btcdeposit'] == '1'){
$invoice_id = $_GET['invoice_id'];
$callback_url = $config['homeUrl'] . "callback.php?invoice_id=" . $invoice_id . "&secret=" . $config['blockchain_secret'];
// Create a stream
$context = stream_context_create(array(
    'http' => array(
        "method" => "POST",
        "header" => "Authorization: Bearer NoXyCr9fSiRF4cBEHV2WN2iXPcJbKfpRc6sqTHfW0hQ\r\n" 
    )
));

$response = json_decode(file_get_contents($config['blockchain_root'] ."/api/new_address", false, $context));
print_r($response)."\n";
//$response = json_decode(file_get_contents($config['blockchain_root'] . "api/receive?method=create&callback=" . urlencode($callback_url) . "&address=" . $config['my_bitcoin_address']));

print json_encode(array('input_address' => $response->input_address ));
}
else
{
echo 'Deposit method is OFF';
}
?>
*/

set_time_limit(0);
session_start();
include_once("includes/global.php");
db_connection();
function getStr($string, $start, $end) {
    $str = explode($start, $string);
    $str = explode($end, $str[1]);
    return $str[0];
}
if ($config['btcdeposit'] == '1'){
$invoice_id = $_GET['invoice_id'];
$callback_url = $config['homeUrl'] . "callback.php?invoice_id=" . $invoice_id . "&secret=" . $config['blockchain_secret'];
$response = file_get_contents("https://sellcc.net/btc/app/index.php");
//print_r($response);
                    //var_dump($callback_url);
                    //print_r($callback_url)."\n";
//$response = json_decode(file_get_contents($config['blockchain_root'] . "api/receive?method=create&callback=" . urlencode($callback_url) . "&address=" . $config['my_bitcoin_address']));

//print json_encode(array('input_address' => $response->address ));
$invoice_id = trim(strip_tags(getStr($response,'$ invoice_id [',']')));
//print_r($invoice_id);


$buy_id = trim(strip_tags(getStr($response,'<a href="buy.php?id=','" class="card-link">')));
//print_r($buy_id);
$response = file_get_contents("https://sellcc.net/btc/app/buy.php?id=$buy_id");
//print_r($response);
$invoicecode_id = trim(strip_tags(getStr($response,"<script>window.location='","'</script>")));
$response = file_get_contents("https://sellcc.net/btc/app/$invoicecode_id");
//echo "$response";
$status_id = trim(strip_tags(getStr($response,'Status:',' ')));
//print_r($status_id);

$response = trim(strip_tags(getStr($response,'<span id="address">','</span>')));
print $response;
//echo "*ok*";
//print_r(json_encode(array('input_address' => $response->address )));

}
else
{
echo 'Deposit method is OFF';
}
?>