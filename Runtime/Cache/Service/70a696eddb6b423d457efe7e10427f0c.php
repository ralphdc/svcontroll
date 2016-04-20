<?php if (!defined('THINK_PATH')) exit();?><link href="/Public/dwz/themes/css/jtopo.css?v2.3" rel="stylesheet" type="text/css" />
<script src="/Public/dwz/js/jtopo-0.4.8-debug.js?v2.3" type="text/javascript"></script>
<script src="/Public/dwz/js/jpmonitor.js?v2.3" type="text/javascript"></script>
<div class="container_box" id="container_box">
		<div id="toolContent">
			<div class="panelBar" style="height:33px;">
				<ul class="toolBar">
					<li><a class="add" href="javascript:void(0)" title="新建拓扑图" onclick="xgdCreateNode()" ><span>新增节点</span></a></li>
					<li><a class="add" href="javascript:void(0)" title="新建拓扑图" onclick="xgdCreateChildTP()" ><span>新增子拓扑</span></a></li>
					<li><a  title="确实要删除选中记录吗？" href="javascript:void(0)" class="delete"><span onclick="xgdClearScene()">清空画布</span></a></li>
					<!--  <li><a  title="" href="javascript:void(0)" class="edit"><span onclick="xgdMoveCenter()">居中显示</span></a></li>  -->
					 <!--  <li><a  href="javascript:void(0)" class="reflash" onclick="xgdFlush()"><span>刷新</span></a></li>   -->
					<li><a  href="javascript:void(0)" class="fullscreen" onclick="runScreen()"><span>全屏</span></a></li>  
					<!-- <li><a class="save" href="javascript:void(0)" title="保存" onclick="submitTP()"><span>保存</span></a></li>  -->
					<li><a class="save" href="/index.php/Service/Graph/graphSave" title="保存" width="500" height="300" mask="true" rel="graphsave" target="dialog" onclick="xgdLocalSave()" ><span>保存</span></a></li>
					
					
					<li class="line">line</li>
					<li class="jtope_ul_li">
						<input type="radio" name="stageMode" value="drag"  onchange="xgdMoveStage(this)"  id="r3" />
						<label for="r3">平移图像</label>
					</li>
					<li class="jtope_ul_li">
						<input type="radio" name="stageMode" value="select" onchange="xgdMoveStage(this)"  id="r4" />
						<label for="r4">框选图像</label>
					</li>
					<li class="jtope_ul_li">
						<input type="radio" name="stageMode" value="normal" onchange="xgdMoveStage(this)"  checked="checked" id="r5" />
						<label for="r5">默认模式</label>
					</li>
				</ul>
			</div>
		</div>
		<div id="stageSc">
			<canvas width="1500" height="800" id="canvas"></canvas>	
		</div>
		<div class="rmenue"  id="nodeEditMenu">
			<ul>
				
				<li class="jp_edit">
				<!--  <a href="#" onclick="editNode('topoEditNode')">编辑节点</a>  -->
				<a height="500" width="600" target="dialog"  mask="true" title="编辑节点" rel="topoEditNode" href="/index.php/Service/Graph/editNode">编辑节点</a>
				</li>
				<li class="jp_del"><a href="#"  onclick="deleteNode();">删除节点</a></li>
			</ul>
		</div>
		<div class="rmenue"  id="childTPEditMenu">
			<ul>
				<li class="jp_edit">
				<!-- <a href="#" onclick="editChildTP('editChildTP')">  -->
				<a height="500" width="600" target="dialog"  mask="true" title="编辑子拓扑" rel="editChildTP" href="/index.php/Service/Graph/editChildTP">编辑子拓扑</a>
				</li>
				<li class="jp_del"><a href="#"  onclick="deleteChildTP();">删除子拓扑</a></li>
			</ul>
		</div>
		<div class="rmenue" id="linkmenu">
			<ul>
				<li><a href="#" onclick="deleteLink();">删除连线</a></li>
			</ul>
		</div>
</div>
<div id="leftMenue">
 	
</div>
<input type="hidden" class="currentActionName" value="edit" />
<input type="hidden" name="raltpname" id="raltpname"  value="<?php echo ($tpname); ?>" />
<input type="hidden" name="raltpid" id="raltpid"  value="<?php echo ($tpid); ?>" />

<script type="text/javascript">
var stage 		= 	null;
var scene 		= 	null;
var node		=	null;
var newX		=	100;
var newY		=	100;

//设置屏幕模式；
var stageModeDefault 		=   'normal';
var stageModeMove 			=   'drag';
var stageModeSelect 		=   'select';
var stageModeEdit			=   'edit';


//新建节点的宽、高；
var nodeWidth	=	60;
var nodeHeight	=	57;	
var nodeColor	=	'255，255，255';
var nodeImage	=	'/Public/Images/jtopo/node2.png';
var nodeType	=   'normal';


var nodeChild = {
		nodeWidth : 		107,
		nodeHeight:			67,
		nodeChildImage : 	'/Public/Images/jtopo/childtp.png',
		nodeColor : 		'255，255，255',
		nodeType : 			'childtp'
}



//提示文字的坐标；
var msgX		=	10;
var msgY		=	10;
//提示文字的颜色；
var msgColor	=	'251,242,9';
var msgFont		=	'14px bold';
//定义创建节点初始化坐标；
var beginNode		=	null;
var endNode			=	null;


