<?php if (!defined('THINK_PATH')) exit();?>
<form id="pagerForm" action="/index.php?s=/Admin/SysMonitor/showIp" method="post">
	<input type="hidden" name="pageNum" value="1"/>

</form>
<div class="pageContent" style="width:100%">
<table class="searchContent" style="width:100%">
				<tr>
					<td width="50%">	
						<div class="searchBar" style="margin-top:10px;">
							<ul class="searchContent">
								<li>
								<label>当前可否切换：</label>
								<label>可以
								  <input type="radio" name="useable_setting" value="1" <?php if(($useable) == "1"): ?>checked="checked"<?php endif; ?>   />
								  </label>
								  <label>否
								  <input type="radio" name="useable_setting" value="2" <?php if(($useable) == "2"): ?>checked="checked"<?php endif; ?> />
								  </label>
								</li>
							</ul>
							<div class="subBar">
								<ul>
									<li><div class="buttonActive"><div class="buttonContent"><button type="button" id="cantoggle">设置</button></div></div></li>
								</ul>
							</div>
						</div>
					</td>
					<td width="50%">
							
					</td>
					</tr>
					</table>
</div>

<div class="panelBar">
	<ul class="toolBar">
		<li><a href="/index.php?s=/Admin/SysMonitor/showIplist" class="edit" rel="showIplist" target="dialog" mask="true" width="900" height="540" title="IP地址列表"><span>设置</span></a></li>
	</ul>		
</div>
<table class="list tac " width="100%" layoutH="118">
	<thead>
		<tr>
		<th >序号 </th>
		<th >IP地址 </th>
		<th >主机名 </th>
		<th >用户名 </th>
		</tr>
	</thead>
	<tbody class="head_search">
	<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr target="ipvs" rel="<?php echo ($vo['ipv']); ?>" >
		<td><?php echo ($i); ?></td>
		<td><?php echo ($vo['ipv']); ?></td>
		<td><?php echo ($vo['hostname']); ?></td>
		<td><?php echo ($vo['username']); ?></td>
		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	
	</tbody>

</table>
<div class="panelBar">
<div class="pages">
	<span>共<?php echo ($totalCount); ?>条</span>
</div>
<div class="pagination"  targetType="navTab" totalCount="<?php echo ($totalCount); ?>" numPerPage="<?php echo ($pageSize); ?>" pageNumShown="10" currentPage="<?php echo ($currentPage); ?>"></div>
</div>




<script type="text/javascript">
$("#cantoggle").click(function(){
		var setting = $("input[name='useable_setting']:checked").val();
	    $.ajax({
            type: 'POST',
            url: "/index.php?s=/Admin/SysMonitor/setUseable",
            data: "useable_setting="+setting,
            dataType: "json",
            cache: false,
            success: DWZ.ajaxDone,
            error: DWZ.ajaxError
        });
})

</script>