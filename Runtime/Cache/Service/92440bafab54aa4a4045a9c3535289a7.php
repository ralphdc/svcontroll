<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">
		<form method="post" action="/index.php/Service/Mornode/add" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)" novalidate="novalidate">
			<div class="pageFormContent" layouth="58">
				<p>
					<label style="width:120px;">服务器：</label>
					<input type="text" size="20" value=""  name="ServerInfo.ip" readonly="readonly" />
					<a class="btnLook" href="/index.php/Service/Mornode/queryServer" width="900" height="600" lookupGroup="ServerInfo" >查找服务器</a>
				</p>
				<p>
					<label style="width:120px;">组名：</label>
					<input type="text" value=""  name="groupName" size="20" class="required" placeholder="请输入组名"  />
				</p>
				<p>
					<label style="width:120px;">默认采集时间：</label>
					<input type="text" value=""  name="defaultInterval"  class="required" placeholder="单位：秒"  />
				</p>
				<p>
					<label style="width:120px;">cpu采集间隔时间：</label>
					<input type="text" value=""  name="cpuInterval" class="required" placeholder="单位：秒" />
				</p>
				<p>
					<label style="width:120px;">内存采集间隔时间：</label>
					<input type="text" value=""  name="memoryInterval" class="required" placeholder="单位：秒" />
				</p>
				<p>
					<label style="width:120px;">网络采集间隔时间：</label>
					<input type="text" value=""  name="networkInterval" class="required" placeholder="单位：秒" />
				</p>
				<p>
					<label style="width:120px;">硬盘采集间隔时间：</label>
					<input type="text" value=""  name="diskInterval" class="required" placeholder="单位：秒" />
				</p>
				<p>
					<label style="width:120px;">是否启用：</label>
					<select name="enabled" class="combox">
						<option value="">请选择</option>
						<option value="true">启用</option>
						<option value="true">禁用</option>
					</select>
				</p>
				<style type="text/css">
					.spselect{display:none; position:absolute;z-index:1000}
					.content{display:block; padding:2px; width:120px; border:1px #c1c3c8 solid; background:#FFF;}
					.content li{display:block; height:25px;}
					.content li:hover{background:#007fc1;}
					.content li:hover span{color:#FFF; line-height:25px;}
					.content li span{color:#000; line-height:25px;}
				</style>
				<p>
					<label style="width:120px;">是否启用：</label>
					<input type="text" value=""  name="sptext" onclick="showSelect(this)" placeholder="单位：秒" />
					<div class="spselect">
						<ul class="content">
							<li><span>济南</span></li>
							<li><span>青岛</span></li>
							<li><span>烟台</span></li>
							<li><span>东京</span></li>
							<li><span>济南</span></li>
							<li><span>青岛</span></li>
							<li><span>烟台</span></li>
							<li><span>东京</span></li>
						</ul>
					</div>
					<script type="text/javascript">
					
					function showSelect(obj)
					{
						var window_left = $.pdialog.getCurrent().offset().left;
						var window_top = $.pdialog.getCurrent().offset().top;
						var top = $(obj).offset().top - window_top - 20;
						var left = $(obj).offset().left - window_left;
						$("div.spselect").css({'top':top,'left':left}).show();
					}
					/* $("input[name=sptext]").bind('click',function(){
						//if($(".spselect").is(":visible")) $(".spselect").hide();
						var window_left = $.pdialog.getCurrent().offset().left;
						var window_top = $.pdialog.getCurrent().offset().top;
						var top = $(this).offset().top - window_top - 20;
						var left = $(this).offset().left - window_left;
						$("div.spselect").css({'top':top,'left':left}).show();
					}) */
					
						
						
						$(".content li").click(function(){
							$("input[name=sptext]").val($(this).find("span").text());
							$(".content").hide();
						})
						
					</script>
				</p>
				<p>
					<label style="width:120px;">SNMP模板：</label>
					<input type="hidden" size="20"  name="Template.id" />
					<input type="text" size="20"  name="Template.tname" readonly="readonly" />
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