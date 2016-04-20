<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">
<form method="post" action="/index.php/Service/Servermanage/add" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)" novalidate="novalidate">
	<div class="pageFormContent" layouth="58" style="height: 297px; overflow: auto;">
			<p>
				<label>主机IP：</label>
				<input class="required" type="text" id="ipv" name="ipv" maxlength="15" size="30" value="<?php echo $row['ipv'];?>"/>
			</p>
			<p style="height:auto;">
				<label>IP序列：</label>
				<textarea rows="10" cols="30" id="ips" name="ips"><?php echo ($row['ips']); ?></textarea>
			</p>
			<p>
				<label>主机名：</label>
				<input class="required" type="text" id="hostname" name="hostname" maxlength="50" size="30" value="<?php echo $row['hostname'];?>"/>
			</p>
			<p>
				<label>所属产品：</label>
				<input type="hidden" name="prt.pdId" value="<?php echo $row['product_ids'];?>">
				<input size="30" class="textInput" type="text" name="prt.pdName" value="<?php echo $row['product_ids'];?>">
				<a class="btnLook" href="/index.php/Service/Searchser" mask="true" lookupGroup="prt" width="886" height="603">查找：</a>
			</p>
			<p>
				<label>用户名：</label>
				<input class="required" type="text" id="username" name="username" maxlength="50" size="30" value="<?php echo $row['username'];?>"/>
			</p>
			<p>
				<label>密码：</label>
				<input type="password" id="password" name="password" maxlength="50" size="30" value="<?php echo $row['password'];?>"/>
			</p>
			<p>
				<label>所属环境：</label>
			    <select name="environment" style="width:100px">
				<?php if(is_array($environment) && !empty($environment)){ foreach ($environment as $enkey=>$enval) { echo '<option value='.$enkey.'>'.$enval.'</option>'; } }?>
				</select>
			</p>
			<p>
				<label>机器类型：</label>
			    <select name="isVirtual" onchange="showVirtual(this.value);" style="width:100px">
				<?php if(is_array($virtual) && !empty($virtual)){ foreach ($virtual as $tkey=>$tval) { echo '<option value='.$tkey.'>'.$tval.'</option>'; } }?>
				</select>
			</p>
			<p>
				<label>设备类型：</label>
			    <select name="dtype" style="width:100px">
			     <option value="" selected="selected">请选择</option>
				<?php if(is_array($deviceTypeList) && !empty($deviceTypeList)){ foreach ($deviceTypeList as $tkey=>$tval) { echo '<option value='.$tval['deviceid'].'>'.$tval['deviceName'].'</option>'; } }?>
				</select>
			</p>
			<p id="cardid">
				<label>远程控制卡 ：</label>
				<input type="text" id="controlcard" name="controlcard"  size="30" value="<?php echo $row['controlcard'];?>"/>
			</p>
			<p id="virtualCorrespondPhysicalId" style="display:none">
				<label>物理机名：</label>
				<input type="hidden" id="prttid" name="prtt.id" value="<?php echo $row['virtualCorrespondPhysicalId'];?>">
				<input id="physicalName" size="30" class="readonly textInput" type="text" name="prtt.name" value="<?php echo $row['physicalName'];?>" readonly="1">
				<a class="btnLook" href="/index.php/Service/Searchmec" mask="true" lookupGroup="prtt" width="886" height="603">查找：</a>
			</p>
			<p id="serverxh">
				<label>服务器型号：</label>
			    <select name="stId" style="width:100px">
				<?php if(is_array($MechinetypeInfo) && !empty($MechinetypeInfo)){ foreach ($MechinetypeInfo as $key=>$val) { echo '<option value='.$val['stId'].'>'.$val['stChar'].'</option>'; } }?>
				</select>
			
			</p>
			<p>
				<label>机房名称：</label>
			    <select name="arId" onchange="showCabit(this.value)" style="width:100px">
			    <option value="0">请选择机房</option>
				<?php if(is_array($AreamanageInfo) && !empty($AreamanageInfo)){ foreach ($AreamanageInfo as $key=>$val) { echo '<option value='.$val['arId'].'>'.$val['arName'].'</option>'; } }?>
				</select>
			
			</p>
			<p>
				<label>机柜名称：</label>
			    <select name="cabinet_id" id="cabinet_id" style="width:100px">
			    <option value="0">请选择机柜</option>
				</select>
			</p>
			<p id="systemoper">
				<label>操作系统：</label>
			    <select name="sysid" style="width:100px">
				<?php if(is_array($OperatesystemInfo) && count($OperatesystemInfo)){ foreach ($OperatesystemInfo as $key=>$val) { echo '<option value='.$val['sysid'].'>'.$val['system'].'</option>'; } }?>
				</select>
			
			</p>
			<p style="height:auto;">
				<label>备注：</label>
				<textarea rows="2" cols="30" id="serverdemo" name="serverdemo"><?php echo ($row['serverdemo']); ?></textarea>
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
	function showVirtual(val)
	{
		if(val == 1)
		{
			$('#virtualCorrespondPhysicalId').hide();
			$('#cardid').show();
			$('#physicalName').removeClass('required');
			$("#prttid").val('');
			$('#physicalName').val('');
			$('#systemoper').show();
		}else
		{
			$('#cardid').hide();
			$('#controlcard').val('');
			$('#virtualCorrespondPhysicalId').show();
			$('#physicalName').addClass('required');
			//$('#systemoper').hide();
		}
		
	}
	
	function showCabit(val)
	{
		if(val == 0)
		{
			alertMsg.error('请选择机房');
			return;
		}
		$.post('/index.php/Service/Servermanage/getCabitelist',{roomid:val},function(data){
			$('#cabinet_id').html(data);
		})
		
	}
</script>