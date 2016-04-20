<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">
		<form method="post" action="/index.php/Service/Mornode/add" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)" novalidate="novalidate">
			<div class="pageFormContent" layouth="58">
				<p>
					<label style="width:150px;">服务器：</label>
					<input type="text" size="20" value=""  name="ServerInfo.ip" readonly="readonly" />
					<a class="btnLook" href="/index.php/Service/Mornode/queryServer" width="900" height="600" lookupGroup="ServerInfo" >查找服务器</a>
				</p>
				<p>
					<label style="width:150px;">组名:</label>
					<input type="text" value=""  name="groupName" size="20" />
				</p>
				<p>
					<label style="width:150px;">默认采集时间:</label>
					<input type="text" value=""  name="defaultInterval"    />
				</p>
				<p>
					<label style="width:150px;">cpu采集间隔时间:</label>
					<input type="text" value=""  name="cpuInterval"/>
				</p>
				<p>
					<label style="width:150px;">内存采集间隔时间:</label>
					<input type="text" value=""  name="memoryInterval"/>
				</p>
				<p>
					<label style="width:150px;">网络采集间隔时间:</label>
					<input type="text" value=""  name="networkInterval"/>
				</p>
				<p>
					<label style="width:150px;">硬盘采集间隔时间:</label>
					<input type="text" value=""  name="diskInterval"/>
				</p>
				<p>
					<label style="width:150px;">是否启用:</label>
					<input type="text" value=""  name="enabled"/>
				</p>
				<p>
					<label style="width:150px;">SNMP模板:</label>
					<input type="text" value=""  name=""/>
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