<?php if (!defined('THINK_PATH')) exit();?><form id="pagerForm" action="/index.php/Log/HostEventStat" method="post">
	<input type="hidden" name="pageNum" value="1"/>
	<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>
	<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
	<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
	<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
</form>

<div class="pageHeader">
	<form rel ="pagerForm" method="post"  onsubmit="return navTabSearch(this);" action="/index.php/Log/HostEventStat">
	<div class="searchBar">
		<ul class="searchContent">
			<li>
			<label>IP地址：</label>
			<input type="text" value="<?php echo ($_REQUEST['ip']); ?>" id="ip" name="ip" class="textInput">
			</li>
			<li>
				<label>时间（起）：</label>
				<input maxDate="<?php echo date('Y-m-d'); ?>" type="text" value="<?php echo ($_REQUEST['startTime']); ?>" id="startTime" name="startTime" readonly="1" datefmt="yyyy-MM-dd" class="date textInput readonly">
			</li>
			<li>
				<label>时间（终）：</label>
				<input maxDate="<?php echo date('Y-m-d'); ?>" type="text" value="<?php echo ($_REQUEST['endTime']); ?>" id="endTime" name="endTime" readonly="1" datefmt="yyyy-MM-dd" class="date textInput readonly">
			</li>
		</ul>
		<div class="subBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">查询</button></div></div></li>
			</ul>
		</div>
	</div>
	</form>
</div>
<div class="pageContent">
	<?php if(($showPic == 1) ): ?><iframe width="500px" height="440px" frameborder="0" marginwidth="0" marginheight="0" src="/index.php?s=/Log/HostEventStat/showPie" name="frame" id="frame">
		</iframe>
		<iframe width="500px" height="440px" frameborder="0" marginwidth="0" marginheight="0" src="/index.php?s=/Log/HostEventStat/showBarchart" name="frame" id="frame">
		</iframe>
		<?php else: ?>
			<div style="align:center"><h3>暂无图表数据</h3></div><?php endif; ?>
</div>