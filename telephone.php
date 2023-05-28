<?php
//include "functions_proxy.php";
//include "testemail.php";

error_reporting(0);
set_time_limit(0);
ini_set('memory_limit', '-1');
//date_default_timezone_set('Asia/Jakarta');
//date_default_timezone_set("America/New_York");
/*
       include "vendor/autoload.php";
       ini_set('max_execution_time', '0'); // for infinite time of execution

       $faker = Faker\Factory::create();

        $fakedName = $faker->name;
        $fakedFirstName = $faker->firstName;
        $fakedLastName = $faker->lastName;
        $fakedEmail = $faker->email;
        $fakedIp = $faker->ipv4;
        $fakeduuid = $faker->uuid;
        $fakeduuids = $faker->uuid;
        $fakeduuiid = $faker->uuid;
        $fakedzip = $faker->postcode;
		$fakedstreetAddress = $faker->streetAddress;
		$fakedcity = $faker->city;
		$fakedstateAbbr = $faker->stateAbbr;
		$fakedaddress = $faker->address;
		$fakeduserAgent = $faker->userAgent;
		$fakedpassword = $faker->password;
        $ones_digit_random_number = mt_rand(100000, 399999);
        $six_digit_random_number = mt_rand(100000, 999999);
        $seven_digit_random_number = mt_rand(1000000, 9999999);
        $ford_digit_random_number = mt_rand(1000, 9999);
        $four_digit_random_number = mt_rand(1000, 9999);
        $five_digit_random_number = mt_rand(10000, 99999);
        $then_digit_random_number = mt_rand(1000000000, 9999999999);
        $three_digit_random_number = mt_rand(100, 999);
        $tow_digit_random_number = mt_rand(10, 30);
        $one_digit_random_number = mt_rand(01, 12);
        $random_amount = mt_rand(70, 90);

		$fakedpassword  = "$fakedLastName$fakedFirstName$ford_digit_random_number";
*/
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        extract($_POST);
    } elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
        extract($_GET);
    }

    if (isset($_GET['number'])){
        $s_search = $_GET['number'];
    }
    
function GetStr($string, $start, $end) {
    $str = explode($start, $string);
    $str = explode($end, $str[1]);  
    return $str[0];
}
function inStr($string, $start, $end, $value) {
    $str = explode($start, $string);
    $str = explode($end, $str[$value]);
    return $str[0];
}
function inStrr($results,$as){
	$results=strtoupper($results);
	if(!is_array($as)) $as=array($as);
	for($i=0;$i<count($as);$i++) if(strpos(($results),strtoupper($as[$i]))!==false) return true;
	return false;
}
$_random_number = mt_rand(0, 100);
$chxs = curl_init('https://vhimne.com/chk/Braintree/user_agent_database_search.php');
curl_setopt($chxs, CURLOPT_RETURNTRANSFER, true);
curl_setopt($chxs, CURLOPT_FOLLOWLOCATION, true);
//Set the proxy IP.
//curl_setopt($chxs, CURLOPT_PROXY, "$prosock5h");
$outputsx = curl_exec($chxs);
//echo $outputsx."\n";
$location = json_decode(trim(strip_tags($outputsx)), true);
$agent = $location['search_results']['user_agents'][''.$_random_number.'']['user_agent'];
//print_r($location);
//print_r($agent);

//echo $agent."\n";





$chx = curl_init('https://ipinfo.io/json');
curl_setopt($chx, CURLOPT_RETURNTRANSFER, true);
curl_setopt($chx, CURLOPT_FOLLOWLOCATION, true);
//Set the proxy IP.
curl_setopt($chx, CURLOPT_PROXY, "$prosock5h");
$outputs = curl_exec($chx);
//echo $outputs."\n";

$timezone = trim(strip_tags(getStr($outputs,'"timezone": "','"')));
$postal = trim(strip_tags(getStr($outputs,'"postal": "','"')));
$city = trim(strip_tags(getStr($outputs,'"city": "','"')));
$statecode = trim(strip_tags(getStr($outputs,'"region": "','"')));
$statecode = strtolower($statecode);

