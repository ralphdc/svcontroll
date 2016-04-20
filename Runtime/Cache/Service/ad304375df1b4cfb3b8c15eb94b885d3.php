<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">
	<form method="post" action="/index.php/Service/Environment/index" class="pageForm required-validate" novalidate="novalidate">
		<div class="pageFormContent" layouth="58" style="height: 297px; overflow: auto;">
		<table>
		<tr>
			<td>
			<label>所属环境：</label>
			    <select name="environment" style="width:100px">
				<?php if(is_array($environment) && !empty($environment)){ foreach ($environment as $enkey=>$enval) { if($enkey == $nowenvironment) $selected = 'selected'; echo '<option value='.$enkey.'  '.$selected.'>'.$enval.'</option>'; $selected = ''; } }?>
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
	function dialogAjaxDoneme(json)
	{
		/* DWZ.ajaxDone(json);
		$.pdialog.closeCurrent();
		navTab.closeAllTab(); */
	}
</script>