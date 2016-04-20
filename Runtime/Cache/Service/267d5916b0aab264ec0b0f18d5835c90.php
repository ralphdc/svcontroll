<?php if (!defined('THINK_PATH')) exit();?><form id="pagerForm" action="/index.php/Service/Passmanage" method="post">
	<input type="hidden" name="pageNum" value="1"/>
	<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>
	<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
	<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
	<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
</form>


<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return navTabSearch(this);" action="/index.php/Service/Passmanage" method="post">
	<div class="searchBar">
		<ul class="searchContent">
			<li>
			<label>IP：</label>
			<input type="text" value="<?php echo ($_REQUEST['ipv']); ?>" id="ipv" name="ipv" class="textInput">
			</li>
			<li>
			<label>主机名：</label>
			<input type="text" value="<?php echo ($_REQUEST['hostname']); ?>" id="hostname" name="hostname" class="textInput">
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
			<li><a class="edit" href="/index.php/Service/Passmanage/exportexcell/param/<?php echo (base64_encode(json_encode($_REQUEST))); ?>" title="导出Excell"><span>导出成excell表格</span></a></li>

		</ul>
	</div>

	<table class="table" width="100%" layoutH="138">
		<thead>
		<tr>
			<th width="60">序号</th>
			<th>IP</th>
			<th>主机名</th>
			<th>用户名和密码(多个用户用|分隔)</th>
		</tr>
		</thead>
		<tbody>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr target="sid_user" rel="<?php echo ($vo['arId']); ?>">
				<td>
					<?php
 $listnums = $numPerPage * ($currentPage-1) + $key+1; echo $listnums; ?>
				</td>
				<td><?php echo ($vo['ipv']); ?></td>
				<td><?php echo ($vo['hostname']); ?></td>
				<td>
				<?php
 if(is_array($vo['child'])) { $tempArr = array(); foreach($vo['child'] as $key=>$val) { $tempArr[] =$val['usr_name'].' : '.$val['usr_psd']; } $tempStr = implode(" | ",$tempArr); echo $tempStr; } ?>
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