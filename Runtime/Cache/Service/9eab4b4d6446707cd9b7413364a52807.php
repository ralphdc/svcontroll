<?php if (!defined('THINK_PATH')) exit();?>	<form id="pagerForm" action="/index.php/Service/Repertory" method="post">
	<input type="hidden" name="pageNum" value="1"/>
	<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>
	<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
	<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
	<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
</form>


	<div id="repertory_content" layouth="0">
		<div class="item_list_filter" style="border-bottom:solid 1px #ddd;<?php if($enviroments==2) echo 'display:none'?>">
			<!-- form action="" method=""-->
				<span class="pro">svn路径：</span>
				<textarea name="svnlink" id="svnurl" style="width: 630px; height: 17px;"></textarea>
				<input type="submit" value="导入" class="ui_btn_green" id="svnbtn" />
				<a title="批量导入" width="1016" height="702"  rel="dlg_page2" target="dialog" href="/index.php/Service/Repertory/import" ><input type="submit" value="批量导入" class="ui_btn_green"/></a>
			<!--/form-->
		</div>
		<div class="item_list_filter" style="border-bottom:solid 1px #ddd;">
			<p>
			<span style="color:red;">红色表示任何环境都未发布</span>
			<?php if(intval($_SESSION['WEB_ENVIRONMENT']) == 4): ?>
			<span style="color:green">绿色表示测试环境已发布</span>
			<span>黑色表示测试镜像环境已发布</span>
			
			<?php endif; ?>
			<?php if(intval($_SESSION['WEB_ENVIRONMENT']) == 1): ?>
			<span style="color:green">绿色表示运维镜像环境已发布</span>
			<span>黑色表示生产环境已发布</span>
			<?php endif; ?>
			<?php if(intval($_SESSION['WEB_ENVIRONMENT']) == 3): ?>
			<span style="color:green">绿色表示测试环境已发布</span>
			<span>黑色表示测试镜像环境已发布</span>
			<?php endif; ?>
			<?php if(intval($_SESSION['WEB_ENVIRONMENT']) == 2): ?>
			<span style="color:green">绿色表示运维镜像环境已发布</span>
			<span>黑色表示生产环境已发布</span>
			<?php endif; ?>
			<?php if(intval($_SESSION['WEB_ENVIRONMENT']) == 5): ?>
			<span style="color:green">绿色表示测试环境与运维镜像环境已发布 </span>
			<span>黑色表示测试镜像与生产环境已发布</span>
			<?php endif; ?>
		</div>
		<div class="item_list_filter"  style="padding-left:20px">
			<form class="pagerForm" action="/index.php/Service/Repertory/search" method="post" onsubmit="return divSearch(this, 'repertory_content');">
				<span class="">产品名：</span>
				<input type="text" size="15" name="productname" id="" class="textInput" value="<?php echo ($_REQUEST[productname]); ?>"/>			
				<span class="">服务名：</span>
				<input type="text" size="15" name="servicename" id="" class="textInput" value="<?php echo ($_REQUEST[servicename]); ?>"/>
				<span class="">版本：</span>
				<input type="text" size="15" name="serviceversion" id="" class="textInput" value="<?php echo ($_REQUEST[serviceversion]); ?>"/>
				<span class="">MD5：</span>
				<input type="text" size="15" name="md5" id="" class="textInput" value="<?php echo ($_REQUEST[md5]); ?>"/>
				<input type="hidden" name="desployenv" value="<?php echo ($_REQUEST['desployenv']); ?>" />
				<span class="">状态：</span>
				<select name="deploymentFlag" id="" class="">
					<option value="" <?php if($_REQUEST[deploymentFlag]=="") echo "selected" ?> >全部</option>
					<option value="2" <?php if($_REQUEST[deploymentFlag]==2) echo "selected" ?> >已发布</option>
					<option value="1" <?php if($_REQUEST[deploymentFlag]==1) echo "selected" ?> >未发布</option>				
				</select>												
				<input type="submit" value="查询" class="ui_btn_green" />
				<a title="查看批量任务" rel="D60621" target="navTab" href="/index.php/Service/Tasklook/index" ><input type="submit" value="查看本次批量任务" class="ui_btn_green"/></a>
				<a title="设置显示列" width="473" height="512" mask="true"  rel="dlg_page3" target="dialog" href="/index.php/Service/Repertory/setshowcolum" ><input type="submit" value="设置显示列" class="ui_btn_green"/></a>
			</form>
		</div>
		<div id="repertory_list">
			<div class="tableList" layouth="<?php if($enviroments==2){ echo 88;}else{ echo 130;}?>">
				<table class="list tac" width="100%">
					<thead>
						<tr>
							<th width="30"><!-- <input type="checkbox" class="checkboxCtrl" group="orgId" onclick="checkTime2(this);"/> --></th>
							<th>序号</th>
							<?php if(is_array($showClums)): $ks = 0; $__LIST__ = $showClums;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vos): $mod = ($ks % 2 );++$ks; if(($ks == 'svnpath') ): ?><th width="50"><?php echo ($vos); ?></th>
								<?php else: ?> 
									<th><?php echo ($vos); ?></th><?php endif; endforeach; endif; else: echo "" ;endif; ?>
							<th>&nbsp;&nbsp;操&nbsp;作&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr target="script_id" rel="<?php echo ($vo['ssid']); ?>" onclick="checkTime(this);">
								<td>
									<?php
 $checked = ''; if(in_array($vo['mwId'],$metaIDArr)) $checked = "checked"?>
									<input onclick="checkTime1(this);" type="checkbox" name="orgId" <?php echo ($checked); ?> value="<?php echo ($vo['mwId']); ?>"/>
								</td>
								<td>
									<?php
 $listnums = $numPerPage * ($currentPage-1) + $key+1; echo $listnums; ?>
								</td>
								<?php if(array_key_exists('servicename',$showClums)): ?><td><?php echo ($vo['servicename']); ?></td><?php endif; ?>
								<?php if(array_key_exists('serviceversion',$showClums)): ?><td><?php echo ($vo['serviceversion']); ?></td><?php endif; ?>
								<?php if(array_key_exists('servicetype',$showClums)): ?><td>
									<?php echo $servicetype[ $vo['servicetype'] ] ?>
								</td><?php endif; ?>
								<?php if(array_key_exists('is_tool',$showClums)): ?><td>
									<?php echo $toolstype[ $vo['is_tool'] ] ?>
								</td><?php endif; ?>
								<?php if(array_key_exists('servicefunction',$showClums)): ?><td><?php echo ($vo['servicefunction']); ?></td><?php endif; ?>
								<?php if(array_key_exists('svnpath',$showClums)): ?><td style="line-height: 2.5;display:block;width:100px;overflow:hidden" title="<?php echo ($vo['svnpath']); ?>"><?php echo ($vo['svnpath']); ?></td><?php endif; ?>
								<?php if(array_key_exists('javamain',$showClums)): ?><td title="<?php echo ($vo['javamain']); ?>"><?php echo (substr($vo['javamain'],0,7)); ?></td><?php endif; ?>
								<?php if(array_key_exists('deploymentFlag',$showClums)): ?><td <?php if($vo['deploymentFlag'] == '未发布'){ echo 'style="color:red"';} elseif(($vo['deploymentFlag'] =='已发布' || $vo['deploymentFlag'] =='未发布至生产') && ($vo['desployenv'] == '1' || $vo['desployenv'] == '4')){ echo 'style="color:green;"';} ?>>
									<?php echo $vo['deploymentFlag']; ?>
								</td><?php endif; ?>
								<?php if(array_key_exists('importtime',$showClums)): ?><td><?php echo ($vo['importtime']); ?></td><?php endif; ?>
								<?php if(array_key_exists('buildtime',$showClums)): ?><td><?php echo ($vo['buildtime']); ?></td><?php endif; ?>
								<?php if(array_key_exists('md5',$showClums)): ?><td><?php echo ($vo['md5']); ?></td><?php endif; ?>
								<td>
									<a rel="sendplan" href="/index.php/Service/Repertory/call/mwId/<?php echo ($vo['mwId']); ?>/ssid/<?php echo ($vo['ssid']); ?>/sername/<?php echo ($vo['servicename']); ?>/version/<?php echo ($vo['serviceversion']); ?>/defaultcfgid/<?php echo ($vo['defaultcfgid']); ?>/defaultcfg/<?php echo ($vo['defaultcfg']); ?>/desploypath/<?php echo base64_encode($vo['desploypath']) ?>" height="600" width="900" mask="true" class="btnEdit ml10" title="作业计划" target="dialog">调用</a>
									<a class="btnInfo" rel="D60635" title="查看仓库记录" target="NavTab" href="/index.php/Service/Reperthistory/index/mwId/<?php echo ($vo['mwId']); ?>">查看历史</a>
									<a href="/index.php/Service/Repertory/del/id/<?php echo ($vo['mwId']); ?>" target="ajaxTodo" title="确定要删除？" class="btnDel ml10">删除</a>
									<?php if($vo['pro_visible'] != 2 and $enviroments == 1): ?><a href="/index.php/Service/Repertory/showiinproduct/id/<?php echo ($vo['mwId']); ?>" target="ajaxTodo" title="确定要在生产环境上进行显示？" class="btnView ml10">在生产上显示</a><?php endif; ?>
								</td>								
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>					
					</tbody>
				</table>
			</div>
			<div class="panelBar">
				<div class="pages">
					<span>共<?php echo ($totalCount); ?>条</span>
				</div>
				<div class="pagination" targetType="navTab" totalCount="<?php echo ($totalCount); ?>" numPerPage="<?php echo ($numPerPage); ?>" pageNumShown="5" currentPage="<?php echo ($currentPage); ?>"></div>
			</div>
		</div>
	</div></html>
