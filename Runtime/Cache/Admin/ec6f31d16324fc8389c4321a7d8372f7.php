<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">
	<form method="post" action="/index.php?s=/Admin/SetSystem/index" class="pageForm required-validate" novalidate="novalidate" onsubmit="return validateCallback(this, dialogAjaxDonemeto)" >
		<div class="pageFormContent" layouth="58" style="height: 297px; overflow: auto;">
		<table>
		<tr>
			<td>
			<label>所属系统：</label>
			    <select name="systemflag" style="width:100px">
				<?php if(is_array($systemflag) && !empty($systemflag)){ foreach ($systemflag as $enkey=>$enval) { if($enkey == $nowsystemflag) $selected = 'selected'; echo '<option value='.$enkey.'  '.$selected.'>'.$enval.'</option>'; $selected = ''; } }?>
				</select>
			</td>
		</tr>
		</table>
		</div>
		<div class="formBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
				<li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
			</ul>
		</div>
	</form>
</div>
<script>
	function dialogAjaxDonemeto(json)
	{
		DWZ.ajaxDone(json);
		navTab.closeTab(json.navTabId); 
		navTab.closeTab("D703"); 
		navTab.closeTab("D704"); 
	}
</script>