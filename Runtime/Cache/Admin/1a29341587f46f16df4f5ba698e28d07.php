<?php if (!defined('THINK_PATH')) exit();?><style type="text/css">
	.channelborder td{border:2px #afafaf solid; padding:10px;}
	.tr_red{background:#d50202;}
.tr_red td{color:white}

.tr_yellow{background:yellow}
</style>
<div id="channelbody"  style="overflow:auto;height:780px;">
	<div class="item_list_filter"  style="padding-top:5px">
		
	</div>
	<div style=" padding-bottom:20px;">
		<table class="list tac" width="100%">
			<tr><th  colspan="6" align="left"><h1 style="font-size:16px; font-weight:bold;">设置系统参数</h1></th></tr>
			<tr>
				<td align="left" width="100"><span style="font-size:14px; font-weight:bold;">当前系统是：</span></td>
				<td  align="left">
					<select name="tsysname" id="tsysname">
						<?php if(!empty($chaninfo)): ?>
							<?php foreach($chaninfo as $channelk=>$channelv): ?>
								<option value="<?php echo $channelk; ?>" <?php if($currentcs == $channelk): ?> selected="selected" <?php endif; ?>><?php echo $channelv; ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="button" value="提交" onclick="changeSystem()" />
				</td>
			</tr>
		</table>
	</div>
	<div id="Serquality_list">
		<div class="tableList" layouth="150" >
		<div style="float:left;margin-bottom:10px;">
			<span style='float:left;font-size:20px'>
				渠道个数：<?php echo ($ChannelNum); ?>，渠道实例总数：<?php echo ($InstanceNum); ?>
			</span>
		<div style="float:left;margin-left:500px;">
			<input style="cursor: pointer" type="button" name="flush" id='flush' value="刷新"  />
		</div>
		</div>
		<?php if(is_array($ChannelStatus)): $i = 0; $__LIST__ = $ChannelStatus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><table class="list tac" width="100%" style="margin-top:50px;">
				<tr>
					<th colspan="6" align="left" >
						渠道名：<?php echo ($vo['channelName']); ?> 
						渠道ID：<?php echo ($vo['channelID']); ?> 
						渠道服务ID：<?php echo ($vo['channelServiceID']); ?> 
						实例个数：<?php echo ($vo['instancesCount']); ?> 
						状态：<?php echo (showchannelstatus($vo['status'])); ?>
					</th>
				</tr>
				<?php if(!empty($vo['InstanceStatus'])): ?><tr>
					<th>渠道实例地址</th>
					<th>连续失败次数</th>
					<th>连续成功次数</th>
					<th>交易总次数</th>
					<th>状态</th>
					<th>操作</th>
				</tr>
				<?php if(is_array($vo['InstanceStatus'])): $i = 0; $__LIST__ = $vo['InstanceStatus'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$Instance): $mod = ($i % 2 );++$i;?><tr target="script_id" rel="<?php echo ($vo['smId']); ?>" class="channelborder"  <?php if($vo['status'] == 2 || $vo['status'] == 3): ?>style="background:#b70808" <?php elseif($Instance['status'] == 3): ?>style="background:yellow"<?php endif; ?> >
					<td <?php if($vo['status'] == 2 || $vo['status'] == 3): ?>style="color:black; font-weight:bold;font-size:14px;"<?php endif; ?>>
						<?php echo ($Instance['host']); ?>
					</td>
					<td <?php if($vo['status'] == 2 || $vo['status'] == 3): ?>style="color:black; font-weight:bold;font-size:14px;"<?php endif; ?>>
						<?php echo ($Instance['consecutiveFailedTimes']); ?>
					</td>
					<td <?php if($vo['status'] == 2 || $vo['status'] == 3): ?>style="color:black; font-weight:bold;font-size:14px;"<?php endif; ?>>
						<?php echo ($Instance['consecutiveSuccessedTimes']); ?>
					</td>
					<td <?php if($vo['status'] == 2 || $vo['status'] == 3): ?>style="color:black; font-weight:bold;font-size:14px;"<?php endif; ?>>
						<?php echo ($Instance['totalTradeTimes']); ?>
					</td>
					<td <?php if($vo['status'] == 2 || $vo['status'] == 3): ?>style="color:black; font-weight:bold;font-size:14px;"<?php endif; ?>>
						<?php echo (showchannelinstancestatus($Instance)); ?>
					</td>
					<td>
						<?php if($Instance['status'] != 3 ): ?><input style="cursor: pointer" type="button" name="pause" id='pause' value="暂停交易" host="<?php echo ($Instance['host']); ?>" />
						<?php else: ?> 
						<input style="cursor: pointer" type="button" name="restore" id='restore' value="取消暂停" host="<?php echo ($Instance['host']); ?>" /><?php endif; ?>
					</td>
				</tr><?php endforeach; endif; else: echo "" ;endif; endif; ?>
				<?php if(empty($vo['InstanceStatus'])): ?><tr>
					<td colspan="6" align="left" >没有该渠道的实例</td>
				</tr><?php endif; ?>
				<tr>
					<td colspan='6' align='left'>
						<?php if($vo['status'] == 4 || $vo['status'] == 6): if(count($vo['InstanceStatus']) > 0): ?><input style="cursor: pointer" type="button" name="changeChannel"  value="请求渠道路由放行部分交易走原渠道" ServiceID="<?php echo ($vo['channelServiceID']); ?>" action="requestTrade"/><?php endif; ?>
							<input style="cursor: pointer" type="button" name="changeChannel"  value="取消渠道切换" ServiceID="<?php echo ($vo['channelServiceID']); ?>" action="unblock" />
						<?php else: ?>
							<input style="cursor: pointer" type="button" name="changeChannel" value="通知路由切换渠道(慎用)" ServiceID="<?php echo ($vo['channelServiceID']); ?>"   action="block" /><?php endif; ?>
					</td>
				</tr>
			</table>
			<div></div><?php endforeach; endif; else: echo "" ;endif; ?>		
		</div>
	</div>
</div>

<script type="text/javascript">
//暂停交易
$("input[name='pause']").click(function(){
	var host = $(this).attr("host");
	$.ajax({
	  type: "POST",
	  async: false,
	  url: "/index.php?s=/Admin/Channel/changeInstanceStatus",
	  data: "server="+host+"&action=pause",
	  success: function(msg){
		  $("#channelbody").loadUrl('/index.php?s=/Admin/Channel/');  
	   }
	});

})

//恢复交易
$("input[name='restore']").click(function(){
	var host = $(this).attr("host");
	$.ajax({
	  type: "POST",
	  async: false,
	  url: "/index.php?s=/Admin/Channel/changeInstanceStatus",
	  data: "server="+host+"&action=restore",
	  success: function(msg){
		 $("#channelbody").loadUrl('/index.php?s=/Admin/Channel/');  
		 //$(this).attr({"value":'暂停交易','host2':'123123'});
	   }
	});

})

//切换渠道
$("input[name='changeChannel']").click(function(){
	var ServiceID = $(this).attr("ServiceID");
	var type = $(this).attr("action");
	$.ajax({
	  type: "POST",
	  async: false,
	  url: "/index.php?s=/Admin/Channel/changeChannelStatus",
	  data: "serviceID="+ServiceID+"&action="+type,
	  success: function(msg){
		 $("#channelbody").loadUrl('/index.php?s=/Admin/Channel/');  
	   }
	});

})

//刷新按钮
$("input[name='flush']").click(function(){
	 $("#channelbody").loadUrl('/index.php?s=/Admin/Channel/');  
})


function changeSystem(){
	var sys = $("#tsysname").val();
	$.ajax({
		  type: "POST",
		  async: false,
		  url: "/index.php?s=/Admin/Channel/changeChannelSys",
		  data: "systag="+sys,
		  success: function(msg){
			 $("#channelbody").loadUrl('/index.php?s=/Admin/Channel/');  
		   }
		});
}
/*
$(function(){
// 文档就绪
setInterval(function() {                                    
	var x = (new Date()).getTime(); // current time         
	$("#channelbody").loadUrl('/index.php?s=/Admin/Channel/flush','','',false); //去掉刷新的圈圈 
}, 1000 * 10);//1秒一次 1000
});*/

</script>