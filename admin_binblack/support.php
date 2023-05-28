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
    //USERS
    $sql = "SELECT userId, username, typeId FROM " . $config['table_users'] . "";
    $result = mysql_query($sql, $data_sql);

    if (!$result)
    {
        echo sql_error();
    } else
    {
        while ($users = mysql_fetch_assoc($result))
        {
            $listusers[] = $users;
        }
        foreach ($listusers as $i => $iusers)
        {
            if ($iusers[typeId] != '1')
            {
                $usersint .= "<option ";
                if ($iusers[userId] == $_GET[user])
                {
                    $usersint .= "selected ";
                }
                if ($iusers[typeId] == '1')
                {
                    $usersint .= "value='" . $iusers[userId] . "' class='text-danger'>" . htmlspecialchars($iusers[username]) . "</option>";
                } else
                    if ($iusers[typeId] == '3')
                    {
                        $usersint .= "value='" . $iusers[userId] . "' class='text-primary'>" . htmlspecialchars($iusers[username]) . "</option>";
                    } else
                    {
                        $usersint .= "value='" . $iusers[userId] . "'>" . htmlspecialchars($iusers[username]) . "</option>";
                    }
            } else
            {
                $usersint .= '';
            }
        }
    }
    $sql = "SELECT *, COUNT(user_id) FROM " . $config['table_support'] . " WHERE ( msgfrom = '1' AND read_msg_admin = '0') GROUP BY user_id";
    $result = mysql_query($sql, $data_sql);
    if (!$result)
    {
        echo sql_error();
    } else
    {
        $messages = mysql_num_rows($result);
        if ($messages >= 1)
        {
            while ($row = mysql_fetch_array($result))
            {
                $messagesshort[] = $row;
            }
            foreach ($messagesshort as $value)
            {
                $userId = $value["user_id"];
                $sql = "SELECT * FROM " . $config['table_users'] . " WHERE userId = '" . $userId . "'";
                $result = mysql_query($sql, $data_sql);
                if (!$result)
                {
                    echo sql_error();
                } else
                {
                    $user = mysql_fetch_array($result);
                }
                $shortmsg .= '<li class="messages-item" onclick="showpage(\'support.php?act=support&user=' . $userId . '\');" style="background-color:#e8ffe1"><img src="../images/user.jpg" class="messages-item-avatar"><span class="messages-item-from">' . htmlspecialchars($user[username]) . ' (' . $value['COUNT(user_id)'] .
                    ' messages)</span> <span class="messages-item-subject">';
                if ($user[typeId] == '1')
                {
                    $shortmsg .= '<p class="text-danger">Administrator</p>';
                } else
                    if ($user[typeId] == '3')
                    {
                        $shortmsg .= '<p class="text-primary">Seller</p>';
                    } else
                    {
                        $shortmsg .= '<p>User</p>';
                    }
                    $shortmsg .= '</span><span class="messages-item-preview">' . htmlspecialchars(substr($value['msg'], 0, 70)) . ' ...</span></li>';
            }
        } else
        {
            $shortmsg = '';
        }
    }
    $sql = "SELECT * FROM " . $config['table_support'] . " WHERE read_msg_admin = '1' GROUP BY msgfrom ORDER BY id DESC LIMIT 0, 10";
    $result = mysql_query($sql, $data_sql);
    if (!$result)
    {
        echo sql_error();
    } else
    {
        $messages = mysql_num_rows($result);
        if ($messages >= 1)
        {
            while ($addrow = mysql_fetch_array($result))
            {
                $addmessagesshort[] = $addrow;
            }
            foreach ($addmessagesshort as $addvalue)
            {
                $userId = $addvalue["msgfrom"];
                if ($userId == '1')
                {
                    $userId = $addvalue["user_id"];
                }
                if ($userId != '1')
                {
                    $temp .= $userId . '|';
                    if (mb_substr_count($temp, $userId . '|') > 1)
                    {
                        //дубль
                    } else
                    {
                        $sql = "SELECT * FROM " . $config['table_users'] . " WHERE userId = '" . $userId . "'";
                        $result = mysql_query($sql, $data_sql);
                        if (!$result)
                        {
                            echo sql_error();
                        } else
                        {
                            $lastuser = mysql_fetch_array($result);
                        }
                        $lastshortmsg .= '<li class="messages-item" onclick="showpage(\'support.php?act=support&user=' . $userId . '\');" ><img src="../images/user.jpg" class="messages-item-avatar"><span class="messages-item-from">' . htmlspecialchars($lastuser[username]) . '</span> <span class="messages-item-subject">';
                        if ($lastuser[typeId] == '1')
                        {
                            $lastshortmsg .= '<p class="text-danger">Administrator</p>';
                        } else
                            if ($lastuser[typeId] == '3')
                            {
                                $lastshortmsg .= '<p class="text-primary">Seller</p>';
                            } else
                            {
                                $lastshortmsg .= '<p>User</p>';
                            }
                            $lastshortmsg .= '</span></li>';
                    }
                }
            }
        } else
        {
            $lastshortmsg = '';
        }
    }

