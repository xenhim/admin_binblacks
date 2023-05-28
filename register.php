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
if (is_login())
{
    header("location: index.php");
} else
{
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['jabber']) && isset($_POST['captcha']))
    {
        if ($_POST['captcha'] === $_SESSION["captcha"])
        {
            $username = clean($_POST['username']);
            $password = clean($_POST['password']);
            $jabber = clean($_POST['jabber']);
            $jabber = htmlspecialchars($jabber);
            if (!preg_match("/^[a-zA-Z0-9]+$/", $username))
            {
                $respond[type] = "danger";
                $respond[text] = "Bad Username, use only A-z,0-9 symbols";
            } else
                if (strlen($username) < 3)
                {
                    $respond[type] = "danger";
                    $respond[text] = "Username at least 3 characters";
                } else
                    if (strlen($username) > 20)
                    {
                        $respond[type] = "danger";
                        $respond[text] = "Username no more than 20 characters";
                    } else
                        if (strlen($password) < 6)
                        {
                            $respond[type] = "danger";
                            $respond[text] = "Password at least 6 characters";
                        } else
                            if (!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $jabber))
                            {
                                $respond[type] = "danger";
                                $respond[text] = "Jabber Not Available";
                            } else
                            {
                                $sql = "SELECT username FROM " . $config['table_users'] . " WHERE username='$username' OR jabber='$jabber'";
                                $result = mysql_query($sql, $data_sql);
                                if (!$result)
                                {
                                    echo sql_error();
                                } else
                                {
                                    $count = mysql_num_rows($result);
                                    if ($count >= 1)
                                    {
                                        $user = mysql_fetch_row($result);
                                        if ($username == $user[0])
                                        {
                                            $respond[type] = "danger";
                                            $respond[text] = "This username has been used";
                                        } else
                                        {
                                            $respond[type] = "danger";
                                            $respond[text] = "This jabber address has been used";
                                        }
                                    } else
                                    {
                                        $sql = "INSERT INTO " . $config['table_users'] . " (username, password, jabber, regDate) VALUES ('$username', '" . md5($password) . "', '$jabber', '" . time() . "')";
                                        $result = mysql_query($sql, $data_sql);
                                        if (!$result)
                                        {
                                            echo sql_error();
                                        } else
                                        {
                                            //WELLCOME JABBER
                                            $webi = new XMPP($webi_conf);
                                            $webi->connect();
                                            $webi->sendStatus('' . $config['SiteName'] . '', 'chat', 50);
                                            $messageU = "Hello, " . $username . ". Welcome to " . $config['SiteName'] . "     |||     Login: " . $config['homeUrl'] . "login.php";
                                            $webi->sendMessage("" . $jabber . "", $messageU);
                                            $respond[type] = "success";
                                            $respond[text] = "Hello <b>$username</b>, your account has been created";
                                        }
                                    }
                                }
                            }
                            @mysql_free_result($result);
        } else
        {
            $respond[type] = "danger";
            $respond[text] = "Wrong captcha";
        }
    }
    echo $twig->render('register.tpl', array(
        'respond' => $respond,
        'sitename' => $config['SiteName'],
        'logo' => $config['logo']));
}
db_close();

?>