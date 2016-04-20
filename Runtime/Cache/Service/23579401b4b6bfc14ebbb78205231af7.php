<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">
<form novalidate="novalidate" onsubmit="return validateCallback(this, JTdialogAjaxDone)" class="pageForm required-validate" 
action="/index.php/Service/Graph/specailNode" method="post">
	<div class="pageFormContent" layouth="58" id="topo_edit_dialog">
			<p>
				<label>节点类型：</label>
				<input type="text" disabled="disabled" value="已监控设备"/>
			</p>
			<p>
				<label>节点分组：</label>
				<select name="nodeGroup" id="nodeGroup" onchange="triggerSearch('msg_node_group')">
				<option value="">全部产品</option>
				 <?php if(count($prolist) > 0): ?>
				 	<?php foreach($prolist as $list): ?>
				 		<option value="<?php echo $list['pdId']; ?>"><?php echo $list['pdName']; ?></option>
				 	<?php endforeach; ?>
				 <?php endif; ?>
				</select>
				<span id="msg_node_group" style="display:none;color:#FF0000"></span>
			</p>
			<p style="width:100%">
				<label>设备类型：</label>
				<?php if(count($device)): ?>
				<select name="deviceType" id="devicePattern" onchange="triggerSearch('msg_node_device')">
					<option value="">全部设备</option>
					<?php foreach($device as $dk=>$dv): ?>
					<option value="<?php echo $dv['deviceid'] ?>"><?php echo $dv['deviceName']; ?></option>
					<?php endforeach; ?>
				</select><span id="msg_node_device" style="display:none;color:#FF0000">查询成功！</span>
				<?php else: ?>
				<span style="padding: 6px 5px; display: block;">没有查询到设备类型，请添加。</span>
				<?php endif; ?>
			</p>
			<p>
				<label>主机查询：</label>
				<input type="hidden" name="service.nodeId"  id="serviceid" value=""/>
				<input type="hidden" name="service.nodeIp"  id="serviceip" value=""/>
				<input type="text" name="service.nodeName"  id="graphservicename" value="" placeholder="请输入主机或IP" />
				<!--  <a class="btnLook" href="/index.php/Service/GraphSearch" cache="1" lookupGroup="service" width="700" height="603">查找：</a> -->
				<a class="btnLook" href="javascript:void(0)" onclick="getServiceList()" id="mylookup"></a>
				<span id="srs_lookup" style="display:none;color:#FF0000"></span>
			</p>
			<p>
				<label>对应设备：</label>
				<?php if(count($nodes)): ?> 
				<select size="<?php echo count($nodes)+1; ?>" style="width: 300px;" id="targetdevice" name="targetdevice" onchange="setNodeInfo()">
					<?php foreach($nodes as $node): ?>
					<option value="<?php echo $node['id']; ?>"><?php echo $node['ip'].'-'.$node['hostName']; ?></option>
					<?php endforeach; ?>
				</select>
				<?php else: ?>
				<span>没有找到对应的设备！</span>
				<?php endif; ?>
			</p>
	</div>
	<div class="formBar">
		<ul>
			<li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
			<li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
		</ul>
	</div>
	</form>
</div>

<script  type="text/javascript">

/*
function toggleDeviceType(obj)
{
	var val = $(obj).val();
	if(val){
		$.ajax({
			'type':'POST',
			'dataType':'json',
			'url':'/index.php/Service/GraphSearch/query',
			'data':{'did':val},
			success:function(res){
				if (res.statusCode == 1) {
					var lists = res.data;
					var i;
					var str = "";
					for(i=0; i<lists.length; i++){
						str += "<option value='"+lists[i].id+"'>"+lists[i].ip+"-"+lists[i].hostName+"</option>";
					}
					$("#targetdevice").html(str);
					//alertMsg.correct("查询成功！");
					$("#srs").html('查询成功！').fadeIn(1000);
					$("#srs").fadeOut(1000);
				}else{
					
					$(obj).get(0).seletedIndex = 0;
					$("#targetdevice").html('');
					$("#srs").html('未查询到结果！').fadeIn(1000);
					$("#srs").fadeOut(1000);
				}
			},
			error:function(err){
				
			}
		})
	}
}
*/

