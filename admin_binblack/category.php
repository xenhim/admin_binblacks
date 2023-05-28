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
    if ($act == "edit")
    {
        if (isset($_POST["save"]))
        {
            $categoryid = clean($_POST["categoryid"]);
            $categoryname = clean($_POST["categoryname"]);
            $categoryinfo = clean($_POST["categoryinfo"]);
            $sql = "UPDATE " . $config["table_categorys"] . " SET categoryName = '$categoryname', categoryInfo = '$categoryinfo' WHERE categoryId = '$categoryid'";
            $result = mysql_query($sql, $data_sql);
            if ($result)
            {
                echo "<script type=\"text/javascript\" src=\"../js/jquery-1.4.2.min.js\"></script><script>alert('Edited category $categoryname successful');$(parent).ready(function(){parent.showpage('category.php');});</script>";
            } else
            {
                echo sql_error();
            }
        } else
        {
            $categoryid = clean($_GET["categoryid"]);
            $sql = "SELECT * from " . $config["table_categorys"] . " WHERE categoryId = '$categoryid'";
            $result = mysql_query($sql, $data_sql);
            if ($result)
            {
                $count = mysql_num_rows($result);
                if ($count == 1)
                {
                    $category = mysql_fetch_assoc($result);
                }
            } else
            {
                echo sql_error();
            }
            echo $twig->render('admin/editcardcategory.tpl', array('category' => $category));
        }
    } else
        if ($act == "delete")
        {
            $categoryid = clean($_GET["categoryid"]);
            $sql = "DELETE from " . $config["table_categorys"] . " WHERE categoryId = '$categoryid'";
            $result = mysql_query($sql, $data_sql);
            if ($result)
            {
                header("location: category.php");
            } else
            {
                echo sql_error();
            }
        } else
            if ($act == "add")
            {
                if (isset($_POST["save"]))
                {
                    $categoryname = clean($_POST["categoryname"]);
                    $categoryinfo = clean($_POST["categoryinfo"]);
                    $sql = "INSERT INTO " . $config["table_categorys"] . "(categoryName, categoryInfo) VALUES ('$categoryname', '$categoryinfo')";
                    $result = mysql_query($sql, $data_sql);
                    if ($result)
                    {
                        echo "<center><font color='#49A178'>Added category successful</font></center>";
                    } else
                    {
                        echo sql_error();
                    }
                } else
                {
                    echo $twig->render('admin/addcardcategory.tpl');
                }
            } else
            {
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
                    }
                } else
                {
                    echo sql_error();
                }
                echo $twig->render('admin/cardcategory.tpl', array('listCategory' => $listCategory));
            }
}
db_close();

?>