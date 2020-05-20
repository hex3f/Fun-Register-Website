<?php
header("Content-type: text/html; charset=utf-8");
session_start();

//  判断session值应该在的位置
if (isset($_SESSION["login"]) && $_SESSION["login"] === true) {
	header("location:../login/index.php");
}else if (isset($_SESSION["reg_login"]) && $_SESSION["reg_login"] === true) {
	header("location:../register/reg/index.php");
}else if (isset($_SESSION["login_1"]) && $_SESSION["login_1"] === true) {
	header("location:index.php");
}else if (isset($_SESSION["login"]) && $_SESSION["login"] === true) {
	header("location:../login/index.php");
}else if(isset($_SESSION["getkey_reg_login"]) && $_SESSION["getkey_reg_login"] === true){
	header("location:index.php");
}else {
	$_SESSION["reg_login"] = false;
}


?>
<!DOCTYPE html>
<html lang="zh-cn">
	<head>
		<title>HEX3F - 登录密钥</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="initial-scale=1.0, width=device-height"><!--  mobile Safari, FireFox, Opera Mobile  -->
		<link rel="stylesheet" type="text/css" href="https://www.bootcss.com/p/buttons/css/buttons.css" />
		<script src="https://cdn.bootcss.com/jquery/2.2.4/jquery.js"></script>
		<!-- font css -->
		<link rel="stylesheet" href="../css/font.css">
		<!-- Hacker rain effect js -->
		<script src="../js/typed.js" type="text/javascript"></script>
		<!-- Hacker rain effect -->
		<script type="text/javascript">
		$(function(){
			$("#typed").typed({
				// strings: ["Typed.js is a <strong>jQuery</strong> plugin.", "It <em>types</em> out sentences.", "And then deletes them.", "Try it out!"],
				stringsElement: $('#typed-strings'),
				typeSpeed: 100,
				backDelay: 500,
				loop: false,
				contentType: 'html', // or text
				// defaults to false for infinite loop
				loopCount: false,
				resetCallback: function() { newTyped(); }
			});

			$(".reset").click(function(){
				$("#typed").typed('reset');
			});

		});
		</script>
		<script src="libs/modernizr.js"></script>
		<style type="text/css">
			* {
				margin: 0;
				padding: 0;
			}
			html, body {
				width: 100%;
				height: 100%;
				background: #22292C;
				color:white;
				font-size:20px;
				overflow: hidden;
			}
			div {
				margin-top:1em;
				margin-bottom:1em;
			}
			input {
				padding: .5em;
				margin: .5em;
			}
			select {
				padding: .5em;
				margin: .5em;
			}
			#signatureparent {
				color:darkblue;
				background-color:rgba(255,255,255,0.5);
				/*max-width:600px;*/
				padding:20px;
			}
			/*This is the div within which the signature canvas is fitted*/
			#signature {
				border: 2px dotted black;
				background-color:lightgrey;
			}
			/* Drawing the 'gripper' for touch-enabled devices */ 
			html.touch #content {
				float:left;
				width:92%;
			}
			#key {
				background-color:rgba(0,0,0,0.5);
				color:white;
				width:100%;
				height:4em;
				font-size:30px;
				padding:10px;
			}
			#content {
				width: 1000px;
				position: absolute;
				text-align: center;
				top: 0%;
				left: 50%;
				transform: translateX(-50%);
			}
			#displayarea{
				background-color:rgba(200,200,200,0.5);
			}
			#title-text{
				font-size:40px;
			}
		</style>
	</head>
	<body>
		<canvas id="canvas" width="1280" height="1024"> 你的浏览器不支持canvas标签，请您更换浏览器 </canvas>
		<script src="../js/wordEffect.js"></script>
		<div>
			<div id="content">
				<font id="title-text">HEX3F LOGIN SYSTEM</font>
				<div id="tools"></div>
				<div><div id="displayarea"></div></div>
			</div>
			<div id="scrollgrabber"></div>
		</div>
		<script>
		/*  @preserve
		jQuery pub/sub plugin by Peter Higgins (dante@dojotoolkit.org)
		Loosely based on Dojo publish/subscribe API, limited in scope. Rewritten blindly.
		Original is (c) Dojo Foundation 2004-2010. Released under either AFL or new BSD, see:
		http://dojofoundation.org/license for more information.
		*/
		(function($) {
			var topics = {};
			$.publish = function(topic, args) {
				if (topics[topic]) {
					var currentTopic = topics[topic],
					args = args || {};
			
					for (var i = 0, j = currentTopic.length; i < j; i++) {
						currentTopic[i].call($, args);
					}
				}
			};
			$.subscribe = function(topic, callback) {
				if (!topics[topic]) {
					topics[topic] = [];
				}
				topics[topic].push(callback);
				return {
					"topic": topic,
					"callback": callback
				};
			};
			$.unsubscribe = function(handle) {
				var topic = handle.topic;
				if (topics[topic]) {
					var currentTopic = topics[topic];
			
					for (var i = 0, j = currentTopic.length; i < j; i++) {
						if (currentTopic[i] === handle.callback) {
							currentTopic.splice(i, 1);
						}
					}
				}
			};
		})(jQuery);
		</script>
		<script src="libs/jSignature.min.noconflict.js"></script>
		<script>
		(function($){
		$(document).ready(function() {
			
			// All the code below is just code driving the demo. 
			$tools = $('#tools')
			, $extraarea = $('#displayarea')
			, pubsubprefix = 'jSignature.demo.'
			
			$('<div><textarea id="key"></textarea></div>').appendTo($tools)
			
			$('<input type="button" class="button button-3d" value="校验秘钥合法性">').bind('click', function(e){
				
				var login_key = document.getElementById('key').value;
				var i = new Image()
				
				/* 异步传输手机号码 start */
				$.post("check/login_check.php", { login_key: login_key },
					function(data){
					 var value = document.getElementById("tip_value");
					 console.log(data);	//调试
					 if(data == "没有配对的数据"){
						$('<span><p>没有配对的数据</p></span>').appendTo($extraarea);
					 }else{
						i.src = 'data:' + 'data:image/png;base64' + ',' + data;
						$('<span><p>密钥还原图:</p>马上跳转到密匙获取页面</span>').appendTo($extraarea)
						$(i).appendTo($extraarea)
						setTimeout("self.location='index.php'",1000);
					 }

					});
				/* 异步传输手机号码 end */

			}).appendTo($tools)
			
		})
		})(jQuery)
		</script>
	</body>
</html>
