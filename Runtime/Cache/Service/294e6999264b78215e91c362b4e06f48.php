<?php if (!defined('THINK_PATH')) exit();?><style type="text/css">
.iconTbody{height:60px;}
</style>
<form id="pagerForm" action="/index.php/Service/Snmp" method="post">
	<input type="hidden" name="pageNum" value="1"/>
	<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>
	<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
	<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
	<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
</form>


<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return navTabSearch(this);" action="/index.php/Service/Snmp" method="post">
		<div class="searchBar">
			<ul class="searchContent">
				<li>
					<label>模板名称：</label>
					<input type="text" value="<?php echo ($_REQUEST['templateName']); ?>" id="templateName" name="templateName" class="textInput" placeholder="请输入模板名称" />
				</li>
				<li>
					<label>模板类型：</label>
					<select name="templateType" class="combox" onchange="switchVersion(this)">
						<option value="">请选择</option>
						<option value="1" <?php if($_REQUEST['templateType'] == 1): ?> selected="selected" <?php endif; ?>>V1/V2</option>
						<option value="3" <?php if($_REQUEST['templateType'] == 3): ?> selected="selected" <?php endif; ?>>V3</option>
					</select>
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
				<a rel="addSnmp" class="add" href="/index.php/Service/Snmp/list"  title="新增" height="480" width="450" target="dialog" mask="true">
					<span>新增</span>
				</a>
			</li>
			<li>
				<a posttype="string" title="确实要删除选中记录吗？" rel="templateIds" target="selectedTodo" class="delete" href="/index.php/Service/Snmp/batchdel/">
					<span>批量删除选中</span>
				</a>
			</li>
			
		</ul>
	</div>
	<table class="table" width="100%" layoutH="138" class="iconTtable">
		<thead>
		<tr>
			<th class="center" style="width: 43px; cursor: default;"><div title="" class="gridCol"><input type="checkbox" class="checkboxCtrl" group="templateIds"></div></th>
			<th width="60">序号</th>
			<th>模板名称</th>
			<th>模板类型</th>
			<th>读团体字</th>
			<th>写团体字</th>
			<th>用户名称</th>
			<th>上下文名称</th>
			<th>认证协议</th>
			<th>加密协议</th>
			<th>端口</th>
			<th>超时时间</th>
			<th>重试次数</th>
			<!-- <th>启用状态</th> -->
			<th width="105">操作</th>
		</tr>
		</thead>
		<tbody>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
				<td class="center" style="width: 43px;"><div><input type="checkbox" value="<?php echo ($vo['templateId']); ?>" name="templateIds"></div></td>
				<td>
					<?php
 $listnums = $numPerPage * ($currentPage-1) + $key+1; echo $listnums; ?>
				</td>
				<td><?php echo ($vo["templateName"]); ?></td>
				<td>
					<?php if($vo['templateType'] == 1): ?>
					V1/V2
					<?php else: ?>
					V3
					<?php endif; ?>
				</td>
				<td><?php echo ($vo['communityRead']); ?></td>
				<td><?php echo ($vo['communityWrite']); ?></td>
				<td><?php echo ($vo['userName']); ?></td>
				<td><?php echo ($vo['contextName']); ?></td>
				<td><?php echo ($vo['authProtocol']); ?></td>
				<td><?php echo ($vo['encryProtocol']); ?></td>
				<td><?php echo ($vo['port']); ?></td>
				<td><?php echo ($vo['timeout']); ?></td>
				<td><?php echo ($vo['retrys']); ?></td>
				<!-- <td><?php if($vo['enabled']): ?>启用<?php else: ?>停用<?php endif; ?></td> -->
				<td>
					<a class="btnDel" target="ajaxTodo" title="确实要删除这条记录吗" href="/index.php/Service/Snmp/delete/id/<?php echo ($vo['templateId']); ?>">删除</a>
					<a target="dialog" rel="editServer" class="btnEdit" title="编辑" href="/index.php/Service/Snmp/edit/id/<?php echo ($vo['templateId']); ?>"  mask="true" height="480" width="450">编辑</a>
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