if($statecode=="alabama"){ $statecode="AL";
}else if($statecode=="alaska"){ $statecode="AK";
}else if($statecode=="arizona"){ $statecode="AR";
}else if($statecode=="california"){ $statecode="CA";
}else if($statecode=="olorado"){ $statecode="CO";
}else if($statecode=="connecticut"){ $statecode="CT";
}else if($statecode=="delaware"){ $statecode="DE";
}else if($statecode=="district of columbia"){ $statecode="DC";
}else if($statecode=="florida"){ $statecode="FL";
}else if($statecode=="georgia"){ $statecode="GA";
}else if($statecode=="hawaii"){ $statecode="HI";
}else if($statecode=="idaho"){ $statecode="ID";
}else if($statecode=="illinois"){ $statecode="IL";
}else if($statecode=="indiana"){ $statecode="IN";
}else if($statecode=="iowa"){ $statecode="IA";
}else if($statecode=="kansas"){ $statecode="KS";
}else if($statecode=="kentucky"){ $statecode="KY";
}else if($statecode=="louisiana"){ $statecode="LA";
}else if($statecode=="maine"){ $statecode="ME";
}else if($statecode=="maryland"){ $statecode="MD";
}else if($statecode=="massachusetts"){ $statecode="MA";
}else if($statecode=="michigan"){ $statecode="MI";
}else if($statecode=="minnesota"){ $statecode="MN";
}else if($statecode=="mississippi"){ $statecode="MS";
}else if($statecode=="missouri"){ $statecode="MO";
}else if($statecode=="montana"){ $statecode="MT";
}else if($statecode=="nebraska"){ $statecode="NE";
}else if($statecode=="nevada"){ $statecode="NV";
}else if($statecode=="new hampshire"){ $statecode="NH";
}else if($statecode=="new jersey"){ $statecode="NJ";
}else if($statecode=="new mexico"){ $statecode="NM";
}else if($statecode=="new york"){ $statecode="NY";
}else if($statecode=="north carolina"){ $statecode="NC";
}else if($statecode=="north dakota"){ $statecode="ND";
}else if($statecode=="ohio"){ $statecode="OH";
}else if($statecode=="oklahoma"){ $statecode="OK";
}else if($statecode=="oregon"){ $statecode="OR";
}else if($statecode=="pennsylvania"){ $statecode="PA";
}else if($statecode=="rhode Island"){ $statecode="RI";
}else if($statecode=="south carolina"){ $statecode="SC";
}else if($statecode=="south dakota"){ $statecode="SD";
}else if($statecode=="tennessee"){ $statecode="TN";
}else if($statecode=="texas"){ $statecode="TX";
}else if($statecode=="utah"){ $statecode="UT";
}else if($statecode=="vermont"){ $statecode="VT";
}else if($statecode=="virginia"){ $statecode="VA";
}else if($statecode=="washington"){ $statecode="WA";
}else if($statecode=="west virginia"){ $statecode="WV";
}else if($statecode=="wisconsin"){ $statecode="WI";
}else if($statecode=="wyoming"){ $statecode="WY";
}else if($statecode=="district of columbia"){ $statecode="DC";
}else{$statecode="KY";}


$fakedstreetAddressx = preg_replace('/\s+/', '+', $fakedstreetAddress);
$fakedstreetAddresssx = rawurlencode($fakedstreetAddress);

$citys = preg_replace('/\s+/', '+', $city);
$citysx = rawurlencode($city);

$phone = "310$three_digit_random_number$four_digit_random_number";
$emailids = rawurlencode($emailid);
$pass = generateRandomString();

/*
echo $fakedFirstName . "\n";
echo $fakedLastName . "\n";
echo $fakedstreetAddress . "\n";
echo $city . "\n";
echo $statecode . "\n";
echo $postal . "\n";
echo $phone . "\n";
echo $emailid . "\n";
echo $prosock5h . "\n";
*/
header('Content-Type: application/json; charset=utf-8');
# -------------------- [2 REQ] -------------------#
$postdata = "$number";

