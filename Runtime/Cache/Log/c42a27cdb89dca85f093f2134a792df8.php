<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>运维综合平台--日志系统<?php echo (C("sitename")); ?></title>

<!--link href="/Public/dwz/themes/default/style.css" rel="stylesheet" type="text/css" /-->
<link href="/Public/dwz/themes/css/style.css" rel="stylesheet" type="text/css" />
<link href="/Public/dwz/themes/css/core.css" rel="stylesheet" type="text/css" />
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
<script type="text/javascript">



function fleshVerify(){
	//重载验证码
	$('#verifyImg').attr("src", '/index.php/Log/Public/verify/'+new Date().getTime());
}
function dialogAjaxMenu(json){
	dialogAjaxDone(json);
	if (json.statusCode == DWZ.statusCode.ok){
			//扩展
			var menuTag=$("#navMenu .selected").attr('menu');
			$("#sidebar").loadUrl("/index.php/Log/Public/menu/menu/"+menuTag);
	}
}

function navTabAjaxMenu(json){
	navTabAjaxDone(json);
	if (json.statusCode == DWZ.statusCode.ok){
		//扩展
		var menuTag=$("#navMenu .selected").attr('menu');
		$("#sidebar").loadUrl("/index.php/Log/Public/menu/menu/"+menuTag);
	}
}


function navTabAjaxGroupMenu(json){
	navTabAjaxDone(json);
	if (json.statusCode == DWZ.statusCode.ok){
		//扩展
		var menuTag=$("#navMenu .selected").attr('menu');
		$("#sidebar").loadUrl("/index.php/Log/Public/menu/menu/"+menuTag);
	}
}


/*function navTabAjax(json){
	navTabAjaxDone(json);
	if (json.statusCode == DWZ.statusCode.ok){
		$("#navMenu").loadUrl("/index.php/Log/Public/nav");
	}
}
*/
$(function(){
	DWZ.init("/Public/dwz/dwz.frag.xml", {
		loginUrl:"/index.php/Log/Public/login_dialog", loginTitle:"登录",	// 弹出登录对话框
		statusCode:{ok:1,error:0},
		//statusCode:{ok:200, error:300, timeout:301}, //【可选】
		pageInfo:{pageNum:"pageNum", numPerPage:"numPerPage", orderField:"_order", orderDirection:"_sort"}, //【可选】
		debug:false,	// 调试模式 【true|false】
		callback:function(){
			initEnv();
			$("#themeList").theme({themeBase:"/Public/dwz/themes"});
		}
	});
	

});





	
</script>
</head>

<body scroll="no">
	<div id="layout">
		<div id="header">
			<div class="headerNav">
				<span id="headerlist">
				<span><a id="logout" href="/index.php/Log/Public/logout/">退出</a></span>
				<span><a id="chgpwd" target='dialog' width=500 height=220 href="/index.php/Log/Public/password/">修改密码</a></span>
				<span><a id="userinfo" href='#'><?php echo "超级管理员". $_SESSION['rbac']['username'] ?></a></span>
				</span>
				<!-- <a class="logo" href="http://www.xinguodu.com" target="blank">标志</a> -->
				<a href="http://www.xinguodu.com" class="top_tit">运维综合服务平台--日志系统</a>
			</div>
			
			<!--div id="navMenu">
				<ul>
					<?php if(is_array($volist)): $k = 0; $__LIST__ = $volist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li <?php if(($k) == "1"): ?>class="selected"<?php endif; ?> menu="<?php echo ($vo["menu"]); ?>"><a href="/index.php/Log/Public/menu/menu/<?php echo ($vo["menu"]); ?>" ><span><?php echo ($vo["name"]); ?></span></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div-->
		</div>
		
		<div id="leftside">
			<div id="leftshadow" ></div>
			<div id="sidebar_s">
				<div class="collapse">
					<div class="toggleCollapse"><div></div></div>
				</div>
			</div>
			
			<div id="sidebar">
				<div class="toggleCollapse"><h2>主菜单</h2></div>
				
