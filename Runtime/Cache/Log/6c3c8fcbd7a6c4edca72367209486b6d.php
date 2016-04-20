<?php if (!defined('THINK_PATH')) exit();?><form id="pagerForm" action="/index.php/Log/AlarmDateStat" method="post">
	<input type="hidden" name="pageNum" value="1"/>
	<!--input type="hidden" name="pageNum2" value="1"/>
	<input type="hidden" name="pageSize" value="16"/>
	<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
	<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
	<input type="hidden" name="_sort2" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
	<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
	-->
</form>

<script type="text/javascript">
	$("#productId").change(function(){
		var name = $("#productId option:selected").text();
	//	alert(name);
		$.cookie('productId',$(this).val(),{path:'/Competence/dwztp321/Admin'});
		$.cookie('productName',name,{path:'/Competence/dwztp321/Admin'});
	})
</script>

<div class="pageHeader">
	<form rel ="pagerForm" method="post"  onsubmit="return navTabSearch(this);" action="/index.php/Log/AlarmDateStat">
	<div class="searchBar">
		<ul class="searchContent">
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
	<?php if(($showdata == 1) ): ?><iframe width="1000px" height="440px" frameborder="0" marginwidth="0" marginheight="0" src="index.php?s=/Log/AlarmDateStat/showDateStatics" name="frame" id="frame">
	</iframe>
	<?php else: ?>
		暂无数据<?php endif; ?>
</div>