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
			<label>调用链ID ：</label>
			<input type="text" value="<?php echo ($_REQUEST['cid']); ?>" id="cid" name="cid" class="textInput" size="50">
			<input type="hidden" value="<?php echo ($_REQUEST['type']); ?>" name="type" />
			</li>
			<li>
				<label>时间（起）：</label>
				<input size="20" maxDate="<?php echo date('Y-m-d'); ?>" type="text" value="<?php echo ($_REQUEST['startTime']); ?>" id="startTime" name="startTime" readonly="1" datefmt="yyyy-MM-dd HH:mm:ss" class="date textInput readonly">
			</li>
			<li>
				<label>时间（终）：</label>
				<input size="20" maxDate="<?php echo date('Y-m-d'); ?>" type="text" value="<?php echo ($_REQUEST['endTime']); ?>" id="endTime" name="endTime" readonly="1" datefmt="yyyy-MM-dd HH:mm:ss" class="date textInput readonly">
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
<div class="pageContent sortDrag" selector="h1" layoutH="42">
<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><div class="panel collapse">
		<h1><?php echo ($vol['title']); ?></h1>
		<div>
		<table class="list" width="98%">
		<thead>
		<tr>
			<th>编号</th>
			<th>调用链</th>
			<th>服务名</th>
			<th>等级</th>
			<th>信息</th>
			<th>耗时</th>
			<th>方法名称</th>
			<th>路径展示</th>
			<th>记录时间</th>
			<th>线程号</th>
			<th>进程号</th>
			<th>ip地址</th>
		</tr>
		</thead>
		<tbody>
		<?php $respList = $vol['respList']; ?>
		<?php if(is_array($respList)): $i = 0; $__LIST__ = $respList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
				<td>
					<?php
 $listnums = $numPerPage * ($currentPage-1) + $key+1; echo $listnums; ?>
				</td>
				<td><?php echo ($vo['cid']); ?></td>
				<td><?php echo ($vo['srv']); ?></td>
				<?php if($vo['lvl'] == 'ERROR') $style="style='color:red;'";else $style='';?>
				<td <?php echo ($style); ?>><?php echo ($vo['lvl']); ?></td>
				<td><a height="563" width="524" mask="true" rel="see_info_win" title="查看信息" target="dialog" href="/index.php?s=/Log/QueryHistoryLog/showinfo/id/<?php echo ($vo['id']); ?>/type/2/ltype/2"><?php echo substr($vo['msg'],0,30);?></a></td>
				<?php if($vo['etc'] >= 5) $style="style='color:red;'";else $style='';?>
				<td <?php echo ($style); ?>><?php echo ($vo['etc']); ?></td>
				<td><?php echo ($vo['fn']); ?></td>
				<td><div style="width:200px; overflow:hidden;"><?php echo ($vo['dir']); ?></div></td>
				<td><?php echo ($vo['logtime']); ?></td>
				<td><?php echo ($vo['tid']); ?></td>
				<td><?php echo ($vo['pid']); ?></td>
				<td><?php echo ($vo['ip']); ?></td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</tbody>
	</table>
		</div>
	</div><?php endforeach; endif; else: echo "" ;endif; ?>

</div>

</div>