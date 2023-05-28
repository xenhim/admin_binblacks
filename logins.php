<?php

set_time_limit(0);
session_start();
require_once 'lib/Twig/Autoloader.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('template');
$twig = new Twig_Environment($loader, array('cache' => 'template/cache', 'auto_reload' => true));
include_once ("includes/global.php");
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
        if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['captcha']))
        {
            if ($_POST['captcha'] === $_SESSION["captcha"])
            {
                $username = clean($_POST['username']);
                $password = md5(clean($_POST['password']));
                $sql = "SELECT * FROM " . $config['table_users'] . " WHERE username='$username' AND password='$password'";
                $result = mysql_query($sql, $data_sql);
                if (!$result)
                {
                    echo sql_error();
                } else
                {
                    $count = mysql_num_rows($result);
                    if ($count == 1)
                    {
                        session_start();
                        $user = mysql_fetch_assoc($result);
                        $userId = $user["userId"];
                        $regDate = $user["regDate"];
                        $userType = $user["typeId"];
                        $timeuser = setcookie("username", "$username", time()+ 86400,'/');
                        $_SESSION["userId"] = $userId;
                        $_SESSION["username"] = $username;
                        $_SESSION["regDate"] = $regDate;
                        $_SESSION["userType"] = $userType;
                        $_SESSION["timeuser"] = $timeuser;
                        header("location: index.php");
                    } else
                    {
                        $respond[type] = "danger";
                        $respond[text] = "Wrong username or password";
                    }
                }
                @mysql_free_result($result);
            } else
            {
                $respond[type] = "danger";
                $respond[text] = 'Wrong captcha';
            }
        }
        echo $twig->render('login.tpl', array(
            'respond' => $respond,
            'sitename' => $config['SiteName'],
            'logo' => $config['logo']));
    }
}
db_close();

?>