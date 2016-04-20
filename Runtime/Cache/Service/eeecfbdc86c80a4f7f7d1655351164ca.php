<?php if (!defined('THINK_PATH')) exit();?><!--  
<form id="pagerForm" action="/index.php/Service/Graphlogic" method="post">
	<input type="hidden" name="pageNum" value="1"/>
	<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>
	<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
	<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
	<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
</form>

-->
<form id="pagerForm" action="/index.php/Service/Graphlogic/editChildTP" method="post">

	<input type="hidden" name="pageNum" value="1"/>

	<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>

	<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>

	<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>

	<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>

</form>




<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return dialogSearch(this);" action="/index.php/Service/Graphlogic/editChildTP" method="post">
	<div class="searchBar">
		<ul class="searchContent">
			<li>
			<label>拓扑图名称：</label>
			<input type="text" value="<?php echo ($_REQUEST['data']['topoName']); ?>" id="query" name="data[topoName]" class="textInput">
			</li>
		</ul>
		<div class="subBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">查询</button></div></div></li>
			</ul>
		</div>
	</div>
	</form>
</div>

<div class="pageContent">
	<table class="table" width="100%" layoutH="138">
		<thead>
		<tr>
			<th width="60">序号</th>
			<th>拓扑名称</th>
			<th>创建日期</th>
			<th>节点数</th>
			<th width="80">操作</th>
		</tr>
		</thead>
		<tbody>
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="childtpConent">
				<td>
				<input type="hidden" class="tpTagId" value="<?php echo ($vo["topoId"]); ?>" />
				<input type="hidden" class="tpTagName" value="<?php echo ($vo["topoName"]); ?>" />
				<?php  $tag = ($currentPage-1)*$numPerPage + $i; ?>
				<?php echo $tag; ?>
				</td>
				<td class="tpName"><?php echo ($vo["topoName"]); ?></td>
				<td><?php echo ($vo["createDate"]); ?></td>
				<td><?php echo ($vo["nodes"]); ?></td>
				<td width="200">
					<!-- <a class="btnSelect" target="ajaxTodo" callback="handleChildTP"  href="/index.php/Service/Graphlogic/saveChildTP/id/<?php echo ($vo["topoId"]); ?>">选择</a>  -->
					<a class="btnSelect"  href="#" onclick="selectGLTP([<?php echo ($vo["topoId"]); ?>,'<?php echo ($vo["topoName"]); ?>'])">选择</a>
				</td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</tbody>
	</table>
	<div class="panelBar">
		<div class="pages">
			<span>显示</span>
			<select class="combox" name="numPerPage" onchange="dialogPageBreak({numPerPage:this.value})">
				<?php
 $numPerPageArr = array(20,50,100,200); foreach($numPerPageArr as $val) { if($val == $numPerPage) $selected = 'selected'; echo '<option value="'.$val.'" '.$selected.'>'.$val.'</option>'; $selected = ''; } ?>
			</select>
			<span>条，共<?php echo ($totalCount); ?>条</span>
		</div>
		<div class="pagination" targetType="dialog" totalCount="<?php echo ($totalCount); ?>" numPerPage="<?php echo ($numPerPage); ?>" pageNumShown="5" currentPage="<?php echo ($currentPage); ?>"></div>
	</div>
</div>

<script type="text/javascript">
/* $(document).ready(function(){
	var currentEditId = $("input[name='raltpid']").val();
	$(".childtpConent").each(function(){
		var cid = $(this).find(".tpTagId").val();
		if(cid == currentEditId){
			$(this).hide();
		}
	})
}) */

function handleChildTP(json)
{
	if (json.statusCode == DWZ.statusCode.ok) {
		//编辑子拓扑成功~！
		var node = scene.selectedElements[0];
		var current = new Date().getTime();
		var nodeid = json.tpid +'_'+ current;
		//var nodeid = json.tpid;
		node.text = json.tpname;	//修改节点文本；
		node.setXgdId(nodeid); 		//添加唯一标识；
		node.setDtype('childtp'); 	//设置设备类型；
		node.setTpId(json.tpid);
		node.setProName(json.proName);
		$.pdialog.closeCurrent();
	}else{
		alertMsg.error("提交有误，请稍后再试！");
	}
}

function selectGLTP(arr){
	if(!(arr instanceof Array)){
		alertMsg.error("选择有误，请重新选择~！");
		return false;
	}
	if(arr.length < 2){
		alertMsg.error("选择有误，请重新选择~！");
		return false;
	}
	var currentEditId = $("input[name='raltpid']").val();
	if(arr[0] == currentEditId){
		alertMsg.error("不能选择自己作为拓扑节点！");
		return false;
	}
	var tpId 	= arr[0]; 
	var tpName 	= arr[1];
	if(checkEmpty(tpId) || checkEmpty(tpName)){
		alertMsg.error("选择有误，请重新选择~！");
		return false;
	}
	var node = scene.selectedElements[0];
	var current = new Date().getTime();
	var xgdid = tpId +'_'+ current;
	node.text = tpName;	//修改节点文本；
	node.setXgdId(xgdid); 		//添加唯一标识；
	node.setDtype('childtp'); 	//设置设备类型；
	node.setTpId(tpId);
	$.pdialog.closeCurrent();
	console.log(node);
}
</script>