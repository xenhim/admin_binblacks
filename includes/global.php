<?php
//Begin Variable
	global $config;
	include_once("config.php");
	$config["show_error"] = false;
	$config["encode_key"] = "V31PMZMJx3V31PMZMJx3";
	$config["table_settings"] = "settings";
	$config["table_users"] = "users";
	$config["table_types"] = "types";
	$config["table_cards"] = "cards";
	$config["table_categorys"] = "category";
    $config["table_categorys_dump"] = "dumpcategory";
	$config["table_plans"] = "plans";
	$config["table_orders"] = "orders";
    $config["table_packs"] = "packs";
    $config["table_salepack"] = "salepack";
    $config["table_dumps"] = "dumps";
	$config["table_faq"] = "faq";
    $config["table_news"] = "news";
    $config["table_bases"] = "bases";
	$config["table_questions"] = "questions";
    $config["table_support"] = "support";
//End Variable
//	include_once ("../functions.php");

//Begin Function
	function db_connection()
	{
		global $config,$data_sql;
		$data_sql = mysql_connect($config["sql_host"], $config["sql_user"], $config["sql_pass"]);
		if (!$data_sql) die("Can't connect to MySql");
		mysql_select_db($config["db_name"],$data_sql) or die("Can't select database");
	}
	function db_close()
	{
		global $data_sql;
		@mysql_close($data_sql);
	}
	function clean($str)
	{
		$str = @trim($str);
		if(get_magic_quotes_gpc())
		{
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
	function is_login()
	{
		//if (session_is_registered("userId") && session_is_registered("username") && session_is_registered("regDate"))
		if (isset($_SESSION['userId']) && ($_SESSION['username']) && ($_SESSION['regDate']))
		{
			return true;
		}
		else
		{
			@session_destroy();
			return false;
		}
	}
    function is_login_seller()
	{
		//if (session_is_registered("userId") && session_is_registered("username") && session_is_registered("regDate") && $_SESSION["userType"] == '3')
		if (isset($_SESSION['userId']) && ($_SESSION['username']) && ($_SESSION['regDate']) && ($_SESSION['userType'] == '3'))
		{
			return true;
		}
		else
		{
			@session_destroy();
			return false;
		}
	}
	function is_login_admin()
	{
		//if (session_is_registered("userId") && session_is_registered("username") && session_is_registered("regDate") && $_SESSION["userType"] == '1')
		if (isset($_SESSION['userId']) && ($_SESSION['username']) && ($_SESSION['regDate']) && ($_SESSION['userType'] == '1'))
		{
			return true;
		}
		else
		{
			@session_destroy();
			return false;
		}
	}
function sql_error()
{
	if ($config['show_error'])
	{
		die('Invalid query: ' . mysql_error($data_sql));
	}
	else
	{
		die("Error, please contact webmaster for more information.");
	}
}
//End Function
	
//Begin configuration
	if (!$config['show_error'])
	{
		error_reporting(1);
	}
	session_start();
//End configuration
	
	db_connection();
	$sql = "SELECT * FROM " . $config["table_settings"];
	$result = mysql_query($sql,$data_sql);
	if ($result)
	{
		while ($setting = mysql_fetch_assoc($result))
		{
			$listSetting[] = $setting;
		}
		if (is_array($listSetting))
		{
			foreach($listSetting as $setting)
			{
				$config[$setting[settingName]] = $setting[settingValue];
			}
		}
		else
		{
			die("Data setting has error.");
		}
	}
	else
	{
		if ($config['show_error'])
		{
			die('Invalid query: ' . mysql_error($data_sql));
		}
		else
		{
			die("Error, please contact webmaster for more information.");
		}
	}
	db_close();
?>
