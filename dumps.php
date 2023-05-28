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
        $cardid = clean($_GET["cardid"]);
        $sql = "SELECT credit from " . $config["table_users"] . " WHERE userId = '" . clean($_SESSION["userId"]) . "'";
        $result = mysql_query($sql, $data_sql);
        if ($result)
        {
            $count = mysql_num_rows($result);
            if ($count == 1)
            {
                $credit = mysql_fetch_assoc($result);
                $credit = $credit["credit"];
                $sql = "SELECT *, AES_DECRYPT(dumpContent, '$config[encode_key]') as dumpContent from " . $config["table_dumps"] . " LEFT JOIN " . $config["table_categorys_dump"] . " ON " . $config["table_dumps"] . ".categoryId = " . $config["table_categorys_dump"] . ".categoryId WHERE (" . $config["table_dumps"] . ".dumpUsed = '0' OR " . $config["table_dumps"] .
                    ".dumpUsed = '" . clean($_SESSION["userId"]) . "') AND " . $config["table_dumps"] . ".dumpId = '$cardid'";
                $result = mysql_query($sql, $data_sql);
                if ($result)
                {
                    $count = mysql_num_rows($result);
                    if ($count == 1)
                    {
                        $card = mysql_fetch_assoc($result);
                        if ($card["dumpUsed"] == $_SESSION["userId"])
                        {
                            $getresult[type] = 'info';
                            $getresult[text] = 'You already get this dump before, please go to "My dumps" to review it';
                        } else
                            if ($credit < $card[price])
                            {
                                $getresult[type] = 'danger';
                                $getresult[text] = 'You must buy more credit to get this dump';
                            } else
                            {
                                if ($config['Dump_Buy&Check'] == '0')
                                {
                                    $sql = "UPDATE " . $config["table_users"] . " SET credit = '" . ($credit - $card[price]) . "' WHERE userId = '" . clean($_SESSION["userId"]) . "'";
                                    $result = mysql_query($sql, $data_sql);
                                    if ($result)
                                    {
                                        $ctime = date('Y-m-d H:i:s', time() + ($config["dumpchecktime"] * 60));
                                        $sql = "UPDATE " . $config["table_dumps"] . " SET dumpUsed = '" . clean($_SESSION["userId"]) . "', date = '$ctime' WHERE dumpId = '$cardid'";
                                        $result = mysql_query($sql, $data_sql);
                                        if ($result)
                                        {
                                            $getresult[type] = 'result';
                                            $getresult[text] = $card["dumpContent"];
                                        } else
                                        {
                                            echo sql_error();
                                        }
                                    } else
                                    {
                                        echo sql_error();
                                    }
                                }
                                if ($config['Dump Buy&Check'] == '1')
                                {
                                    if ($card[status] == '0')
                                    {
                                        $respond = checkdump($card[dumpNum], $card[dumpMon], $card[dumpYea]);
                                    } else
                                    {
                                        $respond = '1';
                                    }
                                    if ($respond == '1')
                                    {
                                        $sql = "UPDATE " . $config["table_users"] . " SET credit = '" . ($credit - $card[price]) . "' WHERE userId = '" . clean($_SESSION["userId"]) . "'";
                                        $result = mysql_query($sql, $data_sql);
                                        if ($result)
                                        {
                                            $ctime = date('Y-m-d H:i:s', time());
                                            $sql = "UPDATE " . $config["table_dumps"] . " SET dumpUsed = '" . clean($_SESSION["userId"]) . "', date = '$ctime', status = '1' WHERE dumpId = '$cardid'";
                                            if ($result)
                                            {
                                                $getresult[type] = 'result';
                                                $getresult[text] = $card["dumpContent"];
                                            } else
                                            {
                                                echo sql_error();
                                            }
                                        } else
                                        {
                                            echo sql_error();
                                        }
                                    } else
                                        if ($respond == '2')
                                        {
                                            $ctime = date('Y-m-d H:i:s', time());
                                            $sql = "UPDATE " . $config["table_dumps"] . " SET dumpUsed = '-1', status = '2', date = '$ctime' WHERE dumpId = '$cardid'";
                                            $result = mysql_query($sql, $data_sql);

                                            if ($result)
                                            {
                                                $getresult[type] = 'danger';
                                                $getresult[text] = 'Dead';
                                            } else
                                            {
                                                echo sql_error();
                                            }
                                        } else
                                            if ($respond == '3')
                                            {
                                                $ctime = date('Y-m-d H:i:s', time());
                                                $sql = "UPDATE " . $config["table_dumps"] . " SET dumpUsed = '-2', status = '3', date = '$ctime' WHERE dumpId = '$cardid'";
                                                $result = mysql_query($sql, $data_sql);
                                                if ($result)
                                                {
                                                    $getresult[type] = 'warning';
                                                    $getresult[text] = 'Error';
                                                } else
                                                {
                                                    echo sql_error();
                                                }
                                            } else
                                                if ($respond == '4')
                                                {
                                                    $ctime = date('Y-m-d H:i:s', time());
                                                    $sql = "UPDATE " . $config["table_dumps"] . " SET dumpUsed = '-2', status = '4', date = '$ctime' WHERE dumpId = '$cardid'";
                                                    $result = mysql_query($sql, $data_sql);
                                                    if ($result)
                                                    {
                                                        $getresult[type] = 'warning';
                                                        $getresult[text] = 'Error';
                                                    } else
                                                    {
                                                        echo sql_error();
                                                    }
                                                } else
                                                    if ($respond == '-1')
                                                    {
                                                        $getresult[type] = 'warning';
                                                        $getresult[text] = 'Server check has error';
                                                    }

                                }
                            }
                    } else
                    {
                        $getresult[type] = 'danger';
                        $getresult[text] = 'This dump is not available';
                    }
                } else
                {
                    echo sql_error();
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
        echo $twig->render('elements/buy.tpl', array('result' => $getresult));
    } else
        if ($act == "mycard")
        {
            $sql = "SELECT *, AES_DECRYPT(dumpContent, '$config[encode_key]') as dumpContent, DATE_FORMAT(date, '%d.%m.%Y') as sdate from " . $config["table_dumps"] . " WHERE dumpUsed = '" . clean($_SESSION["userId"]) . "' ORDER BY date DESC";
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
            echo $twig->render('mydump.tpl', array('listCard' => $listCard));
        } else
            if ($act == "checki")
            {
                $cardid = clean($_GET["cardid"]);
                $sql = "SELECT *, AES_DECRYPT(dumpContent, '$config[encode_key]') as dumpContent from " . $config["table_dumps"] . " WHERE dumpUsed = " . clean($_SESSION["userId"]) . "  AND " . $config["table_dumps"] . ".dumpId = '$cardid'";
                $result = mysql_query($sql, $data_sql);
                if ($result)
                {
                    $card = mysql_fetch_assoc($result);
                    if ($card["status"] <= 0)
                    {
                        if ($card["dumpUsed"] == $_SESSION["userId"])
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
                    }
                }
                echo $twig->render('elements/check.tpl', array('check' => $check));
            } else
            {
                if (isset($_GET["cat"]) && $_GET["cat"] > 0)
                {
                    $categoryId = clean($_GET["cat"]);
                } else
                {
                    $categoryId = 0;
                }
                if (isset($_GET["bin"]) && strlen($_GET["bin"]) > 0)
                {
                    $binarr = strpos($_GET[bin], ',');
                    if ($binarr === false)
                    {
                        $binSearch = " AND dumpNum like '" . substr(clean($_GET[bin]), 0, 6) . "%'";
                    } else
                    {
                        $massbin = explode(',', $_GET[bin]);
                        foreach ($massbin as $i => $imassbin)
                        {
                            if ($i == '0')
                            {
                                $findbin = " AND (dumpNum like '" . substr(clean($imassbin), 0, 6) . "%'";
                            } else
                            {
                                $findbin .= " OR dumpNum like '" . substr(clean($imassbin), 0, 6) . "%'";
                            }
                        }
                        $findbin .= " )";
                        $binSearch = $findbin;
                    }
                } else
                {
                    $binSearch = "";
                }
                if (isset($_GET["last4"]) && strlen($_GET["last4"]) > 0)
                {
                    $binSearch .= " AND dumpNum like '%" . substr(clean($_GET[last4]), 0, 4) . "'";
                } else
                {
                    $binSearch .= "";
                }
                if (isset($_GET["country"]) && strlen($_GET["country"]) > 0)
                {
                    $inscountry = clean($_GET["country"]);
                    $binSearch .= " AND dumpCou like '%" . clean($_GET[country]) . "%'";
                } else
                {
                    $inscountry = '0';
                }
                if (isset($_GET["type"]) && strlen($_GET["type"]) > 0)
                {
                    $instype = clean($_GET["type"]);
                    $binSearch .= " AND dumptype like '%" . clean($_GET[type]) . "%'";
                } else
                {
                    $instype = '0';
                }
                if (isset($_GET["level"]) && strlen($_GET["level"]) > 0)
                {
                    $inslevel = clean($_GET["level"]);
                    $binSearch .= " AND dumplevel like '%" . clean($_GET[level]) . "%'";
                } else
                {
                    $inslevel = '0';
                }
                if (isset($_GET["class"]) && strlen($_GET["class"]) > 0)
                {
                    $insclass = clean($_GET["class"]);
                    $binSearch .= " AND dumpclass like '%" . clean($_GET['class']) . "%'";
                } else
                {
                    $insclass = '0';
                }
                if (isset($_GET["bank"]) && strlen($_GET["bank"]) > 0)
                {
                    $insbank = clean($_GET["bank"]);
                    $binSearch .= " AND dumpbank like '%" . clean($_GET['bank']) . "%'";
                } else
                {
                    $insbank = '0';
                }
                if (isset($_GET["code"]) && strlen($_GET["code"]) > 0)
                {
                    $inscode = clean($_GET["code"]);
                    $binSearch .= " AND dumpcode like '%" . clean($_GET[code]) . "%'";
                } else
                {
                    $inscode = '0';
                }
                if ($categoryId == 0)
                {
                    $sql = "SELECT dumpId FROM " . $config['table_dumps'] . " WHERE (dumpUsed = '0' AND price > '0') $binSearch ORDER BY dumpId DESC";
                } else
                {
                    $sql = "SELECT dumpId FROM " . $config['table_dumps'] . " WHERE (dumpUsed = '0' AND price > '0' AND categoryId = '$categoryId') $binSearch ORDER BY dumpId DESC";
                }
                $result = mysql_query($sql, $data_sql);
                if (!$result)
                {
                    echo sql_error();
                } else
                {
                    $totalCards = mysql_num_rows($result);
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
                //TEST COUNTRY
                if ($categoryId == '0')
                {
                    $sql = "SELECT dumpCou, COUNT(dumpCou) AS count FROM " . $config['table_dumps'] . " WHERE (dumpUsed = '0' AND price > '0') GROUP BY dumpCou ORDER BY count DESC";
                } else
                {
                    $sql = "SELECT dumpCou, COUNT(dumpCou) AS count FROM " . $config['table_dumps'] . " WHERE (dumpUsed = '0' AND price > '0' AND categoryid = '$categoryId') GROUP BY dumpCou ORDER BY count DESC";
                }
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
                //TEST COUNTRY
                //TYPE
                if ($categoryId == '0')
                {
                    $sql = "SELECT dumptype, COUNT(dumptype) AS count FROM " . $config['table_dumps'] . " WHERE (dumpUsed = '0' AND price > '0') GROUP BY dumptype ORDER BY count DESC";
                } else
                {
                    $sql = "SELECT dumptype, COUNT(dumptype) AS count FROM " . $config['table_dumps'] . " WHERE (dumpUsed = '0' AND price > '0' AND categoryid = '$categoryId') GROUP BY dumptype ORDER BY count DESC";
                }
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
                //TYPE
                //CODE
                if ($categoryId == '0')
                {
                    $sql = "SELECT dumpcode, COUNT(dumpcode) AS count FROM " . $config['table_dumps'] . " WHERE (dumpUsed = '0' AND price > '0') GROUP BY dumpcode ORDER BY count DESC";
                } else
                {
                    $sql = "SELECT dumpcode, COUNT(dumpcode) AS count FROM " . $config['table_dumps'] . " WHERE (dumpUsed = '0' AND price > '0' AND categoryid = '$categoryId') GROUP BY dumpcode ORDER BY count DESC";
                }
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
                //CODE
                //LEVEL
                if ($categoryId == '0')
                {
                    $sql = "SELECT dumplevel, COUNT(dumplevel) AS count FROM " . $config['table_dumps'] . " WHERE (dumpUsed = '0' AND price > '0') GROUP BY dumplevel ORDER BY count DESC";
                } else
                {
                    $sql = "SELECT dumplevel, COUNT(dumplevel) AS count FROM " . $config['table_dumps'] . " WHERE (dumpUsed = '0' AND price > '0' AND categoryid = '$categoryId') GROUP BY dumplevel ORDER BY count DESC";
                }
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
                //LEVEL
                //CLASS
                if ($categoryId == '0')
                {
                    $sql = "SELECT dumpclass, COUNT(dumpclass) AS count FROM " . $config['table_dumps'] . " WHERE (dumpUsed = '0' AND price > '0') GROUP BY dumpclass ORDER BY count DESC";
                } else
                {
                    $sql = "SELECT dumpclass, COUNT(dumpclass) AS count FROM " . $config['table_dumps'] . " WHERE (dumpUsed = '0' AND price > '0' AND categoryid = '$categoryId') GROUP BY dumpclass ORDER BY count DESC";
                }
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
                //CLASS
                //BANK
                if ($categoryId == '0')
                {
                    $sql = "SELECT dumpbank, COUNT(dumpbank) AS count FROM " . $config['table_dumps'] . " WHERE (dumpUsed = '0' AND price > '0') GROUP BY dumpbank ORDER BY count DESC";
                } else
                {
                    $sql = "SELECT dumpbank, COUNT(dumpbank) AS count FROM " . $config['table_dumps'] . " WHERE (dumpUsed = '0' AND price > '0' AND categoryid = '$categoryId') GROUP BY dumpbank ORDER BY count DESC";
                }
                $result = mysql_query($sql, $data_sql);

                if (!$result)
                {
                    echo sql_error();
                } else
                {
                    while ($lisbank = mysql_fetch_assoc($result))
                    {
                        $listbank[] = $lisbank;
                    }
                }
                //BANK
                if (isset($_GET["page"]) && $_GET["page"] > 0)
                {
                    $currentPage = clean($_GET["page"]);
                } else
                {
                    $currentPage = 1;
                }
                if (isset($_GET["perpage"]) && in_array($_GET["perpage"], array(
                    10,
                    20,
                    50,
                    100)))
                {
                    $cardPerPage = clean($_GET["perpage"]);
                } else
                {
                    $cardPerPage = 10;
                }
                $currentCard = ($currentPage - 1) * $cardPerPage;
                if ($categoryId == 0)
                {
                    $sql = "SELECT *, AES_DECRYPT(dumpContent, '$config[encode_key]') as dumpContent from " . $config["table_dumps"] . " LEFT JOIN " . $config["table_categorys_dump"] . " ON " . $config["table_dumps"] . ".categoryId = " . $config["table_categorys_dump"] . ".categoryId WHERE (" . $config["table_dumps"] . ".dumpUsed = '0' AND " . $config["table_dumps"] .
                        ".price > '0') $binSearch ORDER BY " . $config["table_dumps"] . ".dumpId DESC LIMIT $currentCard,$cardPerPage";
                } else
                {
                    $sql = "SELECT *, AES_DECRYPT(dumpContent, '$config[encode_key]') as dumpContent from " . $config["table_dumps"] . " LEFT JOIN " . $config["table_categorys_dump"] . " ON " . $config["table_dumps"] . ".categoryId = " . $config["table_categorys_dump"] . ".categoryId WHERE (" . $config["table_dumps"] . ".dumpUsed = '0' AND " . $config["table_dumps"] .
                        ".price > '0' AND " . $config["table_dumps"] . ".categoryId = '$categoryId') $binSearch ORDER BY " . $config["table_dumps"] . ".dumpId DESC LIMIT $currentCard,$cardPerPage";
                }
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
                        $found = '1';
                    } else
                    {
                        $found = '0';
                    }
                    //ECHO
                    echo $twig->render('dumps.tpl', array(
                        'categoryId' => $categoryId,
                        'listCategory' => $listCategory,
                        'get' => $_GET,
                        'instype' => $instype,
                        'listtype' => $listtype,
                        'inscode' => $inscode,
                        'listcode' => $listcode,
                        'inslevel' => $inslevel,
                        'listlevel' => $listlevel,
                        'insclass' => $insclass,
                        'listclass' => $listclass,
                        'inscountry' => $inscountry,
                        'listCou' => $listCou,
                        'insbank' => $insbank,
                        'listbank' => $listbank,
                        'cardPerPage' => $cardPerPage,
                        'totalCards' => $totalCards,
                        'found' => $found,
                        'session' => $_SESSION,
                        'buyandcheck' => $config['Dump_Buy&Check'],
                        'listCard' => $listCard,
                        'currentPage' => $currentPage,
                        'pages' => ceil($totalCards / $cardPerPage)));
                } else
                {
                    echo sql_error();
                }
            }
}
db_close();

?>