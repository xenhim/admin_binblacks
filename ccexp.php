<?php

set_time_limit(0);
session_start();
include_once ("includes/global.php");
db_connection();
include_once ("checkers/" . $config['CCchecker'] . "");
if (!is_login())
{
    header("location: login.php");
} else
{
    error_reporting(1);
    $inactive = 3600;
    $clock = date('G:i d-m-Y', time() + 43200);
    set_time_limit(0);
    function getStr($string, $start, $end)
    {
        $str = explode($start, $string);
        $str = explode($end, $str[1]);
        return $str[0];
    }
    function info_bin($ccnum)
    {
        $bin = substr($ccnum, 0, 6);
        $file = file_get_contents('dbbin1/base.csv');
        $info = getStr($file, $bin, "\n");
        $info = explode(";", $info);

        $data = "<b><font color=orange>" . $info[2] . "|<font color=red> " . $info[3] . " " . $info[4] . " </font>| " . $info[5] . " " . $info[10] . "</font></b>";
        if (strlen($info[1]) < 2)
        {
            $data = '<b>Unknown Bin</b>';
        }
        return $data;
    }

    function year_convert($year_cc)
    {
        $year_now = date('Y', time());
        $i_year = (int)$year_cc - (int)$year_now;
        if ($i_year > 0)
        {
            return $i_year;
        } else
        {
            return 0;
        }
        ;
    }
    function _date($cclist)
    {
        if (!is_null($cclist))
        {
            foreach ($cclist as $cc)
            {
                $ccnum = info($cc);
                if ($ccnum)
                {
                    $_d = $ccnum['year'] . $ccnum['mon'];
                    $order[$_d][] = $cc;
                } else
                    $order['e'][] = $cc;
            }
            ksort($order);
            if (!is_null($order))
                foreach ($order as $_d)
                    foreach ($_d as $cc)
                        $ok[] = $cc;
            if (!is_null($order['e']))
                foreach ($order['e'] as $cc)
                    $ok[] = $cc;
            return $ok;
        }
    }

    function _bin($ccnum)
    {
        if (isset($_POST['bin']))
        {
            $blen = strlen($_POST['bin']);
            $bin = substr($ccnum['num'], 0, $blen);
            if ($bin == $_POST['bin'])
                return true;
            else
                return false;
        } else
            return true;
    }

    function _dup($cclist)
    {
        for ($i = 0; $i < count($cclist); $i++)
        {
            $ccnum = info($cclist[$i]);
            if ($ccnum)
            {
                $cc = $ccnum['num'];
                for ($j = $i + 1; $j < count($cclist); $j++)
                {
                    if (inStr(str_replace("-", "", str_replace(" ", "", $cclist[$j])), $cc))
                        $cclist[$j] = "";
                }
            }
        }
        foreach ($cclist as $i => $cc)
            if ($cc == "")
                unset($cclist[$i]);
        $ok = array_values($cclist);
        return $ok;
    }

    function _type($cclist)
    {
        foreach ($cclist as $cc)
        {
            $ccnum = info($cc);
            $_d = $ccnum['type'];
            switch ($_d)
            {
                case "VISA":
                    $order['v'][] = $cc;
                    break;
                case "MASTERCARD":
                    $order['m'][] = $cc;
                    break;
                case "AMEX":
                    $order['a'][] = $cc;
                    break;
                case "DISCOVER":
                    $order['d'][] = $cc;
                    break;
            }
        }
        return $order;
    }

    function info($ccline)
    {
        $xy = array(
            "|",
            "\\",
            "/",
            "-",
            ";");
        $sepe = $xy[0];
        foreach ($xy as $v)
        {
            if (substr_count($ccline, $sepe) < substr_count($ccline, $v))
                $sepe = $v;
        }
        $x = explode($sepe, $ccline);
        foreach ($xy as $y)
            $x = str_replace($y, "", str_replace(" ", "", $x));
        foreach ($x as $xx)
        {
            $xx = trim($xx);
            if (is_numeric($xx))
            {
                $yy = strlen($xx);
                switch ($yy)
                {
                    case 15:
                        if (substr($xx, 0, 1) == 3)
                        {
                            $ccnum['num'] = $xx;
                            $ccnum['type'] = "AMEX";
                        }
                        break;
                    case 16:
                        switch (substr($xx, 0, 1))
                        {
                            case '4':
                                $ccnum['num'] = $xx;
                                $ccnum['type'] = "VISA";
                                break;
                            case '5':
                                $ccnum['num'] = $xx;
                                $ccnum['type'] = "MASTERCARD";
                                break;
                            case '6':
                                $ccnum['num'] = $xx;
                                $ccnum['type'] = "DISCOVER";
                                break;
                        }
                        break;
                    case 1:
                        if (($xx >= 1) and ($xx <= 12) and (!isset($ccnum['mon'])))
                            $ccnum['mon'] = "0" . $xx;
                    case 2:
                        if (($xx >= 1) and ($xx <= 12) and (!isset($ccnum['mon'])))
                            $ccnum['mon'] = $xx;
                        elseif (($xx >= 22) and ($xx <= 29) and (isset($ccnum['mon'])) and (!isset($ccnum['year'])))
                            $ccnum['year'] = "20" . $xx;
                        break;
                    case 4:
                        if (($xx >= 2022) and ($xx <= 2029) and (isset($ccnum['mon'])))
                            $ccnum['year'] = $xx;
                        elseif ((substr($xx, 0, 2) >= 1) and (substr($xx, 0, 2) <= 12) and (substr($xx, 2, 2) >= 22) and (substr($xx, 2, 2) <= 29) and (!isset($ccnum['mon'])) and (!isset($ccnum['year'])))
                        {
                            $ccnum['mon'] = substr($xx, 0, 2);
                            $ccnum['year'] = "20" . substr($xx, 2, 2);
                        } else
                            $ccv['cv4'] = $xx;
                        break;
                    case 6:
                        if ((substr($xx, 0, 2) >= 1) and (substr($xx, 0, 2) <= 12) and (substr($xx, 2, 4) >= 2022) and (substr($xx, 2, 4) <= 2029))
                        {
                            $ccnum['mon'] = substr($xx, 0, 2);
                            $ccnum['year'] = substr($xx, 2, 4);
                        }
                        break;
                    case 3:
                        $ccv['cv3'] = $xx;
                        break;

                }
            }
        }
        if (isset($ccnum['num']) and isset($ccnum['mon']) and isset($ccnum['year']))
        {
            if ($ccnum['type'] == "AMEX")
                $ccnum['cvv'] = $ccv['cv4'];
            else
                $ccnum['cvv'] = $ccv['cv3'];
            return $ccnum;
        } else
            return false;
    }

    function percent($num_amount, $num_total)
    {
        $count1 = $num_amount / $num_total;
        $count2 = $count1 * 100;
        $count = number_format($count2, 0);
        return $count;
    }

    if ($_POST['cclist'])
    {
        $sql = "SELECT credit from " . $config["table_users"] . " WHERE userId = '" . clean($_SESSION["userId"]) . "'";
        $result = mysql_query($sql, $data_sql);
        if ($result)
        {
            $count = mysql_num_rows($result);
            if ($count == 1)
            {
                $credit = mysql_fetch_assoc($result);
                $credit = $credit["credit"];
                $checkprice = $config['CheckerPrice'];
                echo "<p><div class='col-md-12'>";
                echo "<h4>Result:</h4>";
                echo '<div class="well">';
                $antixss = htmlspecialchars($_POST['cclist']);
                $cclist = trim($antixss);
                $cclist = str_replace(array("\\\"", "\\'"), array("\"", "'"), $cclist);
                $cclist = str_replace("\n\n", "\n", $cclist);
                $cclist = explode("\n", $cclist);
                $allcheck = sizeof($cclist);
                $fullprice = $allcheck * $checkprice;
                if ($credit >= $fullprice)
                {
                    if ($_POST['dup'] == 'true')
                        $cclist = _dup($cclist);
                    $relog = 0;
                    $tongso = count($cclist);
                    foreach ($cclist as $ccline)
                    {
                        $relog++;
                        $ccnum = info($ccline);
                        if ($ccnum)
                        {
                            if (_bin($ccnum))
                            {

                                $_INFO = $ccnum['num'] . ' | ' . $ccnum['cvv'] . ' | ' . $ccnum['mon'] . ' / ' . $ccnum['year'] . ' | ' . $ccnum['type'];

                                $_bininfo = '';
                                $_bininfo = info_bin($ccnum['num']);
                                $_bininfo = rawurlencode($_bininfo);
                                $_bininfo = str_replace('%0D', '', $_bininfo);
                                $_bininfo = str_replace('%0A', '', $_bininfo);
                                $_bininfo = rawurldecode($_bininfo);
                                $_bininfo = str_replace('UNITED STATES', 'USA', $_bininfo);

                                if ($_POST['bin_info'] == 'true')
                                {
                                    $_INFO = $ccnum['num'] . ' | ' . $ccnum['cvv'] . ' | ' . $ccnum['mon'] . ' / ' . $ccnum['year'] . ' | ' . $ccnum['type'] . ' | ' . $_bininfo;
                                }
                                ;

                                $okokok = check($ccnum['num'], $ccnum['mon'], $ccnum['year'], $ccnum['cvv']);

                                if ($okokok == 1)
                                {

                                    $sql = "SELECT credit from " . $config["table_users"] . " WHERE userId = '" . clean($_SESSION["userId"]) . "'";
                                    $result = mysql_query($sql, $data_sql);
                                    if ($result)
                                    {
                                        $realcredit = mysql_fetch_assoc($result);
                                        $realcredit = $realcredit["credit"];
                                    } else
                                    {
                                        echo sql_error();
                                    }
                                    $sql = "UPDATE " . $config["table_users"] . " SET credit = '" . ($realcredit - $config['CheckerPrice']) . "' WHERE userId = '" . clean($_SESSION["userId"]) . "'";
                                    $result = mysql_query($sql, $data_sql);
                                    if (!$result)
                                    {
                                        echo sql_error();
                                    }
                                    echo $relog . '/' . $tongso . '.<font color="green">CVV_Live | </font><font color="blue"> ' . $_INFO . ' | ' . $credit . '</font><br>';
                                    $cc['l'][] = $ccline;
                                }
                                if ($okokok == 2)
                                {
                                    echo $relog . '/' . $tongso . '.<font color="red"> Die | ' . $_INFO . ' | ' . $credit . '</font><br>';
                                    $cc['d'][] = $ccline;
                                    $sql = "SELECT credit from " . $config["table_users"] . " WHERE userId = '" . clean($_SESSION["userId"]) . "'";
                                    $result = mysql_query($sql, $data_sql);
                                    if ($result)
                                    {
                                        $realcredit = mysql_fetch_assoc($result);
                                        $realcredit = $realcredit["credit"];
                                    } else
                                    {
                                        echo sql_error();
                                    }
                                    $sql = "UPDATE " . $config["table_users"] . " SET credit = '" . ($realcredit - $config['CheckerPrice']) . "' WHERE userId = '" . clean($_SESSION["userId"]) . "'";
                                    $result = mysql_query($sql, $data_sql);
                                    if ($result)
                                    {
                                        //great//
                                    } else
                                    {
                                        echo sql_error();
                                    }
                                    //spisanie//

                                }
                                if ($okokok == -1)
                                {
                                    echo $relog . '/' . $tongso . '.<font color="black">Invaild | ' . $_INFO . ' | ' . $credit . '</font><br>';
                                    $cc['u'][] = $ccline;
                                }
                                if ($okokok == 3)
                                {
                                    echo $relog . '/' . $tongso . '.<font color=red>Unknown | ' . $_INFO . ' | ' . $credit . '</font><br>';
                                    $cc['u'][] = $ccline;
                                }
                                if ($okokok == 5)
                                {

                                    $sql = "SELECT credit from " . $config["table_users"] . " WHERE userId = '" . clean($_SESSION["userId"]) . "'";
                                    $result = mysql_query($sql, $data_sql);
                                    if ($result)
                                    {
                                        $realcredit = mysql_fetch_assoc($result);
                                        $realcredit = $realcredit["credit"];
                                    } else
                                    {
                                        echo sql_error();
                                    }
                                    $sql = "UPDATE " . $config["table_users"] . " SET credit = '" . ($realcredit - $config['CheckerPrice']) . "' WHERE userId = '" . clean($_SESSION["userId"]) . "'";
                                    $result = mysql_query($sql, $data_sql);
                                    if (!$result)
                                    {
                                        echo sql_error();
                                    }
                                    echo $relog . '/' . $tongso . '.<font color="green">CCN_Live | ' . $_INFO . ' | ' . $credit . '</font><br>';
                                    $cc['l'][] = $ccline;
                                }
                                if ($okokok == 6)
                                {
                                    echo $relog . '/' . $tongso . '.<font color="red">Exdate/CCV2 | ' . $_INFO . ' | ' . $credit . '</font><br>';
                                    $cc['u'][] = $ccline;
                                }

                            }
                        } else
                        {
                            echo $relog . '/' . $tongso . '.<font color=black>Line_Error | ' . substr($ccline, 0, 80) . ' [...] | ' . $credit . '</font><br>';
                            $cc['e'][] = $ccline;
                        }
                        flush();
                    }

                    echo '</div></div>';
                    if (!is_null($cc['l']))
                    {


                        if ($_POST['date'] == 'true')
                            $cc['l'] = _date($cc['l']);


                        $xx = percent(count($cc['l']), count($cclist));
                        echo "<center><font color='green'><strong>LIVE: " . count($cc['l']) . " ~ $xx %</strong></center><br>";
                        echo '<center><textarea class="form-control" wrap="off" rows=10 style="width:90%;">';

                        foreach ($cc['l'] as $ss)
                            echo $ss . "\n";

                        echo '</textarea></center></br>';


                        if ($_POST['type'] == 'true')
                        {
                            $count = count($cc['l']);
                            $cc['l'] = _type($cc['l']);


                            if (!is_null($cc['l']['v']))
                            {


                                $xx = percent(count($cc['l']['v']), $count);
                                echo "<center><font color=red><strong>VISA: " . count($cc['l']['v']) . " ~ $xx %</strong></center><br>";


                                echo '<center><textarea class="form-control" wrap="off" rows=8 style="width:90%;">';

                                foreach ($cc['l']['v'] as $ss)
                                    echo $ss . "\n";

                                echo '</textarea></center></br>';


                            }


                            if (!is_null($cc['l']['m']))
                            {


                                $xx = percent(count($cc['l']['m']), $count);
                                echo "<center><font color=red><strong>MASTERCARD: " . count($cc['l']['m']) . " ~ $xx %</strong></center><br>";


                                echo '<center><textarea class="form-control" wrap="off" rows=8 style="width:90%;">';

                                foreach ($cc['l']['m'] as $ss)
                                    echo $ss . "\n";

                                echo '</textarea></center></br>';


                            }


                            if (!is_null($cc['l']['a']))
                            {


                                $xx = percent(count($cc['l']['a']), $count);
                                echo "<center><font color=red><strong>AMEX: " . count($cc['l']['a']) . " ~ $xx %</strong></center><br>";


                                echo '<center><textarea class="form-control" wrap="off" rows=8 style="width:90%;">';

                                foreach ($cc['l']['a'] as $ss)
                                    echo $ss . "\n";

                                echo '</textarea></center></br>';


                            }


                            if (!is_null($cc['l']['d']))
                            {


                                $xx = percent(count($cc['l']['d']), $count);
                                echo "<center><font color=red><strong>DISC: " . count($cc['l']['d']) . " ~ $xx %</strong></center><br>";


                                echo '<center><textarea class="form-control" wrap="off" rows=8 style="width:90%;">';

                                foreach ($cc['l']['d'] as $ss)
                                    echo $ss . "\n";

                                echo '</textarea></center></br>';


                            }


                        }


                    }


                    if (!is_null($cc['d']))
                    {


                        $xx = percent(count($cc['d']), count($cclist));
                        echo "<center><font color=green><strong>DIE: " . count($cc['d']) . " ~ $xx %</strong></center><br>";


                        echo '<center><textarea class="form-control" wrap="off" rows=20 style="width:90%;">';

                        foreach ($cc['d'] as $ss)
                            echo $ss . "\n";

                        echo '</textarea></center></br>';


                    }


                    if (!is_null($cc['i']))
                    {


                        $xx = percent(count($cc['i']), count($cclist));
                        echo "<center><font color=green><strong>CCInvaid: " . count($cc['i']) . " ~ $xx %</strong></center><br>";


                        echo '<center><textarea class="form-control" wrap="off" rows=20 style="width:90%;">';

                        foreach ($cc['i'] as $ss)
                            echo $ss . "\n";

                        echo '</textarea></center></br>';


                    }


                    if (!is_null($cc['c']))
                    {


                        $xx = percent(count($cc['c']), count($cclist));
                        echo "<center><font color=green><strong>Can't Check: " . count($cc['c']) . " ~ $xx %</strong></center><br>";


                        echo '<center><textarea class="form-control" wrap="off" rows=20 style="width:90%;">';

                        foreach ($cc['c'] as $ss)
                            echo $ss . "\n";
                        echo '</textarea></center></br>';

                    }

                    if (!is_null($cc['u']))
                    {

                        $xx = percent(count($cc['u']), count($cclist));
                        echo "<center><font color=green><strong>Unknown: " . count($cc['u']) . " ~ $xx %</strong></center><br>";


                        echo '<center><textarea class="form-control" wrap="off" rows=20 style="width:90%;">';

                        foreach ($cc['u'] as $ss)
                            echo $ss . "\n";
                        echo '</textarea></center></br>';


                    }

                    if (!is_null($cc['e']))
                    {
                        $xx = percent(count($cc['e']), count($cclist));
                        echo "<center><font color='green'><strong>LINE ERROR: " . count($cc['e']) . " ~ $xx %</strong></center><br>";


                        echo '<center><textarea class="form-control" wrap="off" rows=20 style="width:90%;">';

                        foreach ($cc['e'] as $ss)
                            echo $ss . "\n";

                        echo '</textarea></center></br>';
                    }
                } else
                {
                    echo "<font color='#ff0000'>Please add balance</font>";
                }
            } else
            {
                echo "<font color='#ff0000'>Your account has been deleted</font>";
            }
        } else
        {
            echo sql_error();
        }

    } else
    {
        echo '</div>';
    }
}
db_close();

?>