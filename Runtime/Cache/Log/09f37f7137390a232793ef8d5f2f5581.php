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
			<label>调用链ID：</label>
			<input type="text" value="<?php echo ($_REQUEST['cid']); ?>" id="cid" name="cid" class="textInput"/>
			<input type="hidden" value="<?php echo ($_REQUEST['type']); ?>" name="type" />
			</li>
			<li>
				<label>时间（起）：</label>
				<input size="19" maxDate="<?php echo date('Y-m-d'); ?>" type="text" value="<?php echo ($_REQUEST['startTime']); ?>" id="startTime" name="startTime" readonly="true" datefmt="yyyy-MM-dd HH:mm:ss" class="date textInput readonly">
			</li>
			<li>
				<label>时间（终）：</label>
				<input size="19" maxDate="<?php echo date('Y-m-d'); ?>" type="text" value="<?php echo ($_REQUEST['endTime']); ?>" id="endTime" name="endTime" readonly="true" datefmt="yyyy-MM-dd HH:mm:ss" class="date textInput readonly">
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
			<!-- <li><a class="edit" href="/index.php/Log/CallChain/exportexcell/param/<?php echo (base64_encode(json_encode($_REQUEST))); ?>" title="导出Excell"><span>导出成Excell表格</span></a></li> -->
		</ul>
	</div>	
	<table class="table" width="100%" layoutH="138">
		<thead>
		<tr>
			<th width="60">编号</th>
			<th>调用链ID</th>
			<th>日志等级</th>
			<th width="100">信息</th>
			<th>IP地址</th>
			<th>服务名称</th>
			<th>类名</th>
			<th>方法名</th>
			<th>日志类型</th>
			<th>进程ID</th> 
			<th width="100" orderField="logTime" <?php if($_REQUEST["_order"] == 'logTime'): ?>class="<?php echo ($_REQUEST["_sort"]); ?>"<?php endif; ?> >发生时间</th>
			
		</tr>
		</thead>
		<tbody>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr target="sid_user" rel="<?php echo ($vo['id']); ?>">
				<td>
					<?php
 $listnums = $numPerPage * ($currentPage-1) + $key+1; echo $listnums; ?>
				</td>
				<td><?php echo ($vo['cid']); ?></td>
				<td><?php echo ($vo['lvl']); ?></td>
				<td><a height="563" width="524" mask="true" rel="see_info_win4" title="查看信息" target="dialog" href="/index.php?s=/Log/QueryHistoryLog/showinfo/id/<?php echo ($vo['id']); ?>/type/4"><?php echo substr($vo['msg'],0,100);?></a></td>
				<td><?php echo ($vo['ip']); ?></td>
				<td><?php echo ($vo['srv']); ?></td>
				<td><?php echo ($vo['cls']); ?></td>
				<td><?php echo ($vo['fn']); ?></td>
				<td><?php echo ($vo['lt']); ?></td>
				<td><?php echo ($vo['pid']); ?></td>
				<td><?php echo ($vo['logtime']); ?></td>
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

<script type="text/javascript">
	$(function(){
		$("#cid").width(600);
	})
</script>