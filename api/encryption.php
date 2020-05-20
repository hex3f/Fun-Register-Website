<?php
/* 加密需要传参的CODE */

//MD5
function code_md5($code){
	$codeArray = str_split($code,5);
	$result = md5($codeArray[0]).$codeArray[1];
	return $result;
}

//凯撒密码
function code_caesar($code,$count){
	$reg_code = $code;
	for($j=0;$j<25;$j++)
	{
		if($count == $j){
			 return $reg_code;
		}
		$reg_code = "";
		for ($i=0;$i<strlen($code);$i++)
		{
			$te=ord($code[$i])+1;
			if($te==91)        //如果是小写字母就是123
			{
			$te='65';    //如果是小写字母就是97
			}
			$code[$i] = chr($te);
			$reg_code = $reg_code.$code[$i];
		}
	}
}
