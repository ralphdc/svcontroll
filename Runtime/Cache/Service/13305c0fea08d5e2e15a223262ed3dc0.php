<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">
	<form method="post" action="/index.php/Service/Configure/add_b" class="pageForm required-validate" onsubmit="return validateCallback(this, configAddAjaxDone)" novalidate="novalidate">
		<div class="pageFormContent" layouth="58">
			<div class="config_win_head">
				名称：<input type="text" name="propName" id="" class="required textInput add_name" /> <!-- &nbsp;&nbsp;备注: <textarea style="width: 308px; height: 17px;" name="remark" id="remark" maxlength="100"></textarea> -->
				<input type="hidden" name="id" value="" id="pid"/>
			</div>
			<div class="config_win_head">
				备注：<input type="text" size="80" maxlength="150" name="remark" id="remark" class="textInput" value="<?php echo ($remark); ?>" />
			</div>
			<?php
 $i=0; foreach($result as $key => $vo) { ?>
				<div class="config_info_item">
					<div class="num"><?php echo ++$i?></div>
					<span class="pro">属性：</span>
					<input type="text" name="prop[]" id="" class="textInput" value="<?php echo $key?>" readonly="readonly"/>
					<span class="pro ml30">值：</span>
					<input type="text" name="value[]" id="" class="textInput" value=""/>
				</div>
			<?php
 } ?>		
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
$(function(){
	function get_pid(){
		var nodes = config_tree.getSelectedNodes();
		return nodes[0].id;
	}
	$(document).ready(function(){
		  
		 $("#pid").val(get_pid());
	});
	
	
});


function configAddAjaxDone(json){
	var name=$('.add_name').val();
	var remark=$('#remark').val();
	if(name==''){
		alert('名称不能为空');
		return false;
	}
	DWZ.ajaxDone(json);	
	if(json.id > 0)
	{
		addTreeNode(config_tree_which,name,json.id,remark);
		$.pdialog.closeCurrent();
	}
}

</script>