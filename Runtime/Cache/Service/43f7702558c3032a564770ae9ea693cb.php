<?php if (!defined('THINK_PATH')) exit();?><link href="/Public/dwz/themes/css/zTreeStyle/zTreeStyle.css" rel="stylesheet" type="text/css" />
<script src="/Public/dwz/js/jquery.ztree.all-3.5.js" type="text/javascript"></script>


<div layouth="0">
	<div class="side_tree hQuery_tree js_drag_width" style="border-top:none;width:160px;">
		<ul id="hQuery_tree" class="ztree" layouth="10"></ul>
	</div>
	<div id="hQuery_content" layouth="0">
		<form id="pagerForm" action="/index.php/Service/Historyquery/search" method="post">
			<input type="hidden" name="pageNum" value="1"/>
			<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>
			<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
			<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
			<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
		    </volist>
		</form>
		<div class="pageHeader">
			<div class="item_list_filter"  style="padding-left:20px">
				<form rel="pagerForm" action="/index.php/Service/Historyquery/search" method="post" onsubmit="return divSearch(this, 'hQuery_content');">
			<div class="searchBar">
				<table class="searchContent">
					<span class="">IP地址：</span>
					<input type="hidden" size="15" name="id" id="" class="textInput"  value="<?php echo ($_REQUEST[id]); ?>"/>	
					<input type="text" size="15" name="ip" id="" class="textInput"  value="<?php echo ($_REQUEST[ip]); ?>"/>			
					<span class="">服务名称：</span>
					<input type="text" size="15" name="serviceName" id="" class="textInput"  value="<?php echo ($_REQUEST[serviceName]); ?>"/>
					<span class="">元素ID：</span>
					<input type="text" size="15" name="elemId" id="" class="textInput" value="<?php echo ($_REQUEST[elemId]); ?>"/>
					<span class="">报警时间：</span>
					<input size="28" type="text" value="<?php echo ($_REQUEST['start']); ?>" id="start" name="start" readonly="true" datefmt="yyyy-MM-dd HH:mm:ss" class="date textInput">
					<span class="">至：</span>
					<input size="28" type="text" value="<?php echo ($_REQUEST['end']); ?>" id="end" name="end" readonly="true" datefmt="yyyy-MM-dd HH:mm:ss" class="date textInput">							
					<input type="submit" value="查询" class="ui_btn_green" />

				</table>
			</div>
				</form>
			</div>
		</div>
		
		<div class="pageContent">
			<div id="hQuery_list">
				<div class="tableList" layouth="130">
					<table class="list tac" width="100%">
						<thead>
							<tr>
								<th>序号</th>
								<th>seqID</th>
								<th>IP地址</th>
								<th>服务</th>
								<th>元素名称</th>
								<th>元素ID</th>
								<th>状态</th>
								<th>邮件通知</th>
								<th>手机通知</th>
								<th>备注</th>
								<th>报警时间</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr target="script_id" rel="<?php echo ($vo['id']); ?>">
								<td>
									<?php
 $listnums = $numPerPage * ($currentPage-1) + $key+1; echo $listnums; ?>
								</td>
									<td><?php echo ($vo['id']); ?></td>
									<td><?php echo ($vo['ip']); ?></td>
									<td><?php echo ($vo['serviceName']); ?></td>
									<td><?php echo ($vo['elemName']); ?></td>
									<td><?php echo ($vo['elemId']); ?></td>
									<td><?php echo ($status[$vo['isNotified']]); ?></td>
									<td><?php echo ($vo['email']); ?></td>
									<td><?php echo ($vo['mobile']); ?></td>	
									<td><?php echo ($vo['remark']); ?></td>
									<td><?php echo ($vo['warnTime']); ?></td>								
								</tr><?php endforeach; endif; else: echo "" ;endif; ?>					
						</tbody>
					</table>
				</div>
				<div class="panelBar">
					<div class="pages">
						<span>共<?php echo ($totalCount); ?>条</span>
					</div>
					<div class="pagination" rel="hQuery_content" totalCount="<?php echo ($totalCount); ?>" numPerPage="<?php echo ($numPerPage); ?>" pageNumShown="5" currentPage="<?php echo ($currentPage); ?>"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
var settingforhQuery = {
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
	}
};

var hQuery_nodes=[
	<?php echo ($defaultTree); ?>
	];

var hQuery_tree;
$(document).ready(function(){
	$.fn.zTree.init($("#hQuery_tree"), settingforhQuery, hQuery_nodes);
	hQuery_tree = $.fn.zTree.getZTreeObj("hQuery_tree");
	// updateType();
	$('.hQuery_tree a').attr('rel','hQuery_content');
	//$('.hQuery_tree ul li a').attr('rel','hQuery_content');
	
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

var config_tree_which=hQuery_tree,
	config_treeId_which='hQuery_tree';

function onBodyMouseDown(event){
	if (!$(event.target).is('.context_menu') && $(event.target).closest('.context_menu').length==0) {
		$('.context_menu').remove();
	}
}

function changeparentnums(nodes,tree_which){
	var nodechild = nodes;
	if(nodechild && nodechild.length > 0){
		for (var i=0, l=nodechild.length; i<l; i++) {
			var num = nodechild[i].children ? nodechild[i].children.length : 0;
			if(num > 0){
				if(nodechild[i].isParent){
					nodechild[i].name = nodechild[i].name.replace(/ \(.*\)/gi, "") + " (<font color='red'>" + num + "</font>)";
					tree_which.updateNode(nodechild[i]);
					changeparentnums(nodechild[i].children,tree_which);
				}
			}
		}
	}
}
function updateType() {
	changeparentnums(hQuery_tree.getNodes(),hQuery_tree);
}


</script>