<?php if (!defined('THINK_PATH')) exit();?>
<form id="pagerForm" action="/index.php/Service/DeviceInfo" method="post">
	<input type="hidden" name="pageNum" value="1"/>
	<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>
	<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
	<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
	<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
</form>


<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return navTabSearch(this);" action="/index.php/Service/DeviceInfo" method="post">
		<div class="searchBar">
			<ul class="searchContent">
				<li>
					<label>设备编号：</label>
					<input type="text" value="<?php echo ($_REQUEST['deviceNumber']); ?>" id="name" name="deviceNumber" class="textInput">
				</li>
				<li>
					<label>资产编号：</label>
					<input type="text" value="<?php echo ($_REQUEST['assetNumber']); ?>" id="name" name="assetNumber" class="textInput">
				</li>
				<li>
					<label>业务地址：</label>
					<input type="text" value="<?php echo ($_REQUEST['businessAddress']); ?>" id="name" name="businessAddress" class="textInput">
				</li>
				<li>
					<label>机柜：</label>
					<input type="text" value="<?php echo ($_REQUEST['cabinetname']); ?>" id="name" name="cabinetname" class="textInput">
				</li>
			</ul>
			<div class="subBar">
				<ul>
					<li><div class="buttonActive"><div class="buttonContent"><button type="submit">查询</button></div></div></li>
				</ul>
			</div>
		</div>
	</form>
</div>

<div class="pageContent">
	<div class="panelBar" style="height:29px;">
		<ul class="toolBar">
			<li><a rel="addServer" class="add" href="/index.php/Service/DeviceInfo/add" title="新增" height="715" width="540" target="dialog" mask="true"><span>新增</span></a></li>
			<li class="line">line</li>
			<li><a posttype="string" title="确实要删除选中记录吗？" rel="ids" target="selectedTodo" class="delete" href="/index.php/Service/DeviceInfo/foreverdelete/id/{sid_device}"><span>批量删除选中</span></a></li>
			<li class="line">line</li>
			<li style="position:relative">
				<style type="text/css">
					#file_upload {
					opacity: 0;
					position: absolute;
					z-index: 100;
					width:100px;
					}
				</style>
				<!-- <a class="edit" href="/index.php/Service/DeviceInfo/leading" target="dialog" mask="true" width="400" height="200"><span>从Excel导入</span></a>  -->
				<a class="edit" href="#"><span>从Excel导入</span></a>
				<input type="file" name="file_upload" id="file_upload" />
			</li>
			<li><a class="edit" href="/index.php/Service/DeviceInfo/uploadSee" target="navtab"><span>查看导入结果</span></a> </li>
		</ul>
	</div>
	
	<table class="table" width="100%" layoutH="138">
		<thead>
		<tr>
			<th class="center" style="width: 43px; cursor: default;"><div title="" class="gridCol"><input type="checkbox" class="checkboxCtrl" group="ids"></div></th>
			<th width="60">序号</th>
			<th>数据中心</th>
			<th>机柜</th>
			<th>设备编号</th>
			<th>品牌</th>
			<th width="100">型号</th>
			<th>资产编号</th>
			<th>配置信息</th>
			<th>服务编码</th>
			<th>责任人</th>
			<th>业务地址</th>
			<th>带外管理地址</th>
			<th width="105">备注</th>
			<th width="105">操作</th>
			
			
		</tr>
		</thead>
		<tbody>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr target="sid_device" rel="<?php echo ($vo['assetid']); ?>">
				<td class="center" style="width: 43px;"><div><input type="checkbox" value="<?php echo ($vo['assetid']); ?>" name="ids"></div></td>
				<td>
					<?php
 $listnums = $numPerPage * ($currentPage-1) + $key+1; echo $listnums; ?>
				</td>
				<td><?php echo ($vo['areaname']); ?></td>
				<td><?php echo ($vo['cabinetname']); ?></td>
				<td><?php echo ($vo['deviceNumber']); ?></td>
				<td><?php echo ($vo['brand']); ?></td>
				<td><?php echo ($vo['model']); ?></td>
				<td><?php echo ($vo['assetNumber']); ?></td>
				<td>CPU:<?php echo ((isset($vo['cpuinfo']) && ($vo['cpuinfo'] !== ""))?($vo['cpuinfo']):"--"); ?>  内存：<?php echo ((isset($vo['memoryinfo']) && ($vo['memoryinfo'] !== ""))?($vo['memoryinfo']):"--"); ?>  磁盘：<?php echo ((isset($vo['diskinfo']) && ($vo['diskinfo'] !== ""))?($vo['diskinfo']):"--"); ?></td>
				<td><?php echo ($vo['serviceNumber']); ?></td>
				<td><?php echo ($vo['dutyman']); ?></td>
				<td><?php echo ($vo['businessAddress']); ?></td>
				<td><?php echo ($vo['managementAddress']); ?></td>
				<td><?php echo ($vo['remark']); ?></td>
				<td>
					<a class="btnDel" target="ajaxTodo" title="确实要删除这条记录吗" href="/index.php/Service/DeviceInfo/delete/id/<?php echo ($vo['assetid']); ?>">删除</a>
					<a target="dialog" rel="fitting_index1" class="btnEdit" title="编辑" href="/index.php/Service/DeviceInfo/edit/id/<?php echo ($vo['assetid']); ?>" height="715" width="540">编辑</a>
				</td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</tbody>
	</table>
	<div class="panelBar">
		<div class="pages">
			<span>显示</span>
			<select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
				<?php
 $numPerPageArr = array(20,50,100,200); foreach($numPerPageArr as $val) { if($val == $numPerPage) $selected = 'selected'; echo '<option value="'.$val.'" '.$selected.'>'.$val.'</option>'; $selected = ''; } ?>
			</select>
			<span>条，共<?php echo ($totalCount); ?>条</span>
		</div>
		<div class="pagination" targetType="navTab" totalCount="<?php echo ($totalCount); ?>" numPerPage="<?php echo ($numPerPage); ?>" pageNumShown="5" currentPage="<?php echo ($currentPage); ?>"></div>
	</div>


</div>
	<script type="text/javascript">
		$(function() {
		    $("#file_upload").uploadify({
		        swf				: '/Public/uploadify/uploadify.swf',
		        uploader		: '/index.php/Service/DeviceInfo/leading',
		        formData		: {'act':'upload','js_source':'uploadify','<?php echo session_name(); ?>':'<?php echo session_id(); ?>'},
		        buttonText		: '选择文件',
		        fileTypeExts	: '*.xls; *.xlsx;',
		       fileSizeLimit	: '20MB',
		        method			: 'post',
		       
		        //The maximum number of files you are allowed to upload.  When this number is reached or exceeded, the onUploadError event is triggered.
		        //uploadLimit 	: 1, 
		        onUploadError	: function(file, errorCode, errorMsg, errorString) {
		            alertMsg.error('文件： ' + file.name + ' 上传失败！返回消息： ' + errorString);
		        },
		        onUploadSuccess : function(file, data, response) {
		        	var rs = eval("("+data+")");
		        	if(rs.statusCode == 1){
		        		alertMsg.correct(rs.message);
		        	}else{
		        		alertMsg.error(rs.message);
		        	}
		        },
		        onSelectError : function(file,errorCode,errorMsg) {
		        	alertMsg.error("上传失败！上传的文件后缀名需为xls或xlsx，大小在20M以内。");
		        }
		    });
		});

	</script>