<!--div class="accordion" fillSpace="sideBar">
	<div class="accordionContent">
		<ul class="tree leftmenu treeFolder">
			<?php if(is_array($menu)): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><li><a  class="accordionHeader" href="/index.php/Log/<?php echo ($item['menuUrl']); ?>" target="navTab" rel="<?php echo ($item['menuUrl']); ?>"><?php echo ($item['menuName']); ?></a>
				<?php if(!empty($item['sub'])): ?><ul>
				<?php if(is_array($item['sub'])): $i = 0; $__LIST__ = $item['sub'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$subItem): $mod = ($i % 2 );++$i;?><li class="nonesub" ><a class="tree_menu" href="/index.php/Log/<?php echo ($subItem['menuUrl']); ?>" target="navTab" rel="<?php echo ($subItem['menuUrl']); ?>" ><?php echo ($subItem['menuName']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul><?php endif; ?>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>

	</div>
</div--> 

<div class="accordion" fillspace="sidebar">
	<div class="accordionHeader">
		<h2><div class="side_menu_icon_2">日志系统</div></h2>
	</div>
	<div class="accordionContent">
		<ul class="tree leftmenu treeFolder">
			<li>
				<a class="tree_menu" href="javascript:void(null);">实时监控</a>
				<ul style="display: none;">
					<li><a href="/index.php/Log/RealTimeDetection" target="navTab" rel="L30501">实时监控总数</a></li>
					<li><a href="/index.php/Log/LatestWarningLog" target="navTab" rel="L30502">最新告警日志</a></li>
				</ul>
			</li>
			<li>
				<a class="tree_menu" href="javascript:void(null);">日志查询</a>
				<ul style="display: none;">
					<!-- <li><a href="/index.php/Log/QueryHistoryLog" target="navTab" rel="L30601">日志历史查询</a></li> 
					<li><a href="/index.php/Log/CallChain" target="navTab" rel="L30602">调用链</a></li>-->
					<li><a href="/index.php/Log/CallChain/index/type/1" target="navTab" rel="L30602" title="基础服务链">基础服务调用链</a></li>
					<li><a href="/index.php/Log/CallChain/index/type/2" target="navTab" rel="L30604" title="交易调用链">交易调用链</a></li>
					<li><a href="/index.php/Log/CallChain/index/type/3" target="navTab" rel="L30605" title="交易调用节点">交易调用节点</a></li>
					<li><a href="/index.php/Log/CallChain/index/type/4" target="navTab" rel="L30606" title="资金调用链">资金调用链</a></li>
					<li><a href="/index.php/Log/CallChain/index/type/5" target="navTab" rel="L30607" title="会员操作日志">会员操作日志</a></li>
					<!-- <li><a href="/index.php/Log/BusinessView" target="navTab" rel="L30603">业务视图</a></li> -->
				</ul>
			</li>
			<li>
				<a class="tree_menu" href="javascript:void(null);">日志统计</a>
				<ul style="display: none;">
					<li><a href="/index.php/Log/HostEventStat" target="navTab" rel="L30701">主机事件统计</a></li>
					<li><a href="/index.php/Log/AlarmDateStat" target="navTab" rel="L30702">按日期统计</a></li>
					<li><a href="/index.php/Log/ChainCount" target="navTab" rel="L30803">节点耗时统计</a></li>
				</ul>
			</li>
			
			<li>
				<a class="tree_menu" href="javascript:void(null);">日志设置</a>
				<ul style="display: none;">
					<li><a href="/index.php/Log/AnalysisRule" target="navTab" rel="L30801">节点管理</a></li>
					<!-- <li><a href="/index.php/Log/CollectSet" mask="true" target="dialog" title="收集器配置">收集器配置</a></li> -->
					<li><a href="/index.php/Log/CraftSet" target="navTab" rel="L30802">分析器配置</a></li>
				</ul>
			</li>
		</ul>
	</div>
	
	
	
	
	
	
</div>
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
					<div class="accountInfo"><!--
						<div class="alertInfo">
							<h2><a href="#" target="_blank"><b>【使用手册】</b> TMS终端管理系统使用手册(PDF)</a></h2>
						</div>-->
						<div class='right'><span>今天是：<?php echo date('Y年 m月 d日')?></span></div>
						<p><span>您好！欢迎使用运维综合服务平台--日志系统</span></p>
					</div>
					<div class="pageFormContent" layoutH="40" style='padding:0 5px'>
						<div class='welcome'>欢迎使用</div>
						<div style='margin-top:120px; padding:0 50px'>
						<!--<fieldset>
							<legend>系统公告</legend>
							<dl>请迅速完成某某二期改造请迅速完成某某二期改造</dl>
							<dl>请迅速完成某某二期改造请迅速完成某某二期改造</dl>
							<dl>请迅速完成某某二期改造请迅速完成某某二期改造</dl>
							<dl>请迅速完成某某二期改造请迅速完成某某二期改造</dl>
						</fieldset>

						<fieldset>
							<legend>系统公告</legend>
							<dl>请迅速完成某某二期改造请迅速完成某某二期改造</dl>
							<dl>请迅速完成某某二期改造请迅速完成某某二期改造</dl>
							<dl>请迅速完成某某二期改造请迅速完成某某二期改造</dl>
							<dl>请迅速完成某某二期改造请迅速完成某某二期改造</dl>
						</fieldset>

						<fieldset>
							<legend>系统公告</legend>
							<dl>请迅速完成某某二期改造请迅速完成某某二期改造</dl>
							<dl>请迅速完成某某二期改造请迅速完成某某二期改造</dl>
							<dl>请迅速完成某某二期改造请迅速完成某某二期改造</dl>
							<dl>请迅速完成某某二期改造请迅速完成某某二期改造</dl>
						</fieldset>

						<fieldset>
							<legend>系统公告</legend>
							<dl>请迅速完成某某二期改造请迅速完成某某二期改造</dl>
							<dl>请迅速完成某某二期改造请迅速完成某某二期改造</dl>
							<dl>请迅速完成某某二期改造请迅速完成某某二期改造</dl>
							<dl>请迅速完成某某二期改造请迅速完成某某二期改造</dl>
						</fieldset>
						--></div>
					</div>
					<!-- 
					<div style="width:230px;position: absolute;top:60px;right:0" layoutH="80">
					<iframe width="100%" height="430" class="share_self" frameborder="0" scrolling="no" src="http://www.baidu.com">
					</iframe>
					</div> -->
				</div>
				
			</div>
		</div>
	</div>

	</div>
	
	<div id="footer">Copyright © 2013 <a href="http://www.xinguodu.com" target="blank">新国都技术股份有限公司</a> Tel：0755-98319989</div>

</body>
</html>