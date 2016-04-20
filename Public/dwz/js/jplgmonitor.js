//新增节点；
function xgdCreateNode() {
	if (!scene || !JPStore) return false;

	var texts = String(new Date().getTime());
	var nodeText = 'Node' + texts;

	var nodeObj = new JTopo.Node(nodeText);
	nodeObj.fillColor = nodeColor;

	if (newX > 200) {
		newX = 30;
	}

	nodeObj.setLocation(newX, newY);
	nodeObj.setSize(nodeWidth, nodeHeight);
	nodeObj.setImage(nodeImage);
	nodeObj.setDtype('default'); 		//设置设备类型；
	//添加唯一标识符；
	nodeObj.setXgdId(texts);
	nodeObj.setServiceName('');

	//初始化节点信息,存入本地;
	nodeObj.addEventListener('mouseup', function(event) {
		if (event.button == 0) {
			//左键处理函数；
		} else if (event.button == 2) {
			//右键处理函数；
			$("#nodeEditMenu").css({
				top: event.pageY,
				left: event.pageX
			}).fadeIn();
			if($(".lmenue").length > 0){
				$(".lmenue").remove();
			}
		}
	});

	//JPStore
	if (scene) {
		scene.add(nodeObj);
		beginNode = null;
		newX += 20;
	}
}


//新增子拓扑；
function xgdCreateChildTP() {
	if (!scene || !JPStore) return false;

	var texts = String(new Date().getTime());
	var nodeText = 'Container_' + texts;

	var nodeObj = new JTopo.Node(nodeText);
	nodeObj.fillColor = nodeChild.nodeColor;
	
	if (newX > 200) {
		newX = 30;
	}

	nodeObj.setLocation(newX, newY);
	nodeObj.setSize(nodeChild.nodeWidth, nodeChild.nodeHeight);
	nodeObj.setImage(nodeChild.nodeChildImage);
	//添加唯一标识符；
	nodeObj.setXgdId(texts);
	nodeObj.setDtype('childtp'); 		//设置设备类型；
	//初始化节点信息,存入本地;
	nodeObj.addEventListener('mouseup', function(event) {
		if (event.button == 0) {
			//左键处理函数；

		} else if (event.button == 2) {
			//右键处理函数；
			$("#childTPEditMenu").css({
				top: event.pageY,
				left: event.pageX
			}).fadeIn();
			if($(".lmenue").length > 0){
				$(".lmenue").remove();
			}
		}
	});
	//JPStore
	if (scene) {
		scene.add(nodeObj);
		beginNode = null;
		newX += 20;
	}
}

