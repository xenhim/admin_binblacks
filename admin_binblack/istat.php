<?php
	set_time_limit(0);
	session_start();
    require_once '../lib/Twig/Autoloader.php';
    Twig_Autoloader::register();
    $loader = new Twig_Loader_Filesystem('../template');
    $twig = new Twig_Environment($loader, array('cache' => '../template/cache', 'auto_reload' => true));
	include_once("../includes/global.php");
    include_once("../includes/GoogChart.class.php");
	db_connection();
	if (!is_login_admin())
	{
		header("location: login.php");
	}
	else
	{
///CATEGORY///
$sql = "SELECT categoryId from " . $config["table_categorys"];
	$result = mysql_query($sql,$data_sql);
	if (!$result)
	{
		echo sql_error();
	}
	else
	{
		$categoryNumber = mysql_num_rows($result);
	}
///CATEGORY DUMP///
$sql = "SELECT categoryId from " . $config["table_categorys_dump"];
	$result = mysql_query($sql,$data_sql);
	if (!$result)
	{
		echo sql_error();
	}
	else
	{
		$categoryDumpNumber = mysql_num_rows($result);
	}
///TOTAL CARDS///
$sql = "SELECT cardId from " . $config["table_cards"];
	$result = mysql_query($sql,$data_sql);
	if (!$result)
	{
		echo sql_error();
	}
	else
	{
		$totalCardNumber = mysql_num_rows($result);
	}
///TOTAL DumpS///
$sql = "SELECT dumpId from " . $config["table_dumps"];
	$result = mysql_query($sql,$data_sql);
	if (!$result)
	{
		echo sql_error();
	}
	else
	{
		$totalDumpNumber = mysql_num_rows($result);
	}
///CHECKER STATS///
$sql = "SELECT cardId from " . $config["table_cards"] . " WHERE status = '1' AND cardUsed <> '0'";
	$result = mysql_query($sql,$data_sql);
	if (!$result)
	{
		echo sql_error();
	}
	else
	{
		$LIVEC = mysql_num_rows($result);
	}
		$sql = "SELECT cardId from " . $config["table_cards"] . " WHERE status = '2' AND cardUsed <> '0'";
	$result = mysql_query($sql,$data_sql);
	if (!$result)
	{
		echo sql_error();
	}
	else
	{
		$DIEC = mysql_num_rows($result);
	}
	$sql = "SELECT cardId from " . $config["table_cards"] . " WHERE status = '3' AND cardUsed <> '0'";
	$result = mysql_query($sql,$data_sql);
	if (!$result)
	{
		echo sql_error();
	}
	else
	{
		$ERRORC = mysql_num_rows($result);
	}
	$sql = "SELECT cardId from " . $config["table_cards"] . " WHERE status = '4' AND cardUsed <> '0'";
	$result = mysql_query($sql,$data_sql);
	if (!$result)
	{
		echo sql_error();
	}
	else
	{
		$UNKNOWNC = mysql_num_rows($result);
	}
		//CHECKER TIMEOFF//
        $sql = "SELECT cardId from " . $config["table_cards"] . " WHERE status = '5' AND cardUsed <> '0'";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            $TIMEOFFC = mysql_num_rows($result);
        }
///CHECKER DUMP STATS///
$sql = "SELECT dumpId from " . $config["table_dumps"] . " WHERE status = '1' AND dumpUsed <> '0'";
	$result = mysql_query($sql,$data_sql);
	if (!$result)
	{
		echo sql_error();
	}
	else
	{
		$DUMPLIVEC = mysql_num_rows($result);
	}
		$sql = "SELECT dumpId from " . $config["table_dumps"] . " WHERE status = '2' AND dumpUsed <> '0'";
	$result = mysql_query($sql,$data_sql);
	if (!$result)
	{
		echo sql_error();
	}
	else
	{
		$DUMPDIEC = mysql_num_rows($result);
	}
	$sql = "SELECT dumpId from " . $config["table_dumps"] . " WHERE status = '3' AND dumpUsed <> '0'";
	$result = mysql_query($sql,$data_sql);
	if (!$result)
	{
		echo sql_error();
	}
	else
	{
		$DUMPERRORC = mysql_num_rows($result);
	}
	$sql = "SELECT dumpId from " . $config["table_dumps"] . " WHERE status = '4' AND dumpUsed <> '0'";
	$result = mysql_query($sql,$data_sql);
	if (!$result)
	{
		echo sql_error();
	}
	else
	{
		$DUMPUNKNOWNC = mysql_num_rows($result);
	}
    ///TIMEOFF DUMPS///
	$sql = "SELECT dumpId from " . $config["table_dumps"] . " WHERE status = '5' AND dumpUsed <> '0'";
	$result = mysql_query($sql,$data_sql);
	if (!$result)
	{
		echo sql_error();
	}
	else
	{
		$DUMPTIMEOFFC = mysql_num_rows($result);
	}
///UNUSED CARD///
	$sql = "SELECT cardId from " . $config["table_cards"] . " WHERE cardUsed = '0'";
	$result = mysql_query($sql,$data_sql);
	if (!$result)
	{
		echo sql_error();
	}
	else
	{
		$unusedCardNumber = mysql_num_rows($result);
	}
$usedCardNumber = $totalCardNumber - $unusedCardNumber;
///UNUSED DUMP///
	$sql = "SELECT dumpId from " . $config["table_dumps"] . " WHERE dumpUsed = '0'";
	$result = mysql_query($sql,$data_sql);
	if (!$result)
	{
		echo sql_error();
	}
	else
	{
		$unusedDumpNumber = mysql_num_rows($result);
	}
