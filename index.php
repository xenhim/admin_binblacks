<?php
ini_set('session.cookie_lifetime', 86400);
ini_set('session.gc_maxlifetime', 86400);
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
		$messages = mysql_num_rows($result);
		if ($messages >= 1)
		{
        $msgnew = '<span class="badge"> '.$messages.'</span>';
        $shortmsg = '<ul class="dropdown-menu posts"><li><span class="dropdown-menu-title"> You have '.$messages.' messages</span></li><li><div class="drop-down-wrapper"><ul>';
        while ( $row = mysql_fetch_array($result) )
                {
                        $messagesshort[] = $row;
                }
        foreach ( $messagesshort as $value )
                {
        $shortmsg .= '<li><a href="javascript:;"><div class="clearfix"><div class="thread-image"><img src="./images/support.jpg"></div><div class="thread-content"><span class="author">Support</span><span class="preview">'.htmlspecialchars(substr($value['msg'],0,100)).'</span><span class="time"> ' . date('d.m.Y H:i:s', strtotime($value["date_msg"])) . '</span></div></div></a></li>';            
                }
        $shortmsg .= '</ul></div></li><li class="view-all">';
        if ($_SESSION["userType"] == '1'){
        $shortmsg .= '<a href="#" >See messages in Admin panel <i class="fa fa-arrow-circle-o-right"></i></a></li></ul>';
        } else {
        $shortmsg .= '<a href="#" onclick="showpage(\'support.php\');">See all messages <i class="fa fa-arrow-circle-o-right"></i></a></li></ul>';        
		}
        }
		else
		{
		$msgnew = '';
        $shortmsg ='';
		}
	}
    if (isset($_GET["page"]))
	{
		$subpage = clean($_GET["page"]);
	}
	else
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
    echo $twig->render('index.tpl', array(
            'config' => $config,
            'credit' => $credit,
            'session' => $_SESSION,
            'msgnew' => $msgnew,
            'shortmsg' => $shortmsg,
            'respond' => $respond,
            'sitename' => $config['SiteName'],
            'logo' => $config['logo'],
            'themeusr' => $config['themeusr'],
            'homeurl' => $config['homeUrl'],
            'page' => $page
            ));
	db_close();
?>