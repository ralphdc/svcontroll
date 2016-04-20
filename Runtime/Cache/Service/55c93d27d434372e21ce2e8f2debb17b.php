<?php if (!defined('THINK_PATH')) exit();?><style type="text/css">
.iconTbody{height:60px;}
</style>
<form id="pagerForm" action="/index.php/Service/Mornode" method="post">
	<input type="hidden" name="pageNum" value="1"/>
	<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>
	<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
	<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
	<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
</form>


<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return navTabSearch(this);" action="/index.php/Service/Mornode" method="post">
		<div class="searchBar">
			<ul class="searchContent">
				<li>
					<label>IP：</label>
					<input type="text" value="<?php echo ($_REQUEST['ip']); ?>" id="data-ip" name="ip" class="textInput" placeholder="请输入IP或节点名" />
				</li>
				<li>
					<label>组名：</label>
					<input type="text" value="<?php echo ($_REQUEST['groupName']); ?>" id="data-gName" name="groupName" class="textInput" placeholder="请输入所属组名" />
				</li>
				<li>
					<label>是否可用：</label>
					<select name="enabled" id="data-enabled" class="combox">
						<option value="">请选择状态</option>
						<option value="true" <?php if($_REQUEST['enabled'] == 'true'): ?> selected="selected" <?php endif ?>>可用</option>
						<option value="false" <?php if($_REQUEST['enabled'] == 'false'): ?> selected="selected" <?php endif ?>>不可用</option>
					</select>
				</li>
				<li>
					<label>设备类型编号：</label>
					<input type="text" value="<?php echo ($_REQUEST['deviceType']); ?>" id="data-deviceType" name="deviceType" class="textInput" placeholder="请输入整数值" />
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

<div class="pageContent">
	<div class="panelBar" style="height:29px;">
		<ul class="toolBar">
			<li>
				<a rel="addMornode" class="add" href="/index.php/Service/Mornode/list"  title="新增" height="450" width="470" target="dialog" mask="true">
					<span>新增</span>
				</a>
			</li>
		</ul>
	</div>
	
	<table class="table" width="100%" layoutH="138" class="iconTtable">
		<thead>
		<tr>
			<th width="60">序号</th>
			<th>主机名称</th>
			<th>设备类型</th>
			<th>IP</th>
			<th>操作系统</th>
			<th>组名</th>
			<th>启用状态</th>
			<th>模板名称</th>
			<th width="105">操作</th>
		</tr>
		</thead>
		<tbody>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
				<td>
					<?php
 $listnums = $numPerPage * ($currentPage-1) + $key+1; echo $listnums; ?>
				</td>
				<td><?php if( intval($vo['status']) == 0 ): ?><img src="/Public/extend/yes.png" width="18" height="18" align="absmiddle" /><?php else: ?><img src="/Public/extend/no.png" width="18" height="18" align="absmiddle" /><?php endif; ?>&nbsp;<?php echo ($vo['hostName']); ?></td>
				<td><?php echo ($vo['deviceType']); ?></td>
				<td><?php echo ($vo['ip']); ?></td>
				<td><?php echo ($vo['osType']); ?></td>
				<td><?php echo ($vo['groupName']); ?></td>
				<td><?php if($vo['enabled']): ?><img src="/Public/extend/yes.png" width="18" height="18" /><?php else: ?><img src="/Public/extend/no.png" width="18" height="18" /><?php endif; ?></td>
				<td><?php echo ($vo['template']['templateName']); ?></td>
				<td>
					<a class="btnDel" target="ajaxTodo" title="确实要删除这条记录吗" href="/index.php/Service/Mornode/delete/id/<?php echo ($vo['nodeId']); ?>">删除</a>
					<a target="dialog" rel="editServer" class="btnEdit" title="编辑" href="/index.php/Service/Mornode/edit/id/<?php echo ($vo['nodeId']); ?>" mask="true" height="450" width="470">编辑</a>
				</td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</tbody>
	</table>
	<div class="panelBar">
		<div class="pages">
			<span>显示</span>
			<select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
				<?php
 $numPerPageArr = array(20,50,100,200); foreach($numPerPageArr as $val) { if($val == $numPerPage) $selected = 'selected'; echo '<option value="'.$val.'" '.$selected.'>'.$val.'</option>'; $selected = ''; } ?>
			</select>
			<span>条，共<?php echo ($totalCount); ?>条</span>
		</div>
		<div class="pagination" targetType="navTab" totalCount="<?php echo ($totalCount); ?>" numPerPage="<?php echo ($numPerPage); ?>" pageNumShown="5" currentPage="<?php echo ($currentPage); ?>"></div>
	</div>
</div>