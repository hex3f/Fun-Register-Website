<?php
session_start();

require '../api/db_conn.php';
require '../api/config.php';
require '../api/sms.php';

/* ajax post data */
$code = $_POST['encryption_Code'];
$phonenumber = $_POST['PhoneNumber'];

if(preg_match($phone_rule, $phonenumber) == "1"){	// 正则校验
		
	$sql_search_same_number = "SELECT reg_phone,code_encryption FROM reg_check";
	$result = $conn->query($sql_search_same_number);
	if ($result->num_rows > 0) {
		// 输出数据
		while($row = $result->fetch_assoc()) {
			//判断手机号与code是否符合
			if($row["reg_phone"] == $phonenumber && $row["code_encryption"] == $code){
				goto writeMYSQLDB;
			}
		}
		echo "CODE与手机号不匹配或不存在";
		return;
	}
}else{
	echo "手机格式错误";
	return;
}
writeMYSQLDB:
$sql_search_account = "SELECT phone_number FROM account";
$result = $conn->query($sql_search_account);
if ($result->num_rows > 0) {
	// 输出数据
	while($row = $result->fetch_assoc()) {
		//判断数据库内是否存在该号码
		if($row["phone_number"] == $phonenumber){
			echo "号码已通过验证";
			return;
		}else{
			/* 开始写入预备账号数据库 */
			
			$temporary_key = make_password(20);
			$temporary_key = $temporary_key.$phonenumber;
			$temporary_key = md5($temporary_key);
			$sql_insert_key_number = "INSERT INTO account ( phone_number,temporary_key ) VALUES ('{$phonenumber}','{$temporary_key}')";
			mysqli_query($conn,"DELETE FROM reg_check WHERE reg_phone='{$phonenumber}'");
			if ($conn->query($sql_insert_key_number) === TRUE) {
				// 存储 session 数据
				$_SESSION['phone'] = $phonenumber;
				$_SESSION["key"] = $temporary_key;
				$_SESSION["reg_login"] = true;
				echo "数据存入成功";
				return;
			}else{
				echo $conn->error;
			}

			/* 结束写入预备账号数据库 */
		}
	}
	echo "CODE与手机号不匹配或不存在";
	return;
}else{
	/* 开始写入预备账号数据库 */
	
	$temporary_key = make_password(20);
	$temporary_key = $temporary_key.$phonenumber;
	$temporary_key = md5($temporary_key);
	$sql_insert_key_number = "INSERT INTO account ( phone_number,temporary_key ) VALUES ('{$phonenumber}','{$temporary_key}')";
	mysqli_query($conn,"DELETE FROM reg_check WHERE reg_phone='{$phonenumber}'");
	if ($conn->query($sql_insert_key_number) === TRUE) {
		// 存储 session 数据
		$_SESSION['phone'] = $phonenumber;
		$_SESSION["key"] = $temporary_key;
		$_SESSION["reg_login"] = true;
		echo "数据存入成功";
		return;
	}else{
		echo $conn->error;
	}

	/* 结束写入预备账号数据库 */
}