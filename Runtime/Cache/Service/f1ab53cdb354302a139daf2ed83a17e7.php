<?php if (!defined('THINK_PATH')) exit();?><link href="/Public/dwz/themes/css/zTreeStyle/zTreeStyle.css" rel="stylesheet" type="text/css" />
<script src="/Public/dwz/js/jquery.ztree.all-3.5.js" type="text/javascript"></script>
<form id="pagerForm" action="/index.php/Service/Scheduling" method="post">
	<input type="hidden" name="pageNum" value="1"/>
	<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>
	<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
	<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
	<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
</form>

<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return navTabSearch(this);" action="/index.php/Service/Scheduling" method="post">
		<div class="searchBar searchBar_adjust">
			<table class="searchContent">
				<tr>
					<td>
						<label>服务名称：</label>
						<input type="text" name="servicename" id="servicename" value="<?php echo ($_REQUEST['servicename']); ?>"  class="textInput" />
					</td>
					<td>
						<label>服务类型：</label>
						<select name="servicetype" id="servicetype">
							<?php
 $severStr = '<option value="">请选择</option>'; foreach($servicetype as $skey=>$sval) { if($skey == $_REQUEST['servicetype']) $selected = 'selected'; $severStr .='<option value="'.$skey.'" '.$selected.'>'.$sval.'</option>'; $selected = ''; } echo $severStr; ?>
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
						<label>产品名：</label>
						<input type="text" name="product" id="product" class="textInput" value="<?php echo ($_REQUEST['product']); ?>" />
					</td>
					<td>
						<label>计划状态：</label>
						<select name="pnStatus" id="pnStatus">
							<?php
 $severStr = '<option value="">请选择</option>'; foreach($pnStatus as $pkey=>$pval) { if($pkey == $_REQUEST['pnStatus']) $selected = 'selected'; $severStr .='<option value="'.$pkey.'" '.$selected.'>'.$pval.'</option>'; $selected = ''; } echo $severStr; ?>
						</select>
					</td>
					<td>
						<label>计划添加者：</label>
						<input type="text" name="persion" id="persion" class="textInput" value="<?php echo ($_REQUEST['persion']); ?>" />
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
				<th>服务名</th>
				<th>服务类型</th>
				<th>产品名</th>
				<th>计划添加者</th>
				<th>是否有效</th>
				<th>计划状态</th>
				<th>添加时间</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
				<td>
					<?php
 $listnums = $numPerPage * ($currentPage-1) + $key+1; echo $listnums; ?>
				</td>
				<td><?php echo ($vo['pnService']); ?></td>
				<td><?php echo ($servicetype[$vo['pnType']]); ?></td>
				<td><?php echo ($vo['pnProduct']); ?></td>
				<td><?php echo ($vo['pnPersion']); ?></td>
				<?php if($vo['deleteflag'] == 2 ): ?><td style="color:red"><?php echo ($deleteflag[$vo['deleteflag']]); ?></td>    
				<?php else: ?><td><?php echo ($deleteflag[$vo['deleteflag']]); ?></td><?php endif; ?>
				<?php if($vo['pnStatus'] == 1 ): ?><td style="color:red"><?php echo ($pnStatus[$vo['pnStatus']]); ?></td>    
				<?php else: ?><td><?php echo ($pnStatus[$vo['pnStatus']]); ?></td><?php endif; ?>
				<td><?php echo ($vo['pnDate']); ?></td>
				<td>
					<!-- <a href="/index.php/Service/Scheduling/view" target="dialog" title="配置文件预览" rel="" mask="true" width="900" height="400" class="btnView">配置文件预览</a> -->
					<a href="/index.php/Service/Schedhistroy?&pnid=<?php echo ($vo['pnId']); ?>&deleteflag=<?php echo ($vo['deleteflag']); ?>" target="NavTab" title="查看调度历史" rel="D60620" class="btnInfo">历史展示</a>
					<!-- <a href="/index.php/Service/Scheduling/del" target="ajaxTodo" title="确定要删除？" class="btnDel">删除</a> -->
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