<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent sortDrag" selector="h1" layoutH="42">
	<input name="treessname" value="<?php echo ($_REQUEST['servicename']); ?>" type='hidden'/>
		<?php if(!empty($lists['instancelist'])): ?><div class="panel" minH="40" defH="<?php $count = count($lists['instancelist']); $heigth = 40+35*$count; echo $heigth; ?>" >
		<div>
			<table class="list" width="98%">
				<thead>
					<tr>
						<th width="80">服务</th>
						<th width="280">路径</th>
						<th>IP</th>
						<th>端口</th>
						<th>权重</th>
						<th width="50">服务GroupID</th>
						<th width="50">客户GroupID</th>
						<th>版本</th>
						<th>PID</th>
						<th>框架版本号</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody id="instancelist">
				<?php if(is_array($lists['instancelist'])): $i = 0; $__LIST__ = $lists['instancelist'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$instancelist): $mod = ($i % 2 );++$i;?><tr name="trname<?php echo ($i); ?>" <?php if(($instancelist['firstflag'] == 1)): ?>class="trbg selected"<?php endif; ?>  rel="<?php echo ($instancelist['pid']); ?>">
						<td><?php echo ($instancelist['servicename']); ?></td>
						<td><?php echo ($instancelist['path']); ?></td>
						<td><?php echo ($instancelist['ip']); ?></td>
						<td><?php echo ($instancelist['port']); ?></td>
						<td><?php echo ($instancelist['weight']); ?></td>
						<td><?php echo ($instancelist['providergrouid']); ?></td>
						<td><?php echo ($instancelist['consumergroupid']); ?></td>
						<td><?php echo ($instancelist['version']); ?></td>
						<td><?php echo ($instancelist['pid']); ?></td>
						<td><?php echo ($instancelist['framework']); ?></td>
						<td><a href="javascript:void(0);" width="550" height="330" target="dialog" rel="editInstance" name="setUrl" class="btnEdit" title="编辑" >修改</a><a class="btnDel" name="delIns" target='' title="确认要删除吗？" href="javascript:void(0);">删除</a></td>
						<input type="hidden" size="28" name="flag" value="<?php echo ($instancelist['flag']); ?>">
						<input name="order" value="<?php echo ($i); ?>" type='hidden'/>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>	
				</tbody>
			</table>
		</div>
	</div><?php endif; ?>
	<div id="conprobyinstanceGet">
	<div class="panel collapse" minH="50" defH="<?php $count = count($lists['providerlist']); $height = 40+30*$count; echo ($height<40)?40:$height; ?>">
		<h1>ice服务端</h1>
		<div>
			<table class="table list" width="98%">
				<thead>
					<tr>
						<th width="80">服务</th>
						<th>路径</th>
						<th>IP</th>
						<th>端口</th>
						<th>权重</th>
						<th>GroupID</th>
						<th>框架版本号</th>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($lists['providerlist'])): $i = 0; $__LIST__ = $lists['providerlist'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$providerlist): $mod = ($i % 2 );++$i;?><tr>
						<td><?php echo ($providerlist['servicename']); ?></td>
						<td><?php echo ($providerlist['path']); ?></td>
						<td><?php echo ($providerlist['ipv']); ?></td>
						<td><?php echo ($providerlist['port']); ?></td>
						<td><?php echo ($providerlist['weight']); ?></td>
						<td><?php echo ($providerlist['groupid']); ?></td>
						<td><?php echo ($providerlist['framework']); ?></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>	
				</tbody>
			</table>
		</div>
	</div>
	
	<div class="panel collapse" minH="100" defH="<?php $count = count($lists['consumerlist']); $height = 40+30*$count; echo($height<40)?40:$height; ?>">
		<h1>ice客户端</h1>
		<div>
			<table class="table list" width="98%">
				<thead>
					<tr>
						<th width="80">服务</th>
						<th>路径</th>
						<th>IP</th>
						<th>GroupID</th>
						<th>框架版本号</th>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($lists['consumerlist'])): $i = 0; $__LIST__ = $lists['consumerlist'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$consumerlist): $mod = ($i % 2 );++$i;?><tr>
						<td><?php echo ($consumerlist['servicename']); ?></td>
						<td><?php echo ($consumerlist['path']); ?></td>
						<td><?php echo ($consumerlist['ipv']); ?></td>
						<td><?php echo ($consumerlist['groupid']); ?></td>
						<td><?php echo ($consumerlist['framework']); ?></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>	
				</tbody>
			</table>
		</div>
	</div>
	</div>
	
	<!------------------------------>
		<div class="panel collapse" minH="100" defH="<?php $count = count($lists['configlist']); $height = 40+30*$count; echo($height<40)?40:$height; ?>">
		<h1>权重分组配置</h1>
		<div>
			<table class="list" width="98%">
				<thead>
					<tr>
						<th>服务</th>
						<th>路径</th>
						<th>IP</th>
						<th>端口</th>
						<th>权重</th>
						<th width="60">服务GroupID</th>
						<th width="60">客户GroupID</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($lists['configlist'])): $i = 0; $__LIST__ = $lists['configlist'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$configlist): $mod = ($i % 2 );++$i;?><tr>
						<td><?php echo ($configlist['servicename']); ?></td>
						<td><?php echo ($configlist['path']); ?></td>
						<td><?php echo ($configlist['ip']); ?></td>
						<td><?php echo ($configlist['port']); ?></td>
						<td><?php echo ($configlist['weight']); ?></td>
						<td><?php echo ($configlist['providergrouid']); ?></td>
						<td><?php echo ($configlist['consumergroupid']); ?></td>
						<td><a href="javascript:void(0);" width="550" height="330" target="dialog" rel="editConfig" name="editConfig" class="btnEdit" title="编辑" >修改</a><a class="btnDel" name="delConfig" target='' title="确认要删除吗？" href="javascript:void(0);">删除</a></td>
						<input type="hidden" size="28" name="flag" value="<?php echo ($configlist['flag']); ?>">
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>	
				</tbody>
			</table>
		</div>
		</div>
