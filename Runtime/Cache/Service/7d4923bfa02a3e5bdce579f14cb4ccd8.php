<?php if (!defined('THINK_PATH')) exit();?><link href="/Public/dwz/themes/css/zTreeStyle/zTreeStyle.css" rel="stylesheet" type="text/css" />
<script src="/Public/dwz/js/jquery.ztree.all-3.5.js" type="text/javascript"></script>
<script src="/Public/dwz/js/jquery.ztree.exhide-3.5.min.js" type="text/javascript"></script>


<div class="head_search">
	<table>
		<tr>
			<td>
				<div class="radioGroup">
					<label for="config_search_pz" class="radioButton"><input type="radio" name="config_search_which" id="config_search_pz" value="1" checked="checked" />配置项</label>
					<label for="config_search_sl" class="radioButton"><input type="radio" name="config_search_which" id="config_search_sl" value="2" />配置实例</label>
					<label for="config_search_sm" class="radioButton"><input type="radio" name="config_search_which" id="config_search_sm" value="3" />配置实例引用</label>
				</div>
			</td>
			<td>
				<label>属性值：</label><input type="text" name="config_search_key" id="" class="textInput" />
			</td>	
			<td>
				<button type="submit" class="btn_search">查询</button>
				<button type="submit" class="btn_search_cancel">取消查询</button>
			</td>
		</tr>
	</table>
</div>

<div layouth="35">
	<div class="side_tree js_drag_width config_side_tree" layouth="36">
		<div class="config_tree_con" data-size="a">
			<a href="javascript:;" class="config_tree_btn">收起</a>
			<ul id="config_tree" class="ztree"></ul>
		</div>
		<div class="config_tree_con" data-size="a" style="border-top:solid 1px #ddd;">
			<a href="javascript:;" class="config_tree_btn">收起</a>
			<ul id="examples_tree" class="ztree"></ul>
		</div>
	</div>
	<div id="config_content" layouth="36">
		<h1>请点选左边树进行操作！</h1>
	
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
		key: {
			title:"t"
		},
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

var config_nodes=[
<?php echo ($config_nodes); ?>
	],
	examples_nodes=[
<?php echo ($examples_nodes); ?>		
	];


var config_tree,examples_tree,tree_which_search;

function resetSearchTree(treewhich,search_nodes) {
	if(treewhich == 'config_tree')
	{
		$.fn.zTree.init($("#config_tree"), setting, search_nodes);
		initUI($('#config_tree'));
	}else
	{
		$.fn.zTree.init($("#examples_tree"), setting, search_nodes);
		initUI($('#examples_tree'));
	}
	config_tree = $.fn.zTree.getZTreeObj("config_tree");
	examples_tree = $.fn.zTree.getZTreeObj("examples_tree");
	updateType();
	$('.config_side_tree a').attr('rel','config_content');
}

