<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">
<form method="post" action="/index.php/Service/Moniconfig/add" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)" novalidate="novalidate">
	<div class="pageFormContent" layouth="58" style="height: 297px; overflow: auto;">
			<p>
				<label>类型名：</label>
				<input class="required" type="text" id="name" name="name" maxlength="50" size="30" value="<?php echo $row['name'];?>"/>
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