<?php if (!defined('THINK_PATH')) exit();?><form id="pagerForm" action="/index.php/Service/Historyquery/search" method="post">
	<input type="hidden" name="pageNum" value="1"/>
	<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>
	<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
	<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
	<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
    </volist>
</form>
<div class="pageHeader">
	<div class="item_list_filter"  style="padding-left:20px">
		<form rel="pagerForm" action="/index.php/Service/Historyquery/search" method="post" onsubmit="return divSearch(this, 'hQuery_content');">
	<div class="searchBar">
		<table class="searchContent">
			<span class="">IP地址：</span>
			<input type="hidden" size="15" name="id" id="" class="textInput"  value="<?php echo ($_REQUEST[id]); ?>"/>	
			<input type="text" size="15" name="ip" id="" class="textInput"  value="<?php echo ($_REQUEST[ip]); ?>"/>			
			<span class="">服务名称：</span>
			<input type="text" size="15" name="serviceName" id="" class="textInput"  value="<?php echo ($_REQUEST[serviceName]); ?>"/>
			<span class="">元素ID：</span>
			<input type="text" size="15" name="elemId" id="" class="textInput" value="<?php echo ($_REQUEST[elemId]); ?>"/>
			<span class="">报警时间：</span>
			<input size="20" type="text" value="<?php echo ($_REQUEST['start']); ?>" id="start" name="start" readonly="true" datefmt="yyyy-MM-dd HH:mm:ss" class="date textInput">
			<span class="">至：</span>
			<input size="20" type="text" value="<?php echo ($_REQUEST['end']); ?>" id="end" name="end" readonly="true" datefmt="yyyy-MM-dd HH:mm:ss" class="date textInput">							
			<input type="submit" value="查询" class="ui_btn_green" />
		</table>
	</div>
		</form>
	</div>
</div>

<div class="pageContent">
	<div id="hQuery_list">
		<div class="tableList" layouth="83">
			<table class="list tac" width="100%">
				<thead>
					<tr>
						<th>序号</th>
						<th>seqID</th>
						<th>IP地址</th>
						<th>服务</th>
						<th>元素名称</th>
						<th>元素ID</th>
						<th>状态</th>
						<th>邮件通知</th>
						<th>手机通知</th>
						<th>备注</th>
						<th>报警时间</th>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr target="script_id" rel="<?php echo ($vo['id']); ?>">
							<td>
								<?php
 $listnums = $numPerPage * ($currentPage-1) + $key+1; echo $listnums; ?>
							</td>
							<td><?php echo ($vo['id']); ?></td>
							<td><?php echo ($vo['ip']); ?></td>
							<td><?php echo ($vo['serviceName']); ?></td>
							<td><?php echo ($vo['elemName']); ?></td>
							<td><?php echo ($vo['elemId']); ?></td>
							<td><?php echo ($status[$vo['isNotified']]); ?></td>
							<td><?php echo ($vo['email']); ?></td>
							<td><?php echo ($vo['mobile']); ?></td>	
							<td><?php echo ($vo['remark']); ?></td>
							<td><?php echo ($vo['warnTime']); ?></td>								
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>					
				</tbody>
			</table>
		</div>
		<div class="panelBar">
			<div class="pages">
				<span>共<?php echo ($totalCount); ?>条</span>
			</div>
			<div class="pagination" rel="hQuery_content" totalCount="<?php echo ($totalCount); ?>" numPerPage="<?php echo ($numPerPage); ?>" pageNumShown="5" currentPage="<?php echo ($currentPage); ?>"></div>
		</div>
	</div>
</div>