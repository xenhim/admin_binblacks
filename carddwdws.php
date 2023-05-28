<?php

set_time_limit(0);
session_start();
require_once 'lib/Twig/Autoloader.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('template');
$twig = new Twig_Environment($loader, array('cache' => 'template/cache', 'auto_reload' => true));
include_once ("includes/global.php");
db_connection();
include_once ("checkers/" . $config['CCchecker'] . "");
$act = clean($_GET["act"]);
if (!is_login())
{
    header("location: login.php");
} else
	{
function getStr($string,$start,$end){
	$str = explode($start,$string);
	$str = explode($end,$str[1]);
	return $str[0];
}

function info($ccnum){
	$bin = substr($ccnum,0,6);
		$file = file_get_contents('dbbin1/base.csv');
		$info = getStr($file,$bin,"\n");
		$info = explode(";",$info);
	if($info[3] == "CREDIT"){
		$info[3] = str_replace('CREDIT','<span class="text-primary">CREDIT</span>',$info[3]);
	}
	if($info[4] == "PLATINUM"){
		$info[4] = str_replace('PLATINUM','<span class="text-danger">PLATINUM</span>',$info[4]);
	}
	elseif($info[4] == "GOLD/PREM"){
		$info[4] = str_replace('GOLD/PREM','<span class="text-warning">GOLD/PREM</span>',$info[4]);
	}
	elseif($info[4] == "BUSINESS"){
		$info[4] = str_replace('BUSINESS','<span class="text-success">BUSINESS</span>',$info[4]);
	}
	$country = "$info[5]";
	//echo $country."\r";
	$data = "<tr align=center><td><span class='text-info'>$ccnum|".$info[5]."</span></td><td><a class='banklink' data-link='".$info[2]."'>".$info[2]."</a></td><td>".$info[3]." ".$info[4]."</td><td>".$info[5]."</td><td>".$info[10]."</td></tr>";
	if(strlen($info[1]) < 2){
		$data = "<tr align=center><td><span class='text-info'>$ccnum</span></td><td colspan=4>Unknown</td></tr>";
	}
	return $data;
}
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
                $sql = "SELECT *, AES_DECRYPT(cardContent, '$config[encode_key]') as cardContent from " . $config["table_cards"] . " LEFT JOIN " . $config["table_categorys"] . " ON " . $config["table_cards"] . ".categoryId = " . $config["table_categorys"] . ".categoryId WHERE (" . $config["table_cards"] . ".cardUsed = '0' OR " . $config["table_cards"] .
                    ".cardUsed = '" . clean($_SESSION["userId"]) . "') AND " . $config["table_cards"] . ".cardId = '$cardid'";
                $result = mysql_query($sql, $data_sql);
                if ($result)
                {
                    $count = mysql_num_rows($result);
                    if ($count == 1)
                    {
                        $card = mysql_fetch_assoc($result);
                        if ($card["cardUsed"] == $_SESSION["userId"])
                        {
                            $getresult[type] = 'info';
                            $getresult[text] = 'You already get this card before, please go to "My card" to review it';
                        } else
                            if ($credit < $card[price])
                            {
                                $getresult[type] = 'danger';
                                $getresult[text] = 'You must buy more credit to get this card';
                            } else
                            {
                                if ($config['Buy&Check'] == '0')
                                {
                                    $sql = "UPDATE " . $config["table_users"] . " SET credit = '" . ($credit - $card[price]) . "' WHERE userId = '" . clean($_SESSION["userId"]) . "'";
                                    $result = mysql_query($sql, $data_sql);
                                    if ($result)
                                    {
                                        $ctime = date('Y-m-d H:i:s', time() + ($config["checktime"] * 60));
                                        $sql = "UPDATE " . $config["table_cards"] . " SET cardUsed = '" . clean($_SESSION["userId"]) . "', date = '$ctime' WHERE cardId = '$cardid'";
                                        $result = mysql_query($sql, $data_sql);
                                        if ($result)
                                        {
                                            $getresult[type] = 'result';
                                            $getresult[text] = $card["cardContent"];
                                        } else
                                        {
                                            echo sql_error();
                                        }
                                    } else
                                    {
                                        echo sql_error();
                                    }
                                }
                                if ($config['Buy&Check'] == '1')
                                {
                                    if ($card[status] == '0')
                                    {
                                        $respond = check($card[cardNum], $card[cardMon], $card[cardYea], $card[cardCvv]);
                                    } else
                                    {
                                        $respond = '1';
                                    }
                                    if ($respond == 1)
                                    {
                                        $sql = "UPDATE " . $config["table_users"] . " SET credit = '" . ($credit - $card[price]) . "' WHERE userId = '" . clean($_SESSION["userId"]) . "'";
                                        $result = mysql_query($sql, $data_sql);
                                        if ($result)
                                        {
                                            $ctime = date('Y-m-d H:i:s', time());
                                            $sql = "UPDATE " . $config["table_cards"] . " SET cardUsed = '" . clean($_SESSION["userId"]) . "', date = '$ctime', status = '1' WHERE cardId = '$cardid'";
                                            $result = mysql_query($sql, $data_sql);
                                            if ($result)
                                            {
                                                $getresult[type] = 'result';
                                                $getresult[text] = $card["cardContent"];
                                            } else
                                            {
                                                echo sql_error();
                                            }
                                        } else
                                        {
                                            echo sql_error();
                                        }
                                    } else
                                        if ($respond == 2)
                                        {
                                            $ctime = date('Y-m-d H:i:s', time());
                                            $sql = "UPDATE " . $config["table_cards"] . " SET cardUsed = '-1', status = '2', date = '$ctime' WHERE cardId = '$cardid'";
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
                                            if ($respond == 3)
                                            {
                                                $ctime = date('Y-m-d H:i:s', time());
                                                $sql = "UPDATE " . $config["table_cards"] . " SET cardUsed = '-2', status = '3', date = '$ctime'  WHERE cardId = '$cardid'";
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
                                                if ($respond == 4)
                                                {
                                                    $ctime = date('Y-m-d H:i:s', time());
                                                    $sql = "UPDATE " . $config["table_cards"] . " SET cardUsed = '-2', status = '4', date = '$ctime' WHERE cardId = '$cardid'";
                                                    $result = mysql_query($sql, $data_sql);
                                                    if ($result)
                                                    {
                                                        $getresult[type] = 'info';
                                                        $getresult[text] = 'Unknown';
                                                    } else
                                                    {
                                                        echo sql_error();
                                                    }
                                                } else
                                                    if ($respond == '-1')
                                                    {
                                                        $getresult[type] = 'warning';
                                                        $getresult[text] = 'Server check has error';
                                                    } else
                                                    {
                                                        $getresult[type] = 'warning';
                                                        $getresult[text] = 'Error';
                                                    }

                                }
                            }
                    } else
                    {
                        $getresult[type] = 'danger';
                        $getresult[text] = 'This card is not available';
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
            $sql = "SELECT *, AES_DECRYPT(cardContent, '$config[encode_key]') as cardContent, DATE_FORMAT(date, '%d.%m.%Y') as sdate from " . $config["table_cards"] . " WHERE cardUsed = '" . clean($_SESSION["userId"]) . "' ORDER BY date DESC";
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
            echo $twig->render('mycard.tpl', array('listCard' => $listCard));
        }
    ///START CHECK FUNC
        else
            if ($act == "checki")
            {
                $cardid = clean($_GET["cardid"]);
                $sql = "SELECT *, AES_DECRYPT(cardContent, '$config[encode_key]') as cardContent from " . $config["table_cards"] . " WHERE cardUsed = " . clean($_SESSION["userId"]) . "  AND " . $config["table_cards"] . ".cardId = '$cardid'";
                $result = mysql_query($sql, $data_sql);
                if ($result)
                {
                    $card = mysql_fetch_assoc($result);
                    if ($card["status"] <= 0)
                    {
                        if ($card["cardUsed"] == $_SESSION["userId"])
                        {
                            if (date('Y-m-d H:i:s') < $card[date])
                            {
                                $sql = "UPDATE " . $config["table_cards"] . " SET status = '10' WHERE cardId = '$cardid'";
                                $result = mysql_query($sql, $data_sql);
                                if (!$result)
                                {
                                    echo sql_error();
                                }
                                $respond = check($card[cardNum], $card[cardMon], $card[cardYea], $card[cardCvv]);
                                if ($respond == 1)
                                {
                                    $sql = "UPDATE " . $config["table_cards"] . " SET status = '1' WHERE cardId = '$cardid'";
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
                                    if ($respond == 2)
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
                                            $sql = "UPDATE " . $config["table_cards"] . " SET status = '2' WHERE cardId = '$cardid'";
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
                                        if ($respond == 3)
                                        {
                                            $sql = "UPDATE " . $config["table_cards"] . " SET status = '0' WHERE cardId = '$cardid'";
                                            $result = mysql_query($sql, $data_sql);
                                            if ($result)
                                            {
                                                $check[type] = 'warning';
                                                $check[text] = 'Error - F5 Try';
                                            } else
                                            {
                                                echo sql_error();
                                            }
                                        } else
                                            if ($respond == 4)
                                            {
                                                $sql = "UPDATE " . $config["table_cards"] . " SET status = '4' WHERE cardId = '$cardid'";
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
                                                $sql = "UPDATE " . $config["table_cards"] . " SET status = '0' WHERE cardId = '$cardid'";
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
                                $sql = "UPDATE " . $config["table_cards"] . " SET status = '5' WHERE cardId = '$cardid'";
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
                    echo $binarr;
                    if ($binarr === false)
                    {
                        $binSearch = " AND cardNum like '" . substr(clean($_GET[bin]), 0, 6) . "%'";
                    } else
                    {
                        $massbin = explode(',', $_GET[bin]);
                        foreach ($massbin as $i => $imassbin)
                        {
                            if ($i == '0')
                            {
                                $findbin = " AND (cardNum like '" . substr(clean($imassbin), 0, 6) . "%'";
                            } else
                            {
                                $findbin .= " OR cardNum like '" . substr(clean($imassbin), 0, 6) . "%'";
                            }
                        }
                        $findbin .= " )";
                        $binSearch = $findbin;
                    }
                } else
                {

                    $binSearch = "";
                }
                if (isset($_GET["zip"]) && strlen($_GET["zip"]) > 0)
                {
                    $binSearch .= " AND CardZip like '" . substr(clean($_GET[zip]), 0, 7) . "%'";
                } else
                {
                    $binSearch .= "";
                }
                if (isset($_GET["country"]) && strlen($_GET["country"]) > 0)
                {
                    $inscountry = clean($_GET["country"]);
                    $binSearch .= " AND cardCou like '" . clean($_GET[country]) . "%'";
                } else
                {
                    $inscountry = '0';
                }
                if (isset($_GET["state"]) && strlen($_GET["state"]) > 0)
                {
                    $insstate = clean($_GET["state"]);
                    $binSearch .= " AND CardState like '" . clean($_GET[state]) . "%'";
                } else
                {
                    $insstate = '0';
                }
                if (isset($_GET["city"]) && strlen($_GET["city"]) > 0)
                {
                    $inscity = clean($_GET["city"]);
                    $binSearch .= " AND CardCity like '" . clean($_GET[city]) . "%'";
                } else
                {
                    $inscity = '0';
                }
                if (isset($_GET["type"]) && strlen($_GET["type"]) > 0)
                {
                    $instype0 = clean($_GET["type"]);
                    $instype = substr($instype0, 0, 1);
                    $binSearch .= " AND cardNum like '" . clean($instype) . "%'";
                } else
                {
                    $instype = '0';
                }
                if ($categoryId == 0)
                {
                    $sql = "SELECT cardId FROM " . $config['table_cards'] . " WHERE cardUsed = '0' AND price > '0' $binSearch ORDER BY cardId DESC";
                } else
                {
                    $sql = "SELECT cardId FROM " . $config['table_cards'] . " WHERE cardUsed = '0' AND price > '0' AND categoryId = '$categoryId' $binSearch ORDER BY cardId DESC";
                }
                $result = mysql_query($sql, $data_sql);
                if (!$result)
                {
                    echo sql_error();
                } else
                {
                    $totalCards = mysql_num_rows($result);
                }
                $sql = "SELECT categoryId,categoryName FROM " . $config['table_categorys'] . " ORDER BY categoryId";
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
                if ($categoryId == '0')
                {
                    $sql = "SELECT cardCou, COUNT(cardCou) AS count FROM " . $config['table_cards'] . " WHERE (cardUsed = '0' AND price > '0') GROUP BY cardCou ORDER BY count DESC";
                } else
                {
                    $sql = "SELECT cardCou, COUNT(cardCou) AS count FROM " . $config['table_cards'] . " WHERE cardUsed = '0' AND price > '0' AND categoryid = '$categoryId' GROUP BY cardCou ORDER BY count DESC";
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
                if ($categoryId == '0' and $inscountry == '0')
                {
                    $sql = "SELECT CardState, COUNT(CardState) AS count FROM " . $config['table_cards'] . " WHERE (cardUsed = '0' AND price > '0') GROUP BY CardState ORDER BY count DESC";
                } else
                    if ($categoryId == '0' and $inscountry != '0')
                    {
                        $sql = "SELECT CardState, COUNT(CardState) AS count FROM " . $config['table_cards'] . " WHERE (cardUsed = '0' AND price > '0') AND cardCou = '$inscountry' GROUP BY CardState ORDER BY count DESC";
                    } else
                        if ($categoryId != '0' and $inscountry != '0')
                        {
                            $sql = "SELECT CardState, COUNT(CardState) AS count FROM " . $config['table_cards'] . " WHERE (cardUsed = '0' AND price > '0') AND categoryid = '$categoryId' AND cardCou = '$inscountry' GROUP BY CardState ORDER BY count DESC";
                        } else
                        {
                            $sql = "SELECT CardState, COUNT(CardState) AS count FROM " . $config['table_cards'] . " WHERE cardUsed = '0' AND price > '0' AND categoryid = '$categoryId' GROUP BY CardState ORDER BY count DESC";
                        }
                        $result = mysql_query($sql, $data_sql);

                if (!$result)
                {
                    echo sql_error();
                } else
                {
                    while ($state = mysql_fetch_assoc($result))
                    {
                        $liststate[] = $state;
                    }
                }
                if ($categoryId == '0' and $inscountry == '0' and $insstate == '0')
                {
                    $sql = "SELECT CardCity, COUNT(CardCity) AS count FROM " . $config['table_cards'] . " WHERE (cardUsed = '0' AND price > '0') GROUP BY CardCity ORDER BY count DESC";
                } else
                    if ($categoryId == '0' and $inscountry != '0' and $insstate == '0')
                    {
                        $sql = "SELECT CardCity, COUNT(CardCity) AS count FROM " . $config['table_cards'] . " WHERE (cardUsed = '0' AND price > '0') AND cardCou = '$inscountry' GROUP BY CardCity ORDER BY count DESC";
                    } else
                        if ($categoryId == '0' and $inscountry != '0' and $insstate != '0')
                        {
                            $sql = "SELECT CardCity, COUNT(CardCity) AS count FROM " . $config['table_cards'] . " WHERE (cardUsed = '0' AND price > '0') AND cardCou = '$inscountry' AND CardState = '$insstate' GROUP BY CardCity ORDER BY count DESC";
                        } else
                            if ($categoryId == '0' and $inscountry == '0' and $insstate != '0')
                            {
                                $sql = "SELECT CardCity, COUNT(CardCity) AS count FROM " . $config['table_cards'] . " WHERE (cardUsed = '0' AND price > '0') AND CardState = '$insstate' GROUP BY CardCity ORDER BY count DESC";
                            } else
                                if ($categoryId != '0' and $inscountry != '0' and $insstate == '0')
                                {
                                    $sql = "SELECT CardCity, COUNT(CardCity) AS count FROM " . $config['table_cards'] . " WHERE (cardUsed = '0' AND price > '0') AND categoryid = '$categoryId' AND cardCou = '$inscountry' GROUP BY CardCity ORDER BY count DESC";
                                } else
                                    if ($categoryId != '0' and $inscountry != '0' and $insstate != '0')
                                    {
                                        $sql = "SELECT CardCity, COUNT(CardCity) AS count FROM " . $config['table_cards'] . " WHERE (cardUsed = '0' AND price > '0') AND categoryid = '$categoryId' AND cardCou = '$inscountry' AND CardState = '$insstate' GROUP BY CardCity ORDER BY count DESC";
                                    } else
                                        if ($categoryId != '0' and $inscountry == '0' and $insstate != '0')
                                        {
                                            $sql = "SELECT CardCity, COUNT(CardCity) AS count FROM " . $config['table_cards'] . " WHERE (cardUsed = '0' AND price > '0') AND categoryid = '$categoryId' AND CardState = '$insstate' GROUP BY CardCity ORDER BY count DESC";
                                        } else
                                        {
                                            $sql = "SELECT CardCity, COUNT(CardCity) AS count FROM " . $config['table_cards'] . " WHERE (cardUsed = '0' AND price > '0') AND categoryid = '$categoryId' GROUP BY CardCity ORDER BY count DESC";
                                        }
                                        $result = mysql_query($sql, $data_sql);

                if (!$result)
                {
                    echo sql_error();
                } else
                {
                    while ($city = mysql_fetch_assoc($result))
                    {
                        $listcity[] = $city;
                    }
                }

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
                    $sql = "SELECT *, AES_DECRYPT(cardContent, '$config[encode_key]') as cardContent from " . $config["table_cards"] . " LEFT JOIN " . $config["table_categorys"] . " ON " . $config["table_cards"] . ".categoryId = " . $config["table_categorys"] . ".categoryId WHERE (" . $config["table_cards"] . ".cardUsed = '0' AND " . $config["table_cards"] .
                        ".price > '0') $binSearch ORDER BY " . $config["table_cards"] . ".cardId DESC LIMIT $currentCard,$cardPerPage";
                } else
                {
                    $sql = "SELECT *, AES_DECRYPT(cardContent, '$config[encode_key]') as cardContent from " . $config["table_cards"] . " LEFT JOIN " . $config["table_categorys"] . " ON " . $config["table_cards"] . ".categoryId = " . $config["table_categorys"] . ".categoryId WHERE (" . $config["table_cards"] . ".cardUsed = '0' AND " . $config["table_cards"] .
                        ".price > '0' AND " . $config["table_cards"] . ".categoryId = '$categoryId') $binSearch ORDER BY cardId DESC LIMIT $currentCard,$cardPerPage";
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
                    echo $twig->render('card.tpl', array(
                        'categoryId' => $categoryId,
                        'listCategory' => $listCategory,
                        'get' => $_GET,
                        'inscountry' => $inscountry,
                        'listCou' => $listCou,
                        'insstate' => $insstate,
                        'liststate' => $liststate,
                        'inscity' => $inscity,
                        'listcity' => $listcity,
                        'instype' => $instype,
                        'cardPerPage' => $cardPerPage,
                        'totalCards' => $totalCards,
                        'found' => $found,
                        'session' => $_SESSION,
                        'buyandcheck' => $config['Buy&Check'],
                        'listCard' => $listCard,
                        'currentPage' => $currentPage,
                        'pages' => ceil($totalCards / $cardPerPage)));
                } else
                {
                    echo sql_error();
                }
            }  
            {
                echo $bin;
              echo info[$bin];
                                  echo $card[cardNum];
              
function cc($ccline){
  $xy = array("|","\\","/","-",";");
  $sepe = $xy[0];
  foreach($xy as $v){
      if (substr_count($ccline,$sepe) < substr_count($ccline,$v)) $sepe = $v;
  }
  $x = explode($sepe,$ccline);
  foreach($xy as $y) $x = str_replace($y,"",str_replace(" ","",$x));
  foreach ($x as $xx){
      $xx = trim($xx);
         if (is_numeric($xx)){
             $yy=strlen($xx);
             switch ($yy){
                 case 15: $ccnum['num'] = $xx; break;
                 case 16: $ccnum['num'] = $xx; break;
              }
          }
  }
	return $ccnum['num'];
}

function findcc($str){
	$str=str_replace(" ","",$str);
	for($i=0;$i<=strlen($str);$i++){
	if(is_numeric($str[$i])){
	$ccNum.=$str[$i];
	if(strlen($ccNum)>5){
	return $ccNum;
	break;
	};
	}
	else $ccNum='';
	}
}


if($_POST['listcc']){
		$listcc = trim($_POST['listcc']); 
		$listcc = str_replace(array("\\\"","\\'"),array("\"","'"),$listcc); 
		$listcc = str_replace("\n\n","\n",$listcc); 
		$listcc = str_replace("\r\n\r\n","\r\n",$listcc); 
		$listcc = explode("\n",$listcc);
		for($i=0;$i<count($listcc);$i++){
			$ccnum = cc($listcc[$i]);
			if($ccnum == ""){
				$ccnum = findcc($listcc[$i]);
			}
			$info .= info($ccnum);
			$infos .= info($listcc[$i]);
		}
		/*
                $separa = explode("|", $ccnum);
				$cc = $separa[0];
				//echo $ccnum = cc($listcc[$i]);;
				//var_dump($ccnum);
                $urls = "https://lookup.binlist.net/$bindata";
				$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "$urls");
			curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$fim = curl_exec($ch);
				$location = json_decode(trim(strip_tags($fim)), true);
				$countrypost = $location['country']['name'];
				//var_dump($location)."\n";
				//echo $countrypost;
				*/
        $type = 'result';
echo $twig->render('checkbin.tpl', array(
'type' => $type,
'info' => $info,
'ccline' => $ccline));
}
else{
$type = 'page';
echo $twig->render('checkbin.tpl', array(
'type' => $type));
}
    }
}
}
db_close();

?>