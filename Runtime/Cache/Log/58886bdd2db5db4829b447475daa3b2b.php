<?php if (!defined('THINK_PATH')) exit();?><form id="pagerForm" action="/index.php/Log/RealTimeDetection" method="post">
	<input type="hidden" name="pageNum" value="1"/>
	<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>
	<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
	<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
	<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
</form>

<div class="pageHeader">
	<form rel ="pagerForm" method="post"  onsubmit="return navTabSearch(this);" action="/index.php/Log/RealTimeDetection">
	<div class="searchBar">
		<ul class="searchContent">
			<li>
			<label>服务：</label>
			<input type="text" value="<?php echo ($_REQUEST['srv']); ?>" id="srv" name="srv" class="textInput">
			</li>
			<li>
				<label>时间（起）：</label>
				<input maxDate="<?php echo date('Y-m-d'); ?>"  type="text" value="<?php if($_REQUEST['start']) echo $_REQUEST['start'];else echo date('Y-m-d'); ?>" id="start" name="start" readonly="1" datefmt="yyyy-MM-dd" class="date textInput readonly">
			</li>
			<li>
				<label>时间（终）：</label>
				<input maxDate="<?php echo date('Y-m-d'); ?>"  type="text" value="<?php if($_REQUEST['end']) echo $_REQUEST['end'];else echo date('Y-m-d'); ?>" id="end" name="end" readonly="1" datefmt="yyyy-MM-dd" class="date textInput readonly">
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
	<div class="panelBar" style="height:27px;">
		<ul class="toolBar">
		</ul>
	</div>
	<table class="table" width="100%" layoutH="138">
		<thead>
		<tr>
			<th width="200">服务</th>
			<th width="200">错误总数</th>
		</tr>
		</thead>
		<tbody>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr target="sid_user" rel="<?php echo ($vo['srv']); ?>">
				<td><?php echo ($vo['srv']); ?></td>
				<td><a style="text-decoration:underline;color:red" rel="L30503" target="navTab" title="查看详情页面" href="/index.php?s=/Log/ShowMonitorDetail/index/srv/<?php echo ($vo['srv']); ?>/start/<?php echo $_REQUEST['start']?$_REQUEST['start']:date('Y-m-d');?>/end/<?php echo $_REQUEST['end']?$_REQUEST['end']:date('Y-m-d');?>"><?php echo ($vo['error']); ?></a></td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</tbody>
	</table>

	<div class="panelBar">
		<div class="pages">
			<span>显示</span>
			<select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
				<?php
 $numPerPageArr = array(20,50,100,200); foreach($numPerPageArr as $val) { if($val == $numPerPage) $selected = 'selected'; echo '<option value="'.$val.'" '.$selected.'>'.$val.'</option>'; $selected = ''; } ?>
			</select>
			<span>条，共<?php echo ($totalCount); ?>条</span>
		</div>
		<div class="pagination" targetType="navTab" totalCount="<?php echo ($totalCount); ?>" numPerPage="<?php echo ($numPerPage); ?>" pageNumShown="5" currentPage="<?php echo ($currentPage); ?>"></div>
	</div>


</div>