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
			<label>流水号 ：</label>
			<input type="text" value="<?php echo ($_REQUEST['cid']); ?>" id="cid" name="cid" class="textInput">
			<input type="hidden" value="<?php echo ($_REQUEST['type']); ?>" name="type" />
			</li>
			<li>
			<label>商户号 ：</label>
			<input type="text" value="<?php echo ($_REQUEST['merNo']); ?>" id="merNo" name="merNo" class="textInput">
			</li>
			<li>
			<label>终端号 ：</label>
			<input type="text" value="<?php echo ($_REQUEST['tmlNo']); ?>" id="tmlNo" name="tmlNo" class="textInput">
			</li>
			<li>
				<label>时间（起）：</label>
				<input size="20" maxDate="<?php echo date('Y-m-d'); ?>" type="text" value="<?php echo ($_REQUEST['startTime']); ?>" id="startTime" name="startTime" readonly="true" datefmt="yyyy-MM-dd HH:mm:ss" class="date textInput readonly">
			</li>
			<li>
				<label>时间（终）：</label>
				<input size="20" maxDate="<?php echo date('Y-m-d'); ?>" type="text" value="<?php echo ($_REQUEST['endTime']); ?>" id="endTime" name="endTime" readonly="true" datefmt="yyyy-MM-dd HH:mm:ss" class="date textInput readonly">
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

<table class="table" width="100%" layoutH="110">
		<thead>
		<tr>
			<th>编号</th>
			<th>流水号</th>
			<th>父调用链</th>
			<th>服务名</th>
			<th>记录时间</th>
			
		</tr>
		</thead>
		<tbody>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr target="sid_user" rel="<?php echo ($vo['id']); ?>">
				<td>
					<?php
 $listnums = $numPerPage * ($currentPage-1) + $key+1; echo $listnums; ?>
				</td>
				<td><a style="text-decoration:underline;color:green" rel="L30605" target="navTab" title="交易调用节点" href="/index.php/Log/CallChain/index/type/3/cid/<?php echo ($vo['pcid']); ?>/startTime/<?php echo $_REQUEST['startTime']?$_REQUEST['startTime']:date('Y-m-d H:i:s');?>/endTime/<?php echo $_REQUEST['endTime']?$_REQUEST['endTime']:date('Y-m-d H:i:s');?>/from/transchain"><?php echo ($vo['flow']); ?></a></td>
				<td><a style="text-decoration:underline;color:green" rel="L30605" target="navTab" title="交易调用节点" href="/index.php/Log/CallChain/index/type/3/cid/<?php echo ($vo['pcid']); ?>/startTime/<?php echo $_REQUEST['startTime']?$_REQUEST['startTime']:date('Y-m-d H:i:s');?>/endTime/<?php echo $_REQUEST['endTime']?$_REQUEST['endTime']:date('Y-m-d H:i:s');?>/from/transchain"><?php echo ($vo['pcid']); ?></a></td>
				
				<td><?php echo ($vo['srv']); ?></td>
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