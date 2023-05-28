<?php

set_time_limit(0);
session_start();
require_once 'lib/Twig/Autoloader.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('template');
$twig = new Twig_Environment($loader, array('cache' => 'template/cache', 'auto_reload' => true));
include_once ("includes/global.php");
db_connection();
$act = clean($_GET["act"]);
if (!is_login())
{
    header("location: login.php");
} else
{
    function add_to_cart($card_id)
    {
        if (empty($_SESSION['cards'][$card_id]))
        {
            $_SESSION['cards'][$card_id] = $card_id;
        }
        update_cart();
    }

    function update_cart()
    {
        global $config;
        global $data_sql;
        $_SESSION['cart_coast'] = 0;
        foreach ($_SESSION['cards'] as $key => $value)
        {
            $sql = "SELECT cardUsed, price FROM " . $config["table_cards"] . " WHERE cardId = '" . $key . "'";
            $result = mysql_query($sql, $data_sql);
            if ($result)
            {
                $card = mysql_fetch_assoc($result);
                if ($card[cardUsed] == '0')
                {
                    $_SESSION['cart_coast'] += $card[price];
                } else
                {
                    unset($_SESSION['cards'][$key]);
                }
            } else
            {
                echo sql_error();
            }
        }
        $_SESSION['cards_val'] = count($_SESSION['cards']);
    }
    function remove_from_cart($card_id)
    {
        unset($_SESSION['cards'][$card_id]);
        update_cart();
    }
    //FUNC
    if ($act == "add")
    {
        add_to_cart(clean($_POST['card_id']));
    }
    if ($act == "update")
    {
        update_cart();
        echo $twig->render('elements/cc-cart-upd.tpl', array('cards' => $_SESSION['cards_val']));
    }
    if ($act == "totalcart")
    {
        echo $twig->render('elements/cc-cart-total.tpl', array('cards' => $_SESSION['cards_val'], 'price' => $_SESSION['cart_coast']));
    }
    if ($act == "remove")
    {
        remove_from_cart(clean($_POST['card_id']));
    }
    if ($act == "order")
    {
        update_cart();
        foreach ($_SESSION['cards'] as $key => $value)
        {
            $sql = "SELECT *, AES_DECRYPT(cardContent, '$config[encode_key]') as cardContent from " . $config["table_cards"] . " LEFT JOIN " . $config["table_categorys"] . " ON " . $config["table_cards"] . ".categoryId = " . $config["table_categorys"] . ".categoryId WHERE " . $config["table_cards"] . ".cardId = '$key'";
            $result = mysql_query($sql, $data_sql);
            if ($result)
            {
                $cardinfo[] = mysql_fetch_assoc($result);
            } else
            {
                echo sql_error();
            }
        }

        echo $twig->render('cc-cart-order.tpl', array(
            'cards' => $_SESSION['cards_val'],
            'price' => $_SESSION['cart_coast'],
            'cardinfo' => $cardinfo));
    }
}
db_close();

?>