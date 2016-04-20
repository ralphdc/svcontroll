<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">
<form method="post" action="/index.php/Service/DeviceType/add" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDoneAdd)" novalidate="novalidate">
	<div class="pageFormContent" layouth="58">
			
			
			<p>
				<label>设备类型：</label>
				<input  type="text" id="deviceName" name="data[deviceName]" maxlength="15" size="30" value="" class="required" />
			</p>
			<p>
				<label>选择图标：</label>
				<input type="hidden" name="imgName" />
				<input  type="text" id="imgName" name="imgName" maxlength="15" size="30" value="" class="required" disabled="disabled" />
				<a class="btnLook" href="/index.php/Service/DeviceType/icon/" lookupGroup="" width="500" height="503">查找</a>
			</p>
			
			<p>
				<label>备注：</label>
				<input  type="text" id="deviceDemo" name="data[deviceDemo]" maxlength="15" size="30" value=""/>
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
	$(".pageFormContent").find('p').width(380);
	
	function dialogAjaxDoneAdd(json){
	    DWZ.ajaxDone(json);
	    if (json.statusCode == DWZ.statusCode.ok) {
	        if (json.navTabId) {
	            navTab.reload(json.forwardUrl, {
	                navTabId: json.navTabId
	            });
	        } else {
	            var $pagerForm = $("#pagerForm", navTab.getCurrentPanel());
	            var args = $pagerForm.size() > 0 ? $pagerForm.serializeArray() : {}
	            navTabPageBreak(args, json.rel);
	        }
	        //if ("closeCurrent" == json.callbackType) {
	        	var dialogId = 'addServer';
	        	var dialog = $("body").data(dialogId);
	        	$.pdialog._current = dialog;
	            $.pdialog.closeCurrent();
	        //}
	    }
	}
</script>