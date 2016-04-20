<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo (C("sitename")); ?></title>
<link href="/Public/dwz/themes/css/login.css" rel="stylesheet" type="text/css" />
<script src="/Public/dwz/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script language="JavaScript">
<!--
function fleshVerify(type){ 
	//重载验证码
	var timenow = new Date().getTime();
	if (type){
		$('#verifyImg').attr("src", '/index.php/Service/Public/verify/adv/1/'+timenow);
	}else{
		$('#verifyImg').attr("src", '/index.php/Service/Public/verify/'+timenow);
	}
}
//-->
</script>
</head>
<body>
<div id="login">
	<div id="login_header">
		
	</div>
	<div id="login_content">
	<div class="login_banner">
		<div class="loginForm">
			<form method="post" action="/index.php/Service/Public/validateLogin/">
				<p>
					<label class='active'  >帐号：</label>
					<input type="text" name="account" size="20" class="login_input"  id="userid_input"/>
				</p>
				<p>
					<label>密码：</label>
					<input type="password" name="password" size="20" class="login_input" id="pwd_input" />
				</p>
				<!-- <div id='p_img_noborder'>
				<p id='p_imgcode'>
					<label>验证码：</label>
					<input class="code" name="verify" type="text" size="5" id ="code_input" />
					<span><img id="verifyImg" width="90" height="32" SRC="/index.php/Service/Public/verify/" onClick="fleshVerify()" border="0" alt="点击刷新验证码" style="cursor:pointer" align="absmiddle"></span>
				</p>
				</div> -->
				<div >
					<input id="login_button"  type="submit" value=" " />
				</div>
				
			
			</form>
		</div>
		<!--div class="login_banner"><img src="/Public/dwz/themes/default/images/login_banner.jpg" /></div-->
		<!--div class="login_main">
		</div-->
		
		<div id="login_sysinfo">
					<div id="scroll_info">
						<div class="scroll_info_item">
							<p class="sys_info_text">TMS是用于终端管理的一套系统产品，它从终端入库开始，到终端销毁的整个使用生命周期进行全面的管理。产品功能：</p>
							<ul>
								<li>&gt;提供终端仓管功能</li>
								<li>&gt;提供终端程序维护功能 </li>
								<li>&gt;提供装拆机功能</li>
								<li>&gt;提供终端参数维护功能</li>
								<li>&gt;提供终端监控功能</li>
								<li>&gt;提供统计报表功能</li>
							</ul>
						</div>
						</div>
					
					<div class="sys_character">
						<div class="sys_character_item"><div class="item_icon icon1">极速<br>下载<!--<span>系统的特性系统的特性<br>系统的特性<br>系统的特性</span>--></div></div>
						<div class="sys_character_item"><div class="item_icon icon2">实时<br>监控<!--<span>系统的特性系统的特性<br>系统的特性<br>系统的特性</span>--></div></div>
						<div class="sys_character_item"><div class="item_icon icon3">完备<br>管理<!--<span>系统的特性系统的特性<br>系统的特性<br>系统的特性</span>--></div></div>
					</div>
				</div>
		
		
	</div>
	</div>
	<div id="login_footer">
		Copyright &copy; 2014 <?php echo (C("COMPANY")); ?> Inc. All Rights Reserved.
	</div>
</div>

</body> 
</html>

	<script>
	$(function() {
		$('#userid_input').focus();
		$('#pwd_input').val('');
		$('#code_input').val('');
		$('.loginForm input').each(function(){
			input_inf($(this));
			$(this).focus(function(){
				input_inf($(this));
				$(this).parent().addClass('active');
			});
			$(this).blur(function(){
				input_inf($(this));
				$(this).parent().removeClass('active');
			});
			$(this).bind('input propertychange',function(){
				//$(this).next().remove();
				input_inf($(this));
			});
		});
		var errorid = '{{ error["errorid"] }}';
		var errormsg = '{{ error["errormsg"] }}';
		if(errorid)
		{
			$('#'+errorid).parent().append('<div class="login_error"><div class="login_error_msg">'+errormsg+'</div><div class="login_error_b"></div></div>');
		}

	});

	function input_inf(obj)
	{
		if(obj.val() == '')
			obj.prev().show();
		else
			obj.prev().hide();
	}
	
	function form_sub(){
		var obj = document.getElementById('login-form');
		if(EncryptPwd(obj))
			obj.submit();
		else
			return;
	}

	function EncryptPwd(form) {
		if(!$('#userid_input').val())
		{
			$('#userid_input').next().remove();
			$('#userid_input').parent().append('<div class="login_error"><div class="login_error_msg">请输入用户名！</div><div class="login_error_b"></div></div>');
			$('#userid_input').focus();
			return false;
		}
		if(!$('#pwd_input').val())
		{
			$('#pwd_input').next().remove();
			$('#pwd_input').parent().append('<div class="login_error"><div class="login_error_msg">请输入用户密码！</div><div class="login_error_b"></div></div>');
			$('#pwd_input').focus();
			return false;
		}
		if(!$('#code_input').val())
		{
			$('#code_input').next().remove();
			$('#code_input').parent().append('<div class="login_error"><div class="login_error_msg">请输入验证码</div><div class="login_error_b"></div></div>');
			$('#code_input').focus();
			return false;
		}
		
		form.password.value = hex_md5(form.imgcode.value+hex_md5(form.password.value));
		return true;
	}
	</script>