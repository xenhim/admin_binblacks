<?php

set_time_limit(0);
session_start();
require_once '../lib/Twig/Autoloader.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('../template');
$twig = new Twig_Environment($loader, array('cache' => '../template/cache', 'auto_reload' => true));
include_once ("../includes/global.php");
db_connection();
$act = clean($_GET["act"]);
if (!is_login_admin())
{
    header("location: login.php");
} else
{
    if ($act == "open")
    {
        if (isset($_GET["id"]))
        {
            $id = clean($_GET["id"]);
            $sql = "SELECT * from " . $config["table_salepack"] . " WHERE id = '" . $id . "'";
            $result = mysql_query($sql, $data_sql);
            if (!$result)
            {
                echo sql_error();
            } else
            {
                $pack = mysql_fetch_assoc($result);
            }
            $sql = "SELECT *, AES_DECRYPT(dumpContent, '$config[encode_key]') as dumpContent, DATE_FORMAT(date, '%d.%m.%Y') as sdate from " . $config["table_dumps"] . " WHERE pack = '" . $id . "' ORDER BY date DESC";
            $result = mysql_query($sql, $data_sql);
            if ($result)
            {
                $count = mysql_num_rows($result);
                if ($count >= 1)
                {
                    while ($card = mysql_fetch_assoc($result))
                    {
                        $listCard[] = $card;
                    }
                }
                echo $twig->render('admin/elements/openpack.tpl', array(
                    'listCard' => $listCard,
                    'pack' => $pack,
                    'id' => $id));
            } else
            {
                echo sql_error();
            }
        }
    } else
    {
        $sql = "SELECT *, DATE_FORMAT(date, '%d.%m.%Y') as sdate from " . $config["table_salepack"] . " LEFT JOIN " . $config["table_users"] . " ON " . $config["table_salepack"] . ".used = " . $config["table_users"] . ".userId ORDER BY date DESC";
        $result = mysql_query($sql, $data_sql);
        if ($result)
        {
            $count = mysql_num_rows($result);
            if ($count >= 1)
            {
                while ($card = mysql_fetch_assoc($result))
                {
                    $listCard[] = $card;
                }
            }
        } else
        {
            echo sql_error();
        }
        echo $twig->render('admin/elements/salespacklist.tpl', array('listCard' => $listCard));
    }
}
db_close();

?>