$usedDumpNumber = $totalDumpNumber - $unusedDumpNumber;
///PRECENT-CHART///
$prc1 = $usedCardNumber / 100;
$liveprc = $LIVEC / $prc1;
$dieprc = $DIEC / $prc1;
$errorprc = $ERRORC / $prc1;
$unknownprc = $UNKNOWNC / $prc1;
$timeoffprc = $TIMEOFFC / $prc1;
///DUMP-PRECENT-CHART///
$dumpprc1 = $usedDumpNumber / 100;
$dumpliveprc = $DUMPLIVEC / $prc1;
$dumpdieprc = $DUMPDIEC / $prc1;
$dumperrorprc = $DUMPERRORC / $prc1;
$dumpunknownprc = $DUMPUNKNOWNC / $prc1;
$dumptimeoffprc = $DUMPTIMEOFFC / $prc1;
///TYPE USER///
$sql = "SELECT userId from " . $config["table_users"] . " WHERE typeId = '1'";
	$result = mysql_query($sql,$data_sql);
	if (!$result)
	{
		echo sql_error();
	}
	else
	{
		$adminUser = mysql_num_rows($result);
	}
 $sql = "SELECT userId from " . $config["table_users"] . " WHERE typeId = '2'";
	$result = mysql_query($sql,$data_sql);
	if (!$result)
	{
		echo sql_error();
	}
	else
	{
		$userUser = mysql_num_rows($result);
	}
 $sql = "SELECT userId from " . $config["table_users"] . " WHERE typeId = '3'";
	$result = mysql_query($sql,$data_sql);
	if (!$result)
	{
		echo sql_error();
	}
	else
	{
		$sellerUser = mysql_num_rows($result);
	}
	$sql = "SELECT userId from " . $config["table_users"];
	$result = mysql_query($sql,$data_sql);
	if (!$result)
	{
		echo sql_error();
	}
	else
	{
		$totalUser = mysql_num_rows($result);
	}
/// TOP 7 USER ///
$sql = "SELECT username, credit from " . $config["table_users"] . " WHERE typeId = '2' ORDER BY credit DESC LIMIT 0 , 7";
	$result = mysql_query($sql,$data_sql);
	if (!$result)
	{
		echo sql_error();
	}
	else
	{
	   while ($result1 = mysql_fetch_assoc($result))
					{
						$LISTUser[] = $result1;
					}
	}
///CHECKER CHART///
$chart = new GoogChart();
$data = array(
			'Live ('.$LIVEC.')' => $liveprc,
			'Die ('.$DIEC.')' => $dieprc,
			'Error ('.$ERRORC.')' => $errorprc,
			'Unknown ('.$UNKNOWNC.')' => $unknownprc,
			'Time off ('.$TIMEOFFC.')' => $timeoffprc,
		);
$color = array(
			'#5CB85C',
			'#D9534F',
			'#F0AD4E',
            '#428BCA',
            '#5BC0DE',
		);
$chart->setChartAttrs( array(
	'type' => 'pie3',
	'title' => 'Credit Cards Checker',
	'data' => $data,
	'size' => array( 570, 300 ),
	'color' => $color
	));
///DUMP CHART///
$dumpchart = new GoogChart();
$dumpdata = array(
			'Live ('.$DUMPLIVEC.')' => $dumpliveprc,
			'Die ('.$DUMPDIEC.')' => $dumpdieprc,
			'Error ('.$DUMPERRORC.')' => $dumperrorprc,
			'Unknown ('.$DUMPUNKNOWNC.')' => $dumpunknownprc,
			'Time off ('.$DUMPTIMEOFFC.')' => $dumptimeoffprc,
		);
$dumpcolor = array(
			'#5CB85C',
			'#D9534F',
			'#F0AD4E',
            '#428BCA',
            '#5BC0DE',
		);
$dumpchart->setChartAttrs( array(
	'type' => 'pie3',
	'title' => 'Dumps Checker',
	'data' => $dumpdata,
	'size' => array( 570, 300 ),
	'color' => $dumpcolor
	));
echo $twig->render('admin/stats.tpl', array(
    'adminUser' => $adminUser,
    'sellerUser' => $sellerUser,
    'userUser' => $userUser,
    'totalUser' => $totalUser,
    'cardcategory' => $categoryNumber,
    'totalcard' => $totalCardNumber,
    'unusedcard' => $unusedCardNumber,
    'usedcard' => $usedCardNumber,
    'livecards' => $LIVEC,
    'diecards' => $DIEC,
    'errorcards' => $ERRORC,
    'unknowncards' => $UNKNOWNC,
    'timeoffcards' => $TIMEOFFC,
    'cardschart' => $chart,
    'listuser' => $LISTUser,
    'dumpschart' => $dumpchart,
    'dumpcategory' => $categoryDumpNumber,
    'totaldumps' => $totalDumpNumber,
    'unuseddumps' => $unusedDumpNumber,
    'useddumps' => $usedDumpNumber,
    'livedumps' => $DUMPLIVEC,
    'diedumps' => $DUMPDIEC,
    'errordumps' => $DUMPERRORC,
    'unknowndumps' => $DUMPUNKNOWNC,
    'timeoffdumps' => $DUMPTIMEOFFC));
 	}
	db_close();
?>