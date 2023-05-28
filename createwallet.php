<?php
/*
set_time_limit(0);
session_start();
include_once("includes/global.php");
db_connection();
// Create a stream
$opts = [
    "http" => [
        "method" => "POST",
        "header" => "Authorization: Bearer NoXyCr9fSiRF4cBEHV2WN2iXPcJbKfpRc6sqTHfW0hQ\r\n"
    ]
];

// DOCS: https://www.php.net/manual/en/function.stream-context-create.php
$context = stream_context_create($opts);

// Open the file using the HTTP headers set above
// DOCS: https://www.php.net/manual/en/function.file-get-contents.php
$response = json_decode(file_get_contents('https://www.blockonomics.co/api/new_address', false, $context));
if ($config['btcspeed'] == '1'){
$invoice_id = $_GET['invoice_id'];
$callback_url = $config['homeUrl'] . "callback.php?invoice_id=" . $invoice_id . "&secret=" . $config['blockchain_secret'];
echo $callback_url."\n";
// /api/callback_url?status=2&addr=1C3FrYaGgUJ8R21jJcwzryQQUFCWFpwcrL&value=10000&txid=4cb3 0849ffcaf61c0e97e8351cca2a32722ceb6ad5f34e630b4acb7c6dc1e73b
// /api/callback_url?status=0&addr=1C3FrYaGgUJ8R21jJcwzryQQUFCWFpwcrL&value=10000&txid=4cb3 0849ffcaf61c0e97e8351cca2a32722ceb6ad5f34e630b4acb7c6dc1e73b&rbf=1

//$response = json_decode(file_get_contents($config['blockchain_root'] . "api/receive?method=create&callback=" . urlencode($callback_url) . "&address=" . $config['my_bitcoin_address']));
//$response = json_decode(file_get_contents($config['blockchain_root'] . "/api/callback_url?status=0&callback=" . urlencode($callback_url) . "&addr=" . $config['my_bitcoin_address']));

print $response->input_address;
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
if ($config['btcspeed'] == '1'){
$invoice_id = $_GET['invoice_id'];
$callback_url = $config['homeUrl'] . "callback.php?invoice_id=" . $invoice_id . "&secret=" . $config['blockchain_secret'];
$response = json_decode(file_get_contents($config['blockchain_root'] . "v2/receive?xpub=xpub6CpaodaSLZpqkCpmo5nCPojf7FPDkr1sXDrgxs3xAuTEXZoYkRhztqZ6gbiZssBaJ5mG9RzGKQ2wgekEtBEo98J9dDScD1mx8woLPNhqm8S&callback=" . urlencode($callback_url) . "&key=" . $config['my_bitcoin_address'] . "&gap_limit=200"));
print $response->address;
}
else
{
echo 'Deposit method is OFF';
}
?>
