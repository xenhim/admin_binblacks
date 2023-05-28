<?php
	set_time_limit(0);
	session_start();
    require_once 'lib/Twig/Autoloader.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('template');
$twig = new Twig_Environment($loader, array('cache' => 'template/cache', 'auto_reload' => true));
	include_once("includes/global.php");
	db_connection();
	$act = clean($_GET["act"]);
	if (!is_login())
	{
		header("location: login.php");
	}
	else
	{
//FUNC
function add_to_cart($card_id) {
if (empty($_SESSION['dumps'][$card_id])) {    
$_SESSION['dumps'][$card_id] = $card_id;
}
update_cart();
}

function update_cart() {
global $config;
global $data_sql;
$_SESSION['dump_cart_coast']=0;
foreach ($_SESSION['dumps'] as $key => $value) {
$sql = "SELECT dumpUsed, price FROM " . $config["table_dumps"] . " WHERE dumpId = '".$key."'";
$result = mysql_query($sql, $data_sql);
    if ($result)
    {
    $card = mysql_fetch_assoc($result);
    if ($card[dumpUsed] == '0'){
    $_SESSION['dump_cart_coast']+=$card[price];
    } else {
    unset($_SESSION['dumps'][$key]);
    }
    }
    else {
                        echo sql_error();
         }
}
$_SESSION['dumps_val']=count($_SESSION['dumps']);
}
function remove_from_cart($card_id) {
unset($_SESSION['dumps'][$card_id]);
update_cart();
}
//FUNC
if ($act == "add"){
add_to_cart(clean($_POST['card_id']));
}
if ($act == "update"){
update_cart();
echo $twig->render('elements/dump-cart-upd.tpl', array('dumps' => $_SESSION['dumps_val']));
}
if ($act == "totalcart"){
echo $twig->render('elements/dump-cart-total.tpl', array('dumps' => $_SESSION['dumps_val'], 'price' => $_SESSION['dump_cart_coast']));
}
if ($act == "remove"){
remove_from_cart(clean($_POST['card_id']));
}
if ($act == "order"){
update_cart();
foreach ($_SESSION['dumps'] as $key =>$value) {
    $sql = "SELECT *, AES_DECRYPT(dumpContent, '$config[encode_key]') as dumpContent from " .
        $config["table_dumps"] . " LEFT JOIN " . $config["table_categorys_dump"] . " ON " . $config["table_dumps"] . ".categoryId = " . $config["table_categorys_dump"] . ".categoryId WHERE " . $config["table_dumps"] . ".dumpId = '$key'";
    $result = mysql_query($sql, $data_sql);
    if ($result)
    {
            $cardinfo[] = mysql_fetch_assoc($result);
    }
    else {
                        echo sql_error();
                    }
}
echo $twig->render('dump-cart-order.tpl', array(
            'dumps' => $_SESSION['dumps_val'],
            'price' => $_SESSION['dump_cart_coast'],
            'cardinfo' => $cardinfo));
}
	}
	db_close();
?>