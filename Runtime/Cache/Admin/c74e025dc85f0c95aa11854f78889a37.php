<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">
	<form method="post" action="/index.php?s=/Admin/SysMonitor/save" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone);">
		<div class="pageFormContent liList" layoutH="56">
		
		<?php  foreach ($list as $k=>$v){ ?>
		<p>
			<label><?php echo $v['T']; ?></label>
			<input name="listSetting[]" id="listSetting" type="checkbox"  value="<?php echo $k;?>" <?php if(strstr($setRes['listSetting'],$k))echo "checked";?>/>
		</p>

		<?php } ?>
			
		</div>
		<div class="formBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
				<li>
					<div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div>
				</li>
			</ul>
		</div>
	</form>
</div>