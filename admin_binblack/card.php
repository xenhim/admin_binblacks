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
				$spliter = clean($_POST["spliter"]);
				$numpost = clean($_POST["numpost"]);
				$cvvpost = clean($_POST["cvvpost"]);
				$monpost = clean($_POST["monpost"]);
				$yeapost = clean($_POST["yeapost"]);
				$coupost = clean($_POST["coupost"]);
                $statepost = clean($_POST["statepost"]);
                $citypost = clean($_POST["citypost"]);
                $zippost = clean($_POST["zippost"]);
                $status = clean($_POST["status"]);
                $price = clean($_POST["price"]);
                $price = str_replace(",",".",$price);
                $iseller = clean($_POST["seller"]);
                $isellerprc = clean($_POST["sellerprc"]);
                $isellerprc = str_replace(",",".",$isellerprc);
				if ($content != "" && $spliter != "" && $numpost != "" && $monpost != "" && $yeapost != "")
				{
					$cardField = explode($spliter, $content);
					if ($numpost < 1 || ($cvvpost < 1 && $cvvpost != "") || $monpost < 1 || $yeapost < 1 || ($coupost < 1 && $coupost != ""))
					{
						echo "<center><font color='#ff0000'>Please give correct position</font></center>";
					}
					else if (count($cardField) >= 4 && count($cardField) >= $numpost && (count($cardField) >= $cvvpost || $cvvpost == "") && count($cardField) >= $monpost && count($cardField) >= $yeapost && (count($cardField) >= $coupost || $coupost == ""))
					{
						$cardNumber = clean($cardField[$numpost - 1]);
						$cardMonth = clean($cardField[$monpost - 1]);
						$cardYear = clean($cardField[$yeapost - 1]);
						if ($monpost == $yeapost)
						{
							if (strlen($cardMonth) == 5 || strlen($cardMonth) == 3)
							{
								$cardMonth = substr($cardMonth, 0, 1);
							}
							else
							{
								$cardMonth = substr($cardMonth, 0, 2);
							}
							$cardYear = substr($cardYear, -2, 2);
						}
						if (strlen($cardMonth) < 2)
						{
							$cardMonth = "0".$cardMonth;
						}
						if (strlen($cardYear) < 2)
						{
							$cardYear = "200".$cardYear;
						}
						else if (strlen($cardYear) < 3)
						{
							$cardYear = "20".$cardYear;
						}
						if ($cvvpost != "")
						{
							$cardCvv = clean($cardField[$cvvpost - 1]);
						}
						else
						{
							$cardCvv = "";
						}
						if ($coupost != "")
						{
							$cardCountry = clean($cardField[$coupost - 1]);
						}
						else
						{
										$cardCountry = "-";
									}
                                    if ($statepost != "")
									{
										$CardState = clean($cardField[$statepost - 1]);
									}
									else
									{
										$CardState = "-";
									}
                                    if ($citypost != "")
									{
										$CardCity = clean($cardField[$citypost - 1]);
									}
									else
									{
										$CardCity = "-";
									}
                                    if ($zippost != "")
									{
										$CardZip = clean($cardField[$zippost - 1]);
									}
									else
									{
										$CardZip = "-";
									}
						$sql = "UPDATE " . $config["table_cards"] . " SET cardContent = AES_ENCRYPT('$content', '$config[encode_key]'), cardNum = '$cardNumber', cardMon = '$cardMonth', cardYea = '$cardYear', cardCvv = '$cardCvv', cardCou = '$cardCountry', CardState = '$CardState', CardCity = '$CardCity', CardZip = '$CardZip', cardNumPost = '$numpost', cardMonPost = '$monpost', cardYeaPost = '$yeapost', cardCvvPost = '$cvvpost', cardCouPost = '$coupost', CardStatePost = '$statepost', CardCityPost = '$citypost', CardZipPost = '$zippost', cardUsed = '$used', price = '$price', categoryId = '$category', status = '$status', seller = '$iseller', sellerprc = '$isellerprc' WHERE cardId = '$id'";
						$result = mysql_query($sql, $data_sql);
						if ($result)
						{
							echo "updated";
						}
						else
						{
							echo sql_error();
						}
					}
					else
					{
						echo "<center><font color='#ff0000'>Line error</font></center>";
					}
				}
				else
				{
					echo "<center><font color='#ff0000'>Please fill all field requires (*)</font></center>";
				}
			}
			else
			{
				$sql = "SELECT * FROM " . $config['table_categorys'] . " ORDER BY categoryId";
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
				$sql = "SELECT *, AES_DECRYPT(cardContent, '$config[encode_key]') as cardContent from " . $config["table_cards"] . " WHERE cardId = '$cardid'";
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
                echo $twig->render('admin/elements/cardedit.tpl', array(
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
			$sql = "DELETE from " . $config["table_cards"] . " WHERE cardId = '$cardid'";
			$result = mysql_query($sql, $data_sql);
			if ($result)
			{
				header("location: card.php");
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
				$spliter = clean($_POST["spliter"]);
				$numpost = clean($_POST["numpost"]);
				$monpost = clean($_POST["monpost"]);
				$yeapost = clean($_POST["yeapost"]);
				$cvvpost = clean($_POST["cvvpost"]);
				$coupost = clean($_POST["coupost"]);
				//$coupost = clean($countrypost);
                $statepost = clean($_POST["statepost"]);
                $citypost = clean($_POST["citypost"]);
                $zippost = clean($_POST["zippost"]);
                $iseller = clean($_POST["seller"]);
                $isellerprc = clean($_POST["sellerprc"]);
                $isellerprc = str_replace(",",".",$isellerprc);
                $norefund = clean($_POST["norefund"]);
				$checkcard = '0';
				/*
				if ($listcard != "" && $category != "" && $spliter != "" && $numpost != "" && $monpost != "" && $yeapost != "")
				{
				$separa = explode("\n", $listcard);
				//$cc = $separa[0];
						foreach ($separa as $k => $v)
						{
							if (strlen($v) > 20)
							{
								$cardField = explode($spliter, $v);
								if (count($cardField) >= 4 && count($cardField) >= $numpost && (count($cardField) >= $cvvpost || $cvvpost == "") && count($cardField) >= $monpost && count($cardField) >= $yeapost && (count($cardField) >= $coupost || $coupost == ""))
								{
									$cardNumber = clean($cardField[$numpost - 1]
									);
									//$cc = json_encode($cardNumber);
									//print_r($cc)."\n";
								}

				$bindata = substr($cardNumber, 0, 6);
				//var_dump($bindata)."\n";
				$urls = "https://vhimne.com/chk/Braintree/bin.php?bin=$bindata";
				$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "$urls");
			curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$fim = curl_exec($ch);
				$location = json_decode(trim(strip_tags($fim)), true);
				$countrypost = $location['country']['name'];
				//var_dump($location)."\n";
				//echo $countrypost."\n";
                }
			}
				}
		*/
				if ($listcard != "" && $category != "" && $spliter != "" && $numpost != "" && $monpost != "" && $yeapost != "")
				{
					if ($numpost < 1 || ($cvvpost < 1 && $cvvpost != "") || $monpost < 1 || $yeapost < 1 || ($coupost < 1 && $coupost != ""))
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
								if (count($cardField) >= 4 && count($cardField) >= $numpost && (count($cardField) >= $cvvpost || $cvvpost == "") && count($cardField) >= $monpost && count($cardField) >= $yeapost && (count($cardField) >= $coupost || $coupost == ""))
								{
									$cardNumber = clean($cardField[$numpost - 1]);
									
									$cardMonth = clean($cardField[$monpost - 1]);
									$cardYear = clean($cardField[$yeapost - 1]);
									if ($monpost == $yeapost)
									{
										if (strlen($cardMonth) == 5 || strlen($cardMonth) == 3)
										{
											$cardMonth = substr($cardMonth, 0, 1);
										}
										else
										{
											$cardMonth = substr($cardMonth, 0, 2);
										}
										$cardYear = substr($cardYear, -2, 2);
									}
									if (strlen($cardMonth) < 2)
									{
										$cardMonth = "0".$cardMonth;
									}
									if (strlen($cardYear) < 2)
									{
										$cardYear = "200".$cardYear;
									}
									else if (strlen($cardYear) < 3)
									{
										$cardYear = "20".$cardYear;
									}
									if ($cvvpost != "")
									{
										$cardCvv = clean($cardField[$cvvpost - 1]);
									}
									else
									{
										$cardCvv = "";
									}
									if ($coupost != "")
									{
										$cardCountry = clean($cardField[$coupost - 1]);
										//$cardCountry = clean($countrypost);
									}
									else
									{
										$cardCountry = "-";
									}
                                    if ($statepost != "")
									{
										$CardState = clean($cardField[$statepost - 1]);
									}
									else
									{
										$CardState = "-";
									}
                                    if ($citypost != "")
									{
										$CardCity = clean($cardField[$citypost - 1]);
									}
									else
									{
										$CardCity = "-";
									}
                                    if ($zippost != "")
									{
										$CardZip = clean($cardField[$zippost - 1]);
									}
									else
									{
										$CardZip = "-";
									}
									if ($checkcard == '1')
									{
										$respond = checkCard($cardNumber, $cardMonth, $cardYear, $cardCvv);
									}
									else
									{
										$respond = 1;
									}
									if ($respond == 1)
									{
										$sql = "SELECT cardId FROM " . $config["table_cards"] . " WHERE AES_DECRYPT(cardContent, '$config[encode_key]') like '%" . clean($cardField[$numpost - 1]) . "%'";
										$result = mysql_query($sql, $data_sql);
										if ($result)
										{
											if (mysql_num_rows($result) >= 1)
											{
												echo "<font color='#ff0000'>Line ".($k+1).": $v => Duplicate in database</font><br />";
														    echo $save."\n";

											}
											else
											{
												$v = clean($v);
												$sql = "INSERT INTO " . $config["table_cards"] . " (categoryId, cardContent, cardNum, cardMon, cardYea, cardCvv, cardCou, CardState, CardCity, CardZip, cardSpliter, cardNumPost, cardMonPost, cardYeaPost, cardCvvPost, cardCouPost, CardStatePost, CardCityPost, CardZipPost, seller, sellerprc, status) VALUES ('$category', AES_ENCRYPT('$v', '$config[encode_key]'), '$cardNumber', '$cardMonth', '$cardYear', '$cardCvv', '$cardCountry', '$CardState', '$CardCity', '$CardZip', '$spliter', '$numpost', '$monpost', '$yeapost', '$cvvpost', '$coupost', '$statepost', '$citypost', '$zippost', '$iseller', '$isellerprc', '$norefund')";
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
				$sql = "SELECT * FROM " . $config['table_categorys'] . " ORDER BY categoryId";
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
                echo $twig->render('admin/elements/cardadd.tpl', array(
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
				$binSearch .= " AND CardZip like '".substr(clean($_GET[zip]), 0, 7)."%'";
			}
			else
			{
				$binSearch .= "";
			}
			if (isset($_GET["country"]) && strlen($_GET["country"]) > 0)
			{
			    $inscountry = clean($_GET["country"]);
				$binSearch .= " AND cardCou like '".clean($_GET[country])."%'";
			}
            else
			{
				$inscountry = '0';
			}
            if (isset($_GET["state"]) && strlen($_GET["state"]) > 0)
			{
				$insstate = clean($_GET["state"]);
				$binSearch .= " AND CardState like '".clean($_GET[state])."%'";
			}
            else
			{
				$insstate = '0';
			}
			if (isset($_GET["city"]) && strlen($_GET["city"]) > 0)
			{
				$inscity = clean($_GET["city"]);
				$binSearch .= " AND CardCity like '".clean($_GET[city])."%'";
			}
            else
			{
				$inscity = '0';
			}
			if (isset($_GET["type"]) && strlen($_GET["type"]) > 0)
			{
				$instype0 = clean($_GET["type"]);
				$instype = substr($instype0, 0, 1);
				$binSearch .= " AND cardNum like '".clean($instype)."%'";
			}
            else
			{
				$instype = '0';
			}
            
			$ordercardby = "ASC";
            //TEST COUNTRY
            if ($categoryId == '0'){
            $sql = "SELECT cardCou, COUNT(cardCou) AS count FROM " . $config['table_cards'] . " GROUP BY cardCou ORDER BY count DESC";
            } else {
            $sql = "SELECT cardCou, COUNT(cardCou) AS count FROM " . $config['table_cards'] . " WHERE categoryid = '$categoryId' GROUP BY cardCou ORDER BY count DESC";
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
            //TEST STATE
            if ($categoryId == '0' and $inscountry == '0'){
            $sql = "SELECT CardState, COUNT(CardState) AS count FROM " . $config['table_cards'] . " GROUP BY CardState ORDER BY count DESC";
            }
            else if ($categoryId == '0' and $inscountry != '0'){
            $sql = "SELECT CardState, COUNT(CardState) AS count FROM " . $config['table_cards'] . " WHERE cardCou = '$inscountry' GROUP BY CardState ORDER BY count DESC";
            } 
            else if($categoryId != '0' and $inscountry != '0'){
            $sql = "SELECT CardState, COUNT(CardState) AS count FROM " . $config['table_cards'] . " WHERE categoryid = '$categoryId' AND cardCou = '$inscountry' GROUP BY CardState ORDER BY count DESC";
            }
            else {
            $sql = "SELECT CardState, COUNT(CardState) AS count FROM " . $config['table_cards'] . " WHERE categoryid = '$categoryId' GROUP BY CardState ORDER BY count DESC";
            }
            $result = mysql_query($sql,$data_sql);
            
			if (!$result)
			{
				echo sql_error();
			}
			else
			{
				while ($state = mysql_fetch_assoc($result))
				{
					$liststate[] = $state;
				}
			}
            //TEST STATE
            //TEST city
			if ($categoryId == '0' and $inscountry == '0' and $insstate == '0'){
            $sql = "SELECT CardCity, COUNT(CardCity) AS count FROM " . $config['table_cards'] . " GROUP BY CardCity ORDER BY count DESC";
            }
            else if ($categoryId == '0' and $inscountry != '0' and $insstate == '0'){
            $sql = "SELECT CardCity, COUNT(CardCity) AS count FROM " . $config['table_cards'] . " WHERE cardCou = '$inscountry' GROUP BY CardCity ORDER BY count DESC";    
            }
            else if ($categoryId == '0' and $inscountry != '0' and $insstate != '0'){
            $sql = "SELECT CardCity, COUNT(CardCity) AS count FROM " . $config['table_cards'] . " WHERE cardCou = '$inscountry' AND CardState = '$insstate' GROUP BY CardCity ORDER BY count DESC";    
            }
            else if ($categoryId == '0' and $inscountry == '0' and $insstate != '0'){
            $sql = "SELECT CardCity, COUNT(CardCity) AS count FROM " . $config['table_cards'] . " WHERE CardState = '$insstate' GROUP BY CardCity ORDER BY count DESC";    
            }
            else if ($categoryId != '0' and $inscountry != '0' and $insstate == '0'){
            $sql = "SELECT CardCity, COUNT(CardCity) AS count FROM " . $config['table_cards'] . " WHERE categoryid = '$categoryId' AND cardCou = '$inscountry' GROUP BY CardCity ORDER BY count DESC";    
            }
            else if ($categoryId != '0' and $inscountry != '0' and $insstate != '0'){
            $sql = "SELECT CardCity, COUNT(CardCity) AS count FROM " . $config['table_cards'] . " WHERE categoryid = '$categoryId' AND cardCou = '$inscountry' AND CardState = '$insstate' GROUP BY CardCity ORDER BY count DESC";    
            }
            else if ($categoryId != '0' and $inscountry == '0' and $insstate != '0'){
            $sql = "SELECT CardCity, COUNT(CardCity) AS count FROM " . $config['table_cards'] . " WHERE categoryid = '$categoryId' AND CardState = '$insstate' GROUP BY CardCity ORDER BY count DESC";    
            }
             else {
            $sql = "SELECT CardCity, COUNT(CardCity) AS count FROM " . $config['table_cards'] . " WHERE categoryid = '$categoryId' GROUP BY CardCity ORDER BY count DESC";
            }
            $result = mysql_query($sql,$data_sql);
            
			if (!$result)
			{
				echo sql_error();
			}
			else
			{
				while ($city = mysql_fetch_assoc($result))
				{
					$listcity[] = $city;
				}
			}
            //TEST city
			$sql = "SELECT cardId FROM " . $config['table_cards'] . " LEFT JOIN " . $config['table_users'] . " ON " . $config['table_cards'] . ".cardUsed = " . $config['table_users'] . ".userId";
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
				$sql .= " AND cardUsed <> '0'";
			}
			else
			{
				$showused = "no";
				$sql .= " AND cardUsed = '0'";
			}
			$sql .= " $binSearch ORDER BY cardId $ordercardby";
			$result = mysql_query($sql,$data_sql);
			if (!$result)
			{
				echo sql_error();
			}
			else
			{
				$totalCards = mysql_num_rows($result);
			}
			$sql = "SELECT categoryId,categoryName FROM " . $config['table_categorys'] . " ORDER BY categoryId";
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
			if (isset($_GET["perpage"]) && in_array($_GET["perpage"], array(50, 100)))
			{
				$cardPerPage = clean($_GET["perpage"]);
			}
			else
			{
				$cardPerPage = 50;
			}
			$currentCard = ($currentPage - 1) * $cardPerPage;
			$sql = "SELECT *, AES_DECRYPT(cardContent, '$config[encode_key]') as cardContent FROM " . $config['table_cards'] . " LEFT JOIN " . $config['table_users'] . " ON " . $config['table_cards'] . ".cardUsed = " . $config['table_users'] . ".userId LEFT JOIN " . $config['table_categorys'] . " ON " . $config['table_cards'] . ".categoryId = " . $config['table_categorys'] . ".categoryId ";
			if ($categoryId != 0)
			{
				$sql .= " WHERE " . $config['table_cards'] . ".categoryId = '$categoryId'";
			}
			else
			{
				$sql .= " WHERE 1";
			}
			if ($_GET["showused"] == "yes")
			{
				$showused = "yes";
				$sql .= " AND cardUsed <> '0'";
			}
			else if ($_GET["showused"] == "no")
			{
				$showused = "no";
				$sql .= " AND cardUsed = '0'";
			}
			else
			{
				$showused = "all";
			}
			$sql .= " $binSearch ORDER BY cardId $ordercardby LIMIT $currentCard,$cardPerPage";
			$result = mysql_query($sql, $data_sql);
			if ($result)
			{
                
				$msgHtml .= "<table class='table table-striped table-bordered table-hover'>";
				$msgHtml .= "<tr><td><b>Id</b></td><td><b>Type</b></td><td><b>Bin</b></td><td><b>Exp Date</b></td><td><b>Category</b></td><td><b>Country</b></td><td><b>State</b></td><td><b>City</b></td><td><b>Zip</b></td><td><b>User</b></td><td><b>Status</b></td><td><b>Action</b></td></tr>";
				$count = mysql_num_rows($result);
				if ($count >= 1)
				{   
				    $found = '1';
					while ($card = mysql_fetch_assoc($result))
					{
						if ($card[username] == "")
						{
							$card[username] = "None";
						}
						$listCard[] = $card;
					}
				}
				else
				{
					$found = '0';
				}
                echo $twig->render('admin/card.tpl', array(
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
                        'listCard' => $listCard,
                        'currentPage' => $currentPage,
                        'showused' => $showused,
                        'pages' => ceil($totalCards / $cardPerPage)));
			}
			else
			{
				echo sql_error();
			}
		}
	}
	db_close();
?>