//重绘节点；
//只有编辑和预览,监控状态才使用此函数；
//function displayNodes(text, x, y, width, height, image, xgdid,dtype,ptype) {
function displayNodes(Node) {
	if (!scene || !JPStore) return false;
	var nodeObj = new JTopo.Node(Node.text);
	nodeObj.setLocation(Node.px, Node.py);
	nodeObj.setSize(Node.width, Node.height);
	var background = Node.dtype == 'childtp' ? "childtp.png" : "default.png";
	nodeObj.setImage("/Public/Images/jtopolg/"+background);
	//服务名称（唯一标识）；
	nodeObj.setXgdId(Node.xgdid);
	//普通节点或拓扑子图；
	nodeObj.setDtype(Node.dtype);
	//设置服务名称；
	nodeObj.setServiceName(Node.sname);
	nodeObj.setTpId(Node.tpid);
	//判断当前操作状态： 编辑，新建，预览拓扑图；
	//只有预览状态下，值才为真；
	var dialog = $.pdialog.getCurrent();
	//获取状态符号；
	//预览、监控状态不可拖拽；
	var currentAct = dialog.find('.currentActionName').val();
	if(currentAct == 'monitor'){
		nodeObj.dragable = false;
	}
	//编辑状态弹出右键；
	if(currentAct=='edit'){
		nodeObj.addEventListener('mouseup', function(event) {
			if (event.button == 0) {
				//左键处理函数,拖拽，覆盖原有值
			} else if (event.button == 2) {
				//编辑子拓扑；
				if(Node.dtype == 'childtp'){
					//右键处理函数；
					$("#childTPEditMenu").css({
						top: event.pageY,
						left: event.pageX
					}).fadeIn();
				}else{
					//右键处理函数；
					$("#nodeEditMenu").css({
						top: event.pageY,
						left: event.pageX
					}).fadeIn();
				}
			}
		})
	}
	//预览、监控状态下弹出左键菜单；
	if (currentAct == 'monitor') {
		nodeObj.addEventListener('mouseover', function(e) {
			if($(".lmenue").length > 0){
				$(".lmenue").remove();
			}
			if(Node.dtype == 'childtp'){
				var tpStr = JPStore.getItem('tplgMonitorInfoStr');
				if(!checkEmpty(tpStr)){
					var tpMonitorObj = JSON.parse(tpStr);
					var j;
					for(j=0; j<tpMonitorObj.length; j++){
						if(tpMonitorObj[j].topoId == Node.tpid ){
							var lmenu = '<div class="lmenue"  mouseleave="hideLeftMenue(this)" >';
							lmenu += '<ul>';
							lmenu += '<li class="jp_edit" align="left"><a href="javascript:void(0)" class="nodeinfo" onclick="redirectTP(' + Node.tpid + ')">查看详细>></a></li>';
							lmenu += '<li class="jp_del"><p>节点名称：<span class="ntype">' + tpMonitorObj[j].topoName + '</span></p></li>';
							lmenu += '<li class="jp_del"><p>节点个数：<span class="ntype">' + tpMonitorObj[j].nodes + '</span></p></li>';
							lmenu += '<li class="jp_del"><p>节点类型：<span class="ngroup">拓扑容器</span></p></li>';
							lmenu += '</ul>';
							lmenu += '</div>';
							break;
						}
					}
				}
			}else{
				var NdStr = JPStore.getItem('ndlgMonitorInfoStr');
				if(!checkEmpty(NdStr)){
					var ndMonitorObj = JSON.parse(NdStr);
					var j;
					for(j=0; j<ndMonitorObj.length; j++){
						if(ndMonitorObj[j].service == Node.sname ){
							var lmenu = '<div class="lmenue"  mouseleave="hideLeftMenue(this)" >';
							lmenu += '<ul>';
							lmenu += '<li class="jp_edit" align="left"><a href="javascript:void(0)" class="nodeinfo" onclick="showNodeInfo(\'' + Node.sname + '\')">查看详细>></a></li>';
							lmenu += '<li class="jp_del"><p>节点类型：<span class="ngroup">' + '已监控节点' + '</span></p></li>';
							lmenu += '<li class="jp_del"><p>产品名称：<span class="dtype">' + ndMonitorObj[j].prName + '</span></p></li>';
							lmenu += '<li class="jp_del"><p>服务名称：<span class="hname">' + ndMonitorObj[j].service + '</span></p></li>';
							lmenu += '<li class="jp_del"><p>服务描述：<span class="hdes">' + ndMonitorObj[j].servFunc + '</span></p></li>';
							lmenu += '<li class="jp_del"><p>告警数：<span class="hip">' + ndMonitorObj[j].warns + '</span></p></li>';
							lmenu += '</ul>';
							lmenu += '</div>';
							break;
						}
					}
				}
			}
			if(typeof(lmenu) == 'string' && lmenu.length > 0){
				$("#toolContent").after(lmenu);
				$(".lmenue").css({
					top: e.pageY,
					left: e.pageX
				}).show();
			}
			//****************************************************
			//****************************************************
			//****************************************************
			//$.ajaxSettings.global = false;
		});
		
		nodeObj.addEventListener('mouseout', function(e) {
			$(".lmenue").remove();
		});
	}
	if (scene) {
		scene.add(nodeObj);
	}
}

function redirectTP(targetid){
	var dialog = $("body").data("monitorTP");
	$.pdialog._current = dialog;
	$.pdialog.reload("/index.php/Service/Graphlogic/monitor?id="+targetid);
}

function dialogReload(url,dialogId)
{
	var dialog = $("body").data(dialogId);
	$.pdialog._current = dialog;
	$.pdialog.reload(url);
}

/*function displayLink(beginNode, endNode, width, radius, color, dcid) {
	var lk = new JTopo.Link(beginNode, endNode);
	lk.lineWidth = width; //宽度
	//lk.bundleGap 		= 	lk_bundleGap;
	//lk.textOffsetY 		= 	lk_textOffsetY ;
	lk.arrowsRadius = lk_arrowsRadius; //箭头弧度；
	lk.strokeColor = lk_strokeColor; //连线颜色；

	lk.dcid = dcid;
	//添加连接右键菜单；
	lk.addEventListener('mouseup', function(event) {
		//右键处理函数；
		if (event.button == 2) {
			$("#linkmenu").css({
				top: event.pageY,
				left: event.pageX
			}).show();
		}
	})
	scene.add(lk);
}*/

/*function displayLinks(link_obj) {
	var lk = new JTopo.Link(beginNode, endNode);
	lk.lineWidth = width; //宽度
	//lk.bundleGap 		= 	lk_bundleGap;
	//lk.textOffsetY 		= 	lk_textOffsetY ;
	lk.arrowsRadius = lk_arrowsRadius; //箭头弧度；
	lk.strokeColor = lk_strokeColor; //连线颜色；

	lk.dcid = dcid;
	//添加连接右键菜单；
	lk.addEventListener('mouseup', function(event) {
		//右键处理函数；
		if (event.button == 2) {
			$("#linkmenu").css({
				top: event.pageY,
				left: event.pageX
			}).show();
		}
	})
	scene.add(lk);
}*/



//清除界面；
function xgdClearScene() {
	if (scene) {
		scene.clear();
	}

	nodeSet = [];
	linkSet = [];
	$.ajaxSettings.global = false;
	$.ajax({
		type: 'POST',
		cache: false,
		url: '/index.php/Service/Graphlogic/clear',
		data: {
			'act': 'clear',
		},
		dataType: 'json',
		success: function(data) {
			alertMsg.correct('数据已清空！');
		}
	})
}

