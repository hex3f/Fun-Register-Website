<?php
/* 首页参数 */
$index_title = "HEX3F - 首页";			//首页title
$filing_url = "http://www.beian.miit.gov.cn/";	//备案跳转页面

/* 首页效果字 */
$index_textEffect = array();
$index_textEffect[0] = "<p>欢迎来到hex3f</p>";
$index_textEffect[1] = "<p>控制台输入 <span style='color:red;'>register();</span> 开始注册</p>";

/* 数据库连接参数 */
$dbservername = 'localhost:3306';	//数据IP地址
$dbusername = 'root';				//数据库用户名
$dbpassword = 'root';					//数据库密码
$dbname = 'hex3f';				//数据库名

/* 百度地图API AK */
$baidu_ak = "";

/* 短信调试 */
$open_sms_send = true;	//开启发送短信
$sms_debug_mode = false;
$sms_debug_number = "";

/* 正则表达式 */
$phone_rule  = "/^(13[0-9]|14[5-9]|15[012356789]|166|17[0-8]|18[0-9]|19[8-9])[0-9]{8}$/";  //手机号码正则表达式

/* 移动端进入网站跳转页面 */
$mobile_url = "http://www.hex3f.com";

/* 扫雷验证配置 */
$checkgame_rows = 10;
$checkgame_cols = 10;
$checkgame_mines = 15;

/* 阿里云短信服务 */
// TODO 此处需要替换成开发者自己的AK (https://ak-console.aliyun.com/)
$accessKeyId = ""; // AccessKeyId
$accessKeySecret = ""; // AccessKeySecret
$SignName = "";	//设置签名名称，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
$TemplateCode = "";//设置模板CODE，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
$TemplateCodeMD5 = "";				//MD5
$TemplateCodeCAESARPASSWORD = "";	//CAESARPASSWORD





