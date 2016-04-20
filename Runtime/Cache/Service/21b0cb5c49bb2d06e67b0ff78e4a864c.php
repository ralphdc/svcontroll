<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent" style="">
<form method="post" action="/index.php/Service/Graph/graphSave" class="pageForm required-validate" onsubmit="return validateCallback(this, saveTPAjaxDone)" novalidate="novalidate">
	<div class="pageFormContent" layouth="58">
		<input type="hidden" name="data[graph]"  id="jtcontent"/>
		<input type="hidden" name="data[nodes]" id="jtnumber" />
		<input type="hidden" name="data[topoId]" id="tp_ids" value="" />
		<input type="hidden" name="ids" id="child_tp_ids" value="" />
		<input type="hidden" name="serverInfo" id="serverInfo" value="" />
		<input type="hidden" name="topoInfo" id="topoInfo" value="" />
			<p>
				<label>拓扑名称：</label>
				<input class="required" type="text" id="tpname_pad" name="data[topoName]" maxlength="50" size="30" value="<?php echo ($tpname); ?>" placeholder="请输入拓扑名称"/>
			</p>
			<p>
				<label>节点个数：</label>
				<input class="required" type="text" id="nodenumber" name="nodes" maxlength="50" size="30" value=""/>
			</p>
			<!-- 
			<p>
				<label>连线个数：</label>
				<input class="required" type="text" id="linknumber" name="linknumber" maxlength="50" size="30" value=""/>
			</p>
			 -->
			 <!-- 
			<p>
				<label>提交时间：</label>
				<input class="required" type="text" id="subtime" name="subtime" maxlength="50" size="30" value=""/>
			</p>
			 -->
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
	
	
	function saveTPAjaxDone(json) {
	    DWZ.ajaxDone(json);
	    if (json.statusCode == DWZ.statusCode.ok) {
	        if (json.navTabId) {
	            navTab.reload(json.forwardUrl, {
	                navTabId: json.navTabId
	            });
	        } else {
	            var $pagerForm = $("#pagerForm", navTab.getCurrentPanel());
	            var args = $pagerForm.size() > 0 ? $pagerForm.serializeArray() : {}
	            navTabPageBreak(args, json.rel);
	        }
	        $.pdialog.closeCurrent();
	 	   //最后关闭画布窗口；2016-03-24
	 		var dialog = $("body").data("newTopo");
	 		if(!dialog) dialog = $("body").data("editGraphWindow");
	 		if(dialog){
	 			$.pdialog._current = dialog;
	 			$.pdialog.closeCurrent();
	 		}
	    }else{
	    	$.pdialog.closeCurrent();
	    }
	}

	function saveTP()
	{
		//console.log(JPStore);
		var nodeInfo = JPStore.getItem('nodeSaveItem');
		var linkInfo = JPStore.getItem('linkSaveItem');
		var stageInfo = JPStore.getItem('stageSaveItem');
		var childTpInfo = JPStore.getItem('childTpSaveItem');
		
		var nodeInfoObj = JSON.parse(nodeInfo);
		var linkInfoObj = JSON.parse(linkInfo);
		var stageInfoObj = JSON.parse(stageInfo);
		
		var jtopoCon = {'node':nodeInfoObj,'link':linkInfoObj,'sg':stageInfoObj};
		var jtopoStr = JSON.stringify(jtopoCon);
		
		$("#jtcontent").val(jtopoStr);
		
		//子拓扑ID赋值；
		$("#child_tp_ids").val(childTpInfo);
		
		//2016-03-24新增字段：serverInfo,topoInfo;
		var sInfo = JPStore.getItem('serverInfoStr');
		var tInfo = JPStore.getItem('topoInfoStr');
		
		if(!checkEmpty(sInfo)) $("#serverInfo").val(sInfo);
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
		
		//2016-03-23 新增，编辑拓扑图，增加提交字段，以检测图中节点是否存在；
		
	})
</script>