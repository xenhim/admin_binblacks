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
    if ($act == "LIVE")
    {
        $categoryId = 0;
        $binSearch = "";
        $showuse = 1;
        $otv = 1;
        $sql = "SELECT *, AES_DECRYPT(dumpContent, '$config[encode_key]') as dumpContent FROM " . $config['table_dumps'] . " LEFT JOIN " . $config['table_users'] . " ON " . $config['table_dumps'] . ".dumpUsed = " . $config['table_users'] . ".userId LEFT JOIN " . $config['table_categorys_dump'] . " ON " . $config['table_dumps'] . " .categoryId = " . $config['table_categorys_dump'] .
            ".categoryId ";
        if ($categoryId != 0)
        {
            $sql .= " WHERE " . $config['table_dumps'] . ".categoryId = '$categoryId'";
        } else
        {
            $sql .= " WHERE 1";
        }
        if ($showuse = 1)
        {
            $showused = "yes";
            $sql .= " AND dumpUsed <> '0' ";
        }
        $sql .= " AND status = '$otv' ";
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
            }
            $table = $twig->render('admin/dumpstat.tpl', array('type' => 'table', 'listCard' => $listCard));
        } else
        {
            echo sql_error();
        }
    }
    if ($act == "DIE")
    {
        $categoryId = 0;
        $binSearch = "";
        $showuse = 1;
        $otv = 2;
        $sql = "SELECT *, AES_DECRYPT(dumpContent, '$config[encode_key]') as dumpContent FROM " . $config['table_dumps'] . " LEFT JOIN " . $config['table_users'] . " ON " . $config['table_dumps'] . ".dumpUsed = " . $config['table_users'] . ".userId LEFT JOIN " . $config['table_categorys_dump'] . " ON " . $config['table_dumps'] . " .categoryId = " . $config['table_categorys_dump'] .
            ".categoryId ";
        if ($categoryId != 0)
        {
            $sql .= " WHERE " . $config['table_dumps'] . ".categoryId = '$categoryId'";
        } else
        {
            $sql .= " WHERE 1";
        }
        if ($showuse = 1)
        {
            $showused = "yes";
            $sql .= " AND dumpUsed <> '0' ";
        }
        $sql .= " AND status = '$otv' ";
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

            }
            $table = $twig->render('admin/dumpstat.tpl', array('type' => 'table', 'listCard' => $listCard));
        } else
        {
            echo sql_error();
        }
    }
    if ($act == "ERROR")
    {
        $categoryId = 0;
        $binSearch = "";
        $showuse = 1;
        $otv = 3;
        $sql = "SELECT *, AES_DECRYPT(dumpContent, '$config[encode_key]') as dumpContent FROM " . $config['table_dumps'] . " LEFT JOIN " . $config['table_users'] . " ON " . $config['table_dumps'] . ".dumpUsed = " . $config['table_users'] . ".userId LEFT JOIN " . $config['table_categorys_dump'] . " ON " . $config['table_dumps'] . " .categoryId = " . $config['table_categorys_dump'] .
            ".categoryId ";
        if ($categoryId != 0)
        {
            $sql .= " WHERE " . $config['table_dumps'] . ".categoryId = '$categoryId'";
        } else
        {
            $sql .= " WHERE 1";
        }
        if ($showuse = 1)
        {
            $showused = "yes";
            $sql .= " AND dumpUsed <> '0' ";
        }
        $sql .= " AND status = '$otv' ";
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
            }
            $table = $twig->render('admin/dumpstat.tpl', array('type' => 'table', 'listCard' => $listCard));
        } else
        {
            echo sql_error();
        }
    }
    if ($act == "TIMEOFF")
    {
        $categoryId = 0;
        $binSearch = "";
        $showuse = 1;
        $otv = 5;
        $sql = "SELECT *, AES_DECRYPT(dumpContent, '$config[encode_key]') as dumpContent FROM " . $config['table_dumps'] . " LEFT JOIN " . $config['table_users'] . " ON " . $config['table_dumps'] . ".dumpUsed = " . $config['table_users'] . ".userId LEFT JOIN " . $config['table_categorys_dump'] . " ON " . $config['table_dumps'] . " .categoryId = " . $config['table_categorys_dump'] .
            ".categoryId ";
        if ($categoryId != 0)
        {
            $sql .= " WHERE " . $config['table_dumps'] . ".categoryId = '$categoryId'";
        } else
        {
            $sql .= " WHERE 1";
        }
        if ($showuse = 1)
        {
            $showused = "yes";
            $sql .= " AND dumpUsed <> '0' ";
        }
        $sql .= " AND status = '$otv' ";
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
            }
            $table = $twig->render('admin/dumpstat.tpl', array('type' => 'table', 'listCard' => $listCard));
        } else
        {
            echo sql_error();
        }
    }
    if ($act == "UNKNOWN")
    {
        $categoryId = 0;
        $binSearch = "";
        $showuse = 1;
        $otv = 4;
        $sql = "SELECT *, AES_DECRYPT(dumpContent, '$config[encode_key]') as dumpContent FROM " . $config['table_dumps'] . " LEFT JOIN " . $config['table_users'] . " ON " . $config['table_dumps'] . ".dumpUsed = " . $config['table_users'] . ".userId LEFT JOIN " . $config['table_categorys_dump'] . " ON " . $config['table_dumps'] . " .categoryId = " . $config['table_categorys_dump'] .
            ".categoryId ";
        if ($categoryId != 0)
        {
            $sql .= " WHERE " . $config['table_dumps'] . ".categoryId = '$categoryId'";
        } else
        {
            $sql .= " WHERE 1";
        }
        if ($showuse = 1)
        {
            $showused = "yes";
            $sql .= " AND dumpUsed <> '0' ";
        }
        $sql .= " AND status = '$otv' ";
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
            }
            $table = $twig->render('admin/dumpstat.tpl', array('type' => 'table', 'listCard' => $listCard));
        } else
        {
            echo sql_error();
        }
    }
    if ($act == "ALL")
    {
        $categoryId = 0;
        $binSearch = "";
        $showuse = 1;
        $sql = "SELECT *, AES_DECRYPT(dumpContent, '$config[encode_key]') as dumpContent FROM " . $config['table_dumps'] . " LEFT JOIN " . $config['table_users'] . " ON " . $config['table_dumps'] . ".dumpUsed = " . $config['table_users'] . ".userId LEFT JOIN " . $config['table_categorys_dump'] . " ON " . $config['table_dumps'] . " .categoryId = " . $config['table_categorys_dump'] .
            ".categoryId ";
        if ($categoryId != 0)
        {
            $sql .= " WHERE " . $config['table_dumps'] . ".categoryId = '$categoryId'";
        } else
        {
            $sql .= " WHERE 1";
        }
        if ($showuse = 1)
        {
            $showused = "yes";
            $sql .= " AND dumpUsed <> '0' ";
        }
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
            }
            $table = $twig->render('admin/dumpstat.tpl', array('type' => 'table', 'listCard' => $listCard));
        } else
        {
            echo sql_error();
        }
    }
    $head = $twig->render('admin/dumpstat.tpl', array('type' => 'head'));
    $footer = $twig->render('admin/dumpstat.tpl', array('type' => 'footer'));
    echo $head;
    echo $table;
    echo $footer;
}
db_close();

?>