function deleteNodeData(sNode) {
	for (q = 0; q < nodeSet.length; q++) {
		if (nodeSet[q].text == sNode[0].text) {
			nodeSet.splice(q, 1);
			break;
		}
	}
}

function deleteLinkData(sLink) {
	for (p = 0; p < linkSet.length; p++) {
		if (linkSet[p].dcid == sLink[0].dcid) {
			linkSet.splice(p, 1);
			break;
		}
	}
}


//删除节点；
function deleteNode() {
	if (!scene) return false;

	var sNode = scene.selectedElements;
	var text = sNode[0].text;
	var xgdIdObj = sNode[0].getXgdId();
	var xgdId = xgdIdObj.xgdid;
	if (sNode[0] instanceof JTopo.Node) {
		
		$.post('/index.php/Service/Graphlogic/delNodeFromHash',{'service':xgdId},function(res){
			var data = eval("(" + res + ")");
			if(data.statusCode == 1){
					var nodeLink = sNode[0].inLinks;
					deleteNodeData(sNode);
					scene.remove(sNode[0]);
					JPStore.removeItem(text);
					alertMsg.correct(data.message);
			}
		})
	} else {
		createTextNode('请先选择节点，然后点击删除！');
	}
}

//删除节点；
function deleteChildTP() {
	if (!scene) return false;
	var sNode = scene.selectedElements;
	var text = sNode[0].text;
	if (sNode[0] instanceof JTopo.Node) {
		deleteNodeData(sNode);
		scene.remove(sNode[0]);
		JPStore.removeItem(text);
	} else {
		createTextNode('请先选择节点，然后点击删除！');
	}
}

//删除连线；
function deleteLink() {
	if (!scene) return false;
	var lkNode = scene.selectedElements;
	if (lkNode[0] instanceof JTopo.Link) {
		scene.remove(lkNode[0]);
	} else {
		createTextNode('请先选择连线，然后点击删除！');
	}
}

//编辑连线；
function editLink(){
	if (!scene) return false;
	var lkNode = scene.selectedElements;
	if (!(lkNode[0] instanceof JTopo.Link)) {
		alertMsg.error("请选择需要编辑的线段~！");
		return false;
	}
	
	if(dgoption != null && dgoption != undefined && dgoption != ''){
		var linkWinOption = dgoption;
		linkWinOption.width = 500;
		linkWinOption.height = 400;
		linkWinOption.max = false;
		linkWinOption.mask = true;
		$.pdialog.open('/index.php/Service/Graphlogic/setLink','GiveLinkConfigure','设置连线',linkWinOption);
	}
}

//创建提示；
function createTextNode(text) {
	if (!scene) return false;
	var msgNode = new JTopo.TextNode(text);
	msgNode.zIndex++;
	msgNode.setBound(msgX, msgY);
	msgNode.fontColor = msgColor;
	msgNode.font = msgFont;
	scene.add(msgNode);
	setTimeout(deleteTextNode(msgNode), 2000);
}

function deleteTextNode(textnode) {
	if (!scene) return false;
	return function() {
		scene.remove(textnode);
	}
}


