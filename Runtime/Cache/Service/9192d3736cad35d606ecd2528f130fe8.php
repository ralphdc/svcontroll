<?php if (!defined('THINK_PATH')) exit();?><script src="/Public/dwz/js/jquery.ztree.excheck-3.5.js" type="text/javascript"></script>

<div class="pageContent">
	<form method="post" action='/index.php/Service/Repertory/create_plan' class="pageForm required-validate" onsubmit="return validateCallback(this,callDialogAjaxDone)" novalidate="novalidate">
		<div class="pageFormContent" layouth="58">
			<div class="repertory_call_left">
				<div class="searchBar">
					<table class="searchContent">
						<tr>
							<td><label>IP：</label><input type="text" name="ipte" id="ipte" class="textInput" size="14"></td>
							<td><label>机器名：</label><input type="text" name="hostnamete" id="hostnamete" class="textInput" size="15"></td>
							<td><a type="submit" id="btn_search" class="button btn_search ui_btn_green" style="height:22px;line-height:22px;margin-left:15px;">查询</a></td>
						</tr>
					</table>
				</div>
				<div id='productIpTree'>
				
					<?php echo ($ipProductTree); ?>

				</div>
			</div>
			<div id="instance_detail" class="repertory_call_right" layouth="80">
				<p>
					<label>服务实例：</label>
					<input type="text" size="28" class="required textInput" name="serName" id="" value="<?php echo ($serName); ?>" readonly="true" />
					<input type="hidden" id="ips" name="ips" value="<?php echo ($ips); ?>"/>
					<input type="hidden" id="mwId" name="mwId" value="<?php echo ($mwId); ?>"/>
					<input type="hidden" id="version" name="version" value="<?php echo ($version); ?>"/>
				</p>
				<p>
					<label>部署路径：</label>
					<input type="text" size="28" class="required textInput" name="serPath" id="" value="<?php echo ($desploypath); ?>"/>
				</p>
				<p>
					<label>部署组：</label>
					<input type="text" size="28" class="required textInput" name="serGroup" id="" value="<?php echo ($serGroup); ?>"/>
				</p>
				<p>
					<label>部署用户：</label>
					<input type="text" size="28" class="required textInput" name="serUser" id="" value="<?php echo ($serUser); ?>"/>
				</p>
				<p>
					<label>操作类型：</label>
					<select name="opmType" id="opmType" class="combox" onchange="opmTypeChanged()">
						<option value="1">实时</option>
						<option value="2">定时</option>
					</select>
				</p>
				<p id="crontime" style="display:none">
					<label>执行时间：</label>
					<input size="28" minDate="<?php echo date('Y-m-d'); ?>" type="text" value="<?php echo ($_REQUEST['startTime']); ?>" id="cron" name="cron" readonly="true" datefmt="yyyy-MM-dd HH:mm:ss" class="date textInput">
				</p>
				<p>
					<label>计划类型：</label>
					<select name="disType" id="" class="combox">					
						<option value="3">新增</option>
						<option value="4">迭代</option>
					</select>
				</p>
				<p>
					<label>启动进程数：</label>
					<input type="text" size="28" class="required textInput" name="processNum" id="" value="<?php echo ($processNum); ?>" />
				</p>
				<p>
					<input type="hidden" value="<?php echo ($defaultInfo['defaultcfgid']); ?>" name="config.id">
					<label>配置文件：</label>
					<input type="text" size="28" class="required textInput" name="config.name" id="" value="<?php echo ($defaultInfo['defaultcfg']); ?>" readonly="true" />
					<a href="/index.php/Service/Repertory/select_info" rel="select_info_win" title="配置信息选择" mask="true" width="956" height="628" class="btnLook"  lookupgroup="config">查找带回</a>
				</p>
				<p>
					<label>备注：</label>
					<input type="text" size="28" class="textInput" name="demo" id="" />
				</p>
			</div>
		</div>
		<div class="formBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
				<li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
			</ul>
		</div>
	</form>
</div>

<script type="text/javascript">
function kkk(){
	var ips='';
	$("#productIpTree").find('.checked').each(function(index,obj){
		if ($(obj).next('a').hasClass('level2') ) {
			
			ips = ips + $(obj).next('a').attr('tvalue') + ',';
		}
	});
	
	$('#ips').val(ips.substring(0,ips.length-1));
	
}

function opmTypeChanged(){
	if ($('#opmType').val()==1) {
		$('#cron').removeClass("required");
		$('#cron').attr("readonly",true);
		$('#cron').addClass("readonly");
		$('#cron').val('');
		$('#crontime').hide();
	}else{
		$('#cron').addClass("required");
		$('#cron').attr("readonly",false);	
		$('#cron').removeClass("readonly");
		$('#crontime').show();
	}
};

$("#btn_search").click(function(){
	$.post('/index.php/Service/Repertory/callByReqs'
			,{ip:$("#ipte").val(),hostname:$("#hostnamete").val(),mwId:$("#mwId").val()}
			,function(data){
					$("#productIpTree").html(data.message).initUI();
			}
			,"json"
	);
	
});

function callDialogAjaxDone(json){
	var ips=$('#ips').val();
	if(ips==''){
		alertMsg.error('机器未选择');
		return false;
	}	
	DWZ.ajaxDone(json);
	//alert(json.statusCode);
	
	if(json.statusCode==1){
		navTab.openTab('D60604','/index.php/Service/Scheduling',{"title":"作业调度"});
		$.pdialog.closeCurrent();
	}
}

$(function(){
	$("#productIpTree").find("a").each(function(){
		if($(this).attr("checked")){
			$(this).css("color","#21a121");
		}
	})
})
</script>