$datasave = base64_decode("Y3VybCAtTCA=");
$datasave .= base64_decode("J2h0dHBzOi8vYXBpLmRhdGEyNDcuY29tL3YvMi4wP2FwaT1UJnVzZXI9cXNtb2JpbGVsb29rdXAmcGFzcz14TTQzOGsyV3ozJm91dD1qc29uJnAxPQ==");
$datasave .= $postdata.base64_decode("JyBcCiAgLUggJ2F1dGhvcml0eTogYXBpLmRhdGEyNDcuY29tJyBcCiAgLUggJ2FjY2VwdDogdGV4dC9odG1sLGFwcGxpY2F0aW9uL3hodG1sK3htbCxhcHBsaWNhdGlvbi94bWw7cT0wLjksaW1hZ2UvYXZpZixpbWFnZS93ZWJwLGltYWdlL2FwbmcsKi8qO3E9MC44LGFwcGxpY2F0aW9uL3NpZ25lZC1leGNoYW5nZTt2PWIzO3E9MC45JyBcCiAgLUggJ2FjY2VwdC1sYW5ndWFnZTogZW4tVVMsZW47cT0wLjgnIFwKICAtSCAnc2VjLWNoLXVhLW1vYmlsZTogPzAnIFwKICAtSCAnc2VjLWNoLXVhLXBsYXRmb3JtOiAibWFjT1MiJyBcCiAgLUggJ3NlYy1mZXRjaC1kZXN0OiBkb2N1bWVudCcgXAogIC1IICdzZWMtZmV0Y2gtbW9kZTogbmF2aWdhdGUnIFwKICAtSCAnc2VjLWZldGNoLXNpdGU6IG5vbmUnIFwKICAtSCAnc2VjLWZldGNoLXVzZXI6ID8xJyBcCiAgLUggJ3VwZ3JhZGUtaW5zZWN1cmUtcmVxdWVzdHM6IDEnIFwKICAtSCAndXNlci1hZ2VudDogTW96aWxsYS81LjAgKE1hY2ludG9zaDsgSW50ZWwgTWFjIE9TIFggMTBfMTRfNikgQXBwbGVXZWJLaXQvNTM3LjM2IChLSFRNTCwgbGlrZSBHZWNrbykgQ2hyb21lLzEwMy4wLjAuMCBTYWZhcmkvNTM3LjM2JyBcCiAgLS1jb21wcmVzc2Vk");
    // $datasave .= $data.base64_decode("Jw==");
     
     $result = shell_exec($datasave);
     
     		//	$resultData = json_decode($result);

				echo $result;
//echo $result."\n";

//$Address = rawurlencode($Address);
//$User_Agent = $user_agent_r;


# -------------------- [2 REQ] -------------------#

/*
		$resultData['results'] = array(
			
    $resultData = [ 'Name' => "$fakedFirstName $fakedLastName"],
    $resultData = [ 'FirstName' => "$fakedFirstName"],
    $resultData = [ 'LastName' => "$fakedLastName"],
    $resultData = [ 'Address' => "$fakedstreetAddress"],
    $resultData = [ 'City' => "$city"],
    $resultData = [ 'State' => "$statecode"],
    $resultData = [ 'Postal' => "$postal"],
    $resultData = [ 'Phone' => "$phone"],
    $resultData = [ 'Email' => "$emailid"],
    $resultData = [ 'Proxy' => "$prosock5h"],
			);
*/