<script>

//svn import
$('#svnbtn').click(function(){
	$.post('/index.php/Service/Repertory/importsvn'
			,{svnurl:$("#svnurl").val()}
			,function(data){
				if(data.statusCode=='1'){
					alertMsg.correct(data.message);
					 if (data.navTabId) {
				            navTab.reload(data.forwardUrl, {
				                navTabId: data.navTabId
				            });
					 }
					
				}else{
					alertMsg.error(data.message);
				}
			}
			,"json"
	)
})



var MetaIDArr = [];
var uniqueMetaIDArr = [];
function onlyUnique(value, index, self) { 
    return self.indexOf(value) === index;
}
uniqueMetaIDArr = MetaIDArr.filter( onlyUnique );
function checkTime(obj)
{
	//新增加点击行右边的树展开到对应的位置
	 var tempObj =  $(obj);
	 var value= parseInt(tempObj.attr('rel'));
	 repertory_tree.expandAll(false);
	var menode = repertory_tree.getNodeByTId('1');
	//repertory_tree.selectNode(menode);
	repertory_tree.expandNode(menode, true, null, null, false);
	 var nodecheck = repertory_tree.getNodeByParam("id", value,null);
	 repertory_tree.expandNode(nodecheck,true,true,true);
    var nowObj =tempObj.find('input');
    var checked = nowObj.attr('checked');
     if(checked){
	  	 $.ajax({ 
	  		async: false, 
	  		type : "POST",
	  		data:{bathval:nowObj.val(),type:1},
	  		url : "/index.php/Service/Repertory/bathprocess", 
	  		dataType : 'json', 
	  		success : function(data) { 
	  			if(data.status == 1)
		  		   {
		  			 	nowObj.removeAttr('checked');
		  		   }
	  		} 
	  		}); 
     }else{ 
	  	 $.ajax({ 
		  		async: false, 
		  		type : "POST",
		  		data:{bathval:nowObj.val(),type:2},
		  		url : "/index.php/Service/Repertory/bathprocess", 
		  		dataType : 'json', 
		  		success : function(data) { 
		  			if(data.status == 1)
			  		   {
		  				nowObj.attr('checked','true');
			  		   }
		  		} 
		  		}); 
  	 }
}
function checkTime1(obj)
{
	 var tempObj =  $(obj);
     var nowObj =tempObj;
	 var checked = nowObj.attr('checked');
     if(checked){
  	   nowObj.removeAttr('checked');
     }else{
  	   nowObj.attr('checked','true');
  	 }
}