function xgdLocalSave() {
	if (!scene) return false;
	var jtElements = scene.getDisplayedElements();
	var tmp = 0;
	var jpNodes = [];
	var jpLinks = [];
	var jpchildTps = [];
	//2016-03-24新增serviceInfo,topoInfo字段；
	var serviceInfo = []; 
	var topoInfo = [];
	for (tmp = 0; tmp < jtElements.length; tmp++) {
		//节点；
		if (jtElements[tmp].elementType == 'node') {
			var node_id_obj = jtElements[tmp].getXgdId();
			var node_id = node_id_obj.xgdid;
			
			var nodeTypeObj = jtElements[tmp].getDtype();
			var nodeType = nodeTypeObj.dtype;
			//写入子拓扑数据；
			if(nodeType == 'childtp' && node_id.indexOf('_') > 0){
				var childTpArr = node_id.split("_");
				if(!checkEmpty(childTpArr[0]) ){
					if(childTpArr[0] > 0){
						jpchildTps.push(childTpArr[0]);
						var topoStr = childTpArr[0] + ',' + jtElements[tmp].text;
						topoInfo.push(topoStr);
					}
				}
			}
			
			var sProObj = jtElements[tmp].getProName();
			var proType = sProObj.proName;
			
			//2016-03-21 设置ServiceName,tpid
			var sNameObj = jtElements[tmp].getServiceName();
			var sName = sNameObj.serviceName;
			
			var tpIdObj = jtElements[tmp].getTpId();
			var tpid = tpIdObj.tpid;
			
			if(nodeType != 'childtp' && !checkEmpty(sName)){
				serviceInfo.push(sName);
			}
			
			var nodeSet = {
				'xgdid': node_id,
				'text': jtElements[tmp].text,
				'px': jtElements[tmp].x,
				'py': jtElements[tmp].y,
				'width': jtElements[tmp].width,
				'height': jtElements[tmp].height,
				'alpha': jtElements[tmp].alpha,
				'borderRadius': jtElements[tmp].borderRadius,
				'fillColor': jtElements[tmp].fillColor,
				'fontColor': jtElements[tmp].fontColor,
				'scaleX': jtElements[tmp].scaleX,
				'scaleY': jtElements[tmp].scaleY,
				'selected': jtElements[tmp].selected,
				'shadow': jtElements[tmp].shadow,
				'visible': jtElements[tmp].visible,
				'zIndex': jtElements[tmp].zIndex,
				'dtype': nodeType,
				'proName':proType,
				'sname':sName,
				'tpid':tpid
			};
			jpNodes.push(nodeSet);
		}
		//连线；
		if (jtElements[tmp].elementType == 'link') {
			//console.log(jtElements[tmp]);
			var nodeFrom = jtElements[tmp].nodeA;
			var nodeFromText = nodeFrom.text;
			var nodeFromIdObj = nodeFrom.getXgdId();
			var nodeFromId = nodeFromIdObj.xgdid;
			var nodeTo = jtElements[tmp].nodeZ;
			var nodeToText = nodeTo.text;
			var nodeToIdObj = nodeTo.getXgdId();
			var nodeToId = nodeToIdObj.xgdid;
			var linkSet = {
				'text': jtElements[tmp].text,	//文本；
				'fromText': nodeFromText,
				'toText': nodeToText,
				'fromId': nodeFromId,
				'toId': nodeToId,
				'width': jtElements[tmp].width,
				'height': jtElements[tmp].height,
				'alpha': jtElements[tmp].alpha,
				'arrowsRadius': jtElements[tmp].arrowsRadius,
				'bundleGap': jtElements[tmp].bundleGap,
				'dcid': jtElements[tmp].dcid,
				'dragable': jtElements[tmp].dragable,
				'fillColor': jtElements[tmp].fillColor,
				'font': jtElements[tmp].font,
				'fontColor': jtElements[tmp].fontColor,
				'lineJoin': jtElements[tmp].lineJoin,
				'lineWidth': jtElements[tmp].lineWidth,
				'shadow': jtElements[tmp].shadow,
				'dtype':'linking',
				'strokeColor': jtElements[tmp].strokeColor, //线体颜色；
				/**
				 * 新增连线配置；2016-03-07
				 */
				'linkSetInfo':jtElements[tmp].linkSetInfo
			}
			//console.log(linkSet);
			jpLinks.push(linkSet);
		}
	}
	var nodeSetStr = JSON.stringify(jpNodes);
	var linkSetStr = JSON.stringify(jpLinks);
	var childTpStr = jpchildTps.join(',');
	
	JPStore.setItem('nodeSaveItem', nodeSetStr);
	JPStore.setItem('linkSaveItem', linkSetStr);
	JPStore.setItem('childTpSaveItem', childTpStr);
	
	//2016-03-24 新增serviceInfo字段；
	if(serviceInfo.length > 0){
		var serviceInfoStr = serviceInfo.join(",");
		JPStore.setItem('serviceInfoStr', serviceInfoStr);
	}
	//2016-03-24 新增topoInfo字段；
	if(topoInfo.length > 0){
		var topoInfoStr = topoInfo.join(";");
		JPStore.setItem('topoInfoStr', topoInfoStr);
	}
}

//Ajax提交；
function submitTP() {
	xgdLocalSave();
	$.pdialog.open("/index.php/Service/Graphlogic/graphSave", 'graphsave', '保存拓扑', {
		'width': 500,
		'height': 300,
		'mask': true
	});
}

function findNodeByText(text) {
	var displayNodes = scene.getDisplayedNodes();
	var p;
	for (p = 0; p < displayNodes.length; p++) {
		if (displayNodes[p].elementType == 'node' && displayNodes[p].text == text) {
			return displayNodes[p];
		}
	}
}

function findNodeById(nid) {
	var displayNodes = scene.getDisplayedNodes();
	var p;
	for (p = 0; p < displayNodes.length; p++) {
		var xgdidobj = displayNodes[p].getXgdId();
		var xgdid = xgdidobj.xgdid;
		if (displayNodes[p].elementType == 'node' && xgdid == nid) {
			return displayNodes[p];
		}
	}
}

/**
 * 2016-03-21
 * 增加数组结构，应对同一画布出现多个相同节点的情况；[逻辑图]
 * @param nid
 * @returns
 */
function findNodeArrByServiceName(name) {
	var displayNodes = scene.getDisplayedNodes();
	var p;
	var nodeArr = [];
	for (p = 0; p < displayNodes.length; p++) {
		var serverNameObj = displayNodes[p].getServiceName();
		var sName = serverNameObj.serviceName;
		if (displayNodes[p].elementType == 'node' && sName == name) {
			nodeArr.push(displayNodes[p]);
		}
	}
	return nodeArr;
}

/**
 * 2016-03-21
 * 增加数组结构，应对同一画布出现多个相同节点的情况；[拓扑图]
 * @param nid
 * @returns
 */
