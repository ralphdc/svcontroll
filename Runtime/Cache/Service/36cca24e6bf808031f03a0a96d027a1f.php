<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">
		<table class="list" layoutH="50" width="100%">
		<thead>
			<tr>
				<th>告警元素</th>
				<th>告警信息</th>
				<th>告警时间</th>
				<th>备注</th>
			</tr>
		</thead>
		<tbody>
			<?php if(is_array($sinfo)): $i = 0; $__LIST__ = $sinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
					<td><?php echo ($vo['element']); ?></td>
					<td><?php echo ($vo['info']); ?></td>
					<td><?php echo ($vo['time']); ?></td>
					<td><?php echo ($vo['remark']); ?></td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</tbody>
	</table>
</div>