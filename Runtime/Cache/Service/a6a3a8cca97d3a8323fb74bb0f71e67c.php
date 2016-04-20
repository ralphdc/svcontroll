<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">
	<form method="post" action='/index.php/Service/Schedhistroy/program' class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone);" novalidate="novalidate">
		<div class="pageFormContent" layouth="58">
			<p>
				<label>服务实例：</label>
				<input type="text" size="28" class="required textInput" name="disServicename" id="disServicename" value="<?php echo ($rowInfo['disServicename']); ?>" readonly="TRUE" />
				<input type="hidden" name="dispatched" id="dispatched" value="<?php echo ($rowInfo['dispatched']); ?>" />
				<input type="hidden" name="pnid" id="pnid" value="<?php echo ($rowInfo['pnId']); ?>" />
				<input type="hidden" name="instanceid" id="instanceid" value="<?php echo ($rowInfo['instanceid']); ?>" />
				
			</p>
			<p>
				<label>IP地址：</label>
				<input type="text" size="28" class="required textInput" name="disIpv" id="disIpv" value="<?php echo ($rowInfo['disIpv']); ?>" readonly="TRUE" />
			</p>
			<p>
				<label>部署路径：</label>
				<input type="text" size="28" class="required textInput" name="disPath" id="disPath" value="<?php echo ($rowInfo['disPath']); ?>" readonly="TRUE" />
			</p>
			<p>
				<label>部署组：</label>
				<input type="text" size="28" class="required textInput" name="group" id="group" value="<?php echo ($rowInfo['disGroup']); ?>" />
			</p>
			<p>
				<label>部署用户：</label>
				<input type="text" size="28" class="required textInput" name="owner" id="owner" value="<?php echo ($rowInfo['disOwner']); ?>" />
			</p>
			<p>
				<label>调度类型：</label>
				<select name="distype" id="distype">
					<?php
 $severStr = ''; foreach($status as $skey=>$sval) { if($skey == $rowInfo['disStatus']) $selected = 'selected'; $severStr .='<option value="'.$skey.'" '.$selected.'>'.$sval.'</option>'; $selected = ''; } echo $severStr; ?>
				</select>
			</p>
			<p>
				<label>部署类型：</label>
					<select name="opmtype" id="opmtype" onchange="changecron(this);">
						<?php
 $disStr = ''; foreach($distype as $dskey=>$dsval) { if($dskey == $rowInfo['disType']) $selected = 'selected'; $disStr .='<option value="'.$dskey.'" '.$selected.'>'.$dsval.'</option>'; $selected = ''; } echo $disStr; ?>
					</select>
			</p>
			<p id="crontimep" <?php if($rowInfo["disType"] == 1) echo 'style="display:none;"'?>>
				<label>时间表达式：</label>
				<input size="28" minDate="<?php echo date('Y-m-d'); ?>" type="text" value="<?php echo ($rowInfo['disCron']); ?>" id="cron" name="cron" readonly="true" datefmt="yyyy-MM-dd HH:mm:ss" class="date textInput">
			</p>
			<p>
					<input type="hidden" value="<?php echo ($rowInfo['config']['0']['id']); ?>" name="editconfig.id">
					<label>配置文件：</label>
					<input type="text" size="28" class="required textInput" name="editconfig.name" id="" readonly="true" value="<?php echo ($rowInfo['config']['0']['configInstanceName']); ?>" />
					<!-- <a href="/index.php/Service/Repertory/select_info" rel="select_info_win" title="配置信息选择" mask="true" width="892" height="562" class="btnLook"  lookupgroup="editconfig">查找带回</a> -->
				</p>
			<!-- <p>
				<label>操作人：</label>
				<input readonly type="text" size="28" class="required textInput" name="person" id="person" value="<?php echo ($_SESSION['cUserNo']); ?>" />
			</p> -->
			<p>
				<label>进程数：</label>
				<input type="text" size="28" class="required textInput" name="times" id="times" value="1" />
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
<script>
	function changecron(opmtype)
	{
		var opmtypeObj = $(opmtype);
		var opmtypeval = opmtypeObj.val();
		if(opmtypeval == 1)
		{
			$('#crone').removeClass("required");
			$('#crone').attr("readonly",true);
			$('#crone').addClass("readonly");
			$('#crone').val('');
			$('#crontimep').hide();
		}else if(opmtypeval == 2)
		{
			$('#crone').addClass("required");
			$('#crone').attr("readonly",false);	
			$('#crone').removeClass("readonly");
			$('#crontimep').show();
		}
	}
</script>