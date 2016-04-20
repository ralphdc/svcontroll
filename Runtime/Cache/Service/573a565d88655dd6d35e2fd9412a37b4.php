<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>运维综合平台--服务管制<?php echo (C("sitename")); ?></title>

<!--link href="/Public/dwz/themes/default/style.css" rel="stylesheet" type="text/css" /-->
<link href="/Public/dwz/themes/css/style.css" rel="stylesheet" type="text/css" />
<link href="/Public/dwz/themes/css/core.css" rel="stylesheet" type="text/css" />

<link href="/Public/uploadify/uploadify.css" rel="stylesheet" type="text/css" />

<!--[if IE]>
<link href="/Public/dwz/themes/css/ieHack.css" rel="stylesheet" type="text/css" />
<![endif]-->
<style type="text/css">


</style>
<script>
/*ThinkPHP常量*/
var _APP_="/index.php";
var _PUBLIC_="/Public";
/*本地域名正则表达式*/
//var localTest=/^http?:\/\/<?php echo str_replace(".","\.",$_SERVER['HTTP_HOST']) ?>\//i;
var localTest=/^http?:\/\/[^\/]*?(sinaapp\.com)\//i;
</script>

<script src="/Public/dwz/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="/Public/dwz/js/jquery.cookie.js" type="text/javascript"></script>
<script src="/Public/dwz/js/jquery.validate.js" type="text/javascript"></script>
<script src="/Public/dwz/js/jquery.bgiframe.js" type="text/javascript"></script>
<script src="/Public/xheditor/xheditor-1.2.1.min.js" type="text/javascript"></script>
<script src="/Public/xheditor/xheditor_lang/zh-cn.js" type="text/javascript"></script>
<script src="/Public/dwz/js/dwz.min.js" type="text/javascript"></script>
<script src="/Public/dwz/js/dwz.regional.zh.js" type="text/javascript"></script>
<script src="/Public/dwz/js/speedup.js" type="text/javascript"></script>
<script src="/Public/Highcharts/js/highcharts.js" type="text/javascript"></script>
<script src="/Public/uploadify/jquery.uploadify.min.js" type="text/javascript"></script>
<script src="/Public/echarts/echarts.min.js" type="text/javascript"></script>
<script src="/Public/common/common.js" type="text/javascript"></script>



<script type="text/javascript">

function fleshVerify(){
	//重载验证码
	$('#verifyImg').attr("src", '/index.php/Service/Public/verify/'+new Date().getTime());
}
function dialogAjaxMenu(json){
	dialogAjaxDone(json);
	if (json.statusCode == DWZ.statusCode.ok){
			//扩展
			var menuTag=$("#navMenu .selected").attr('menu');
			$("#sidebar").loadUrl("/index.php/Service/Public/menu/menu/"+menuTag);
	}
}

function navTabAjaxMenu(json){
	navTabAjaxDone(json);
	if (json.statusCode == DWZ.statusCode.ok){
		//扩展
		var menuTag=$("#navMenu .selected").attr('menu');
		$("#sidebar").loadUrl("/index.php/Service/Public/menu/menu/"+menuTag);
	}
}


function navTabAjaxGroupMenu(json){
	navTabAjaxDone(json);
	if (json.statusCode == DWZ.statusCode.ok){
		//扩展
		var menuTag=$("#navMenu .selected").attr('menu');
		$("#sidebar").loadUrl("/index.php/Service/Public/menu/menu/"+menuTag);
	}
}


/*function navTabAjax(json){
	navTabAjaxDone(json);
	if (json.statusCode == DWZ.statusCode.ok){
		$("#navMenu").loadUrl("/index.php/Service/Public/nav");
	}
}
*/


