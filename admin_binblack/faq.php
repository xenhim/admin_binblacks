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
				$categoryid = clean($_POST["categoryid"]);
				$categoryname = clean($_POST["categoryname"]);
				$categoryicon = clean($_POST["categoryicon"]);
				$sql = "UPDATE " . $config["table_faq"] . " SET categoryName = '$categoryname', categoryIcon = '$categoryicon' WHERE categoryId = '$categoryid'";
				$result = mysql_query($sql, $data_sql);
				if ($result)
				{
					echo "<script type=\"text/javascript\" src=\"../js/jquery-1.4.2.min.js\"></script><script>alert('Edited FAQ category $categoryname successful');$(parent).ready(function(){parent.showpage('faq.php');});</script>";
				}
				else
				{
					echo sql_error();
				}
			}
			else
			{
				$categoryid = clean($_GET["categoryid"]);
				$sql = "SELECT * from " . $config["table_faq"] . " WHERE categoryId = '$categoryid'";
				$result = mysql_query($sql, $data_sql);
				if ($result)
				{
					$count = mysql_num_rows($result);
					if ($count == 1)
					{
						$category = mysql_fetch_assoc($result);
                    }
				}
				else
				{
					echo sql_error();
				}
                echo $twig->render('admin/faq-edit-cat.tpl', array('category' => $category));
			}
		}
		else if ($act == "editanswer")
		{
			if (isset($_POST["save"]))
			{
				$question = clean($_POST["question"]);
				$answer = clean($_POST["answer"]);
				$categoryId = clean($_POST["category"]);
				$id = clean($_POST["id"]);
				$sql = "UPDATE " . $config["table_questions"] . " SET question = '$question', answer = '$answer', categoryId = '$categoryId' WHERE Id = '$id'";
				$result = mysql_query($sql, $data_sql);
				if ($result)
				{
					echo "<script type=\"text/javascript\" src=\"../js/jquery-1.4.2.min.js\"></script><script>alert('Edited successful');$(parent).ready(function(){parent.showpage('faq.php');});</script>";
				}
				else
				{
					echo sql_error();
				}
			}
			else
			{
				$answerid = clean($_GET["answerid"]);
				$sql = "SELECT * from " . $config["table_questions"] . " WHERE Id = '$answerid'";
				$result = mysql_query($sql, $data_sql);
				if ($result)
				{
					$count = mysql_num_rows($result);
					if ($count == 1)
					{
						$answer = mysql_fetch_assoc($result);
				$sql = "SELECT * FROM " . $config['table_faq'] . " ORDER BY categoryId";
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
                    }
				}
				else
				{
					echo sql_error();
				}
                echo $twig->render('admin/faq-edit-answer.tpl', array('listCategory' => $listCategory, 'answer' => $answer));
			}
		}
		else if ($act == "delete")
		{
			$categoryid = clean($_GET["categoryid"]);
			$sql = "DELETE from " . $config["table_faq"] . " WHERE categoryId = '$categoryid'";
			$result = mysql_query($sql, $data_sql);
			$sql = "DELETE from " . $config["table_questions"] . " WHERE categoryId = '$categoryid'";
			$result = mysql_query($sql, $data_sql);
			if ($result)
			{
				header("location: faq.php");
			}
			else
			{
				echo sql_error();
			}
		}
		else if ($act == "deleteanswer")
		{
			$answerid = clean($_GET["answerid"]);
			$sql = "DELETE from " . $config["table_questions"] . " WHERE Id = '$answerid'";
			$result = mysql_query($sql, $data_sql);
			if ($result)
			{
				header("location: faq.php");
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
				$categoryname = clean($_POST["categoryname"]);
				$categoryicon = clean($_POST["categoryicon"]);
				$sql = "INSERT INTO " . $config["table_faq"] . "(categoryName, categoryIcon) VALUES ('$categoryname', '$categoryicon')";
				$result = mysql_query($sql, $data_sql);
				if ($result)
				{
					echo "<center><font color='#00ff00'>Added FAQ category successful</font></center>";
				}
				else
				{
					echo sql_error();
				}
			}
			else
			{
			 echo $twig->render('admin/faq-add-cat.tpl');
			}
		}
		else if ($act == "addanswer")
		{
			if (isset($_POST["save"]))
			{
				$question = clean($_POST["question"]);
				$answer = clean($_POST["answer"]);
				$categoryId = clean($_POST["category"]);
				$sql = "INSERT INTO " . $config["table_questions"] . "(question, answer, categoryId) VALUES ('$question', '$answer', '$categoryId')";
				$result = mysql_query($sql, $data_sql);
				if ($result)
				{
					echo "<center><font color='#00ff00'>Added question successful</font></center>";
				}
				else
				{
					echo sql_error();
				}
			}
			else
			{
				$sql = "SELECT * FROM " . $config['table_faq'] . " ORDER BY categoryId";
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
			     echo $twig->render('admin/faq-add-answer.tpl', array('listCategory' => $listCategory));
			}
		}
		else
		{
			$sql = "SELECT * from " . $config["table_faq"] . " ORDER BY categoryId";
			$result = mysql_query($sql, $data_sql);
			if ($result)
			{
                $count = mysql_num_rows($result);
				if ($count >= 1)
				{
					while ($category = mysql_fetch_assoc($result))
					{
						$listCategory[] = $category;
					}
				}
			}
			else
			{
				echo sql_error();
			}
//ADDED
$head = $twig->render('admin/faq.tpl', array('type' => 'head'));
$menu = $twig->render('admin/faq.tpl', array('listCategory' => $listCategory, 'type' => 'menu'));
foreach ($listCategory as $pane => $category)
{
if ($pane == '0') {
$active = '1';
} else
{
$active = '0';
}
$sql = "SELECT * from " . $config["table_questions"] . " WHERE categoryId = '". $category['categoryId'] ."'";
			$result = mysql_query($sql, $data_sql);
			if ($result)
			{
$count = mysql_num_rows($result);
				if ($count >= 1)
				{
$found = '1';
while ($answer = mysql_fetch_assoc($result))
					{
						$answers[] = $answer;
					}
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
$content .= $twig->render('admin/faq.tpl', array('category' => $category, 'type' => 'content', 'found' => $found, 'active' => $active, 'answers' => $answers));
unset($answers);
}
$footer = $twig->render('admin/faq.tpl', array('type' => 'footer'));
        echo $head;
        echo $menu;
        echo $content;
        echo $footer;
		}
	}
	db_close();
?>