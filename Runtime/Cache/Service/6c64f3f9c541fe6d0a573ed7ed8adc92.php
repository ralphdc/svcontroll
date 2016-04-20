<?php if (!defined('THINK_PATH')) exit();?><link href="/Public/dwz/themes/css/zTreeStyle/zTreeStyle.css" rel="stylesheet" type="text/css" />
<script src="/Public/dwz/js/jquery.ztree.all-3.5.js" type="text/javascript"></script>
<form id="pagerForm" action="/index.php/Service/Realmonitor" method="post">
	<input type="hidden" name="pageNum" value="1"/>
	<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>
	<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
	<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
	<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
</form>

<div id="monitorlist" class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="javascript:void(0)" onClick="Refresh()" id="refresh1"><span id="clickname1">开始监控</span></a></li>
		</ul>
	</div>
	<table class="table" width="100%" layoutH="138">
		<thead>
		<tr>
			<th>服务名</th>
			<th>IP地址</th>
			<th>元素</th>
			<th>值</th>
			<th>是否处理</th>
			<th>是否通知</th>
			<th>备注</th>
			<th>时间</th>
			<th>操作</th>
		</tr>
		</thead>
		<tbody>
			<!-- <tr rel="7813" target="SysMonitor" class=""><td><div>monitor_prog_db-140513.1-RELEASE</div></td><td><div>172.17.3.90</div></td><td><div>0024</div></td><td><div>database[172.18.0.</div></td><td><div>0</div></td><td><div>1</div></td><td><div></div></td><td><div>2014-05-14 17:43:03</div></td><td><div><div><a class="delete" title="关闭监控" onclick="onoff(&quot;0024&quot;,0,&quot;172.17.3.90&quot;,&quot;monitor_prog_db-140513.1-RELEASE&quot;)" href="javascript:void(0);">关闭监控</a>  |  <a class="add" title="开启监控" onclick="onoff(&quot;0024&quot;,1,&quot;172.17.3.90&quot;,&quot;monitor_prog_db-140513.1-RELEASE&quot;)" href="javascript:void(0);">开启监控</a></div></div></td></tr> -->
		</tbody>
	</table>
</div>


<script type="text/javascript" src="/Public/dwz/js/md5.js"></script>
<script type="text/javascript">
var comet = null;
var $isconnect = 0;
var timestamp = 0;
var checkcode = '';
var url = "/index.php/Service/Realmonitor/InvokRedis";

var Comet = function (data_url){
	this.url = data_url;
	this.connect = function(){
		timestamp = new Date().getTime();
	    var self = this;
	    $.ajax({
	    	cache : false,
			type : 'post',
			url : this.url,
			global: false,
			dataType : 'json',
			data : {'_' : timestamp,isconnect:$isconnect},
			success : function(response){
				if(response.msg !== "undefined" && response.msg !== ""){
					self.handleResponse(response.msg);
				}
			},
			complete : function(){
				if($isconnect == 1){
					comet.connect($isconnect);
				}
			}
	    });
	};
	
	var $box = $("#monitorlist");
	var tbody = $box.find("tbody");
	this.handleResponse = function(msginfo){
		var row= jQuery.parseJSON(msginfo);
		var trss = '<tr rel="'+row.seri+'" target="SysMonitor" class=""><td><div>'+row.servicename+'</div></td><td><div>'+row.ip+'</div></td><td><div>'+row.elemno+'</div></td><td><div>'+row.elemval+'</div></td><td><div>0</div></td><td><div>1</div></td><td><div>'+row.remark+'</div></td><td><div>'+row.time+'</div></td><td><div><div><a class="delete" title="关闭监控" onclick="onoff(&apos;'+row.elemno+'&apos;,0)" href="javascript:void(0);">关闭监控</a>  |  <a class="add" title="开启监控" onclick="onoff(&apos;'+row.elemno+'&apos;,1)" href="javascript:void(0);">开启监控</a></div></div></td></tr>';
    	$(tbody).prepend(trss);
	};
};

function Refresh(){
	comet = new Comet(url);
	if($isconnect == 0){
		$("#refresh1").removeClass().addClass("delete");
		$("#clickname1").html("暂停监控");
		$isconnect = 1;
		comet.connect($isconnect);
		return;
	}else if($isconnect == 1){
		$isconnect = 0;
		comet = null;
		$("#refresh1").removeClass().addClass("add");
		$("#clickname1").html("开始监控");
		return;
	}
}

function onoff(id,opty){
    var urlme = "/index.php/Service/Realmonitor/OnOff";
    $.post(urlme,{"id":id,"opty":opty},function(response){
        if(response == 'true'){
            alertMsg.correct("操作成功！");
            return true;
        }else{
        	alertMsg.error("操作失败！");
            return false;
        }
    });
    return false;
}

$(".close").click(function(){
	$isconnect = 0;
	comet = null;
});
</script>