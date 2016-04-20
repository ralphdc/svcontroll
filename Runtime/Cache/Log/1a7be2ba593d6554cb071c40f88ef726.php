<?php if (!defined('THINK_PATH')) exit();?><form id="pagerForm" action="/index.php/Log/CallChain" method="post">
	<input type="hidden" name="pageNum" value="1"/>
	<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>
	<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
	<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
	<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
</form>


<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return navTabSearch(this);" action="/index.php/Log/CallChain" method="post">
	<div class="searchBar">
		<ul class="searchContent">
			<li>
			<label>商户号：</label>
			<input  style="width:30px;" type="text" value="<?php echo ($_REQUEST['mno']); ?>" id="mno" name="mno" class="textInput">
			</li>	
			<li>
			<label>商户名称：</label>
			<input  style="width:30px;" type="text" value="<?php echo ($_REQUEST['mname']); ?>" id="mname" name="mname" class="textInput">
			</li>
			<li>
			<label>操作类型：</label>
			<input  style="width:30px;" type="text" value="<?php echo ($_REQUEST['ctype']); ?>" id="ctype" name="ctype" class="textInput">
			</li> 
			<!-- <li>
			<label>流程ID ：</label>
			<input  style="width:30px;" type="text" value="<?php echo ($_REQUEST['fid']); ?>" id="fid" name="fid" class="textInput">
			</li>-->
			<li>
			<label>终端号：</label>
			<input  style="width:30px;" type="text" value="<?php echo ($_REQUEST['tno']); ?>" id="tno" name="tno" class="textInput">
			<input type="hidden" value="<?php echo ($_REQUEST['type']); ?>" name="type" />
			<input type="hidden" value="5" name="fromsearch" />
			</li>
			<li>
			<label>操作员：</label>
			<input  style="width:30px;" type="text" value="<?php echo ($_REQUEST['user']); ?>" id="user" name="user" class="textInput">
			</li>
			<li>
				<label>时间（起）：</label>
				<input size="19" maxDate="<?php echo date('Y-m-d'); ?>" type="text" value="<?php echo ($_REQUEST['startTime']); ?>" id="startTime" name="startTime" readonly="true" datefmt="yyyy-MM-dd HH:mm:ss" class="date textInput readonly">
			</li>
			<li>
				<label>时间（终）：</label>
				<input size="19" maxDate="<?php echo date('Y-m-d'); ?>" type="text" value="<?php echo ($_REQUEST['endTime']); ?>" id="endTime" name="endTime" readonly="true" datefmt="yyyy-MM-dd HH:mm:ss" class="date textInput readonly">
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

<table class="table" width="100%" layoutH="110">
		<thead>
		<tr>
			<th>编号</th>
			<th>用户登录名</th>
			<th>用户名</th>
			<th>商户号</th>
			<th>商户名</th>
			<th>终端号</th>
			<th>操作类型</th>
			<th>任务名称</th>
			<th>记录时间</th>
			<th>修改信息内容</th>
			<th>日志消息</th>
		</tr>
		</thead>
		<tbody>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr target="sid_user" rel="<?php echo ($vo['id']); ?>">
				<td>
					<?php
 $listnums = $numPerPage * ($currentPage-1) + $key+1; echo $listnums; ?>
				</td>
				<td><?php echo ($vo['user']); ?></td>
				<td><?php echo ($vo['uname']); ?></td>
				<td><?php echo ($vo['mno']); ?></td>
				<td><?php echo ($vo['mname']); ?></td>
				<td><?php echo ($vo['tno']); ?></td>
				<td><?php echo ($vo['ctype']); ?></td>
				<td><?php echo ($vo['tid']); ?></td>
				<td><?php echo ($vo['logtime']); ?></td>
				<td><?php echo ($vo['con']); ?></td>
				<td><a height="563" width="524" mask="true" rel="see_info_win5" title="查看信息" target="dialog" href="/index.php?s=/Log/QueryHistoryLog/showinfo/id/<?php echo ($vo['id']); ?>/type/5/ltype/5"><?php echo substr($vo['msg'],0,30);?></a></td>
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