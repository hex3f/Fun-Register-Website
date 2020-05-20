<?php
header("Content-type: text/html; charset=utf-8");
$login_key = "";
$getkey_reg_login = false;
$phone = "";
$t_key = "";
$ip = "";
$username = "";
$email = "";
$encryption_pass_code = "";
session_start();
require '../../api/config.php';
$chenkUser = "/^[a-zA-Z][a-zA-Z0-9]{4,15}$/"; /* USER校验 */
$chenkIP = "/^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/"; /* 通讯IP地址 */
$chenkEmail = "/^([a-zA-Z]|[0-9])(\w|\-)+@[a-zA-Z0-9]+\.([a-zA-Z]{2,4})$/"; /* USER校验 */

//  判断是否登陆
if (isset($_SESSION["getkey_reg_login"]) && $_SESSION["getkey_reg_login"] === true) {
	
	$login_key_1 = $_POST['login_key_1'];
	$login_key_2 = $_POST['login_key_2'];
	//echo strlen($login_key_2);
	if($login_key_1 == "image/png;base64" && strlen($login_key_2) >= 1000){
		
		$getkey_reg_login = true;
		$t_key = $_SESSION["t_key"];
		$phone = $_SESSION['phone'];
		$username = $_SESSION['username'];
		$ip = $_SESSION['ip'];
		$email = $_SESSION['email'];
		
		$encryption_pass_code = str_split($login_key_2,100);
		$login_key = $encryption_pass_code[0].$phone."hex3f-encryption-password";
		
	}else{
		echo "数据错误";
		die();
	}

	if($username != "" && $ip != "" && $email != "" && $phone != "" && $t_key != ""){
	//echo $username."\r\n".$ip."\r\n".$email."\r\n".$phone;
		if(preg_match($chenkUser, $username) && preg_match($chenkIP, $ip) && preg_match($chenkEmail, $email) && preg_match($phone_rule, $phone)){
				require '../../api/db_conn.php';
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
					$sql_search_account = "SELECT temporary_key,ip FROM account";
					$result = $conn->query($sql_search_account);
					
					while($row_2 = $result->fetch_assoc()) {
						//判断数据库内是否存在该号码
						
						if($row_2["temporary_key"] == $t_key){
							if($same_ip){
								echo "存在相同IP";
								return;
							}
							$ip = ip2long($ip);
							
							/* 开始写入预备账号数据库 */
							
							$sql_data = "UPDATE account SET encryption_login_key = '{$login_key}', username = '{$username}', ip = '{$ip}', email = '{$email}', temporary_key = null WHERE phone_number = '{$phone}'";
							
							//php存入时：$ip = ip2long($ip);
							//mysql取出时：SELECT INET_ATON(ip) FROM table ...
							//php取出时，多一步：$ip = long2ip($ip);
							
							//mysqli_query($conn,"DELETE FROM reg_check WHERE reg_phone='{$phonenumber}'");
							
							/* $conn->query($sql_data) === TRUE */
							if ($conn->query($sql_data) === TRUE) {
								
								$myfile = fopen("../key/".md5(sha1($login_key)).".hex3f", "w") or die("Unable to open file!");
								chmod("../key/".md5(sha1($login_key)).".hex3f",0777);
								$txt = $login_key_2;
								fwrite($myfile, $txt);
								fclose($myfile);
								
								$login_key = lockString($login_key,"hex3fcom339999909-fojfklsdmfaklsdfoiweunfuiernfkjsad/**");
								$login_key = lockString($login_key,"hex3fcom339999909");
								
								$_SESSION["reg_login"] = false;
								$_SESSION["getkey_reg_login"] = false;
								$_SESSION["login"] = true;
								$_SESSION["login_key"] =  $login_key;
								$_SESSION["img_data"] =  $txt;
								
								echo "验证成功";
								
								die();
							}else{
								echo $conn->error;
								die();
							}
							/* 结束写入预备账号数据库 */
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
	}
}else if (isset($_SESSION["login_1"]) && $_SESSION["login_1"] === true) {
	
	$login_key_1 = $_POST['login_key_1'];
	$login_key_2 = $_POST['login_key_2'];
	//echo strlen($login_key_2);
	if($login_key_1 == "image/png;base64" && strlen($login_key_2) >= 1000){
		
		//$phone = "18850322821";
		$phone = $_SESSION['phone'];
		$username = $_SESSION['username'];
		$ip = $_SESSION['ip'];
		$email = $_SESSION['email'];
		$file_name = $_SESSION['FILE_NAME'];
		
		$encryption_pass_code = str_split($login_key_2,100);
		$login_key = $encryption_pass_code[0].$phone."hex3f-encryption-password";
		
	}else{
		echo "数据错误";
		die();
	}
	if($username != "" && $ip != "" && $email != "" && $phone != "" && $file_name != ""){
		//echo $username."\r\n".$ip."\r\n".$email."\r\n".$phone;
		if(preg_match($chenkUser, $username) && preg_match($chenkIP, $ip) && preg_match($chenkEmail, $email) && preg_match($phone_rule, $phone)){
				require '../../api/db_conn.php';
				
				$sql_search_account = "SELECT ip FROM account";
				$result = $conn->query($sql_search_account);
				
				while($row = $result->fetch_assoc()) {
					
					if($row["ip"] == ip2long($ip)){
							
							
						/* 开始更新数据 */
						
						$sql_data = "UPDATE account SET encryption_login_key = '{$login_key}' WHERE phone_number = '{$phone}'";
						if ($conn->query($sql_data) === TRUE) {
								
						$myfile = fopen("../key/".md5(sha1($login_key)).".hex3f", "w") or die("Unable to open file!");
						$txt = $login_key_2;
						fwrite($myfile, $txt);
						fclose($myfile);
						
						$login_key = lockString($login_key,"hex3fcom339999909-fojfklsdmfaklsdfoiweunfuiernfkjsad/**");
						$login_key = lockString($login_key,"hex3fcom339999909");
						
						$_SESSION["login"] = true;
						$_SESSION["login_1"] = false;
						$_SESSION["login_key"] =  $login_key;
						$_SESSION["img_data"] = $txt;
						
							if(unlink("../key/".$file_name.".hex3f")){
								echo "验证成功";
								die();
							}else{
								echo "验证文件删除失败";
								die();
							}

						}
						
						/* 结束更新数据 */
						
					}else{
						echo "数据库内不存在这个IP";
						die();
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

}else if(isset($_SESSION["reg_login"]) && $_SESSION["reg_login"] === true){
	echo "你还未验证参数";
	die();
}else {
	//未登录使用key验证
	$_SESSION["reg_login"] = false;
	
	$key = $_POST['key'];
	echo "未通过验证";
}

/**对登录key进行加密。
 * @param $txt
 * @param string $key
 * @return string
 */
function lockString($txt,$key)
{
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-=+";
    $nh = rand(0,64);
    $ch = $chars[$nh];
    $mdKey = md5($key.$ch);
    $mdKey = substr($mdKey,$nh%8, $nh%8+7);
    $txt = base64_encode($txt);
    $tmp = '';
    $i=0;$j=0;$k = 0;
    for ($i=0; $i<strlen($txt); $i++) {
        $k = $k == strlen($mdKey) ? 0 : $k;
        $j = ($nh+strpos($chars,$txt[$i])+ord($mdKey[$k++]))%64;
        $tmp .= $chars[$j];
    }
    return urlencode($ch.$tmp);
}
/**对登录key进行解密。
 * @param $txt
 * @param string $key
 * @return bool|string
 */
function unlockString($txt,$key)
{
    $txt = urldecode($txt);
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-=+";
    $ch = $txt[0];
    $nh = strpos($chars,$ch);
    $mdKey = md5($key.$ch);
    $mdKey = substr($mdKey,$nh%8, $nh%8+7);
    $txt = substr($txt,1);
    $tmp = '';
    $i=0;$j=0; $k = 0;
    for ($i=0; $i<strlen($txt); $i++) {
        $k = $k == strlen($mdKey) ? 0 : $k;
        $j = strpos($chars,$txt[$i])-$nh - ord($mdKey[$k++]);
        while ($j<0) $j+=64;
        $tmp .= $chars[$j];
    }
    return base64_decode($tmp);
}
?>