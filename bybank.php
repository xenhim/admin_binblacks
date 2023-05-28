<?

session_start();
require_once 'lib/Twig/Autoloader.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('template');
$twig = new Twig_Environment($loader, array('cache' => 'template/cache', 'auto_reload' => true));
include_once ("includes/global.php");
function info($bank)
{
    $file1 = file_get_contents('dbbin1/base.csv');
    $file1 = explode("\n", $file1);
    $data = "";
    foreach ($file1 as $line1)
    {
        if (stristr($line1, $bank))
        {
            $info = trim($line1);
            $info = explode(";", $info);

            if ($info[3] == "CREDIT")
            {
                $info[3] = str_replace('CREDIT', '<span class="text-primary">CREDIT</span>', $info[3]);
            }
            if ($info[4] == "PLATINUM")
            {
                $info[4] = str_replace('PLATINUM', '<span class="text-danger">PLATINUM</span>', $info[4]);
            } elseif ($info[4] == "GOLD/PREM")
            {
                $info[4] = str_replace('GOLD/PREM', '<span class="text-warning">GOLD/PREM</span>', $info[4]);
            } elseif ($info[4] == "BUSINESS")
            {
                $info[4] = str_replace('BUSINESS', '<span class="text-success">BUSINESS</span>', $info[4]);
            }
            $data .= "<tr align=center><td><span class='text-info'>" . $info[0] . "</span></td><td>$bank</td><td>" . $info[3] . " " . $info[4] . "</td><td>" . $info[5] . "</td><td>" . $info[10] . "</td></tr>";
        }
    }
    return $data;
}
$bank = $_GET['bank'];
$info = info($bank);
echo $twig->render('bybank.tpl', array('bank' => $bank, 'info' => $info));

?>