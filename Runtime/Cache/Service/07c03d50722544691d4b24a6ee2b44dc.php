<?php if (!defined('THINK_PATH')) exit();?><form id="pagerForm" action="/index.php/Service/Retrive" method="post">
	<input type="hidden" name="pageNum" value="1"/>
	<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>
	<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
	<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
	<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
</form>


<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return navTabSearch(this);" action="/index.php/Service/Retrive" method="post">
	<div class="searchBar">
		<ul class="searchContent">
			<li>
			<label>IP地址：</label>
			<input type="text" value="<?php echo ($_REQUEST['ipv']); ?>" id="ipv" name="ipv" class="textInput">
			<input type="hidden" id="cfginstanceid" name="cfginstanceid" value="<?php echo ($_REQUEST['cfginstanceid']); ?>">
			</li>
			<li>
			<label>服务名：</label>
			<input type="text" value="<?php echo ($_REQUEST['servicename']); ?>" id="servicename" name="servicename" class="textInput">
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
			 <li><a class="onekey" href="/index.php/Service/Retrive/retriveAll/ids/<?php echo ($idsStr); ?>" target="ajaxTodo" mask="true"  height="262" width="447"><span>一键恢复</span></a></li>
			<li><a class="selectedkey" posttype="string" rel="ids"  href="/index.php/Service/Retrive/retriveSelect/ids/{serviceInstanceId}" target="selectedTodo" mask="true" warn="请选择一条记录"><span>选择恢复</span></a></li> 
			<li class="line">line</li>
		</ul>
	</div>

	<table class="table" width="100%" layoutH="138">
		<thead>
		<tr>
			<th class="center" style="width: 43px; cursor: default;"><div title="" class="gridCol"><input type="checkbox" class="checkboxCtrl" group="ids"></div></th>
			<th width="60">序号</th>
			<th>服务名</th>
			<th>服务版本</th>
			<th>IP地址</th>
			<th>路径</th>
		</tr>
		</thead>
		<tbody>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr target="serviceInstanceId" rel="<?php echo ($vo['serviceInstanceId']); ?>">
				<td class="center" style="width: 43px;"><div><input type="checkbox" value="<?php echo ($vo['serviceInstanceId']); ?>" name="ids"></div></td>
				<td>
					<?php
 $listnums = $numPerPage * ($currentPage-1) + $key+1; echo $listnums; ?>
				</td>
				<td><?php echo ($vo['serviceName']); ?></td>
				<td><?php echo ($vo['serviceVersion']); ?></td>
				<td><?php echo ($vo['ipv']); ?></td>
				<td><?php echo ($vo['path']); ?></td>
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