$(document).ready(function(){
	$.fn.zTree.init($("#config_tree"), setting, config_nodes);
	$.fn.zTree.init($("#examples_tree"), setting, examples_nodes);
	config_tree = $.fn.zTree.getZTreeObj("config_tree");
	examples_tree = $.fn.zTree.getZTreeObj("examples_tree");
	updateType();
	$('.config_side_tree a').attr('rel','config_content');
	config_tree.expandAll(false);
	examples_tree.expandAll(false);
	
	$('.head_search .btn_search').click(function(){
		var area=$(this).parents('.head_search'),
			which=$('input[name="config_search_which"]:checked',area).val(),
			key=$('input[name="config_search_key"]',area).val();
		if(which==1){
			var tree_earch='config_tree';
			tree_which_search = 'config_tree';
		}else{
			var tree_earch='examples_tree';
			tree_which_search = 'examples_tree';
		}
		$.post('/index.php/Service/Configure/getSearchInfo',{type:which,key:key},function(data){
			if(data)
			{
				var search_nodes=eval(data);
				resetSearchTree(tree_earch,search_nodes);
				if(key == '' || key == null)
				{
					if(which == 1)
					{
						config_tree.expandAll(false);	
					}else
					{
						examples_tree.expandAll(false);
					}
				}
			}
		})
//		$('.head_search .btn_search_cancel').show();
	});
	
	$('.config_tree_btn').click(function(){
		var con=$(this).parent('.config_tree_con'),
			con_other=con.siblings('.config_tree_con'),
			tree=$(this).siblings('.ztree');
		
		if($(this).hasClass('status_close')){
			$(this).removeClass('status_close').text('收起');
			$('.config_tree_name',con).remove();
			if(con_other.data('size')=='a'){
				con.data('size','a');
			}else if(con_other.data('size')=='b'){
				con.data('size','a');
				con_other.data('size','a');
			}else{
				con.data('size','b');
			}
		}else{
			$(this).addClass('status_close').text('展开');
			con.data('size','c');
			if(con_other.data('size')=='a'){
				con_other.data('size','b')
			}
			if(tree.attr('id')=='config_tree'){
				con.prepend('<div class="config_tree_name">配置项</div>');
			}else{
				con.prepend('<div class="config_tree_name">配置实例</div>');
			}
		}
		$(window).resize();
	});
	
	$(window).resize(function(){
		var h=$('.config_side_tree').height();
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
});

var config_tree_which,config_treeId_which;
function OnRightClick(event, treeId, treeNode) {
	config_treeId_which=treeId;
	//console.log(treeNode);
	if(treeId=='config_tree'){
		var tree_which=config_tree;
		config_tree_which=config_tree;
	}else{
		var tree_which=examples_tree;
		config_tree_which=examples_tree;
	}
	if (!treeNode && event.target.tagName.toLowerCase() != "button" && $(event.target).parents("a").length == 0) {
		tree_which.cancelSelectedNode();
		showRMenu("root", event.clientX, event.clientY,tree_which,treeId);
	} else if (treeNode && !treeNode.noR) {
		tree_which.selectNode(treeNode);
		showRMenu("node", event.clientX, event.clientY,tree_which,treeId,treeNode);
	}
}

function showRMenu(type, x, y,tree_which,treeId,treeNode){
	var menu='<ul class="context_menu" style="left:'+(x+2)+'px;top:'+(y+2)+'px;">';
	if(type=='root'){
		/* if(treeId=='config_tree'){
			menu+='<li class="m_add" data-type="a">增加节点</li>';
		} */
	}else{
		if(treeId=='config_tree'){
			if(treeNode.level==0){
				menu+='<li class="m_add" data-type="a">增加节点</li>';
			}else if(treeNode.level==1){
				menu+='<li class="m_add" data-type="b">增加节点</li><li class="m_edit" data-type="a">编辑节点</li><li class="m_del">删除节点</li>';
			}else{
				menu+='<li class="m_edit" data-type="b">编辑节点</li><li class="m_del">删除节点</li>';
			}
		}else{
			if(treeNode.level==0){
				menu+='<li class="m_add" data-type="d">增加节点</li>';
			}else if(treeNode.level==1){
				menu+='<li class="m_add" data-type="c">增加节点</li><li class="m_edit" data-type="d">编辑节点</li><li class="m_del">删除节点</li><li class="m_paste">粘贴节点</li>';
			}else{
				menu+='<li class="m_edit" data-type="c">编辑节点</li><li class="m_del">删除节点</li><li class="m_copy">复制节点</li><li class="m_openser">服务实例</li><li class="m_lookvers">查看历史版本</li>';
			}
		}
	}
	menu+='</ul>';
	menu=$(menu);
	
	//2016-03-22修正鼠标右键菜单在窗口下方被隐藏的bug;
	var win_height = $(window).height();
	
	$('body').append(menu);
	var menu_height = $(".context_menu").height();
	var valid_height = parseInt(win_height - y);
	if(menu_height > valid_height){
		var ls_top = y - menu_height;
		$(".context_menu").css('top',ls_top);
	}
	
	$('body').bind("mousedown", onBodyMouseDown);
	menu.contextmenu(function(e){
		return false;
	});
	
	//$('.m_add',menu).click(function(){addTreeNode(tree_which)});
	//$('.m_edit',menu).click(function(){editTreeNode(tree_which)});
	
	$('.m_add',menu).click(function(){
		var type=$(this).data('type');
		var nodes = config_tree_which.getSelectedNodes();
		hideRMenu();
		if(type=='a'){
			$.pdialog.open('/index.php/Service/Configure/add_a?id='+nodes[0].id,'tree_edit_win','公共属性分类',{'width':'600','height':'500','mask':true});
		}else if(type=='b'){
			$.pdialog.open('/index.php/Service/Configure/add_b?id='+nodes[0].id,'tree_edit_win','详细配置',{'width':'600','height':'500','mask':true});
		}else if(type=='c'){
			$.pdialog.open('/index.php/Service/Configure/add_c?id='+nodes[0].id,'tree_edit_win','添加',{'width':'800','height':'600','mask':true});
		}else if(type=='d'){
			$.pdialog.open('/index.php/Service/Configure/add_d','tree_edit_win','添加组合实例',{'width':'410','height':'253','mask':true});
		}
	});
	$('.m_edit',menu).click(function(){
		var type=$(this).data('type');
		var nodes = config_tree_which.getSelectedNodes();
		hideRMenu();
		var node_name=treeNode.name.replace(/ \(.*\)/gi, "");
		if(type=='a'){
			$.pdialog.open('/index.php/Service/Configure/edit_a?id='+nodes[0].id,'tree_edit_win',node_name+' 编辑',{'width':'600','height':'500','mask':true});
		}else if(type=='b'){
			$.pdialog.open('/index.php/Service/Configure/edit_b?id='+nodes[0].id,'tree_edit_win',node_name+' 编辑',{'width':'600','height':'500','mask':true});
		}else if(type=='c'){
			$.pdialog.open('/index.php/Service/Configure/edit_c?id='+nodes[0].id,'tree_edit_win',node_name+' 编辑',{'width':'800','height':'600','mask':true});
		}else if(type=='d'){
			$.pdialog.open('/index.php/Service/Configure/edit_d?id='+nodes[0].id,'tree_edit_win',node_name+' 编辑',{'width':'410','height':'253','mask':true});
		}
	});
	$('.m_openser',menu).click(function(){
		hideRMenu();
		var nodes = config_tree_which.getSelectedNodes();
		var node_name=treeNode.name.replace(/ \(.*\)/gi, "");
		navTab.openTab('D60699','/index.php/Service/ConfserRelation?id='+nodes[0].id,{title: '使用配置服务',fresh: true,external: false});
	});
	$('.m_lookvers',menu).click(function(){
		hideRMenu();
		var nodes = config_tree_which.getSelectedNodes();
		var node_name=treeNode.name.replace(/ \(.*\)/gi, "");
		//navTab.openTab('D9001','/index.php/Service/Lookhisversion?id='+nodes[0].baseId,{title: '查看历史版本',fresh: true,external: false});
		var $rel = $("#config_content");
        $rel.loadUrl('/index.php/Service/Configure/detail?type=d&id='+nodes[0].baseId, {},
        function() {
            $rel.find("[layoutH]").layoutH();
        });
	});
	$('.m_del',menu).click(function(){
		hideRMenu();
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
	
	$('.m_copy',menu).click(function(){copyTreeNode(tree_which)});
	$('.m_paste',menu).click(function(){pasteTreeNode(tree_which)});
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

function addTreeNode(tree_which,name,id,remark) {
	hideRMenu();
	name=name||'新增';
	var newNode = {"name":name,"target":"ajax","id":id,"baseId":id};
	if (tree_which.getSelectedNodes()[0]) {
		if(config_treeId_which=='config_tree'){
			if(tree_which.getSelectedNodes()[0].level==0){
				newNode.target='';
			}else if(tree_which.getSelectedNodes()[0].level==1){
				newNode.url='/index.php/Service/Configure/detail?type=a&id='+id;
				if(remark !=null) newNode.t=remark;
			}
		}else{
			if(tree_which.getSelectedNodes()[0].level==0){
				newNode.url='/index.php/Service/Configure/detail?type=b&id='+id;
			}else if(tree_which.getSelectedNodes()[0].level==1){
				newNode.url='/index.php/Service/Configure/detail?type=c&id='+id;
				if(remark !=null) newNode.t=remark;
			}
		}
		newNode.checked = tree_which.getSelectedNodes()[0].checked;
		var new_node=tree_which.addNodes(tree_which.getSelectedNodes()[0], newNode);
	} else {
		var new_node=tree_which.addNodes(null, newNode);
	}
	initUI($('.config_side_tree'));
	$('.config_side_tree a').attr('rel','config_content');
	updateType();
}

function renameTreeNode(name,remark){
	var nodes = config_tree_which.getSelectedNodes(),
		treeNode = nodes[0];
	treeNode.name=name;
	var linktime = new Date().getTime();
	if(config_treeId_which == "config_tree" && treeNode.level == 1)
	{
		treeNode.url='';
	}else
	{
		treeNode.url=treeNode.url+'&linktime='+linktime;
	}
	if(remark !=null) treeNode.t=remark;
	config_tree_which.updateNode(treeNode);
	changeparentnums(config_tree_which.getNodes(),config_tree_which);
}

function renameTreeNodeAndID(name,id){
	var nodes = config_tree_which.getSelectedNodes(),
		treeNode = nodes[0];
	treeNode.name=name;
	treeNode.id=id;
	treeNode.url='/index.php/Service/Configure/detail?type=c&id='+id;
	config_tree_which.updateNode(treeNode);
	changeparentnums(config_tree_which.getNodes(),config_tree_which);
}

function removeTreeNode(tree_which) {
	var nodes = tree_which.getSelectedNodes();
	if (nodes && nodes.length>0) {
		
		if (nodes[0].children && nodes[0].children.length > 0) {
			var msg = "要删除的节点是父节点，如果删除将连同子节点一起删掉。\n\n请确认！";
			alertMsg.confirm(msg,{okCall:function(){
				$.post('/index.php/Service/Configure/delete',{treeid:config_treeId_which,type:"itemKind",id: nodes[0].id},function(data){
					if(data.statusCode=="200") {
						tree_which.removeNode(nodes[0]);
						alertMsg.correct("操作成功!");
						updateType();
					}else{
						alertMsg.error("由于"+data.message+",删除失败!")
					}
				}, "json");
				}
			})
		} else {
			if(nodes[0].level == 1){
				$.post('/index.php/Service/Configure/delete',{treeid:config_treeId_which,type:"itemKind",id: nodes[0].id},function(data){
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
						alertMsg.error("由于"+data.message+"删除失败!")
					}
				}, "json");
			}else{
				$.post('/index.php/Service/Configure/delete',{treeid:config_treeId_which,type:"item",id: nodes[0].id},function(data){
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
							alertMsg.error("由于"+data.message+"删除失败!")
						}
				}, "json");
			}
		}
	}
}

function fontCss(treeNode) {
	var aObj = $("#" + treeNode.tId + "_a");
	aObj.removeClass("copy").removeClass("cut");
	if (treeNode === curSrcNode) {
		if (curType == "copy") {
			aObj.addClass(curType);
		} else {
			aObj.addClass(curType);
		}			
	}
}

var curSrcNode, curType;
function setCurSrcNode(tree_which,treeNode) {
	if (curSrcNode) {
		delete curSrcNode.isCur;
		var tmpNode = curSrcNode;
		curSrcNode = null;
		fontCss(tmpNode);
	}
	curSrcNode = treeNode;
	if (!treeNode) return;

	curSrcNode.isCur = true;			
	tree_which.cancelSelectedNode();
	fontCss(curSrcNode);
}
var parentIDme;
function copyTreeNode(tree_which) {
	nodes = tree_which.getSelectedNodes();
	if (nodes.length == 0) {
		alertMsg.error("请先选择一个节点");
		return;
	}
	var parentNodeme = nodes[0].getParentNode();
	parentIDme = parentNodeme.id;
	curType = "copy";
	setCurSrcNode(tree_which,nodes[0]);
	hideRMenu();
}

function pasteTreeNode(tree_which) {
	if (!curSrcNode) {
		alertMsg.error("请先选择一个节点进行复制 ");
		return;
	}
	var nodes = tree_which.getSelectedNodes(),
	targetNode = nodes.length>0? nodes[0]:null;
	if (curSrcNode === targetNode) {
		alertMsg.error("不能移动，源节点 与 目标节点相同");
		return;
	} else if (curType === "cut" && ((!!targetNode && curSrcNode.parentTId === targetNode.tId) || (!targetNode && !curSrcNode.parentTId))) {
		alertMsg.error("不能移动，源节点 已经存在于 目标节点中");
		return;
	} else if (curType === "copy") {
		var data = {fromKindId:parentIDme,fromInstanceId:curSrcNode.id,toKindId:nodes[0].id};
		var tempNodeName = '';
		var tempNodeid = 0;
		$.ajax({
			   type: "POST",
			   url: "/index.php/Service/Configure/copyInstance",
			   async:false,
			   dataType:'json',
			   data: data,
			   success: function(data){
				   if(data['statusCode'] == '200')
					{
						/* curSrcNode.id = data['id'];
						curSrcNode.name = curSrcNode.name+'_copy';
						curSrcNode.url='/index.php/Service/Configure/detail?type=c&id='+data['id']; */
						tempNodeid = data['id'];
						tempNodeName = curSrcNode.name+'_copy';
						//tempurl='/index.php/Service/Configure/detail?type=c&id='+data['id'];
						targetNode = tree_which.copyNode(targetNode, curSrcNode, "inner");
					}else
					{
						alertMsg.error('由于'+data['message']+'粘贴失败');
						return ;
					}
			   }
			});
	} else if (curType === "cut") {
		targetNode = tree_which.moveNode(targetNode, curSrcNode, "inner");
		if (!targetNode) {
			alertMsg.error("剪切失败，源节点是目标节点的父节点");
		}
		targetNode = curSrcNode;
	}
	setCurSrcNode(tree_which);
	delete targetNode.isCur;
	tree_which.selectNode(targetNode);
	if(tempNodeid > 0)
		renameTreeNodeAndID(tempNodeName,tempNodeid);
	hideRMenu();
	initUI($('.config_side_tree'));
	$('.config_side_tree a').attr('rel','config_content');
	updateType();
}

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
function updateType() {
	changeparentnums(config_tree.getNodes(),config_tree);
	changeparentnums(examples_tree.getNodes(),examples_tree);
}

</script>