function triggerSearch(html){
	var proid = $("#nodeGroup").val();
	var deviceid = $("#devicePattern").val();
	$.ajax({
		'type':'POST',
		'dataType':'json',
		'url':'/index.php/Service/GraphSearch/queryProAndDevice',
		'data':{'pdid':proid,'deviceid':deviceid},
		success:function(res){
			if (res.statusCode == 1) {
				var lists = res.data;
				var i;
				var str = "";
				for(i=0; i<lists.length; i++){
					str += "<option value='"+lists[i].id+"'>"+lists[i].ip+"-"+lists[i].hostName+"</option>";
				}
				$("#targetdevice").html(str);
				//alertMsg.correct("查询成功！");
				msg = "查询成功！";
			}else{
				$("#targetdevice").html('');
				msg="未查询到结果";
			}
			if(html){
				$("#"+html).html(msg).fadeIn(1000);
				$("#"+html).fadeOut(1000);
			}
			
		},
		error:function(err){
		}
	})
	
}
function JTdialogAjaxDone(json){
	DWZ.ajaxDone(json);
	if (json.statusCode == DWZ.statusCode.ok) {
		var current = new Date().getTime();
		var nodeid = json.nodeId +'_'+ current;
		var dtype = json.deviceid;
		//var nodeImage = jpImages[dtype];
		if(json.icon){
			var nodeImage = '/Public/Images/jtopo/'+json.icon;
			
		}else{
			var nodeImage = '/Public/Images/jtopo/node2.png';
		}
		var node = scene.selectedElements[0];
		node.setImage(nodeImage);		//修改节点图标；
		node.text = json.nodeText;		//修改节点文本；
		node.setXgdId(nodeid); 			//添加唯一标识；
		node.setDtype(dtype); 			//设置设备类型；
		node.setServerId(json.nodeId);	//设置对应设备的ID值；2016-03-18
		$.pdialog.closeCurrent();
	}
}

function getServiceList() {
	var vals = $("#graphservicename").val();
	if (vals == '' || vals == undefined) {
		alertMsg.error('请输入主机名或IP');
		return false;
	}

	var pdId = $("#nodeGroup").val();
	var deviceId = $("#devicePattern").val();
	$.ajax({
		type: "POST",
		cache: false,
		dataType: 'json',
		data: {
			'host': vals,
			'pdId': pdId,
			'deviceId': deviceId
		},
		url: '/index.php/Service/GraphSearch/searchHost',
		success: function(da) {
			if (da.statusCode == 1) {
				var res_content = da.content;
				var i;
				var str = "";
				for(i=0; i<res_content.length; i++){
					str += "<option value='"+res_content[i].id+"'>"+res_content[i].ip+"-"+res_content[i].hostName+"</option>";
				}

				$("#targetdevice").html(str);
					//alertMsg.correct("查询成功！");
					
					$("#serviceid").val('');
					$("#serviceip").val('');
					//$("#graphservicename").val('');
					$("#srs_lookup").html('查询成功！').fadeIn(1000);
					$("#srs_lookup").fadeOut(1000);

				/*$("#serviceid").val(da.id);
				$("#serviceip").val(da.ip);
				$("#graphservicename").val(da.hostName);*/

				/*$("#targetdevice").find("option").each(function() {
					if ($(this).val() == da.id) {
						$(this).attr("selected", true);
						state = 1;
					}
				})
				if (state) $("#targetdevice").attr('disabled', true);
				alertMsg.correct(da.message);*/
			} else {
				$("#targetdevice").html('');
				$("#serviceid").val('');
				$("#serviceip").val('');
				//$("#graphservicename").val('');
				$("#srs_lookup").html('未查询到结果！').fadeIn(1000);
				$("#srs_lookup").fadeOut(1000);
				//alertMsg.error(da.message);
			}
		}
	})
}

//主机查询搜索框，如果内容被清空，查询所有节点填充；
$("#graphservicename").on("keyup",function(){
	if($(this).val() == ''){
		$("#nodeGroup").val('');
		$("#devicePattern").val('');
		triggerSearch();
	}
})

function setNodeInfo() {
	var targetInfo 	= $("#targetdevice").find("option:selected").text();
	var targetArr  	= targetInfo.split('-');
	var serviceip  	= targetArr[0];
	var graphservicename = targetArr[1];
	var deviceType 	= targetArr[2];
	var serviceid 	= $("#targetdevice").val();
	$("#serviceid").val(serviceid);
	$("#graphservicename").val(graphservicename);
	$("#serviceip").val(serviceip);

	if(deviceType){
		$("#devicePattern").val(deviceType);
	}
}
</script>