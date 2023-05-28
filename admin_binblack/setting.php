<?php
	set_time_limit(0);
	session_start();
	include_once("../includes/global.php");
	db_connection();
	$act = clean($_GET["act"]);
	if (!is_login_admin())
	{
		header("location: login.php");
	}
	else
	{
		if (isset($_POST["save"]))
		{
			$sql = "SELECT * from " . $config["table_settings"];
			$result = mysql_query($sql, $data_sql);
			if ($result)
			{
				$listSetting = array();
				while ($setting = mysql_fetch_assoc($result))
				{
					$listSetting[] = $setting;
				}
				if (is_array($listSetting))
				{
					foreach ($listSetting as &$setting)
					{
						$setting[settingValue] = clean($_POST[$setting[settingName]]);
					}
					foreach ($listSetting as &$setting)
					{  if ($setting[settingValue] != ''){
						$sql = "UPDATE " . $config["table_settings"] . " SET settingValue = '".$setting[settingValue]."' WHERE settingId = '".$setting[settingId]."'";
						$result = mysql_query($sql, $data_sql);
						if (!$result)
						{
							echo sql_error();
						}
                        }
					}
					echo '<font color="#099668"><center><strong>Saved setting successful</strong></center></font>';
				}
				else
				{
					die("<script>alert('Error, please contact webmaster for more information.');</script>");
				}
			}
			else
			{
				echo sql_error();
			}
		}
		else
		{
			$sql = "SELECT * from " . $config["table_settings"];
			$result = mysql_query($sql, $data_sql);
			if ($result)
			{
			    $msgHtml = '<div class="page-header"><h1>Setting<small> Edit settings</small></h1></div></div></div>';
				$listSetting = array();
				while ($setting = mysql_fetch_assoc($result))
				{
					$listSetting[] = $setting;
				}
				if (is_array($listSetting))
				{
					foreach ($listSetting as $setting)
					{  
					   if ($setting[settingName] == 'SiteName'){
					       $general1 .= "<tr><td>".$setting[settingInfo]."</td><td><input class='form-control' name='".$setting[settingName]."' value='".$setting[settingValue]."' /></td></tr>";
                            }
                       else if ($setting[settingName] == 'homeUrl'){
					       $general2 .= "<tr><td>".$setting[settingInfo]."</td><td><input class='form-control' name='".$setting[settingName]."' value='".$setting[settingValue]."' /></td></tr>";
                            }
                       else if ($setting[settingName] == 'adminEmail'){
					       $general3 .= "<tr><td>".$setting[settingInfo]."</td><td><input class='form-control' name='".$setting[settingName]."' value='".$setting[settingValue]."' /></td></tr>";
                            }
                       else if ($setting[settingName] == 'themeadmin' ||  $setting[settingName] == 'themeusr'){
					       if ($setting[settingValue] == 'theme_navy.css')
					        {   
					           $design .= "<tr><td class='tdCol'>".$setting[settingInfo]."</td><td><select name='".$setting[settingName]."' class='form-control'><option value='theme_navy.css' selected=''>Navy</option><option value='theme_light.css'>Light</option><option value='theme_dark.css'>Dark</option><option value='theme_black_and_white.css'>Black&White</option><option value='theme_green.css'>Green</option><option value='theme_grey_red.css'>Grey&Red</option><option value='theme_grey_blue.css'>Grey&Blue</option><option value='theme_grey_green.css'>Grey&Green</option><option value='theme_black_green.css'>Black&Green</option><option value='theme_black_blue.css'>Black&Blue</option><option value='theme_black_red.css'>Black&Red</option></select></td></tr>";
					       }
                           else if ($setting[settingValue] == 'theme_light.css')
					        {   
					           $design .= "<tr><td class='tdCol''>".$setting[settingInfo]."</td><td><select name='".$setting[settingName]."' class='form-control'><option value='theme_navy.css' >Navy</option><option value='theme_light.css' selected=''>Light</option><option value='theme_dark.css'>Dark</option><option value='theme_black_and_white.css'>Black&White</option><option value='theme_green.css'>Green</option><option value='theme_grey_red.css'>Grey&Red</option><option value='theme_grey_blue.css'>Grey&Blue</option><option value='theme_grey_green.css'>Grey&Green</option><option value='theme_black_green.css'>Black&Green</option><option value='theme_black_blue.css'>Black&Blue</option><option value='theme_black_red.css'>Black&Red</option></select></td></tr>";
					       }
                           else if ($setting[settingValue] == 'theme_dark.css')
					        {   
					           $design .= "<tr><td class='tdCol''>".$setting[settingInfo]."</td><td><select name='".$setting[settingName]."' class='form-control'><option value='theme_navy.css' >Navy</option><option value='theme_light.css'>Light</option><option value='theme_dark.css' selected=''>Dark</option><option value='theme_black_and_white.css'>Black&White</option><option value='theme_green.css'>Green</option><option value='theme_grey_red.css'>Grey&Red</option><option value='theme_grey_blue.css'>Grey&Blue</option><option value='theme_grey_green.css'>Grey&Green</option><option value='theme_black_green.css'>Black&Green</option><option value='theme_black_blue.css'>Black&Blue</option><option value='theme_black_red.css'>Black&Red</option></select></td></tr>";
					       }
                           else if ($setting[settingValue] == 'theme_black_and_white.css')
					        {   
					           $design .= "<tr><td class='tdCol''>".$setting[settingInfo]."</td><td><select name='".$setting[settingName]."' class='form-control'><option value='theme_navy.css' >Navy</option><option value='theme_light.css'>Light</option><option value='theme_dark.css'>Dark</option><option value='theme_black_and_white.css' selected=''>Black&White</option><option value='theme_green.css'>Green</option><option value='theme_grey_red.css'>Grey&Red</option><option value='theme_grey_blue.css'>Grey&Blue</option><option value='theme_grey_green.css'>Grey&Green</option><option value='theme_black_green.css'>Black&Green</option><option value='theme_black_blue.css'>Black&Blue</option><option value='theme_black_red.css'>Black&Red</option></select></td></tr>";
					       }
                           else if ($setting[settingValue] == 'theme_green.css')
					        {   
					           $design .= "<tr><td class='tdCol''>".$setting[settingInfo]."</td><td><select name='".$setting[settingName]."' class='form-control'><option value='theme_navy.css' >Navy</option><option value='theme_light.css'>Light</option><option value='theme_dark.css'>Dark</option><option value='theme_black_and_white.css'>Black&White</option><option value='theme_green.css' selected=''>Green</option><option value='theme_grey_red.css'>Grey&Red</option><option value='theme_grey_blue.css'>Grey&Blue</option><option value='theme_grey_green.css'>Grey&Green</option><option value='theme_black_green.css'>Black&Green</option><option value='theme_black_blue.css'>Black&Blue</option><option value='theme_black_red.css'>Black&Red</option></select></td></tr>";
					       }
                           else if ($setting[settingValue] == 'theme_grey_red.css')
					        {   
					           $design .= "<tr><td class='tdCol''>".$setting[settingInfo]."</td><td><select name='".$setting[settingName]."' class='form-control'><option value='theme_navy.css' >Navy</option><option value='theme_light.css'>Light</option><option value='theme_dark.css'>Dark</option><option value='theme_black_and_white.css'>Black&White</option><option value='theme_green.css'>Green</option><option value='theme_grey_red.css' selected=''>Grey&Red</option><option value='theme_grey_blue.css'>Grey&Blue</option><option value='theme_grey_green.css'>Grey&Green</option><option value='theme_black_green.css'>Black&Green</option><option value='theme_black_blue.css'>Black&Blue</option><option value='theme_black_red.css'>Black&Red</option></select></td></tr>";
					       }
                           else if ($setting[settingValue] == 'theme_grey_blue.css')
					        {   
					           $design .= "<tr><td class='tdCol''>".$setting[settingInfo]."</td><td><select name='".$setting[settingName]."' class='form-control'><option value='theme_navy.css' >Navy</option><option value='theme_light.css'>Light</option><option value='theme_dark.css'>Dark</option><option value='theme_black_and_white.css'>Black&White</option><option value='theme_green.css'>Green</option><option value='theme_grey_red.css'>Grey&Red</option><option value='theme_grey_blue.css' selected=''>Grey&Blue</option><option value='theme_grey_green.css'>Grey&Green</option><option value='theme_black_green.css'>Black&Green</option><option value='theme_black_blue.css'>Black&Blue</option><option value='theme_black_red.css'>Black&Red</option></select></td></tr>";
					       }
                           else if ($setting[settingValue] == 'theme_grey_green.css')
					        {   
					           $design .= "<tr><td class='tdCol''>".$setting[settingInfo]."</td><td><select name='".$setting[settingName]."' class='form-control'><option value='theme_navy.css' >Navy</option><option value='theme_light.css'>Light</option><option value='theme_dark.css'>Dark</option><option value='theme_black_and_white.css'>Black&White</option><option value='theme_green.css'>Green</option><option value='theme_grey_red.css'>Grey&Red</option><option value='theme_grey_blue.css'>Grey&Blue</option><option value='theme_grey_green.css' selected=''>Grey&Green</option><option value='theme_black_green.css'>Black&Green</option><option value='theme_black_blue.css'>Black&Blue</option><option value='theme_black_red.css'>Black&Red</option></select></td></tr>";
					       }
                           else if ($setting[settingValue] == 'theme_black_green.css')
					        {   
					           $design .= "<tr><td class='tdCol''>".$setting[settingInfo]."</td><td><select name='".$setting[settingName]."' class='form-control'><option value='theme_navy.css' >Navy</option><option value='theme_light.css'>Light</option><option value='theme_dark.css'>Dark</option><option value='theme_black_and_white.css'>Black&White</option><option value='theme_green.css'>Green</option><option value='theme_grey_red.css'>Grey&Red</option><option value='theme_grey_blue.css'>Grey&Blue</option><option value='theme_grey_green.css'>Grey&Green</option><option value='theme_black_green.css' selected=''>Black&Green</option><option value='theme_black_blue.css'>Black&Blue</option><option value='theme_black_red.css'>Black&Red</option></select></td></tr>";
					       }
                           else if ($setting[settingValue] == 'theme_black_blue.css')
					        {   
					           $design .= "<tr><td class='tdCol''>".$setting[settingInfo]."</td><td><select name='".$setting[settingName]."' class='form-control'><option value='theme_navy.css' >Navy</option><option value='theme_light.css'>Light</option><option value='theme_dark.css'>Dark</option><option value='theme_black_and_white.css'>Black&White</option><option value='theme_green.css'>Green</option><option value='theme_grey_red.css'>Grey&Red</option><option value='theme_grey_blue.css'>Grey&Blue</option><option value='theme_grey_green.css'>Grey&Green</option><option value='theme_black_green.css'>Black&Green</option><option value='theme_black_blue.css' selected=''>Black&Blue</option><option value='theme_black_red.css'>Black&Red</option></select></td></tr>";
					       }
                           else if ($setting[settingValue] == 'theme_black_red.css')
					        {   
					           $design .= "<tr><td class='tdCol''>".$setting[settingInfo]."</td><td><select name='".$setting[settingName]."' class='form-control'><option value='theme_navy.css' >Navy</option><option value='theme_light.css'>Light</option><option value='theme_dark.css'>Dark</option><option value='theme_black_and_white.css'>Black&White</option><option value='theme_green.css'>Green</option><option value='theme_grey_red.css'>Grey&Red</option><option value='theme_grey_blue.css'>Grey&Blue</option><option value='theme_grey_green.css'>Grey&Green</option><option value='theme_black_green.css' >Black&Green</option><option value='theme_black_blue.css'>Black&Blue</option><option value='theme_black_red.css' selected=''>Black&Red</option></select></td></tr>";
					       }
                            else 
                           {
                               $design .= "<tr><td class='tdCol'>".$setting[settingInfo]."</td><td><select name='".$setting[settingName]."' class='form-control'><option value='theme_navy.css' selected=''>Navy</option><option value='theme_light.css'>Light</option><option value='theme_dark.css'>Dark</option><option value='theme_black_and_white.css'>Black&White</option><option value='theme_green.css'>Green</option><option value='theme_grey_red.css'>Grey&Red</option><option value='theme_grey_blue.css'>Grey&Blue</option><option value='theme_grey_green.css'>Grey&Green</option><option value='theme_black_green.css'>Black&Green</option><option value='theme_black_blue.css'>Black&Blue</option><option value='theme_black_red.css'>Black&Red</option></select></td></tr>";
                           }
                           }
                       else if ($setting[settingName] == 'logo'){
					       $design2 .= "<tr><td>".$setting[settingInfo]."</td><td><input class='form-control' name='".$setting[settingName]."' value='".$setting[settingValue]."' /></td></tr>";
                            }
                       else if ($setting[settingName] == 'mindeposit'){
					       $payment0 .= "<tr><td>".$setting[settingInfo]."</td><td><input class='form-control' name='".$setting[settingName]."' value='".$setting[settingValue]."' /></td></tr>";
                            }
                       else if ($setting[settingName] == 'btcdeposit'){
					       if ($setting[settingValue] == '1')
                           {
					       $payment1 .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='1' selected=''>ON</option><option value='0'>OFF</option></select></td></tr>";
                           }
                           else if ($setting[settingValue] == '0')
                           {
					       $payment1 .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='0' selected=''>OFF</option><option value='1'>ON</option></select></td></tr>";
                           } else 
                           {
                           $payment1 .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='1' selected=''>ON</option><option value='0'>OFF</option></select></td></tr>"; 
                           }
                           }
                        else if ($setting[settingName] == 'btcspeed'){
					       if ($setting[settingValue] == '1')
                           {
					       $payment1 .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='1' selected=''>ON</option><option value='0'>OFF</option></select></td></tr>";
                           }
                           else if ($setting[settingValue] == '0')
                           {
					       $payment1 .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='0' selected=''>OFF</option><option value='1'>ON</option></select></td></tr>";
                           } else {
                           $payment1 .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='1' selected=''>ON</option><option value='0'>OFF</option></select></td></tr>"; 
                           }
                           }
                        else if ($setting[settingName] == 'btconfirm'){
					       $payment1 .= "<tr><td>".$setting[settingInfo]."</td><td><input class='form-control' name='".$setting[settingName]."' value='".$setting[settingValue]."' /></td></tr>";
                            }
                        else if ($setting[settingName] == 'bcguid'){
					       $payment1 .= "<tr><td>".$setting[settingInfo]."</td><td><input class='form-control' name='".$setting[settingName]."' value='".$setting[settingValue]."' /></td></tr>";
                            }
                        else if ($setting[settingName] == 'bcmainpass'){
					       $payment1 .= "<tr><td>".$setting[settingInfo]."</td><td><input class='form-control' name='".$setting[settingName]."' value='".$setting[settingValue]."' /></td></tr>";
                            }
                        else if ($setting[settingName] == 'blockchain_root'){
					       $payment2 .= "<tr><td>".$setting[settingInfo]."</td><td><input class='form-control' name='".$setting[settingName]."' value='".$setting[settingValue]."' /></td></tr>";
                            }
                        else if ($setting[settingName] == 'my_bitcoin_address'){
					       $payment3 .= "<tr><td>".$setting[settingInfo]."</td><td><input class='form-control' name='".$setting[settingName]."' value='".$setting[settingValue]."' /></td></tr>";
                            }
                        else if ($setting[settingName] == 'blockchain_secret'){
					       $payment4 .= "<tr><td>".$setting[settingInfo]."</td><td><input class='form-control' name='".$setting[settingName]."' value='".$setting[settingValue]."' /></td></tr>";
                            }
                        else if ($setting[settingName] == 'pmdeposit'){
					       if ($setting[settingValue] == '1')
                           {
					       $payment5 .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='1' selected=''>ON</option><option value='0'>OFF</option></select></td></tr>";
                           }
                           else if ($setting[settingValue] == '0')
                           {
					       $payment5 .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='0' selected=''>OFF</option><option value='1'>ON</option></select></td></tr>";
                           } else {
                           $payment5 .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='1' selected=''>ON</option><option value='0'>OFF</option></select></td></tr>"; 
                           }
                           }
                        else if ($setting[settingName] == 'currency_code'){
					       $payment6 .= "<tr><td>".$setting[settingInfo]."</td><td><input class='form-control' name='".$setting[settingName]."' value='".$setting[settingValue]."' /></td></tr>";
                            }
                        else if ($setting[settingName] == 'currency_symb'){
					       $payment7 .= "<tr><td>".$setting[settingInfo]."</td><td><input class='form-control' name='".$setting[settingName]."' value='".$setting[settingValue]."' /></td></tr>";
                            }
                        else if ($setting[settingName] == 'merchant'){
					       $payment8 .= "<tr><td>".$setting[settingInfo]."</td><td><input class='form-control' name='".$setting[settingName]."' value='".$setting[settingValue]."' /></td></tr>";
                            }
                        else if ($setting[settingName] == 'storename'){
					       $payment9 .= "<tr><td>".$setting[settingInfo]."</td><td><input class='form-control' name='".$setting[settingName]."' value='".$setting[settingValue]."' /></td></tr>";
                            }
                        else if ($setting[settingName] == 'securityword'){
					       $payment10 .= "<tr><td>".$setting[settingInfo]."</td><td><input class='form-control' name='".$setting[settingName]."' value='".$setting[settingValue]."' /></td></tr>";
                            }
                        else if ($setting[settingName] == 'securityword'){
					       $payment10 .= "<tr><td>".$setting[settingInfo]."</td><td><input class='form-control' name='".$setting[settingName]."' value='".$setting[settingValue]."' /></td></tr>";
                            }
                        else if ($setting[settingName] == 'UMERCH'){
					       $payment10 .= "<tr><td>".$setting[settingInfo]."</td><td><input class='form-control' name='".$setting[settingName]."' value='".$setting[settingValue]."' /></td></tr>";
                            }
						else if ($setting[settingName] == 'UPASS'){
							$payment10 .= "<tr><td>".$setting[settingInfo]."</td><td><input class='form-control' name='".$setting[settingName]."' value='".$setting[settingValue]."' /></td></tr>";
						}
						else if ($setting[settingName] == 'UPMUSD'){
							if ($setting[settingValue] == '1')
							{
								$payment10 .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='1' selected=''>ON</option><option value='0'>OFF</option></select></td></tr>";
							}
							else if ($setting[settingValue] == '0')
							{
								$payment10 .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='0' selected=''>OFF</option><option value='1'>ON</option></select></td></tr>";
							} else {
								$payment10 .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='1' selected=''>ON</option><option value='0'>OFF</option></select></td></tr>"; 
							}
						}
						else if ($setting[settingName] == 'UWMZ'){
							if ($setting[settingValue] == '1')
							{
								$payment10 .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='1' selected=''>ON</option><option value='0'>OFF</option></select></td></tr>";
							}
							else if ($setting[settingValue] == '0')
							{
								$payment10 .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='0' selected=''>OFF</option><option value='1'>ON</option></select></td></tr>";
							} else {
								$payment10 .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='1' selected=''>ON</option><option value='0'>OFF</option></select></td></tr>"; 
							}
						}
						else if ($setting[settingName] == 'UPAYMERZ'){
							if ($setting[settingValue] == '1')
							{
								$payment10 .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='1' selected=''>ON</option><option value='0'>OFF</option></select></td></tr>";
							}
							else if ($setting[settingValue] == '0')
							{
								$payment10 .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='0' selected=''>OFF</option><option value='1'>ON</option></select></td></tr>";
							} else {
								$payment10 .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='1' selected=''>ON</option><option value='0'>OFF</option></select></td></tr>"; 
							}
						}
                        else if ($setting[settingName] == 'salecc'){
					       if ($setting[settingValue] == '1')
                           {
					       $cc .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='1' selected=''>ON</option><option value='0'>OFF</option></select></td></tr>";
                           }
                           else if ($setting[settingValue] == '0')
                           {
					       $cc .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='0' selected=''>OFF</option><option value='1'>ON</option></select></td></tr>";
                           } else {
                           $cc .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='1' selected=''>ON</option><option value='0'>OFF</option></select></td></tr>"; 
                           }
                           }
                        else if ($setting[settingName] == 'Buy&Check'){
					       if ($setting[settingValue] == '1')
                           {
					       $cc2 .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='1' selected=''>ON</option><option value='0'>OFF</option></select></td></tr>";
                           }
                           else if ($setting[settingValue] == '0')
                           {
					       $cc2 .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='0' selected=''>OFF</option><option value='1'>ON</option></select></td></tr>";
                           } else {
                           $cc2 .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='1' selected=''>ON</option><option value='0'>OFF</option></select></td></tr>"; 
                           }
                           }
                        else if ($setting[settingName] == 'CCchecker'){
					       $cc3 .= "<tr><td>".$setting[settingInfo]."</td><td><input class='form-control' name='".$setting[settingName]."' value='".$setting[settingValue]."' /></td></tr>";
                            }
                        else if ($setting[settingName] == 'checktime'){
					       $cc4 .= "<tr><td>".$setting[settingInfo]."</td><td><input class='form-control' name='".$setting[settingName]."' value='".$setting[settingValue]."' /></td></tr>";
                            }
                        else if ($setting[settingName] == 'saledump'){
					       if ($setting[settingValue] == '1')
                           {
					       $dumps .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='1' selected=''>ON</option><option value='0'>OFF</option></select></td></tr>";
                           }
                           else if ($setting[settingValue] == '0')
                           {
					       $dumps .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='0' selected=''>OFF</option><option value='1'>ON</option></select></td></tr>";
                           } else {
                           $dumps .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='1' selected=''>ON</option><option value='0'>OFF</option></select></td></tr>"; 
                           }
                           }
                        else if ($setting[settingName] == 'Dump_Buy&Check'){
					       if ($setting[settingValue] == '1')
                           {
					       $dumps2 .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='1' selected=''>ON</option><option value='0'>OFF</option></select></td></tr>";
                           }
                           else if ($setting[settingValue] == '0')
                           {
					       $dumps2 .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='0' selected=''>OFF</option><option value='1'>ON</option></select></td></tr>";
                           } else {
                           $dumps2 .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='1' selected=''>ON</option><option value='0'>OFF</option></select></td></tr>"; 
                           }
                           }
                        else if ($setting[settingName] == 'dumpchecker'){
					       $dumps3 .= "<tr><td>".$setting[settingInfo]."</td><td><input class='form-control' name='".$setting[settingName]."' value='".$setting[settingValue]."' /></td></tr>";
                            }
                        else if ($setting[settingName] == 'dumpchecktime'){
					       $dumps4 .= "<tr><td>".$setting[settingInfo]."</td><td><input class='form-control' name='".$setting[settingName]."' value='".$setting[settingValue]."' /></td></tr>";
                            }
                        else if ($setting[settingName] == 'packs'){
					       if ($setting[settingValue] == '1')
                           {
					       $packs .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='1' selected=''>ON</option><option value='0'>OFF</option></select></td></tr>";
                           }
                           else if ($setting[settingValue] == '0')
                           {
					       $packs .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='0' selected=''>OFF</option><option value='1'>ON</option></select></td></tr>";
                           } else {
                           $packs .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='1' selected=''>ON</option><option value='0'>OFF</option></select></td></tr>"; 
                           }
                           }
                        else if ($setting[settingName] == 'salecheck'){
					       if ($setting[settingValue] == '1')
                           {
					       $checker .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='1' selected=''>ON</option><option value='0'>OFF</option></select></td></tr>";
                           }
                           else if ($setting[settingValue] == '0')
                           {
					       $checker .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='0' selected=''>OFF</option><option value='1'>ON</option></select></td></tr>";
                           } else {
                           $checker .= "<tr><td class='tdCol' width='150px'>".$setting[settingInfo]."</td><td class='tdCol' width='500px'><select name='".$setting[settingName]."' class='form-control'><option value='1' selected=''>ON</option><option value='0'>OFF</option></select></td></tr>"; 
                           }
                           }
                        else if ($setting[settingName] == 'CheckerPrice'){
					       $checker2 .= "<tr><td>".$setting[settingInfo]."</td><td><input class='form-control' name='".$setting[settingName]."' value='".$setting[settingValue]."' /></td></tr>";
                            }
					   }
					}
					$savebtn .= "<center><input type='button' class='btn btn-bricky' name='save' onclick=\"showpage('index.php');\" value='Cancel' /> <input type='submit' class='btn btn-green' name='save' value='Save' /></center>";
                $msgHtml .= '<div class="tabbable tabs-left">
<ul id="myTab3" class="nav nav-tabs tab-green">
<li class="active"><a href="#setting1" data-toggle="tab"><i class="pink clip-settings"></i> General/Design</a></li>
<li class=""><a href="#setting2" data-toggle="tab"><i class="blue fa fa-cogs"></i> Modules</a></li>
<li class=""><a href="#setting3" data-toggle="tab"><i class="fa fa-btc"></i> Payment</a></li>
</ul>
<div class="tab-content">
<div class="tab-pane active" id="setting1">
<form action=\'setting.php?act=edit\' method=\'POST\' target=\'result1\'>
<div class="col-sm-6"><div class="panel panel-default"><div class="panel-heading">General</div><table class="table table-bordered table-striped"><tbody><tr><th>Setting name</th><th>Setting value</th></tr>'.$general1.$general2.$general3.'</tbody></table></div></div>
<div class="col-sm-6"><div class="panel panel-default"><div class="panel-heading">Design</div><table class="table table-bordered table-striped"><tbody><tr><th>Setting name</th><th>Setting value</th></tr>'.$design.$design2.'</tbody></table></div></div>
'.$savebtn.'
<p><center><iframe name="result1" id="result1" src="" style="border:none;height:30px;" ></iframe></center><p>
</form>
</div>
<div class="tab-pane" id="setting2">
<form action=\'setting.php?act=edit\' method=\'POST\' target=\'result2\'>
<div class="col-sm-6"><div class="panel panel-default"><div class="panel-heading">Credit Cards</div><table class="table table-bordered table-striped"><tbody><tr><th>Setting name</th><th>Setting value</th></tr>'.$cc.$cc2.$cc3.$cc4.'</tbody></table></div></div>
<div class="col-sm-6"><div class="panel panel-default"><div class="panel-heading">Dumps</div><table class="table table-bordered table-striped"><tbody><tr><th>Setting name</th><th>Setting value</th></tr>'.$dumps.$dumps2.$dumps3.$dumps4.'</tbody></table></div></div>
<div class="col-sm-6"><div class="panel panel-default"><div class="panel-heading">Packs</div><table class="table table-bordered table-striped"><tbody><tr><th>Setting name</th><th>Setting value</th></tr>'.$packs.'</tbody></table></div></div>
<div class="col-sm-6"><div class="panel panel-default"><div class="panel-heading">Checker</div><table class="table table-bordered table-striped"><tbody><tr><th>Setting name</th><th>Setting value</th></tr>'.$checker.$checker2.'</tbody></table></div></div>
'.$savebtn.'
<p><center><iframe name="result2" id="result2" src="" style="border:none;height:30px;" ></iframe></center><p>
</form>
</div>
<div class="tab-pane" id="setting3">
<form action=\'setting.php?act=edit\' method=\'POST\' target=\'result3\'>
<div class="col-sm-12"><div class="panel panel-default"><div class="panel-heading">Payment</div><table class="table table-bordered table-striped"><tbody><tr><th>Setting name</th><th>Setting value</th></tr>'.$payment0.$payment1.$payment2.$payment3.$payment4.$payment5.$payment6.$payment7.$payment8.$payment9.$payment10.$payment11.$payment12.'</tbody></table></div></div>
'.$savebtn.'
<p><center><iframe name="result3" id="result3" src="" style="border:none;height:30px;" ></iframe></center><p>
</form>
</div></div></div>';
			}
			else
			{
				echo sql_error();
			}
			echo $msgHtml;
		}
	}
	db_close();
?>