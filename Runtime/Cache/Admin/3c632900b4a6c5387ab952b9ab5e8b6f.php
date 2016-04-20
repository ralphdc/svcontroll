<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent sortDrag" selector="h1" layoutH="15">
		
	<div class="panel collapse" minH="100" defH="570">
		<h1>服务列表</h1>
		<div>
			<table id="serviceList" class="list" width="98%">
				<thead>
					<tr>
						<th width="80">服务</th>
						<th>路径</th>
						<th>IP</th>
						<th>端口</th>
						<th>权重</th>
						<th>服务端GroupID</th>
						<th>客户端GroupID</th>
						<th>框架版本号</th>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($lists)): foreach($lists as $key=>$vo): if(is_array($vo)): foreach($vo as $key=>$vvo): ?><tr>
						<td bordercolor="#9900CC"><?php echo ($vvo['servicename']); ?></td>
						<td><?php echo ($vvo['path']); ?></td>
						<td><?php echo ($vvo['ip']); ?></td>
						<td><?php echo ($vvo['port']); ?></td>
						<td><?php echo ($vvo['weight']); ?></td>
						<td><?php echo ($vvo['providergrouid']); ?></td>
						<td><?php echo ($vvo['consumergroupid']); ?></td>
						<td><?php echo ($vvo['framework']); ?></td>
					</tr><?php endforeach; endif; endforeach; endif; ?>
				</tbody>
			</table>
		</div>
	</div>

</div>
<script type="text/javascript">

</script>