/*
			$resultDatass = array();
if (stringMatch($results, "reCAPTCHA")){
			$resultDatas['status'] = "#UnKnow";
			$resultDatas['message'] = "The reCAPTCHA was invalid. Go back and try it again.";
	}else if (stringMatch($results, "Gateway Rejected: cvv")){
			$resultDatas['status'] = "#live";
			$resultDatas['message'] = "Gateway Rejected: cvv";
	}else if (stringMatch($results, "Card Issuer Declined CVV")){
			$resultDatas['status'] = "#live";
			$resultDatas['message'] = "Card Issuer Declined CVV";
	}else if (stringMatch($results, "Invalid Security Code")){
			$resultDatas['status'] = "#live";
			$resultDatas['message'] = "Invalid Security Code";
	}else if (stringMatch($results, "Declined for CVV failure")){
			$resultDatas['status'] = "#live";
			$resultDatas['message'] = "Declined for CVV failure";
	}else if ($statusCode == 200){
			$resultDatas['status'] = "#live";
			$resultDatas['error_msge'] = "successfully";
			$resultDatas['result'] = "$results";
	}else if (stringMatch($results, "reCAPTCHA")){
			$resultDatas['status'] = "#UnKnow";
			$resultDatas['message'] = "The reCAPTCHA was invalid. Go back and try it again.";
	}else if ($statusCode == 422){
			$resultDatas['status'] = "#die";
			$resultDatas['error_msge'] = "unsuccessfully";
			//$resultDatas['msg2'] = "$AuthMessage";
	}else{
			$resultDatas['status'] = "#UnKnow";
			$resultDatas['result'] = "$results";
			//$resultDatas['response'] = "$statusCode";
	}

			$resultDatas['card'] = "$ccline";
			$resultDatas['postal'] = "$postal";
			$resultDatas['response_status'] = "$statusCode";
			$resultDatas['message_error'] = "$AuthMessage";
			$resultDatas['credits'] = "$credit";
			$resultDatas = json_encode($resultDatas);
				echo $resultDatas;
*/
/*
   $resultData['results'] = array([
    'Uuid' => "$fakeduuid",
    'Name' => "$fakedFirstName $fakedLastName",
    'FirstName' => "$fakedFirstName",
    'LastName' => "$fakedLastName",
    'Address' => "$fakedstreetAddress",
    'City' => "$city",
    'State' => "$statecode",
    'Postal' => "$postal",
    'Phone' => "$phone",
    'Email' => "$emailid",
    'Proxy' => "$prosock5h",
    'Password' => "$fakedpassword",
	'Md5' => "$emailidmd5",
	'User_Agent' => "$agent",
],
 );
 */



$infowork = "$fakeduuid:$fakedFirstName $fakedLastName:$fakedFirstName:$fakedLastName:$fakedstreetAddress:$city:$statecode:$postal:$phone:$emailid:$pass:$prosock5h";
//echo $infowork . "\n";

$fpFileData = fopen('infowork.txt', "a+");
fwrite($fpFileData, $resultData."\n");
fwrite($fpFileData, $infowork."\n");
fclose($fpFileData);

/*

    $curl = curl_init();
    curl_setopt_array($curl, [
                      CURLOPT_URL => "https://privatix-temp-mail-v1.p.rapidapi.com/request/mail/id/$emailidmd5/format/json/",
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_FOLLOWLOCATION => true,
                      CURLOPT_ENCODING => "",
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 30,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => "GET",
                      CURLOPT_HTTPHEADER => [
                      "x-rapidapi-host: privatix-temp-mail-v1.p.rapidapi.com",
                      "x-rapidapi-key: 8b24694926msh0f53c5a48e81ab8p17bfb7jsn1349e4bfecd0"
                      ],
                      ]);
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    
    $emailidx = $response;
    $emailidx = htmlspecialchars_decode($emailidx, ENT_QUOTES);
    //echo $emailidmd5;
    
    
    if ($err) {
//     echo "cURL Error #:" . $err;
     } else {
//     echo $response;
     }
    */
    //$textFrom = trim(strip_tags(getStr($emailidx, '"items":[{','"textFrom":"Airbnb ","textSubject":"Please confirm your email address"')));
    //echo $textFrom."\n";
    //$mid = trim(strip_tags(getStr($emailidx, '"mid":"','","textDate":"')));
    
    
    //echo $Confirm."\n";
    
    
    //$re_9_9 = '/(?P<name>Confirm email)\s*.+([\x5b](https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,4}\b([-a-zA-Z0-9@:%_\+.~#?&\/\/=]*))[\x5d])/i';
    
    $re_9_9 = '/https:\/\/www.airbnb.com\/confirm_email([-a-zA-Z0-9@:%_\+.~#?&\/\/=])*\b/i';
    //preg_match_all($re, $emailidx, $matches, PREG_SET_ORDER, 0);
    preg_match_all($re_9_9, $emailidx, $matches_9_9, PREG_SET_ORDER, 0);
    //print_r($matches_9_9);
    //var_dump($matches_9_9);
    
    // Print the entire match result
    $Confirm = $matches_9_9[0][0];
    //echo $Confirm."\n";
    
    
    //$Confirm = str_replace("\/\/", "//", $Confirm);
    ///$Confirm = str_replace("\/", "/", $Confirm);
    
    //echo $Confirm."\n";


