<?php if (!defined('THINK_PATH')) exit();?><div class="panel collapse" minH="100" defH="<?php $count = count($lists['providerlist']); $height = 40+30*$count; echo ($height<40)?40:$height; ?>">
		<h1>ice服务端</h1>
		<div>
			<table class="table list" width="98%">
				<thead>
					<tr>
						<th width="80">服务</th>
						<th>路径</th>
						<th>IP</th>
						<th>端口</th>
						<th>权重</th>
						<th>GroupID</th>
						<th>框架版本号</th>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($lists['providerlist'])): $i = 0; $__LIST__ = $lists['providerlist'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$providerlist): $mod = ($i % 2 );++$i;?><tr>
						<td><?php echo ($providerlist['servicename']); ?></td>
						<td><?php echo ($providerlist['path']); ?></td>
						<td><?php echo ($providerlist['ipv']); ?></td>
						<td><?php echo ($providerlist['port']); ?></td>
						<td><?php echo ($providerlist['weight']); ?></td>
						<td><?php echo ($providerlist['groupid']); ?></td>
						<td><?php echo ($providerlist['framework']); ?></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>	
				</tbody>
			</table>
		</div>
	</div>
	
	<div class="panel collapse" minH="100" defH="<?php $count = count($lists['consumerlist']); $height = 40+30*$count; echo($height<40)?40:$height; ?>">
		<h1>ice客户端</h1>
		<div>
			<table class="table list" width="98%">
				<thead>
					<tr>
						<th width="80">服务</th>
						<th>路径</th>
						<th>IP</th>
						<th>GroupID</th>
						<th>框架版本号</th>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($lists['consumerlist'])): $i = 0; $__LIST__ = $lists['consumerlist'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$consumerlist): $mod = ($i % 2 );++$i;?><tr>
						<td><?php echo ($consumerlist['servicename']); ?></td>
						<td><?php echo ($consumerlist['path']); ?></td>
						<td><?php echo ($consumerlist['ipv']); ?></td>
						<td><?php echo ($consumerlist['groupid']); ?></td>
						<td><?php echo ($consumerlist['framework']); ?></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>	
				</tbody>
			</table>
		</div>
	</div>