<?php if (!defined('THINK_PATH')) exit();?><form id="pagerForm" action="/index.php/Service/Servermanage" method="post">
	<input type="hidden" name="pageNum" value="1"/>
	<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>
	<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
	<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
	<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
</form>


<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return navTabSearch(this);" action="/index.php/Service/Servermanage" method="post">
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
	<div class="panelBar" style="height:29px;">
		<ul class="toolBar">
			<li><a rel="addServer" class="add" href="/index.php/Service/Servermanage/add" title="新增" height="715" width="540" target="dialog" mask="true"><span>新增</span></a></li>
			<!-- <li><a class="edit" href="/index.php/Service/Servermanage/edit/id/{sid_user}" target="dialog" mask="true" warn="请选择一条记录"><span>编辑</span></a></li> -->
			<li><a posttype="string" title="确实要删除选中记录吗？" rel="ids" target="selectedTodo" class="delete" href="/index.php/Service/Servermanage/foreverdelete/id/{sid_user}"><span>批量删除选中</span></a></li>
			<li class="line">line</li>
		</ul>
	</div>

	<table class="table" width="100%" layoutH="138">
		<thead>
		<tr>
			<th class="center" style="width: 43px; cursor: default;"><div title="" class="gridCol"><input type="checkbox" class="checkboxCtrl" group="ids"></div></th>
			<th width="60">序号</th>
			<th width="60">主机IP</th>
			<th>主机名</th>
			<th>主机类型</th>
			<th>所属环境</th>
			<th width="100">所属产品</th>
			<th>用户名</th>
			<th>服务器型号</th>
			<th>机房名称</th>
			<th>机柜信息</th>
			<th>操作系统</th>
			<th>设备类型</th>
			<!-- <th>物理机IP</th> -->
			<th>宿主机名</th>
			<th>远程控制卡</th>
			<th width="105">操作</th>
		</tr>
		</thead>
		<tbody>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr target="sid_user" rel="<?php echo ($vo['severid']); ?>">
				<td class="center" style="width: 43px;"><div><input type="checkbox" value="<?php echo ($vo['severid']); ?>" name="ids"></div></td>
				<td>
					<?php
 $listnums = $numPerPage * ($currentPage-1) + $key+1; echo $listnums; ?>
				</td>
				<td><?php echo ($vo['ipv']); ?></td>
				<td><?php echo ($vo['hostname']); ?></td>
				<td><?php echo ($vo['physicalVirtualType']); ?></td>
				<td><?php echo ($environment[$vo['environment']]); ?></td>
				<td><?php echo ($vo['product_names']); ?></td>
				<td><?php echo ($vo['username']); ?></td>
				<td><?php echo ($vo['st_char']); ?></td>
				<td><?php echo ($vo['ar_name']); ?></td>
				<td><?php echo ($vo['cabinetname']); ?></td>
				<td><?php echo ($vo['system']); ?></td>
				<td><?php echo ($vo['deviceName']); ?></td>
				<!-- <td><?php echo ($vo['virtualCorrespondPhysicalId']); ?></td> -->
				<td><?php echo ($vo['physicalName']); ?></td>
				<td><a href="<?php echo ($vo['controlcard']); ?>" title="点我查看远程控制卡" target="_blank" style="color:blue;"><?php echo ($vo['controlcard']); ?></a></td>
				<td>
					<a class="btnDel" target="ajaxTodo" title="确实要删除这条记录吗" href="/index.php/Service/Servermanage/delete/id/<?php echo ($vo['severid']); ?>">删除</a>
					<a target="dialog" rel="fitting_index1" class="btnEdit" title="编辑" href="/index.php/Service/Servermanage/edit/id/<?php echo ($vo['severid']); ?>" height="715" width="540">编辑</a>
					<!--  <a href="/index.php/Service/Servermanage/seemechine/id/<?php echo ($vo['severid']); ?>" target="dialog" title="详情" rel="see_mechine_win" mask="true" width="500" height="500" class="btnView"></a>  -->
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