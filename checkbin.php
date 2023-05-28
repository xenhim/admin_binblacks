<?php
	set_time_limit(0);
	session_start();
    require_once 'lib/Twig/Autoloader.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('template');
$twig = new Twig_Environment($loader, array('cache' => 'template/cache', 'auto_reload' => true));
	include_once("includes/global.php");
	db_connection();
	if (!is_login())
	{
		header("location: login.php");
	}
	else
	{
function cc($ccline){
  $xy = array("|","\\","/","-",";");
  $sepe = $xy[0];
  foreach($xy as $v){
      if (substr_count($ccline,$sepe) < substr_count($ccline,$v)) $sepe = $v;
  }
  $x = explode($sepe,$ccline);
  foreach($xy as $y) $x = str_replace($y,"",str_replace(" ","",$x));
  foreach ($x as $xx){
      $xx = trim($xx);
         if (is_numeric($xx)){
             $yy=strlen($xx);
             switch ($yy){
                 case 15: $ccnum['num'] = $xx; break;
                 case 16: $ccnum['num'] = $xx; break;
              }
          }
  }
	return $ccnum['num'];
}

function findcc($str){
	$str=str_replace(" ","",$str);
	for($i=0;$i<=strlen($str);$i++){
	if(is_numeric($str[$i])){
	$ccNum.=$str[$i];
	if(strlen($ccNum)>5){
	return $ccNum;
	break;
	};
	}
	else $ccNum='';
	}
}

function getStr($string,$start,$end){
	$str = explode($start,$string);
	$str = explode($end,$str[1]);
	return $str[0];
}

function info($ccnum){
	$bin = substr($ccnum,0,6);
		$file = file_get_contents('dbbin1/base.csv');
		$info = getStr($file,$bin,"\n");
		$info = explode(";",$info);
	if($info[3] == "CREDIT"){
		$info[3] = str_replace('CREDIT','<span class="text-primary">CREDIT</span>',$info[3]);
	}
	if($info[4] == "PLATINUM"){
		$info[4] = str_replace('PLATINUM','<span class="text-danger">PLATINUM</span>',$info[4]);
	}
	elseif($info[4] == "GOLD/PREM"){
		$info[4] = str_replace('GOLD/PREM','<span class="text-warning">GOLD/PREM</span>',$info[4]);
	}
	elseif($info[4] == "BUSINESS"){
		$info[4] = str_replace('BUSINESS','<span class="text-success">BUSINESS</span>',$info[4]);
	}
	$country = "$info[5]";
	//echo $country."\r";
	$data = "<tr align=center><td><span class='text-info'>$ccnum|".$info[5]."</span></td><td><a class='banklink' data-link='".$info[2]."'>".$info[2]."</a></td><td>".$info[3]." ".$info[4]."</td><td>".$info[5]."</td><td>".$info[10]."</td></tr>";
	if(strlen($info[1]) < 2){
		$data = "<tr align=center><td><span class='text-info'>$ccnum</span></td><td colspan=4>Unknown</td></tr>";
	}
	return $data;
}

if($_POST['listcc']){
		$listcc = trim($_POST['listcc']); 
		$listcc = str_replace(array("\\\"","\\'"),array("\"","'"),$listcc); 
		$listcc = str_replace("\n\n","\n",$listcc); 
		$listcc = str_replace("\r\n\r\n","\r\n",$listcc); 
		$listcc = explode("\n",$listcc);
		for($i=0;$i<count($listcc);$i++){
			$ccnum = cc($listcc[$i]);
			if($ccnum == ""){
				$ccnum = findcc($listcc[$i]);
			}
			$info .= info($ccnum);
			$infos .= info($listcc[$i]);
		}
		/*
                $separa = explode("|", $ccnum);
				$cc = $separa[0];
				//echo $ccnum = cc($listcc[$i]);;
				//var_dump($ccnum);
                $urls = "https://lookup.binlist.net/$bindata";
				$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "$urls");
			curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$fim = curl_exec($ch);
				$location = json_decode(trim(strip_tags($fim)), true);
				$countrypost = $location['country']['name'];
				//var_dump($location)."\n";
				//echo $countrypost;
				*/
        $type = 'result';
echo $twig->render('checkbin.tpl', array(
'type' => $type,
'info' => $info));
}
else{
$type = 'page';
echo $twig->render('checkbin.tpl', array(
'type' => $type));
}
	}
	db_close();
?>