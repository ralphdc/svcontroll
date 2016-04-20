<?php if (!defined('THINK_PATH')) exit();?><link href="/Public/dwz/themes/css/zTreeStyle/zTreeStyle.css" rel="stylesheet" type="text/css" />
<script src="/Public/dwz/js/jquery.ztree.all-3.5.js" type="text/javascript"></script>

<form id="pagerForm" action="/index.php/Service/Repertory" method="post">
	<input type="hidden" name="pageNum" value="1"/>
	<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>
	<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
	<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
	<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
</form>

<div layouth="0">
	<div class="side_tree repertory_tree js_drag_width" style="border-top:none;width:160px;">
		<div>
		部署环境：
			<select name="desployenvp" onchange="reloadTree(this.value)">
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
		<ul id="repertory_tree" class="ztree" layouth="10"></ul>
	</div>
	<div id="repertory_content" layouth="0">
		<div class="item_list_filter" style="border-bottom:solid 1px #ddd; <?php if($enviroments==2) echo 'display:none'?>">
			<!-- form action="" method=""-->
				<span class="pro">svn路径：</span>
				<textarea name="svnlink" id="svnurl" style="width: 630px; height: 17px;"></textarea>
				<input type="submit" value="导入" class="ui_btn_green" id="svnbtn" />
				<a title="批量导入" width="1016" height="702"  rel="dlg_page2" target="dialog" href="/index.php/Service/Repertory/import" ><input type="submit" value="批量导入" class="ui_btn_green"/></a>
			<!--/form-->
		</div>
		<div class="item_list_filter" style="border-bottom:solid 1px #ddd;">
			<p>
			<span style="color:red;">红色表示任何环境都未发布</span>
			<?php if(intval($_SESSION['WEB_ENVIRONMENT']) == 4): ?>
			<span style="color:green">绿色表示测试环境已发布</span>
			<span>黑色表示测试镜像环境已发布</span>
			
			<?php endif; ?>
			<?php if(intval($_SESSION['WEB_ENVIRONMENT']) == 1): ?>
			<span style="color:green">绿色表示运维镜像环境已发布</span>
			<span>黑色表示生产环境已发布</span>
			<?php endif; ?>
			<?php if(intval($_SESSION['WEB_ENVIRONMENT']) == 3): ?>
			<span style="color:green">绿色表示测试环境已发布</span>
			<span>黑色表示测试镜像环境已发布</span>
			<?php endif; ?>
			<?php if(intval($_SESSION['WEB_ENVIRONMENT']) == 2): ?>
			<span style="color:green">绿色表示运维镜像环境已发布</span>
			<span>黑色表示生产环境已发布</span>
			<?php endif; ?>
			<?php if(intval($_SESSION['WEB_ENVIRONMENT']) == 5): ?>
			<span style="color:green">绿色表示测试环境与运维镜像环境已发布 </span>
			<span>黑色表示测试镜像与生产环境已发布</span>
			<?php endif; ?>
		</div>
		<div class="item_list_filter"  style="padding-left:20px">
			<form class="pagerForm" action="/index.php/Service/Repertory/search" method="post" onsubmit="return divSearch(this, 'repertory_content');">
				<span class="">产品名：</span>
				<input type="text" size="15" name="productname" id="" class="textInput" />			
				<span class="">服务名：</span>
				<input type="text" size="15" name="servicename" id="" class="textInput" />
				<span class="">版本：</span>
				<input type="text" size="15" name="serviceversion" id="" class="textInput" />
				<span class="">MD5：</span>
				<input type="text" size="15" name="md5" id="" class="textInput" />
				<span class="">状态：</span>
				<select name="deploymentFlag" id="" class="">
					<option value="" selected>全部</option>
					<option value="2">已发布</option>
					<option value="1">未发布</option>				
				</select>												
				<input type="submit" value="查询" class="ui_btn_green" />
				<!--input type="button" onclick="toTaskLook()" value="查看本次批量任务" class="ui_btn_green"/>
				<input type="hidden" id="batchprocess" value="0"/-->
				<a title="查看批量任务" rel="D60621" target="navTab" href="/index.php/Service/Tasklook/index" ><input type="submit" value="查看本次批量任务" class="ui_btn_green"/></a>
				<a title="设置显示列" width="473" height="512" mask="true"  rel="dlg_page3" target="dialog" href="/index.php/Service/Repertory/setshowcolum" ><input type="submit" value="设置显示列" class="ui_btn_green"/></a>
			</form>
		</div>
		<div id="repertory_list">
			<div class="tableList" layouth="<?php if($enviroments==2){ echo 88;}else{ echo 130;}?>">
				<table class="list tac" width="100%">
					<thead>
						<tr>
							<th width="30"><!-- <input type="checkbox" class="checkboxCtrl" group="orgId" onclick="checkTime2(this);"/> --></th>
							<th>序号</th>
							<?php if(is_array($showClums)): $ks = 0; $__LIST__ = $showClums;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vos): $mod = ($ks % 2 );++$ks; if(($ks == 'svnpath') ): ?><th width="50"><?php echo ($vos); ?></th>
								<?php else: ?> 
									<th><?php echo ($vos); ?></th><?php endif; endforeach; endif; else: echo "" ;endif; ?>
							<th>&nbsp;&nbsp;操&nbsp;作&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
						</tr>
					</thead>
					<tbody>
					<?php if(is_array($list)): $vks = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($vks % 2 );++$vks;?><tr target="script_id" rel="<?php echo ($vo['ssid']); ?>" onclick="checkTime(this);">
								<td>
									<?php
 $checked = ''; if(in_array($vo['mwId'],$metaIDArr)) $checked = "checked"?>
									<input onclick="checkTime1(this);"  type="checkbox" name="orgId" <?php echo ($checked); ?> value="<?php echo ($vo['mwId']); ?>"/>
								</td>
								<td>
									<?php
 $listnums = $numPerPage * ($currentPage-1) + $key+1; echo $listnums; ?>
								</td>
								<?php if(array_key_exists('servicename',$showClums)): ?><td><?php echo ($vo['servicename']); ?></td><?php endif; ?>
								<?php if(array_key_exists('serviceversion',$showClums)): ?><td><?php echo ($vo['serviceversion']); ?></td><?php endif; ?>
								<?php if(array_key_exists('servicetype',$showClums)): ?><td>
									<?php echo $servicetype[ $vo['servicetype'] ] ?>
								</td><?php endif; ?>
								<?php if(array_key_exists('is_tool',$showClums)): ?><td>
									<?php echo $toolstype[ $vo['is_tool'] ] ?>
								</td><?php endif; ?>
								<?php if(array_key_exists('servicefunction',$showClums)): ?><td><?php echo ($vo['servicefunction']); ?></td><?php endif; ?>
								<?php if(array_key_exists('svnpath',$showClums)): ?><td style="line-height: 2.5;display:block;width:100px;overflow:hidden" title="<?php echo ($vo['svnpath']); ?>"><?php echo ($vo['svnpath']); ?></td><?php endif; ?>
								<?php if(array_key_exists('javamain',$showClums)): ?><td title="<?php echo ($vo['javamain']); ?>"><?php echo (substr($vo['javamain'],0,7)); ?></td><?php endif; ?>
								<?php if(array_key_exists('deploymentFlag',$showClums)): ?><td <?php if($vo['deploymentFlag'] == '未发布'){ echo 'style="color:red"';} elseif(($vo['deploymentFlag'] =='已发布' || $vo['deploymentFlag'] =='未发布至生产') && ($vo['desployenv'] == '1' || $vo['desployenv'] == '4')){ echo 'style="color:green;"';} ?>>
									<?php echo $vo['deploymentFlag']; ?>
								</td><?php endif; ?>
								<?php if(array_key_exists('importtime',$showClums)): ?><td><?php echo ($vo['importtime']); ?></td><?php endif; ?>
								<?php if(array_key_exists('buildtime',$showClums)): ?><td><?php echo ($vo['buildtime']); ?></td><?php endif; ?>
								<?php if(array_key_exists('md5',$showClums)): ?><td><?php echo ($vo['md5']); ?></td><?php endif; ?>
								<td>
									<a rel="sendplan" href="/index.php/Service/Repertory/call/mwId/<?php echo ($vo['mwId']); ?>/ssid/<?php echo ($vo['ssid']); ?>/sername/<?php echo ($vo['servicename']); ?>/version/<?php echo ($vo['serviceversion']); ?>/defaultcfgid/<?php echo ($vo['defaultcfgid']); ?>/defaultcfg/<?php echo ($vo['defaultcfg']); ?>/desploypath/<?php echo base64_encode($vo['desploypath']) ?>" height="600" width="900" mask="true" class="btnEdit ml10" title="作业计划" target="dialog">调用</a>
									<a class="btnInfo" rel="D60635" title="查看仓库记录" target="NavTab" href="/index.php/Service/Reperthistory/index/mwId/<?php echo ($vo['mwId']); ?>">查看历史</a>
									<a href="/index.php/Service/Repertory/del/id/<?php echo ($vo['mwId']); ?>" target="ajaxTodo" title="确定要删除？" class="btnDel ml10">删除</a>
									<?php if($vo['pro_visible'] != 2 and $enviroments == 1): ?><a href="/index.php/Service/Repertory/showiinproduct/id/<?php echo ($vo['mwId']); ?>" target="ajaxTodo" title="确定要在生产环境上进行显示？" class="btnView ml10">在生产上显示</a><?php endif; ?>
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

