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
echo $twig->render('support.tpl');
    }
	db_close();
?>