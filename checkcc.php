<?php
	set_time_limit(0);
	session_start();
    require_once 'lib/Twig/Autoloader.php';
    Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('template');
$twig = new Twig_Environment($loader, array('cache' => 'template/cache', 'auto_reload' => true));
	include_once("includes/global.php");
	db_connection();
	if (!is_login())
	{
		header("location: login.php");
	}
	$sql = "SELECT * from " . $config["table_users"] . " LEFT JOIN " . $config["table_types"] . " ON " . $config["table_users"] . ".typeId = " . $config["table_types"] . ".typeId WHERE " . $config["table_users"] . ".userId = '" . clean($_SESSION["userId"]) . "'";
	$result = mysql_query($sql,$data_sql);
	if (!$result)
	{
        echo sql_error();
	}
	else
	{
		$count = mysql_num_rows($result);
		if ($count == 1)
		{
			$user = mysql_fetch_assoc($result);
			$credit = $user["credit"];
			$typeName = $user["typeName"];
			$typeColor = $user["typeColor"];
		}
		else
		{
			die("Your account has been deleted, please contact webmaster for more information.");
		}
	}
    $name = clean($_SESSION["userId"]);
    if ($_SESSION["userType"] == '1'){
    $sql = "SELECT * FROM " . $config['table_support'] . " WHERE ((user_id = '$name' OR msgfrom = '$name') AND read_msg_admin = '0')";
    }
    else{
    $sql = "SELECT * FROM " . $config['table_support'] . " WHERE ((user_id = '$name' OR msgfrom = '$name') AND read_msg = '0')";
    }
    $result = mysql_query($sql,$data_sql);
	if (!$result)
	{
    echo sql_error();
	}
	else
	{
echo $twig->render('checkcc.tpl', array(
'credit' => $credit,
'CheckerPrice' => $config['CheckerPrice']
));
}
	db_close();
?>