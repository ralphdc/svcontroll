<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">
<form method="post" action="/index.php?s=/Admin/WeightService/update" class="pageForm required-validate" onsubmit="return validateCallback(this, editDialogAjaxDone)" novalidate="novalidate">
	<div class="pageFormContent" layouth="58" style="height: 297px; overflow: auto;">
			<p>
				<label>服务：</label>
				<input type="text" size="28" name="servicename"  class="textInput readonly" readonly="true" value="<?php echo ($_REQUEST['servicename']); ?>">
				<input type="hidden" size="28" name="treessname"  class="textInput readonly" readonly="true" value="<?php echo ($_REQUEST['treessname']); ?>">
			</p>
			<p>
				<label>IP地址：</label>
				<input type="text" size="28" name="ip" maxlength="30" class="textInput readonly" readonly="true" value="<?php echo ($_REQUEST['IP']); ?>">
			</p>
			<p>
				<label>路径：</label>
				<input type="text" size="28" name="path"  class="required textInput" readonly="true" value="<?php echo str_replace("*", "/", $_REQUEST['path']); ?>">
			</p>
			<p>
				<label>端口：</label>
				<input type="text" size="28" name="port" maxlength="30" class="textInput " readonly="true" value="<?php echo ($_REQUEST['port']); ?>">
			</p>
			<?php if(($_REQUEST['flag'] != 1)): ?><p>
				<label>权重：</label>
				<input type="text" size="28" name="weight" maxlength="30" class="textInput digits" min='0' max="100" value="<?php echo ($_REQUEST['weight']); ?>"> 
			</p>
			<p>
				<label class="error">注意：</label>
				<label style="width:150px;text-align:left;color:#e23d0b">0<=权重<=100</label>
			</p><?php endif; ?>
			<p style="width:500px;">
				<label>Group组：</label>
				<?php
 $_REQUEST['consumergroupid'] = ($_REQUEST['consumergroupid'] == '默认组' || $_REQUEST['consumergroupid'] == '无' )?'':$_REQUEST['consumergroupid']; $_REQUEST['providergrouid'] = ($_REQUEST['providergrouid'] == '默认组' || $_REQUEST['providergrouid'] == '无' )?'':$_REQUEST['providergrouid']; ?>
				<?php if(($_REQUEST['flag'] == 1)): ?><input type="text" size="28"  maxlength="30" class="readonly textInput required"  readonly="true" value="<?php echo ($_REQUEST['consumergroupid']); ?>" name="prt.groupName" > 
				<a class="btnLook" href="/index.php/Admin/WeightService/groupSelect" mask="false" lookupGroup="prt" width="700" height="400">查找：</a>
				<?php elseif(($_REQUEST['flag'] == 2)): ?>
				<input type="text" size="28"  maxlength="30" class="readonly textInput required"  readonly="true" value="<?php echo ($_REQUEST['providergrouid']); ?>" name="prt.groupName" />
				<a class="btnLook" href="/index.php/Admin/WeightService/groupSelect" mask="false" lookupGroup="prt" width="700" height="400">查找：</a>
				<?php else: ?>
				<input type="text" size="28"  maxlength="30" class="readonly textInput required"  readonly="true" value="<?php echo ($_REQUEST['providergrouid']); ?>" name="prt.groupName" />
				<a class="btnLook" href="/index.php/Admin/WeightService/groupSelect" mask="false" lookupGroup="prt" width="700" height="400">查找：</a><?php endif; ?>
				
			</p>
			<p>
				<label>实例属性：</label>
				<?php if(($_REQUEST['flag'] == 1)): ?><input type="radio" name="flag" value="1" checked />客户端
				<?php elseif(($_REQUEST['flag'] == 2)): ?>
				<input type="radio" name="flag" value="2" checked />服务端
				<?php else: ?>
				<input type="radio" name="flag" value="1" />客户端
				<input type="radio" name="flag" value="2" checked />服务端
				<input type="radio" name="flag" value="3"  />两者<?php endif; ?>
			</p>
			
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

$("input[name='flag']").click(function(){
	var flag = $(this).val();
	var providergrouid = "<?php echo ($_REQUEST['providergrouid']); ?>";
	var consumergroupid = "<?php echo ($_REQUEST['consumergroupid']); ?>";
	if(flag == 1){
		$("input[name='providergrouid']").val(consumergroupid);
	}else{
		$("input[name='providergrouid']").val(providergrouid);
	}
});

function editDialogAjaxDone(json){
    DWZ.ajaxDone(json);
    if (json.statusCode == DWZ.statusCode.ok) {
        if (json.navTabId) {
            $("#Service_list").loadUrl(json.forwardUrl);
        }
        $.pdialog.closeCurrent();
    }
}
</script>