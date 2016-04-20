<?php if (!defined('THINK_PATH')) exit();?><form id="pagerForm" action="/index.php/Service/Operatmember/getUnaddedStaff" method="post">
	<input type="hidden" name="pageNum" value="1"/>
	<input type="hidden" name="numPerPage" value="<?php echo ($numPerPage); ?>"/>
	<input type="hidden" name="id" value="<?php echo ($id); ?>" />
	
	<!--
	 <input type="hidden" name="_order" value=""/>  
	 <input type="hidden" name="_sort" value=""/>
	 <input type="hidden" name="pdName" value=""/> 
	 -->
</form>
	

<div class="pageContent">
	<form id="addList" action="/index.php/Service/Operatmember/groupAddStaff" method="post" class="pageForm required-validate" onsubmit="return validateCallback(this,submitStaffAjaxDone)">
		<input type="hidden" name="id" value="<?php echo ($id); ?>" />
		<table class="table" targetType="dialog" layoutH="112" width="100%">
			<thead>
				<tr>
					<th width="30"><input type="checkbox" class="checkboxCtrl" group="stId[]" /></th>
					<th>序号</th>
					<th>联系人</th>
					<th>通知方式</th>
				</tr>
			</thead>
			<tbody>
			<?php $ralph_order=0; ?>
				<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
					<?php $ralph_order++;?>
						<td><div><input type="checkbox" value="<?php echo ($vo['staffId']); ?>" name="stId[]" /></div></td>
						<td><?php echo ($numPerPage*($currentPage - 1) + $ralph_order); ?></td>
						<td><?php echo ($vo['staffName']); ?><input type="hidden" name="staffName[<?php echo ($vo['staffId']); ?>]" value="<?php echo ($vo['staffName']); ?>" /></td>
						<td>
							<input type="checkbox" value="1" name="noticetype[<?php echo ($vo['staffId']); ?>][wechat]" />微信
						    <input type="checkbox" value="1" name="noticetype[<?php echo ($vo['staffId']); ?>][email]" />邮件
						    <input type="checkbox" value="1" name="noticetype[<?php echo ($vo['staffId']); ?>][msg]" />短消息
					    </td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</tbody>
		</table>
		<div class="panelBar">
			<div class="pages">
				<span>显示</span>
				<select class="combox" name="numPerPage" onchange="dialogPageBreak({numPerPage:this.value})">
					<?php
 $numPerPageArr = array(20,50,100,200); foreach($numPerPageArr as $val) { if($val == $numPerPage) $selected = 'selected="selected"'; echo '<option value="'.$val.'" '.$selected.'>'.$val.'</option>'; $selected = ''; } ?>
				</select>
				<span>条，共<?php echo ($totalCount); ?>条</span>
			</div>
			<div class="pagination" targetType="dialog" totalCount="<?php echo ($totalCount); ?>" numPerPage="<?php echo ($numPerPage); ?>" pageNumShown="5" currentPage="<?php echo ($currentPage); ?>"></div>
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

function submitStaffAjaxDone(json){
	
	DWZ.ajaxDone(json);
	if(json.statusCode > 0)
	{
		addTreeNode(operate_tree,json);
		$.pdialog.closeCurrent();
	}
}


</script>