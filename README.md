# PHP Advanced registration website install tutorial
* Step 1 "Import database file" <br/>
You can see the "hex3f.sql" in the source file. This is database back-up. But you need a mysql database. 
Now you just need import the sql file. 

* Step 2 "Modify configuration file" <br/>
This file is in "/hex3f/api/config.php". You need to fill in all the config to run the website. <br/><br/>
 1. $baidu_ak -> Baidu map ak number <br/>
 2. $accessKeyId -> Alibaba Cloud sms AccessKeyId <br/>
 3. $accessKeySecret -> Alibaba Cloud sms AccessKeySecret <br/>
 4. $SignName -> Alibaba Cloud sms sign name <br/>
 5. $TemplateCode -> Alibaba Cloud sms template code <br/>
 6. $TemplateCodeCAESARPASSWORD ->  Alibaba Cloud sms to send caesar password code <br/>

* This is my sms template <br/>
TemplateCodeCAESARPASSWORD: <br/>
注册码：${code}，请将注册码进行凯撒密码加密，位移量为手机号最后一位，并向首页的code变量进行GET传参即可开始注册！ <br/>
TemplateCodeMD5: <br/>
注册码：${code}，请将前五位进行MD5加密，且合并在一起，向首页的code变量进行GET传参即可开始注册！ <br/>

<div align=center><b>NOW YOU JUST NEED TO ENJOY!</b> <br/>
<img src="index.png" width="80%" align=center>
