<?php
set_time_limit(0);
session_start();
require_once 'lib/Twig/Autoloader.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('template');
$twig = new Twig_Environment($loader, array('cache' => 'template/cache', 'auto_reload' => true));
include_once ("includes/global.php");
include_once ("includes/GoogChart.class.php");
db_connection();
if (!is_login_seller())
{
    header("location: login.php");
} else
{
	$sql = "SELECT * from " . $config["table_users"] . " LEFT JOIN " . $config["table_types"] . " ON " . $config["table_users"] . ".typeId = " . $config["table_types"] . ".typeId WHERE " . $config["table_users"] . ".userId = '" . clean($_SESSION["userId"]) . "'";
	$result = mysql_query($sql,$data_sql);
	if (!$result)
	{
		echo sql_error();
	}
	else
	{
		$count = mysql_num_rows($result);
		if ($count == 1)
		{
			$seller = mysql_fetch_assoc($result);
		}
		else
		{
			die("Your account has been deleted, please contact webmaster for more information.");
		}
	}
if ($config['saledump'] == '0') {
        //TOTAL CC//
        $sql = "SELECT cardId from " . $config["table_cards"] . " WHERE seller = '" . $seller[userId] .
            "'";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            $totalcc = mysql_num_rows($result);
        }
        //UNUSED CC//
        $sql = "SELECT cardId from " . $config["table_cards"] . " WHERE seller = '" . $seller[userId] .
            "' AND cardUsed = '0'";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            $unusedcc = mysql_num_rows($result);
        }
        //USED CC//
        $usedcc = $totalcc - $unusedcc;
        //CHECKER LIVE//
        $sql = "SELECT cardId from " . $config["table_cards"] . " WHERE seller = '" . $seller[userId] .
            "' AND status = '1'";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            $LIVECC = mysql_num_rows($result);
        }
        //CHECKER DIE//
        $sql = "SELECT cardId from " . $config["table_cards"] . " WHERE seller = '" . $seller[userId] .
            "' AND status = '2'";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            $DIECC = mysql_num_rows($result);
        }
        //CHECKER ERROR//
        $sql = "SELECT cardId from " . $config["table_cards"] . " WHERE seller = '" . $seller[userId] .
            "' AND status = '3'";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            $ERRORCC = mysql_num_rows($result);
        }
        //CHECKER TIMEOFF//
        $sql = "SELECT cardId from " . $config["table_cards"] . " WHERE seller = '" . $seller[userId] .
            "' AND status = '5'";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            $TIMEOFFCC = mysql_num_rows($result);
        }
        //CHECKER UNKNOWN//
        $sql = "SELECT cardId from " . $config["table_cards"] . " WHERE seller = '" . $seller[userId] .
            "' AND status = '4'";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            $UNKNOWNCC = mysql_num_rows($result);
        }
        //fullsalespaid//
        $sql = "SELECT price, sellerprc from " . $config["table_cards"] . " WHERE seller = '" . $seller[userId] .
            "' AND cardUsed <> '0' AND (status = '1' OR status = '5')";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            while ($price = mysql_fetch_assoc($result))
					{
						$pricer[] = $price;
					}
            foreach ($pricer as $price)
{
$cena += $price[price] * $price[sellerprc];
}
if (empty($cena)) {
$cena = '0';    
}
        }
        //fullsales//
        $sql = "SELECT cardId, cardNum, status, price, sellerprc from " . $config["table_cards"] . " WHERE seller = '" . $seller[userId] .
            "' AND cardUsed <> '0'";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            while ($sales = mysql_fetch_assoc($result))
					{
						$fullsales[] = $sales;
					}
        }
        $balance = $cena - $seller[paids];

        ///CHECKER CHART///
        $chart = new GoogChart();
        ///PRECENT-CHART///
        $prc1 = $usedcc / '100';
        $liveprc = $LIVECC / $prc1;
        $dieprc = $DIECC / $prc1;
        $errorprc = $ERRORCC / $prc1;
        $unknownprc = $UNKNOWNCC / $prc1;
        $timeoffprc = $TIMEOFFCC / $prc1;
        $data = array(
            'Live (' . $LIVECC . ')' => $liveprc,
            'Die (' . $DIECC . ')' => $dieprc,
            'Error (' . $ERRORCC . ')' => $errorprc,
            'Unknown (' . $UNKNOWNCC . ')' => $unknownprc,
            'Time off (' . $TIMEOFFCC . ')' => $timeoffprc,
            );
        $color = array(
            '#5CB85C',
            '#D9534F',
            '#F0AD4E',
            '#428BCA',
            '#5BC0DE',
            );
        $chart->setChartAttrs(array(
            'type' => 'pie3',
            'title' => 'Checker',
            'data' => $data,
            'size' => array(570, 300),
            'color' => $color));

