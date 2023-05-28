<?php
include_once "config.php";
include_once "functions.php";
//include_once ("../../includes/global.php");
/*
set_time_limit(0);
session_start();
require_once '../../lib/Twig/Autoloader.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('../../template');
$twig = new Twig_Environment($loader, array('cache' => '../../template/cache', 'auto_reload' => true));
//include_once ("../../includes/global.php");
//db_connection();
/*
if (!is_login())
{
    header("location: login.php");
} else
{*/

/*
    if ($config['btcdeposit'] == '1' && $config['btcspeed'] != '1')
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
        echo $twig->render('elements/btc_status.tpl', array(
            'invoice' => $invoice_id,
            'priceusd' => $payment['orderTotal'],
            'pricebtc' => $payment['btcvalue'],
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
                    $response = json_decode(file_get_contents($config['blockchain_root'] . "ru/merchant/" . urlencode($config['bcguid']) . "/address_balance?password=" . urlencode($config['bcmainpass']) . "&address=" . urlencode($wallet) . "&confirmations=" . urlencode($config['btconfirm'])));
                    $received = $response->total_received;
                    if ($received != $walletbalance)
                    {
                        if ($received > $walletbalance)
                        {
                            $addbal = $received - $walletbalance;
                            $price_usd = file_get_contents($config['blockchain_root'] . "tobtc?currency=USD&value=1");
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
*/
/*
// Check code
if(!isset($_GET['code'])){
    exit();
}
$code = mysqli_escape_string($conn, $_GET['code']);
// Get invoice information
$address = getAddress($code);

$product = getInvoiceProduct($code);

$status = getStatus($code);

$price = getInvoicePrice($code);
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitcoin store</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- Navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="row">
            <a class="navbar-brand" href="#">Bitcoin Example</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Store <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="orders.php">Purchases <span class="sr-only">(current)</span></a>
                </li>
                </ul>
                
            </div>
        </div>
    </nav>

    <!-- Products -->
    <main>
        <div class="row">
            <div class="product-hold">
                <?php
                 //   $sql = "SELECT * FROM " . $config['table_orders'] . " WHERE orderId = '" . $paymentid . "'";

                // Get and display all products
                $sql = "SELECT * FROM `products` ORDER BY `id` DESC LIMIT 1";
                //$sqlx = "INSERT INTO `products` (name, description, price)";
                //$sqlvalue = "VALUES ('$name', '$description', '$price')";
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($result)){
                    ?>
                    <div class="product">
                        <div class="card" style="width: 95%;margin:0 auto;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['name']; ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted">$<?php echo $row['price']; ?></h6>
                                <p class="card-text"><?php echo $row['description'] ?></p>
                                <a href="buy.php?id=<?php echo $row['id']; ?>" class="card-link">Buy now</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>

    <br>
<?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        extract($_POST);
    } elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
        extract($_GET);
    }
    
    //$name = $_POST['name'];
    //$name = $_GET['name'];
    //$name = urldecode($name);

if (isset($_GET['name'])){
    $sql = "INSERT INTO `products` (name, description, price)";
	$insert_array = $sql . "VALUES ('$name', '$description', '$price')";
	$result = mysqli_query($conn, $insert_array);
//print_r($name)."\r";
//print_r($description)."\r";
//print_r($price)."\r";

}
//print_r($result);
//var_dump($result);
//echo $name."\r";
//echo $description."\r";
//echo $price."\r";
?>
    	<form class="form-horizontal" method="GET">
		<div class="row">
		<div class="product-hold">
		<div class="product">
		<div class="card" style="width: 95%;margin:0 auto;">
		<div class="card-body">
        <textarea id="name" name="name" style="width: 95%;margin:0 auto" wrap="off"></textarea>
        <textarea id="description" name="description" style="width: 95%;margin:0 auto" wrap="off"></textarea>
        <textarea id="price" name="price" style="width: 95%;margin:0 auto" wrap="off"></textarea>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
<div class="form-group">
<div class="col-sm-12">
<button type="submit" name="add_comfirm" value="1" class="btn btn-primary fw-bold">Start</button>
<input type="submit" id="start" name="add_comfirm" value="Check Now!">
					</div></div>
		</form>
            </div>
        </div>
    </main>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>