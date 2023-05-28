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
        $code = clean($_GET["code"]);
        $class = clean($_GET["class"]);
        $level = clean($_GET["level"]);
        $sql = "SELECT dumpId FROM " . $config["table_dumps"] . " WHERE (categoryId = '" . $category . "' AND dumpCou = '" . $country . "' AND dumpcode = '" . $code . "' AND dumpclass = '" . $class . "' AND dumplevel = '" . $level . "' AND dumpUsed = '0' AND price = '" . $lastprice . "')";
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
                $respond[text] = '<strong> ' . $kolvo . ' ' . $country . ' (code: ' . $code . ', class: ' . $class . ', level: ' . $level . ' ) Cards update!</strong> (Price = ' . $lastprice . ' -->  ' . $price . '$ )';
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
        //MAIN PAGE//
        $header = $twig->render('admin/dumpeditprice.tpl', array('type' => 'head'));
        $sql = "SELECT * from " . $config["table_categorys_dump"] . " ORDER BY categoryId";
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
                    $sql = "SELECT dumpcode, dumpclass, dumplevel, price, dumpCou, COUNT(dumpCou) AS count FROM " . $config["table_dumps"] . " WHERE (categoryId = '" . $category["categoryId"] . "' AND dumpUsed = '0') GROUP BY dumpCou, price, dumpcode, dumpclass, dumplevel ORDER BY count DESC";
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
                    $tables .= $twig->render('admin/dumpeditprice.tpl', array(
                        'type' => 'table',
                        'category' => $category,
                        'listprice' => $listprice,
                        ));
                    unset($listprice);
                }
            }
        } else
        {
            echo sql_error();
        }
        echo $header;
        echo $tables;
    }
}
db_close();

?>