<?php if (!defined('THINK_PATH')) exit();?>	<form id="pagerForm" action="/index.php?s=/Admin/SysMonitor/SysMonitor/strategyBat" method="post">
	</form>

	<div class="accordion" layoutH="30" style="width:100%;float:left;margin:5px;">
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><form method="post" action="/index.php?s=/Admin/SysMonitor/delStrategyBat" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone)" novalidate="novalidate">
		<div class="accordionHeader">
			<h2><span>icon</span><?php echo ($vo['batchmerName']); ?></h2>
		</div>
		<div class="accordionContent" style="height:auto">
			<table class="list" width="100%" height='208px'>
				<tbody class="head_search">
				<tr>
					<td ><textarea  cols="140" rows="10" readonly><?php echo ($vo['batchmerSetting']); ?></textarea>
						<input type="hidden" name="id" value="<?php echo ($vo['mmId']); ?>" /></td>
					<td ><button type="submit"  class="btn_search saveStrategy">删除</button></td>
					<td >
						<a href="/index.php/Admin/SysMonitor/showStrategyBat/mmId/<?php echo ($vo['mmId']); ?>/batchmerSetting/<?php echo ($vo['batchmerSetting']); ?>" target="navtab" class="btn_search" title="<?php echo mb_substr($vo['batchmerName'],0,6,'utf-8');?>" rel="showStrategyBat<?php echo ($i); ?>">查看</a>
					</td>
				</tr>
				</tbody>
			</table>
		</div>
		</form><?php endforeach; endif; else: echo "" ;endif; ?>
		
		<div class="accordionHeader">
			<h2><span>icon</span>添加</h2>
		</div>
		<div class="accordionContent">
			<form method="post" action="/index.php?s=/Admin/SysMonitor/saveStrategyBat" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone)" novalidate="novalidate">
			<table class="list tac " width="100%">
				<thead>
					<tr>
					<th >名称</th>
					<th >商户号终端号</th>
					<th >操作</th>
					</tr>
				</thead>
				<tbody class="head_search">
				<tr>
					<td><input type="text" name="batchmerName" class="required textInput" minlength="1" maxlength="8" /></td>
					<td> <textarea name="batchmerSetting" id="strategyBatContent" rel="0"  cols="140" rows="10" style="color:#999999;" >
84944197298001447494925;
84944197298001447494926;
84944197298001447494927;
							</textarea></td>
					<td>
						<button type="submit"  class="btn_search saveStrategy">保存</button>
					</td>
				</tr>
				</tbody>
			</table>
			</form>
		</div>
	</div>
<script type="text/javascript">
$("#strategyBatContent").click(function(){
	var rel = $(this).attr('rel');
	if(rel == "0"){
		$(this).val('');
		$(this).css('color',"#616161");
		$(this).attr('rel',"1");
	}
})
</script>