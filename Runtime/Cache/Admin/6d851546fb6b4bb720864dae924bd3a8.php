<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">
	<form method="post" action="/index.php?s=/Admin/IceWeight/GroupCreate" class="pageForm required-validate" onsubmit="return validateCallback(this, configAddAjaxDone);">
		<div class="pageFormContent" layouth="58">
			 <p>
                <label>组名称：</label>
                <input name="dbGroupName" class="required" type="text" size="30" style="ime-mode:active;" />
            </p>
            <p>
                <label>组描述：</label>
                <input name="dbGroupDes" type="text" size="30" style="ime-mode:active;" />
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

	 function configAddAjaxDone(json){
		 DWZ.ajaxDone(json);
			if(parseInt(json.statusCode) > 0)
			{
				addTreeNode(config_tree_which_xgd,json.nodename,json.nodeid);
				$.pdialog.closeCurrent();
			}else{
				//alert("新增失败，请稍后再试！");
				//$.pdialog.closeCurrent();
			}
	} 
</script>