</div>
<script type="text/javascript">

$("a[name='setUrl']").click(function(){
	var cav = $(this).parent().parent();
	var servicename = $("td",cav).slice(0,1).html();
	var path = $("td",cav).slice(1,2).html();
	var IP = $("td",cav).slice(2,3).html();
	var port = $("td",cav).slice(3,4).html();
	var weight = $("td",cav).slice(4,5).html();
	var providergrouid = $("td",cav).slice(5,6).html();
	var consumergroupid = $("td",cav).slice(6,7).html();
	var pid = $("td",cav).slice(8,9).html();

	var flag = $("input[name='flag']",cav).val();
	var order = $("input[name='order']",cav).val();
	var path1 = path.replace(/\//g,"*");
	var treessname = $("input[name='treessname']").val();

	
	$("tr","#instancelist").removeClass();
	$("tr[name='trname"+order+"']").addClass("selected");
	
	$(this).attr("href","/index.php?s=/Admin/WeightService/edit/servicename/"+servicename+"/IP/"+IP+"/port/"+port+"/weight/"+weight+"/providergrouid/"+providergrouid+"/consumergroupid/"+consumergroupid+"/flag/"+flag+"/path/"+path1+"/treessname/"+treessname);

});
$("a[name='delIns']").click(function(){
	var cav = $(this).parent().parent();
	var servicename = $("td",cav).slice(0,1).html();
	var path = $("td",cav).slice(1,2).html();
	var IP = $("td",cav).slice(2,3).html();
	var port = $("td",cav).slice(3,4).html();
	var weight = $("td",cav).slice(4,5).html();
	var providergrouid = $("td",cav).slice(5,6).html();
	var consumergroupid = $("td",cav).slice(6,7).html();
	var flag = $("input[name='flag']",cav).val();
	var path1 = path.replace(/\//g,"*");
	var treessname = $("input[name='treessname']").val();
	
	var url = "/index.php?s=/Admin/WeightService/checkDelete/servicename/"+servicename+"/IP/"+IP+"/port/"+port+"/weight/"+weight+"/providergrouid/"+providergrouid+"/consumergroupid/"+consumergroupid+"/flag/"+flag+"/path/"+path1+"/treessname/"+treessname;
	
	var consumURL = "/index.php?s=/Admin/WeightService/delete/servicename/"+servicename+"/IP/"+IP+"/port/"+port+"/weight/"+weight+"/providergrouid/"+providergrouid+"/consumergroupid/"+consumergroupid+"/consumerdelete/1/flag/"+flag+"/path/"+path1+"/treessname/"+treessname;
	if(flag == "1"){
		alertMsg.confirm("确认要删除吗？", {
					okCall: function() {
						ajaxTodo(consumURL, deleteConsumAjaxDone);
					}
				});
	}
	if(flag == "2"||flag == "3"){
		//$(this).attr({target:'dialog',href:url});
		$.pdialog.open(url, 'editInstance', '删除服务', {"width":500,"height":250});
		return;
	}
	
	

});

function deleteConsumAjaxDone(json){
    DWZ.ajaxDone(json);
    if (json.statusCode == DWZ.statusCode.ok) {
        if (json.navTabId) {
            $("#Service_list").loadUrl(json.forwardUrl);
        }
    }
}

$("tr","#instancelist").click(function(){
	var cav = $(this);
	var servicename = $("td",cav).slice(0,1).html();
	var path = $("td",cav).slice(1,2).html();
	var IP = $("td",cav).slice(2,3).html();
	var port = $("td",cav).slice(3,4).html();
	var weight = $("td",cav).slice(4,5).html();
	var providergrouid = $("td",cav).slice(5,6).html();
	var consumergroupid = $("td",cav).slice(6,7).html();
	var flag = $("input[name='flag']",cav).val();
	var path1 = path.replace(/\//g,"*");
	var URL = "/index.php?s=/Admin/WeightService/conprobyinstanceGet/servicename/"+servicename+"/ip/"+IP+"/port/"+port+"/weight/"+weight+"/providergrouid/"+providergrouid+"/consumergroupid/"+consumergroupid+"/flag/"+flag+"/path/"+path1;
	$("#conprobyinstanceGet").loadUrl(URL);
})

$("a[name='editConfig']").click(function(){
	var cav = $(this).parent().parent();
	var servicename = $("td",cav).slice(0,1).html();
	var path = $("td",cav).slice(1,2).html();
	var IP = $("td",cav).slice(2,3).html();
	var port = $("td",cav).slice(3,4).html();
	var weight = $("td",cav).slice(4,5).html();
	var providergrouid = $("td",cav).slice(5,6).html();
	var consumergroupid = $("td",cav).slice(6,7).html();
	var flag = $("input[name='flag']",cav).val();
	var path1 = path.replace(/\//g,"*");
	var treessname = $("input[name='treessname']").val();
	
	$("tr",cav).addClass("selected");
	$(this).attr("href","/index.php?s=/Admin/WeightService/editConfig/servicename/"+servicename+"/ip/"+IP+"/port/"+port+"/weight/"+weight+"/providergrouid/"+providergrouid+"/consumergroupid/"+consumergroupid+"/flag/"+flag+"/path/"+path1+"/treessname/"+treessname);

});

$("a[name='delConfig']").click(function(){
	var cav = $(this).parent().parent();
	var servicename = $("td",cav).slice(0,1).html();
	var path = $("td",cav).slice(1,2).html();
	var IP = $("td",cav).slice(2,3).html();
	var port = $("td",cav).slice(3,4).html();
	var weight = $("td",cav).slice(4,5).html();
	var providergrouid = $("td",cav).slice(5,6).html();
	var consumergroupid = $("td",cav).slice(6,7).html();
	var flag = $("input[name='flag']",cav).val();
	var path1 = path.replace(/\//g,"*");
	var treessname = $("input[name='treessname']").val();
	
	var url = "/index.php?s=/Admin/WeightService/checkDelete/servicename/"+servicename+"/IP/"+IP+"/port/"+port+"/weight/"+weight+"/providergrouid/"+providergrouid+"/consumergroupid/"+consumergroupid+"/flag/"+flag+"/path/"+path1+"/treessname/"+treessname;;
	
	var consumURL = "/index.php?s=/Admin/WeightService/delete/servicename/"+servicename+"/IP/"+IP+"/port/"+port+"/weight/"+weight+"/providergrouid/"+providergrouid+"/consumergroupid/"+consumergroupid+"/consumerdelete/1/flag/"+flag+"/path/"+path1+"/treessname/"+treessname;;
	if(flag == "1"){
		alertMsg.confirm("确认要删除吗？", {
					okCall: function() {
						ajaxTodo(consumURL, deleteConsumAjaxDone);
					}
				});
	}
	if(flag == "2"||flag == "3"){
		$.pdialog.open(url, 'editInstance', '删除服务', {"width":500,"height":250});
		return;
	}

});
</script>