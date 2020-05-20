<?php
header("Content-type: text/html; charset=utf-8");
$login_key = "xxxxx";
$login = false;
$phone = "";
$ip = "";
$username = "";
$email = "";
session_start();

if(is_array($_POST)&&count($_POST)>0)//判断是否有Get参数
{
	if(isset($_POST["login_key"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
	{
		if(strlen($_POST['login_key']) > 10){
			$login_key = $_POST['login_key'];
		}
	}
}

$login_key = unlockString($login_key,"hex3fcom339999909");
$login_key = unlockString($login_key,"hex3fcom339999909-fojfklsdmfaklsdfoiweunfuiernfkjsad/**");

require '../../api/db_conn.php';
$sql = "SELECT encryption_login_key,username,ip,email,phone_number FROM account";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		if($row['encryption_login_key'] == $login_key){
			$_SESSION['FILE_NAME'] = md5(sha1($login_key));
			$file_name = $_SESSION['FILE_NAME'];
			$myfile = fopen("../key/".$file_name.".hex3f", "r");
			$_SESSION["first_key"] = fgets($myfile);
			echo $_SESSION["first_key"];
			//echo "数据已配对";
			fclose($myfile);
			$_SESSION["ip"] = long2ip($row['ip']);
			$_SESSION["username"] = $row['username'];
			$_SESSION["email"] = $row['email'];
			$_SESSION["phone"] = $row['phone_number'];
			$_SESSION["login_1"] = true;
		}else{
			echo "没有配对的数据";
		}
	}
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