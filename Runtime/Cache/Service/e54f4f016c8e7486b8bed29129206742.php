<?php if (!defined('THINK_PATH')) exit();?>
<form id="pagerForm" action="/index.php/Service/Graph" method="post">
	<input type="hidden" name="pageNum" value="1"/>
	<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>
	<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
	<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
	<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
</form>

<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return navTabSearch(this);" action="/index.php/Service/Graph" method="post">
	<div class="searchBar">
		<ul class="searchContent">
			<li>
			<label>物理图名称：</label>
			<input type="text" value="<?php echo ($_REQUEST['data']['topoName']); ?>" id="query" name="data[topoName]" class="textInput">
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
			<li><a class="add" href="/index.php/Service/Graph/add" title="新建拓扑图" rel="newTopo" target="dialog"  max="true" ><span>新增</span></a></li>
			<li><a posttype="string" title="确实要删除选中记录吗？" class="delete" onclick=" return deleteCookieCheckBox(this,event)" href="/index.php/Service/Graph/graphBatchDel"><span>批量删除选中</span></a></li>
			<li class="line">line</li>
			
		</ul>
	</div>

	<table class="table" width="100%" layoutH="138">
		<thead>
		<tr>
			<th class="center" style="width: 43px; cursor: default;"></th>
			<th width="60">序号</th>
			<th>拓扑名称</th>
			<th>创建日期</th>
			<th>创建者</th>
			<th>节点数</th>
			<th width="80">操作</th>
		</tr>
		</thead>
		<tbody class="currentTbody">
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
				<td class="center" style="width: 43px;">
					<div>
						<input type="checkbox" value="<?php echo ($vo["topoId"]); ?>" name="ids" onclick="recordCookie(this)">
					</div>
				</td>
				<td>
				<?php  $tag = ($currentPage-1)*$numPerPage + $i; ?>
				<?php echo $tag; ?>
				</td>
				<td><a href="/index.php/Service/Graph/monitor?id=<?php echo ($vo["topoId"]); ?>&start=1"  max="true"  rel="monitorTP" target="dialog" title="预览拓扑图-<?php echo ($vo["topoName"]); ?>" resizable="false"><?php echo ($vo["topoName"]); ?></a></td>
				<td><?php echo ($vo["createDate"]); ?></td>
				<td><?php echo ($vo["creator"]); ?></td>
				<td><?php echo ($vo["nodes"]); ?></td>
				<td width="200">
					<a class="btnDel" target="ajaxTodo" callback="delCallback" title="确实要删除这条记录吗" href="/index.php/Service/Graph/graphDel/id/<?php echo ($vo["topoId"]); ?>">删除</a>
					<a height="290" width="443" target="dialog"  class="btnEdit" max="true" title="编辑" rel="editGraphWindow" href="/index.php/Service/Graph/edit/id/<?php echo ($vo["topoId"]); ?>">编辑</a>
					<!--
					<a height="290" width="443" target="dialog"  class="btnMonitor" max="true" title="在线监控" href="/index.php/Service/Graph/Monitor/id/<?php echo ($vo["topoId"]); ?>">实时监控</a>
					-->
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

$(document).ready(function(){
	var cookieCheck = 'cookieCheckBox_graph';
	<?php if(trim($_GET['from']) == 'graphNav'): ?>
	$.cookie(cookieCheck,null);
	<?php endif; ?>
	<?php if(trim($_REQUEST['data']['topoName'])): ?>
	$.cookie(cookieCheck,null);
	<?php endif; ?>
	var cookieValid = $.cookie(cookieCheck);
	if(cookieValid != null && cookieValid != undefined && cookieValid!= ''){
		var cookieValidArr = cookieValid.split(",");
		if(cookieValidArr.length > 0){
			$(".currentTbody").find("input[type=checkbox]").each(function(){
				var ckv = $(this).val();
				if($.inArray(ckv,cookieValidArr) > -1){
					$(this).attr('checked',true);
				}
			})
		}
	}
});


var setIntervalCount = 0;
var intervals = [];
var intervalsd = [];
var CPUHistoryArray = [];
function delCallback(json){
	if(json.statusCode == 1){
		alertMsg.correct(json.message);
		if (json.navTabId) {
            navTab.reload(json.forwardUrl, {
                navTabId: json.navTabId
            });
        }
	}else{
		alertMsg.error(json.message);
	}
}


function recordCookie(checkbox)
{
	var ckv = $(checkbox).val();
	var cookieCall = $.cookie('cookieCheckBox_graph');
	if($(checkbox).is(":checked")){
		if(cookieCall != null && cookieCall != undefined && cookieCall!= ''){
			cookieCall += ',';
			cookieCall += ckv;
			$.cookie('cookieCheckBox_graph',cookieCall);
		}else{
			$.cookie('cookieCheckBox_graph',ckv);
		}
	}else{
		if(cookieCall != null && cookieCall != undefined && cookieCall!= ''){
			var cookieArr = cookieCall.split(",");
			if(cookieArr.length > 0){
				var i=0;
				for(i;i<cookieArr.length;i++){
					if(cookieArr[i] == ckv){
						cookieArr.splice(i,1);
					}
				}
				var cookieStr = cookieArr.join(',');
				$.cookie('cookieCheckBox_graph',cookieStr);
			}
		}
	}
	
}

function deleteCookieCheckBox(deletedom,event)
{
	event.preventDefault();
	var url = $(deletedom).attr('href');
	if(url == '' || typeof(url) == "undefined"){
		alertMsg.error("页面有错误，不能执行操作~！");
		return false;
	}
	var title = $(deletedom).attr("title");
    if (title) {
        alertMsg.confirm(title, {
            okCall: function() {
            	var cookieCall = $.cookie('cookieCheckBox_graph');
            	if(cookieCall != '' && cookieCall != undefined && cookieCall != null){
            		$.ajax({
            		    type: 'POST',
            		    url: url,
            		    dataType: "json",
            		    data: {'ids':cookieCall},
            		    cache: false,
            		    success: function(data){
            		    	if(data.statusCode == 1){
            		    		alertMsg.correct(data.message);
            		    		if (data.navTabId) {
            		                navTab.reload(data.forwardUrl, {
            		                    navTabId: data.navTabId
            		                });
            		            }
            		    		//清除已被记录的cookie;
            		    		$.cookie('cookieCheckBox_graph',null);
            		    	}else{
            		    		alertMsg.error(data.message);
            		    		if(data.statusCode == 2){
            		    			if (data.navTabId) {
                		                navTab.reload(data.forwardUrl, {
                		                    navTabId: data.navTabId
                		                });
                		            }
            		    		}
            		    	}
            		    },
            		    error: function(){
            		    	alertMsg.error('网络链接有错误~！');
            		    	return false;
            		    }
            		});
            	}else{
            		alertMsg.error('请选择正确的拓扑图进行删除！');
            	}
            }
        });
     }
}

</script>