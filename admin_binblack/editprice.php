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
        $category = clean($_GET["category"]);
        $price = clean($_GET["price"]);
        $price = str_replace(",", ".", $price);
        $lastprice = clean($_GET["lastprice"]);
        $lastprice = str_replace(",", ".", $lastprice);
        $country = clean($_GET["country"]);
        $sql = "SELECT cardId FROM " . $config["table_cards"] . " WHERE (categoryId = '" . $category . "' AND cardCou = '" . $country . "' AND cardUsed = '0' AND price = '" . $lastprice . "')";
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
                $respond[text] = '<strong> ' . $kolvo . ' ' . $country . ' Cards update!</strong> (Price = ' . $lastprice . ' -->  ' . $price . '$ )';
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
        //MAIN PAGE//
        $header = $twig->render('admin/cardeditprice.tpl', array('type' => 'head'));
        $sql = "SELECT * from " . $config["table_categorys"] . " ORDER BY categoryId";
        $result = mysql_query($sql, $data_sql);
        if ($result)
        {
            $count = mysql_num_rows($result);
            if ($count >= 1)
            {
                while ($category = mysql_fetch_assoc($result))
                {
                    $listCategory[] = $category;
                }
                foreach ($listCategory as $category)
                {
                    $sql = "SELECT price, cardCou, COUNT(cardCou) AS count FROM " . $config["table_cards"] . " WHERE (categoryId = '" . $category["categoryId"] . "' AND cardUsed = '0') GROUP BY cardCou, price ORDER BY count DESC";
                    $result = mysql_query($sql, $data_sql);
                    if ($result)
                    {
                        $msgHtml .= "<center><div class='panel panel-default' style='width:650px'><div class='panel-heading'><i class='fa fa-credit-card'></i>" . $category["categoryName"] . "</div>";
                        $msgHtml .= "<table class='table table-bordered table-striped'>";
                        $msgHtml .= "<tr><th width='175px'><center>Country</center></th><th width='175px'><center>Value</center></th><th width='200px'><center>Action/Result</center></th></tr>";
                        $count = mysql_num_rows($result);
                        if ($count >= 1)
                        {
                            while ($noprice = mysql_fetch_assoc($result))
                            {
                                $listprice[] = $noprice;
                            }
                        }
                        $tables .= $twig->render('admin/cardeditprice.tpl', array(
                            'type' => 'table',
                            'category' => $category,
                            'listprice' => $listprice,
                            ));
                        unset($listprice);
                    } else
                    {
                        echo sql_error();
                    }
                }
            }
        } else
        {
            echo sql_error();
        }
    }
    //MAIN PAGE//
    echo $header;
    echo $tables;
}
db_close();

?>