<?php
	set_time_limit(0);
	session_start();
    require_once '../lib/Twig/Autoloader.php';
    Twig_Autoloader::register();
    $loader = new Twig_Loader_Filesystem('../template');
    $twig = new Twig_Environment($loader, array('cache' => '../template/cache', 'auto_reload' => true));
	include_once("../includes/global.php");
	db_connection();
	$act = clean($_GET["act"]);
	if (!is_login_admin())
	{
		header("location: login.php");
	}
	else
	{
		if ($act == "edit")
		{
			if (isset($_POST["save"]))
			{
				$id = clean($_POST["id"]);
				$content = clean($_POST["content"]);
				$used = clean($_POST["used"]);
				$category = clean($_POST["category"]);
				$dumpNum = clean($_POST["dumpNum"]);
				$dumpMon = clean($_POST["dumpMon"]);
				$dumpYea = clean($_POST["dumpYea"]);
				$dumpCou = clean($_POST["dumpCou"]);
				$dumpcode = clean($_POST["dumpcode"]);
				$dumptype = clean($_POST["dumptype"]);
                $dumpclass = clean($_POST["dumpclass"]);
                $dumplevel = clean($_POST["dumplevel"]);
                $dumpbank = clean($_POST["dumpbank"]);
                $status = clean($_POST["status"]);
                $price = clean($_POST["price"]);
                $iseller = clean($_POST["seller"]);
                $isellerprc = clean($_POST["sellerprc"]);
                $isellerprc = str_replace(",",".",$isellerprc);
				if ($content != "" && $dumpNum != "" && $dumpMon != "" && $dumpYea != "")
				{
					if ($dumpNum < 1 || $dumpMon < 1 || $dumpYea < 1)
					{
						echo "<center><font color='#ff0000'>Please give correct position</font></center>";
					}
					else
					{
						$sql = "UPDATE " . $config["table_dumps"] . " SET dumpContent = AES_ENCRYPT('$content', '$config[encode_key]'), dumpNum = '$dumpNum', dumpMon = '$dumpMon', dumpYea = '$dumpYea', dumpCou = '$dumpCou', dumpcode = '$dumpcode', dumptype = '$dumptype', dumpclass = '$dumpclass', dumplevel = '$dumplevel', dumpbank = '$dumpbank', dumpUsed = '$used', categoryId = '$category', price = '$price', status = '$status', seller = '$iseller', sellerprc = '$isellerprc' WHERE dumpId = '$id'";
                        $result = mysql_query($sql, $data_sql);
						if ($result)
						{
							echo "<script type=\"text/javascript\" src=\"../js/jquery-1.4.2.min.js\"></script><script>alert('Edited card #$id successful');$(parent).ready(function(){parent.showpage('dumps.php');});</script>";
						}
						else
						{
							echo sql_error();
						}
					}
				}
				else
				{
					echo "<center><font color='#ff0000'>Please fill all field requires (*)</font></center>";
				}
			}
			else
			{
				$sql = "SELECT * FROM " . $config['table_categorys_dump'] . " ORDER BY categoryId";
				$result = mysql_query($sql,$data_sql);
				if (!$result)
				{
					echo sql_error();
				}
				else
				{
					while ($category = mysql_fetch_assoc($result))
					{
						$listCategory[] = $category;
					}
				}
                //SELLER//
                $sql = "SELECT userId, username FROM " . $config['table_users'] . " WHERE typeId = '3'";
				$result = mysql_query($sql,$data_sql);
				if (!$result)
				{
					echo sql_error();
				}
				else
				{
					while ($seller = mysql_fetch_assoc($result))
					{
						$listseller[] = $seller;
					}
				}
                //SELLER//
				$cardid = clean($_GET["cardid"]);
				$sql = "SELECT *, AES_DECRYPT(dumpContent, '$config[encode_key]') as dumpContent from " . $config["table_dumps"] . " WHERE dumpId = '$cardid'";
				$result = mysql_query($sql, $data_sql);
				if ($result)
				{
					$count = mysql_num_rows($result);
					if ($count == 1)
					{
						$card = mysql_fetch_assoc($result);
                        $found = '1';
                    }
					else
					{
						$found = '0';
					}
				}
				else
				{
					echo sql_error();
				}
				echo $twig->render('admin/elements/dumpedit.tpl', array(
                        'cardid' => $cardid,
                        'found' => $found,
                        'card' => $card,
                        'listCategory' => $listCategory,
                        'listseller' => $listseller
                        ));
			}
		}
		else if ($act == "delete")
		{
			$cardid = clean($_GET["cardid"]);
			$sql = "DELETE from " . $config["table_dumps"] . " WHERE dumpId = '$cardid'";
			$result = mysql_query($sql, $data_sql);
			if ($result)
			{
				header("location: dumps.php");
			}
			else
			{
				echo sql_error();
			}
		}
		else if ($act == "add")
		{
			if (isset($_POST["save"]))
			{
				$listcard = str_replace("\r", "", $_POST["listcard"]);
				$listcard = str_replace("\n\n", "\n", $listcard);
				$category = clean($_POST["category"]);
				$spliter = "=";
                $iseller = clean($_POST["seller"]);
                $isellerprc = clean($_POST["sellerprc"]);
                $isellerprc = str_replace(",",".",$isellerprc);
				$checkcard = '0';
                $norefund = clean($_POST["norefund"]);
    function getStr($string,$start,$end){
	$str = explode($start,$string);
	$str = explode($end,$str[1]);
	return $str[0];
}
				if ($listcard != "" && $category != "")
				{
					if ($listcard < 1)
					{
						echo "<center><font color='#ff0000'>please give correct position</font></center>";
					}
					else
					{
						$listcard = explode("\n", $listcard);
                        echo '<style type="text/css">body {background: #000;}</style>';
						foreach ($listcard as $k => $v)
						{
							if (strlen($v) > 20)
							{
								$cardField = explode($spliter, $v);
								if (count($cardField) >= 2)
								{
									$cardNumber = clean($cardField[0]);
                                    $cardNumber = preg_replace("/\\D+/",'',$cardNumber);
									$cardDate = clean($cardField[1]);
                                    $cardMonth = substr($cardDate, 2, 2);
                                    $cardYear = substr($cardDate, 0, 2);
                                    $cardcode = substr($cardDate, 4, 3);
                                    $bin = substr($cardNumber, 0, 6);
		
        $file = file_get_contents('../dbbin1/base.csv');
		$info = getStr($file,$bin,"\n");
		$info = explode(";",$info);
									$dumpbank = $info[2];
									$dumpbank = str_replace("'", "", $dumpbank);
									$dumpbank = str_replace('"', '', $dumpbank);
									$dumpbank = clean($dumpbank);
                                    $dumpclass = $info[3];
									$dumpclass = str_replace("'", "", $dumpclass);
									$dumpclass = str_replace('"', '', $dumpclass);
									$dumpclass = clean($dumpclass);
                                    $dumplevel = $info[4];
									$dumplevel = str_replace("'", "", $dumplevel);
									$dumplevel = str_replace('"', '', $dumplevel);
									$dumplevel = clean($dumplevel);
                                    $dumpCou = $info[5];
									$dumpCou = str_replace("'", "", $dumpCou);
									$dumpCou = str_replace('"', '', $dumpCou);
									$dumpCou = clean($dumpCou);
                                    $dumptype = $info[1];
									$dumptype = str_replace("'", "", $dumptype);
									$dumptype = str_replace('"', '', $dumptype);
									$dumptype = clean($dumptype);
									if ($checkcard == '1')
									{
										$respond = checkdump($cardNumber, $cardMonth, $cardYear, $cardCvv);
									}
									else
									{
										$respond = 1;
									}
									if ($respond == 1)
									{
										$sql = "SELECT dumpId FROM " . $config["table_dumps"] . " WHERE AES_DECRYPT(dumpContent, '$config[encode_key]') like '%" . $cardNumber . "%'";
										$result = mysql_query($sql, $data_sql);
										if ($result)
										{
											if (mysql_num_rows($result) >= 1)
											{
												echo "<font color='#ff0000'>Line ".($k+1).": $v => Duplicate in database</font><br />";
											}
											else
											{
												$v = clean($v);
												$sql = "INSERT INTO " . $config["table_dumps"] . " (categoryId, dumpContent, dumpNum, dumpMon, dumpYea, dumpCou, dumpcode, dumptype, dumpclass, dumplevel, dumpbank, seller, sellerprc, status) VALUES ('$category', AES_ENCRYPT('$v', '$config[encode_key]'), '$cardNumber', '$cardMonth', '$cardYear', '$dumpCou', '$cardcode', '$dumptype', '$dumpclass', '$dumplevel', '$dumpbank', '$iseller', '$isellerprc','$norefund')";
												$result = mysql_query($sql, $data_sql);
												if ($result)
												{
													echo "<font color='#00ff00'>Line ".($k+1).": $v => Added to database</font><br />";
												}
												else
												{
													echo sql_error();
												}
											}
										}
										else
										{
											echo sql_error();
										}
									}
									else if ($respond == 2)
									{
										echo "<font color='#ff0000'>Line ".($k+1).": $v => Invalid card number.</font><br />";
									}
									else if ($respond == 3)
									{
										echo "<font color='#ff0000'>Line ".($k+1).": $v => Die</font><br />";
									}
									else
									{
										echo "<font color='#ff0000'>Line ".($k+1).": $v => Server check error => Stop</font><br />";
										break;
									}
								}
								else
								{
									echo "<font color='#ff0000'>Line ".($k+1).": $v => Line error</font><br />";
								}
								flush();
							}
						}
					}
				}
				else
				{
					echo "<center><font color='#ff0000'>Please fill all field requires (*)</font></center>";
				}
			}
			else
			{
				$sql = "SELECT * FROM " . $config['table_categorys_dump'] . " ORDER BY categoryId";
				$result = mysql_query($sql,$data_sql);
				if (!$result)
				{
					echo sql_error();
				}
				else
				{
					while ($category = mysql_fetch_assoc($result))
					{
						$listCategory[] = $category;
					}
				}
                $sql = "SELECT userId, username FROM " . $config['table_users'] . " WHERE typeId = '3'";
				$result = mysql_query($sql,$data_sql);
				if (!$result)
				{
					echo sql_error();
				}
				else
				{
					while ($seller = mysql_fetch_assoc($result))
					{
						$listseller[] = $seller;
					}
				}
                echo $twig->render('admin/elements/dumpadd.tpl', array(
                        'listseller' => $listseller,
                        'listCategory' => $listCategory
                        ));
			}
		}
		else
		{
			if (isset($_GET["cat"]) && $_GET["cat"] > 0)
			{
				$categoryId = clean($_GET["cat"]);
			}
			else
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
				$binSearch .= " AND dumpNum like '%".substr(clean($_GET[last4]), 0, 4)."'";
			}
			else
			{
				$binSearch .= "";
			}
			if (isset($_GET["country"]) && strlen($_GET["country"]) > 0)
			{
			    $inscountry = clean($_GET["country"]);
				$binSearch .= " AND dumpCou like '%".clean($_GET[country])."%'";
			}
            else
			{
				$inscountry = '0';
			}
            if (isset($_GET["type"]) && strlen($_GET["type"]) > 0)
			{
			    $instype = clean($_GET["type"]);
				$binSearch .= " AND dumptype like '%".clean($_GET[type])."%'";
			}
            else
			{
				$instype = '0';
			}
            if (isset($_GET["level"]) && strlen($_GET["level"]) > 0)
			{
			    $inslevel = clean($_GET["level"]);
				$binSearch .= " AND dumplevel like '%".clean($_GET[level])."%'";
			}
            else
			{
				$inslevel = '0';
			}
            if (isset($_GET["class"]) && strlen($_GET["class"]) > 0)
			{
			    $insclass = clean($_GET["class"]);
				$binSearch .= " AND dumpclass like '%".clean($_GET['class'])."%'";
			}
            else
			{
				$insclass = '0';
			}
            if (isset($_GET["bank"]) && strlen($_GET["bank"]) > 0)
			{
			    $insbank = clean($_GET["bank"]);
				$binSearch .= " AND dumpbank like '%".clean($_GET['bank'])."%'";
			}
            else
			{
				$insbank = '0';
			}
            if (isset($_GET["code"]) && strlen($_GET["code"]) > 0)
			{
			    $inscode = clean($_GET["code"]);
				$binSearch .= " AND dumpcode like '%".clean($_GET[code])."%'";
			}
            else
			{
				$inscode = '0';
			}
			$ordercardby = "ASC";
            //TEST COUNTRY
            if ($categoryId == '0'){
            $sql = "SELECT dumpCou, COUNT(dumpCou) AS count FROM " . $config['table_dumps'] . " GROUP BY dumpCou ORDER BY count DESC";
            } else {
            $sql = "SELECT dumpCou, COUNT(dumpCou) AS count FROM " . $config['table_dumps'] . " WHERE categoryid = '$categoryId' GROUP BY dumpCou ORDER BY count DESC";
            }
            $result = mysql_query($sql,$data_sql);
            
			if (!$result)
			{
				echo sql_error();
			}
			else
			{
				while ($country = mysql_fetch_assoc($result))
				{
					$listCou[] = $country;
				}
			}
            //TEST COUNTRY
            //TYPE
            if ($categoryId == '0'){
            $sql = "SELECT dumptype, COUNT(dumptype) AS count FROM " . $config['table_dumps'] . " GROUP BY dumptype ORDER BY count DESC";
            } else {
            $sql = "SELECT dumptype, COUNT(dumptype) AS count FROM " . $config['table_dumps'] . " WHERE categoryid = '$categoryId' GROUP BY dumptype ORDER BY count DESC";
            }
            $result = mysql_query($sql,$data_sql);
            
			if (!$result)
			{
				echo sql_error();
			}
			else
			{
				while ($listype = mysql_fetch_assoc($result))
				{
					$listtype[] = $listype;
				}
			}
            //TYPE
            //CODE
            if ($categoryId == '0'){
            $sql = "SELECT dumpcode, COUNT(dumpcode) AS count FROM " . $config['table_dumps'] . " GROUP BY dumpcode ORDER BY count DESC";
            } else {
            $sql = "SELECT dumpcode, COUNT(dumpcode) AS count FROM " . $config['table_dumps'] . " WHERE categoryid = '$categoryId' GROUP BY dumpcode ORDER BY count DESC";
            }
            $result = mysql_query($sql,$data_sql);
            
			if (!$result)
			{
				echo sql_error();
			}
			else
			{
				while ($liscode = mysql_fetch_assoc($result))
				{
					$listcode[] = $liscode;
				}
			}
            //CODE
            //LEVEL
            if ($categoryId == '0'){
            $sql = "SELECT dumplevel, COUNT(dumplevel) AS count FROM " . $config['table_dumps'] . " WHERE (dumpUsed = '0' AND price > '0') GROUP BY dumplevel ORDER BY count DESC";
            } else {
            $sql = "SELECT dumplevel, COUNT(dumplevel) AS count FROM " . $config['table_dumps'] . " WHERE categoryid = '$categoryId' GROUP BY dumplevel ORDER BY count DESC";
            }
            $result = mysql_query($sql,$data_sql);
            
			if (!$result)
			{
				echo sql_error();
			}
			else
			{
				while ($lislevel = mysql_fetch_assoc($result))
				{
					$listlevel[] = $lislevel;
				}
			}
            //LEVEL
            //CLASS
            if ($categoryId == '0'){
            $sql = "SELECT dumpclass, COUNT(dumpclass) AS count FROM " . $config['table_dumps'] . " GROUP BY dumpclass ORDER BY count DESC";
            } else {
            $sql = "SELECT dumpclass, COUNT(dumpclass) AS count FROM " . $config['table_dumps'] . " WHERE categoryid = '$categoryId' GROUP BY dumpclass ORDER BY count DESC";
            }
            $result = mysql_query($sql,$data_sql);
            
			if (!$result)
			{
				echo sql_error();
			}
			else
			{
				while ($lisclass = mysql_fetch_assoc($result))
				{
					$listclass[] = $lisclass;
				}
			}
            //CLASS
            //BANK
            if ($categoryId == '0'){
            $sql = "SELECT dumpbank, COUNT(dumpbank) AS count FROM " . $config['table_dumps'] . " GROUP BY dumpbank ORDER BY count DESC";
            } else {
            $sql = "SELECT dumpbank, COUNT(dumpbank) AS count FROM " . $config['table_dumps'] . " WHERE categoryid = '$categoryId' GROUP BY dumpbank ORDER BY count DESC";
            }
            $result = mysql_query($sql,$data_sql);
            
			if (!$result)
			{
				echo sql_error();
			}
			else
			{
				while ($lisbank = mysql_fetch_assoc($result))
				{
					$listbank[] = $lisbank;
				}
			}
            //BANK
			$sql = "SELECT dumpId FROM " . $config['table_dumps'] . " LEFT JOIN " . $config['table_users'] . " ON " . $config['table_dumps'] . ".dumpUsed = " . $config['table_users'] . ".userId";
			if ($categoryId != 0)
			{
				$sql .= " WHERE categoryId = '$categoryId'";
			}
			else
			{
				$sql .= " WHERE 1";
			}
			if ($_GET["showused"] == "yes")
			{
				$showused = "yes";
				$sql .= " AND dumpUsed <> '0'";
			}
			else
			{
				$showused = "no";
				$sql .= " AND dumpUsed = '0'";
			}
			$sql .= " $binSearch ORDER BY dumpId $ordercardby";
			$result = mysql_query($sql,$data_sql);
			if (!$result)
			{
				echo sql_error();
			}
			else
			{
				$totalCards = mysql_num_rows($result);
			}
			$sql = "SELECT categoryId,categoryName FROM " . $config['table_categorys_dump'] . " ORDER BY categoryId";
            $result = mysql_query($sql,$data_sql);
			if (!$result)
			{
				echo sql_error();
			}
			else
			{
				while ($category = mysql_fetch_assoc($result))
				{
					$listCategory[] = $category;
				}
			}
			if (isset($_GET["page"]) && $_GET["page"] > 0)
			{
				$currentPage = clean($_GET["page"]);
			}
			else
			{
				$currentPage = 1;
			}
			if (isset($_GET["perpage"]) && in_array($_GET["perpage"], array(10, 20, 50, 100)))
			{
				$cardPerPage = clean($_GET["perpage"]);
			}
			else
			{
				$cardPerPage = 10;
			}
			$currentCard = ($currentPage - 1) * $cardPerPage;
			$sql = "SELECT *, AES_DECRYPT(dumpContent, '$config[encode_key]') as dumpContent FROM " . $config['table_dumps'] . " LEFT JOIN " . $config['table_users'] . " ON " . $config['table_dumps'] . ".dumpUsed = " . $config['table_users'] . ".userId LEFT JOIN " . $config['table_categorys_dump'] . " ON " . $config['table_dumps'] . ".categoryId = " . $config['table_categorys_dump'] . ".categoryId ";
			if ($categoryId != 0)
			{
				$sql .= " WHERE " . $config['table_dumps'] . ".categoryId = '$categoryId'";
			}
			else
			{
				$sql .= " WHERE 1";
			}
			if ($_GET["showused"] == "yes")
			{
				$showused = "yes";
				$sql .= " AND dumpUsed <> '0'";
			}
			else if ($_GET["showused"] == "no")
			{
				$showused = "no";
				$sql .= " AND dumpUsed = '0'";
			}
			else
			{
				$showused = "all";
			}
			$sql .= " $binSearch ORDER BY dumpId $ordercardby LIMIT $currentCard,$cardPerPage";
			$result = mysql_query($sql, $data_sql);
			if ($result)
			{
				$count = mysql_num_rows($result);
				if ($count >= 1)
				{
					while ($card = mysql_fetch_assoc($result))
					{
						if ($card[username] == "")
						{
							$card[username] = "None";
						}
						$listCard[] = $card;
					}
                    $found = '1';
				}
				else
				{
					$found = '0';
				}
			}
			else
			{
				echo sql_error();
			}
            echo $twig->render('admin/dumps.tpl', array(
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
                        'listCard' => $listCard,
                        'currentPage' => $currentPage,
                        'showused' => $showused,
                        'pages' => ceil($totalCards / $cardPerPage)));
		}
	}
	db_close();
?>