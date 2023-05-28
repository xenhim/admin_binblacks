<?php

set_time_limit(0);
session_start();
include_once ("includes/global.php");
db_connection();
if ($config['pmdeposit'] == '1')
{
    $string = $_POST['PAYMENT_ID'] . ':' . $_POST['PAYEE_ACCOUNT'] . ':' . $_POST['PAYMENT_AMOUNT'] . ':' . $_POST['PAYMENT_UNITS'] . ':' . $_POST['PAYMENT_BATCH_NUM'] . ':' . $_POST['PAYER_ACCOUNT'] . ':' . $config['securityword'] . ':' . $_POST['TIMESTAMPGMT'];

    $hash = strtoupper(md5($string));
    
    //echo $hash;
    
    if ($hash == $_POST['V2_HASH'])
    {
        $paymentid = clean($_POST['PAYMENT_ID']);
        $sql = "SELECT * FROM " . $config['table_orders'] . " WHERE orderId = '$paymentid'";
        $result = mysql_query($sql, $data_sql);
        if ($result)
        {
            $payment = mysql_fetch_assoc($result);
        } else
        {
            echo sql_error();
        }
        if ($_POST['PAYMENT_AMOUNT'] == $payment['orderTotal'] && $_POST['PAYEE_ACCOUNT'] == $config['merchant'] && $_POST['PAYMENT_UNITS'] == $config['currency_code'])
        {
            $userid = $payment['userId'];
            $sql = "SELECT * FROM " . $config['table_users'] . " WHERE userid = '$userid'";
            $result = mysql_query($sql, $data_sql);
            if ($result)
            {
                $user = mysql_fetch_assoc($result);
            } else
            {
                echo sql_error();
            }
            //add balance
            $sql = "UPDATE " . $config['table_users'] . " SET credit = '" . ($user["credit"] + $payment['orderTotal']) . "' WHERE userid = '$userid'";
            $result = mysql_query($sql, $data_sql);
            if ($result)
            {
                //status order//
                $sql = "UPDATE " . $config['table_orders'] . " SET approved = '1' WHERE orderId = '$paymentid'";
                $result = mysql_query($sql, $data_sql);
                if ($result)
                {
                    $msgBody = "Update credit successful.";
                } else
                {
                    echo sql_error();
                }
                //status order//
                header("location: index.php");
                echo "<script type=\"text/javascript\" src=\"../js/jquery-1.4.2.min.js\"></script><script>alert('Update credit successful!');$(parent).ready(function(){parent.showpage('index.php');});</script>";
            } else
            {
                echo sql_error();
            }
            //live


        } else
        {
            $msgBody = "Incorrect payment parameters";
        }
    } else
    {
        $msgBody = "Invalid response. Sent hash didn't match the computed hash.";
    }
    echo $msgBody;
} else
{
    echo 'Deposit method is OFF';
}
db_close();

?>