var setMenuUrl = "/index.php/Service/Common/setMenu";
$(function(){
	DWZ.init("/Public/dwz/dwz.frag.xml", {
		loginUrl:"/index.php/Service/Public/login_dialog", loginTitle:"登录",	// 弹出登录对话框
		statusCode:{ok:1,error:0, timeout:301},
		//statusCode:{ok:200, error:300, timeout:301}, //【可选】
		pageInfo:{pageNum:"pageNum", numPerPage:"numPerPage", orderField:"_order", orderDirection:"_sort"}, //【可选】
		debug:false,	// 调试模式 【true|false】
		callback:function(){
			initEnv();
			$("#themeList").theme({themeBase:"/Public/dwz/themes"});
		}
	});
	
	
	$("#sysMenu").find("a").each(function(e){
		var hf = $(this).attr("href");
		if(hf.indexOf("http") != -1){
			var hflen = strlen(hf);
			var htp = hf.substring(hf.indexOf("http"),hflen+1);
			$(this).attr('href',htp);
			$(this).attr('target','_blank');
		}
	})
});

//判断字符串长度，区分单双字节；
function strlen(str){
    var len = 0;
    for (var i=0; i<str.length; i++) { 
     var c = str.charCodeAt(i); 
    //单字节加1 
     if ((c >= 0x0001 && c <= 0x007e) || (0xff60<=c && c<=0xff9f)) { 
       len++; 
     } 
     else { 
      len+=2; 
     } 
    } 
    return len;
}





	
</script>
</head>
<body scroll="no">
	<div id="layout">
		<div id="header">
			<div class="headerNav">
				<span id="headerlist">
				<span><a id="logout" href="/index.php/Service/Public/logout/">退出</a></span>
				<span><a id="chgpwd" target='dialog' width=500 height=220 href="/index.php/Service/Public/password/">修改密码</a></span>
				<span><a id="userinfo" href='#'><?php echo $_SESSION[C('USER_AUTH_KEY')]; ?></a></span>
				<span><a style="background-image:none" href="/index.php/Service/Environment" mask="true" target="dialog" title="设置环境">设置环境</a></span>
				</span>
				<!-- <a class="logo" href="http://www.xinguodu.com" target="blank">标志</a> -->
				<a href="/index.php/Service/Index" class="top_tit">运维综合服务平台(<span style="color:red;font-size:22px;font-style:italic"><?php echo ($enviroment[$_SESSION['WEB_ENVIRONMENT']]); ?>环境</span>)--服务管制</a>
			</div>
			
			<!--div id="navMenu">
				<ul>
					<?php if(is_array($volist)): $k = 0; $__LIST__ = $volist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li <?php if(($k) == "1"): ?>class="selected"<?php endif; ?> menu="<?php echo ($vo["menu"]); ?>"><a href="/index.php/Service/Public/menu/menu/<?php echo ($vo["menu"]); ?>" ><span><?php echo ($vo["name"]); ?></span></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div-->
		</div>
		
		<div id="leftside">
			<div id="leftshadow" ></div>
			<div id="sidebar_s" style="left: 0px;">
				<div class="collapse">
					<div class="toggleCollapse"><div></div></div>
				</div>
			</div>
			
			<div id="sidebar">
				<div class="toggleCollapse"><h2>主菜单</h2><div>收缩</div></div>
				<div class="accordion" fillspace="sidebar" id="sysMenu">
		<?php if(!empty($menu)): ?>
			<?php foreach($menu as $mk=>$mv): ?>
			<div class="accordionHeader">
					<h2><div class="side_menu_icon_2"><?php echo $mv['name']; ?></div></h2>
			</div>
			<?php if(!empty($mv['children'])): ?>
				<div class="accordionContent">
					<ul class="tree leftmenu treeFolder">
						<?php foreach($mv['children'] as $mvk=>$mvv): ?>
							<li>
								<a 
									<?php if(!empty($mvv['children'])): ?>
										class="tree_menu" 
									<?php else: ?>
									 target="navTab" rel="<?php echo $mvv['id'] ?>" 
									 <?php endif; ?> 
								
								<?php if($mvv['name'] == '服务治理'): ?> 
									<?php if($_SESSION['WEB_ENVIRONMENT'] == 3): ?>
										href="http://172.20.6.136:85/containerui/index.do" 
										<?php elseif($_SESSION['WEB_ENVIRONMENT'] == 4 || $_SESSION['WEB_ENVIRONMENT'] == 5): ?>
										 href="http://172.17.4.203:8080/containerui/index.do"
										  <?php elseif($_SESSION['WEB_ENVIRONMENT'] == 2): ?>
										  href="http://10.128.133.113/containerui/index.do"
										   <?php else: ?>href="http://172.17.4.203:8080/containerui/index.do"
									<?php endif; ?> 
									<?php else: ?>
										 href="/index.php/<?php echo getUrl($mvv['url']);?>"
								<?php endif;?>>
								<?php echo $mvv['name']; ?>
								</a>
								<?php if(!empty($mvv['children'])): ?>
									<ul style="display: none;">
										<?php foreach($mvv['children'] as $mvvk=>$mvvv): ?>
												<li><a href="/index.php/<?php echo getUrl($mvvv['url']);?>" target="navTab" rel="<?php echo $mvvv['id'];?>"> <?php echo $mvvv['name'];?></a></li>
										<?php endforeach; ?>
										<?php if($mvv['name'] == '拓扑镜像'): ?>
											<li>
												<a href="/index.php/Service/Mornode" target="navTab" rel="D890170">监控节点管理</a>
											</li>
											<li>
												<a href="/index.php/Service/Snmp" target="navTab" rel="SNMP88967">SNMP模板管理</a>
											</li>
										<?php endif; ?>
									</ul>
								<?php endif; ?>
								

							</li>
						<?php endforeach; ?>
						<!-- 
						<?php if($mv['name'] == '监控管理'): ?>
							<li>
								<a href="/index.php/javascript:void(0);" class="tree_menu">SNMP配置</a>
								<ul style="display: none;">
									<li><a href="/index.php/Service/Snmp" target="navTab" rel="SNMP88967">模板管理</a></li>
								</ul>
							</li>
						<?php endif; ?>
						 -->
					</ul>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
		<?php else: ?>
		没有可以显示的菜单
		<?php endif; ?>
