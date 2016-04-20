<?php if (!defined('THINK_PATH')) exit();?><link href="/Public/dwz/themes/css/zTreeStyle/zTreeStyle.css" rel="stylesheet" type="text/css" />
<script src="/Public/dwz/js/jquery.ztree.all-3.5.js" type="text/javascript"></script>
<form id="pagerForm" action="/index.php/Service/Schedhistroy" method="post">
	<input type="hidden" name="pageNum" value="1"/>
	<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>
	<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
	<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
	<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
</form>

<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return navTabSearch(this);" action="/index.php/Service/Schedhistroy" method="post">
		<div class="searchBar searchBar_adjust">
			<table class="searchContent">
				<tr>
					<td>
						<label>服务名称：</label>
						<input type="text" name="servicename" id="servicename" value="<?php echo ($_REQUEST['servicename']); ?>"  class="textInput" />
						<input type="hidden" name="isbatch" id="isbatch" value="<?php echo ($_REQUEST['isbatch']); ?>"  class="textInput" />
						<input type="hidden" name="pnid" id="pnid" value="<?php echo ($_REQUEST['pnid']); ?>"  class="textInput" />
						<input type="hidden" name="deleteflag" id="deleteflag" value="<?php echo ($_REQUEST['deleteflag']); ?>"  class="textInput" />
					</td>
					<td>
						<label>调度类型：</label>
						<select name="status" id="status">
							<?php
 $severStr = '<option value="">请选择</option>'; foreach($status as $skey=>$sval) { if($skey == $_REQUEST['status']) $selected = 'selected'; $severStr .='<option value="'.$skey.'" '.$selected.'>'.$sval.'</option>'; $selected = ''; } echo $severStr; ?>
						</select>
					</td>
					<td>
						<label>时间（起）：</label>
						<input type="text" value="<?php echo ($_REQUEST['startTime']); ?>" id="startTime" name="startTime" readonly="1" datefmt="yyyy-MM-dd" class="date textInput readonly">
					</td>
					<td>
						<label>时间（终）：</label>
						<input type="text" value="<?php echo ($_REQUEST['endTime']); ?>" id="endTime" name="endTime" readonly="1" datefmt="yyyy-MM-dd" class="date textInput readonly">
					</td>	
					<td rowspan="2"><div class="buttonActive"><div class="buttonContent"><button type="submit">查询</button></div></div>
					</td>
				</tr>
				<tr>
					<td>
						<label>部署类型：</label>
						<select name="type" id="type">
							<?php
 $disStr = '<option value="">请选择</option>'; foreach($distype as $dskey=>$dsval) { if($dskey == $_REQUEST['type']) $selected = 'selected'; $disStr .='<option value="'.$dskey.'" '.$selected.'>'.$dsval.'</option>'; $selected = ''; } echo $disStr; ?>
						</select>
					</td>
					<td>
						<label>调度状态：</label>
						<select name="result" id="result">
							<?php
 $resultStr = '<option value="">请选择</option>'; foreach($resultArr as $rekey=>$reval) { if($rekey == $_REQUEST['result']) $selected = 'selected'; $resultStr .='<option value="'.$rekey.'" '.$selected.'>'.$reval.'</option>'; $selected = ''; } echo $resultStr; ?>
						</select>
					</td>
					<td>
						<label>IP地址：</label>
						<input type="text" name="ipv" id="ipv" class="textInput" value="<?php echo ($_REQUEST['ipv']); ?>" />
					</td>
					<td>
						<label>操作人：</label>
						<input type="text" name="person" id="person" class="textInput" value="<?php echo ($_REQUEST['person']); ?>" />
					</td>
				</tr>
			</table>
		</div>
	</form>
</div>
	
