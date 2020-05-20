var register = "can_not_register";
var sendSMS = "can_not_send";
var gameStyle = document.getElementById("game");
var console_text = document.getElementById("console_text");
var chenkPhone = /^(13[0-9]|14[5-9]|15[012356789]|166|17[0-8]|18[0-9]|19[8-9])[0-9]{8}$/; /* 手机校验 */

$("#console_text").keydown(function() {//给输入框绑定按键事件
	if(event.keyCode == "13") {//判断如果按下的是回车键则执行下面的代码
		/* 注册命令 start */
		if(console_text.value == "register();" && gameStyle.style.display == "block" && register == "register_84c1677aa9267edfe416f513d767e10c6dfc2beeb7cb678d5838db7626807696845936db2f6e92878c4f09958bb7aceee4e6cd3e20c4e8681c367accebd24565:nozuobi"){
			console.log("ERROR:重复开启注册入口");
			console_text.value = "";
			return;
		}
		if(console_text.value == "register();" && sendSMS == "can_not_send"){
			console_text.value = "";
			gameStyle.style.display = "block";
			web_tip("提示","已开启注册入口！","sounds/tip_music.wav");
			console.log("已开启注册入口");
			register = "register_84c1677aa9267edfe416f513d767e10c6dfc2beeb7cb678d5838db7626807696845936db2f6e92878c4f09958bb7aceee4e6cd3e20c4e8681c367accebd24565:nozuobi";
		}
		/* 注册命令 end */
		
		/* 手机验证码命令 start */
		if(sendSMS == "20d1d47b8ac2d9635d2bdf7ec4f17c302bcd956c3dea4bb4aeca366d7e37709551ca509c220ff8495a1642489088d8c0a05e0df1723dbae40dc4da5c23595e33:nozuobi"){
			if(chenkPhone.test(console_text.value)){
				
				
				/* 异步传输手机号码 start */
				
				$.post("check/send_code_sms.php", { PhoneNumber: console_text.value, sendsms: sendSMS},
				   function(data){
					 //console.log(data);	//调试
					   
					 if(data == "发送成功"){
						sendSMS = "can_not_send";
						web_tip("短信发送成功","短信可能存在延迟，接收后请注意查看短信内容，内容为注册方法！","http://downsc.chinaz.net/files/download/sound1/201402/4082.wav");
						console.log("请注意查看短信内容 内容为注册方法");
							// 重置验证 start 
							$(document).ready(function() {
								minesweeper.reset('game');
							});
							console.log("已重置验证");
							// 重置验证 end 
					 }else if(data == "一分钟内只能发一条短信"){
						 web_tip("错误","同一号码，一分钟内只能发一条短信！","http://downsc.chinaz.net/Files/DownLoad/sound1/201908/11827.wav");
						 console.log("ERROR:" + data);
					 }else if(data == "一小时内只能发五条短信"){
						 web_tip("错误","同一号码，一小时内只能发五条短信！","http://downsc.chinaz.net/Files/DownLoad/sound1/201908/11827.wav");
						 console.log("ERROR:" + data);
					 }else if(data == "发送次数过多，已异常处理"){
						 web_tip("警告","该号码接收验证码次数过多，已异常处理！","http://downsc.chinaz.net/Files/DownLoad/sound1/201908/11827.wav");
						 console.log("ERROR:" + data);
					 }else if(data == "该号码已注册"){
						 web_tip("错误","该号码已注册","http://downsc.chinaz.net/Files/DownLoad/sound1/201908/11827.wav");
						 console.log("ERROR:" + data);
					 }else{
						 console.log("发生了未知错误");
						 console.log("ERROR:" + data);
						}
				   });
			
				/* 异步传输手机号码 end */
				
			}else{
				console.log("ERROR:请输入正确的手机号码");
			}
		}else if(chenkPhone.test(console_text.value)){
			console.log("ERROR:请先完成验证");
		}
		/* 手机验证码命令 end */
			console_text.value = "";
	}
})

function cheat(){
	if(sendSMS!= "can_not_send" && sendSMS!= "20d1d47b8ac2d9635d2bdf7ec4f17c302bcd956c3dea4bb4aeca366d7e37709551ca509c220ff8495a1642489088d8c0a05e0df1723dbae40dc4da5c23595e33:nozuobi"){
		console.log("请勿作弊");
		sendSMS = "can_not_send";
	}
}
setInterval("cheat()","1000");