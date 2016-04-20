<?php if (!defined('THINK_PATH')) exit();?><div class="pagerListInfo">
	<form id="pagerForm" action="/index.php/Service/Mornode/queryTemplate" method="post">
		<input type="hidden" name="pageNum" value="1"/>
		<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>
		<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
		<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
		<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
	</form>
</div>

<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return dialogSearch(this);" action="/index.php/Service/Mornode/queryTemplate" method="post">
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
	<table class="table" width="100%" layoutH="138" class="iconTtable">
		<thead>
		<tr>
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
			<th>操作</th>
		</tr>
		</thead>
		<tbody>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
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
				<td><a title="选择" class="btnSelect" href="javascript:$.bringBack({id:<?php echo $vo['templateId']; ?>,tname:'<?php echo $vo['templateName']; ?>'})"></a></td>
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