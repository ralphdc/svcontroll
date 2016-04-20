<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">
		<form method="post" action="/index.php/Service/Mornode/edit" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)" novalidate="novalidate">
			<div class="pageFormContent" layouth="58">
				<input  value="<?php echo ($data["nodeId"]); ?>" name="nodeId"   type="hidden" />
				<p>
					<label style="width:120px;">服务器：</label>
					<input type="text" size="20" value="<?php echo ($data["ip"]); ?>"  name="ServerInfo.ip" readonly="readonly" />
					<a class="btnLook" href="/index.php/Service/Mornode/queryServer" width="900" height="600" lookupGroup="ServerInfo" >查找服务器</a>
				</p>
				<p>
					<label style="width:120px;">组名：</label>
					<input type="text" value="<?php echo ($data["groupName"]); ?>"  name="groupName" size="20" class="required" placeholder="请输入组名"  />
				</p>
				<p>
					<label style="width:120px;">默认采集时间：</label>
					<input type="text" value="<?php echo ($data["defaultInterval"]); ?>"  name="defaultInterval"  class="required" placeholder="单位：秒"  />
				</p>
				<p>
					<label style="width:120px;">cpu采集间隔时间：</label>
					<input type="text" value="<?php echo ($data["cpuInterval"]); ?>"  name="cpuInterval" class="required" placeholder="单位：秒" />
				</p>
				<p>
					<label style="width:120px;">内存采集间隔时间：</label>
					<input type="text" value="<?php echo ($data["memoryInterval"]); ?>"  name="memoryInterval" class="required" placeholder="单位：秒" />
				</p>
				<p>
					<label style="width:120px;">网络采集间隔时间：</label>
					<input type="text" value="<?php echo ($data["networkInterval"]); ?>"  name="networkInterval" class="required" placeholder="单位：秒" />
				</p>
				<p>
					<label style="width:120px;">硬盘采集间隔时间：</label>
					<input type="text" value="<?php echo ($data["diskInterval"]); ?>"  name="diskInterval" class="required" placeholder="单位：秒" />
				</p>
				<p>
					<label style="width:120px;">是否启用：</label>
					<select name="enabled" class="combox">
						<option value="">请选择</option>
						<option value="true"  <?php if((bool)$data['enabled']):?> selected="selected" <?php endif; ?>>启用</option>
						<option value="false" <?php if(!(bool)$data['enabled']):?> selected="selected" <?php endif; ?>>禁用</option>
					</select>
				</p>
				<p>
					<label style="width:120px;">SNMP模板：</label>
					<input type="hidden" size="20"  name="Template.id" value="<?php echo ($data["template"]["templateId"]); ?>" />
					<input type="text" size="20"  name="Template.tname" value="<?php echo ($data["template"]["templateName"]); ?>" readonly="readonly" />
					<a class="btnLook" href="/index.php/Service/Mornode/queryTemplate" width="900" height="600" lookupGroup="Template" >查找模板</a>
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