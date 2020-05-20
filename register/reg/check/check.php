<?php
$key = "";
$phone = "";
$t_key = "";
$ip = "";
$username = "";
$email = "";
session_start();
require '../../../api/db_conn.php';
require '../../../api/config.php';
$chenkUser = "/^[a-zA-Z][a-zA-Z0-9]{4,15}$/"; /* USER校验 */
$chenkIP = "/^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/"; /* 通讯IP地址 */
$chenkEmail = "/^([a-zA-Z]|[0-9])(\w|\-)+@[a-zA-Z0-9]+\.([a-zA-Z]{2,4})$/"; /* USER校验 */

//  判断是否登陆
if (isset($_SESSION["reg_login"]) && $_SESSION["reg_login"] === true) {
	
	$key = $_SESSION["key"];
	$phone = $_SESSION['phone'];
	$username = $_POST['username'];
	$ip = $_POST['ip'];
	$email = $_POST['email'];
	
	if($username != "" && $ip != "" && $email != ""){
		if(preg_match($chenkUser, $username) && preg_match($chenkIP, $ip) && preg_match($chenkEmail, $email) && preg_match($phone_rule, $phone)){
				$sql_search_account = "SELECT temporary_key,ip FROM account";
				$result = $conn->query($sql_search_account);
				if ($result->num_rows > 0) {
					// 输出数据
					$same_ip = false;
					$encryption_ip = ip2long($ip);
					while($row = $result->fetch_assoc()) {
						//echo $row["ip"];	//调试相同IP
						//echo "sql:".$row["temporary_key"];
						//echo "local:".$key;
						if($row["ip"] == $encryption_ip){
							$same_ip = true;
						}
					}
					$sql_search_account = "SELECT phone_number,temporary_key,encryption_login_key,ip FROM account";
					$result = $conn->query($sql_search_account);
					
					while($row_2 = $result->fetch_assoc()) {
						//判断数据库内是否存在该号码
						if($row_2["temporary_key"] == $key){
							if($same_ip){
								echo "存在相同IP";
								die();
							}
							//$_SESSION["reg_login"] = false;
							$_SESSION["getkey_reg_login"] = true;
							$_SESSION["reg_login"] = false;
							$_SESSION["ip"] = $ip;
							$_SESSION["t_key"] = $key;
							$_SESSION["username"] = $username;
							$_SESSION["email"] = $email;
							echo "验证成功";
							die();
								
						}else{
							echo "数据库内不存在这个注册KEY";
							die();
						}
					}
					
				}
		}else{
			echo "参数格式不正确";
			die();
		}
	}else{
		echo "空";
		die();
	}
	//echo "已通过验证";
	//echo $_SESSION["phone"];
}
else {
	$_SESSION["reg_login"] = false;
	$key = $_POST['key'];
	if($key == ""){
		echo "空";
		die();
	}
	$sql_search_account = "SELECT temporary_key,phone_number FROM account";
	$result = $conn->query($sql_search_account);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			if($row["temporary_key"] == $key){
				$_SESSION["reg_login"] = true;
				$_SESSION["key"] = $key;
				$_SESSION['phone'] = $row["phone_number"];
				echo "key校验成功";
			}
		}
	}
}
?>