<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">
<form method="post" action="/index.php/Service/Operatmember/edit" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)" novalidate="novalidate">
	<div class="pageFormContent" layouth="58" style="height: 297px; overflow: auto;">
			<p>
				<label>联系人：</label>
				<input class="required" type="text" id="staffName" name="staffName" maxlength="50" size="30" value="<?php echo $row['staffName'];?>"/>
				<input type="hidden" name="id" id="id" value="<?php echo $row['staffId'];?>" />
			</p>
			<p>
				<label>运维账号：</label>
				<input class="required" type="text" id="staffAccount" name="staffAccount" maxlength="50" size="30" value="<?php echo $row['staffAccount'];?>"/>
			</p>
			<p>
				<label>电话号码：</label>
				<input class="required" type="text" id="staffPhoneNo" name="staffPhoneNo" maxlength="50" size="30" value="<?php echo $row['staffPhoneNo'];?>"/>
			</p>
			<p>
				<label>邮箱：</label>
				<input class="required" type="text" id="staffEmail" name="staffEmail" maxlength="50" size="30" value="<?php echo $row['staffEmail'];?>"/>
			</p>
			<p>
				<label>微博账号：</label>
				<input type="text" id="microBlogId" name="microBlogId" maxlength="50" size="30" value="<?php echo $row['microBlogId'];?>"/>
			</p>
			<p>
				<label>微信账号：</label>
				<input class="required" type="text" id="wechatId" name="wechatId" maxlength="50" size="30" value="<?php echo $row['wechatId'];?>"/>
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