/* var adIds = "";  
 $("input:checkbox[name=orgId]").each(function(i){  
     if(0==i){  
         adIds = $(this).val();  
     }else{  
         adIds += (","+$(this).val());  
     }  
 }); 

 function checkTime2(obj)
{
     var nowObj =$(obj);
	 var checked = nowObj.attr('checked');
     if(checked){
         $.post("/index.php/Service/Repertory/bathprocess",{bathval:0,bathvalStr:adIds,type:3},function(data){
	  	   },'json');
         
         $.ajax({ 
		  		async: false, 
		  		type : "POST",
		  		data:{bathval:0,bathvalStr:adIds,type:3},
		  		url : "/index.php/Service/Repertory/bathprocess", 
		  		dataType : 'json', 
		  		success : function(data) {} 
		  		}); 
         
     }else{ 
          $.post("/index.php/Service/Repertory/bathprocess",{bathval:0,bathvalStr:adIds,type:4},function(data){
	  	   },'json'); 
         $.ajax({ 
		  		async: false, 
		  		type : "POST",
		  		data:{bathval:0,bathvalStr:adIds,type:4},
		  		url : "/index.php/Service/Repertory/bathprocess", 
		  		dataType : 'json', 
		  		success : function(data) {} 
		  		}); 
  	 }
} */



</script>