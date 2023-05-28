<?php

set_time_limit(0);
session_start();
include_once ("../includes/global.php");
db_connection();
if (!is_login_admin())
{
    header("location: login.php");
} else
{
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    header("Content-Type: text/javascript; charset=utf-8");
    function Send()
    {
        global $config, $data_sql;
        $name = clean($_SESSION["userId"]);
        $text = substr($_POST['text'], 0, 500);
        $text = htmlspecialchars($text);
        $text = clean($text);
        $supportuser = intval($_POST['user']);
        $sql = "INSERT INTO " . $config['table_support'] . " (user_id, date_msg, read_msg, msg, msgfrom) VALUES ('$name', '" . date('Y-m-d H:i:s', time()) . "', '0', '$text', '$supportuser')";
        echo $sql;
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        }
    }
    function Load()
    {
        global $config, $data_sql;
        $last_message_id = intval($_POST['last']);
        $supportuser = intval($_POST['user']);
        $sql = "SELECT * FROM " . $config['table_support'] . " WHERE ((user_id = '$supportuser' OR msgfrom = '$supportuser') AND id > '$last_message_id') ORDER BY id DESC LIMIT 45";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        }
        if (mysql_num_rows($result) > 0)
        {
            $js = 'var chat = $("#message_list");';
            $messages = array();
            while ($row = mysql_fetch_array($result))
            {
                $messages[] = $row;
            }
            $last_message_id = $messages[0]['id'];
            $messages = array_reverse($messages);
            $js .= 'chat.append("';
            foreach ($messages as $value)
            {
                if ($value['user_id'] != '1')
                {
                    $js .= '<li class=\'other\'><div class=\'avatar\'><img src=\'../images/user.jpg\'></div>';
                } else
                {
                    $js .= '<li class=\'self\'><div class=\'avatar\'><img src=\'../images/support.jpg\'></div>';
                }
                $js .= '<div class=\'messages\'><p>' . $value['msg'] . '</p><span class=\'time\'>' . date('d.m.Y H:i:s', strtotime($value["date_msg"])) . '</span></div></li>';
                $sql = "UPDATE " . $config['table_support'] . " SET read_msg_admin = '1' WHERE id = '" . $value['id'] . "'";
                $result = mysql_query($sql, $data_sql);
                if (!$result)
                {
                    echo sql_error();
                }
            }
            $js .= '");';

            $js .= "last_message_id = $last_message_id;$('#chatAudio')[0].play();";
            echo $js;
        }
    }
    if (isset($_POST['act']))
    {
        switch ($_POST['act'])
        {
            case "send":
                Send();
                break;
            case "load":
                Load();
                break;
            default:
                exit();
        }
    }
}
db_close();

?>