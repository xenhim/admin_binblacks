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
    if ($act == "set")
    {
        $price = clean($_GET["price"]);
        $price = str_replace(",", ".", $price);
        $country = clean($_GET["country"]);
        $code = clean($_GET["code"]);
        $class = clean($_GET["class"]);
        $level = clean($_GET["level"]);
        $sql = "SELECT dumpId FROM " . $config["table_dumps"] . " WHERE (dumpCou = '" . $country . "' AND dumpcode = '" . $code . "' AND dumpclass = '" . $class . "' AND dumplevel = '" . $level . "' AND dumpUsed = '0' AND price <= '0')";
        $result = mysql_query($sql, $data_sql);
        if ($result)
        {
            $count = mysql_num_rows($result);
            if ($count >= 1)
            {
                while ($set = mysql_fetch_assoc($result))
                {
                    $setprice[] = $set;
                }
                foreach ($setprice as $set)
                {
                    $sql = "UPDATE " . $config["table_dumps"] . " SET price = '" . $price . "' WHERE dumpId = '" . $set[dumpId] . "'";
                    $result = mysql_query($sql, $data_sql);
                    if ($result)
                    {
                        $kolvo += 1;
                    } else
                    {
                        echo sql_error();
                    }
                }
                $respond[type] = "success";
                $respond[text] = '<strong> ' . $kolvo . ' ' . $country . ' (code: ' . $code . ', class: ' . $class . ', level: ' . $level . ' ) Dumps update!</strong> (Price = ' . $price . ' $ )';
            } else
            {
                $respond[type] = "danger";
                $respond[text] = 'No dumps.';
            }
        } else
        {
            echo sql_error();
        }
        echo $twig->render('elements/alerts.tpl', array('respond' => $respond));
    } else
    {
        $sql = "SELECT dumpcode, dumpclass, dumplevel, dumpCou, COUNT(dumpCou) AS count FROM " . $config["table_dumps"] . " WHERE (dumpUsed = '0' AND price <= '0') GROUP BY dumpCou, dumpcode, dumpclass, dumplevel ORDER BY count DESC";
        $result = mysql_query($sql, $data_sql);
        if ($result)
        {
        $count = mysql_num_rows($result);
            if ($count >= 1)
            {
                while ($noprice = mysql_fetch_assoc($result))
                {
                    $listprice[] = $noprice;
                }
            } 
        } else
        {
            echo sql_error();
        }
        echo $twig->render('admin/dumpaddprice.tpl', array('listprice' => $listprice));
    }
}
db_close();

?>