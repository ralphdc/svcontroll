<?php if (!defined('THINK_PATH')) exit();?><div class="pagerListInfo">
	<form id="pagerForm" action="/index.php/Service/Mornode/queryServer" method="post">
		<input type="hidden" name="pageNum" value="1"/>
		<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>
		<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
		<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
		<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
	</form>
</div>

<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return dialogSearch(this);" action="/index.php/Service/Mornode/queryServer" method="post">
	<div class="searchBar">
		<ul class="searchContent">
			<li>
			<label>主机名：</label>
			<input type="text" value="<?php echo ($_REQUEST['hostname']); ?>" name="hostname" class="textInput">
			</li>
			<li>
			<label>IP地址：</label>
			<input type="text" value="<?php echo ($_REQUEST['ipv']); ?>" name="ipv" class="textInput">
			</li>
			<li>
			<label>所属环境：</label>
			<select name="environment" class="combox">					
				<option value="">请选择环境</option>
				<?php if(is_array($environment)): $i = 0; $__LIST__ = $environment;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$enviro): $mod = ($i % 2 );++$i; if($key == $_REQUEST['environment']): ?><option value="<?php echo ($key); ?>" selected><?php echo ($enviro); ?></option>
					<?php else: ?><option value="<?php echo ($key); ?>"><?php echo ($enviro); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
			</select>
			</li>
			<li>
			<label>主机类型：</label>
			<select name="isVirtual" class="combox">					
				<option value="">请选择</option>
				<?php if(is_array($virtual)): $i = 0; $__LIST__ = $virtual;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$virtualval): $mod = ($i % 2 );++$i; if($key == $_REQUEST['isVirtual']): ?><option value="<?php echo ($key); ?>" selected><?php echo ($virtualval); ?></option>
					<?php else: ?><option value="<?php echo ($key); ?>"><?php echo ($virtualval); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
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
	<table class="table" width="100%" layoutH="138">
		<thead>
		<tr>
			<th width="60">序号</th>
			<th>主机IP</th>
			<th>主机名</th>
			<th>主机类型</th>
			<th>所属环境</th>
			<th>所属产品</th>
			<th>设备类型</th>
			<th>宿主机名</th>
			<th width="105">操作</th>
		</tr>
		</thead>
		<tbody>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
				<td>
					<?php
 $listnums = $numPerPage * ($currentPage-1) + $key+1; echo $listnums; ?>
				</td>
				<td><?php echo ($vo['ipv']); ?></td>
				<td><?php echo ($vo['hostname']); ?></td>
				<td><?php echo ($vo['physicalVirtualType']); ?></td>
				<td><?php echo ($environment[$vo['environment']]); ?></td>
				<td><?php echo ($vo['product_names']); ?></td>
				<td><?php echo ($vo['deviceName']); ?></td>
				<td><?php echo ($vo['physicalName']); ?></td>
				<td>
					<a class="btnSelect" title="查找带回此值"  href="javascript:$.bringBack({'id':'<?php echo $vo['severid'] ?>','ip':'<?php echo $vo['ipv'] ?>'})" >选择</a>
				</td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
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