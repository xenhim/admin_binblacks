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
    if ($act == "edit")
    {
        if (isset($_POST["save"]))
        {
            $userid = clean($_POST["userid"]);
            $username = clean($_POST["username"]);
            $email = clean($_POST["email"]);
            $password = clean($_POST["password"]);
            $typeid = clean($_POST["typeid"]);
            $credit = clean($_POST["credit"]);
            if (strlen($password) > 0)
            {
                if (strlen($password) > 5)
                {
                    $sql = "UPDATE " . $config["table_users"] . " SET password = '" . md5($password) . "', jabber = '$email', typeId = '$typeid', credit = '$credit' WHERE userId = '$userid'";
                } else
                {
                    die("<center><font color='#ff0000'>Password at least 6 characters</font></center>");
                }
            } else
                if (!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $email))
                {
                    die("<center><font color='#ff0000'>Email Not Available</font></center>");
                } else
                {
                    $sql = "UPDATE " . $config["table_users"] . " SET jabber = '$email', typeId = '$typeid', credit = '$credit' WHERE userId = '$userid'";
                }
                $result = mysql_query($sql, $data_sql);
            if ($result)
            {
                echo "<script type=\"text/javascript\" src=\"../js/jquery-1.4.2.min.js\"></script><script>alert('Edited user $username successful');$(parent).ready(function(){parent.showpage('user.php');});</script>";
            } else
            {
                echo sql_error();
            }
        } else
        {
            $sql = "SELECT * from " . $config["table_types"];
            $result = mysql_query($sql, $data_sql);
            if ($result)
            {
                while ($type = mysql_fetch_assoc($result))
                {
                    $listType[] = $type;
                }
            } else
            {
                echo sql_error();
            }
            $userid = clean($_GET["userid"]);
            $sql = "SELECT * from " . $config["table_users"] . " LEFT JOIN " . $config["table_types"] . " ON " . $config["table_users"] . ".typeId = " . $config["table_types"] . ".typeId WHERE " . $config["table_users"] . ".userid = '$userid'";
            $result = mysql_query($sql, $data_sql);
            if ($result)
            {
                $count = mysql_num_rows($result);
                if ($count == 1)
                {
                    $found = '1';
                    $user = mysql_fetch_assoc($result);
                } else
                {
                    $found = '0';
                }
            } else
            {
                echo sql_error();
            }
            echo $twig->render('admin/edituser.tpl', array(
                'userid' => $userid,
                'listType' => $listType,
                'user' => $user,
                'found' => $found));
        }
    } else
        if ($act == "delete")
        {
            $userid = clean($_GET["userid"]);
            $sql = "DELETE from " . $config["table_users"] . " WHERE userid = '$userid'";
            $result = mysql_query($sql, $data_sql);
            if ($result)
            {
                header("location: user.php");
            } else
            {
                echo sql_error();
            }
        } else
            if ($act == "add")
            {
                if (isset($_POST["save"]))
                {
                    $username = clean($_POST["username"]);
                    $email = clean($_POST["email"]);
                    $password = clean($_POST["password"]);
                    $typeid = clean($_POST["typeid"]);
                    $credit = clean($_POST["credit"]);
                    if (strlen($username) < 3)
                    {
                        die("<center><font color='#ff0000'>Username at least 3 characters</font></center>");
                    } else
                        if (strlen($password) < 6)
                        {
                            die("<center><font color='#ff0000'>Password at least 6 characters</font></center>");
                        } else
                            if (!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $email))
                            {
                                die("<center><font color='#ff0000'>Email Not Available</font></center>");
                            } else
                            {
                                $sql = "SELECT username FROM " . $config['table_users'] . " WHERE username='$username' OR jabber='$email'";
                                $result = mysql_query($sql, $data_sql);
                                if (!$result)
                                {
                                    echo sql_error();
                                } else
                                {
                                    $count = mysql_num_rows($result);
                                    if ($count >= 1)
                                    {
                                        $user = mysql_fetch_row($result);
                                        if ($username == $user[0])
                                        {
                                            die("<center><font color='#ff0000'>This username has been used</font></center>");
                                        } else
                                        {
                                            die("<center><font color='#ff0000'>This jabber address has been used</font></center>");
                                        }
                                    } else
                                    {
                                        $sql = "INSERT INTO " . $config["table_users"] . " (username, password, jabber, typeId, credit, regDate) VALUES ('$username', '" . md5($password) . "', '$email', '$typeid', '$credit', '" . time() . "')";
                                        $result = mysql_query($sql, $data_sql);
                                        if ($result)
                                        {
                                            die("<center><font color='#00ff00'>Added user <b>$username</b> successful</font></center>");
                                        } else
                                        {
                                            echo sql_error();
                                        }
                                    }
                                }
                            }
                } else
                {
                    $sql = "SELECT * from " . $config["table_types"];
                    $result = mysql_query($sql, $data_sql);
                    if ($result)
                    {
                        while ($type = mysql_fetch_assoc($result))
                        {
                            $listType[] = $type;
                        }
                    } else
                    {
                        echo sql_error();
                    }
                    echo $twig->render('admin/adduser.tpl', array('listType' => $listType));
                }
            } else
            {
                $sql = "SELECT * from " . $config["table_users"] . " LEFT JOIN " . $config["table_types"] . " ON " . $config["table_users"] . ".typeId = " . $config["table_types"] . ".typeId ORDER BY userId";
                $result = mysql_query($sql, $data_sql);
                if ($result)
                {
                    $count = mysql_num_rows($result);
                    if ($count >= 1)
                    {
                        while ($user = mysql_fetch_assoc($result))
                        {
                            $user["regDate"] = date("d/m/Y", $user["regDate"]);
                            $listUser[] = $user;
                        }
                    }
                } else
                {
                    echo sql_error();
                }
                echo $twig->render('admin/users.tpl', array('listUser' => $listUser));

            }
}
db_close();

?>