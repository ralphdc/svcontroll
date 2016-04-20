<?php if (!defined('THINK_PATH')) exit();?><link href="/Public/dwz/themes/css/zTreeStyle/zTreeStyle.css" rel="stylesheet" type="text/css" />
<script src="/Public/dwz/js/jquery.ztree.all-3.5.js" type="text/javascript"></script>
<script src="/Public/dwz/js/jquery.ztree.exhide-3.5.min.js" type="text/javascript"></script>

<form id="pagerForm" action="/index.php/Service/Batchprocess" method="post">
	<input type="hidden" name="pageNum" value="1"/>
	<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>
	<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
	<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
	<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
</form>


<div layouth="0">
	<div class="side_tree js_drag_width" style="border-top:none;width:160px;">
	<!--  
		<div>
		部署环境：
			<select name="desployenvp" onchange="reloadTreetask(this.value)">
				<option value="" <?php if($_REQUEST[desployenvp]=="") echo "selected" ?>>请选择</option>
				<option value="5" <?php if($_REQUEST[desployenvp]=="5") echo "selected" ?>>未发布</option>
				<?php if($treeType == 1) {?>
				<option value="4" <?php if($_REQUEST[desployenvp]=="4") echo "selected" ?>>测试环境</option>
				<option value="3" <?php if($_REQUEST[desployenvp]=="3") echo "selected" ?>>测试镜像</option>
				<?php }elseif($treeType == 2){?>
				<option value="1" <?php if($_REQUEST[desployenvp]=="1") echo "selected" ?>>运维环境</option>
				<option value="2" <?php if($_REQUEST[desployenvp]=="2") echo "selected" ?>>生产</option>
				<?php }?>
			</select>
		</div>
		-->
		<ul id="task_umcomplete" class="ztree" layouth="350"></ul>
		<ul id="task_complete" class="ztree" layouth="350"></ul>
	</div>
	<div id="task_content" layouth="0">
		<div class="item_list_filter"  style="padding-left:20px">
			<form class="pagerForm" action="/index.php/Service/Batchprocess/search" method="post" onsubmit="return divSearch(this, 'task_content');">
						
				<span class="">服务名：</span>
				<input type="text" size="15" name="servicename" id="" class="textInput" value="<?php echo ($_REQUEST[servicename]); ?>" />												
				<input style="margin-left:20px;" type="submit" value="查询" class="ui_btn_green" />
				<!-- <?php if($showbutton == 1): ?><a style="margin-left:50px;" title="部署" rel="D60622" target="navTab" href="/index.php/Service/Batchprocess/index/from/1" ><input type="submit" value="部署" class="ui_btn_green"/></a>
				<a style="margin-left:50px;" title="配置预览" rel="D60622" target="navTab" href="/index.php/Service/Seeconfigs/index/taskid/1" ><input type="submit" value="配置预览" class="ui_btn_green"/></a><?php endif; ?> -->
			</form>
		</div>
		<div id="repertory_list">
			<div class="tableList" layouth="83">
				<table class="list tac" width="100%">
					<thead>
						<tr>
							<th>序号</th>
							<th>服务名</th>
							<th>版本</th>
							<th>类型</th>
							<th>功能描述</th>
							<th>main入口</th>
							<th>发布状态</th>
							<th>任务名称</th>
							<th>任务状态</th>
							<th>导入时间</th>
							<th>构建时间</th>
							<th>&nbsp;&nbsp;操&nbsp;作&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
						</tr>
					</thead>
					<tbody>
					<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr target="script_id" rel="<?php echo ($vo['mwId']); ?>">
								<td>
									<?php
 $listnums = $numPerPage * ($currentPage-1) + $key+1; echo $listnums; ?>
								</td>
								<td><?php echo ($vo['servicename']); ?></td>
								<td><?php echo ($vo['serviceversion']); ?></td>
								<td>
									<?php echo $servicetype[ $vo['servicetype'] ] ?>
								</td>
								<td><?php echo ($vo['servicefunction']); ?></td>
								<td title="<?php echo ($vo['javamain']); ?>"><?php echo (substr($vo['javamain'],0,7)); ?></td>
								<td <?php if($vo['deploymentFlag'] == 1){ echo 'style="color:red"';} elseif($vo['deploymentFlag'] =='2' && ($vo['desployenv'] == '1' || $vo['desployenv'] == '4')){ echo 'style="color:green;"';} ?>>
									<?php echo $deploymentFlagArr[$vo['deploymentFlag']] ?>
								</td>
								<td><?php echo ($vo['taskname']); ?></td>
								<td>
									<?php echo $taskstate[ $vo['taskstate'] ] ?>
								</td>
								<td><?php echo ($vo['importtime']); ?></td>
								
								<td><?php echo ($vo['buildtime']); ?></td>
								<td>
									<?php
 $btnclass = 'btnEdit'; if($vo['deploymentFlag'] =='2') { $btnclass = 'btnInfo'; } ?>
									<a rel="createconfig" href="/index.php/Service/Batchprocess/call/ptaskid/<?php echo ($vo['taskid']); ?>/mwId/<?php echo ($vo['mwId']); ?>/ssid/<?php echo ($vo['ssid']); ?>/sername/<?php echo ($vo['servicename']); ?>/deploymentFlag/<?php echo ($vo['deploymentFlag']); ?>/version/<?php echo ($vo['serviceversion']); ?>/defaultcfgid/<?php echo ($vo['defaultcfgid']); ?>/defaultcfg/<?php echo ($vo['defaultcfg']); ?>/desploypath/<?php echo base64_encode($vo['desploypath']) ?>" height="600" width="900" mask="true" class="<?php echo ($btnclass); ?> ml10" title="作业计划" target="dialog">调用</a>
									<a href="/index.php/Service/Batchprocess/del/id/<?php echo ($vo['mwId']); ?>/taskid/<?php echo ($vo['taskid']); ?>" target="ajaxTodo" title="确定要删除？" class="btnDel ml10">删除</a>
								</td>								
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>				
					</tbody>
				</table>
			</div>
			<div class="panelBar">
				<div class="pages">
					<span>共<?php echo ($totalCount); ?>条</span>
				</div>
				<div class="pagination" targetType="navTab" totalCount="<?php echo ($totalCount); ?>" numPerPage="<?php echo ($numPerPage); ?>" pageNumShown="5" currentPage="<?php echo ($currentPage); ?>"></div>
			</div>
		</div>

	</div>