function findNodeArrByTpId(tpid) {
	var displayNodes = scene.getDisplayedNodes();
	var p;
	var nodeArr = [];
	for (p = 0; p < displayNodes.length; p++) {
		var tpIdObj = displayNodes[p].getTpId();
		var tp_id = tpIdObj.tpid;
		if (displayNodes[p].elementType == 'node' && tpid == tp_id) {
			nodeArr.push(displayNodes[p]);
		}
	}
	return nodeArr;
}

/*function xgdFlush() {


	if (!scene) return false;
	if (!JPStore) return false;

	xgdLocalSave();

	scene.clear();
	var nodeSaveInfo = JPStore.getItem('nodeSaveItem');
	var linkSaveInfo = JPStore.getItem('linkSaveItem');
	//console.log(nodeSaveInfo); 
	if (nodeSaveInfo) {
		var node_obj = JSON.parse(nodeSaveInfo);
		var tmp;
		for (tmp = 0; tmp < node_obj.length; tmp++) {
			displayNodes(node_obj[tmp].text, node_obj[tmp].px, node_obj[tmp].py, node_obj[tmp].width, node_obj[tmp].height, node_obj[tmp].image, node_obj[tmp].xgdid);

		}
	}

	if (linkSaveInfo) {
		var link_obj = JSON.parse(linkSaveInfo);
		var tmp;
		for (tmp = 0; tmp < link_obj.length; tmp++) {

			var fromText = link_obj[tmp].fromText;
			var fromNode = findNodeByText(fromText);

			var fromId = link_obj[tmp].fromId;
			var fromNode = findNodeById(fromId);
			var toId = link_obj[tmp].toId;
			var toNode = findNodeById(toId);
			displayLink(fromNode, toNode, link_obj[tmp].lineWidth, link_obj[tmp].arrowsRadius, link_obj[tmp].fillColor, link_obj[tmp].dcid);

		}
	}
	alertMsg.correct("刷新完毕!");
}*/


function xgdEditShow(obj) {
	scene.clear();
	var topoContent = obj;
	var nodes = topoContent.node;
	var links = topoContent.link;
	var i, j;
	for (i = 0; i < nodes.length; i++) {
		if(nodes[i].proName) {
			var image = jticons ? jticons[nodes[i].proName] : '';
		}else{
			var image = nodes[i].dtype == 'default' ?  'node2.png' : '';
		}
		//displayNodes(nodes[i].text, nodes[i].px, nodes[i].py, nodes[i].width, nodes[i].height,image, nodes[i].xgdid,nodes[i].dtype,nodes[i].proName,nodes[i].serviceName);
		displayNodes(nodes[i]);
	}
	for (j = 0; j < links.length; j++) {
		displayLinks(links[j]);
	}
}

function displayLinks(link_obj) {
	var fromId = link_obj.fromId;
	var fromNode = findNodeById(fromId);
	var toId = link_obj.toId;
	var toNode = findNodeById(toId);
	if(link_obj.linkSetInfo.ltype == 'fold'){
		 var lk = new JTopo.FoldLink(fromNode, toNode);
		 //如果是折线，需要设置拐角长度；
	 	 // lk.bundleOffset = link_obj.linkSetInfo.lbundleOffset;
    }else if(link_obj.linkSetInfo.ltype == 'curve'){
    	//曲线；
 	   var lk = new JTopo.CurveLink(fromNode, toNode);
    }else{
    	//直线；
 	   var lk = new JTopo.Link(fromNode, toNode);
    }
	
	lk.text				= link_obj.linkSetInfo.ltext;
	lk.lineWidth 		= link_obj.linkSetInfo.lwidth; 			//线体宽度
	//lk.bundleGap 		= link_obj.linkSetInfo.lbundlegap;		//线体间隔；
	//lk.textOffsetY 		= link_obj.linkSetInfo.loffset;			//文本偏移；
	lk.arrowsRadius 	= link_obj.linkSetInfo.larrowsize; 		//箭头大小；
	lk.strokeColor 		= link_obj.linkSetInfo.lcolor; 			//连线颜色；
	lk.dcid 			= link_obj.dcid;						//唯一标识；
	lk.linkSetInfo		= link_obj.linkSetInfo;					//获取连线配置；
	if(link_obj.linkSetInfo.lpattern == 'dashedPattern'){
		lk.dashedPattern = link_obj.linkSetInfo.lwidth; 		//虚实；
	}
	//添加连接右键菜单；
	lk.addEventListener('mouseup', function(event) {
		//右键处理函数；
		if (event.button == 2) {
			$("#linkmenu").css({
				top: event.pageY,
				left: event.pageX
			}).show();
		}
	})
	scene.add(lk);
}

function xgdMonitorShow(json) {
	scene.clear();
	var topoContent = obj;
	var nodes = topoContent.node;
	var links = topoContent.link;
	var i, j;
	for (i = 0; i < nodes.length; i++) {
		var dtype = nodes[i].dtype;
		var image = jticons[dtype];
		displayNodes(nodes[i].text, nodes[i].px, nodes[i].py, nodes[i].width, nodes[i].height, nodes[i].image, nodes[i].xgdid,dtype);
	}
	//console.log(nodes);
	//console.log(links);
	for (j = 0; j < links.length; j++) {

		var fromId = links[j].fromId;
		var fromNode = findNodeById(fromId);

		var toId = links[j].toId;
		var toNode = findNodeById(toId);

		displayLink(fromNode, toNode, links[j].lineWidth, links[j].arrowsRadius, links[j].fillColor, links[j].dcid);
	}

}

