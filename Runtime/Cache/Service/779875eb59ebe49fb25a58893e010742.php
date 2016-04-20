<?php if (!defined('THINK_PATH')) exit();?><form id="pagerForm" action="/index.php/Service/Download" method="post">
	<input type="hidden" name="pageNum" value="1"/>
	<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>
	<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
	<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
	<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
</form>

<div class="pageHeader">
	<form rel ="pagerForm" method="post"  onsubmit="return navTabSearch(this);" action="/index.php/Service/Download">
	<div class="searchBar">
		<ul class="searchContent">
			<li>
				<label>时间（起）：</label>
				<input type="text" value="<?php if($_REQUEST['start']) echo $_REQUEST['start'];else echo date('Y-m-d'); ?>" id="start" name="start" readonly="1" datefmt="yyyy-MM-dd" class="date textInput readonly">
			</li>
			<li>
				<label>时间（终）：</label>
				<input type="text" value="<?php if($_REQUEST['end']) echo $_REQUEST['end'];else echo date('Y-m-d'); ?>" id="end" name="end" readonly="1" datefmt="yyyy-MM-dd" class="date textInput readonly">
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
<div id="result"></div>
<div class="pageContent">
	<div class="panelBar" style="height:27px;">
		<ul class="toolBar">
			<li><a class="add" href="javascript:void(0)" onClick="Refresh(1)"><span>开始控制</span></a></li>
			<li><a class="delete" href="javascript:void(0)" onClick="Refresh(2)" ><span>停止控制</span></a></li>
		</ul>
	</div>
	<table class="table" width="100%" layoutH="120">
		<thead>
		<tr>
			<th width="200">序号</th>
			<th width="200">开始时间</th>
			<th width="200">结束时间</th>
			<th width="200">笔数</th>
		</tr>
		</thead>
		<tbody>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr target="sid_user" rel="<?php echo ($vo['srv']); ?>">
				<td>
					<?php
 $listnums = $numPerPage * ($currentPage-1) + $key+1; echo $listnums; ?>
				</td>
				<td><?php echo ($vo['startTime']); ?></td>
				<td><?php echo ($vo['endTime']); ?></td>
				<td><?php echo ($vo['count']); ?></td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</tbody>
	</table>
</div>


<script>

	
	function loadResult(){
		$.pdialog.open("/index.php/Service/Download/getRedisInfo",'operate','操作结果',{'width':'700','height':'400','mask':true});
	}
	
	function Refresh(i)
	{
		$.ajax({
	    	cache : false,
			type : 'post',
			url : "/index.php/Service/Download/throwMqs",
			global: false,
			dataType : 'json',
			data : {'_' : new Date().getTime(),isclose:i},
			success : function(response){
				//console.log("00000000000000000000");
				DWZ.ajaxDone(response);
				if(response.statusCode == 1){
					setTimeout("loadResult()",1000);
				}else{
					alertMsg.error(response.message);
				}
				
				
			}
	    });
	}
	
	//关闭窗口时，触发；
	_setoutTime = null;
	var dig = $.pdialog.getCurrent();
	if(!dig && _setoutTime) clearTimeout(_setoutTime);
</script>