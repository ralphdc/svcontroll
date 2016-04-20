<?php if (!defined('THINK_PATH')) exit();?><table class="list tac " width="100%" layoutH="30">
	<thead>
		<tr>
		<th >序号 </th>
		<th >策略名称 </th>
		<th >商户号 </th>
		<th >终端号 </th>
		<th >发卡行(多个用英文,隔开) </th>
		<th >渠道ID </th>
		<th >返回码(多个用英文,隔开) </th>
		<th >不等于的返回码(多个用英文,隔开) </th>
		<th >操作 </th>
		</tr>
	</thead>
	<tbody class="head_search">
	<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
		<td><?php echo ($i); ?><input  type="hidden" name='strategyOrder'  value="<?php echo ($i); ?>" ></td>
		<td><input  type="text" name='strategyName' readonly  value="<?php echo ($vo['strategy_name']); ?>"  ></td>
		<td><input  type="text" name='merchantLid' readonly value="<?php echo ($vo['merchantLid']); ?>" ><input type="hidden" name='strId' value="<?php echo ($vo['strId']); ?>" ></td>
		<td><input  type="text" name='termLid' readonly value="<?php echo ($vo['termLid']); ?>" ></td>
		<td><input  type="text" name="issuebank" readonly value="<?php echo ($vo['issuebank']); ?>" title="<?php echo ($vo['issuebank']); ?>" ></td>
		<td><input  type="text" name='channelId' readonly value="<?php echo ($vo['channelId']); ?>" ></td>
		<td><input  type="text" name='returnCode' readonly value="<?php echo ($vo['returnCode']); ?>" ></td>
		<td><input  type="text" name='rtncode_notinclude' readonly value="<?php echo ($vo['rtncode_notinclude']); ?>" ></td>
		<td>
			<a href="/index.php?s=/Admin/SysMonitor/delStrategy/id/<?php echo ($vo['strId']); ?>" target="ajaxTodo" title="你确定要删除吗？"  class="btn_search">删除</a>
			<button type="submit" class="btn_search showStrategy">查看</button>
		</td>
		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	<tr>
		<td></td>
		<td><input  type="text" name='strategyName' value="" maxlength="15" ></td>
		<td><input  type="text" name='merchantLid' value="" ></td>
		<td><input  type="text" name='termLid' value="" ></td>
		<td><input  type="text" name="issuebank"  value=""></td>
		<td><input  type="text" name='channelId' value="" ></td>
		<td><input  type="text" name='returnCode' value="" ></td>
		<td><input  type="text" name='rtncode_notinclude' value="" ></td>
		<td>
			<button type="submit" class="btn_search saveStrategy">保存</button>
		</td>
	</tr>
	</tbody>
</table>
<script type="text/javascript">

$(".saveStrategy").click(function(){
	var cav = $(this).parent().parent();
	var strategyName = $("input[name='strategyName']",cav).val();
	var merchantLid = $("input[name='merchantLid']",cav).val();
	var termLid = $("input[name='termLid']",cav).val();
	var issuebank = $("input[name='issuebank']",cav).val();
	var channelId = $("input[name='channelId']",cav).val();
	var returnCode = $("input[name='returnCode']",cav).val();
	var rtncode_notinclude = $("input[name='rtncode_notinclude']",cav).val();

	if(returnCode !=""&&rtncode_notinclude!=''){
		alertMsg.error("返回码与不等于返回码不能同时都有值");
        return false;
	}
	$.ajax({
				type : 'post',
				url : '/index.php?s=/Admin/SysMonitor/saveStrategy',
				global: false,
				dataType : 'json',
				data : {'strategy_name':strategyName,'merchantLid':merchantLid,'termLid':termLid,'issuebank':issuebank,'channelId':channelId,'returnCode':returnCode,'rtncode_notinclude':rtncode_notinclude},
				success : function(response){
					StrategyAjaxDone(response);
				}
			});
});

$(".showStrategy").click(function(){
	var cav = $(this).parent().parent();
	var strategyName = $("input[name='strategyName']",cav).val();
	var merchantLid = $("input[name='merchantLid']",cav).val();
	var termLid = $("input[name='termLid']",cav).val();
	var channelId = $("input[name='channelId']",cav).val();
	var returnCode = $("input[name='returnCode']",cav).val();
	var order = $("input[name='strategyOrder']",cav).val();
	var issuebank = $("input[name='issuebank']",cav).val();
	var rtncode_notinclude = $("input[name='rtncode_notinclude']",cav).val();
	
	navTab.openTab(order, '/index.php?s=/Admin/SysMonitor/showStrategy', {
                title: strategyName,
				data: {'merchantLid':merchantLid,'termLid':termLid,'channelId':channelId,'returnCode':returnCode,'name':order,'issuebank':issuebank,'rtncode_notinclude':rtncode_notinclude}
				
            }); 
});

function StrategyAjaxDone(json){
    DWZ.ajaxDone(json);
    if (json.statusCode == DWZ.statusCode.ok) {
        if (json.navTabId) {
            navTab.reloadFlag(json.navTabId);
        } else {
            var $pagerForm = $("#pagerForm", navTab.getCurrentPanel());
            var args = $pagerForm.size() > 0 ? $pagerForm.serializeArray() : {}
            navTabPageBreak(args, json.rel);
        }
    }
}




</script>