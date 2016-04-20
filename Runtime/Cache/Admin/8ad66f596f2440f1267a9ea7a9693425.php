<?php if (!defined('THINK_PATH')) exit();?><div id="channelbody"  style="overflow:auto;height:780px;">
<div class="item_list_filter"  style="padding-top:5px">

</div>
<h1>渠道状态监控</h1>
<hr/>
<div id="Serquality_list">
	<div class="tableList" layouth="37" style="overflow:auto;height:780px;" >
	<div style="float:left;margin-bottom:10px;">
		<span style='float:left;font-size:20px'>渠道个数：<?php echo ($ChannelNum); ?>，渠道实例总数：<?php echo ($InstanceNum); ?></span>
		<div style="float:left;margin-left:500px;">
			<input style="cursor: pointer" type="button" name="flush" id='flush' value="刷新"  />
		</div>
	</div>
	<?php if(is_array($ChannelStatus)): $i = 0; $__LIST__ = $ChannelStatus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><table class="list tac" width="100%" style="margin-top:20px;">
			<tr>
				<th colspan="6" align="left" >
					渠道名：<?php echo ($vo['channelName']); ?> 
					渠道ID：<?php echo ($vo['channelID']); ?> 
					渠道服务ID：<?php echo ($vo['channelServiceID']); ?> 
					实例个数：<?php echo ($vo['instancesCount']); ?> 
					状态：<?php echo (showchannelstatus($vo['status'])); ?>
				</th>
			</tr>
 			<tr>
					<th>渠道实例地址</th>
					<th>连续失败次数</th>
					<th>连续成功次数</th>
					<th>交易总次数</th>
					<th>状态</th>
					<th>操作</th>
				</tr>
				<?php if(is_array($vo['InstanceStatus'])): $i = 0; $__LIST__ = $vo['InstanceStatus'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$Instance): $mod = ($i % 2 );++$i;?><tr target="script_id" rel="<?php echo ($vo['smId']); ?>">
						<td>
							<?php echo ($Instance['host']); ?>
						</td>
						<td>
							<?php echo ($Instance['consecutiveFailedTimes']); ?>
						</td>
						<td>
							<?php echo ($Instance['consecutiveSuccessedTimes']); ?>
						</td>
						<td>
							<?php echo ($Instance['totalTradeTimes']); ?>
						</td>
						<td >
							<?php echo (showchannelinstancestatus($Instance['status'])); ?>
						</td>
						<td>
							<?php if($Instance['status'] != 3 ): ?><input style="cursor: pointer" type="button" name="pause" id='pause' value="暂停交易" host="<?php echo ($Instance['host']); ?>" />
							<?php else: ?> 
							<input style="cursor: pointer" type="button" name="restore" id='restore' value="恢复交易" host="<?php echo ($Instance['host']); ?>" /><?php endif; ?>
						</td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					<tr><td colspan='6' align='left'>
					<?php if($vo['status'] == 4 ): ?><input style="cursor: pointer" type="button" name="changeChannel"  value="请求渠道路由放行部分交易走原渠道" ServiceID="<?php echo ($Instance['channelServiceID']); ?>" action="requestTrade"/> 
						<input style="cursor: pointer" type="button" name="changeChannel"  value="取消渠道切换" ServiceID="<?php echo ($Instance['channelServiceID']); ?>" action="unblock" />
					<?php else: ?>
						<input style="cursor: pointer" type="button" name="changeChannel" value="通知路由切换渠道(慎用)" ServiceID="<?php echo ($Instance['channelServiceID']); ?>"   action="block" /><?php endif; ?>
					</td>
					</tr>
				<?php if(empty($vo['InstanceStatus'])): ?><tr>
					<td colspan="6" align="left" >没有该渠道的实例</td>
				</tr><?php endif; ?>
		</table>
		<div ></div><?php endforeach; endif; else: echo "" ;endif; ?>		
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
		  $("#channelbody").loadUrl('/index.php?s=/Admin/Channel/flush');  
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
		 $("#channelbody").loadUrl('/index.php?s=/Admin/Channel/flush');  
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
		 $("#channelbody").loadUrl('/index.php?s=/Admin/Channel/flush');  
	   }
	});

})

//刷新按钮
$("input[name='flush']").click(function(){
	 $("#channelbody").loadUrl('/index.php?s=/Admin/Channel/flush');  
})

/*
$(function(){
// 文档就绪
setInterval(function() {                                    
	var x = (new Date()).getTime(); // current time         
	$("#channelbody").loadUrl('/index.php?s=/Admin/Channel/flush','','',false); //去掉刷新的圈圈 
}, 1000 * 10);//1秒一次 1000
});*/

</script>