function runScreen() {
	runPrefixMethod(stage.canvas, "RequestFullScreen");
	/*$(document).keyup(function(e){
		if(e.keyCode == 27){
			$.pdialog.closeCurrent();
		}
	})*/

	$(document).bind('mousedown', function(e) {
		if (f_IsFullScreen) {
			exitFullscreen();
		}
	})
}

function runPrefixMethod(element, method) {
	var usablePrefixMethod;
	["webkit", "moz", "ms", "o", ""].forEach(function(prefix) {
		if (usablePrefixMethod) return;
		if (prefix === "") {
			// 无前缀，方法首字母小写
			method = method.slice(0, 1).toLowerCase() + method.slice(1);
		}
		var typePrefixMethod = typeof element[prefix + method];
		if (typePrefixMethod + "" !== "undefined") {
			if (typePrefixMethod === "function") {
				usablePrefixMethod = element[prefix + method]();
			} else {
				usablePrefixMethod = element[prefix + method];
			}
		}
	});

	return usablePrefixMethod;
};

//判断浏览器是否全屏 
function f_IsFullScreen() {
	return (document.body.scrollHeight == window.screen.height && document.body.scrollWidth == window.screen.width);
}


// 判断浏览器种类
function exitFullscreen() {
	if (document.exitFullscreen) {
		document.exitFullscreen();
	} else if (document.mozCancelFullScreen) {
		document.mozCancelFullScreen();
	} else if (document.webkitExitFullscreen) {
		document.webkitExitFullscreen();
	}
	
	/*if($(".lmenue").length && $(".lmenue").is(":visible")){
		$(".lmenue").hide();
	}*/
}

//新增子拓扑；
function xgdNewTP() {

}

function xgdDebug() {
	console.log(nodeSet);
	console.log(linkSet);
}

function xgdMoveCenter() {
	if (!stage) return false;
	var disNodes = scene.getDisplayedNodes();
	if (!disNodes.length) {
		alertMsg.error("屏幕没有节点，点击无效！");
		return false;
	}
	stage.centerAndZoom();
}

function xgdMoveStage(obj) {
	if (!stage) return false;
	if ($(obj).is(':checked')) {
		var modeState = $(obj).val();
		stage.mode = modeState;
	} else {
		stage.mode = stageMode;
	}
}

function editNode(panelid) {
	$.pdialog.open("/index.php/Service/Graphlogic/editNode", panelid, '编辑节点', {
		'width': 600,
		'height': 500,
		'mask': true
	});
}

function editChildTP(panelid) {
	$.pdialog.open("/index.php/Service/Graphlogic/editChildTP", panelid, '编辑子拓扑', {
		'width': 600,
		'height': 500,
		'mask': true
	});
}

function editChildNode(panelid) {
	$.pdialog.open("/index.php/Service/Graph/editChildTP", panelid, '编辑节点', {
		'width': 600,
		'height': 500,
		'mask': true
	});
}

function xgdfindValue() {
	var svId = $("#serviceid").val();
	$("#targetdevice").find("option").each(function() {
		if ($(this).val() == svId) {
			$(this).attr("selected", true);
			state = 1;
		}
	})
	if (state) $("#targetdevice").attr('disabled', true);
}


function setNodeInfo() {
	var targetInfo = $("#targetdevice").find("option:selected").text();
	var targetArr = targetInfo.split('-');
	var serviceip = targetArr[0];
	var servicename = targetArr[1];
	var serviceid = $("#targetdevice").val();
	$("#serviceid").val(serviceid);
	$("#servicename").val(servicename);
	$("#serviceip").val(serviceip);
}

function getServiceList() {
	var vals = $("#servicename").val();
	if (vals == '' || vals == undefined) {
		alertMsg.error('请输入主机名或IP');
		return false;
	}

	$.ajax({
		type: "POST",
		cache: false,
		dataType: 'json',
		data: {
			'host': vals
		},
		url: '/index.php/Service/GraphSearch/searchHost',
		success: function(da) {
			if (da.statusCode == 1) {
				$("#serviceid").val(da.id);
				$("#serviceip").val(da.ip);
				$("#servicename").val(da.hostName);
				$("#targetdevice").find("option").each(function() {
					if ($(this).val() == da.id) {
						$(this).attr("selected", true);
						state = 1;
					}
				})
				if (state) $("#targetdevice").attr('disabled', true);
				alertMsg.correct(da.message);
			} else {
				alertMsg.error(da.message);
			}
		}
	})
}

function saveStage() {
	var canvas = document.getElementById('canvas');
	var jsonStr = stage.toJson();
	//console.log(jsonStr);
}