<div class="tableList" layouth="120">
	<table id="scheduling_list" class="list tac" width="100%">
		<thead>
			<tr>
				<th>序号</th>
				<!-- <th>调度ID</th>
				<th>计划ID</th> -->
				<th>服务名</th>
				<th>IP地址</th>
				<th>调度类型</th>
				<th>部署类型</th>
				<th <?php if($_REQUEST['isbatch'] == 1) echo 'style="display:none"'; ?> >时间表达式</th>
				<th>调用次数</th>
				<th>成功次数</th>
				<th>失败次数</th>
				<th>部署路径</th>
				<th>部署组</th>
				<th>部署用户</th>
				<th>操作人</th>
				<th>调度状态</th>
				<th>操作时间</th>
				<th width="100">&nbsp&nbsp&nbsp&nbsp操 &nbsp&nbsp&nbsp&nbsp 作&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
			</tr>
		</thead>
		<tbody>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
				<td>
					<?php
 $listnums = $numPerPage * ($currentPage-1) + $key+1; echo $listnums; ?>
				</td>
				<!-- <td><?php echo ($vo['dispatchId']); ?></td>
				<td><?php echo ($vo['pnId']); ?></td> -->
				<td><?php echo ($vo['disServicename']); ?></td>
				<td><?php echo ($vo['disIpv']); ?></td>
				<td>
					<?php echo $status[$vo['disStatus']];?>
				</td>
				<td>
					<?php echo $distype[$vo['disType']];?>
				</td>
				<td <?php if($_REQUEST['isbatch'] == 1) echo 'style="display:none"'; ?>><?php echo ($vo['disCron']); ?></td>
				<td><?php echo ($vo['disTimes']); ?></td>
				<td><?php echo ($vo['disSuccess']); ?></td>
				<td><?php echo ($vo['disFail']); ?></td>
				<td><?php echo ($vo['disPath']); ?></td>
				<td><?php echo ($vo['disGroup']); ?></td>
				<td><?php echo ($vo['disOwner']); ?></td>
				<td><?php echo ($vo['disPerson']); ?></td>
				<?php if($vo['disResult'] == 1 ): ?><td style="color:red"><?php echo ($resultArr[$vo['disResult']]); ?></td>    
				<?php else: ?><td><?php echo ($resultArr[$vo['disResult']]); ?></td><?php endif; ?>
				<td><?php echo ($vo['disDate']); ?></td>
				<td>
					<?php if($deletflag == 1): ?><a href="/index.php/Service/Schedhistroy/program?&dispatchid=<?php echo ($vo['dispatchId']); ?>" target="dialog" title="作业计划修改" rel="scheduling_program_win" mask="true" width="500" height="500" class="btnEdit">重新部署启动关闭</a><?php endif; ?>
					<a href="/index.php/Service/Schedhistroy/Seeconfige/?&instanceid=<?php echo ($vo['instanceid']); ?>" target="dialog" title="查看最新配置" rel="see_config_win" mask="true" width="500" height="500" class="btnInfo"></a>
					<a href="/index.php/Service/Schedhistroy/Seelog/?&dispatchid=<?php echo ($vo['dispatchId']); ?>" target="dialog" title="查看日志" rel="see_log_win" mask="true" width="500" height="500" class="btnView"></a>
					<a href="/index.php/Service/Schedhistroy/Seepic/?&id=<?php echo ($vo['dispatchId']); ?>" target="dialog" title="查看配置快照" rel="see_pic_win" mask="true" width="500" height="500" class="btnAdd"></a>
				</td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</tbody>
	</table>
</div>


<div class="panelBar">
	<div class="pages">
		<span>共<?php echo ($totalCount); ?>条</span>
	</div>
	<div class="pagination" targetType="navTab" totalCount="<?php echo ($totalCount); ?>" numPerPage="<?php echo ($numPerPage); ?>" pageNumShown="5" currentPage="<?php echo ($currentPage); ?>"></div>
</div>

<script type="text/javascript">
/* $(function(){
	$('#scheduling_list tbody tr').contextmenu(function(e){
		var y=e.pageY+2,
			x=e.pageX+2,
			menu='<ul class="context_menu" style="left:'+(x+2)+'px;top:'+(y+2)+'px;"><li class="m_deploy disable">部署</li><li class="m_start">启动</li><li class="m_invalid">作废</li></ul>';
		$('body').append(menu);
		
		return false;
	});
	
	$('body').mousedown(function(event){
		if (!$(event.target).is('.context_menu') && $(event.target).closest('.context_menu').length==0) {
			$('.context_menu').remove();
		}
	});
}); */
</script>