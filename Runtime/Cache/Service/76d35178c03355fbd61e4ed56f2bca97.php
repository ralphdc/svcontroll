<?php if (!defined('THINK_PATH')) exit();?><style type="text/css">
.iconTbody{height:60px;}
</style>
<form id="pagerForm" action="/index.php/Service/Proicon" method="post">
	<input type="hidden" name="pageNum" value="1"/>
	<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>
	<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
	<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
	<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
</form>


<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return navTabSearch(this);" action="/index.php/Service/Proicon" method="post">
		<div class="searchBar">
			<ul class="searchContent">
				<li>
					<label>产品名称：</label>
					<input type="text" value="<?php echo ($_REQUEST['data']['pdName']); ?>" id="data-deviceName" name="data[pdName]" class="textInput">
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
<!-- 产品只能编辑，没有删除和新增功能~！2016-03-02 -->
<!-- 
	<div class="panelBar" style="height:29px;">
		<ul class="toolBar">
			<li>
				<a rel="addServer" class="add" href="/index.php/Service/Proicon/add"  title="新增" height="200" width="430" target="dialog" mask="true">
					<span>新增</span>
				</a>
			</li>
			<li class="line">line</li>
			<li><a posttype="string" title="确实要删除选中记录吗？" rel="ids" target="selectedTodo" class="delete" href="/index.php/Service/Proicon/deletebatch/"><span>批量删除选中</span></a></li>
			<li class="line">line</li>
		</ul>
	</div>
-->
	<table class="table" width="100%" layoutH="138" class="iconTtable">
		<thead>
		<tr>
			<!-- <th class="center" style="width: 43px; cursor: default;"><div title="" class="gridCol"><input type="checkbox" class="checkboxCtrl" group="ids"></div></th>  -->
			<th width="60">序号</th>
			<th width="300">产品名称</th>
			<th width="400">产品图标</th>
			<th>备注</th>
			<th width="105">操作</th>
		</tr>
		</thead>
		<tbody>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
				<!--<td class="center" style="width: 43px;"><div><input type="checkbox" value="<?php echo ($vo['deviceid']); ?>" name="ids"></div></td> -->
				<td><div style="padding-left:5px">
					<?php
 $listnums = $numPerPage * ($currentPage-1) + $key+1; echo $listnums; ?>
					</div>
				</td>
				<td><?php echo ($vo['pdName']); ?></td>
				<td class="iconTbody">
					<?php if(strlen($vo['pdIcon']) > 0 && file_exists('./Public/Images/jtopolg/'.$vo['pdIcon'])): ?>
					<div><img src="/Public/Images/jtopolg/<?php echo ($vo['pdIcon']); ?>" width="30" height="30" /></div>
					<?php else: ?><img src="/Public/Images/jtopolg/default.png" width="30" height="30" />
					<?php endif; ?>
				</td>
				<td><?php echo ((isset($vo['pdDemo']) && ($vo['pdDemo'] !== ""))?($vo['pdDemo']):""); ?></td>
				<td>
				<!--
					<a class="btnDel" target="ajaxTodo" title="确实要删除这条记录吗" href="/index.php/Service/Proicon/delete/id/<?php echo ($vo['deviceid']); ?>">删除</a> 
				-->
					<a target="dialog" rel="editServer" class="btnEdit" title="编辑" href="/index.php/Service/Proicon/edit/id/<?php echo ($vo['pdId']); ?>" height="200" width="430">编辑</a>
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