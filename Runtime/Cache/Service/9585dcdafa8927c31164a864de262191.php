<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">
<form method="post" action="/index.php/Service/Channelswitch/update" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)" novalidate="novalidate">
	<div class="pageFormContent" layouth="58" style="height: 297px; overflow: auto;">
			<p>
				<label>服务名：</label>
				<input type="hidden" name="channels.id" value="<?php echo $row['srvId'];?>">
				<input size="30" readonly class="readonly required textInput" type="text" name="channels.name" value="<?php echo $row['srvName'];?>">
				<a class="btnLook" href="/index.php/Service/Searchserv" mask="true" lookupGroup="channels" width="886" height="603">查找：</a>
				<input type="hidden" name="id" id="id" value="<?php echo $row['id'];?>" />
			</p>
			<p>
				<label>元素ID：</label>
				<input type="hidden" name="channele.id" value="<?php echo $row['elemId'];?>">
				<input size="30" readonly class="readonly required textInput" type="text" name="channele.name" value="<?php echo $row['elemId'];?>">
				<a class="btnLook" href="/index.php/Service/Searchelem" mask="true" lookupGroup="channele" width="886" height="603">查找：</a>
			</p>
			<p>
				<label>渠道名称：</label>
				<input class="required" type="text" id="name" name="name"  size="30" value="<?php echo $row['name'];?>"/>
			</p>
			<p>
				<label>IP地址：</label>
				<input class="required" type="text" id="ip" name="ip"  size="30" value="<?php echo $row['ip'];?>"/>
			</p>
			<p>
				<label>端口号：</label>
				<input class="required" type="text" id="port" name="port"  size="30" value="<?php echo $row['port'];?>"/>
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