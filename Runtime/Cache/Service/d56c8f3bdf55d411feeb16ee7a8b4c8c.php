<?php if (!defined('THINK_PATH')) exit();?><style type="text/css">
	.warn{float:left;display:block;line-height: 20px; margin-top:5px; width: 22px; height: 20px;}
	.warnnumber h1{padding-top: 4px;}
	.info h1{margin-top: 6px;}
</style>

<div class="pageContent">
		<div class="tabs" currentIndex="0" eventType="click">
			<div class="tabsHeader">
				<div class="tabsHeaderContent">
					<ul>
						<li>
							<a href="javascript:;">
								<span>详细信息</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="tabsContent warnnumber">
				<table class="list" width="100%" layoutH="50">
						<tbody>
							<thead>
								<th><h1>告警元素</h1></th>
								<th><h1>IP</h1></th>
								<th><h1>告警信息</h1></th>
								<th><h1>告警时间</h1></th>
								<th class="center"><h1>备注</h1></th>
							</thead>
							<?php if(is_array($sdetail)): $i = 0; $__LIST__ = $sdetail;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($vo['element']); ?></td>
								<td><?php echo ($vo['ip']); ?></td>
								<td><?php echo ($vo['info']); ?></td>
								<td><?php echo ($vo['time']); ?></td>
								<td><?php echo ($vo['remark']); ?></td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
			</div>
			<div class="tabsFooter">
				<div class="tabsFooterContent"></div>
			</div>
		</div>
</div>