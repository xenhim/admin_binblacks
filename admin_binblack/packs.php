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
    if ($act == "create")
    {
        $sql = "SELECT categoryId,categoryName FROM " . $config['table_categorys_dump'] . " ORDER BY categoryId";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            while ($category = mysql_fetch_assoc($result))
            {
                $listCategory[] = $category;
            }
        }
        $sql = "SELECT userId, username FROM " . $config['table_users'] . " WHERE typeId = '3' ORDER BY userId";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            while ($seller = mysql_fetch_assoc($result))
            {
                $listSeller[] = $seller;
            }
        }
        $sql = "SELECT dumpCou, COUNT(dumpCou) AS count FROM " . $config['table_dumps'] . " WHERE (dumpUsed = '0' AND price > '0') GROUP BY dumpCou ORDER BY count DESC";
        $result = mysql_query($sql, $data_sql);

        if (!$result)
        {
            echo sql_error();
        } else
        {
            while ($country = mysql_fetch_assoc($result))
            {
                $listCou[] = $country;
            }
        }
        $sql = "SELECT dumptype, COUNT(dumptype) AS count FROM " . $config['table_dumps'] . " WHERE (dumpUsed = '0' AND price > '0') GROUP BY dumptype ORDER BY count DESC";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            while ($listype = mysql_fetch_assoc($result))
            {
                $listtype[] = $listype;
            }
        }
        $sql = "SELECT dumpcode, COUNT(dumpcode) AS count FROM " . $config['table_dumps'] . " WHERE (dumpUsed = '0' AND price > '0') GROUP BY dumpcode ORDER BY count DESC";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            while ($liscode = mysql_fetch_assoc($result))
            {
                $listcode[] = $liscode;
            }
        }
        $sql = "SELECT dumplevel, COUNT(dumplevel) AS count FROM " . $config['table_dumps'] . " WHERE (dumpUsed = '0' AND price > '0') GROUP BY dumplevel ORDER BY count DESC";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            while ($lislevel = mysql_fetch_assoc($result))
            {
                $listlevel[] = $lislevel;
            }
        }
        $sql = "SELECT dumpclass, COUNT(dumpclass) AS count FROM " . $config['table_dumps'] . " WHERE (dumpUsed = '0' AND price > '0') GROUP BY dumpclass ORDER BY count DESC";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            while ($lisclass = mysql_fetch_assoc($result))
            {
                $listclass[] = $lisclass;
            }
        }
        echo $twig->render('admin/elements/packsadd.tpl', array(
            'listCategory' => $listCategory,
            'listCou' => $listCou,
            'listcode' => $listcode,
            'listtype' => $listtype,
            'listclass' => $listclass,
            'listlevel' => $listlevel,
            'listSeller' => $listSeller));

    } else
        if ($act == "edit")
        {
            $id = clean($_GET["id"]);
            $sql = "SELECT * FROM " . $config['table_packs'] . " WHERE Id = '$id'";
            $result = mysql_query($sql, $data_sql);
            if (!$result)
            {
                echo sql_error();
            } else
            {
                $pack = mysql_fetch_assoc($result);
            }
            $sql = "SELECT categoryId,categoryName FROM " . $config['table_categorys_dump'] . " ORDER BY categoryId";
            $result = mysql_query($sql, $data_sql);
            if (!$result)
            {
                echo sql_error();
            } else
            {
                while ($category = mysql_fetch_assoc($result))
                {
                    $listCategory[] = $category;
                }
            }
            $sql = "SELECT userId, username FROM " . $config['table_users'] . " WHERE typeId = '3' ORDER BY userId";
            $result = mysql_query($sql, $data_sql);
            if (!$result)
            {
                echo sql_error();
            } else
            {
                while ($seller = mysql_fetch_assoc($result))
                {
                    $listSeller[] = $seller;
                }
            }
            $sql = "SELECT dumpCou, COUNT(dumpCou) AS count FROM " . $config['table_dumps'] . " WHERE (dumpUsed = '0' AND price > '0') GROUP BY dumpCou ORDER BY count DESC";
            $result = mysql_query($sql, $data_sql);

            if (!$result)
            {
                echo sql_error();
            } else
            {
                while ($country = mysql_fetch_assoc($result))
                {
                    $listCou[] = $country;
                }
            }
            $sql = "SELECT dumptype, COUNT(dumptype) AS count FROM " . $config['table_dumps'] . " WHERE (dumpUsed = '0' AND price > '0') GROUP BY dumptype ORDER BY count DESC";
            $result = mysql_query($sql, $data_sql);
            if (!$result)
            {
                echo sql_error();
            } else
            {
                while ($listype = mysql_fetch_assoc($result))
                {
                    $listtype[] = $listype;
                }
            }
            $sql = "SELECT dumpcode, COUNT(dumpcode) AS count FROM " . $config['table_dumps'] . " WHERE (dumpUsed = '0' AND price > '0') GROUP BY dumpcode ORDER BY count DESC";
            $result = mysql_query($sql, $data_sql);
            if (!$result)
            {
                echo sql_error();
            } else
            {
                while ($liscode = mysql_fetch_assoc($result))
                {
                    $listcode[] = $liscode;
                }
            }
            $sql = "SELECT dumplevel, COUNT(dumplevel) AS count FROM " . $config['table_dumps'] . " WHERE (dumpUsed = '0' AND price > '0') GROUP BY dumplevel ORDER BY count DESC";
            $result = mysql_query($sql, $data_sql);
            if (!$result)
            {
                echo sql_error();
            } else
            {
                while ($lislevel = mysql_fetch_assoc($result))
                {
                    $listlevel[] = $lislevel;
                }
            }
            $sql = "SELECT dumpclass, COUNT(dumpclass) AS count FROM " . $config['table_dumps'] . " WHERE (dumpUsed = '0' AND price > '0') GROUP BY dumpclass ORDER BY count DESC";
            $result = mysql_query($sql, $data_sql);
            if (!$result)
            {
                echo sql_error();
            } else
            {
                while ($lisclass = mysql_fetch_assoc($result))
                {
                    $listclass[] = $lisclass;
                }
            }
            echo $twig->render('admin/elements/packsedit.tpl', array(
                'listCategory' => $listCategory,
                'listCou' => $listCou,
                'listcode' => $listcode,
                'listtype' => $listtype,
                'listclass' => $listclass,
                'listlevel' => $listlevel,
                'listSeller' => $listSeller,
                'pack' => $pack));
        } else
            if ($act == "add")
            {
                if (isset($_POST["save"]))
                {
                    $title = clean($_POST["title"]);
                    $comm1 = clean($_POST["comm1"]);
                    $comm2 = clean($_POST["comm2"]);
                    $category = clean($_POST["category"]);
                    $country = clean($_POST["country"]);
                    $code = clean($_POST["code"]);
                    $type = clean($_POST["type"]);
                    $class = clean($_POST["class"]);
                    $level = clean($_POST["level"]);
                    $quantity = clean($_POST["quantity"]);
                    $price = clean($_POST["price"]);
                    $price = str_replace(",", ".", $price);
                    $seller = clean($_POST["seller"]);
                    $refund = clean($_POST["refund"]);
                    $sellerprc = clean($_POST["sellerprc"]);
                    $sellerprc = str_replace(",", ".", $sellerprc);
                    if ($title != "" && $price != "" && $quantity != "" && $sellerprc != "")
                    {
                        $sql = "INSERT INTO " . $config["table_packs"] . " (`categoryId`, `type`, `level`, `class`, `code`, `name`, `comment1`, `comment2`, `Used`, `country`, `value`, `price`, `seller`, `sellerprc`, `norefund`) VALUES ('$category', '$type', '$level', '$class', '$code', '$title', '$comm1', '$comm2', '0', '$country', '$quantity', '$price', '$seller', '$sellerprc', '$refund')";
                        $result = mysql_query($sql, $data_sql);
                        if ($result)
                        {
                            echo '<font color="#099668"><center><strong>Added dump pack successful</strong></center></font>';
                        } else
                        {
                            echo sql_error();
                        }
                    } else
                    {
                        echo '<font color="#ff0000"><center><strong>Please fill all field requires (*)</strong></center></font>';
                    }
                }
            } else
                if ($act == "save")
                {
                    if (isset($_POST["save"]))
                    {
                        $id = clean($_GET["id"]);
                        $title = clean($_POST["title"]);
                        $comm1 = clean($_POST["comm1"]);
                        $comm2 = clean($_POST["comm2"]);
                        $category = clean($_POST["category"]);
                        $country = clean($_POST["country"]);
                        $code = clean($_POST["code"]);
                        $type = clean($_POST["type"]);
                        $class = clean($_POST["class"]);
                        $level = clean($_POST["level"]);
                        $quantity = clean($_POST["quantity"]);
                        $price = clean($_POST["price"]);
                        $price = str_replace(",", ".", $price);
                        $seller = clean($_POST["seller"]);
                        $sellerprc = clean($_POST["sellerprc"]);
                        $sellerprc = str_replace(",", ".", $sellerprc);
                        $refund = clean($_POST["refund"]);
                        if ($title != "" && $price != "" && $quantity != "" && $sellerprc != "")
                        {
                            $sql = "UPDATE " . $config["table_packs"] . " SET categoryId = '$category', type = '$type', level = '$level', class = '$class', code = '$code', name = '$title', comment1 = '$comm1', comment2 = '$comm2', Used = '0', country = '$country', value = '$quantity', price = '$price', seller = '$seller', sellerprc = '$sellerprc', norefund = '$refund' WHERE Id = '$id'";
                            $result = mysql_query($sql, $data_sql);
                            if ($result)
                            {
                                echo '<font color="#099668"><center><strong>Edit successful</strong></center></font>';
                            } else
                            {
                                echo sql_error();
                            }
                        } else
                        {
                            echo '<font color="#ff0000"><center><strong>Please fill all field requires (*)</strong></center></font>';
                        }
                    }
                } else
                    if ($act == "delete")
                    {
                        $id = clean($_GET["id"]);
                        $sql = "DELETE from " . $config["table_packs"] . " WHERE Id = '$id'";
                        $result = mysql_query($sql, $data_sql);
                        if ($result)
                        {
                            header("location: packs.php");
                        } else
                        {
                            echo sql_error();
                        }
                    } else
                    {
                        $sql = "SELECT * FROM " . $config['table_packs'] . " ORDER BY Id";
                        $result = mysql_query($sql, $data_sql);
                        if (!$result)
                        {
                            echo sql_error();
                        } else
                        {
                            while ($packs = mysql_fetch_assoc($result))
                            {
                                $listpacks[] = $packs;
                            }
                        }
                        foreach ($listpacks as $packs)
                        {
                            if ($packs['categoryId'] == '0')
                            {
                                $checkavil = '';
                            } else
                            {
                                $checkavil = ' AND categoryId = "' . $packs['categoryId'] . '"';
                            }
                            if ($packs['type'] == '0')
                            {
                                $checkavil .= '';
                            } else
                            {
                                $checkavil .= ' AND dumptype = "' . $packs['type'] . '"';
                            }
                            if ($packs['level'] == '0')
                            {
                                $checkavil .= '';
                            } else
                            {
                                $checkavil .= ' AND dumplevel = "' . $packs['level'] . '"';
                            }
                            if ($packs['class'] == '0')
                            {
                                $checkavil .= '';
                            } else
                            {
                                $checkavil .= ' AND dumpclass = "' . $packs['class'] . '"';
                            }
                            if ($packs['code'] == '0')
                            {
                                $checkavil .= '';
                            } else
                            {
                                $checkavil .= ' AND dumpcode = "' . $packs['code'] . '"';
                            }
                            if ($packs['country'] == '0')
                            {
                                $checkavil .= '';
                            } else
                            {
                                $checkavil .= ' AND dumpCou = "' . $packs['country'] . '"';
                            }
                            if ($packs['seller'] == '0')
                            {
                                $checkavil .= '';
                            } else
                            {
                                $checkavil .= ' AND seller = "' . $packs['seller'] . '"';
                            }
                            //CHECK AVIL//
                            $sql = "SELECT dumpId FROM " . $config['table_dumps'] . " WHERE (dumpUsed = '0' AND price > '0')" . $checkavil . "";
                            $result = mysql_query($sql, $data_sql);
                            if (!$result)
                            {
                                echo sql_error();
                            } else
                            {
                                $dumpcount = mysql_num_rows($result);
                            }
                            $body .= $twig->render('admin/packs.tpl', array(
                                'type' => 'pack',
                                'packs' => $packs,
                                'dumpcount' => $dumpcount));
                            unset($dumpcount);
                        }
                        $head .= $twig->render('admin/packs.tpl', array('type' => 'head'));
                        $footer = $twig->render('admin/packs.tpl', array('type' => 'footer'));
                        echo $head;
                        echo $body;
                        echo $footer;
                    }
}
db_close();

?>