function curl($s_url, $s_method = false, $s_header = false) {
    //echo "Send => $s_url <br>Data => $s_method <br>Header => ".$s_header."<br><br>";
    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, $s_url);
	//curl_setopt($ch, CURLOPT_PROXY, "http://$super_proxy:$port");
	//curl_setopt($ch, CURLOPT_PROXYUSERPWD, "$username:$password");
    //curl_setopt($ch, CURLOPT_PROXY, $socks5);
    //curl_setopt($ch, CURLOPT_PROXYUSERPWD, $rotate); 
    //curl_setopt($curl_handle, CURLOPT_PROXYUSERPWD, "$username-session-$session:$password");
    curl_setopt($curl_handle, CURLOPT_PROXY, $proxy);
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl_handle, CURLOPT_HEADER, 1);
    //curl_setopt($curl_handle, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    //curl_setopt($ch, CURLOPT_REFERER, $_SERVER['REQUEST_URI']);
    if (is_array($s_header)){
        curl_setopt($curl_handle, CURLOPT_HTTPHEADER, $s_header);
    }
    curl_setopt($curl_handle, CURLOPT_COOKIEJAR, $cookieFile); //save cookies here
    curl_setopt($curl_handle, CURLOPT_COOKIEFILE, $cookieFile); //read cookies from here
    curl_setopt($curl_handle, CURLOPT_VERBOSE, TRUE);
   //curl_setopt($curl_handle, CURLOPT_COOKIE, 'PHPSESSID=' . $_COOKIE['PHPSESSID']);
    curl_setopt($curl_handle, CURLOPT_COOKIESESSION, TRUE);
    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    if ($s_method != false){
        curl_setopt($curl_handle, CURLOPT_POST, 1);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $s_method);
    }
    curl_setopt($curl_handle, CURLOPT_FOLLOWLOCATION, 1);
    $respone_html = curl_exec($curl_handle);
    curl_close($curl_handle);
    return $respone_html;
}
function stringMid($s_string, $s_begin, $s_end) {
    $s_contents = $s_string;
    $ini = strpos($s_contents, $s_begin);
    if ($ini == 0) {
        return false;
    }
    $ini+= strlen($s_begin);
    $len = strpos($s_contents, $s_end, $ini) - $ini;
    $s_returnsrt = substr($s_string, $ini, $len);
    return $s_returnsrt;
}
function stringMatch($s_srt, $s_findmatch) {
    $s_return = false;
    $s_compare_match = strripos($s_srt, $s_findmatch);
    if ($s_compare_match === false) {
        $s_return = false;
    } else {
        $s_return = true;
    }
    return $s_return;
}
function arrayReplace($s__string, $s__search, $s__replace) {
    $returnStr = $s__string;
    for ($i = 0;$i < count($s__search);$i++) {
        $returnStr = str_replace($s__search[$i], $s__replace[$i], $returnStr);
    }
    return $returnStr;
}
function generateRandomString($length = 12) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

//echo generateRandomString();



/*
require_once("init.db.php");

// Startover
if ( isset($_GET['reset']) == 1 ){
   //$DB->query("UPDATE fff_logs SET log_status=0");
}

//$data_sql = $DB->query("SELECT * FROM fff_logs WHERE log_status='0' ORDER BY log_id ASC LIMIT 500");
/*
while ( $data = $data_sql->fetch_array() )
{
    // Processing
    //$DB->query("UPDATE fff_logs SET log_status=1 WHERE log_id='{$data['log_id']}'");
	//$DB->query("UPDATE users SET user_credit=1 WHERE id='{$data['id']}'");
	$DB->query("UPDATE users SET user_credit=0 WHERE id LIKE '%1%'");
    //$data = strFilter($data);
    // Completed
    //updateDecode($data);
}
*/

