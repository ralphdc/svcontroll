<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent" style="width:300px; overflow:hidden">

	<form method="post" action="/index.php/Service/Operatmember/noticeSubmit"  class="pageForm required-validate" onsubmit="return validateCallback(this, noticeChangeAjaxDone)" novalidate="novalidate">
		<div class="pageFormContent">
				<input type="hidden" name="gid" value="<?php echo ($gid); ?>" />
				<input type="hidden" name="oid" value="<?php echo ($oid); ?>" />
				<p style="width:280px; overflow:hidden">
				<style type="text/css">
					.myfont{ 	font-size: 12px;
							    margin: 0;
							    padding: 6px 5px;
								float:left;
								color: #616161;
							    font-family: "Microsoft yahei",Arial,sans-serif;
							}
				</style>
					<label>联系人:</label> <span class="myfont"><?php echo ($nm); ?></span>
				</p>
				<p style="width:280px; overflow:hidden">
					<label>通知方式:</label>
					<?php
 $we_checked = ""; $email_checked = ""; $msg_checked = ""; if(intval($bintype[0]) == 1){ $we_checked = "checked='checked'"; } if(intval($bintype[1]) == 1){ $email_checked = "checked='checked'"; } if(intval($bintype[2]) == 1){ $msg_checked = "checked='checked'"; } ?>
						<input type="checkbox"  name="noticetype[wechat]" value="1" <?php echo $we_checked; ?>/>微信
						<input type="checkbox" name="noticetype[email]" value="1" <?php echo $email_checked; ?>/>邮件
						<input type="checkbox"  name="noticetype[msg]" value="1" <?php echo $msg_checked; ?> />短消息
				</p>
		</div>
	</form>
</div>

<script type="text/javascript">
	function noticeChangeAjaxDone(json){
		DWZ.ajaxDone(json);
		if(json.statusCode==200)
		{
			//更新树信息；
			updateNodeNotice(operate_tree,json.ntype)
			alertMsg.correct("操作成功!");
			
		}else{
			alertMsg.error(json.message);
		}
	}
</script>