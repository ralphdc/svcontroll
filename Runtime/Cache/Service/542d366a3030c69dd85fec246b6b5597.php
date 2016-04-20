<?php if (!defined('THINK_PATH')) exit();?><form id="pagerForm" action="/index.php/Service/Deployment" method="post">
	<input type="hidden" name="pageNum" value="1"/>
	<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>
	<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
	<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
	<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
</form>



<div class="pageHeader" style="background-color: #efefef;">
	<form rel="pagerForm" onsubmit="return navTabSearch(this);" action="/index.php/Service/Deployment" method="post">
	<div class="searchBar">
		
		<div class="subBar">
		
		</div>
	</div>
	</form>
</div>
<div class="pageContent">
	<div class="panelBar" style="height:29px;">
		<ul class="toolBar">
			<li><a class="add" href="/index.php/Service/Deployment/add" title="新增" target="dialog" mask="true" height="400" width="500"><span>新增</span></a></li>
			<li class="line">line</li>
			<li><a title="初始化机器" class="edit" href="javascript:void(0);" id="initMechine"><span>初始化机器</span></a></li>
			<li class="line">line</li>
			<li><a title="执行命令" class="edit" href="javascript:void(0);" id="executOrder"><span>执行命令</span></a></li>
			<li class="line">line</li>
			<li><a title="历史记录" rel="D60666" target="navTab" class="edit" href="/index.php/Service/Repertscrhis/index/type/1"><span>查看历史记录</span></a></li>
			
		</ul>
	</div>

	<table class="table" width="100%" layoutH="138">
		<thead>
		<tr>
			<th class="center" style="width: 43px; cursor: default;"><div title="" class="gridCol"><input type="checkbox" class="checkboxCtrl" group="ids"></div></th>
			<th width="60">序号</th>
			<th width="60">类型</th>
			<th width="120">脚本名称</th>
			<th width="120">功能描述</th>
			<th width="150">储存路径</th>
			<th width="120">参数说明</th>
			<th width="120">执行前缀</th>
			<th width="80">操作</th>
		</tr>
		</thead>
		<tbody>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr target="sid_user" rel="<?php echo ($vo['smId']); ?>">
				<td class="center" style="width: 43px;"><div><input type="checkbox" value="<?php echo ($vo['smId']); ?>" name="ids"></div></td>
				<td>
					<?php
 $listnums = $numPerPage * ($currentPage-1) + $key+1; echo $listnums; ?>
				</td>
				<td><?php echo ($typeProp[$vo['smTyProperty']]); ?></td>
				<td><?php echo ($vo['smName']); ?></td>
				<td title="<?php echo ($vo['smFunction']); ?>"><?php echo (substr($vo['smFunction'],0,25)); ?></td>
				<td><?php echo ($vo['smAddress']); ?></td>
				<td title="<?php echo ($vo['smParameters']); ?>"><?php echo ($vo['smParameters']); ?></td>
				<td><?php echo ($vo['smDemo']); ?></td>
				<td><a class="btnDel" target="ajaxTodo" title="确实要删除这条记录吗" href="/index.php/Service/Deployment/delete/script_id/<?php echo ($vo['smId']); ?>">删除</a><a height="400" width="500" target="dialog" rel="fitting_index1" class="btnEdit" title="编辑" href="/index.php/Service/Deployment/edit/script_id/<?php echo ($vo['smId']); ?>">编辑</a></td>
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

<script type="text/javascript">
<!--
	$(function(){
		$('#initMechine').click(function(){
			var temparr = [];
			$("input:checkbox[name='ids']:checked").each(function(){
		    	temparr.push($(this).val());
		     });
			var temstr =  temparr.join(',');
			if(temstr == '' || temstr == null || temstr == undefined)
			{
				alertMsg.error('请勾选初始化机器的脚本');
			}else{
	            $.pdialog.open('/index.php/Service/Deployment/call/scriptid/'+temstr, 'initMechine',"初始化机器", {
	                mask: true,
	                width: 543,
	                height: 620
	            });
			}
			
		});
		
		
		$('#executOrder').click(function(){
			
	            $.pdialog.open('/index.php/Service/Deployment/excuteorder', 'executOrder',"执行命令", {
	                mask: true,
	                width: 936,
	                height: 620
	            });
			})
	})
	
//-->
</script>