//  设置背景图片；
var jpImages = {
	'normal'	:	'/Public/Images/jtopo/node2.png',
	'server'	:	'/Public/Images/jtopo/server.png',
	'firewall'	:	'/Public/Images/jtopo/firewall.png',
	'router'	:	'/Public/Images/jtopo/router.png',
	'transfer'	:	'/Public/Images/jtopo/transfer.png',
	'desktop'	:	'/Public/Images/jtopo/other.png',
	'web'		:	'/Public/Images/jtopo/other.png',
	'virtual'	:	'/Public/Images/jtopo/other.png',
	'balance'	:	'/Public/Images/jtopo/other.png',
	'other'		:	'/Public/Images/jtopo/other.png',
}

//var jticons = <?php echo ($dtype); ?>

var dvNames = {
	'server'	:'服务器',
	'router'	:'路由器',
	'transfer'	:'交换机',
	'firewall'	:'防火墙',
	'desktop'	:'桌面机',
	'web'		:'WEB站点',
	'virtual'	:'虚拟主机',
	'balance'	:'负载均衡',
	'other'		:'其他'
}
//创建连线参数；
lk_line_Width 		= 	3;
lk_bundleGap 		= 	20;
lk_textOffsetY 		= 	3;
lk_arrowsRadius 	= 	15;
lk_strokeColor		=	'255,255,0';


$("#stageSc").height(600);

//创建存储对象；
var JPStore = 	null;
//新建节点信息初始化；
if(window.localStorage){
	JPStore	=	window.localStorage;
}else{
	$("#container_box").prepend("<h1>您的浏览器不支持HTML5,请更换！</h1>");
}

//创建容器存储节点和连接；
var linkSet = [];
var nodeSet = [];
//创建临时节点，定义连线；
var tempNodeA		=	new JTopo.Node('TemA');
var tempNodeB		=	new JTopo.Node('TemB');

tempNodeA.setSize(nodeWidth,nodeHeight);
tempNodeB.setSize(nodeWidth,nodeHeight);


var link			=	new JTopo.Link(tempNodeA,tempNodeB);

var canvas = $("#canvas")[0];
stage = new JTopo.Stage(canvas);
stage.mode = stageModeDefault;
scene 	= new JTopo.Scene(stage);
scene.background='/Public/Images/jtopo/enterdesk.png';
	
scene.addEventListener("dbclick",function(e){
 	if(e.button == 2){
           scene.remove(link);
           return;
       }
       if(e.target != null && e.target instanceof JTopo.Node){
           if(beginNode == null){
               beginNode = e.target;
               scene.add(link);
               tempNodeA.setLocation(e.x, e.y);
               tempNodeB.setLocation(e.x, e.y);
           }else if(beginNode !== e.target){
               var endNode = e.target;
               var lk = new JTopo.Link(beginNode, endNode);
               lk.lineWidth 		= 	lk_line_Width; //宽度
			//lk.bundleGap 		= 	lk_bundleGap;
			//lk.textOffsetY 		= 	lk_textOffsetY ;
			lk.arrowsRadius 	= 	lk_arrowsRadius;	//箭头弧度；
			lk.strokeColor		=	lk_strokeColor;	//连线颜色；

			lk.dcid 				= new Date().getTime();
			//添加连接右键菜单；
			lk.addEventListener('mouseup',function(event){
				//右键处理函数；
				if(event.button == 2){
					$("#linkmenu").css({
					top: event.pageY,
					left: event.pageX
				}).show();
				}
			})
               scene.add(lk);
              // console.log(lk);
               //写入缓存；
               var lkinfo = {'dcid':lk.dcid,'beginNode':beginNode,'endNode':endNode,'lkwidth':lk.lineWidth,'lkscolor':lk.strokeColor,'lkRadius':lk.arrowsRadius}
               linkSet.push(lkinfo);

               //console.log(linkSet);
               //console.log(nodeSet);

               beginNode = null;
               endNode = null;
               scene.remove(link);
           }else{
               beginNode = null;
           }
       }else{
       	beginNode = null;
           scene.remove(link);
       }
})
	
  
scene.mousedown(function(e){
   if(e.target == null || e.target === beginNode || e.target === link){
       scene.remove(link);
   }

   if($("#nodeEditMenu").is(":visible")){
   	$("#nodeEditMenu").hide();
   }
   if($("#childTPEditMenu").is(":visible")){
	   	$("#childTPEditMenu").hide();
	}
   if($(".lmenue").is(":visible")){
      	$(".lmenue").hide();
      }
   if($("#linkmenu").is(":visible")){
   	$("#linkmenu").hide();
   }
   });

   scene.mousemove(function(e){
       tempNodeB.setLocation(e.x, e.y);
});
	 




/* 连线--右键菜单处理 */	
$("#linkmenu a").click(function(){
	
	$("#linkmenu").hide();

})

$("#nodeEditMenu a").click(function(){
	
	$("#nodeEditMenu").hide();

})

$("#childTPEditMenu a").click(function(){
	$("#childTPEditMenu").hide();
})

$(function(){
	if(JPStore){
		JPStore.clear();
	}
	var dialog = $.pdialog.getCurrent();
	dialog.find("a.close").click(function(){
		if(JPStore){
			JPStore.clear();
		}
	})
	//进制改变窗口大小；
	dialog.find("a.restore").hide();
	
	//新建窗口关闭时，清空Redis缓存数据；
	/* var closeA = $("#container_box").parent().prev("div").find("a.close");
	closeA.on('click',function(){
		var dt = new Date().getTime();
		$.post('/index.php/Service/Graph/clearRedis',{t:dt},function(data){console.log('Redis缓存已清空！');JPStore.clear();})
	}) */
	

	xgdEditShow(<?php echo ($topo); ?>);
	updateNodeInfo();
})

</script>