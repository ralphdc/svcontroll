<?php if (!defined('THINK_PATH')) exit();?><link href="/Public/dwz/themes/css/jtopo.css?V-2.2.1" rel="stylesheet" type="text/css" />
<script src="/Public/dwz/js/jtopo-0.4.8-debug.js?V-2.2.1" type="text/javascript"></script>
<script src="/Public/dwz/js/jplgmonitor.js?V-2.2.1" type="text/javascript"></script>
<div class="container_box" id="container_box">
	<div id="toolContent">
		<div class="panelBar" style="height:33px;">
			<ul class="toolBar">
				<li><a class="add" href="javascript:void(0)" title="新建拓扑图" onclick="xgdCreateNode()" ><span>新增节点</span></a></li>
				<li><a class="add" href="javascript:void(0)" title="新建拓扑图" onclick="xgdCreateChildTP()" ><span>新增子逻辑图</span></a></li>
				<li><a  title="确实要删除选中记录吗？" href="javascript:void(0)" class="delete"><span onclick="xgdClearScene()">清空画布</span></a></li>
				<!-- <li><a  title="" href="javascript:void(0)" class="edit"><span onclick="xgdMoveCenter()">居中显示</span></a></li>
				 <li><a  title="设置连线样式" href="javascript:void(0)" class="add"><span onclick="setLink()">设置连线</span></a></li> 
				 -->
				<li><a  href="javascript:void(0)" class="fullscreen" onclick="runScreen()"><span>全屏</span></a></li>  
				<!-- <li><a class="save" href="javascript:void(0)" title="保存" onclick="submitTP()"><span>保存</span></a></li> -->
				<li><a class="save" href="/index.php/Service/Graphlogic/graphSave" title="保存" width="500" height="300" mask="true" rel="graphsave" target="dialog" onclick="xgdLocalSave()"><span>保存</span></a></li>
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
				<li class="line">line</li>
				<li><a  title="设置连线样式" href="javascript:void(0)" class="edit lty"><span onclick="setLinkType('straight')">直线</span></a></li>
				<li><a  title="设置连线样式" href="javascript:void(0)" class="edit lty"><span onclick="setLinkType('fold')">折线</span></a></li>
				<li><a  title="设置连线样式" href="javascript:void(0)" class="edit lty"><span onclick="setLinkType('curve')">曲线</span></a></li>
			</ul>
		</div>
	</div>
	<div id="stageSc">
		<canvas width="1500" height="800" id="canvas"></canvas>	
	</div>
	<div class="rmenue"  id="nodeEditMenu">
		<ul>
			<li class="jp_edit">
				<!-- <a href="#" onclick="editNode('editGraphLGNode')">编辑节点</a>  -->
				<a href="/index.php/Service/Graphlogic/editNode" width="600" target="dialog" height="500" mask="true" rel="editGraphLGNode" onclick="editNode('editGraphLGNode')">编辑节点</a>
			</li>
			<li class="jp_del"><a href="#"  onclick="deleteNode();">删除节点</a></li>
		</ul>
	</div>
	
	<div class="rmenue"  id="childTPEditMenu">
		<ul>
			<li class="jp_edit">
			<!-- <a href="#" onclick="editChildTP('editChildTP')">编辑子逻辑图</a>  -->
			<a href="/index.php/Service/Graphlogic/editChildTP" width="600" target="dialog" height="500" mask="true" rel="editChildTP">编辑子逻辑图</a>
			</li>
			<li class="jp_del"><a href="#"  onclick="deleteChildTP();">删除子逻辑图</a></li>
		</ul>
	</div>
	<div class="rmenue" id="linkmenu">
		<ul>
			<li><a href="/index.php/Service/Graphlogic/setLink" rel="GiveLinkConfigure" target="dialog"  width="500" height="400" mask="true" max="false" title="设置连线"">编辑连线</a></li>
			<!-- <li><a href="#" onclick="editLink();">编辑连线</a></li>  -->
			<li><a href="#" onclick="deleteLink();">删除连线</a></li>
		</ul>
	</div>
</div>
<div id="leftMenue"></div>
<input type="hidden" class="currentActionName" value="add" />

<script type="text/javascript">

// 设置连线样式；
// 2016-03-07；
var JPlinkType={
		'ltype':'straight',
		'lwidth':3,
		'larrowsize':15,
		'lpattern':'default',
		'lbundlegap':10,
		'loffset':3,
		'lcolor':'255,255,0',
		'ltext':'',
		'lbundleOffset':10 // 折线拐角处的长度
}; 

