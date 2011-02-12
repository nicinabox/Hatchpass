<?php
/* Connect to database */
mysql_connect("127.0.0.1", "root", "") or die(mysql_error());
mysql_select_db("hatchpass") or die(mysql_error());

/* Constants */
define(ID, $_GET['id']);
define(HIDE, $_GET['h']);
define(MYURL, "http://".$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
define(DEBUG, false);
define(VERSION, "2.3");
/* Array of symbols */
$symarr = array("!","@","#","]","^","&","*","(","%","[","?","$","{","+","=","}",")","_","-","|","/","<",">");

/* Convert int to string */
function parseSetting($s) {
  switch ($s) {
    case "0":
      return false;
      break;
    case "1":
      return "checked";
      break;
    default:
      break;
  }
}

/* Function to create legacy hash */
function legacyHash($master, $host, $s) {		
	global $symarr;
		
	$hash = hash('sha256',(hash('sha256',($master.":".$host)).$s['id']));
	$pass = substr($hash, 0, $s['strlen']);
	
	if ($s['symbols'] == "1") {
		$host_len = strlen($host);
	
		// First number in salt
		preg_match("([0-9])", $s['id'], $match);
		$salt_num = $match[0];
		
		$passArr = str_split($pass);
		$thisUpper = 1;
		$nums = 0;
		foreach ($passArr as $key => $char) {			
			if(!is_numeric($char)) {
				if ($thisUpper == 0) {
					$thisUpper = 1;
					$passArr[$key] = strtoupper($char);
				} else {
					$thisUpper = 0;
				}
			} else {
				$passArr[$key] .= $symarr[$nums+$salt_num+$thisUpper];
				if ($nums == 0) {
					$pass_num = $char;
				}
				$nums++;
			}
		}
		$string = join($passArr);	
	} else {
		$string = $pass;	
	}
	
	return substr($string, 0, $s['strlen']);
}

/* New method for making hashes */
function defaultHash($master, $host, $s) {		
	global $symarr;
	
	$hash = hash('sha256',(hash('sha256',($master.":".$host)).$s['id']));
	
	$pass = substr($hash, 0, $s['strlen']);
	
	list($domain, $tld) = explode(".", $host);
	
	$host_len = strlen($domain);
	
	// First number in salt
	preg_match("([0-9])", $s['id'], $match);
	$salt_num = $match[0];
	
	$passArr = str_split($pass);
	$thisUpper = 1;
	$nums = 0;
	foreach ($passArr as $key => $char) {			
		if(ctype_alpha($char)) {
			if ($s['caps'] == "1" && $thisUpper == 0) {
				$thisUpper = 1;
				$passArr[$key] = strtoupper($char);
			} else {
				$thisUpper = 0;
			}
		} else {
			if(!isset($firstNum)) {
				$firstNum = $passArr[$key];
			}
			if ($s['symbols'] == "1") {
				$passArr[$key+$firstNum/3] .= $symarr[$nums+$key+$firstNum*$nums+count($tld)*$key];
			}
		
			if ($nums == 0) {
				$pass_num = $char;
			}
			$nums++;
		}
	}
	$string = join($passArr);	
	
	return substr($string, 0, $s['strlen']);
}

function encrypt($text, $salt) {
    return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $salt, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
}

function decrypt($text, $salt) {
    return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $salt, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
}

function newUrl() {
  $now = time();
	$url = substr(crypt($now, md5($now)),0,5);
  return $url;
}

function defaultSettings($id, $method=null) {
    $s->id = $id;
    $s->symbols = 1;
    $s->caps = 1;
    $s->strlen = 10;
    $s->h_algorithm = "default";
  //    $s->r_master = "0";
    $s->r_settings = 0;
  //    $s->r_url = "1";
  
  if ($method == "json") {
    $s = json_encode($s);
  }
  return $s;
}
?>