function showNodeInfo(sName) {
	//var winWidth = $(window).width();
	//var winHeight = $(window).height();
	var winWidth = 700;
	var winHeight = 400;
	$(".lmenue").remove();
	var cindex = $($.pdialog._current).css("zIndex");
	$.pdialog.open('/index.php/Service/Graphlogic/lgServiceDetail/?sName=' + sName,"nodeWindow_"+sName,'节点详细信息',{width:winWidth,height:winHeight})
	var dialog = $.pdialog.getCurrent();
	dialog.css('zIndex',cindex);
}

function goBack(tpid) {
	var dialogId = 'monitorTP';
	var dialog = $("body").data(dialogId);
	$.pdialog._current = dialog;
	$.pdialog.reload('/index.php/Service/Graph/monitor?id=' + tpid);
}


function createWarn()
{
	var node = new JTopo.Node();
	node.setImage('./img/topo/'+ icon +'.png', true);
	node.fontColor = '0,0,0';
	node.setLocation(x, y);
	scene.add(node);

	node.mouseover(function(){
		this.text = text;
	});
	node.mouseout(function(){
		this.text = null;
	});
}

function monitorNodeInfo() {
	var displayNodes = scene.getDisplayedNodes();
	var p;
	var serviceNames = new Array();
	var tpIds = new Array();
	if (displayNodes.length) {
		for (p = 0; p < displayNodes.length; p++) {
			if (displayNodes[p].elementType == 'node') {
				var dTypeObj = displayNodes[p].getDtype();
				var dType = dTypeObj.dtype;
				if(dType == 'childtp'){
					var tpIdObj = displayNodes[p].getTpId();
					var tpId = tpIdObj.tpid;
					if(!checkEmpty(tpId)) tpIds.push(tpId);
				}else{
					var serviceNameObj = displayNodes[p].getServiceName();
					var serviceName = serviceNameObj.serviceName;
					if(!checkEmpty(serviceName)) serviceNames.push(serviceName);
				}
			}
		}
		if (tpIds.length > 0 || serviceNames.length > 0) {
			var serviceNameStr = serviceNames.length > 0 ? serviceNames.join(',') : '';
			var tpIdStr = tpIds.length > 0 ? tpIds.join(',') : '';
			$.ajax({
				global:false,
				type: "POST",
				dataType: 'json',
				cache: false,
				timeout: 2000,
				data: {
					'service': serviceNameStr,
					'topoIds' : tpIdStr
				},
				url: '/index.php/Service/Graphlogic/monitorNodeInfo',
				success: function(data) {
					if(data.statusCode == DWZ.statusCode.ok){
						var ndMonitorInfo = data.resinfo.serviceInfo;
						if(ndMonitorInfo != null && ndMonitorInfo != undefined && ndMonitorInfo != '' ){
							var i;
							var j;
							for(i=0; i<ndMonitorInfo.length; i++){
								var warnNodeArr = findNodeArrByServiceName(ndMonitorInfo[i].service);
								for(j=0; j<warnNodeArr.length; j++){
									if(ndMonitorInfo[i].warns > 0){
											warnNodeArr[j].alarm = '' + ndMonitorInfo[i].warns;
											warnNodeArr[j].alarmColor = '255,0,0';
											warnNodeArr[j].alarmAlpha = 0.9;
									}else{
										warnNodeArr[j].alarm = null;
									}
									//更改设备图标；2016-03-18；
									var iconUrl = ndMonitorInfo[i].proIcon;
									warnNodeArr[j].setImage('/Public/Images/jtopolg/'+iconUrl);
									//warnNodeArr[j].text = ndMonitorInfo[i].service;
								}
							}
							//数据存入本地缓存；2016-03-18；
							var ndMonitorInfoStr = JSON.stringify(ndMonitorInfo);
							JPStore.setItem('ndlgMonitorInfoStr',ndMonitorInfoStr);	//节点数据；
						}
						var tpMonitorInfo = data.resinfo.topoInfo;
						if(tpMonitorInfo != null && tpMonitorInfo != undefined && tpMonitorInfo != '' ){
							//检查拓扑图名称是否改变；2016-03-18;
							var m;
							for(m=0; m<tpMonitorInfo.length; m++){
								var TPNodes = findNodeArrByTpId(tpMonitorInfo[m].topoId);
								var n;
								for(n=0; n<TPNodes.length; n++){
									TPNodes[n].text = tpMonitorInfo[m].topoName;
								}
							}
							var tpMonitorInfoStr = JSON.stringify(tpMonitorInfo);
							JPStore.setItem('tplgMonitorInfoStr',tpMonitorInfoStr); //拓扑图数据；
						}
					}else{
						//alertMsg.error(data.message);
						console.group("ErrorMessage:")
						console.log("==================没有读取到数据====================");
						console.groupEnd();
					}
				},
				error: function(xhr, msg, eobj) {
					//alertMsg.error(msg);
					console.group("ErrorMessage:")
					console.log(msg);
					console.groupEnd();
				}
			})
		}
	}
}

