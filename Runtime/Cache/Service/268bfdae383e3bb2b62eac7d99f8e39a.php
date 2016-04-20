<?php if (!defined('THINK_PATH')) exit();?>	<div class="item_list_filter"  style="padding-left:20px">
		<form class="pagerForm" action="/index.php/Service/Batchprocess/search" method="post" onsubmit="return divSearch(this, 'task_content');">
			<span class="">服务名：</span>
			<input type="text" size="15" name="servicename" id="" class="textInput" value="<?php echo ($_REQUEST[servicename]); ?>" />
			<input type="hidden" name="id" id="id" value="<?php echo ($_REQUEST[id]); ?>" />
			<input style="margin-left:20px;" type="submit" value="查询" class="ui_btn_green" />
			<?php if($showbutton == 1): ?><a style="margin-left:50px;" title="部署" href="javascript:void(0);" id="deployment" ><input type="button" value="部署" class="ui_btn_green"/></a>
			<a style="margin-left:50px;" title="配置预览" rel="D61623" target="navTab" href="/index.php/Service/Seeconfigs/index/ptaskid/<?php echo ($ptaskid); ?>" ><input type="button" value="配置预览" class="ui_btn_green"/></a>
			<a style="margin-left:50px;" title="部署结果" rel="D61624" target="navTab" href="/index.php/Service/Seebatchres/index/ptaskid/<?php echo ($ptaskid); ?>" ><input type="button" value="查看部署结果" class="ui_btn_green"/></a><?php endif; ?>
			<form id="pagerForm" action="/index.php/Service/Batchprocess" method="post">
	<input type="hidden" name="pageNum" value="1"/>
	<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>
	<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
	<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
	<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
</form>

		</form>
	</div>
	<div id="repertory_list">
		<div class="tableList" layouth="83">
			<table class="list tac" width="100%" rel="task_content">
				<thead>
					<tr>
						<?php if($showbutton == 1): ?><th width="30"><input type="checkbox" class="checkboxCtrl" group="depId"/></th><?php endif; ?>
						<th>序号</th>
						<th>服务名</th>
						<th>版本</th>
						<th>类型</th>
						<th>功能描述</th>
						<th>main入口</th>
						<th>发布状态</th>
						<th>任务名称</th>
						<th>任务状态</th>
						<th>导入时间</th>
						<th>构建时间</th>
						<th>&nbsp;&nbsp;操&nbsp;作&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
					</tr>
				</thead>
				<tbody id="deploymentArr">
				<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($showbutton == 1): ?><tr target="script_id" rel="<?php echo ($vo['mwId']); ?>" onclick="checkboxs(this);">
							<td onclick="checkboxs1(this);">
								<input type="checkbox" name="depId" value="<?php echo ($vo['mwId']); ?>"/>
							</td>
				<?php else: ?>
					<tr target="script_id" rel="<?php echo ($vo['mwId']); ?>"><?php endif; ?>
							<td>
								<?php
 $listnums = $numPerPage * ($currentPage-1) + $key+1; echo $listnums; ?>
							</td>
							<td><?php echo ($vo['servicename']); ?></td>
							<td><?php echo ($vo['serviceversion']); ?></td>
							<td>
								<?php echo $servicetype[ $vo['servicetype'] ] ?>
							</td>
							<td><?php echo ($vo['servicefunction']); ?></td>
							<td title="<?php echo ($vo['javamain']); ?>"><?php echo (substr($vo['javamain'],0,7)); ?></td>
							<td <?php if($vo['deploymentFlag'] == 1){ echo 'style="color:red"';} elseif($vo['deploymentFlag'] =='2' && ($vo['desployenv'] == '1' || $vo['desployenv'] == '4')){ echo 'style="color:green;"';} ?>>
								<?php echo $deploymentFlagArr[$vo['deploymentFlag']] ?>
							</td>
							<td><?php echo ($vo['taskname']); ?></td>
							<td>
								<?php echo $taskstate[ $vo['taskstate'] ] ?>
							</td>
							<td><?php echo ($vo['importtime']); ?></td>
							
							<td><?php echo ($vo['buildtime']); ?></td>
							<td>
								<?php
 $btnclass = 'btnEdit'; if($vo['deploymentFlag'] =='2') { $btnclass = 'btnInfo'; } ?>
								<a rel="createconfig" href="/index.php/Service/Batchprocess/call/ptaskid/<?php echo ($vo['taskid']); ?>/mwId/<?php echo ($vo['mwId']); ?>/ssid/<?php echo ($vo['ssid']); ?>/sername/<?php echo ($vo['servicename']); ?>/deploymentFlag/<?php echo ($vo['deploymentFlag']); ?>/version/<?php echo ($vo['serviceversion']); ?>/defaultcfgid/<?php echo ($vo['defaultcfgid']); ?>/defaultcfg/<?php echo ($vo['defaultcfg']); ?>/desploypath/<?php echo base64_encode($vo['desploypath']) ?>" height="600" width="900" mask="true" class="<?php echo ($btnclass); ?> ml10" title="作业计划" target="dialog">调用</a>
								<a href="/index.php/Service/Batchprocess/del/id/<?php echo ($vo['mwId']); ?>/taskid/<?php echo ($vo['taskid']); ?>" target="ajaxTodo" title="确定要删除？" class="btnDel ml10">删除</a>
							</td>								
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>				
				</tbody>
			</table>
		</div>
		<div class="panelBar">
			<div class="pages">
				<span>共<?php echo ($totalCount); ?>条</span>
			</div>
			<div class="pagination" rel="task_content" totalCount="<?php echo ($totalCount); ?>" numPerPage="<?php echo ($numPerPage); ?>" pageNumShown="5" currentPage="<?php echo ($currentPage); ?>"></div>
		</div>
	</div>


<script>
	<!--
	function checkboxs(obj)
	{
		 var tempObj =  $(obj);
	     var nowObj =tempObj.find('input');
	     var checked = nowObj.attr('checked');
	     if(checked){
	  	   nowObj.removeAttr('checked');
	     }else{
	  	   nowObj.attr('checked','true');
	  	 }
	}
	function checkboxs1(obj)
	{
		 var tempObj =  $(obj);
	     var nowObj =tempObj.find('input');
		 var checked = nowObj.attr('checked');
	     if(checked){
	  	   nowObj.removeAttr('checked');
	     }else{
	  	   nowObj.attr('checked','true');
	  	 }
	}
	
	function jqchk(){  //jquery获取复选框值    
		  var chk_value =[];    
		 $('#deploymentArr').find('input').each(function(index,element){
			 var tempobj = $(element);
			 if($(element).attr('checked'))
			{
				 chk_value.push(tempobj.val());
			}
		  });    
		  return chk_value.length==0 ? '' : chk_value.join(',');    
		}    
	$(function(){
		$('#deployment').click(function(){
			//取得选中的checkbox的值
			$.post('/index.php/Service/Batchprocess/gobatchprocess/ptaskid/<?php echo ($ptaskid); ?>',{mwid:jqchk()},function(data){
				if(data.statusCode=="200") {
					alertMsg.correct("操作成功!");
				}else if(data.statusCode=="1"){
					alertMsg.error(data.message)
				}else{
					alertMsg.error("由于"+data.message+",部署失败!")
				}
			}, "json");

		})
	})
	-->
	
</script>