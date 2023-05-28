<?php

set_time_limit(0);
session_start();
require_once 'lib/Twig/Autoloader.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('template');
$twig = new Twig_Environment($loader, array('cache' => 'template/cache', 'auto_reload' => true));
include_once ("includes/global.php");
db_connection();
if (!is_login())
{
    header("location: login.php");
} else
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

            foreach ($listCategory as $pane => $category)
            {
                if ($pane == '0')
                {
                    $msgHtml .= '<div class="tab-pane active" id="faq_' . $category['categoryId'] . '">';
                } else
                {
                    $msgHtml .= '<div class="tab-pane" id="faq_' . $category['categoryId'] . '">';
                }
                $msgHtml .= '<div id="accordion" class="panel-group accordion accordion-custom accordion-teal">';
                $sql = "SELECT * from " . $config["table_questions"] . " WHERE categoryId = '" . $category['categoryId'] . "'";
                $result = mysql_query($sql, $data_sql);
                if ($result)
                {
                    $count = mysql_num_rows($result);
                    if ($count >= 1)
                    {
                        while ($answer = mysql_fetch_assoc($result))
                        {
                            $answers[] = $answer;
                        }
                        foreach ($answers as $one => $answer)
                        {
                            if ($one == '0')
                            {
                                $msgHtml .= '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a href="#faq_' . $answer['categoryId'] . '_' . $answer['Id'] . '" data-parent="#accordion" data-toggle="collapse" class="accordion-toggle"><i class="icon-arrow"></i>';
                                $msgHtml .= $answer['question'];
                                $msgHtml .= '</a></h4></div><div class="panel-collapse in" id="faq_' . $answer['categoryId'] . '_' . $answer['Id'] . '"><div class="panel-body">';
                                $msgHtml .= $answer['answer'];
                                $msgHtml .= '</div></div></div>';
                            } else
                            {
                                $msgHtml .= '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a href="#faq_' . $answer['categoryId'] . '_' . $answer['Id'] . '" data-parent="#accordion" data-toggle="collapse" class="accordion-toggle collapsed"><i class="icon-arrow"></i>';
                                $msgHtml .= $answer['question'];
                                $msgHtml .= '</a></h4></div><div class="panel-collapse collapse" id="faq_' . $answer['categoryId'] . '_' . $answer['Id'] . '"><div class="panel-body">';
                                $msgHtml .= $answer['answer'];
                                $msgHtml .= '</div></div></div>';
                            }
                            unset($answers);
                        }
                    } else
                    {
                        $msgHtml .= '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a href="#faq_' . $category['categoryId'] . '" data-parent="#accordion" data-toggle="collapse" class="accordion-toggle"><i class="icon-arrow"></i>';
                        $msgHtml .= 'No Answer found.';
                        $msgHtml .= '</a></h4></div><div class="panel-collapse collapse in" id="faq_' . $category['categoryId'] . '"><div class="panel-body">';
                        $msgHtml .= 'No Answer found.';
                        $msgHtml .= '</div></div></div>';
                    }
                } else
                {
                    echo sql_error();
                }
                $msgHtml .= '</div></div>';
            }
            echo $twig->render('faq.tpl', array('listCategory' => $listCategory, 'msghtml' => $msgHtml));
        }
    }
}
db_close();

?>