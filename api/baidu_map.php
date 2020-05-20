<?php
function getip() {
  static $ip = '';
  $ip = $_SERVER['REMOTE_ADDR'];
  if(isset($_SERVER['HTTP_CDN_SRC_IP'])) {
	$ip = $_SERVER['HTTP_CDN_SRC_IP'];
  } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
	$ip = $_SERVER['HTTP_CLIENT_IP'];
  } elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
	foreach ($matches[0] AS $xip) {
	  if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
		$ip = $xip;
		break;
	  }
	}
  }
  return $ip;
}
function curl_get($url) {
	$ch = curl_init();
	$timeout = 300;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$res = curl_exec($ch);

	if (curl_errno($ch)) {
		echo 'Curl error: ' . curl_error($ch);
	}

	curl_close($ch);
	return $res;
}
require 'config.php';
global $ak;
$ak = $baidu_ak;
function  getaddress($ip){
	if($ip == "127.0.0.1"){
		print_r("localhost:debug");
		return;
	}
	if(str_split($ip,3)[0] == "172" || str_split($ip,3)[0] == "192"){
		print_r("LAN");
		return;
	}
	$url = "http://api.map.baidu.com/location/ip?ip=".$ip."&ak=".$GLOBALS['ak']."&coor=";
	$res=curl_get($url);
	$user_json = json_decode($res,true); //数据转换
	print_r($user_json["content"]['address']);
}