function updateNodeInfo() {
	var displayNodes = scene.getDisplayedNodes();
	var p;
	var serviceNames = new Array();
	var tpIds = new Array();
	if (displayNodes.length) {
		for (p = 0; p < displayNodes.length; p++) {
			if (displayNodes[p].elementType == 'node') {
				var dTypeObj = displayNodes[p].getDtype();
				var dType = dTypeObj.dtype;
				if(dType == 'childtp'){
					var tpIdObj = displayNodes[p].getTpId();
					var tpId = tpIdObj.tpid;
					tpIds.push(tpId);
				}else{
					var serviceNameObj = displayNodes[p].getServiceName();
					var serviceName = serviceNameObj.serviceName;
					if(serviceName.length > 0) serviceNames.push(serviceName);
				}
			}
		}
		if (tpIds.length > 0 || serviceNames.length > 0) {
			var serviceNameStr = serviceNames.length > 0 ? serviceNames.join(',') : '';
			var tpIdStr = tpIds.length > 0 ? tpIds.join(',') : '';
			$.ajax({
				global:false,
				type: "POST",
				dataType: 'json',
				cache: false,
				timeout: 2000,
				data: {
					'service': serviceNameStr,
					'topoIds' : tpIdStr
				},
				url: '/index.php/Service/Graphlogic/monitorNodeInfo',
				success: function(data) {
					if(data.statusCode == DWZ.statusCode.ok){
						var ndMonitorInfo = data.resinfo.serviceInfo;
						if(ndMonitorInfo != null && ndMonitorInfo != undefined && ndMonitorInfo != '' ){
							var i;
							var j;
							for(i=0; i<ndMonitorInfo.length; i++){
								var warnNodeArr = findNodeArrByServiceName(ndMonitorInfo[i].service);
								for(j=0; j<warnNodeArr.length; j++){
									//更改设备图标；2016-03-18；
									var iconUrl = ndMonitorInfo[i].proIcon;
									warnNodeArr[j].setImage('/Public/Images/jtopolg/'+iconUrl);
									//warnNodeArr[j].text = ndMonitorInfo[i].service;
								}
							}
						}
						var tpMonitorInfo = data.resinfo.topoInfo;
						if(tpMonitorInfo != null && tpMonitorInfo != undefined && tpMonitorInfo != '' ){
							//检查拓扑图名称是否改变；2016-03-18;
							var m;
							for(m=0; m<tpMonitorInfo.length; m++){
								var TPNodes = findNodeArrByTpId(tpMonitorInfo[m].topoId);
								var n;
								for(n=0; n<TPNodes.length; n++){
									TPNodes[n].text = tpMonitorInfo[m].topoName;
								}
							}
						}
					}else{
						//alertMsg.error(data.message);
						console.group("ErrorMessage:")
						console.log("==================没有读取到数据====================");
						console.groupEnd();
					}
				},
				error: function(xhr, msg, eobj) {
					//alertMsg.error(msg);
					console.group("ErrorMessage:")
					console.log(msg);
					console.groupEnd();
					updateNodeInfo();
				}
			})
		}
	}
}

function hideLeftMenue(obj){
	$(obj).hide();
}

function setLink()
{
	var linkWinOption = dgoption;
	linkWinOption.width = 500;
	linkWinOption.height = 400;
	linkWinOption.max = false;
	$.pdialog.open('/index.php/Service/Graphlogic/setLink','linkConfig','设置连线信息',linkWinOption);
}

/**
 * 	窗口关闭后，默认的回调函数，默认留空；
 * 	20160307；
 */
function jpDefaultCallBack(){}

function setLinkType(ltype)
{
	if(!JPStore) alertMsg.error("您的浏览器版本不兼容此项功能~！");
	if(!ltype) alertMsg.error('出错~！点击传入参数有误！');
	var JPBTNlinkType={};
	JPBTNlinkType.ltype = ltype;
	var linkTypeConfigStr = JSON.stringify(JPBTNlinkType);
	JPStore.setItem('linkTypeConfig',linkTypeConfigStr);
}


/**
 * 2016-03-19
 * 获取画布所有节点文本值；
 */

function getDisplayNodesText() {
	if(!scene) alertMsg("Scene对象未查询到，不能操作！！");
	var displayNodes = scene.getDisplayedNodes();
	var p;
	var textArr = [];
	for (p = 0; p < displayNodes.length; p++) {
		if (displayNodes[p].elementType == 'node') {
			textArr.push(displayNodes[p].text);
		}
	}
	return textArr;
}

function checkEmpty(str){
	if(str == null || str ==undefined || str==''|| typeof(str) == 'undefined'){
		return true;
	}else{
		return false;
	}
}


function checkSceneData() {
	var valid = true;
	var displayNodes = scene.getDisplayedNodes();
	var p;
	for (p = 0; p < displayNodes.length; p++) {
		if (displayNodes[p].elementType == 'node') {
			var dtype_obj = displayNodes[p].getDtype();
			var dtype = dtype_obj.dtype;
			if(dtype == 'default'){
				var service_obj = displayNodes[p].getServiceName();
				var service = service_obj.serviceName;
				if(!checkEmpty(service)){
					valid = false;
				}
			}else{
				var tp_obj = displayNodes[p].getTpId();
				var tpid = tp_obj.tpid;
				if(!checkEmpty(tpid)){
					valid = false;
				}
			}
		}
	}
	return valid;
}