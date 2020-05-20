<?php

require '../api/config.php';
require '../api/sms.php';
require '../api/db_conn.php';

if($sms_debug_mode){
	/* 调试数据 */
	$phoneNmber = $sms_debug_number;
	$readysend = true;
}else{
	if(is_array($_POST)&&count($_POST)>0){
		if(!isset($_POST["PhoneNumber"])){
			die();
		}
		if(!isset($_POST["sendsms"])){
			die();
		}
	}else{
		die();
	}
	/* ajax post data */
	$phoneNmber = $_POST['PhoneNumber'];
	$readysend = $_POST['sendsms'];
}

if($readysend){
	if(preg_match($phone_rule, $phoneNmber) == "1"){	// 正则校验
	
	
	$sql_search_account = "SELECT phone_number FROM account";
	$result = $conn->query($sql_search_account);
	if ($result->num_rows > 0) {
		// 输出数据
		while($row = $result->fetch_assoc()) {
			//判断数据库内是否存在该号码
			if($row["phone_number"] == $phoneNmber){
				echo "该号码已注册";
				die();
			}
		}
	}
		
	$sql_search_same_number = "SELECT reg_phone,step,reg_method FROM reg_check";
	$result = $conn->query($sql_search_same_number);
	
	if ($result->num_rows > 0) {
		// 输出数据
		while($row = $result->fetch_assoc()) {
			//判断手机号是否已接受过短信
			if($row["reg_phone"] == $phoneNmber){
				$code = rand_send($phoneNmber, "other");
				if( $code[0] == "MD5" ){
					$_TemplateCode = $TemplateCodeMD5;
				}else if( $code[0] == "CAESARPASSWORD" ){
					$_TemplateCode = $TemplateCodeCAESARPASSWORD;
				}
				mysqli_query($conn,"UPDATE reg_check SET sms_code = '{$code[2]}',reg_method = '{$code[0]}',code_encryption = '{$code[1]}' WHERE reg_phone = '{$phoneNmber}'");//更新code
			}else {
				$code = rand_send($phoneNmber, "other");
				if( $code[0] == "MD5" ){
					$_TemplateCode = $TemplateCodeMD5;
					mysqli_query($conn,"DELETE FROM reg_check WHERE reg_phone='{$phoneNmber}'");
					$sql_insert_code_number = "INSERT INTO reg_check (reg_phone, sms_code, step, reg_method, code_encryption ) VALUES ('{$phoneNmber}', '{$code[2]}', 1, '{$code[0]}', '{$code[1]}')";
					if ($conn->query($sql_insert_code_number) === TRUE) {
						
					}else{
						echo $conn->error;
					}
				}else if( $code[0] == "CAESARPASSWORD" ){
					$_TemplateCode = $TemplateCodeCAESARPASSWORD;
					mysqli_query($conn,"DELETE FROM reg_check WHERE reg_phone='{$phoneNmber}'");
					$sql_insert_code_number = "INSERT INTO reg_check (reg_phone, sms_code, step, reg_method, code_encryption ) VALUES ('{$phoneNmber}', '{$code[2]}', 1, '{$code[0]}', '{$code[1]}')";
					if ($conn->query($sql_insert_code_number) === TRUE) {
						
					}else{
						echo $conn->error;
					}
				}
			}
		}
			
			
			
	}else {
		$code = rand_send($phoneNmber, "other");
		//print_r($code);
		if( $code[0] == "MD5" ){
			$_TemplateCode = $TemplateCodeMD5;
			$sql_insert_code_number = "INSERT INTO reg_check (reg_phone, sms_code, step, reg_method, code_encryption ) VALUES ('{$phoneNmber}', '{$code[2]}', 1, '{$code[0]}', '{$code[1]}')";
			if ($conn->query($sql_insert_code_number) === TRUE) {
				
			}else{
				echo $conn->error;
			}
		}else if( $code[0] == "CAESARPASSWORD" ){
			$_TemplateCode = $TemplateCodeCAESARPASSWORD;
			$sql_insert_code_number = "INSERT INTO reg_check (reg_phone, sms_code, step, reg_method, code_encryption ) VALUES ('{$phoneNmber}', '{$code[2]}', 1, '{$code[0]}', '{$code[1]}')";
			if ($conn->query($sql_insert_code_number) === TRUE) {
				
			}else{
				echo $conn->error;
			}
		}
	}
		
		sendsmsto_phone($open_sms_send, $phoneNmber, $code[2], $SignName, $_TemplateCode, $accessKeyId, $accessKeySecret);	//发信
		
	}else{
		echo '请输入正确的手机号码';
	}
}else{
	echo '请先完成验证';
}




//$response = SmsDemo::querySendDetails();
//echo "查询短信发送情况(querySendDetails)接口返回的结果:\n";
//print_r($response);