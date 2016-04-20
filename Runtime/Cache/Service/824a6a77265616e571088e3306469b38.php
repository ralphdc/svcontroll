<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">
	<form method="post" action='/index.php/Service/Addmonelement/edit' class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone);" novalidate="novalidate">
		<div class="pageFormContent" layouth="46">
			<p>
				<label>元素名称：</label>
				<input class="required" type="text" id="elemName" name="elemName" maxlength="50" size="30" value="<?php echo $row['elemName'];?>"/>
				<input type="hidden" type="text" id="id" name="id"  value="<?php echo $row['id'];?>"/>
				<input type="hidden" type="text" id="pageNumb" name="pageNumb"  value="<?php echo ($pageNum); ?>"/>
			</p>
			<p>
				<label>处理方式：</label>
				<select name="dealMode" style="width:120px">
				<option value=''>请选择</option>
				<?php if(is_array($dealType) && !empty($dealType)){ foreach ($dealType as $tkey=>$tval) { if($tkey == $row['dealMode']) $selected = 'selected'; echo '<option value='.$tkey.' '.$selected.'>'.$tval.'</option>'; $selected =''; } }?>
				</select>
			</p>
			<p>
				<label>处理级别：</label>
				<select name="priority" style="width:120px">
				<?php if(is_array($firstorno) && !empty($firstorno)){ foreach ($firstorno as $fkey=>$fval) { if($fkey == $row['priority']) $selected = 'selected'; echo '<option value='.$fkey.' '.$selected.'>'.$fval.'</option>'; $selected =''; } }?>
				</select>
			</p>
			<p>
				<label>元素状态：</label>
				<select name="statusme" id="statusme" onchange="elementTypeChanged();" style="width:120px">
				<?php if(is_array($status) && !empty($status)){ foreach ($status as $tkey=>$tval) { if($tkey == $row['status']) $selected = 'selected'; echo '<option value='.$tkey.' '.$selected.'>'.$tval.'</option>'; $selected =''; } }?>
				</select>
			</p>
			<div id="timehide" style="display:none;">
			<p>
				<label>时间（起）：</label>
				<input  size="30" minDate="<?php echo date('Y-m-d'); ?>" type="text" value="<?php echo $row['start'];?>" id="start" name="start" readonly="1" datefmt="yyyy-MM-dd HH:mm:ss" class="dohide date textInput readonly">
			</p>
			<p>
				<label>时间（终）：</label>
				<input  size="30" minDate="<?php echo date('Y-m-d'); ?>" type="text" value="<?php echo $row['end'];?>" id="end" name="end" readonly="1" datefmt="yyyy-MM-dd HH:mm:ss" class="dohide date textInput readonly">
			</p>
			</div>
			<p id="currmodeid">
				<label>模式设置：</label>
				<select name="currmode" style="width:120px" onchange="toggleFiler(this)">
				<?php if(is_array($currmode) && !empty($currmode)){ foreach ($currmode as $ckkey=>$ckval) { if($ckkey == $row['currMode']) $selected = 'selected'; echo '<option value='.$ckkey.' '.$selected.'>'.$ckval.'</option>'; $selected =''; } }?>
				</select>
			</p>
			<p>
				<label>报警次数：</label>
				<input class="required digits" type="text" id="respWarnTimes" name="respWarnTimes" maxlength="50" size="30" value="<?php echo $row['respWarnTimes'];?>"/>
			</p>
			<p>
				<label>测试次数：</label>
				<input class="required digits" type="text" id="respTestTimes" name="respTestTimes" maxlength="50" size="30" value="<?php echo $row['respTestTimes'];?>"/>
			</p>
			
			<p>
				<label>时间间隔：</label>
				<input class="required digits" type="text" id="flowInterval" name="flowInterval" maxlength="50" size="30" value="<?php echo $row['flowInterval'];?>"/>（单位：分钟）
			</p>
			
			<p>
				<label>发送信息数：</label>
				<input class="required digits" type="text" id="msgNum" name="msgNum" maxlength="50" size="30" value="<?php echo $row['msgNum'];?>"/>
			</p>
			<p>
				<label>资源类型：</label>
				<select name="resId" style="width:120px">
				<option value=''>请选择</option>
				<?php if(is_array($resType) && !empty($resType)){ foreach ($resType as $tkkey=>$tkval) { if($tkkey == $row['resId']) $selected = 'selected'; echo '<option value='.$tkkey.' '.$selected.'>'.$tkval.'</option>'; $selected =''; } }?>
				</select>
			</p>
			<p>
				<label>消息备注：</label>
				<textarea id="remarks" name="remarks" style="width: 184px; height: 83px;" maxlength="200" onchange="this.value=this.value.substring(0, 200)" onkeydown="this.value=this.value.substring(0, 200)" onkeyup="this.value=this.value.substring(0, 200)"><?php echo $row['remarks'];?></textarea>
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
function elementTypeChanged(){
	if ($('#statusme').val()==1) {
		$('.dohide').removeClass("required");
		$('.dohide').attr("readonly",false);	
		$('.dohide').removeClass("readonly");
		$('.dohide').val('');
		$('#timehide').hide();
		$('#currmodeid').show();
		
	}else{
		$('.dohide').addClass("required");
		$('.dohide').attr("readonly",true);
		$('.dohide').addClass("readonly");
		$('#timehide').show();
		$('#currmodeid').hide();
	}
	
};



function toggleFiler(dom_obj){
	
	var currentValue = $(dom_obj).val();
	var currentText		= $(dom_obj).find('option:selected').text();
	if(currentText == '调试模式'){
		$("#currmodeid").after($("<p id='keyfilter'><label>关键字过滤：</label><input type='text' class='textInput' name='filter' id='filter' size='30'  value='<?php echo ($row["notifyFilter"]); ?>' /><input type='checkbox' name='flagFilter' value='1' "+strCheck+" />是否过滤</p>"));
	}else{
		if($("#keyfilter").length > 0){
			$("#keyfilter").remove();
		}
	}
}

$(function(){
	
	var checkFlag = '<?php echo ($row['flagFilter']); ?>';
	var checkFlagInt = Number(checkFlag);
	if(checkFlagInt){
		strCheck = "checked='checked'";
	}else{
		strCheck ="";
	}
	
	
	//2015-11-30 添加关键字过滤；
	if($("#currmodeid").is(':visible')){
		var selectTx = $("#currmodeid").find("select").find("option:selected").text();
		 if(selectTx == '调试模式'){
			$("#currmodeid").after($("<p id='keyfilter'><label>关键字过滤：</label><input type='text' name='filter' id='filter' class='textInput' size='30'  value='<?php echo ($row["notifyFilter"]); ?>' /><input type='checkbox' name='flagFilter' value='1' "+strCheck+" />是否过滤</p>"));
		} 
	}
	
	elementTypeChanged();
	
})
</script>