?>
<div class="page-header"><h1>Support<small> Admin Panel</small></h1></div></div></div>
<div class="row"><div class="col-md-12">
<div class="panel panel-default"><div class="panel-heading"><i class="fa fa-envelope-o"></i>Support</div>
<div class="panel-body messages"><ul class="messages-list" style="height:530px; overflow: auto;"><li class="messages-search">
<select id="user" onchange="showpage('support.php?act=support&user='+document.getElementById('user').options[document.getElementById('user').selectedIndex].value);" class="form-control search-select">
<?=

    $usersint;

?></select></li>
<script> 
$(document).ready(function() { 
$("#user").select2();
});
</script>
<li class="messages-item" style="background-color:#c6fb90">New messages</li>
<?=

    $shortmsg;

?>
<li class="messages-item" style="background-color:#eaeaea">Last messages</li>
<?=

    $lastshortmsg;

?>
</ul>
<?

    if ($act == 'support')
    {
        $supportuser = clean($_GET["user"]);
        $sql = "SELECT * FROM " . $config['table_users'] . " WHERE userId = '" . $supportuser . "'";
        $result = mysql_query($sql, $data_sql);
        if (!$result)
        {
            echo sql_error();
        } else
        {
            $suser = mysql_fetch_array($result);
        }
        echo '
<script type="text/javascript">
$(document).ready(function () {
    $("#msg_form").submit(Send);
    $("#msg").focus();
    setInterval("Load();", 2000);
    $(\'<audio id="chatAudio"><source src="../assets/audio/notify.ogg" type="audio/ogg"><source src="../assets/audio/notify.mp3" type="audio/mpeg"><source src="../assets/audio/notify.wav" type="audio/wav"></audio>\').appendTo(\'body\');
});

function Send() {
$.post("ajax-support.php",
{
act: "send",
user: "' . $supportuser . '",
text: $("#msg").val()
},
Load );
$("#msg").val("");
$("#msg").focus();
return false;
}

var last_message_id = 0;
var load_in_process = false;

function Load() {
if(!load_in_process)
{
load_in_process = true;
$.post("ajax-support.php",
{
act: "load",
user: "' . $supportuser . '",
last: last_message_id,
rand: (new Date()).getTime()
},
function (result) {
$(".panel-body1").scrollTop($(".panel-body1").get(0).scrollHeight);
load_in_process = false;
});
}
}
</script>
';
        echo '
									<div class="messages-content">
										<div class="message-header">
											<div class="message-time">
												Register: ' . date("d/m/Y", $suser[regDate]) . '
											</div>
											<div class="message-from">
												' . htmlspecialchars($suser[username]) . ' &lt;' . htmlspecialchars($suser[jabber]) . '&gt;
											</div>
											<div class="message-to">Type: ';
        if ($suser[typeId] == '1')
        {
            echo '<span class="label label-danger">Administrator</span>';
        } else
            if ($suser[typeId] == '3')
            {
                echo '<span class="label label-info">Seller</span>';
            } else
            {
                echo '<span class="label label-success">User</span>';
            }

            echo ' Balance: <span class="label label-inverse"> ' . $suser[credit] . '$</span>
											</div>
											<div class="message-actions">
												<a title="Edit user" href="#" onclick="showpage(\'user.php?act=edit&userid=' . $supportuser . '\');"><i class="clip-user-plus"></i></a>
												<a title="Add balance" href="#" onclick="showpage(\'user.php?act=edit&userid=' . $supportuser . '\');"><i class="fa fa-money"></i></a>
                                                <a title="Edit cards" href="#" onclick="showpage(\'card.php\');"><i class="fa fa-credit-card"></i></a>
												<a title="Delete user" href="#" onclick="if (confirm(\'Delete user. Are you sure?\')) {showpage(\'user.php?act=delete&amp;userid=' . $supportuser . '\');}"><i class="fa fa-ban"></i></a>
											</div>
										</div>
										<div class="message-content">
<!-- chat -->
<div class="panel-body1" style="height:460px; overflow: auto;">
<ol class="discussion">
<div id="message_list" >
</div>
</ol>
										</div>                                        
<!-- chat -->
                                <form id="msg_form" action="">
									<div class="chat-form">
										<div class="input-group">
											<input id="msg" type="text" class="form-control input-mask-date" placeholder="Type a message here...">
											<span class="input-group-btn">
												<button class="btn btn-teal" type="submit">
													<i class="fa fa-check"></i>
												</button> </span>
            </form>
										</div>
									</div>
										</div>
									</div>
								</div>
							</div>
							<!-- end: INBOX PANEL -->
						</div>
					</div>
';
    }
}
db_close();

?>