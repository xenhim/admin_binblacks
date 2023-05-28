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
if ($config['btcdeposit'] == '1'){
$invoice_id = $_GET['invoice_id'];
$callback_url = $config['homeUrl'] . "callback.php?invoice_id=" . $invoice_id . "&secret=" . $config['blockchain_secret'];
$response = json_decode(file_get_contents($config['blockchain_root'] . "v2/receive?xpub=xpub6CpaodaSLZpqkCpmo5nCPojf7FPDkr1sXDrgxs3xAuTEXZoYkRhztqZ6gbiZssBaJ5mG9RzGKQ2wgekEtBEo98J9dDScD1mx8woLPNhqm8S&callback=" . urlencode($callback_url) . "&key=" . $config['my_bitcoin_address'] . "&gap_limit=200"));
//print_r($response);
                    //var_dump($callback_url);
                    //print_r($callback_url)."\n";
//$response = json_decode(file_get_contents($config['blockchain_root'] . "api/receive?method=create&callback=" . urlencode($callback_url) . "&address=" . $config['my_bitcoin_address']));

//print json_encode(array('input_address' => $response->address ));
print $response->address;
//echo "*ok*";
//print_r(json_encode(array('input_address' => $response->address )));

}
else
{
echo 'Deposit method is OFF';
}
?>