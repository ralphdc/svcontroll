<?php if (!defined('THINK_PATH')) exit();?>
<form id="pagerForm" action="/index.php/Service/Proicon" method="post">
	<input type="hidden" name="pageNum" value="1"/>
	<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>
	<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
	<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
	<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
</form>

<style type="text/css">
	
	.upd{margin:10px;}
	.upd p{float: left;}
	.localsub{width: 73px; height: 24px;}
	.wn{display: block; padding-top:20px; }
	
</style>

<div class="pageContent">
	<div class="upd">
		<p><input type="file" value="upload" name="file_upload_icon_lg" id="file_upload_icon_lg" /></p>
		 <p class="wn">上传图片尺寸为：宽度60px 高度57px</p>
	</div>
	<table class="table" width="100%" layoutH="100">
		<thead>
		<tr>
			<th width="60">序号</th>
			<th class="center">预览</th>
			<th width="80">操作</th>
		</tr>
		</thead>
		<tbody id="icontbody">
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><if condition="strpos($vo,"")">
			<tr>
				<td><?php echo ($i); ?></td>
				<td style="background:url('/Public/Images/jtopolg/<?php echo ($vo); ?>') no-repeat center; height:100px;"></td>
				<td>
					<a class="btnSelect" title="查找带回" href="javascript:$.bringBack({'imgName':'<?php echo $vo; ?>'})">选择</a>
					<a class="btnDel" callback="reflashIcon" title="确实要删除这条记录吗" target="ajaxTodo" href="/index.php/Service/Proicon/delicon/icon/<?php echo (geticonname($vo)); ?>">删除</a> 
					
					<!-- 
						URL参数，如果有"."符号，会提交失败！； 2016-1-28
					 -->					
					
				</td>
			</tr>
			</notempty><?php endforeach; endif; else: echo "" ;endif; ?>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	   $("#file_upload_icon_lg").uploadify({
		        swf				: '/Public/uploadify/uploadify.swf',
		        uploader		: '/index.php/Service/Proicon/icon',
		        formData		: {
		        	'act':'upload',
		        	'js_source':'uploadify',
		        	'<?php echo session_name(); ?>':'<?php echo session_id(); ?>',
		        	'cookey':'<?php echo cookie('JSID'); ?>'
		        },
		        buttonText		: '本地上传',
		        fileTypeExts	: '*.png; *.jpg; *.jpeg;',
		        fileSizeLimit	: '20MB',
		        method			: 'post',
		        multi 			: false,
		        uploadLimit 	: 1,
		        //The maximum number of files you are allowed to upload.  When this number is reached or exceeded, the onUploadError event is triggered.
		        //uploadLimit 	: 1, 
		        onUploadError	: function(file, errorCode, errorMsg, errorString) {
		            alertMsg.error('文件： ' + file.name + ' 上传失败！返回消息： ' + errorString);
		        },
		        onUploadSuccess : function(file, data, response) {
		        	var rs = eval("("+data+")");
		        	var imageName = rs.image;
		        	var imageN = imageName.replace(".","|");
		        	if(rs.statusCode == 1){
		        		$.pdialog.reload('/index.php/Service/Proicon/icon/');
		        		alertMsg.correct(rs.message);
		        	}else{
		        		alertMsg.error(rs.message);
		        	}
		        },
		        onSelectError : function(file,errorCode,errorMsg) {
		        	alertMsg.error("上传失败！上传的文件后缀名需为png或jpg,jpeg，大小在20M以内。");
		        },
		        onUploadError : function(file, errorCode, errorMsg, errorString) {
		        	alertMsg.error('The file ' + file.name + ' could not be uploaded: ' + errorString);
		        }
		    });
	   
	   
	   function reflashIcon(json)
	   {
		   if (json.statusCode == DWZ.statusCode.ok) {
	            $.pdialog.reload('/index.php/Service/Proicon/icon/');
		   }else{
			   alertMsg.error(json.message);
		   }
	   }
</script>