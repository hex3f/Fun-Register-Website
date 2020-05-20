$(document).ready(function(){
	$("body").showbanner({
		title : "提示",
		content : "hex3f主体网站只能在PC平台打开，推荐使用Chrome、Firefox。",
		sound : "sounds/banneralert.mp3",
		handle : false,
		show_duration : 200,
		duration : 5000,
		hide_duration : 700
});
	$(".soundban").click(function(){
		$("body").showbanner({
			title : "jq22.com",
			icon : "images/icon.png",
			content : "xxxxxxxxxxxxxxxxxxxxx",
			sound : "sounds/banneralert.mp3",
			handle : false,
			show_duration : 200,
			duration : 1000,
			hide_duration : 700
		});
	});
});