</div>

<script type="text/javascript">
var setting = {
	view: {
		dblClickExpand: false,
		selectedMulti: false,
		nameIsHTML:true
	},
	data: {
		simpleData: {
			enable: true
		}
	},
	edit: {
		enable: false,
		showAddBtn: false,
		showRemoveBtn: false,
		showRenameBtn: false
	},
	callback: {
		onRightClick: OnRightClick
	}
};

var task_umcomplete_nodes=[
	<?php echo ($defaultTree); ?>
	];
var task_complete_nodes=[
      <?php echo ($completeTree); ?>
    ];

var task_umcomplete;
var task_complete;

$(document).ready(function(){
	$.fn.zTree.init($("#task_umcomplete"), setting, task_umcomplete_nodes);
	$.fn.zTree.init($("#task_complete"), setting, task_complete_nodes);
	task_umcomplete = $.fn.zTree.getZTreeObj("task_umcomplete");
	task_complete = $.fn.zTree.getZTreeObj("task_complete");
	
	// updateType();
	$('#task_umcomplete a').attr('rel','task_content');
	$('#task_complete a').attr('rel','task_content');
	task_umcomplete.expandAll(false);
	task_complete.expandAll(false);
	var menode = task_umcomplete.getNodeByTId('1');
	task_umcomplete.expandNode(menode, true, null, null, false);
	var menode1 = task_complete.getNodeByTId('1');
	task_complete.expandNode(menode1, true, null, null, false);
	
	$('.js_drag_width').each(function(){
		if($('.mouse_area',this).length!=0){
			return;
		}
		var area=$(this),
			handle=$('<div class="mouse_area" style="position:absolute;top:0;right:0;width:5px;height:100%;cursor:e-resize;"></div>')
		$(this).css('position','relative').append(handle);
		var drag_move=false,
			s_x,
			s_w;
		handle.mousedown(function(event){
			drag_move=true;
			s_x=event.pageX;
			s_w=area.width();
			$('body').bind('selectstart',function(){return false;}).addClass('unselect');
		});
		$(document).mousemove(function(event){
			if(drag_move){
				var e_x=event.pageX,
					dist=e_x-s_x,
					e_w=s_w+dist;
				if(e_w<100){
					e_w=100
				}else if(e_w>800){
					e_w=800;
				}
				console.log(e_w);
				area.width(e_w+'px');
			}
		}).mouseup(function(){
			drag_move=false;
			$('body').unbind('selectstart').removeClass('unselect');
		});
	});
});

var config_tree_which,config_treeId_which;

function OnRightClick(event, treeId, treeNode) {
	config_treeId_which=treeId;
	//console.log(treeNode);
	if(treeId=='task_umcomplete'){
		var tree_which=task_umcomplete;
		config_tree_which=task_umcomplete;
	}else{
		var tree_which=task_complete;
		config_tree_which=task_complete;
	}
	if (!treeNode && event.target.tagName.toLowerCase() != "button" && $(event.target).parents("a").length == 0) {
		tree_which.cancelSelectedNode();
		showRMenufortask("root", event.clientX, event.clientY,tree_which,treeId);
	} else if (treeNode && !treeNode.noR) {
		tree_which.selectNode(treeNode);
		showRMenufortask("node", event.clientX, event.clientY,tree_which,treeId,treeNode);
	}
}

