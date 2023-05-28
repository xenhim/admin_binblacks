<?php

set_time_limit(0);
session_start();
require_once '../lib/Twig/Autoloader.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('../template');
$twig = new Twig_Environment($loader, array('cache' => '../template/cache', 'auto_reload' => true));
include_once ("../includes/global.php");
db_connection();
if (!is_login_admin())
{
    header("location: login.php");
}
$sql = "SELECT * from " . $config["table_users"] . " LEFT JOIN " . $config["table_types"] . " ON " . $config["table_users"] . ".typeId = " . $config["table_types"] . ".typeId WHERE " . $config["table_users"] . ".userId = '" . clean($_SESSION["userId"]) . "'";
$result = mysql_query($sql, $data_sql);
if (!$result)
{
    echo sql_error();
} else
{
    $count = mysql_num_rows($result);
    if ($count == 1)
    {
        $user = mysql_fetch_assoc($result);
        $credit = $user["credit"];
        $typeName = $user["typeName"];
        $typeColor = $user["typeColor"];
    } else
    {
        die("Your account has been deleted, please contact webmaster for more information.");
    }
}

$sql = "SELECT userId from " . $config["table_users"] . " WHERE credit > '0'";
$result = mysql_query($sql, $data_sql);
if (!$result)
{
    echo sql_error();
} else
{
    $creditUser = mysql_num_rows($result);
}
$sql = "SELECT orderId from " . $config["table_orders"];
$result = mysql_query($sql, $data_sql);
if (!$result)
{
    echo sql_error();
} else
{
    $totalOrder = mysql_num_rows($result);
}
$sql = "SELECT userId from " . $config["table_users"];
$result = mysql_query($sql, $data_sql);
if (!$result)
{
    echo sql_error();
} else
{
    $totalUser = mysql_num_rows($result);
}

if (isset($_GET["page"]))
{
    $subpage = clean($_GET["page"]);
} else
{
    $subpage = "news";
}
$page = "
	<script>
	$(document).ready(function() {
		showpage('$subpage.php');
	});
	</script>
	";
echo $twig->render('admin/index.tpl', array(
    'credit' => $credit,
    'session' => $_SESSION,
    'totalOrder' => $totalOrder,
    'totalUser' => $totalUser,
    'sitename' => $config['SiteName'],
    'logo' => $config['logo'],
    'themeadmin' => $config['themeadmin'],
    'page' => $page));
db_close();

?>