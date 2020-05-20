# PHP Advanced registration website INSTALL TUTORIAL
* Step 1 "Import database file" <br/>
You can see the "hex3f.sql" in the source file. This is database back-up. But you need a mysql database. 
Now you just need import the sql file. 

* Step 2 "Modify configuration file" <br/>
This file is in "/hex3f/api/config.php". You need to fill in all the config to run the website. <br/>
$baidu_ak -> Baidu map ak number
$accessKeyId -> Alibaba Cloud sms AccessKeyId
$accessKeySecret -> Alibaba Cloud sms AccessKeySecret
$SignName -> Alibaba Cloud sms sign name
$TemplateCode -> Alibaba Cloud sms template code
$TemplateCodeMD5 -> Alibaba Cloud sms to send md5 code
$TemplateCodeCAESARPASSWORD ->  Alibaba Cloud sms to send caesar password code
