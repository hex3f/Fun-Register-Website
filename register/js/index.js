$(function(){

'use strict';

// The following values are used to test as dummy data only so that
// we can fake a successful login…
var _boxyUsernameFakedValue = '2709ce66b3b7c0bec57687c6ef220ccfTVXYZ';
var _boxyPasswordFakedValue = '15980066528';

var _boxyWrap = document.getElementById('boxy-login-wrapper');
var _boxyLoginForm = document.forms['boxy-login-form'];
var _boxyFormInner = $(_boxyLoginForm).find('div.boxy-form-inner');

//var _boxySide = jQuery.makeArray( $(_boxyFormInner).find('span.side') );
var _boxySide = $(_boxyFormInner).find('span.side');
var	_boxySideA = _boxySide[0],
	_boxySideB = _boxySide[1],
	_boxySideC = _boxySide[2],
	_boxySideD = _boxySide[3];

var _boxyInput;
var _boxyPassword;

var _boxyButton = [ $(_boxySideA).find('button.boxy-button').attr('data-step','0'),
					$(_boxySideB).find('button.boxy-button').attr('data-step','1'),
					$(_boxySideC).find('button.boxy-button').attr('data-step','2'),
					$(_boxySideC).find('input[name=remember-me]'),
					$(_boxySideC).find('label[for=remember-me]'),
					$(_boxySideD).find('button.boxy-button').attr('data-step','9')
					];

var _boxyEndCaps = $(_boxyFormInner).find('span.end-cap');

var _boxyLeftCap = $(_boxyEndCaps[0]);
var _boxyRightCap = $(_boxyEndCaps[1]);

var _toLogin = _boxyLeftCap.find('.glyphicon-user'),
	_okLogin = _boxyRightCap.find('.icon-success'),
	_badLogin = _boxyRightCap.find('.icon-failure');

var _boxyButtonA = _boxyButton[0],
	_boxyButtonB = _boxyButton[1],
	_boxyButtonC = _boxyButton[2],
	_boxyButtonD = _boxyButton[5];

var _boxyButtonInput = _boxyButton[3],
	_boxyButtonCombined = _boxyButton[4],
	_boxyMessage = $(_boxyWrap).find('em.small-forgot'),
	_rememberMeOp = $('input#remember-me');

var _checked = $(_boxyWrap).find('span.boxy-checked'),
	_unchecked = $(_boxyWrap).find('span.boxy-unchecked'),
	_boxyForgot = $(_boxyWrap).find('.boxy-forgot');



var _toolTipOps = {'placement' : 'top',
					'data-html' : true,
					'data-animation' : true,
					'selector' : '[data-toggle=tooltip]',
					'trigger' : 'hover',
					'delay' : { 'show': 250,
								'hide': 150 
							}
					};

// Inits Bootstrap Tooltips
$(_boxyWrap).tooltip( _toolTipOps );

/********************************************************/
/*	END OF GLOBAL    ************************************/
/*	VARIABLES…       ************************************/
/********************************************************/

// Handles "Remember me" checkbox icons
$(_rememberMeOp).on('change', function(){
	if( $(this).is(':checked') ){
		web_tip('错误','该协议必须同意','http://downsc.chinaz.net/Files/DownLoad/sound1/201908/11827.wav');
	}else{
		web_tip('错误','该协议必须同意','http://downsc.chinaz.net/Files/DownLoad/sound1/201908/11827.wav');
	}
	return false;
});



// Sets focus on next available input field
$(_boxyFormInner).on('keydown', '#boxy-input , #boxy-password', function(evt) { 
	  
	  var keyCode = evt.keyCode || evt.which; 

	  if (keyCode == 9) {
      evt.preventDefault(); 

	    $(this).next('button').click();

      $(this).parent().next('.side').find('input').focus();
	  } 
});


			
_okLogin.on('click',function(evt){
	evt.preventDefault();

	var _disableInputs = $(_boxyFormInner).find('input');

		_disableInputs.attr('disabled','disabled');

		$(_boxyFormInner).removeClass('rotated90');
		$(_boxyFormInner).removeClass('rotated180');
		$(_boxyFormInner).removeClass('rotatedBack90');
		$(_boxyFormInner).removeClass('rotatedBack180');
		$(_boxyFormInner).removeClass('rotate3d');

		if( $(_boxyWrap).hasClass('shake') ){ 
        $(_boxyWrap).removeClass('shake');
      }


	});


_badLogin.on('click',function(evt){
	evt.preventDefault();
	$(_boxyFormInner).removeClass('rotated90');
		$(_boxyFormInner).removeClass('rotated180');
		$(_boxyFormInner).removeClass('rotatedBack90');
		$(_boxyFormInner).removeClass('rotatedBack180');
		$(_boxyFormInner).removeClass('rotate3d');

		
  if( $(_boxyWrap).hasClass('shake') ){ 
        $(_boxyWrap).removeClass('shake');
      }
  
	$(_boxyFormInner).addClass('rotate360');

	});


$(_toLogin).on('click', function(evt){
		$(_boxyFormInner).removeClass('rotateFirst3d');
		$(this).next('.side').find('input').focus();
		//var _stepVal = Math.floor( $(this).attr('data-step') );
		evt.preventDefault();
		return false;
	});


	// Next -- Username field
	_boxyButtonA.on('click', function(evt){
		$(this).next('.side').find('input').focus();
		var _stepVal = Math.floor( $(this).attr('data-step') );
		evt.preventDefault();
		return validateForm(_stepVal);
	});

	// Next -- Password field
	_boxyButtonB.on('click', function(evt){
		var _stepVal = Math.floor( $(this).attr('data-step') );
		evt.preventDefault();
		return validateForm(_stepVal);
	});

	// OK button -- check login and submit
	_boxyButtonC.on('click', function(evt){
		var _stepVal = Math.floor( $(this).attr('data-step') );
		
		$(_boxyFormInner).addClass('rotate3d');

		evt.preventDefault();
		return validateForm(_stepVal);
	});

	_boxyButtonD.on('click', function(evt){
		var _stepVal = Math.floor( $(this).attr('data-step') );
		evt.preventDefault();
		return validateForm(_stepVal);
	});


function testLogin( _code, _phone ){
	
	/* 异步传输手机号码 start */
	var _rightCap = $('.end-cap.right');
	var _leftCap = $('.end-cap.left');
	$.post("check.php", { encryption_Code: _code, PhoneNumber: _phone },
	   function(data){
		console.log(data);	//调试
		 if(data == "数据存入成功"){
			_rightCap.addClass('boxy-success');
			//$('.boxy-success').find('.icon-success').attr('title','logged in as, ' + _boxyUser );
			$('.boxy-success').find('.icon-success').stop().fadeIn('slow');
			web_tip('提示','你已进入ID生成环节。三秒后跳转注册页。','http://downsc.chinaz.net/files/download/sound1/201207/1778.wav');
			setTimeout("self.location='reg/index.php'",3000); //指定3秒刷新一次
		 }else if(data == "手机格式错误"){
			_rightCap.addClass('boxy-failure');
			$('.boxy-failure').find('.icon-failure').stop().fadeIn('slow');
			web_tip('错误','手机格式错误，三秒后将自动刷新。','http://downsc.chinaz.net/files/download/sound1/201207/1778.wav');
			setTimeout('location.reload()',3000); //指定3秒刷新一次
		 }else if(data == "CODE与手机号不匹配或不存在"){
			_rightCap.addClass('boxy-failure');
			$('.boxy-failure').find('.icon-failure').stop().fadeIn('slow');
			web_tip('错误','CODE与手机不匹配，三秒后将自动刷新。','http://downsc.chinaz.net/files/download/sound1/201207/1778.wav');
			setTimeout('location.reload()',3000); //指定3秒刷新一次
		 }else if(data == "号码已通过验证"){
			_rightCap.addClass('boxy-failure');
			$('.boxy-failure').find('.icon-failure').stop().fadeIn('slow');
			web_tip('错误','该号码已经验证完毕，请前往注册页面。三秒后自动跳转注册页面。','http://downsc.chinaz.net/files/download/sound1/201207/1778.wav');
			setTimeout('location.reload()',3000); //指定3秒刷新一次
		 }else{
			_rightCap.addClass('boxy-failure');
			$('.boxy-failure').find('.icon-failure').stop().fadeIn('slow');
			web_tip('错误','发生了未知的错误，三秒后刷新。','http://downsc.chinaz.net/files/download/sound1/201207/1778.wav');
			setTimeout('location.reload()',3000); //指定3秒刷新一次
		 }
	   });

	/* 异步传输手机号码 end */
/*
	if ( ( _boxyUser !== _userValidateAgainst ) || ( _boxyPass !== _passValidateAgainst ) ){
		_rightCap.addClass('boxy-failure');
		$('.boxy-failure').find('.icon-failure').stop().fadeIn('slow');
		web_tip('错误','CODE与手机不匹配，三秒后将自动刷新','http://downsc.chinaz.net/files/download/sound1/201207/1778.wav');
	}

	if ( (_boxyUser === _userValidateAgainst) && (_boxyPass === _passValidateAgainst) ){
		_rightCap.addClass('boxy-success');
		$('.boxy-success').find('.icon-success').attr('title','logged in as, ' + _boxyUser );
		$('.boxy-success').find('.icon-success').stop().fadeIn('slow');
		web_tip('提示','你已进入ID生成环节。点击ID头像进入。','http://downsc.chinaz.net/files/download/sound1/201207/1778.wav');
	}*/
}

function validateForm(_step){
	var chenkPhone = /^(13[0-9]|14[5-9]|15[012356789]|166|17[0-8]|18[0-9]|19[8-9])[0-9]{8}$/; /* 手机校验 */
	_boxyInput = document.forms['boxy-login-form']['username'];
	_boxyPassword = document.forms['boxy-login-form']['password'];

	if( $(_boxyWrap).hasClass('shake') ){
				$(_boxyWrap).removeClass('shake');
			}

	switch(_step){
		case 0:
/****************************************************************************************/
	// Checks to make sure we are passing a value for the username field
	if( !_boxyInput.value ){

		web_tip('错误','CODE无法获取，三秒后将刷新网页！','http://downsc.chinaz.net/Files/DownLoad/sound1/201908/11827.wav');
		setTimeout('location.reload()',3000); //指定3秒刷新一次
		
	}else if( _boxyInput.value ){
		
		$(_boxyLoginForm).find('.boxy-form-inner').addClass('rotated90');
		$(_boxyMessage).fadeOut('slow');
		
	}
/****************************************************************************************/
		break;
		case 1:
/****************************************************************************************/
	if( !_boxyPassword.value ){
				
    if( $(_boxyWrap).hasClass('shake') ){ 
        $(_boxyWrap).removeClass('shake');
      }
		$(_boxyWrap).addClass('shake');
		$(_boxyMessage).fadeIn('slow');
		document.getElementsByName('password')[0].placeholder = '手机号不能为空';
		web_tip('提示','请输入手机号','http://downsc.chinaz.net/Files/DownLoad/sound1/201908/11827.wav');
			
	}else if( _boxyPassword.value ){
    if(!chenkPhone.test(_boxyPassword.value)){
		web_tip('提示','手机号格式不正确','http://downsc.chinaz.net/Files/DownLoad/sound1/201908/11827.wav');
	}else{
		
		if( $(_boxyWrap).hasClass('shake') ){ 
			$(_boxyWrap).removeClass('shake');
		}
			$(_boxyLoginForm).find('.boxy-form-inner').addClass('rotated180');
			$(_boxyMessage).fadeOut('slow');
		}

	}
/****************************************************************************************/
		break;
		case 2:
		
		var _valUser = _boxyInput.value;
		var _valPass = _boxyPassword.value;
		testLogin( _valUser, _valPass );

		break;
		case 9:
/****************************************************************************************/
	}
}

	$(_boxyForgot).on('click',function(evt){
		evt.preventDefault();
		$(_boxyMessage).fadeOut('slow');
	});	
});


$('.glyphicon-user, .glyphicon-asterisk, .glyphicon-question-sign').on('click',function(evt){
	evt.preventDefault();		
	var _setFocusInput = $(this).parent().find('input');

	return _setFocusInput.focus();	
});