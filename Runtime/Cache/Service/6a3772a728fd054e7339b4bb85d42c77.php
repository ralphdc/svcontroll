<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">
	<form method="post" action="/index.php/Service/Configure/edit_b" class="pageForm required-validate" onsubmit="return validateCallback(this, configEditAjaxDone)" novalidate="novalidate">
		<div class="pageFormContent" layouth="58">
			<div class="config_win_head">
				名称：<input type="text" name="propName" id="propName" class="required textInput edit_name" value="<?php echo ($propName); ?>" />
				<!-- &nbsp;&nbsp;备注: <textarea style="width: 308px; height: 17px;" name="remark" id="remark" ><?php echo ($remark); ?></textarea> -->
				<input type="hidden" name="id" value="" id="myid"/>
			</div>
			<div class="config_win_head">
				备注：<input type="text" size="80" maxlength="150" name="remark" id="remark" class="textInput" value="<?php echo ($remark); ?>" />
			</div>
			<?php
 for($i=0;$i<sizeof($result);$i++) { ?>
				<div class="config_info_item numCount">
					<div class="num"><?php echo $i+1?></div>
					<span class="pro">属性：</span>
					<input type="text" name="prop[]" id="" class="textInput" value="<?php echo $result[$i]['propertyKey']?>" readonly="readonly"/>
					<input type="text" name="tid[]" id="" class="textInput" value="<?php echo htmlentities($result[$i]['propertyKeyValue'],ENT_COMPAT,'UTF-8')?>"/>
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
	function get_id(){
		var nodes = config_tree.getSelectedNodes();
		return nodes[0].id;
	}
	$(document).ready(function(){
		  
		 $("#myid").val(get_id());

		 var nodes = config_tree_which.getSelectedNodes();
		 var nodeName = nodes[0].name.replace(/ \(.*\)/gi, "");;
		 $("#propName").val(nodeName);
		 //alert(get_pid());
	});
});

function configEditAjaxDone(json){
	var name=$('.edit_name').val();
	var remark=$('#remark').val();
	//alert(name);
	if(name==''){
		alert('属性类名不能为空');
		return false;
	}
	DWZ.ajaxDone(json);
	if(json.statusCode == '200')
	{
		renameTreeNode(name,remark);
		$.pdialog.closeCurrent();
		$('a.curSelectedNode').trigger('click');
	}
}
</script>