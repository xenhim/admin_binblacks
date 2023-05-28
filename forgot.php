<?php

set_time_limit(0);
session_start();
require_once 'lib/Twig/Autoloader.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('template');
$twig = new Twig_Environment($loader, array('cache' => 'template/cache', 'auto_reload' => true));
include_once ("includes/global.php");
include_once ("includes/xmpp.class.php");
db_connection();
$act = clean($_GET["act"]);
if ($act == 'logout')
{
    @session_destroy();
    @session_start();
    header("location: index.php");
} else
{
    if (is_login())
    {
        header("location: index.php");
    } else
    {
        if (isset($_POST['username']) && isset($_POST['jabber']) && isset($_POST['captcha']))
        {
            if ($_POST['captcha'] === $_SESSION["captcha"])
            {
                $username = clean($_POST['username']);
                $jabber = clean($_POST['jabber']);
                $sql = "SELECT * FROM " . $config['table_users'] . " WHERE username='$username' AND jabber='$jabber'";
                $result = mysql_query($sql, $data_sql);
                if (!$result)
                {
                    echo sql_error();
                } else
                {
                    $count = mysql_num_rows($result);
                    if ($count == 1)
                    {
                        function genPassword($length)
                        {
                            $password = "";
                            $arr = array(
      'a', 'b', 'c', 'd', 'e', 'f',
      'g', 'h', 'i', 'j', 'k', 'l',
      'm', 'n', 'o', 'p', 'q', 'r',
      's', 't', 'u', 'v', 'w', 'x',
      'y', 'z', 'A', 'B', 'C', 'D',
      'E', 'F', 'G', 'H', 'I', 'J',
      'K', 'L', 'M', 'N', 'O', 'P',
      'Q', 'R', 'S', 'T', 'U', 'V',
      'W', 'X', 'Y', 'Z', '1', '2',
      '3', '4', '5', '6', '7', '8',
      '9', '0', '#', '!', "?", "&"
    );
                            for ($i = 0; $i < $length; $i++)
                                $password .= $arr[mt_rand(0, count($arr) - 1)];
                            return $password;
                        }
                        $newpassword = genPassword(10);
                        $user = mysql_fetch_assoc($result);
                        $jabber = $user["jabber"];
                        $username = $user["username"];
                        $userId = $user["userId"];
                        $sql = "UPDATE " . $config["table_users"] . " SET password = '" . md5($newpassword) . "' WHERE userId = '" . $userId . "'";
                        $result = mysql_query($sql, $data_sql);
                        if (!$result)
                        {
                            echo sql_error();
                        }
                        //SEND PASSWORD//
                        $webi = new XMPP($webi_conf);
                        $webi->connect();
                        $webi->sendStatus('' . $config['SiteName'] . '', 'chat', 50);
                        $messageU = "Hello, " . $username . ". You new password: \"" . $newpassword . "\"     |||     Login: " . $config['homeUrl'] . "login.php";
                        $webi->sendMessage("" . $jabber . "", $messageU);
                        //SEND PASSWORD//
                        $respond[type] = "success";
                        $respond[text] = "<strong> $username </strong> New password sent to your Jabber!";
                    } else
                    {
                        $respond[type] = "danger";
                        $respond[text] = "Wrong username or Jabber";
                    }
                }
                @mysql_free_result($result);
            } else
            {
                $respond[type] = "danger";
                $respond[text] = "Wrong captcha";
            }
        }
        echo $twig->render('forgot.tpl', array(
            'respond' => $respond,
            'sitename' => $config['SiteName'],
            'logo' => $config['logo']));
    }
}
db_close();

?>