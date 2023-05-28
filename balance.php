<?php

set_time_limit(0);
session_start();
include_once ("includes/global.php");
db_connection();
if (!is_login())
{
    header("location: login.php");
} else
{
    $sql = "SELECT * from " . $config["table_users"] . " LEFT JOIN " . $config["table_types"] . " ON " . $config["table_users"] . ".typeId = " . $config["table_types"] . ".typeId WHERE " . $config["table_users"] . ".userId = '" . clean($_SESSION["userId"]) . "'";
    $result = mysql_query($sql, $data_sql);
    if (!$result)
    {
        echo sql_error();
    } else
    {
        $count = mysql_num_rows($result);
        if ($count == 1)
        {
            $user = mysql_fetch_assoc($result);
            $credit = $user["credit"];
        } else
        {
            die("Your account has been deleted, please contact webmaster for more information.");
        }
    }
    echo '<span class="label label-info">' . $credit . ' $</span>';
    //echo '' . $credit . ' $';
}
db_close();

?>