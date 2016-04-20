<?php if (!defined('THINK_PATH')) exit();?><style type="text/css">
	.pageContent .v3{display:none}
	.pageContent .authpwd{display:none}
	.pageContent .encrypwd{display:none}
</style>
<div class="pageContent">
		<form method="post" action="/index.php/Service/Snmp/add" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)" novalidate="novalidate">
			<div class="pageFormContent" layoutH="70">
				<p>
					<label style="width:120px;">模板类型：</label>
					<select name="templateType" class="combox" onchange="switchVersion(this)">
						<option value="1" selected="selected">V1/V2</option>
						<option value="3">V3</option>
					</select>
				</p>
				<p>
					<label style="width:120px;">模板名称：</label>
					<input size="20" value=""  name="templateName" class="required" type="text" />
				</p>
				
				<p class="v1">
					<label style="width:120px;">读团体字：</label>
					<input type="text" value="public"  name="communityRead"   placeholder="如没有请留空 " />
				</p>
				<p class="v1">
					<label style="width:120px;">写团体字：</label>
					<input type="text" value=""  name="communityWrite"  placeholder="如没有请留空" />
				</p>
				<p class="v3">
					<label style="width:120px;">用户名称：</label>
					<input size="20" value=""  name="userName" class="" type="text" />
				</p>
				<p class="v3">
					<label style="width:120px;">上下文名称：</label>
					<input type="text" value=""  name="contextName"  placeholder="如没有请留空" />
				</p>
				<p class="v3">
					<label style="width:120px;">认证协议：</label>
					<select name="authProtocol" class="combox" onchange="getAuthPwd(this,'authpwd')">
						<option value="">请选择</option>
						<option value="MD5">MD5</option>
						<option value="SHA">SHA</option>
					</select>
				</p>
				<p class="authpwd">
					<label style="width:120px;">认证密码：</label>
					<input type="text" name="authPassword" />
				</p>
				<p class="v3">
					<label style="width:120px;">加密协议：</label>
					<select name="encryProtocol" class="combox" onchange="getAuthPwd(this,'encrypwd')" >
						<option value="">请选择</option>
						<option value="DES">DES</option>
						<option value="AES">AES</option>
					</select>
				</p>
				<p class="encrypwd">
					<label style="width:120px;">加密密码：</label>
					<input type="text" name="encryPassword" />
				</p>
				<p>
					<label style="width:120px;">端口：</label>
					<input type="text" value="161"  name="port" class="required" />
				</p>
				<p>
					<label style="width:120px;">超时时间：</label>
					<input type="text" value="5"  name="timeout" class="required" />
				</p>
				<p>
					<label style="width:120px;">重试次数：</label>
					<input type="text" value="3"  name="retrys" class="required" />
				</p>
				<!--  
				<p>
					<label style="width:120px;">状态：</label>
					<select name="enabled" class="combox">
						<option value="1">启用</option>
					</select>
				</p>
				-->
			</div>
			<div class="formBar">
					<ul>
						<li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
						<li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
					</ul>
				</div>
		</form>
</div>

<script type="text/javascript">
	function switchVersion(obj)
	{
		var version = $(obj).val();
		if(version ==1){
			$(".v1").show();
			$("input[name=userName]").attr('class',''); //用户名不必填写；
			$("input[name=communityRead]").val('public'); //读团体字写入默认值；
			$(".v3").hide();
		}else{
			$(".v1").hide();
			$("input[name=userName]").attr('class','required');
			$("input[name=communityRead]").val(''); //读团体字删除默认值；
			$(".v3").show();
		}
	}
	
	function getAuthPwd(obj,pwd)
	{
		var auth = $(obj).val();
		if(IsTrue(auth)){
			$("."+pwd).show();
		}else{
			$("."+pwd).hide();
		}
	}
</script>