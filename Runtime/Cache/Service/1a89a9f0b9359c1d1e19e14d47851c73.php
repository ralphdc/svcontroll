<?php if (!defined('THINK_PATH')) exit();?><form id="pagerForm" action="/index.php/Service/Searchelem" method="post">
	<input type="hidden" name="pageNum" value="1"/>
	<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>
	<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
	<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
	<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
</form>

<div class="pageHeader">
	<form rel="pagerForm" method="post" action="/index.php/Service/Searchelem" onsubmit="return dwzSearch(this, 'dialog');">
	<div class="searchBar">
		<ul class="searchContent">
			<li>
				<label>元素ID名称:</label>
				<input class="textInput" name="elemId" value="<?php echo ($_REQUEST['elemId']); ?>" type="text">
			</li>
			<li>
				<label>元素名称:</label>
				<input class="textInput" name="elemName" value="<?php echo ($_REQUEST['elemName']); ?>" type="text">
			</li>
		</ul>
		<div class="subBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">查询</button></div></div></li>
				<li><div class="buttonActive"><div class="buttonContent"><button type="button" multLookup="orgId" warn="请选择产品">选择带回</button></div></div></li>
			</ul>
		</div>
	</div>
	</form>
</div>
<div class="pageContent">
	<table class="table" targetType="dialog" layoutH="112" width="100%">
		<thead>
			<tr>
				<th width="30"><input type="checkbox" class="checkboxCtrl" group="orgId" /></th>
				<th>元素ID</th>
				<th>元素名称</th>
			</tr>
		</thead>
		<tbody>
		<?php
 if(is_array($list) && count($list)) { foreach($list as $key=>$val) { $valueStr = "{id:'".$val['id']."',name:'".$val['elemName']."'}"; echo '<tr><td><input type="checkbox" name="orgId" value="'.$valueStr.'"/></td><td>'.$val['id'].'</td><td>'.$val['elemName'].'</td></tr>'; } } ?>
		</tbody>
	</table>

	<div class="panelBar">
		<div class="pages">
			<span>显示</span>
			<select class="combox" name="numPerPage" onchange="dialogPageBreak({numPerPage:this.value})">
				<?php
 $numPerPageArr = array(20,50,100,200); foreach($numPerPageArr as $val) { if($val == $numPerPage) $selected = 'selected'; echo '<option value="'.$val.'" '.$selected.'>'.$val.'</option>'; $selected = ''; } ?>
			</select>
			<span>条，共<?php echo ($totalCount); ?>条</span>
		</div>
		<div class="pagination" targetType="dialog" totalCount="<?php echo ($totalCount); ?>" numPerPage="<?php echo ($numPerPage); ?>" pageNumShown="5" currentPage="<?php echo ($currentPage); ?>"></div>
	</div>
</div>