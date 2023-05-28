<?php

set_time_limit(0);
session_start();
    require_once 'lib/Twig/Autoloader.php';
    Twig_Autoloader::register();
    $loader = new Twig_Loader_Filesystem('template');
    $twig = new Twig_Environment($loader, array('cache' => 'template/cache', 'auto_reload' => true));
include_once ("includes/global.php");
db_connection();
include_once ("checkers/" . $config['dumpchecker'] . "");
$act = clean($_GET["act"]);
if (!is_login())
{
    header("location: login.php");
} else
{
    if ($act == "get")
    {
        if ($config['packs'] == '1')
        {
            $id = clean($_GET["id"]);
            $sql = "SELECT credit from " . $config["table_users"] . " WHERE userId = '" . clean($_SESSION["userId"]) . "'";
            $result = mysql_query($sql, $data_sql);
            if ($result)
            {
                $count = mysql_num_rows($result);
                if ($count == 1)
                {
                    $credit = mysql_fetch_assoc($result);
                    $credit = $credit["credit"];
                    $sql = "SELECT * FROM " . $config['table_packs'] . " WHERE id = '" . $id . "'";
                    $result = mysql_query($sql, $data_sql);
                    if (!$result)
                    {
                        echo sql_error();
                    } else
                    {
                        $count = mysql_num_rows($result);
                        if ($count == 1)
                        {
                            $packs = mysql_fetch_assoc($result);
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
                                $count = mysql_num_rows($result);
                            }
                            if ($count < $packs['value'])
                            {
                                echo "<font color='#ff0000'>This pack is not available</font>";
                            } else
                                if ($credit < $packs[price])
                                {
                                    header("location: buy.php");
                                } else
                                {
                                    //ALL GOOD//
                                    //Random GENERATOR//
                                    $sql = "SELECT dumpId FROM " . $config['table_dumps'] . " WHERE (dumpUsed = '0' AND price > '0')" . $checkavil . " ORDER BY RAND() LIMIT " . $packs['value'] . "";
                                    $result = mysql_query($sql, $data_sql);
                                    if (!$result)
                                    {
                                        echo sql_error();
                                    } else
                                    {
                                        while ($dumpid = mysql_fetch_assoc($result))
                                        {
                                            $dumplist[] = $dumpid;
                                        }
                                    }
                                    //Random GENERATOR//
                                    $sql = "UPDATE " . $config["table_users"] . " SET credit = '" . ($credit - $packs[price]) . "' WHERE userId = '" . clean($_SESSION["userId"]) . "'";
                                    $result = mysql_query($sql, $data_sql);
                                    if ($result)
                                    {
                                        $dumpprice = $packs['price'] / $packs['value'];
                                        $rtime = date('Y-m-d H:i:s', time());
                                        $sql = "INSERT INTO " . $config["table_salepack"] . " (`date`, `used`, `name`, `categoryname`, `type`, `level`, `class`, `code`, `comment1`, `comment2`, `country`, `value`, `price`, `seller`, `sellerprc`, `refund`) 
                                                           VALUES ('" . $rtime . "', '" . clean($_SESSION["userId"]) . "', '" . $packs['name'] . "', '" . $packs['categoryId'] . "', '" . $packs['type'] . "', '" . $packs['level'] . "', '" . $packs['class'] . "', '" . $packs['code'] . "', '" . $packs['comment1'] . "', '" . $packs['comment2'] . "', '" .
                                            $packs['country'] . "', '" . $packs['value'] . "', '" . $packs['price'] . "', '" . $packs['seller'] . "', '" . $packs['sellerprc'] . "', '0')";
                                        $result = mysql_query($sql, $data_sql);
                                        $lastid = mysql_insert_id();
                                        if ($result)
                                        {
                                            $ctime = date('Y-m-d H:i:s', time() + ($config["dumpchecktime"] * 60));
                                            foreach ($dumplist as $packlist)
                                            {
                                                if ($packs['norefund'] == '1')
                                                {
                                                    $sql = "UPDATE " . $config["table_dumps"] . " SET dumpUsed = '-5', pack = '" . $lastid . "', status = '1', date = '" . $ctime . "', sellerprc = '" . $packs[sellerprc] . "', price = '" . $dumpprice . "' WHERE dumpId = '" . $packlist[dumpId] . "'";
                                                } else
                                                {
                                                    $sql = "UPDATE " . $config["table_dumps"] . " SET dumpUsed = '-5', pack = '" . $lastid . "', date = '" . $ctime . "', sellerprc = '" . $packs[sellerprc] . "', price = '" . $dumpprice . "' WHERE dumpId = '" . $packlist[dumpId] . "'";
                                                }
                                                $result = mysql_query($sql, $data_sql);
                                                if (!$result)
                                                {
                                                    echo sql_error();
                                                }
                                            }
                                            //DONE//
                                            header("location: packs.php?act=mypacks");
                                            //DONE//
                                        } else
                                        {
                                            echo sql_error();
                                        }
                                    } else
                                    {
                                        echo sql_error();
                                    }
                                    //ALL GOOD//
                                }
                        } else
                        {
                            $getresult[type] = 'danger';
                            $getresult[text] = 'This pack is not available';
                        }
                    }

                } else
                {
                    $getresult[type] = 'danger';
                    $getresult[text] = 'Your account has been deleted';
                }
            } else
            {
                echo sql_error();
            }
            echo $twig->render('elements/buy.tpl', array(
            'result' => $getresult
            ));
        } else
        {
            die("Packs module is OFF");
        }
    } else
        if ($act == "mypacks")
        {
            $sql = "SELECT *, DATE_FORMAT(date, '%d.%m.%Y') as sdate from " . $config["table_salepack"] . " LEFT JOIN " . $config['table_categorys'] . " ON " . $config["table_salepack"] . ".categoryname = " . $config['table_categorys'] . ".categoryId WHERE used = '" . clean($_SESSION["userId"]) . "' ORDER BY date DESC";
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
                echo $twig->render('mypacks.tpl', array(
            'listCard' => $listCard
            ));
            } else
            {
                echo sql_error();
            }
        } else
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
                    if ($pack[used] == $_SESSION["userId"])
                    {
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
                            echo $twig->render('openpack.tpl', array(
                             'listCard' => $listCard,
                             'pack' => $pack,
                             'id' => $id
                             ));
                        } else
                        {
                            echo sql_error();
                        }
                    }
                }
            } else
                if ($act == "checki")
                {
                    $cardid = clean($_GET["cardid"]);
                    $sql = "SELECT *, AES_DECRYPT(dumpContent, '$config[encode_key]') as dumpContent from " . $config["table_dumps"] . " WHERE dumpUsed = '-5'  AND " . $config["table_dumps"] . ".dumpId = '$cardid'";
                    $result = mysql_query($sql, $data_sql);
                    if ($result)
                    {
                        $card = mysql_fetch_assoc($result);
                        $packid = $card["pack"];
                        $sql = "SELECT * from " . $config["table_salepack"] . " WHERE id = '" . $packid . "'";
                        $result = mysql_query($sql, $data_sql);
                        if (!$result)
                        {
                            echo sql_error();
                        } else
                        {
                            $pack = mysql_fetch_assoc($result);
                        }
                        if ($pack["used"] == $_SESSION["userId"])
                        {
                            if ($card["status"] <= 0)
                            {
                                if (date('Y-m-d H:i:s') < $card[date])
                            {
                                $sql = "UPDATE " . $config["table_dumps"] . " SET status = '10' WHERE dumpId = '$cardid'";
                                $result = mysql_query($sql, $data_sql);
                                if (!$result)
                                {
                                    echo sql_error();
                                }
                                $respond = checkdump($card[dumpNum], $card[dumpMon], $card[dumpYea]);
                                if ($respond == '1')
                                {
                                    $sql = "UPDATE " . $config["table_dumps"] . " SET status = '1' WHERE dumpId = '$cardid'";
                                    $result = mysql_query($sql, $data_sql);
                                    if ($result)
                                    {
                                        $check[type] = 'success';
                                        $check[text] = 'Live';
                                    } else
                                    {
                                        echo sql_error();
                                    }
                                } else
                                    if ($respond == '2')
                                    {
                                        $sql = "SELECT credit from " . $config["table_users"] . " WHERE userId = '" . clean($_SESSION["userId"]) . "'";
                                        $result = mysql_query($sql, $data_sql);
                                        if ($result)
                                        {
                                            $credit = mysql_fetch_assoc($result);
                                            $credit = $credit["credit"];
                                        }
                                        $sql = "UPDATE " . $config["table_users"] . " SET credit = '" . ($credit + $card[price]) . "' WHERE userId = '" . clean($_SESSION["userId"]) . "'";
                                        $result = mysql_query($sql, $data_sql);
                                        if ($result)
                                        {
                                            $sql = "UPDATE " . $config["table_dumps"] . " SET status = '2' WHERE dumpId = '$cardid'";
                                            $result = mysql_query($sql, $data_sql);
                                            if ($result)
                                            {
                                                $check[type] = 'danger';
                                                $check[text] = 'Dead';
                                            } else
                                            {
                                                echo sql_error();
                                            }
                                        } else
                                        {
                                            echo sql_error();
                                        }
                                    } else
                                        if ($respond == '3')
                                        {
                                            $sql = "UPDATE " . $config["table_dumps"] . " SET status = '3' WHERE dumpId = '$cardid'";
                                            $result = mysql_query($sql, $data_sql);
                                            if ($result)
                                            {
                                                $check[type] = 'warning';
                                                $check[text] = 'Error';
                                            } else
                                            {
                                                echo sql_error();
                                            }
                                        } else
                                            if ($respond == '4')
                                            {
                                                $sql = "UPDATE " . $config["table_dumps"] . " SET status = '4' WHERE dumpId = '$cardid'";
                                                $result = mysql_query($sql, $data_sql);
                                                if ($result)
                                                {
                                                    $check[type] = 'info';
                                                    $check[text] = 'Unknown';
                                                } else
                                                {
                                                    echo sql_error();
                                                }
                                            } else
                                            {
                                                $sql = "UPDATE " . $config["table_dumps"] . " SET status = '0' WHERE dumpId = '$cardid'";
                                                $result = mysql_query($sql, $data_sql);
                                                if ($result)
                                                {
                                                    $check[type] = 'warning';
                                                    $check[text] = 'Error';
                                                } else
                                                {
                                                    echo sql_error();
                                                }
                                            }
                            } else
                            {
                                $sql = "UPDATE " . $config["table_dumps"] . " SET status = '5' WHERE dumpId = '$cardid'";
                                $result = mysql_query($sql, $data_sql);
                                if ($result)
                                {
                                    $check[type] = 'info';
                                    $check[text] = 'Time off';
                                } else
                                {
                                    echo sql_error();
                                }
                            }
                            }
                            echo $twig->render('elements/check.tpl', array('check' => $check));
                        } //NO YOUR PACK
                    }
                } else
                {
                    if ($config['packs'] == '1')
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
                                $count = mysql_num_rows($result);
                            }
                            if ($count >= $packs['value'])
                            {
                                if ($packs['country'] == '0')
                                {
                                    $packs['country'] = 'Mix Country';
                                }
                                if ($packs['type'] == '0')
                                {
                                    $packs['type'] = 'All';
                                }
                                if ($packs['code'] == '0')
                                {
                                    $packs['code'] = 'All';
                                }
                                if ($packs['class'] == '0')
                                {
                                    $packs['class'] = 'All';
                                }
                                if ($packs['level'] == '0')
                                {
                                    $packs['level'] = 'All';
                                }
                                $listpack[] = $packs;
                            }
                        }
                    } else
                    {
                        die("Packs module is OFF");
                    }
                echo $twig->render('packs.tpl', array('listpack' => $listpack));
                }
}
db_close();

?>