function showRMenufortask(type, x, y,tree_which,treeId,treeNode){
	var menu='<ul class="context_menu" style="left:'+(x+2)+'px;top:'+(y+2)+'px;">';
	if(type=='root'){
		
	}else{
		var addElement = treeNode.addElement;
		if(treeNode.level==1){
			if(addElement == 1){
				menu+='<li class="m_edit">编辑任务名</li><li class="m_del">删除该任务</li><li class="m_addserv">添加元数据</li>';
			}else{
				menu+='<li class="m_edit">编辑任务名</li><li class="m_del">删除该任务</li>';
			}
		}
	}
	menu+='</ul>';
	menu=$(menu);
	$('body').append(menu);
	$('body').bind("mousedown", onBodyMouseDown);
	menu.contextmenu(function(e){
		return false;
	});
	
	$('.m_edit',menu).click(function(){
		if($(this).hasClass('disable')){
			return false;
		}
		var nodes = config_tree_which.getSelectedNodes();
		hideRMenu();
		var node_name=treeNode.name;
		$.pdialog.open('/index.php/Service/Batchprocess/edit?taskId='+nodes[0].id+'&name='+node_name,'tree_edit_win',node_name+'修改任务名',{'width':'600','height':'300','mask':true});
	});
	$('.m_del',menu).click(function(){
		hideRMenu();
		var nodes = tree_which.getSelectedNodes();
		if(nodes && nodes.length>0 && !(nodes[0].children && nodes[0].children.length > 0))
		{
			var msg = '确定删除吗？';
			alertMsg.confirm(msg,{okCall:function(){
				removeTreeNodeTask(tree_which);
			}});
			return false;
		}else
		{
			removeTreeNodeTask(tree_which);
		}
	});
	$('.m_addserv',menu).click(function(){
		hideRMenu();
		var nodes = tree_which.getSelectedNodes();
		//navTab.reload('/index.php/Service/Repertory?batch=1&taskId='+nodes[0].id,"navTabId",'D60602');
		$.cookie('batchadd','1',{path:'/'});
		$.cookie('taskId',nodes[0].id,{path:'/'});
		//判断是否已经生成
		$.ajax({
		   type: "POST",
		   url: "/index.php/Service/Batchprocess/checkComplete",
		   data: "taskId="+nodes[0].id,
		   success: function(msg){
			 if(msg == "1"){
				navTab.openTab('D60602', '/index.php/Service/Repertory', {"title":"仓库中心"});
			 }else{
				alertMsg.error(msg);
			 }
		   }
		});
		
		
		
	});
	
}

function renameTreeNode(name){
	var nodes = config_tree_which.getSelectedNodes(),
		treeNode = nodes[0];
	treeNode.name=name;
	var linktime = new Date().getTime();
	treeNode.url=treeNode.url+'&linktime='+linktime;
	config_tree_which.updateNode(treeNode);
}

function removeTreeNodeTask(tree_which) {
	var nodes = tree_which.getSelectedNodes();
	if (nodes && nodes.length>0) {
		if (nodes[0].children && nodes[0].children.length > 0) {
			var msg = "要删除的节点是父节点，如果删除将连同子节点一起删掉。\n\n请确认！";
			alertMsg.confirm(msg,{okCall:function(){
				$.post('/index.php/Service/Batchprocess/delete',{id: nodes[0].id},function(data){
					if(data.statusCode=="200") {
						tree_which.removeNode(nodes[0]);
						alertMsg.correct("操作成功!");
						navTab.reload(data.forwardUrl);
						//updateType();
					}else{
						alertMsg.error("由于"+data.message+",删除失败!")
					}
				}, "json");
				}
			})
		} 
	}
}

function hideRMenu() {
	$('.context_menu').remove();
	$("body").unbind("mousedown", onBodyMouseDown);
}
function onBodyMouseDown(event){
	if (!$(event.target).is('.context_menu') && $(event.target).closest('.context_menu').length==0) {
		$('.context_menu').remove();
	}
}


function reloadTreetask(envval)
{
	navTab.reload('/index.php/Service/Batchprocess/index', {
        navTabId: 'D60622',
        data:{'desployenvp':envval},
    });
}

<?php  if($deletedSucess > 0) { ?>
			var deletenode = task_umcomplete.getNodeByParam("id","<?php echo $deletedSucess;?>",null);
			if(deletenode)
			{
				task_umcomplete.expandNode(deletenode,true,true,true); 
				task_umcomplete.selectNode(deletenode);
			}else
			{
				var deletenode = task_complete.getNodeByParam("id","<?php echo $deletedSucess;?>",null);
				if(deletenode)
				{
					task_complete.expandNode(deletenode,true,true,true); 
					task_complete.selectNode(deletenode);
				}
			}
	<?php
 } ?>
	
	

</script>