<?php if (!defined('THINK_PATH')) exit();?><link href="/Public/dwz/themes/css/zTreeStyle/zTreeStyle.css" rel="stylesheet" type="text/css" />
<script src="/Public/dwz/js/jquery.ztree.all-3.5.js" type="text/javascript"></script>
<script src="/Public/dwz/js/jquery.ztree.exhide-3.5.min.js" type="text/javascript"></script>

<div layouth="35">
	<div class="side_tree js_drag_width config_side_tree_xgd" layouth="36">
		<div class="" data-size="a">
			<ul id="config_tree_xgd" class="ztree"></ul>
		</div>
	</div>
	
	<div id="config_content_xgd" layouth="36">
		<h1>请点选左边树进行操作！</h1>
	
	</div>
</div>

<script type="text/javascript">
	var zTreeObj;
	var config_tree_which_xgd,config_treeId_which_xgd;
	var config_xgd_parent;
	// zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
	var setting_xgd = {
				view: {
					dblClickExpand: false,
					selectedMulti: false,
					nameIsHTML:true,
					fontCss: setFontCss
				},
				data: {
					key: {
						title:"grouptl"
					},
					simpleData: {
						enable: true
					}
				},
				callback: {
					onRightClick: zTreeOnRightClick,
				}
};
	// zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
	
	var tree_nodes = [<?php echo ($treeMenu); ?>]
	$(document).ready(function(){
	   var xgd_tree = $.fn.zTree.init($("#config_tree_xgd"), setting_xgd, tree_nodes);
	   var zTeeO = $.fn.zTree.getZTreeObj("config_tree_xgd");
	   updateType();
	   zTeeO.expandAll(true);
	   
	   //2015-11-24 定义一个全局变量，存放树对象，消除多棵树先后加载对象丢失的问题；
	    config_xgd_parent = $.fn.zTree.getZTreeObj("config_tree_xgd");
	});
	
	
	
	
	//功能
	 function onLeftClick(sname){
		var url =  '/index.php?s=/Admin/IceWeight/showGroup/servicename/'+sname;
		$("#config_content_xgd").loadUrl(url);
	 }
	
	function zTreeOnRightClick(event,treeId,treeNode){
		config_treeId_which_xgd	=	treeId;
		//var treeObjxgd = $.fn.zTree.getZTreeObj("config_tree_xgd");
		var treeObjxgd = config_xgd_parent;
		config_tree_which_xgd	=	treeObjxgd;
		
		if(treeNode.grouptype == 'db'){
			treeObjxgd.selectNode(treeNode);
			showRMenuXGD("node", event.clientX, event.clientY,treeObjxgd,treeId,treeNode);
		}else if(treeNode.grouptype == 'gpt'){
			treeObjxgd.selectNode(treeNode);
			showRMenuXGD("root", event.clientX, event.clientY,treeObjxgd,treeId);
		}else{
			
		} 
	}
	
	//右键弹出菜单；
	function showRMenuXGD(type, x, y,tree_which,treeId,treeNode){
		var menu_xgd='<ul class="context_menu" style="left:'+(x+2)+'px;top:'+(y+2)+'px;">';
		if(type=='root'){
			 if(treeId=='config_tree_xgd'){
				 menu_xgd+='<li class="m_add_xgd" data-type="a">增加节点</li>';
			}
		}else{
			if(treeId=='config_tree_xgd'){
				if(treeNode.level==0){
					menu_xgd+='<li class="m_add_xgd" data-type="a">增加节点</li>';
				}else if(treeNode.level==1){
					// menu+='<li class="m_add_xgd" data-type="b">增加节点</li><li class="m_edit" data-type="a">编辑节点</li><li class="m_del_xgd">删除节点</li>';
					menu_xgd+='<li class="m_del_xgd">删除节点</li>';
				}else{
					//menu+='<li class="m_edit" data-type="b">编辑节点</li><li class="m_del_xgd">删除节点</li>';
				}
			}
		}
		menu_xgd+='</ul>';
		menu_xgd=$(menu_xgd);
		$('body').append(menu_xgd);
		$('body').bind("mousedown", onBodyMouseDown);
		menu_xgd.contextmenu(function(e){
			return false;
		});
		
		//$('.m_add_xgd',menu_xgd).click(function(){addTreeNode(tree_which)});
		//$('.m_edit',menu).click(function(){editTreeNode(tree_which)});
		
		$('.m_add_xgd',menu_xgd).click(function(){
			var type=$(this).data('type');
			var nodes = tree_which.getSelectedNodes();
			hideRMenuXGD();
			if(type=='a'){
				$.pdialog.open('/index.php?s=/Admin/IceWeight/groupCreateShow','tree_edit_win','新增组',{'width':'450','height':'200','mask':true});
			}
		});
		
		$('.m_del_xgd',menu_xgd).click(function(){
			hideRMenuXGD();
			var nodes = tree_which.getSelectedNodes();
			if(nodes && nodes.length>0 && !(nodes[0].children && nodes[0].children.length > 0))
			{
				var msg = '确定删除吗？';
				alertMsg.confirm(msg,{okCall:function(){
					removeTreeNode(tree_which);
				}});
				return false;
			}else
			{
				removeTreeNode(tree_which);
			}
		});
		
		//$('.m_copy',menu).click(function(){copyTreeNode(tree_which)});
		//$('.m_paste',menu).click(function(){pasteTreeNode(tree_which)});
	}
	
	function onBodyMouseDown(event){
		if (!$(event.target).is('.context_menu') && $(event.target).closest('.context_menu').length==0) {
			$('.context_menu').remove();
		}
	}
	
	function hideRMenuXGD() {
		$('.context_menu').remove();
		$("body").unbind("mousedown", onBodyMouseDown);
	}
	
	//移除节点；
	function removeTreeNode(tree_which) {
		var nodes = tree_which.getSelectedNodes();
		if (nodes && nodes.length>0) {
			if (nodes[0].children && nodes[0].children.length > 0) {
				//不能删除父节点；
				alertMsg.error("父节点不能删除！");
			} else {
				if(nodes[0].level == 1){
					$.post('/index.php/Admin/IceWeight/groupDelete',{type:"itemKind",id: nodes[0].groupid,gpname:nodes[0].name},function(data){
						if(data.statusCode=="200") {
							tree_which.removeNode(nodes[0]);
							var parentnode = nodes[0].getParentNode();
							if(parentnode.children.length == 0)
							{
								parentnode.name = parentnode.name.replace(/ \(.*\)/gi, "");
								tree_which.updateNode(parentnode);
							}
							alertMsg.correct("操作成功!");
							updateType();
						}else{
							//alertMsg.error("由于"+data.message+"删除失败!");
							alertMsg.error(data.message);
						}
					}, "json");
				}
			}
		}
	}
	
	//增加节点
	function addTreeNode(tree_which,name,id,remark) {
		hideRMenuXGD();
		var newNode = {"name":name,"target":"ajax",'groupid':id,'grouptype':'db'};
		if (tree_which.getSelectedNodes()[0]) {
			 if(config_treeId_which_xgd=='config_tree_xgd'){
				if(tree_which.getSelectedNodes()[0].level==0){
					newNode.target='ajax';
					newNode.url='/index.php?s=/Admin/IceWeight/showGroup/servicename/'+name;
				}else if(tree_which.getSelectedNodes()[0].level==1){
					newNode.target='ajax';
					newNode.url='/index.php?s=/Admin/IceWeight/showGroup/servicename/'+name;
					if(remark !=null) newNode.t=remark;
				}
			} 
			//newNode.checked = tree_which.getSelectedNodes()[0].checked;
			var new_node=tree_which.addNodes(tree_which.getSelectedNodes()[0],0,newNode,true);
		} else {
			var new_node=tree_which.addNodes(null, newNode);
		}
		initUI($('.config_side_tree_xgd'));
		$('.config_side_tree_xgd a').attr('rel','config_content_xgd');
		navTab.reload('/index.php/Admin/IceWeight', {
	        navTabId: 'D703',
	        //data:{'desployenvp':envval},
	    });
		//updateType();
	}
	
	
	//更新树信息；
	function updateType() {
		var treeObj = $.fn.zTree.getZTreeObj("config_tree_xgd");
		changeparentnums(treeObj.getNodes(),treeObj);
	}
	
	//更改节点个数；
	function changeparentnums(nodes,tree_which){
		var nodechild = nodes;
		if(nodechild && nodechild.length > 0){
			for (var i=0, l=nodechild.length; i<l; i++) {
				var num = nodechild[i].children ? nodechild[i].children.length : 0;
				if(num > 0)
				{
					if(nodechild[i].isParent)
					{
						nodechild[i].name = nodechild[i].name.replace(/ \(.*\)/gi, "") + " (<font color='red'>" + num + "</font>)";
						tree_which.updateNode(nodechild[i]);
						changeparentnums(nodechild[i].children,tree_which);
					}
				}
			}
		}
	}
	
	function setFontCss(treeId, treeNode) {
		return treeNode.level == 1 && treeNode.grouptype == 'db' ? {color:"red"} : {};
	};
	
	/* function setTreeColor(treeobj,color_db,color_zk){
		var child_nodes = treeobj.getNodes();
		if(child_nodes && child_nodes.length > 0){
			for (var i=0, l=nodechild.length; i<l; i++) {
				if(!nodechild[i].isParent)
				{
					if(nodechild[i].grouptype == 'db'){
						
					}else{
						
					}
				}
			}
		}
	} */
	//页面设置；
	$(window).resize(function(){
		var h=$('.config_side_tree_xgd').height();
		$('.config_tree_con').each(function(){
			var type=$(this).data('size');
			if(type=='a'){
				$(this).height((h/2-1)+'px');
			}else if(type=='b'){
				$(this).height((h-39)+'px');
			}else if(type=='c'){
				$(this).height('38px');
			}
		});
	}).resize();
	
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
</script>