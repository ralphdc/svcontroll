<?php if (!defined('THINK_PATH')) exit();?><form id="pagerForm" action="/index.php/Service/Mechinetype" method="post">
	<input type="hidden" name="pageNum" value="1"/>
	<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>
	<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
	<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
	<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
</form>


<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return navTabSearch(this);" action="/index.php/Service/Mechinetype" method="post">
	<div class="searchBar">
		<ul class="searchContent">
			<li>
			<label>类型编号：</label>
			<input type="text" value="<?php echo ($_REQUEST['stChar']); ?>" id="stChar" name="stChar" class="textInput">
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
			<li><a class="add" href="/index.php/Service/Mechinetype/add" title="新增" target="dialog" mask="true" height="315" width="454"><span>新增</span></a></li>
			<!-- <li><a class="edit" href="/index.php/Service/Mechinetype/edit/id/{sid_user}" target="dialog" mask="true" warn="请选择一条记录"><span>编辑</span></a></li> -->
			<li><a posttype="string" title="确实要删除选中记录吗？" rel="ids" target="selectedTodo" class="delete" href="/index.php/Service/Mechinetype/foreverdelete/id/{sid_user}"><span>批量删除选中</span></a></li>
			<li class="line">line</li>
		</ul>
	</div>

	<table class="table" width="100%" layoutH="138">
		<thead>
		<tr>
			<th class="center" style="width: 43px; cursor: default;"><div title="" class="gridCol"><input type="checkbox" class="checkboxCtrl" group="ids"></div></th>
			<th width="60">序号</th>
			<th width="60">类型编号</th>
			<th>型号名称</th>
			<th>功能描述</th>
			<th>备注 </th>
			<th width="80">操作</th>
		</tr>
		</thead>
		<tbody>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr target="sid_user" rel="<?php echo ($vo['stId']); ?>">
				<td class="center" style="width: 43px;"><div><input type="checkbox" value="<?php echo ($vo['stId']); ?>" name="ids"></div></td>
				<td>
					<?php
 $listnums = $numPerPage * ($currentPage-1) + $key+1; echo $listnums; ?>
				</td>
				<td><?php echo ($vo['stChar']); ?></td>
				<td><?php echo ($vo['stModel']); ?></td>
				<td><?php echo ($vo['stDec']); ?></td>
				<td><?php echo ($vo['stDemo']); ?></td>
				
				<td><a class="btnDel" target="ajaxTodo" title="确实要删除这条记录吗" href="/index.php/Service/Mechinetype/delete/id/<?php echo ($vo['stId']); ?>">删除</a><a height="315" width="454" target="dialog" rel="fitting_index1" class="btnEdit" title="编辑分析器" href="/index.php/Service/Mechinetype/edit/id/<?php echo ($vo['stId']); ?>">编辑</a></td>
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