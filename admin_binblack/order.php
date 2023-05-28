<?php
	set_time_limit(0);
	session_start();
    require_once '../lib/Twig/Autoloader.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('../template');
$twig = new Twig_Environment($loader, array('cache' => '../template/cache', 'auto_reload' => true));
	include_once("../includes/global.php");
	db_connection();
	$act = clean($_GET["act"]);
	if (!is_login_admin())
	{
		header("location: login.php");
	}
	else
	{
	   	if ($act == "delete")
		{
			$orderid = clean($_GET["orderid"]);
			$sql = "DELETE from " . $config["table_orders"] . " WHERE orderId = '$orderid'";
			$result = mysql_query($sql, $data_sql);
			if ($result)
			{
				header("location: order.php?act=lastweek");
			}
			else
			{
				echo sql_error();
			}
		}
        else if ($act == "delete30") {
        $time = date('Y-m-d H:i:s', time()-(86400*30));
        $sql = "SELECT * from " . $config['table_orders'] . "  WHERE orderDate < '".$time."' AND approved = '0'";
        $result = mysql_query($sql, $data_sql);
		if ($result)
		{
        while ($order = mysql_fetch_assoc($result))
					{
						$orderoff[] = $order;
					}
        foreach ($orderoff as $orderoffdel){
$sql = "DELETE from " . $config["table_orders"] . " WHERE orderId = '".$orderoffdel[orderId]."'";
$result = mysql_query($sql, $data_sql);
if (!$result)
{
			echo sql_error();
		}
}
header("location: order.php?act=lastweek");
        }
		else
		{
			echo sql_error();
		}
        }
        else if ($act == "delete7") {
        $time = date('Y-m-d H:i:s', time()-(86400*7));
        $sql = "SELECT * from " . $config['table_orders'] . "  WHERE orderDate < '".$time."' AND approved = '0'";
        $result = mysql_query($sql, $data_sql);
		if ($result)
		{
        while ($order = mysql_fetch_assoc($result))
					{
						$orderoff[] = $order;
					}
        foreach ($orderoff as $orderoffdel){
$sql = "DELETE from " . $config["table_orders"] . " WHERE orderId = '".$orderoffdel[orderId]."'";
$result = mysql_query($sql, $data_sql);
if (!$result)
{
			echo sql_error();
		}
}
header("location: order.php?act=lastweek");
        }
		else
		{
			echo sql_error();
		}
        }
        else if ($act == "delete3") {
        $time = date('Y-m-d H:i:s', time()-(86400*3));
        $sql = "SELECT * from " . $config['table_orders'] . "  WHERE orderDate < '".$time."' AND approved = '0'";
        $result = mysql_query($sql, $data_sql);
		if ($result)
		{
        while ($order = mysql_fetch_assoc($result))
					{
						$orderoff[] = $order;
					}
        foreach ($orderoff as $orderoffdel){
$sql = "DELETE from " . $config["table_orders"] . " WHERE orderId = '".$orderoffdel[orderId]."'";
$result = mysql_query($sql, $data_sql);
if (!$result)
{
			echo sql_error();
		}
}
header("location: order.php?act=lastweek");
        }
		else
		{
			echo sql_error();
		}
        }
        else if ($act == "lastweek"){
        $time = date('Y-m-d H:i:s', time()-(86400*7));
        $sql = "SELECT * from " . $config['table_orders'] . " LEFT JOIN " . $config['table_users'] . " ON " . $config['table_orders'] . ".userId = users.userId WHERE " . $config['table_orders'] . ".orderDate > '".$time."' ORDER BY orderId ASC";
        $result = mysql_query($sql, $data_sql);
		if ($result)
		{
            $count = mysql_num_rows($result);
            if ($count >= 1)
			{
			while ($order = mysql_fetch_assoc($result))
				{
					$listOrder[] = $order;
				}
			}
		}
		else
		{
			echo sql_error();
		}
        }
        else if ($act == "lastmonth"){
        $time = date('Y-m-d H:i:s', time()-(86400*30));
        $sql = "SELECT * from " . $config['table_orders'] . " LEFT JOIN " . $config['table_users'] . " ON " . $config['table_orders'] . ".userId = users.userId WHERE " . $config['table_orders'] . ".orderDate > '".$time."' ORDER BY orderId ASC";
        $result = mysql_query($sql, $data_sql);
		if ($result)
		{
            $count = mysql_num_rows($result);
			if ($count >= 1)
			{
			while ($order = mysql_fetch_assoc($result))
				{
					$listOrder[] = $order;
				}
			}
		}
		else
		{
			echo sql_error();
		}
        }
         else {
		$sql = "SELECT * from " . $config['table_orders'] . " LEFT JOIN " . $config['table_users'] . " ON " . $config['table_orders'] . ".userId = users.userId ORDER BY orderId ASC";
		$result = mysql_query($sql, $data_sql);
		if ($result)
		{
            $count = mysql_num_rows($result);
			if ($count >= 1)
			{
			while ($order = mysql_fetch_assoc($result))
				{
					$listOrder[] = $order;
				}
            }
		}
		else
		{
			echo sql_error();
		}
        }
        echo $twig->render('admin/orders.tpl', array(
            'listOrder' => $listOrder
            ));
	}
	db_close();
?>