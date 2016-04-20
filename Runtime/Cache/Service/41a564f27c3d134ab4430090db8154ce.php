<?php if (!defined('THINK_PATH')) exit();?><form id="pagerForm" action="/index.php/Service/Addmonelement" method="post">
	<input type="hidden" name="pageNum" value="1"/>
	<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>
	<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
	<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
	<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
</form>


<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return navTabSearch(this);" action="/index.php/Service/Addmonelement" method="post">
	<div class="searchBar">
		<ul class="searchContent">
			<li>
			<label>类型：</label>
			<select name="type">
				<option value=''>请选择</option>
				<?php if(is_array($resType) && !empty($resType)){ foreach ($resType as $tkey=>$tval) { if($tkey == $_REQUEST['type']) $selected = 'selected'; echo '<option value='.$tkey.' '.$selected.'>'.$tval.'</option>'; $selected =''; } }?>
				</select>
			</li>
			<li>
			<label>元素ID：</label>
			<input type="text" value="<?php echo ($_REQUEST['elemId']); ?>" id="elemId" name="elemId" class="textInput">
			</li>
			<li>
			<label>元素名称：</label>
			<input type="text" value="<?php echo ($_REQUEST['elemName']); ?>" id="elemName" name="elemName" class="textInput">
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
			<li><a class="add" href="/index.php/Service/Addmonelement/add" title="新增" target="dialog" mask="true" height="469" width="471"><span>新增</span></a></li>
			<li><a posttype="string" title="确实要删除选中记录吗？" rel="ids" target="selectedTodo" class="delete" href="/index.php/Service/Addmonelement/foreverdelete/id/{sid_user}"><span>批量删除选中</span></a></li>
			<li><a warn="请选择要设置的元素" title="设置元素通知人和方式" rel="setNoticeType" max="true" target="dialog" href="/index.php/Service/Addmonelement/setNoticeType/elementID/{sid_user}/pageNum/<?php echo ($currentPage); ?>" class="add"><span>设置元素通知人和方式</span></a></li>
			<li class="line">line</li>
		</ul>
	</div>

	<table class="table" width="100%" layoutH="138">
		<thead>
		<tr>
			<th class="center" style="width: 43px; cursor: default;"><div title="" class="gridCol"><input type="checkbox" class="checkboxCtrl" group="ids"></div></th>
			<th width="60">序号</th>
			<th>元素ID</th>
			<th>元素名称</th>
			<th>处理方式</th>
			<th>响应报警次数</th>
			<th>响应测试次数</th>
			<th>流量控制</th>
			<th>发信息数</th>
			<th>资源类型</th>
			<th>监控状态</th>
			<th>时间(起)</th>
			<th>时间(终)</th>
			<th>当前模式</th>
			<th>优先级别</th>
			<th width="100">操作</th>
		</tr>
		</thead>
		<tbody>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr target="sid_user" rel="<?php echo ($vo['id']); ?>">
				<td class="center" style="width: 43px;"><div><input type="checkbox" value="<?php echo ($vo['id']); ?>" name="ids"></div></td>
				<td>
					<?php
 $listnums = $numPerPage * ($currentPage-1) + $key+1; echo $listnums; ?>
				</td>
				<td><?php echo ($vo['id']); ?></td>
				<td><?php echo ($vo['elemName']); ?></td>
				<td><?php echo ($dealType[$vo['dealMode']]); ?></td>
				<td><?php echo ($vo['respWarnTimes']); ?></td>
				<td><?php echo ($vo['respTestTimes']); ?></td>
				<td><?php echo ($vo['flowInterval']); ?></td>
				<td><?php echo ($vo['msgNum']); ?></td>
				<td><?php echo ($vo['resName']); ?></td>
				<td><?php echo ($status[$vo['status']]); ?></td>
				<td><?php echo ($vo['start']); ?></td>
				<td><?php echo ($vo['end']); ?></td>
				<td><?php echo ($currmode[$vo['currMode']]); ?></td>
				<td><?php echo ($firstorno[$vo['priority']]); ?></td>
				<td>
				<a height="525" width="466" target="dialog" rel="fitting_index1" class="btnEdit" title="编辑开启或者关闭监控" href="/index.php/Service/Addmonelement/edit/id/<?php echo ($vo['id']); ?>/pageNum/<?php echo ($currentPage); ?>">编辑</a>
				<a href="/index.php/Service/Addmonelement/savepersons/?id=<?php echo ($vo['id']); ?>&pageNum=<?php echo ($currentPage); ?>" target="dialog" title="调试模式下分配人员" rel="see_people_win" mask="true"  max="true" class="btnAdd"></a>
				<a class="btnDel" target="ajaxTodo" title="确实要删除这条记录吗" href="/index.php/Service/Addmonelement/delete/id/<?php echo ($vo['id']); ?>">删除</a>
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