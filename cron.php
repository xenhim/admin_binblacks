<?

set_time_limit(0);
session_start();
include_once ("includes/global.php");
db_connection();
$sql = "SELECT cardId, date FROM " . $config["table_cards"] . " WHERE cardUsed <> '0' AND status = '0'";
$result = mysql_query($sql, $data_sql);
$count = mysql_num_rows($result);
if ($count >= 1)
{
    if (!$result)
    {
        echo sql_error();
    } else
    {
        while ($card = mysql_fetch_assoc($result))
        {
            $timeoff[] = $card;
        }
    }

    foreach ($timeoff as $timoff)
        if (date('Y-m-d H:i:s') > $timoff['date'])
        {
            $sql = "UPDATE " . $config["table_cards"] . " SET status = '5' WHERE cardId = '" . $timoff[cardId] . "'";
            $result = mysql_query($sql, $data_sql);
            if ($result)
            {
                echo '<p>timeoff = id' . $timoff[cardId] . '</p>';
            } else
            {
                echo sql_error();
            }
        } else
        {
            echo 'no cards<p>';
        }
} else
{
    echo 'no timeoff cards<p>';
}

$sql = "SELECT dumpId, date FROM " . $config["table_dumps"] . " WHERE dumpUsed <> '0' AND status = '0'";
$result = mysql_query($sql, $data_sql);
$count = mysql_num_rows($result);
if ($count >= 1)
{
    if (!$result)
    {
        echo sql_error();
    } else
    {
        while ($dump = mysql_fetch_assoc($result))
        {
            $timeoffdump[] = $dump;
        }
    }

    foreach ($timeoffdump as $timedump)
        if (date('Y-m-d H:i:s') > $timedump['date'])
        {
            $sql = "UPDATE " . $config["table_dumps"] . " SET status = '5' WHERE dumpId = '" . $timedump[dumpId] . "'";
            $result = mysql_query($sql, $data_sql);
            if ($result)
            {
                echo '<p>timeoff = id' . $timedump[dumpId] . '</p>';
            } else
            {
                echo sql_error();
            }
        } else
        {
            echo 'no dumps<p>';
        }
} else
{
    echo 'no timeoff dumps<p>';
}

?>