/**
 * 打开窗口默认数据；
 */
var dgoption = {
		width:100, 				//dialog 打开时的默认宽度
		height:100,				// dialog 打开时默认的高度
		max:false,				//Max 属性表示此dialog打开时默认最大化
		mask:true,				//mask表示打开层后将背景遮盖
		maxable:false, 			//dialog 是否可最大化
		minable:false, 			//dialog 是否可最小化
		resizable:false,	 	//dialog 是否可变大小
		drawable:true,			//dialog 是否可拖动
		fresh:true,				//重复打开dialog时是否重新载入数据，默认值true,
		close:"jpDefaultCallBack", 		//关闭dialog时的监听函数，需要有boolean类型的返回值，
		param:"{msg:'message'}" //close监听函数的参数列表，以json格式表示，例{msg:’message’}
}

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
var nodeWidth		=	60;
var nodeHeight		=	57;	
var nodeColor		=	'255，255，255';
var nodeImage		=	'/Public/Images/jtopo/node2.png';
var nodeType		=   'normal';

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
var jticons = <?php echo ($dtype); ?>

$("#stageSc").height(600);
//创建存储对象；
var JPStore = 	null;
//新建节点信息初始化；
if(window.localStorage){
	JPStore	=	window.localStorage;
	if(JPStore) JPStore.clear();
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
//定义全局连接常量；
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
               //2016-03-10
               //连线设置再次改版；
               //获取对连线类型的定义（直线，折线，曲线三选一）；
               var temObj = {};
               var localLKTConfig = JPStore.getItem('linkTypeConfig');
               if(localLKTConfig != null && localLKTConfig.length > 0){
            	   var localLKTConfigObj = JSON.parse(localLKTConfig);
            	   var i,j;
            	   (function lkInherent(container,inits,sets){
            		    for(i in inits){
            		    	container[i] = inits[i];
            		   	}
            		    for(j in sets){
            		    	if(sets[j] != '' && sets[j] != undefined && sets[j] != null){
            		    		container[j] = sets[j];
             			   }
            		    }
            	   })(temObj,JPlinkType,localLKTConfigObj)
               }else{
            	   temObj = JPlinkType;
               }
               //折线；
               if(temObj.ltype == 'fold'){
            	   var lk = new JTopo.FoldLink(beginNode, endNode);
            	   lk.bundleOffset = temObj.lbundleOffset;
            	//曲线；   
               }else if(temObj.ltype == 'curve'){
            	   var lk = new JTopo.CurveLink(beginNode, endNode);
               }else{
            	   var lk = new JTopo.Link(beginNode, endNode);
               }
               
			lk.lineWidth 		= 	 temObj.lwidth; 		//宽度
			lk.bundleGap 		= 	 temObj.lbundlegap; 	//线体间隔；
			lk.textOffsetY 		= 	 temObj.loffset;		//文本偏移；
			lk.arrowsRadius 	= 	 temObj.larrowsize;		//箭头大小；
			lk.strokeColor		=	 temObj.lcolor;			//连线颜色；
			lk.text				=	 temObj.ltext;			//连线文本；
			lk.dcid 			= 	 new Date().getTime();
			lk.linkSetInfo		=	 temObj;
			if(temObj.lpattern == 'dashedPattern') lk.dashedPattern = temObj.lwidth; //虚实；
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
	//新建窗口关闭时，清空Redis缓存数据；
	/* var closeA = $("#container_box").parent().prev("div").find("a.close");
	closeA.on('click',function(){
		var dt = new Date().getTime();
		$.post('/index.php/Service/Graphlogic/clearRedis',{t:dt},function(data){console.log('Redis缓存已清空！')})
	}) */
	
	//监听弹出窗口，关闭之后清空本地缓存；
	var dialog = $.pdialog.getCurrent();
	dialog.find("a.close").click(function(){
		if(JPStore){
			JPStore.clear();
		}
	})
	//进制改变窗口大小；
	dialog.find("a.restore").hide();
	
	$(".lty").eq(0).find("span").css({'color':'#FF0000'});
	//连线样式切换；
	$(".lty").click(function(){
		$(this).find("span").css({'color':'#FF0000'});
		$(this).parent().siblings().find("span").css({'color':'#616161'});
	})
})

</script>