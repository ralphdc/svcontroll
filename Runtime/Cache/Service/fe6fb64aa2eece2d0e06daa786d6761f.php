<?php if (!defined('THINK_PATH')) exit();?><style type="text/css">
	.warn{float:left;display:block;line-height: 20px; margin-top:5px; width: 22px; height: 20px;}
	.warnnumber h1{padding-top: 4px;}
	.info h1{margin-top: 6px;}

	.t-con-1{float:left;}
	.t-con-2{float:left;}
	.t-con-3{float:left;}

	.tcp-content{height:300px;}
	.warn-content{height:300px;}

	.run{border:1px #47af10 solid; color:#0c0;}
	.break{border:1px #d40808 solid; color:#ff0000;}

	.spTitle span{ padding-top:6px; padding-bottom:6px;}
</style>

<div class="pageContent">
<!-- 
	<div class="formBar">
		<ul style="text-align:left">
			<li><div class="buttonActive"><div class="buttonContent"><button onclick="goBack(<?php echo ($tpid); ?>)">返回上一页</button></div></div></li>
		</ul>
	</div>
-->
	<div class="nodeLeft" style="width:30%; float:left;">
		<div class="tabs" currentIndex="0" eventType="click">
			<div class="tabsHeader">
				<div class="tabsHeaderContent">
					<ul>
						<li>
							<a href="javascript:;">
								<span style="padding-top:4px; padding-bottom:4px;">基本信息</span>
							</a>
						</li>
						<li>
							<a href="javascript:;">
								<span style="padding-top:4px; padding-bottom:4px;">资产信息</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="tabsContent info" style="height:300px;">
				<div class="basic">
					<table class="list" width="100%">
						<tbody>
						<!-- 
							<tr>
								<td class="center" width="20%"><h1>ID：</h1></td>
								<td><?php echo ($nodeinfo['id']); ?></td>
							</tr>
						-->
							<tr>
								<td class="center" width="20%"><h1>主机名：</h1></td>
								<td><?php echo ($nodeinfo['hostName']); ?></td>
							</tr>
							<tr>
								<td class="center"><h1>IP地址：</h1></td>
								<td class="ip"><?php echo ($nodeinfo['ip']); ?></td>
							</tr>
							<tr>
								<td class="center"><h1>系统启动时间：</h1></td>
								<td><?php echo ($server['sysUpTime']); ?></td>
							</tr>
							<tr>
								<td class="center"><h1>系统状态：</h1></td>
								<td>
								<?php if($server['sysStatus'] == 'RUNNING'): ?>
								<span class="run">正常</span>
								<?php else: ?>
								<span class="break">宕机</span>
								<?php endif; ?>
								</td>
							</tr>
							<tr>
								<td class="center"><h1>系统描述：</h1></td>
								<td><?php echo ($server['sysDescr']); ?></td>
							</tr>
							<tr>
								<td class="center"><h1>主机类型：</h1></td>
								<td>
								<?php
 if($nodeinfo['vm'] == 1): ?>
								物理机
								<?php else: ?>
								虚拟机
								<?php endif;?>
								</td>
							</tr>
							<?php if($nodeinfo['vm'] == 2): ?>
							<tr>
								<td class="center"><h1>物理机主机名：</h1></td>
								<td><?php echo ($nodeinfo['phyServerHostname']); ?></td>
							</tr>
							<?php endif; ?>
							<tr>
								<td class="center"><h1>所属环境：</h1></td>
								<td><?php echo ($environment[$nodeinfo['environment']]); ?></td>
							</tr>
							<tr>
								<td class="center"><h1>所属产品：</h1></td>
								<td><?php echo ($nodeinfo['product']); ?></td>
							</tr>
							<tr>
								<td class="center"><h1>服务器型号：</h1></td>
								<td><?php echo ($nodeinfo['serverModel']); ?></td>
							</tr>
							<tr>
								<td class="center"><h1>机房名称：</h1></td>
								<td><?php echo ($nodeinfo['room']); ?></td>
							</tr>
							<tr>
								<td class="center"><h1>机柜信息：</h1></td>
								<td><?php echo ($nodeinfo['cabinet']); ?></td>
							</tr>
							<tr>
								<td class="center"><h1>操作系统：</h1></td>
								<td><?php echo ($nodeinfo['os']); ?></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="property">资产信息</div>
			</div>
			<div class="tabsFooter">
				<div class="tabsFooterContent"></div>
			</div>
		</div>
	</div>
	<div class="nodeRight" style="width:68%; float:right;">
		<div class="tabs t-con-1" currentIndex="0" eventType="click">
			<div class="tabsHeader">
				<div class="tabsHeaderContent">
					<ul>
						<li onclick="flashYcpu()">
							<a href="javascript:;">
								<span>CPU仪表盘</span>
							</a>
						</li>
						<li onclick="flashZcpu()">
							<a href="javascript:;">
								<span>CPU柱状图</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="tabsContent info" style="height:300px; width:300px">
				<div class="basic" id="cpu" style="height:290px; width:300px"></div>
				<div class="basic" id="cpu_axis" style="height:290px; width:100%; padding-top:10px;"></div>
			</div>
		</div>
		<div class="tabs t-con-2" currentIndex="0" eventType="click">
			<div class="tabsHeader">
				<div class="tabsHeaderContent">
					<ul>
						<li onclick="flashYmem()">
							<a href="javascript:;">
								<span>内存仪表盘</span>
							</a>
						</li>
						<li onclick="flashZmem()">
							<a href="javascript:;">
								<span>内存柱状图</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="tabsContent info" style="height:300px;">
				<div class="basic" id="mem" style="height:300px; width:100%"></div>
				<div class="basic" id="mem_axis" style="height:290px; width:100%; padding-top:10px;"></div>
			</div>
		</div>
		<div class="tabs t-con-2" currentIndex="0" eventType="click">
			<div class="tabsHeader">
				<div class="tabsHeaderContent">
					<ul>
						<li onclick="flashYdisk()">
							<a href="javascript:;">
								<span>磁盘仪表盘</span>
							</a>
						</li>
						<li onclick="flashZdisk()">
							<a href="javascript:;">
								<span>磁盘柱状图</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="tabsContent info" style="height:300px;">
				<div class="basic" id="disk" style="height:300px; width:100%"></div>
				<div class="basic" id="disk_axis" style="height:290px; width:100%; padding-top:10px;"></div>
			</div>
		</div>
	</div>
	<div style="width:100%; clear:both;">
	<div class="tabs" currentIndex="0" eventType="click">
			<div class="tabsHeader">
				<div class="tabsHeaderContent">
					<ul>
						<li>
							<a href="javascript:;">
								<span>告警信息</span>
							</a>
						</li>
						<li>
							<a href="javascript:;">
								<span>服务进程</span>
							</a>
						</li>
						<li>
							<a href="javascript:;">
								<span>TCP链接</span>
							</a>
						</li>
						<li onclick="CPUHistory()">
							<a href="javascript:;">
								<span>CPU历史数据</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
			
			<div class="tabsContent warnnumber">
				<div class="warn-content">
					<table class="table" width="100%">
					<tbody>
						<tr>
							<td width="200"><h1>服务名</h1></td>
							<td width="120"><h1>持续时间</h1></td>
							<td width="60"><h1>服务状态</h1></td>
							<td width="280"><h1>所在路径</h1></td>
							<td width="70" class="center"><h1>服务进程号</h1></td>
							<td width="70" class="center"><h1>服务版本</h1></td>
							<td width="60" class="center"><h1>告警数量</h1></td>
						</tr>
						<?php if(is_array($warn)): $i = 0; $__LIST__ = $warn;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
							<td><?php echo ($vo["service"]); ?></td>
							<td><?php echo ($vo["time"]); ?></td>
							<td class="center"><?php echo (checkservicestatus($vo["status"])); ?></td>
							<td><?php echo ($vo["path"]); ?></td>
							<td class="center"><?php echo ($vo["pid"]); ?></td>
							<td class="center"><?php echo ($vo["version"]); ?></td>
							<td class="center">
								<p class="warn"><?php echo ($vo["warns"]); ?></p>
								<a  target="dialog"  class="btnMonitor" mask="true" width="800" height="400" title="告警详情" href="/index.php/Service/Graph/Service/service/<?php echo ($vo["service"]); ?>/ip/<?php echo str_replace(".", "-", $nodeinfo['ip']);?>/">查看详情</a>
							</td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</tbody>
					</table>
				</div>
				<!-- 服务进程 -->
				<div class="process-content pageContent">
					<table class="table processTable" width="100%" layoutH="450" >
						<thead>
							<tr>
								<th>序号</th>
								<th>进程名称</th>
								<th>进程数</th>
								<th>CPU使用率</th>
								<th>内存</th>
								<th>状态</th>
							</tr>
						</thead>
						<tbody>
							<?php  $i=0; foreach($process as $pk=>$pv): ?>
							<tr>
								<td><?php echo ++$i; ?></td>
								<td><?php echo $pk; ?></td>
								<td><?php echo $pv['processNum']; ?></td>
								<td><?php echo number_format($pv['cpuUsage'] * 100,2); ?>%</td>
								<td><?php echo number_format($pv['memorySpace'],2); ?>MB</td>
								<td>
									running<b>(<?php echo $pv['running']; ?>)</b>,
									runnable<b>(<?php echo $pv['runnable']; ?>)</b>,
									notRunnable<b>(<?php echo $pv['notRunnable']; ?>)</b>,
									invalid<b>(<?php echo $pv['invalid']; ?>)</b>,
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<!-- TCP链接 -->
				<div class="tcp-content">
					<table class="list tcpHeader" width="50%">
						<tbody>
							<tr>
								<td width="20%"><b>TCP 连接状态统计</b></td>
								<td>
								<?php foreach($tcp['tcpStatisticData'] as $stak=>$stav): ?>
								<?php if(intval($stav) > 0): ?>
								<?php echo $stak;?>:<?php echo $stav;?>&nbsp;&nbsp;&nbsp;&nbsp;
								<?php endif; ?>
								<?php endforeach; ?>
								</td>
							</tr>
						</tbody>
					</table>
					<table class="table tcpTable" width="100%" layoutH="480">
						<thead>
							<tr>
								<th>编号</th>
								<th>本地地址</th>
								<th>本地端口</th>
								<th>远程地址</th>
								<th>远程端口</th>
								<th>状态</th>
							</tr>
						</thead>
						<tbody>
							<?php $i=0; foreach($tcp['tcpConnMsg'] as $t): ?>
								<tr>
									<td><?php echo ++$i; ?></td>
									<td><?php echo $t['tcpConnLocalAddress']; ?></td>
									<td><?php echo $t['tcpConnLocalPort']; ?></td>
									<td><?php echo $t['tcpConnRemAddress']; ?></td>
									<td><?php echo $t['tcpConnRemPort']; ?></td>
									<td><?php echo $t['tcpConnState']; ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<!-- CPUHistory -->
				<div class="process-content pageContent cpu_history_box" id="cpu_history_box" style="height:300px;">
					
				</div>
			</div>
			<div class="tabsFooter">
				<div class="tabsFooterContent"></div>
			</div>
		</div>
		</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	 var box_width = $(".nodeRight").width();

	 var box_con_width = parseInt(box_width * 0.32);
	 var box_margin = parseInt(box_width * 0.03);

	 var real = box_margin > 5 ? 5 : box_margin;
	 $(".t-con-1").width(box_con_width);
	 $(".t-con-2").css('margin-left',real).width(box_con_width);
	 $(".t-con-3").css('margin-left',real).width(box_con_width);
	 
	 //修改切换条高度；	 
	 $(".tabsHeaderContent").find("span").css({'padding-top':'10px','padding-bottom':'10px'});
	 
	 //定义全局对象，存储上一次的获取信息；
	 var monitorRes 	= {};
	//CPU仪表盘；
	 var CPUcharts 		= null;
	//内存仪表盘；
	 var MEMcharts 		= null;
	//磁盘仪表盘；
	 var DISKcharts 	= null;
	 
	 
	//CPU柱状图；
	 var cpu_axis_Chart = null;
	//内存柱状图；
	 var mem_axis_Chart = null;
	//磁盘柱状图；
	 var disk_axis_Chart = null;
	 
	 //定义保存磁盘路径的全局变量；
	 var global_disk_path = null;
	 
	 var option = {
			 tooltip : {
			        trigger: 'axis',
			        formatter: "{a} <br/>{b} : {c}%" ,
			        showDelay:0,
			        transitionDuration:0,
			        hideDelay:50
			    },  
			 series: [
					     {
				            name: '',
				            type: 'gauge',
				            detail: {formatter:'{value}%'},
				            data: [{value: 0, name: ''}],
				            radius: '80%'
					      }
					 ]
	}

	var axis_option = {
	    title : {
	        //text: 'CPU占用比'                   
	    },  
	    tooltip : {
	        trigger: 'axis',
	        formatter: "{a} <br/>{b} : {c}%" ,
	    },  
	    legend: {
	        data:[
	            '总处理能力',  
	            '已使用'  
	        ]  
	    },  
	    calculable : true,  
	    grid: {x :50 , y: 40 ,x2:20 , y2:30},  
	    xAxis : [  
	        {  
	            type : 'category',  
	            data :  ['CPU1','CPU2']  
	        },  
	    ],  
	    yAxis : [  
	        {  
	            type : 'value',  
	            axisLabel:{formatter:'{value} %'} ,
	            min:0,
	            max:100
	        }  
	    ],  
	    series : [
	          {
	              name:'使用百分比(%)',  
	              legendHoverLink:false,
	              type:'bar', 
	              data:[]
	          }
	    ]  
	}
	 
	 //磁盘配置项；
	 var disk_axis_option = {
			    title : {
			        //text: 'CPU占用比'                   
			    },  
			    tooltip : {
			        trigger: 'axis',
			        formatter: "{a} <br/>{b} : {c}%" ,
			    },  
			    legend: {
			        data:[
			            '总处理能力',  
			            '已使用'  
			        ]  
			    },  
			    calculable : true,  
			    grid: {x :50 , y: 40 ,x2:20 , y2:30},  
			    xAxis : [  
			        {  
			            type : 'category',  
			            data :  ['CPU1','CPU2']  
			        },  
			    ],  
			    yAxis : [  
			        {  
			            type : 'value',  
			            axisLabel:{formatter:'{value} %'} ,
			            min:0,
			            max:100
			        }  
			    ],  
			    series : [
			          {
			              name:'使用百分比(%)',  
			              legendHoverLink:false,
			              type:'bar', 
			              data:[]
			          }
			    ]  
			}
	 
	 
	var bar_option = {
			    title: {
			        text: '99',
			    },
			    tooltip: {
			        trigger: 'axis',
			        formatter: "{a}: {c}%" ,
			    },
			    legend: {
			        data:['9','9']
			    },
			    toolbox: {
			        show: true,
			    },
			    //X轴；
			    xAxis:  {
			        type: 'category',
			        boundaryGap: false,
			        axisLabel: {
			            interval: 10
			        },
			        data: []
			    },
			    //Y轴；
			    yAxis: {
			        type: 'value',
			        axisLabel: {
			            formatter: '{value} %'
			        },
			        min:0,
		            max:100
			    },
			    series: [
			        {
			            name:'tt',
			            type:'line',
			            detail: {formatter:'{value}%'},
			            data:[],
			        }
			    ]
			};
		

	 
	 
	$.ajaxSettings.global = false;						
	window.flashCPU = function(){
		var ips = $(".ip").text();
		if(IsTrue(ips)){
			$.ajax({
				type:"POST",
				dataType:"json",
				url:"/index.php/Service/MonitorService/pushInfo",
				data:{'ips':ips},
				success:function(res){
					if(res.statusCode == 1 || res.statusCode == 0){
						var monitor = res.data;
						 /**
						 **  下面是仪表盘；
						 **/
						 //cpu仪表盘；
						  var cpuUse 	= monitor.cpu  ? parseInt(monitor.cpu)  :  0;
						  var cpuDom 	= document.getElementById('cpu');
						 if(!CPUcharts){
							 //第一次设置；
							 CPUcharts 	=  echarts.init(cpuDom);
							 option.series[0].data[0].value 	=  cpuUse;
							 option.series[0].data[0].name 		= 'CPU使用率';
							 CPUcharts.setOption(option, true);
							 //给全局变量赋值，保留原始数据；
							 monitorRes.cpu = cpuUse;
						 }else{
							 //更新数据,判断数据是否有变化；
							 if(monitorRes.cpu != cpuUse){
								 var cfg_option = CPUcharts.getOption();
								 cfg_option.series[0].data[0].value = cpuUse;   
								 CPUcharts.setOption(cfg_option,true); 
							     monitorRes.cpu = cpuUse;
							 }
						 }
						 
						 //内存仪表盘；
						 var memUse 	= monitor.mem  ? parseInt(monitor.mem)  :  0;
						 var memDom 	= document.getElementById('mem');
						 if(!MEMcharts){
							 //第一次设置；
							 MEMcharts 	=  echarts.init(memDom);
							 option.series[0].data[0].value 	=  memUse;
							 option.series[0].data[0].name 		= '内存使用率';
							 MEMcharts.setOption(option, true);
							 //给全局变量赋值，保留原始数据；
							 monitorRes.mem = memUse;
						 }else{
							 //更新数据,判断数据是否有变化；
							 if(monitorRes.mem != memUse){
								 var cfg_option = MEMcharts.getOption();
								 cfg_option.series[0].data[0].value = memUse;   
							     MEMcharts.setOption(cfg_option,true); 
							     monitorRes.mem = memUse;
							 }
						 }
						 //磁盘仪表盘；
						 var diskUse 	= monitor.disk ? parseInt(monitor.disk) : 0;
						 var diskDom 	= document.getElementById('disk');
						 if(!DISKcharts){
							 //第一次设置；
							 DISKcharts 						=  echarts.init(diskDom);
							 option.series[0].data[0].value 	=  diskUse;
							 option.series[0].data[0].name 		= '磁盘使用率';
							 DISKcharts.setOption(option, true);
							 //给全局变量赋值，保留原始数据；
							 monitorRes.disk = diskUse;
						 }else{
							 //更新数据,判断数据是否有变化；
							 if(monitorRes.disk != diskUse){
								 var cfg_option = DISKcharts.getOption();
								 cfg_option.series[0].data[0].value = diskUse;   
							     DISKcharts.setOption(cfg_option,true); 
							     monitorRes.disk = diskUse;
							 }
						 }
						 
						 /**
						 ** 下面是柱状图；
						 **/
						 
						 //cpu柱状图；
						 var cup1info = monitor.cpu1 ? monitor.cpu1 : 0;
					     var cup2info = monitor.cpu2 ? monitor.cpu2 : 0;
					     var cpu1 = parseInt(cup1info);
					     var cpu2 = parseInt(cup2info);
					     
						 if(!cpu_axis_Chart){
						     if(IsTrue(cpu1) && IsTrue(cpu2)){
						    	 axis_option.xAxis[0].data = ['CPU1','CPU2'];
						    	 axis_option.series[0].data = [cpu1,cpu2];
								 cpu_axis_Chart = echarts.init(document.getElementById('cpu_axis'));
								 cpu_axis_Chart.setOption(axis_option);
								 monitorRes.cpu1 = cpu1;
								 monitorRes.cpu2 = cpu2;
							 }
						 }else{
							 if(monitorRes.cpu1 != cpu1  || monitorRes.cpu2 != cpu2 ){
								 if(IsTrue(cpu1) && IsTrue(cpu2)){
							    	 var axis_cfg_option = cpu_axis_Chart.getOption();
							    	 axis_cfg_option.series[0].data = [cpu1,cpu2];
									 cpu_axis_Chart.setOption(axis_cfg_option);
									 monitorRes.cpu1 = cpu1;
									 monitorRes.cpu2 = cpu2;
								 }
							 }
						 }
						  //内存柱状图；
						 var mem 	= monitor.mem ? monitor.mem : 0;
						 var mems 	= parseInt(mem);
						 if(!mem_axis_Chart){
							 if(IsTrue(mems)){
						    	 axis_option.xAxis[0].data = ['内存使用率'];
						    	 axis_option.series[0].data = [mems] ;
								 mem_axis_Chart = echarts.init(document.getElementById('mem_axis'));
								 mem_axis_Chart.setOption(axis_option);
								 monitorRes.mems = mems;
							 }
						 }else{
							 if(monitorRes.mems != mems){
								 if(IsTrue(mems)){
									 var axis_cfg_option_z = mem_axis_Chart.getOption();
									 axis_cfg_option_z.series[0].data = [mems] ;
									 mem_axis_Chart.setOption(axis_cfg_option_z,true);
									 monitorRes.mems = mems;
								 }
							 }
						 }
						 
						 //磁盘柱状图；
						 var path 	= monitor.path ? monitor.path : '';
					     var sdata 	= monitor.skdata ? monitor.skdata : '';
					     
					     if(!disk_axis_Chart){
					    	 if(IsTrue(path) && IsTrue(sdata)){
						    	 var pathArr = path;
						    	 var real = Array();
						    	 var i=0;
						    	 for(i; i<pathArr.length; i++){
						    		if(countStrNumber("/",pathArr[i]) > 1){
						    			real.push(pathArr[i].substring(0,pathArr[i].indexOf("/",1)));
						    		}else{
						    			real.push(pathArr[i]);
						    		}
						    	 }
						    	//保存磁盘路径；
						    	 disk_axis_option.xAxis[0].data = real;
						    	 disk_axis_option.series[0].data = sdata;
						    	 disk_axis_option.tooltip.formatter=function(params){
						    		 var find = params[0].name.replace(/\//g,"");
						    		 for(var i=0; i<path.length; i++){
						    			 if(path[i].indexOf(find) > -1){
						    				 return path[i]+"<br/>" + params[0].value + "%";
						    			 }
						    		 } 
						    	 } 
								 disk_axis_Chart = echarts.init(document.getElementById('disk_axis'));
								 disk_axis_Chart.setOption(disk_axis_option);
								 monitorRes.path = path;
								 monitorRes.sdata = sdata;
								 
							 }
						 }else{
							 if($.isArray(monitorRes.path) && $.isArray(monitorRes.sdata) && ( monitorRes.path.toString() != path.toString() || monitorRes.sdata.toString() != sdata.toString())){
								 if(IsTrue(path) && IsTrue(sdata)){
							    	 var pathArr = path;
							    	 var real = Array();
							    	 var i=0;
							    	 for(i; i<pathArr.length; i++){
							    		if(countStrNumber("/",pathArr[i]) > 1){
							    			real.push(pathArr[i].substring(0,pathArr[i].indexOf("/",1)));
							    		}else{
							    			real.push(pathArr[i]);
							    		}
							    	 }
							    	
							    	 var axis_cfg_option = disk_axis_Chart.getOption();
							    	 axis_cfg_option.xAxis[0].data = real;
							    	 axis_cfg_option.series[0].data = sdata;
									 disk_axis_Chart.setOption(axis_cfg_option);
									 monitorRes.path = path;
									 monitorRes.sdata = sdata;
								 }
							 }
						 }
					}
				},
				error:function(xhr,msg,err){
					
				},
				complete:function(){
					window.setTimeout("flashCPU()",10000);
				}
			})
		}
	}
	 
	
	
	 window.flashCPU();
	 
	 //CPU仪表盘；
	 window.flashYcpu = function()
	 {
		var info = monitorRes;
		$("#cpu").remove();
		$("#cpu_axis").before("<div id='cpu' style='height:290px; width:100%;'></div>");
		var cpuUse 	= info.cpu ? info.cpu : 0;
		var cpuDom = document.getElementById('cpu');
		cpuChart = echarts.init(cpuDom);
		option.series[0].data[0].value  = cpuUse;
		option.series[0].data[0].name 	= 'CPU使用率';
		cpuChart.setOption(option, true);
	 }
	 
	//cpu柱状图；
	 window.flashZcpu = function()
	 {
		var info = monitorRes;
		$("#cpu_axis").remove();
		$("#cpu").after("<div id='cpu_axis' style='height:290px; width:100%;'></div>");
		 var cup1info = info.cpu1 ? info.cpu1 : 0;
	     var cup2info = info.cpu2 ? info.cpu2 : 0;
	     var cpu1 = parseInt(cup1info);
	     var cpu2 = parseInt(cup2info);
	     
	    // if(IsTrue(cpu1) && IsTrue(cpu2)){
	    	 axis_option.xAxis[0].data = ['CPU1','CPU2'];
	    	 axis_option.series[0].data = [cpu1,cpu2];
			 cpu_axis_Chart = echarts.init(document.getElementById('cpu_axis'));
			 cpu_axis_Chart.setOption(axis_option);
		// }
	 }
	
	
	 //内存仪表盘
	 window.flashYmem = function()
	 {
		var info = monitorRes;
		$("#mem").remove();
		$("#mem_axis").before("<div id='mem' style='height:290px; width:100%;'></div>");
		var memUse 	= info.mem ? info.mem : 0;
		var memDom = document.getElementById('mem');
		memChart = echarts.init(memDom);
		option.series[0].data[0].value  = memUse;
		option.series[0].data[0].name 	= '内存使用率';
		memChart.setOption(option, true);
	 }
	 
	 //内存柱状图；
	 window.flashZmem = function()
	 {
		var info = monitorRes;
		$("#mem_axis").remove();
		$("#mem").after("<div id='mem_axis' style='height:290px; width:100%;'></div>");
		var mem = info.mem ? info.mem : 0;
		 var mems 	= parseInt(mem);
		// if(IsTrue(mems)){
	    	 axis_option.xAxis[0].data = ['内存使用率'];
	    	 axis_option.series[0].data = [mems] ;
			 mem_axis_Chart = echarts.init(document.getElementById('mem_axis'));
			 mem_axis_Chart.setOption(axis_option);
		// }
	 }
	 
	 
	 //磁盘仪表盘；
	 window.flashYdisk = function()
	 {
		var info = monitorRes;
		$("#disk").remove();
		$("#disk_axis").before("<div id='disk' style='height:290px; width:100%;'></div>");
		var diskUse 	= info.disk ? info.disk : 0;
		var diskDom 	= document.getElementById('disk');
		diskChart 	= echarts.init(diskDom);
		option.series[0].data[0].value  = diskUse;
		option.series[0].data[0].name 	= '磁盘使用率';
		diskChart.setOption(option, true);
	 }
	 
	 //磁盘柱状图；
	 window.flashZdisk = function()
	 {
		var info = monitorRes;
		$("#disk_axis").remove();
		$("#disk").after("<div id='disk_axis' style='height:290px; width:100%;'></div>");
		
		var path 	= info.path ? info.path : '';
	    var sdata 	= info.sdata ? info.sdata : '';
	    // if(IsTrue(path) && IsTrue(sdata)){
	    	 var pathArr = path;
	    	 var real = Array();
	    	 var i=0;
	    	 for(i; i<pathArr.length; i++){
	    		if(countStrNumber("/",pathArr[i]) > 1){
	    			real.push(pathArr[i].substring(0,pathArr[i].indexOf("/",1)));
	    		}else{
	    			real.push(pathArr[i]);
	    		}
	    	 }
	    	 
	    	 disk_axis_option.xAxis[0].data = real;
	    	 disk_axis_option.series[0].data = sdata;
	    	 disk_axis_option.tooltip.formatter=function(params){
	    		 var find = params[0].name.replace(/\//g,"");
	    		 for(var i=0; i<path.length; i++){
	    			 if(path[i].indexOf(find) > -1){
	    				 return path[i]+"<br/>" + params[0].value + "%";
	    			 }
	    		 } 
	    	 } 
			 disk_axis_Chart = echarts.init(document.getElementById('disk_axis'));
			 disk_axis_Chart.setOption(disk_axis_option);
		// }
	 }
	 
	 window.CPUHistory = function()
	 {
		
		 
		 
		 var xdata = "<?php echo ($xdata); ?>" ? "<?php echo ($xdata); ?>" : "";
		 var ydata = "<?php echo ($ydata); ?>" ? "<?php echo ($ydata); ?>" : '';
		 var xdataArr = xdata.split(",");
		 var ydataArr = ydata.split(",");
		 var cpu_bar_option = bar_option;
		 cpu_bar_option.xAxis.data = xdataArr;
		 cpu_bar_option.series[0].data = ydataArr;
		 cpu_bar_option.title.text = "时间格式：分/秒";
		 cpu_bar_option.series[0].name = "CPU平均使用率";
		 var CPUHChart = echarts.init(document.getElementById('cpu_history_box'));
		 CPUHChart.setOption(cpu_bar_option);
		 
	 }
})

</script>