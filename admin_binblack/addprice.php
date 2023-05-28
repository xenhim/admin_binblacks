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
        $sql = "SELECT cardId FROM " . $config["table_cards"] . " WHERE (cardCou = '" . $country . "' AND cardUsed = '0' AND price <= '0')";
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
                    $sql = "UPDATE " . $config["table_cards"] . " SET price = '" . $price . "' WHERE cardId = '" . $set[cardId] . "'";
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
                $respond[text] = '<strong> ' . $kolvo . ' ' . $country . ' Cards update!</strong> (Price = ' . $price . ' $ )';
            } else
            {
                $respond[type] = "danger";
                $respond[text] = 'No cards.';
            }
        } else
        {
            echo sql_error();
        }
        echo $twig->render('elements/alerts.tpl', array('respond' => $respond));
    } else
    {
        $sql = "SELECT cardCou, COUNT(cardCou) AS count FROM " . $config["table_cards"] . " WHERE (cardUsed = '0' AND price <= '0') GROUP BY cardCou ORDER BY count DESC";
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
            //ECHO
            echo $twig->render('admin/cardaddprice.tpl', array('listprice' => $listprice));
        } else
        {
            echo sql_error();
        }
    }
}
db_close();

?>