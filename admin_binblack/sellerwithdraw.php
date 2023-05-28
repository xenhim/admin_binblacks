<?php

set_time_limit(0);
session_start();
include_once ("../includes/global.php");
db_connection();
$act = clean($_GET["act"]);
if (!is_login_admin())
{
    header("location: login.php");
} else
{
    if ($act == "withdraw")
    {
        $summ = clean($_POST["summ"]);
        $summ = str_replace(",", ".", $summ);
        $id = clean($_POST["id"]);
        ;
        $sql = "SELECT * FROM " . $config["table_users"] . " WHERE userId = '" . $id . "'";
        $result = mysql_query($sql, $data_sql);
        if ($result)
        {
            $count = mysql_num_rows($result);
            if ($count == 1)
            {
                $seller = mysql_fetch_assoc($result);
                $paids = $seller[paids];
                $paidsnew = $summ + $paids;
                $sql = "UPDATE " . $config["table_users"] . " SET paids = '" . $paidsnew . "' WHERE userId = '" . $id . "'";
                $result = mysql_query($sql, $data_sql);
                if ($result)
                {
                    header("location: index.php?page=restat");
                    echo "<script type=\"text/javascript\" src=\"../js/jquery-1.4.2.min.js\"></script><script>alert('Withdraw successful');$(parent).ready(function(){parent.showpage('restat.php');});</script>";
                } else
                {
                    echo sql_error();
                }
            } else
            {
                die("Account has been deleted");
            }
        } else
        {
            echo sql_error();
        }
    } else
    {
        die('No you day');
    }
}
db_close();

?>