var repertory_nodes=[
	<?php echo ($defaultTree); ?>
	];

var repertory_tree;
$(document).ready(function(){
	$.fn.zTree.init($("#repertory_tree"), setting, repertory_nodes);
	repertory_tree = $.fn.zTree.getZTreeObj("repertory_tree");
	// updateType();
	$('.repertory_tree a').attr('rel','repertory_content');
	repertory_tree.expandAll(false);
	var menode = repertory_tree.getNodeByTId('1');
	//repertory_tree.selectNode(menode);
	repertory_tree.expandNode(menode, true, null, null, false);
	//$('.repertory_tree ul li a').attr('rel','repertory_content');
	
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

var config_tree_which=repertory_tree,
	config_treeId_which='repertory_tree';
function OnRightClick(event, treeId, treeNode) {
	var tree_which=repertory_tree;
	if (!treeNode && event.target.tagName.toLowerCase() != "button" && $(event.target).parents("a").length == 0) {
		tree_which.cancelSelectedNode();
		showRMenures("root", event.clientX, event.clientY,tree_which,treeId);
	} else if (treeNode && !treeNode.noR) {
		tree_which.selectNode(treeNode);
		showRMenures("node", event.clientX, event.clientY,tree_which,treeId,treeNode);
	}
}

function showRMenures(type, x, y,tree_which,treeId,treeNode){
	var menu='<ul class="context_menu" style="left:'+(x+2)+'px;top:'+(y+2)+'px;">';
	
	if(type=='root'){
		
	}else{
		if(treeNode.level==2){
			var ss_type = treeNode.ss_type;;
			if('path' in treeNode){
				if(ss_type == 2){
					menu+='<li class="m_edit">修改路径和配置</li><li class="m_fileFilter">文件过滤或一致</li>';
				}else if(ss_type == 3){
					menu+='<li class="m_edit">修改路径和配置</li><li class="m_coverresour">是否覆盖resource目录</li><li class="m_initsh">是否覆盖init.sh</li>';
				}else{
					menu+='<li class="m_edit">修改路径和配置</li>';
				}
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
	
	$('.m_add',menu).click(function(){
		if($(this).hasClass('disable')){
			return false;
		}
		var nodes = repertory_tree.getSelectedNodes();
		hideRMenu();
		var node_name=treeNode.name.replace(/ \(.*\)/gi, "");
		$.pdialog.open('/index.php/Service/Repertory/add?mwId='+nodes[0].id,'tree_edit_win',node_name+'添加路径和配置',{'width':'600','height':'300','mask':true});
	});
	$('.m_edit',menu).click(function(){
		if($(this).hasClass('disable')){
			return false;
		}
		var nodes = repertory_tree.getSelectedNodes();
		hideRMenu();
		var node_name=treeNode.name.replace(/ \(.*\)/gi, "");
		$.pdialog.open('/index.php/Service/Repertory/edit?mwId='+nodes[0].id,'tree_edit_win',node_name+'修改路径和配置',{'width':'600','height':'300','mask':true});
	});
	$('.m_fileFilter',menu).click(function(){
		if($(this).hasClass('disable')){
			return false;
		}
		var nodes = repertory_tree.getSelectedNodes();
		hideRMenu();
		var node_name=treeNode.name.replace(/ \(.*\)/gi, "");
		$.pdialog.open('/index.php/Service/Repertory/getfileFilter?svrid='+nodes[0].id+'&svrname='+node_name,'tree_filtle_win','文件过滤或一致',{'width':'600','height':'600','mask':true});
	});
	
	
	$('.m_coverresour',menu).click(function(){
		if($(this).hasClass('disable')){
			return false;
		}
		var nodes = repertory_tree.getSelectedNodes();
		hideRMenu();
		var node_name=treeNode.name.replace(/ \(.*\)/gi, "");
		$.get('/index.php/Service/Repertory/getcoverResource1?svrid='+nodes[0].id+'&svrname='+node_name,{},function(data){
			var jsonobj=eval('('+data+')');
			if(jsonobj.statusCode == "30")
			{
				alertMsg.error(jsonobj.message);
			}else
			{
				$.pdialog.open('/index.php/Service/Repertory/getcoverResource?svrid='+nodes[0].id+'&svrname='+node_name,'tree_resource_win','是否覆盖resource目录',{'width':'600','height':'200','mask':true});	
			}
		});
	});
	
	$('.m_initsh',menu).click(function(){
		if($(this).hasClass('disable')){
			return false;
		}
		var nodes = repertory_tree.getSelectedNodes();
		hideRMenu();
		var node_name=treeNode.name.replace(/ \(.*\)/gi, "");
		$.get('/index.php/Service/Repertory/getcoverInit1?svrid='+nodes[0].id+'&svrname='+node_name,{},function(data){
			var jsonobj=eval('('+data+')');
			if(jsonobj.statusCode == "30")
			{
				alertMsg.error(jsonobj.message);
			}else
			{
				$.pdialog.open('/index.php/Service/Repertory/getcoverInit?svrid='+nodes[0].id+'&svrname='+node_name,'tree_init_win','是否覆盖init.sh',{'width':'600','height':'200','mask':true});	
			}
		});
		
	});
	
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
	changeparentnums(repertory_tree.getNodes(),repertory_tree);
}

//svn import
$('#svnbtn').click(function(){
	$.post('/index.php/Service/Repertory/importsvn'
			,{svnurl:$("#svnurl").val()}
			,function(data){
				if(data.statusCode=='1'){
					alertMsg.correct(data.message);
					 if (data.navTabId) {
				            navTab.reload(data.forwardUrl, {
				                navTabId: data.navTabId
				            });
					 }
					
				}else{
					alertMsg.error(data.message);
				}
			}
			,"json"
	)
})

function reloadTree(envval)
{
	navTab.reload('/index.php/Service/Repertory/index', {
        navTabId: 'D60602',
        data:{'desployenvp':envval},
    });
}



	var MetaIDArr = [];
	var uniqueMetaIDArr = [];
	function onlyUnique(value, index, self) { 
	    return self.indexOf(value) === index;
	}
	uniqueMetaIDArr = MetaIDArr.filter( onlyUnique );
	function checkTime(obj)
	{
		//新增加点击行右边的树展开到对应的位置
		 var tempObj =  $(obj);
		 var value= parseInt(tempObj.attr('rel'));
		 repertory_tree.expandAll(false);
		var menode = repertory_tree.getNodeByTId('1');
		//repertory_tree.selectNode(menode);
		repertory_tree.expandNode(menode, true, null, null, false);
		 var nodecheck = repertory_tree.getNodeByParam("id", value,null);
		 repertory_tree.expandNode(nodecheck,true,true,true);
	     var nowObj =tempObj.find('input');
	     var checked = nowObj.attr('checked');
	     if(checked){
		  	 $.ajax({ 
		  		async: false, 
		  		type : "POST",
		  		data:{bathval:nowObj.val(),type:1},
		  		url : "/index.php/Service/Repertory/bathprocess", 
		  		dataType : 'json', 
		  		success : function(data) { 
		  			if(data.status == 1)
			  		   {
			  			 	nowObj.removeAttr('checked');
			  		   }
		  		} 
		  		}); 
	     }else{ 
		  	 $.ajax({ 
			  		async: false, 
			  		type : "POST",
			  		data:{bathval:nowObj.val(),type:2},
			  		url : "/index.php/Service/Repertory/bathprocess", 
			  		dataType : 'json', 
			  		success : function(data) { 
			  			if(data.status == 1)
				  		   {
			  				nowObj.attr('checked','true');
				  		   }
			  		} 
			  		}); 
	  	 }
	}
	function checkTime1(obj)
	{
		 var tempObj =  $(obj);
	     var nowObj =tempObj;
		 var checked = nowObj.attr('checked');
	     if(checked){
	  	   nowObj.removeAttr('checked');
	     }else{
	  	   nowObj.attr('checked','true');
	  	 }
	}
	
	
	/* var adIds = "";  
     $("input:checkbox[name=orgId]").each(function(i){  
         if(0==i){  
             adIds = $(this).val();  
         }else{  
             adIds += (","+$(this).val());  
         }  
     }); 
	
	 function checkTime2(obj)
	{
	     var nowObj =$(obj);
		 var checked = nowObj.attr('checked');
	     if(checked){
	         $.post("/index.php/Service/Repertory/bathprocess",{bathval:0,bathvalStr:adIds,type:3},function(data){
		  	   },'json');
	         
	         $.ajax({ 
			  		async: false, 
			  		type : "POST",
			  		data:{bathval:0,bathvalStr:adIds,type:3},
			  		url : "/index.php/Service/Repertory/bathprocess", 
			  		dataType : 'json', 
			  		success : function(data) {} 
			  		}); 
	         
	     }else{ 
	          $.post("/index.php/Service/Repertory/bathprocess",{bathval:0,bathvalStr:adIds,type:4},function(data){
		  	   },'json'); 
	         $.ajax({ 
			  		async: false, 
			  		type : "POST",
			  		data:{bathval:0,bathvalStr:adIds,type:4},
			  		url : "/index.php/Service/Repertory/bathprocess", 
			  		dataType : 'json', 
			  		success : function(data) {} 
			  		}); 
	  	 }
	} */
	
	

</script>