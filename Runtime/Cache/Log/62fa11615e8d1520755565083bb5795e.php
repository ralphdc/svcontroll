<?php if (!defined('THINK_PATH')) exit();?><form id="pagerForm" action="/index.php/Log/CallChain" method="post">
	<input type="hidden" name="pageNum" value="1"/>
	<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>
	<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
	<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
	<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
</form>


<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return navTabSearch(this);" action="/index.php/Log/CallChain" method="post">
	<div class="searchBar">
		<ul class="searchContent">	
			<li>
			<label>服务名：</label>
			<input type="text" value="<?php echo ($_REQUEST['srv']); ?>" id="srv" name="srv" class="textInput">
			</li>
			<li>
			<label>调用链ID：</label>
			<input type="text" value="<?php echo ($_REQUEST['cid']); ?>" id="cid" name="cid" class="textInput">
			</li>
			<li>
				<label>时间（起）：</label>
				<input maxDate="<?php echo date('Y-m-d'); ?>" size="10" type="text" value="<?php echo ($_REQUEST['startTime']); ?>" id="startTime" name="startTime" readonly="1" datefmt="yyyy-MM-dd" class="date textInput readonly">
			</li>
			<li>
				<label>时间（终）：</label>
				<input maxDate="<?php echo date('Y-m-d'); ?>" size="10" type="text" value="<?php echo ($_REQUEST['endTime']); ?>" id="endTime" name="endTime" readonly="1" datefmt="yyyy-MM-dd" class="date textInput readonly">
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
			<li><a class="edit" href="/index.php/Log/CallChain/exportexcell/param/<?php echo (base64_encode(json_encode($_REQUEST))); ?>" title="导出Excell"><span>导出成Excell表格</span></a></li>
		</ul>
	</div>	
	<table class="table" width="100%" layoutH="138">
		<thead>
		<tr>
			<th width="60">编号</th>
			<th>调用链ID</th>
			<th>日志等级</th>
			<th>head头信息</th>
			<th width="100">信息</th>
			<th>IP地址</th>
			<th>服务名称</th>
			<th>服务类型</th>
			<th>进程ID</th> 
			<!--
			<th>CPU(%)</th>
			<th>内存(%)</th> -->
			<th>耗时</th>
			<th width="100" orderField="logTime" <?php if($_REQUEST["_order"] == 'logTime'): ?>class="<?php echo ($_REQUEST["_sort"]); ?>"<?php endif; ?> >发生时间</th>
			<!-- <th>查看图表</th> -->
			
		</tr>
		</thead>
		<tbody>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr target="sid_user" rel="<?php echo ($vo['id']); ?>">
				<td>
					<?php
 $listnums = $numPerPage * ($currentPage-1) + $key+1; echo $listnums; ?>
				</td>
				<td><?php echo ($vo['chainId']); ?></td>
				<td><?php echo ($vo['level']); ?></td>
				<td><a href="javascript:void(0);" title="<?php echo ($vo['head']); ?>"></a><?php echo ($vo['head']); ?></td>
				<td><a height="563" width="524" mask="true" rel="see_info_win" title="查看信息" target="dialog" href="/index.php?s=/Log/QueryHistoryLog/showinfo/id/<?php echo ($vo['id']); ?>/type/<?php echo ($vo['format']); ?>"><?php echo substr($vo['msg'],0,100);?></a></td>
				<td><?php echo ($vo['ip']); ?></td>
				<td><?php echo ($vo['service']); ?></td>
				<td><?php echo ($vo['serviceType']); ?></td>
				<td><?php echo ($vo['pid']); ?></td>
				<!-- <td><?php echo ($vo['cpu']); ?></td>
				<td><?php echo ($vo['memory']); ?></td> -->
				<td><?php echo ($vo['elapseTime']); ?></td>
				<td><?php echo ($vo['logTime']); ?></td>
				<!-- <td><a title="查看前后20秒CPU、memory使用率图表" width="1400" height="445" mask="true" target="dialog" href="/index.php?s=/Log/CallChain/showLine/ip/<?php echo ($vo['ip']); ?>/time/<?php echo ($vo['logTime']); ?>">点击查看CPU、memory使用率</a></td> -->
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