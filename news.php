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
    }
    echo $twig->render('news.tpl', array(
            'saledump' => $config['saledump'],
            'salecc' => $config['salecc'],
            'listdumpnews' => $listdumpnews,
            'listdumpbase' => $listdumpbase,
            'listccnews' => $listccnews,
            'listccbase' => $listccbase
            ));
    
	db_close();
?>