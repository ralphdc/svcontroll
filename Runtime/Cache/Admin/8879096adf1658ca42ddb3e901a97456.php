<?php if (!defined('THINK_PATH')) exit();?>
<form id="pagerForm" action="/index.php?s=/Admin/SysMonitor/showIplist" method="post">
	<input type="hidden" name="pageNum" value="1"/>

</form>

<div class="pageContent" style="width:100%">

<form method="post" action="/index.php?s=/Admin/SysMonitor/showIplist" class="pageForm required-validate" onsubmit="return dialogSearch(this)" novalidate="novalidate">
<div class="searchBar" style="margin-top:10px;">
	<ul class="searchContent">
		<li>
		<label>IP：</label>
		<input type="text" value="<?php echo ($_REQUEST['ipv']); ?>" id="ipv" name="ipv" class="textInput">
		</li>
		<li>
		<label>主机名：</label>
		<input type="text" value="<?php echo ($_REQUEST['hostname']); ?>" id="hostname" name="hostname" class="textInput">
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

<div class="panelBar">
	<ul class="toolBar">
		<li><a href="/index.php?s=/Admin/SysMonitor/setIp/ipv/{ipvs}" class="edit" target="ajaxTodo" callback="dialogAjaxDone" mask="true" title="确定设置此IP吗？"><span>确定</span></a></li>
	</ul>		
</div>
<table class="list tac " width="100%" layoutH="115">
	<thead>
		<tr>
		<th >序号 </th>
		<th >IP地址 </th>
		<th >主机名 </th>
		<th >用户名 </th>
		<th >操作 </th>
		</tr>
	</thead>
	<tbody class="head_search">
	<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr target="ipvs" rel="<?php echo ($vo['ipv']); ?>" >
		<td><?php echo ($i); ?></td>
		<td><?php echo ($vo['ipv']); ?></td>
		<td><?php echo ($vo['hostname']); ?></td>
		<td><?php echo ($vo['username']); ?></td>
		<td><input  type="radio" name='ipv' value="<?php echo ($vo['ipv']); ?>" <?php if(($vo['systemFlag']) == "1"): ?>checked<?php endif; ?> ></td>
		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	
	</tbody>

</table>
<div class="panelBar">
<div class="pages">
	<span>共<?php echo ($totalCount); ?>条</span>
</div>
<div class="pagination"  targetType="dialog" totalCount="<?php echo ($totalCount); ?>" numPerPage="<?php echo ($pageSize); ?>" pageNumShown="10" currentPage="<?php echo ($currentPage); ?>"></div>
</div>




<script type="text/javascript">


</script>