</div>
<script type="text/javascript">
/* $(document).ready(function(){
	
	$(".tree_menu").next("ul").find("a").each(function(e){
		var href = $(this).attr("href");
		var menuId = $(this).attr("rel");
		if(href.indexOf("?") > -1){
			var newHref = href + "&" + "menuId="+menuId;
		}else{
			var newHref = href + "/?" + "menuId="+menuId;
		}
		$(this).attr("href",newHref);
	})
	
}) */
</script>
			</div>
		</div>

<div id="container">
		<div id="navTab" class="tabsPage">
			<div class="tabsPageHeader">
				<div class="tabsPageHeaderContent"><!-- 显示左右控制时添加 class="tabsPageHeaderMargin" -->
					<ul class="navTab-tab">
						<li tabid="main" class="main"><a href="javascript:;"><span><span class="home_icon"> 首页</span></span></a></li>
					</ul>
				</div>
				<div class="tabsLeft">left</div><!-- 禁用只需要添加一个样式 class="tabsLeft tabsLeftDisabled" -->
				<div class="tabsRight">right</div><!-- 禁用只需要添加一个样式 class="tabsRight tabsRightDisabled" -->
				<div class="tabsMore">more</div>
			</div>
			<ul class="tabsMoreList">
				<li><a href="javascript:;">首页</a></li>
			</ul>
			<div class="navTab-panel tabsPageContent layoutBox">
				<div class="page unitBox">
					<div class="accountInfo">
						<div class='right'><span>今天是：<?php echo date('Y年 m月 d日')?></span></div>
						<p><span>您好！欢迎使用运维综合服务平台(<?php echo ($enviroment[$_SESSION['WEB_ENVIRONMENT']]); ?>环境)--服务管制</span></p>
					</div>
					<div class="pageFormContent" layoutH="40" style='padding:0 5px'>
						<div class='welcome'>欢迎使用</div>
						<div style='margin-top:120px; padding:0 50px'>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
	
</div>
	
	<div id="footer">Copyright © 2013 <a href="http://www.xinguodu.com" target="blank">新国都技术股份有限公司</a> Tel：0755-98319989</div>

</body>
</html>