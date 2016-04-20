<?php
//Vendor('Hprose.SendMessage');
class IndexController extends CommonController {

    // 框架首页
	public function index() {
	    
	   /* 
	    *   Redis存储数据；
	    *  if(!$menuInfo = hashGet('ServiceLoginMenu',$jsid)){
	        $request = new CommunicationModel();
	        $getMenu = array('domain'=>'SERVICE_MANAGE');
	        $menuInfo = $request->curl_set_message(C('loginMenu'),$getMenu,true);
	        
	        hashSet('ServiceLoginMenu', array($jsid=>$menuInfo));
	    } */
	    
	    if(!$menus = $_SESSION['ServiceLoginMenu']){
	       $request = new CommunicationModel();
	       $getMenu = array('domain'=>C('LoginMark'));
	       $menuInfo = $request->do_service(C('loginMenu'),$getMenu);
	        
	       $res = strval($menuInfo);
	       
	       if(strlen($res) > 0){
	           $first = substr($res,strpos($res,"["));
	           $end = strrpos($first,"]");
	           $end ++;
	           $res_json = substr($first,0,$end);
	           $menus = json_decode($res_json,true);
	           $_SESSION['ServiceLoginMenu'] = $menus;
	           \Think\Log::write("\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\获取菜单解析后的结果是：".print_r($menus,true));
	       }else{
	           $this->error("菜单未能获取，请重新登录！");
	       }
	   }
	      // $request = new CommunicationModel();
	       //$getMenu = array('domain'=>C('LoginMark'));
	       //$menuInfo = $request->do_service(C('loginMenu'),$getMenu);
	        //$login_res = '[{"id":"2c948cfb51ebb03c0151ebb3ece6000a","name":"服务管制","url":null,"icon":"","children":[{"id":"2c948cfb51ebb03c0151ebb5bf60000f","name":"配置中心","url":null,"icon":"","children":[{"id":"2c948cfb51ebb03c0151ebb73feb0011","name":"配置","url":"Service/Configure","icon":"","children":[]},{"id":"2c948cfb51ebb03c0151ebb84a6c0013","name":"配置节点恢复","url":"Service/Retrive","icon":"","children":[]}]},{"id":"2c948cfb51ebb03c0151ebb8e4840014","name":"仓库中心","url":null,"icon":"","children":[{"id":"2c948cfb51ebb03c0151ebb9ea470016","name":"仓库中心","url":"Service/Repertory","icon":"","children":[]},{"id":"2c948cfb51ebb03c0151ebbaba760018","name":"批量处理","url":"Service/Batchprocess/index/from/2","icon":"","children":[]}]},{"id":"2c948cfb51ebb03c0151ebbb44c40019","name":"作业中心","url":null,"icon":"","children":[{"id":"2c948cfb51ebb03c0151ebbbfe1f001b","name":"作业调度","url":"Service/Scheduling","icon":"","children":[]}]},{"id":"2c948cfb51ebb03c0151ebbc7b5c001c","name":"转账通道","url":null,"icon":"","children":[{"id":"2c948cfb51ebb03c0151ebbd5347001e","name":"转账通道","url":"Service/Ukey","icon":"","children":[]}]}]},{"id":"2c948cfb51ebb03c0151ebb48c15000b","name":"监控管理","url":null,"icon":"","children":[{"id":"2c948cfb51ec5db00151ec65a5fc000a","name":"服务监控中心","url":null,"icon":"","children":[{"id":"2c948cfb51ec5db00151ec67723f000f","name":"服务监控","url":"Service/Sermonitor","icon":"","children":[]}]},{"id":"2c948cfb51ec5db00151ec65fbf8000b","name":"质量监控","url":null,"icon":"","children":[{"id":"2c948cfb51ec5db00151ec68273b0011","name":"渠道切换","url":"Admin/Channel","icon":"","children":[]}]},{"id":"2c948cfb51ec5db00151ec665e33000c","name":"第三方工具中心","url":null,"icon":"","children":[{"id":"2c948cfb51ec5db00151ec68aa560013","name":"下载管理","url":"Service/Download","icon":"","children":[]},{"id":"2c948cfb51ec5db00151ec8e100e0015","name":"Cacti连接","url":"http://10.128.133.212/cacti/","icon":"","children":[]},{"id":"2c948cfb51ec5db00151ec8e93310017","name":"Naigos连接","url":"http://10.128.133.213/nagios/","icon":"","children":[]}]},{"id":"2c948cfb51ec5db00151ec66a58f000d","name":"监控配置中心","url":null,"icon":"","children":[{"id":"2c948cfb51ec5db00151ec8f67fc0019","name":"运维成员管理","url":"Service/Operatmember","icon":"","children":[]},{"id":"2c948cfb51ec5db00151ec9042b1001b","name":"代理资源映射","url":"Service/Agentresource","icon":"","children":[]},{"id":"2c948cfb51ec5db00151ec90fa0d001d","name":"监控元素","url":"Service/Addmonelement","icon":"","children":[]},{"id":"2c948cfb51ec5db00151ec91f28e001f","name":"元素资源类型","url":"Service/Moniconfig","icon":"","children":[]},{"id":"2c948cfb51ec5db00151ec929fae0021","name":"历史查询","url":"Service/Historyquery","icon":"","children":[]},{"id":"2c948cfb51ec5db00151ec9344b30023","name":"实时监控","url":"Service/Realmonitor","icon":"","children":[]},{"id":"2c948cfb51ec5db00151ec93fc8c0025","name":"渠道","url":"Service/Channelswitch","icon":"","children":[]},{"id":"2c948cfb51ec5db00151ec94aa210027","name":"监控过滤","url":"Service/Monitorfilter","icon":"","children":[]},{"id":"2c948cfb51ec5db00151ec9640660029","name":"切换设置","url":"Admin/SysMonitor/showIp","icon":"","children":[]}]}]},{"id":"2c948cfb51ebb03c0151ebb4c96f000c","name":"主机管理","url":null,"icon":"","children":[{"id":"2c948cfb51ec5db00151ec975f99002b","name":"初始化机器","url":"Service/Deployment","icon":"","children":[]},{"id":"2c948cfb51ec5db00151ec97e9dd002d","name":"密码管理","url":"Service/passmanage","icon":"","children":[]}]},{"id":"2c948cfb51ebb03c0151ebb502c8000d","name":"资产管理","url":null,"icon":"","children":[{"id":"2c948cfb51ec5db00151ec985607002e","name":"资源中心","url":null,"icon":"","children":[{"id":"2c948cfb51ec5db00151ec993e620031","name":"机房管理","url":"Service/Areamanage","icon":"","children":[]},{"id":"2c948cfb51ec5db00151ec99d3710033","name":"机柜管理","url":"Service/Cabinet","icon":"","children":[]},{"id":"2c948cfb51ec5db00151ec9a6dfb0035","name":"机器类型/型号管理","url":"Service/Mechinetype","icon":"","children":[]},{"id":"2c948cfb51ec5db00151ec9b06fe0037","name":"操作系统","url":"Service/Operatesystem","icon":"","children":[]},{"id":"2c948cfb51ec5db00151ec9b7d650039","name":"服务器管理","url":"Service/Servermanage","icon":"","children":[]}]},{"id":"2c948cfb51ec5db00151ec989f66002f","name":"非计算资源中心","url":null,"icon":"","children":[{"id":"2c948cfb51ec5db00151ec9c2a49003b","name":"资产","url":"Service/DeviceInfo","icon":"","children":[]}]}]},{"id":"2c948cfb51ebb03c0151ebb549e1000e","name":"服务治理","url":null,"icon":"","children":[{"id":"2c948cfb51ec5db00151ec9ccdd8003d","name":"设置T1T2系统","url":"Admin/SetSystem","icon":"","children":[]},{"id":"2c948cfb51ec5db00151ec9da7f5003f","name":"服务治理","url":"http://172.17.4.203:8080/containerui/index.do","icon":"","children":[]},{"id":"2c948cfb51ec5db00151ec9e37b10041","name":"流水质量监控","url":"Admin/SysMonitor","icon":"","children":[]},{"id":"2c948cfb51ec5db00151ec9ea69e0043","name":"Ice权重","url":"Admin/IceWeight","icon":"","children":[]},{"id":"2c948cfb51ec5db00151ec9f41b20045","name":"权重服务","url":"Admin/WeightService","icon":"","children":[]}]}]';
	       
	       /* if(strlen($login_res) > 0){
	           $menus = json_decode($login_res,true);
	           $_SESSION['ServiceLoginMenu'] = $menus;
	           \Think\Log::write("\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\获取菜单解析后的结果是：".print_r($menus,true));
	       }else{
	           $this->error("菜单未能获取，请重新登录！");
	       } */
	   
	    
	    $this->assign ( 'menu', $menus);
	    $this->assign ( 'enviroment', C('CONST_ENVIRONMENT') );
	     C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
	     C ( 'SHOW_PAGE_TRACE', false );
	     $this->display ();
	}

}