echo $twig->render('seller/cardstat.tpl', array(
        'balance' => $balance,
        'earned' => $cena,
        'totalpaid' => $seller[paids],
        'totalcards' => $totalcc,
        'unusedcards' => $unusedcc,
        'usedcards' => $usedcc,
        'chart' => $chart,
        'livecards' => $LIVECC,
        'diecards' => $DIECC,
        'errorcards' => $ERRORCC,
        'unknowncards' => $UNKNOWNCC,
        'timeoffcards' => $TIMEOFFCC,
        'sellerid' => $seller[userId],
        'fullsales' => $fullsales
        ));

}
else
{
//CC+DUMPS
        //TOTAL CC//
        $sql = "SELECT cardId from " . $config["table_cards"] . " WHERE seller = '" . $seller[userId] .
            "'";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            $totalcc = mysql_num_rows($result);
        }
        //TOTAL DUMPS//
        $sql = "SELECT dumpId from " . $config["table_dumps"] . " WHERE seller = '" . $seller[userId] .
            "'";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            $totaldumps = mysql_num_rows($result);
        }
        //UNUSED CC//
        $sql = "SELECT cardId from " . $config["table_cards"] . " WHERE seller = '" . $seller[userId] .
            "' AND cardUsed = '0'";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            $unusedcc = mysql_num_rows($result);
        }
        //UNUSED DUMPS//
        $sql = "SELECT dumpId from " . $config["table_dumps"] . " WHERE seller = '" . $seller[userId] .
            "' AND dumpUsed = '0'";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            $unuseddumps = mysql_num_rows($result);
        }
        //USED CC//
        $usedcc = $totalcc - $unusedcc;
        //USED DUMP//
        $useddumps = $totaldumps - $unuseddumps;
        //CHECKER LIVE//
        $sql = "SELECT cardId from " . $config["table_cards"] . " WHERE seller = '" . $seller[userId] .
            "' AND status = '1'";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            $LIVECC = mysql_num_rows($result);
        }
        //CHECKER DUMP LIVE//
        $sql = "SELECT dumpId from " . $config["table_dumps"] . " WHERE seller = '" . $seller[userId] .
            "' AND status = '1'";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            $LIVEDUMP = mysql_num_rows($result);
        }
        //CHECKER DUMP DIE//
        $sql = "SELECT dumpId from " . $config["table_dumps"] . " WHERE seller = '" . $seller[userId] .
            "' AND status = '2'";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            $DIEDUMP = mysql_num_rows($result);
        }
        //CHECKER DIE//
        $sql = "SELECT cardId from " . $config["table_cards"] . " WHERE seller = '" . $seller[userId] .
            "' AND status = '2'";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            $DIECC = mysql_num_rows($result);
        }
        //CHECKER ERROR//
        $sql = "SELECT cardId from " . $config["table_cards"] . " WHERE seller = '" . $seller[userId] .
            "' AND status = '3'";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            $ERRORCC = mysql_num_rows($result);
        }
        //CHECKER DUMP ERROR//
        $sql = "SELECT dumpId from " . $config["table_dumps"] . " WHERE seller = '" . $seller[userId] .
            "' AND status = '3'";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            $ERRORDUMP = mysql_num_rows($result);
        }
        //CHECKER TIMEOFF//
        $sql = "SELECT cardId from " . $config["table_cards"] . " WHERE seller = '" . $seller[userId] .
            "' AND status = '5'";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            $TIMEOFFCC = mysql_num_rows($result);
        }
        //CHECKER DUMP TIMEOFF//
        $sql = "SELECT dumpId from " . $config["table_dumps"] . " WHERE seller = '" . $seller[userId] .
            "' AND status = '5'";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            $TIMEOFFDUMP = mysql_num_rows($result);
        }
        //CHECKER UNKNOWN//
        $sql = "SELECT cardId from " . $config["table_cards"] . " WHERE seller = '" . $seller[userId] .
            "' AND status = '4'";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            $UNKNOWNCC = mysql_num_rows($result);
        }
        //CHECKER DUMP UNKNOWN//
        $sql = "SELECT dumpId from " . $config["table_dumps"] . " WHERE seller = '" . $seller[userId] .
            "' AND status = '4'";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            $UNKNOWNDUMP = mysql_num_rows($result);
        }
        //fullsalespaid//
        $sql = "SELECT price, sellerprc from " . $config["table_cards"] . " WHERE seller = '" . $seller[userId] .
            "' AND cardUsed <> '0' AND (status = '1' OR status = '5')";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            while ($price = mysql_fetch_assoc($result))
					{
						$pricer[] = $price;
					}
            foreach ($pricer as $price)
{
$cena += $price[price] * $price[sellerprc];
}
if (empty($cena)) {
$cena = '0';    
}
        }
        //fullsalespaid DUMP//
        $sql = "SELECT price, sellerprc from " . $config["table_dumps"] . " WHERE seller = '" . $seller[userId] .
            "' AND dumpUsed <> '0' AND (status = '1' OR status = '5')";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            while ($pricedump = mysql_fetch_assoc($result))
					{
						$pricerdump[] = $pricedump;
					}
            foreach ($pricerdump as $pricedump)
{
$cenadump += $pricedump[price] * $pricedump[sellerprc];
}
if (empty($cenadump)) {
$cenadump = '0';    
}
        }
        //fullsales//
        $sql = "SELECT cardId, cardNum, status, price, sellerprc from " . $config["table_cards"] . " WHERE seller = '" . $seller[userId] .
            "' AND cardUsed <> '0'";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            while ($sales = mysql_fetch_assoc($result))
					{
						$fullsales[] = $sales;
					}
        }
        //fullsales Dump//
        $sql = "SELECT dumpId, dumpNum, status, price, pack, sellerprc from " . $config["table_dumps"] . " WHERE seller = '" . $seller[userId] .
            "' AND dumpUsed <> '0'";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            while ($salesdump = mysql_fetch_assoc($result))
					{
						$fullsalesdump[] = $salesdump;
					}
        }
        $balance = $cena + $cenadump - $seller[paids];
        $earned = $cena + $cenadump;
        
        ///CHECKER CHART///
        $chart = new GoogChart();
        ///PRECENT-CHART///
        $prc1 = $usedcc / '100';
        $liveprc = $LIVECC / $prc1;
        $dieprc = $DIECC / $prc1;
        $errorprc = $ERRORCC / $prc1;
        $unknownprc = $UNKNOWNCC / $prc1;
        $timeoffprc = $TIMEOFFCC / $prc1;
        $data = array(
            'Live (' . $LIVECC . ')' => $liveprc,
            'Die (' . $DIECC . ')' => $dieprc,
            'Error (' . $ERRORCC . ')' => $errorprc,
            'Unknown (' . $UNKNOWNCC . ')' => $unknownprc,
            'Time off (' . $TIMEOFFCC . ')' => $timeoffprc,
            );
        $color = array(
            '#5CB85C',
            '#D9534F',
            '#F0AD4E',
            '#428BCA',
            '#5BC0DE',
            );
        $chart->setChartAttrs(array(
            'type' => 'pie',
            'title' => 'Checker CC',
            'data' => $data,
            'size' => array(350, 250),
            'color' => $color));
            
        ///CHECKER DUMP CHART///
        $chartdumps = new GoogChart();
        ///PRECENT-CHART///
        $prc2 = $useddumps / '100';
        $dliveprc = $LIVEDUMP / $prc2;
        $ddieprc = $DIEDUMP / $prc2;
        $derrorprc = $ERRORDUMP / $prc2;
        $dunknownprc = $UNKNOWNDUMP / $prc2;
        $dtimeoffprc = $TIMEOFFDUMP / $prc2;
        $data2 = array(
            'Live (' . $LIVEDUMP . ')' => $dliveprc,
            'Die (' . $DIEDUMP . ')' => $ddieprc,
            'Error (' . $ERRORDUMP . ')' => $derrorprc,
            'Unknown (' . $UNKNOWNDUMP . ')' => $dunknownprc,
            'Time off (' . $TIMEOFFDUMP . ')' => $dtimeoffprc,
            );
        $color2 = array(
            '#5CB85C',
            '#D9534F',
            '#F0AD4E',
            '#428BCA',
            '#5BC0DE',
            );
        $chartdumps->setChartAttrs(array(
            'type' => 'pie',
            'title' => 'Checker DUMPS',
            'data' => $data2,
            'size' => array(350, 250),
            'color' => $color2));
        
        echo $twig->render('seller/dumpandcard.tpl', array(
        'balance' => $balance,
        'earned' => $earned,
        'earnedcc' => $cena,
        'earneddumps' => $cenadump,
        'totalpaid' => $seller[paids],
        'totalcards' => $totalcc,
        'unusedcards' => $unusedcc,
        'usedcards' => $usedcc,
        'totaldumps' => $totaldumps,
        'unuseddumps' => $unuseddumps,
        'useddumps' => $useddumps,
        'livecards' => $LIVECC,
        'diecards' => $DIECC,
        'errorcards' => $ERRORCC,
        'unknowncards' => $UNKNOWNCC,
        'timeoffcards' => $TIMEOFFCC,
        'livedumps' => $LIVEDUMP,
        'diedumps' => $DIEDUMP,
        'errordumps' => $ERRORDUMP,
        'unknowndumps' => $UNKNOWNDUMP,
        'timeoffdumps' => $TIMEOFFDUMP,
        'cardchart' => $chart,
        'dumpchart' => $chartdumps,
        'sellerid' => $seller[userId],
        'fullsales' => $fullsales,
        'fullsalesdump' => $fullsalesdump,
        ));
}        
}
db_close();
?>