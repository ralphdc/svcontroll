<?php if (!defined('THINK_PATH')) exit();?><div class="table_list_tit">进程状态</div>
<div class="tableList" layouth="73">
	<table class="list tac" width="100%">
		<thead>
			<tr>
				<th>序号</th>
				<th>IP地址</th>
				<th>服务名</th>
				<th>服务版本</th>
				<th>部署路径</th>
				<th>端口号</th>
				<th>进程号</th>
				<!-- <th>MD5</th>
				<th>开始时间</th>
				<th>运行时长</th> -->
				<th width="120">&nbsp;&nbsp;&nbsp;&nbsp;操&nbsp;作&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<?php if(is_array($result)): $i = 0; $__LIST__ = $result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr  title="双击查看该服务的调度历史" ondblclick="javascript:jumptohistroy(this);" rels="<?php echo ($vo['name']); ?>|<?php echo ($vo['ip']); ?>|<?php echo ($vo['ver']); ?>|<?php echo ($vo['path']); ?>|<?php echo ($serviceid); ?>">
				<td>
					<?php
 $listnums = $numPerPage * ($currentPage-1) + $key+1; echo $listnums; ?>
				</td>
				<td><?php echo ($vo['ip']); ?></td>
				<td><?php echo ($vo['name']); ?></td>
				<td><?php echo ($vo['ver']); ?></td>
				<td><?php echo ($vo['path']); ?></td>
				<td><?php echo ($vo['port']); ?></td>
				<td><?php echo ($vo['pid']); ?></td>
				<!-- <td>jkfjskfjs12fslfks</td>
				<td>2014-09-08<br />08:20:30</td>
				<td>25小时30分</td> -->
				<td>
					<a href="/index.php/Service/Schedhistroy/shutdownser/?&servicename=<?php echo ($vo['name']); ?>&version=<?php echo ($vo['ver']); ?>&ipv=<?php echo ($vo['ip']); ?>&processnum=<?php echo ($vo['pid']); ?>&path=<?php echo ($vo['path']); ?>&serviceid=<?php echo ($serviceid); ?>" target="dialog" title="关闭服务" rel="sermonitor_program_win" mask="true" width="500" height="500" class="btnEdit">作业计划管理</a>
					<a href="/index.php/Service/Schedhistroy/Seemoniconfigure/?&ipv=<?php echo ($vo['ip']); ?>&path=<?php echo ($vo['path']); ?>&serviceid=<?php echo ($serviceid); ?>&version=<?php echo ($vo['ver']); ?>&servicename=<?php echo ($vo['name']); ?>" target="dialog" title="查看配置" rel="see_config_win" mask="true" width="500" height="500" class="btnInfo"></a>
					<a href="/index.php/Service/Schedhistroy/serviceRestart/?&ipv=<?php echo ($vo['ip']); ?>&path=<?php echo ($vo['path']); ?>&processnum=<?php echo ($vo['pid']); ?>&version=<?php echo ($vo['ver']); ?>&servicename=<?php echo ($vo['name']); ?>" target="dialog" title="重启服务" rel="see_config_win" mask="true" width="500" height="500" class="btnRestart"></a>
				</td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</tbody>
	</table>
</div>
<script>
function jumptohistroy(trobj)
{
	var params =  $(trobj).attr("rels");
	//先获取对应的pnid
	$.post("/index.php/Service/Sermonitor/getpnid",{params:params},function(data){
		navTab.openTab('D60620','/index.php/Service/Schedhistroy?&pnid='+Number(data)+'&deleteflag=1',{title: '查看调度历史',fresh: true,external: false});	
	})
}
</script>