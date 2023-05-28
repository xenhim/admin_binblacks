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
    if ($act == "addnewsdump"){
    if (isset($_GET["save"]))
			{
    $date = clean($_GET["date"]);
    $color = clean($_GET["color"]);
    $text = clean($_GET["text"]);
    $sql = "INSERT INTO " . $config["table_news"] . " (date, color, text, category) VALUES ('$date', '$color', '$text', '1')";
	$result = mysql_query($sql, $data_sql);
	if ($result)
	{
header("location: news.php");
	}
	else
	   {
	   echo sql_error();
	   }
      }   
    }
    else if ($act == "addnewscc"){
    if (isset($_GET["save"]))
			{ 
    $date = clean($_GET["date"]);
    $color = clean($_GET["color"]);
    $text = clean($_GET["text"]);
    $sql = "INSERT INTO " . $config["table_news"] . " (date, color, text, category) VALUES ('$date', '$color', '$text', '2')";
	$result = mysql_query($sql, $data_sql);
	if ($result)
	{
	   header("location: news.php");
	}
	else
	   {
	   echo sql_error();
	   }
    }    
    }
    else if ($act == "delete")
    {
			$id = clean($_GET["id"]);
			$sql = "DELETE from " . $config["table_news"] . " WHERE id = '$id'";
			$result = mysql_query($sql, $data_sql);
			if ($result)
			{
				header("location: news.php");
			}
			else
			{
				echo sql_error();
			}
		}
        else if ($act == "basedelete")
    {
			$id = clean($_GET["id"]);
			$sql = "DELETE from " . $config["table_bases"] . " WHERE id = '$id'";
			$result = mysql_query($sql, $data_sql);
			if ($result)
			{
				header("location: news.php");
			}
			else
			{
				echo sql_error();
			}
		}
    else if ($act == "addbasedump"){
    if (isset($_GET["save"]))
			{ 
    $category = clean($_GET["dcategory"]);
    $color = clean($_GET["dcolor"]);
    $precent = clean($_GET["dprecent"]);
    $sql = "INSERT INTO " . $config["table_bases"] . " (category, color, precent, type) VALUES ('$category', '$color', '$precent', '1')";
	$result = mysql_query($sql, $data_sql);
	if ($result)
	{
	   header("location: news.php");
	}
	else
	   {
	   echo sql_error();
	   }
    }    
    }
    else if ($act == "addbasecc"){
    if (isset($_GET["save"]))
			{ 
    $category = clean($_GET["cccategory"]);
    $color = clean($_GET["cccolor"]);
    $precent = clean($_GET["ccprecent"]);
    $sql = "INSERT INTO " . $config["table_bases"] . " (category, color, precent, type) VALUES ('$category', '$color', '$precent', '2')";
	$result = mysql_query($sql, $data_sql);
	if ($result)
	{
	   header("location: news.php");
	}
	else
	   {
	   echo sql_error();
	   }
    }    
    }
    else 
    {
       $sql = "SELECT * FROM " . $config['table_news'] . " WHERE category = '1' ORDER BY DATE_FORMAT(date, '%d%m%Y') DESC";
            $result = mysql_query($sql,$data_sql);
			if (!$result)
			{
				echo sql_error();
			}
			else
			{
				while ($dumpnews = mysql_fetch_assoc($result))
				{
					$listdumpnews[] = $dumpnews;
				}
			}
        $sql = "SELECT * FROM " . $config['table_bases'] . " LEFT JOIN " . $config['table_categorys_dump'] . " ON " . $config['table_bases'] . ".category = ".$config['table_categorys_dump'].".categoryId WHERE type = '1' ORDER BY precent DESC";
            $result = mysql_query($sql,$data_sql);
			if (!$result)
			{
				echo sql_error();
			}
			else
			{
				while ($dumpbase = mysql_fetch_assoc($result))
				{
					$listdumpbase[] = $dumpbase;
				}
			}
            $sql = "SELECT categoryId,categoryName FROM " . $config['table_categorys_dump'] . " ORDER BY categoryId";
            $result = mysql_query($sql,$data_sql);
			if (!$result)
			{
				echo sql_error();
			}
			else
			{
				while ($category = mysql_fetch_assoc($result))
				{
					$listCategory[] = $category;
				}
			}
            $sql = "SELECT categoryId,categoryName FROM " . $config['table_categorys'] . " ORDER BY categoryId";
            $result = mysql_query($sql,$data_sql);
			if (!$result)
			{
				echo sql_error();
			}
			else
			{
				while ($dumpcategory = mysql_fetch_assoc($result))
				{
					$dumplistCategory[] = $dumpcategory;
				}
			}
        $sql = "SELECT * FROM " . $config['table_news'] . " WHERE category = '2' ORDER BY DATE_FORMAT(date, '%d%m%Y') DESC";
            $result = mysql_query($sql,$data_sql);
			if (!$result)
			{
				echo sql_error();
			}
			else
			{
				while ($ccnews = mysql_fetch_assoc($result))
				{
					$listccnews[] = $ccnews;
				}
			}
        $sql = "SELECT * FROM " . $config['table_bases'] . " LEFT JOIN " . $config['table_categorys'] . " ON " . $config['table_bases'] . ".category = ".$config['table_categorys'].".categoryId WHERE type = '2' ORDER BY precent DESC";
            $result = mysql_query($sql,$data_sql);
			if (!$result)
			{
				echo sql_error();
			}
			else
			{
				while ($ccbase = mysql_fetch_assoc($result))
				{
					$listccbase[] = $ccbase;
				}
			}
    echo $twig->render('admin/news.tpl', array(
            'listdumpnews' => $listdumpnews,
            'listdumpbase' => $listdumpbase,
            'listccnews' => $listccnews,
            'listccbase' => $listccbase,
            'dumplistCategory' => $dumplistCategory,
            'listCategory' => $listCategory
            ));
    }
    }
	db_close();
?>