//$DB = db_connect($dbconfig);
/*
function func($conn)
{
    $query = "UPDATE users SET user_credit = user_credit - 2";
    $result = mysqli_query($conn, $query);
}
*/
//var_dump($DB);
/*
header('Content-Type: text/plain; charset=utf-8');

//print_r($DB);
//$data_sqls = $DB->query("UPDATE users SET user_credit=0 WHERE id LIKE '%1%'");
//$data_sqls = $DB->query("UPDATE users SET user_credit = user_credit + 2000");
//$DB->query("UPDATE users SET user_credit=1 WHERE id='{$data['id']}'");
//$data_sqlx = $DB->query("SELECT id=1 FROM users WHERE username='xenhim'");

//$data_sqlxx = $DB->query("SELECT user_credit FROM users WHERE id='1'");
//print_r($data_sqlxx);
//var_dump($data_sqlxx);
//echo($data_sqls)."\r";
$sql = "SELECT user_credit FROM users WHERE id='1'";
$rs  = $DB->query($sql);
$row = mysqli_fetch_object($rs);
//$result["user_credit"] = $row->user_credit;
//echo json_encode($result)."\r";
$result = $row->user_credit;
echo ($result)."\r";

$sum = 5.0000001;
$val = "$result".".00";
$a = round($val - $sum,2);
$credit = $a;
$query = "UPDATE users SET user_credit=$credit WHERE id='1'";
//echo ($query)."\r";
$rss  = $DB->query($query);
$roww = mysqli_fetch_object($rss);
$results = $roww->user_credit;
echo ($results)."\r";

/*
while ($row = mysqli_fetch_object($rs)) {
    echo "user_credit:   ", $row->user_credit, "\r";
}
*/
//print_r($row);


//print_r($a."\r");


/*
if ( $DB->query("INSERT INTO users (user_credit) VALUES ('{$credit}')") )
{
    echo "Saved";
}
*/

//print_r($a, $a === 0);
//echo("$a, $a === 0")."\r";
//var_dump($a, $a === 0);

/*
if($balance > '0'){
 $amount = min($due, $balance);
 $data = array('invoice_id' => $invoice_id, 'balance_pay' => '1', 'amount' => $amount,);
 $this->payments_m->create($data);
}

$free_credits -= $cost;
if($free_credits < 0) {
    $regular_credits += $free_credits;
    $free_credits = 0;
}
*/
/*
include("chilkat_9_5_0.php");

$crypt = new CkCrypt2();

$success = $crypt->UnlockComponent('Anything for 30-day trial');
if ($success != true) {
    print $crypt->lastErrorText() . "\n";
    exit;
}

//  AES is also known as Rijndael.
$crypt->CryptAlgorithm = 'aes';

//  CipherMode may be "ecb" or "cbc"
$crypt->CipherMode = 'cbc';

//  KeyLength may be 128, 192, 256
$crypt->KeyLength = 256;

//  The padding scheme determines the contents of the bytes
//  that are added to pad the result to a multiple of the
//  encryption algorithm's block size.  AES has a block
//  size of 16 bytes, so encrypted output is always
//  a multiple of 16.
$crypt->PaddingScheme = 0;

//  EncodingMode specifies the encoding of the output for
//  encryption, and the input for decryption.
//  It may be "hex", "url", "base64", or "quoted-printable".
$crypt->EncodingMode = 'hex';

//  An initialization vector is required if using CBC mode.
//  ECB mode does not use an IV.
//  The length of the IV is equal to the algorithm's block size.
//  It is NOT equal to the length of the key.
$ivHex = '000102030405060708090A0B0C0D0E0F';
$crypt->SetEncodedIV($ivHex,'hex');

//  The secret key must equal the size of the key.  For
//  256-bit encryption, the binary secret key is 32 bytes.
//  For 128-bit encryption, the binary secret key is 16 bytes.
$keyHex = '000102030405060708090A0B0C0D0E0F101112131415161718191A1B1C1D1E1F';
$crypt->SetEncodedKey($keyHex,'hex');

//  Encrypt a string...
//  The input string is 44 ANSI characters (i.e. 44 bytes), so
//  the output should be 48 bytes (a multiple of 16).
//  Because the output is a hex string, it should
//  be 96 characters long (2 chars per byte).
$encStr = $crypt->encryptStringENC('The quick brown fox jumps over the lazy dog.');
print $encStr . "\n";

//  Now decrypt:
$decStr = $crypt->decryptStringENC($encStr);
print $decStr . "\n";
*/




?>

