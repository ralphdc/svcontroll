<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent" style="">
<form method="post" action="/index.php/Service/Graphlogic/graphSave" class="pageForm required-validate" onsubmit="return validateCallbackTP(this, dialogLGAjaxDone)" novalidate="novalidate">
	<div class="pageFormContent" layouth="58">
		<input type="hidden" name="data[graph]"  id="jtcontent"/>
		<input type="hidden" name="data[nodes]" id="jtnumber" />
		<input type="hidden" name="data[topoId]" id="tp_ids" value="" />
		<input type="hidden" name="ids" id="child_tp_ids" value="" />
		<input type="hidden" name="serviceInfo" id="serviceInfo" value="" />
		<input type="hidden" name="topoInfo" id="topoInfo" value="" />
			<p>
				<label>拓扑名称：</label>
				<input class="required" type="text" id="tpname_pad" name="data[topoName]" maxlength="50" size="30" value="<?php echo ($tpname); ?>" placeholder="请输入拓扑名称"/>
			</p>
			<p>
				<label>节点个数：</label>
				<input class="required" type="text" id="nodenumber" name="nodes" maxlength="50" size="30" value=""/>
			</p>
	</div>
	<div class="formBar">
		<ul>
			<li><div class="buttonActive"><div class="buttonContent"><button type="submit" onclick="saveTP()">保存</button></div></div></li>
			<li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
		</ul>
	</div>
</form>
</div>

<script type="text/javascript">
	
	function collectNodeInfo()
	{
		nodeInfo = JPStore.getItem('nodeSaveItem');
		node_obj = JSON.parse(nodeInfo);
		var n;
		var node_data = [];
		for(n=0; n < node_obj.length; n++){
			var t = node_obj[n].text;
			var tem = JPStore.getItem(t);
			var tem_json = JSON.parse(tem);
			node_data.push(tem_json);
		}
		return JSON.stringify(node_data);
	}

	function saveTP()
	{
		//console.log(JPStore);
		var nodeInfo = JPStore.getItem('nodeSaveItem');
		var linkInfo = JPStore.getItem('linkSaveItem');
		var childTpInfo = JPStore.getItem('childTpSaveItem');
		
		var nodeInfoObj = JSON.parse(nodeInfo);
		var linkInfoObj = JSON.parse(linkInfo);
		
		var jtopoCon = {'node':nodeInfoObj,'link':linkInfoObj};
		var jtopoStr = JSON.stringify(jtopoCon);
		
		$("#jtcontent").val(jtopoStr);
		//子拓扑ID赋值；
		$("#child_tp_ids").val(childTpInfo);
		
		//2016-03-24新增字段：serverInfo,topoInfo;
		var sInfo = JPStore.getItem('serviceInfoStr');
		var tInfo = JPStore.getItem('topoInfoStr');
		
		if(!checkEmpty(sInfo)) $("#serviceInfo").val(sInfo);
		if(!checkEmpty(tInfo)) $("#topoInfo").val(tInfo);
	}
	
	$(document).ready(function(){
		if(JPStore){
			var store_node = JSON.parse(JPStore.getItem('nodeSaveItem'));
			var store_link = JSON.parse(JPStore.getItem('linkSaveItem'));

			var store_node_length = store_node.length;
			var store_link_length = store_link.length;

			$("#nodenumber").val(store_node_length);
			$("#jtnumber").val(store_node_length);
			$("#nodenumber").attr('disabled',true);
		}
		
		//初始化赋值；
		var tpname = $("#raltpname").val();
		$("#tpname_pad").val(tpname);
		var tpid = $("#raltpid").val();
		$("#tp_ids").val(tpid);
	})
	
	
	
function validateCallbackTP(form,callback, confirmMsg) {
    var $form = $(form);
    if (!$form.valid()) {
        return false;
    }
    var _submitFn = function() {
        $.ajax({
            type: form.method || 'POST',
            url: $form.attr("action"),
            data: $form.serializeArray(),
            dataType: "json",
            cache: false,
            success: callback || DWZ.ajaxDone,
            error: DWZ.ajaxError
        });
    }
    if(checkSceneData()){
		alertMsg.error("逻辑图没有设置节点信息，请设置后提交~！");
		$.pdialog.closeCurrent();
		return false;
	}
    if (confirmMsg) {
        alertMsg.confirm(confirmMsg, {
            okCall: _submitFn
        });
    } else {
        _submitFn();
    }
    return false;
}
	
	function dialogLGAjaxDone(json)
	{
		dialogAjaxDone(json);
		if(json.statusCode == 1){
			 //最后关闭画布窗口；2016-03-24
			var dialog = $("body").data("newLGTopo");
			if(!dialog) dialog = $("body").data("editLGGraphWindow");
			if(dialog){
				$.pdialog._current = dialog;
				$.pdialog.closeCurrent();
			}
		}
	}
</script>