<?php
/**
 * 服务管制-仓库中心
 * @author zengguangqiu
 *
 */
class RepertoryController extends CommonController {
	//var $navTab = 'D60602';
	var $navTab = '2c948cfb51ebb03c0151ebb9ea470016';
	var $deploymentFlagArr = array('1'=>'未发布','2'=>'已发布');
	var $servicetype = array('1'=>'C服务','2'=>'Web服务','3'=>'Java服务');
	var $toolstype = array('1'=>'工具','2'=>'非工具');
	var $is_covered = array('1'=>'是','2'=>'否');
	var $showColums = array('servicename'=>'服务名','serviceversion'=>'版本','servicetype'=>'类型','is_tool'=>'工具与否','servicefunction'=>'功能描述','svnpath'=>'svn路径','javamain'=>'main入口', 'deploymentFlag'=>'发布状态','importtime'=>'导入时间','buildtime'=>'构建时间','md5'=>'MD5');
	
// 框架首页
	public function index() {
			
		$Repertory = new RepertoryModel($_POST,$_GET);
		if($_POST['desployenvp'] == 5)
		{
			$_POST['data']['deploymentFlag'] = '1';
			$_POST['deploymentFlag'] = '1';
			$_POST['data']['desployenv'] = '';
			$_POST['desployenv'] = '';
		}else
		{
			$_POST['data']['deploymentFlag'] = '';
			$_POST['data']['desployenv'] = $_POST['desployenvp'];
			$_POST['deploymentFlag'] = '';
			$_POST['desployenv'] = $_POST['desployenvp'];
		}
		$defaultTree = $Repertory->defaultTree($_POST,$_GET);
		
		//组装数据
		$tmp_result['defaultTree']	= '{"name":"服务","open":true';
		
		if(is_array($defaultTree) && count($defaultTree))
		{
			$tmp_result['defaultTree']	.=',"children": [';
			for($i=0;$i<sizeof($defaultTree);$i++){
					
				$tmp_result['defaultTree']
					.= '{"id":"'
					. $defaultTree[$i]["id"]
					. '","name":"'
					. $defaultTree[$i]["productname"]
					. '","url":"/index.php/Service/Repertory/list_c?id='. $defaultTree[$i]["id"]. '&deploymentFlag='. $_POST['deploymentFlag']. '&desployenv='
. $_POST['desployenv']. '","target":"ajax","open":true,"children":[';
				
				if($defaultTree[$i]['child']){
					for($j=0;$j<sizeof($defaultTree[$i]['child']);$j++ ){
							
						$tmp_result['defaultTree']
							.= '{"id":"'
							. $defaultTree[$i]['child'][$j]['serviceid']
							. '","name":"'
							. $defaultTree[$i]['child'][$j]['servicename']
							. '","url":"/index.php/Service/Repertory/list_a?id='
							. $defaultTree[$i]['child'][$j]['serviceid']. '&deploymentFlag='. $_POST['deploymentFlag']. '&desployenv='. $_POST['desployenv']
							. '","path":"'
							. $defaultTree[$i]['child'][$j]['desploypath']							
							. '","defaultcfgid":"'
							. $defaultTree[$i]['child'][$j]['defaultcfgid']
							. '","defaultcfg":"'
							. $defaultTree[$i]['child'][$j]['defaultcfg']																	
							. '","target":"ajax","open":true,"ss_type":"'
							. $defaultTree[$i]['child'][$j]['ss_type']
							. '","children":[';
							
						if($defaultTree[$i]['child'][$j]['datelist']){
							for($k=0;$k<sizeof($defaultTree[$i]['child'][$j]['datelist']);$k++ ){
								$tmp_result['defaultTree']
									.= '{"id":"'
									. $defaultTree[$i]['child'][$j]['serviceid']
									. '","name":"'
									. $defaultTree[$i]['child'][$j]['datelist'][$k]
									. '","url":"/index.php/Service/Repertory/list_b?id='
									. $defaultTree[$i]['child'][$j]['serviceid']. '&deploymentFlag='. $_POST['deploymentFlag']. '&desployenv='
. $_POST['desployenv']
									. '&time='
									. $defaultTree[$i]['child'][$j]['datelist'][$k]
									. '","target":"ajax","ss_type":'
									. $defaultTree[$i]['child'][$j]['ss_type'].'},';
							}
						}
		
						$tmp_result['defaultTree']	.= ']},';
					}
				}
				$tmp_result['defaultTree']	.= ']},';
			}
			$tmp_result['defaultTree']	.= ']';
		}
		$tmp_result['defaultTree'] .='}';

		$this->assign ( 'servicetype', $this->servicetype);
		$this->assign ( 'defaultTree', $tmp_result['defaultTree'] );
		$this->assign('deploymentFlagArr',$this->deploymentFlagArr);
		
		$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
		$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		
		$Repertory = new RepertoryModel($_POST,$_GET);
		$result = $Repertory->findByReqs($_POST,$_GET);
		$count = $Repertory->countByReqs($_POST,$_GET);
		//dump($result);
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result );
		//去数据库中去出对应的登录的用户已经设置的字段的记录
		$resultcols=$Repertory->getShowColums($_POST);
		$columsArr = array();
		if(!empty($resultcols))
		{
			$tempcolumsArr = explode(",", $resultcols);
			foreach ($tempcolumsArr as $key=>$val)
			{
				$columsArr[$val] =  $this->showColums[$val];
			}
		}else
		{
			$columsArr = $this->showColums;
		}
		$this->assign("showClums", $columsArr);
		$this->assign ( 'map', array('service'=>'','level'=>'','startTime'=>'','endTime'=>'','desployenvp'=>'') );
		cookie('_currentUrl_', __SELF__);
		$metaIDArr =explode(',',cookie('metaid_datas'));
		$this->assign('metaIDArr',$metaIDArr);
		
		//根据环境设置对应显示的树形类型的字段
		if($_SESSION['WEB_ENVIRONMENT'] == 3 || $_SESSION['WEB_ENVIRONMENT'] == 4)
		{
			$treeType = 1;
		}elseif($_SESSION['WEB_ENVIRONMENT'] == 1 || $_SESSION['WEB_ENVIRONMENT'] == 2)
		{
			$treeType = 2;
		}
		$this->assign("enviroments",$_SESSION['WEB_ENVIRONMENT']);
		$this->assign ( 'treeType', $treeType );
		$this->assign ( 'toolstype', $this->toolstype );
		
		$this->display();
	}
	
	public function add() {
		$this->display();
	}
	
	public function edit() {
		if($_POST){
			if(empty($_POST['editmrconfig_name']))
			{
				$_POST['cfgid'] = '';
			}else
			{
				$_POST['cfgid'] = $_POST['editmrconfig_id'];
			}
			$Repertory = new RepertoryModel($_POST,$_GET);
			$result=$Repertory->update($_POST,$_GET);
	
			if($result['errorCode'] == "0"){
				$ret = array("statusCode"=>"200","message"=>'操作成功。',//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				echo json_encode($ret);	return;
			}else{
				$msg = $result['errorMessage'];
				$ret = array("statusCode"=>"0","message"=>$msg);
				echo json_encode($ret);	return;
			}
		}
		//根据mwId获取对应的对应的默认路径和配置文件
		if($_GET['mwId']-0 > 0)
		{
			$Repertory = new RepertoryModel($_POST,$_GET);
			$defaultInfo = $Repertory->getdefaultdesploy($_GET['mwId'],'ssid');
		}
		
		$this->assign ( 'mwId', $_GET['mwId'] );
		$this->assign ( 'path', $defaultInfo['path'] );
		$this->assign ( 'defaultcfgid', $defaultInfo['defaultcfgid']!="undefined"?$defaultInfo['defaultcfgid']:'' );
		$this->assign ( 'defaultcfg', $defaultInfo['defaultcfg']!="undefined"?$defaultInfo['defaultcfg']:'' );
		$this->display();
	}
	
	public function list_a() {
			$request = array();
			foreach($_POST as $k =>$v){
				$request[$k] = $v;
			}
				
			C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
			C ( 'SHOW_PAGE_TRACE', false );
			
			$_POST['data']['deploymentFlag'] = $_GET['deploymentFlag'];
			$_POST['data']['desployenv'] = $_GET['desployenv'];
			$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
			$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
			$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
				
			$Repertory = new RepertoryModel($_POST,$_GET);
			$result = $Repertory->findById($_POST,$_GET);
			$count = $Repertory->countById($_POST,$_GET);
				
			$this->assign ( 'totalCount', $count );
			$this->assign ( 'list', $result );
			$this->assign ( 'map', array('service'=>'','level'=>'','startTime'=>'','endTime'=>'') );
			//去数据库中去出对应的登录的用户已经设置的字段的记录
			$resultcols=$Repertory->getShowColums($_POST);
			$columsArr = array();
			if(!empty($resultcols))
			{
				$tempcolumsArr = explode(",", $resultcols);
				foreach ($tempcolumsArr as $key=>$val)
				{
					$columsArr[$val] =  $this->showColums[$val];
				}
			}else
			{
				$columsArr = $this->showColums;
			}
			$this->assign("showClums",$columsArr);
			cookie('_currentUrl_', __SELF__);
			$metaIDArr =explode(',',cookie('metaid_datas'));
			$this->assign('metaIDArr',$metaIDArr);
			$this->assign('deploymentFlagArr',$this->deploymentFlagArr);
			$this->assign ( 'servicetype', $this->servicetype);
			$this->assign ( 'toolstype', $this->toolstype );
			$this->assign("enviroments",$_SESSION['WEB_ENVIRONMENT']);
			$this->display('list');
	}
	
	public function list_b() {
			$request = array();
			foreach($_POST as $k =>$v){
				$request[$k] = $v;
			}
				
			C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
			C ( 'SHOW_PAGE_TRACE', false );
			
			$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
			$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
			$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
				
			$Repertory = new RepertoryModel($_POST,$_GET);
			$result = $Repertory->findByTime($_POST,$_GET);
			$count = $Repertory->countByTime($_POST,$_GET);
				
			$this->assign ( 'totalCount', $count );
			$this->assign ( 'list', $result );
			$this->assign ( 'map', array('service'=>'','level'=>'','startTime'=>'','endTime'=>'') );
			//去数据库中去出对应的登录的用户已经设置的字段的记录
			$resultcols=$Repertory->getShowColums($_POST);
			$columsArr = array();
			if(!empty($resultcols))
			{
				$tempcolumsArr = explode(",", $resultcols);
				foreach ($tempcolumsArr as $key=>$val)
				{
					$columsArr[$val] =  $this->showColums[$val];
				}
			}else
			{
				$columsArr = $this->showColums;
			}
			$this->assign("showClums",$columsArr);
			cookie('_currentUrl_', __SELF__);
			$metaIDArr =explode(',',cookie('metaid_datas'));
			$this->assign('metaIDArr',$metaIDArr);
			$this->assign('deploymentFlagArr',$this->deploymentFlagArr);
			$this->assign ( 'servicetype', $this->servicetype);
			$this->assign ( 'toolstype', $this->toolstype );
			$this->assign("enviroments",$_SESSION['WEB_ENVIRONMENT']);
			$this->display('list');
	}
	
	public function list_c() {
		$request = array();
		foreach($_POST as $k =>$v){
			$request[$k] = $v;
		}
	
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		
		$_POST['data']['deploymentFlag'] = $_GET['deploymentFlag'];
		$_POST['data']['desployenv'] = $_GET['desployenv'];
		$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
		$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
	
		$Repertory = new RepertoryModel($_POST,$_GET);
		$result = $Repertory->findByProduct($_POST,$_GET);
		$count = $Repertory->countByProduct($_POST,$_GET);
	
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result );
		$this->assign ( 'map', array('service'=>'','level'=>'','startTime'=>'','endTime'=>'') );
		//去数据库中去出对应的登录的用户已经设置的字段的记录
		$resultcols=$Repertory->getShowColums($_POST);
		$columsArr = array();
		if(!empty($resultcols))
		{
			$tempcolumsArr = explode(",", $resultcols);
			foreach ($tempcolumsArr as $key=>$val)
			{
				$columsArr[$val] =  $this->showColums[$val];
			}
		}else
		{
			$columsArr = $this->showColums;
		}
		$this->assign("showClums",$columsArr);
		cookie('_currentUrl_', __SELF__);
		$metaIDArr =explode(',',cookie('metaid_datas'));
		$this->assign('metaIDArr',$metaIDArr);
		$this->assign('deploymentFlagArr',$this->deploymentFlagArr);
		$this->assign ( 'servicetype', $this->servicetype);
		$this->assign ( 'toolstype', $this->toolstype );
		$this->assign("enviroments",$_SESSION['WEB_ENVIRONMENT']);
		$this->display('list');
	}
	
	public function select_info() {
		$Repertory = new RepertoryModel($_POST,$_GET);
		$tmp_result = $Repertory->repConfigTree($_POST,$_GET);
				
		$this->assign ( 'repertory_config_tree', $tmp_result );
		$this->display();
	}

	public function config_detail() {
		$_POST['id'] = intval($_GET['id']);
		$Repertory = new RepertoryModel($_POST,$_GET);
		$tmp_result = $Repertory->getInstanceDetail($_POST,$_GET);
	
		$this->assign ( 'data', $tmp_result );
		$this->display();
	}
		
	public function del(){
		
		$Repertory = new RepertoryModel($_POST,$_GET);
		$id=$_GET['id'];
		if($id){
			$result=$Repertory->deleteById($id);
		}else{
			$ret = array("statusCode"=>"0","message"=>"选择不能为空!");
			echo json_encode($ret);	return;			
		}

		if($result['errorCode'] == "0"){
			$ret = array("statusCode"=>"1","message"=>'操作成功。',"navTabId"=>$this->navTab);
			echo json_encode($ret);	return;
		}else{
			$msg = $result['errorMessage'];
			$ret = array("statusCode"=>"0","message"=>$msg);
			echo json_encode($ret);	return;
		}
	}
	
	public function showiinproduct(){
	
		$Repertory = new RepertoryModel($_POST,$_GET);
		$id=$_GET['id'];
		if($id){
			$result=$Repertory->showiinproduct($id);
		}else{
			$ret = array("statusCode"=>"0","message"=>"选择不能为空!");
			echo json_encode($ret);	return;
		}
	
		if($result['errorCode'] == "0"){
			$ret = array("statusCode"=>"1","message"=>'操作成功。',"navTabId"=>$this->navTab);
			echo json_encode($ret);	return;
		}else{
			$msg = $result['errorMessage'];
			$ret = array("statusCode"=>"0","message"=>$msg);
			echo json_encode($ret);	return;
		}
	}
	
	public function search(){

		if($_POST){
			$request = array();
			foreach($_POST as $k =>$v){
				$request[$k] = $v;
			}
				
			C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
			C ( 'SHOW_PAGE_TRACE', false );
				
			$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
			$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
			$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
				
			$Repertory = new RepertoryModel($_POST,$_GET);
			$result = $Repertory->findByReqs($_POST,$_GET);
			$count = $Repertory->countByReqs($_POST,$_GET);
				
			$this->assign ( 'totalCount', $count );
			$this->assign ( 'list', $result );
			$this->assign ( 'map', array('service'=>'','level'=>'','startTime'=>'','endTime'=>'','desployenv'=>'') );
			//去数据库中去出对应的登录的用户已经设置的字段的记录
			$result=$Repertory->getShowColums($_POST);
			$columsArr = array();
			if(!empty($result))
			{
				$tempcolumsArr = explode(",", $result);
				foreach ($tempcolumsArr as $key=>$val)
				{
					$columsArr[$val] =  $this->showColums[$val];
				}
			}else
			{
				$columsArr = $this->showColums;
			}
			$this->assign("showClums",$columsArr);
			cookie('_currentUrl_', __SELF__);
			$metaIDArr =explode(',',cookie('metaid_datas'));
			$this->assign('metaIDArr',$metaIDArr);
			$this->assign('deploymentFlagArr',$this->deploymentFlagArr);
			$this->assign ( 'servicetype', $this->servicetype);
			$this->assign ( 'toolstype', $this->toolstype);
			$this->assign("enviroments",$_SESSION['WEB_ENVIRONMENT']);
			$this->display('list');
		}
	}

	public function importsvn(){
		set_time_limit(0);
		$Repertory = new RepertoryModel($_POST,$_GET);
		$svnurl=$_POST['svnurl'];
		if($svnurl){
			$tempurl = explode("\n", $svnurl);
			$svnurl = implode('##', $tempurl);
			$result=$Repertory->importByLink($svnurl);
		}else{
			$ret = array("statusCode"=>"0","message"=>"svn链接不能为空!");
			echo json_encode($ret);	return;
		}
	
		if($result['errorCode'] == "0"){
			$ret = array("statusCode"=>"1","message"=>'操作成功。',"navTabId"=>$this->navTab);
			echo json_encode($ret);	return;
		}else{
			$msg = $result['errorMessage'];
			$ret = array("statusCode"=>"0","message"=>$msg);
			echo json_encode($ret);	return;
		}
	}
	public function call(){
		
		$Repertory = new RepertoryModel($_POST,$_GET);
		$_POST["data"]=array(
				"ipv"=>"",
				"mwid"=>$_GET['mwId'],
				"hostname"=>"",
				"environment"=>$_SESSION['WEB_ENVIRONMENT']
		);
		$ipProductTreetemp = $Repertory->ipProductTree($_POST,$_GET);
		$ipProductTree = $ipProductTreetemp['lastret'];
		
		//组装数据
		
		$hiddenvalArr = array();
		if(is_array($ipProductTree) && count($ipProductTree))
		{
			$tmp_result['ipProductTree']	= '<ul  class="tree treeCheck expand" layouth="115" oncheck="kkk">';
			for($i=0;$i<sizeof($ipProductTree);$i++){
				$tmp_result['ipProductTree']	.='<li>';
				$tmp_result['ipProductTree']
					.= '<a href="javascript:;"  tname="ipv">'
					. $ipProductTree[$i]["productname"]
					. '</a>'
					. '<ul>';
			
				if($ipProductTree[$i]['child']){
				    
				    //排序，isselected==yes拍在前面；2015-10-23;
				    //*************************************
				    $isselected = array();
				    $unselected = array();
				    
				    for($p=0;$p<sizeof($ipProductTree[$i]['child']);$p++ ){
				        if( $ipProductTree[$i]['child'][$p]['isselected'] == 'yes')
				        {
				            $isselected[] = $ipProductTree[$i]['child'][$p];
				        }else{
				            $unselected[] = $ipProductTree[$i]['child'][$p];
				        }
				    }
				    $ipProductTree[$i]['child'] = array_merge($isselected,$unselected);
				    //*************************************
					//dump($ipProductTree);
					for($j=0;$j<sizeof($ipProductTree[$i]['child']);$j++ ){
						if( $ipProductTree[$i]['child'][$j]['isselected'] == 'yes')
						{
							$checked = 'checked="true"';
							$hiddenvalArr[] = $ipProductTree[$i]['child'][$j]['ipaddress'];
						}
						//echo $checked;
						$tmp_result['ipProductTree']
							.= '<li><a '.$checked.' title="'
							. $ipProductTree[$i]['child'][$j]['serverdemo']
							. '" href="javascript:;" tname="ipv" tvalue="'
							. $ipProductTree[$i]['child'][$j]['ipaddress']
							. '" class="level2">'
							. $ipProductTree[$i]['child'][$j]['ipname']
							. '</a></li>';
						$checked = '';
					}
				}
				$tmp_result['ipProductTree']	.= '</ul>';
				$tmp_result['ipProductTree']	.= '</li>';
			}
			$tmp_result['ipProductTree'] .='</ul>';
		}
		
		$ips = implode(',', $hiddenvalArr);
		//dump($ipProductTreetemp);
		//获取对应的默认路径和默认配置信息
		$defaultInfo = $Repertory->getdefaultdesploy($_GET['ssid']);
		$this->assign('serName',$_GET['sername']);
		$this->assign('version',$_GET['version']);
		$this->assign('mwId',$_GET['mwId']);
		$this->assign('ips',$ips);
		$this->assign('serUser',$ipProductTreetemp['dis_owner']);
		$this->assign('serGroup',$ipProductTreetemp['dis_group']);
		$this->assign('processNum',$ipProductTreetemp['dis_times']);
		$this->assign('desploypath',empty($ipProductTreetemp['dis_path'])?$defaultInfo['path']:$ipProductTreetemp['dis_path']);
		$this->assign ( 'ipProductTree', $tmp_result['ipProductTree'] );
		$this->assign('defaultInfo',$defaultInfo);
		$this->display();	
	}

	public function callByReqs(){
	
		$Repertory = new RepertoryModel($_POST,$_GET);
		$_POST["data"]=array(
				"ipv"=>$_POST['ip'],
				"mwid"=>$_POST['mwId'],
				"hostname"=>$_POST['hostname'],
				"ptaskid"=>$_POST['ptaskid'],
				"environment"=>$_SESSION['WEB_ENVIRONMENT']
		);
		$ipProductTreetemp = $Repertory->ipProductTree($_POST,$_GET);
		$ipProductTree =$ipProductTreetemp['lastret'];
		//组装数据
		//dump($ipProductTree);
	
		if(is_array($ipProductTree) && count($ipProductTree))
		{
			$tmp_result['ipProductTree']	= '<ul  class="tree treeCheck expand" layouth="115" oncheck="kkk">';
			for($i=0;$i<sizeof($ipProductTree);$i++){
				$tmp_result['ipProductTree']	.='<li>';
				$tmp_result['ipProductTree']
					.= '<a href="javascript:;"  tname="ipv">'
					. $ipProductTree[$i]["productname"]
					. '</a>'
					. '<ul>';
			
				if($ipProductTree[$i]['child']){
					//dump($ipProductTree);
					for($j=0;$j<sizeof($ipProductTree[$i]['child']);$j++ ){
						if( $ipProductTree[$i]['child'][$j]['isselected'] == 'yes')
						{
							$checked = 'checked="true"';
							$hiddenvalArr[] = $ipProductTree[$i]['child'][$j]['ipaddress'];
						}
						//echo $checked;
						$tmp_result['ipProductTree']
							.= '<li><a '.$checked.' title="'
							. $ipProductTree[$i]['child'][$j]['serverdemo']
							. '" href="javascript:;" tname="ipv" tvalue="'
							. $ipProductTree[$i]['child'][$j]['ipaddress']
							. '" class="level2">'
							. $ipProductTree[$i]['child'][$j]['ipname']
							. '</a></li>';
						$checked = '';
					}
				}
				$tmp_result['ipProductTree']	.= '</ul>';
				$tmp_result['ipProductTree']	.= '</li>';
			}
			$tmp_result['ipProductTree'] .='</ul>';
			$msg = $tmp_result['ipProductTree'];
		}else{
			$msg='找不到';
		}
		
		$ret = array("message"=>$msg);
		echo json_encode($ret);	return;
	}	
	
	public function instance_detail(){
		$Repertory = new RepertoryModel($_POST,$_GET);
		$result=$Repertory->getInstanceDetail($_POST,$_GET);
		$this->display();
		
	}
	
	public function create_plan(){
		
		if(empty($_POST['ips']))
		{
			$msg = '机器未选择';
			$ret = array("statusCode"=>"0","message"=>$msg,"navTabId"=>'',//$this->navTab
					"rel"=>"call_win","forwardUrl"=>"","callbackType"=>"");
			exit(json_encode($ret));
		}
		$Repertory = new RepertoryModel($_POST,$_GET);
		/* if($_POST['disType'] == '4')
		{
			$ipsArr = explode(",", $_POST['ips']);
			if(is_array($ipsArr) && count($ipsArr))
			{
				foreach ($ipsArr as $ipkey=>$ipval)
				{
					//websocket通知C++服务
					$ip = $ipval;
					$service_name = trim($_POST['serName']);
					$version = trim($_POST['version']);
					$newIp= sprintf('%-15s', $ip);
					$time = date("YmdHis");
					$str = '01'.$newIp.$this->rep_str($service_name, '0', 2).$service_name.$this->rep_str($version, '0', 2).$version.$time;
					$post_str = array('pBuffer'=>$str,'iLen'=>strlen($str));
					$ret = $Repertory->requestBySoap('DealNotice',$post_str);
				}
			}
				
		} */
		$_POST['form_act']='createPlans';
		$_POST['data']=array(
			//'ipv'=>explode(',',$_POST['ips']),
			'ipv'=>$_POST['ips'],
			'path'=>$_POST['serPath'],
			'group'=>$_POST['serGroup'],
			'owner'=>$_POST['serUser'],
			'opmtype'=>$_POST['opmType'],
			'distype'=>$_POST['disType'],
			'cron'=>$_POST['cron'],
			'processnum'=>$_POST['processNum'],
			'conf'=>$_POST['config_id'],
			'demo'=>$_POST['demo'],
			'person'=>$_SESSION['cUserNo'],
			'groupid'=>'111',
			'mwid'=>$_POST['mwId'],
			'environment'=>trim($_SESSION['WEB_ENVIRONMENT'])
		);
					
		$result=$Repertory->postSave($_POST,$_GET);
		
		if($result['errorCode'] == "0"){
			$ret = array("statusCode"=>"1","message"=>'操作成功。',"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
			echo json_encode($ret);	return;
		}else{
			$msg = $result['errorMessage'];
			$ret = array("statusCode"=>"0","message"=>$msg,"navTabId"=>'',//$this->navTab
						"rel"=>"call_win","forwardUrl"=>"","callbackType"=>"");
			echo json_encode($ret);	return;
		}
	}
	
	public function getSearchInfo()
	{
		$type = intval($_POST['type']);
		$text = trim($_POST['key']);
		$post['data'] = array('type'=>$type,'text'=>$text);
		$Configure = new ConfigureModel($_POST,$_GET);
		$result = $Configure->getSearchInfo($post);
		if($type == 1)
		{
			//显示配置项
			$tmp_result['result']['config_nodes']	= '[{"name":"配置项","open":true,"children": [';
				
			foreach($result as $k1 => $v1 ){
				$tmp_result['result']['config_nodes']	.=
				'{"id":"' . $result[$k1]["id"] . '","name":"' . $result[$k1]["configItemKindName"] . '","open":true,"children":[';
				if($result[$k1]['child']){
					foreach($result[$k1]['child'] as $k2 => $v2 ){
						$tmp_result['result']['config_nodes']	.= '{"id":"' . $result[$k1]['child'][$k2]['id'] . '","name":"' . $result[$k1]['child'][$k2]['configItemName'] . '","url":"/index.php/Service/Repertory/detail?type=a&id=' . $result[$k1]['child'][$k2]['id'] . '","target":"ajax"},';
					}
				}
				$tmp_result['result']['config_nodes']	.= ']},';
			}
				
			$tmp_result['result']['config_nodes']	.= ']}]';
			echo  $tmp_result['result']['config_nodes'];
		}else
		{
			$tmp_result['result']['examples_nodes']	= '[{"name":"配置实例","open":true';
			if(is_array($result) && count($result))
			{
				$tmp_result['result']['examples_nodes']	.=',"children": [';
				foreach($result as $k1 => $v1 ){
					$tmp_result['result']['examples_nodes']	.=
					'{"id":"' . $result[$k1]["id"] . '","name":"' . $result[$k1]["kindName"] . '","open":true,"children":[';
					if($result[$k1]['child']){
						foreach($result[$k1]['child'] as $k2 => $v2 ){
							$tmp_result['result']['examples_nodes']	.= '{"id":"' . $result[$k1]['child'][$k2]['id'] . '","name":"' . $result[$k1]['child'][$k2]['configInstanceName'] . '","url":"/index.php/Service/Repertory/config_detail?id=' . $result[$k1]['child'][$k2]['id'] . '","target":"ajax"},';
						}
					}
					$tmp_result['result']['examples_nodes']	.= ']},';
				}
				$tmp_result['result']['examples_nodes']	.= ']';
			}
			$tmp_result['result']['examples_nodes'].='}]';
	
			echo  $tmp_result['result']['examples_nodes'];
				
		}
	}
	/**
	 * 批量部署加入要部署的服务
	 */
	public function bathprocess()
	{
		$type = intval($_POST['type']);
		$metaID = intval($_POST['bathval']);
		$metaIDStr = $_POST['bathvalStr'];
		if(cookie('metaid_datas') === null)
		{
			$metaIDArr = array();
		}else
		{
			$metaIDArr =explode(',',cookie('metaid_datas'));
		}
		$temDataArr = array();
		$metaIDStrArr = explode(',', $metaIDStr);
		if(is_array($metaIDArr) && count($metaIDArr))
		{
			if($type == 1)
			{
				if(in_array($metaID, $metaIDArr))
				{
					$temDataArr = array_flip($metaIDArr);
					unset($temDataArr[$metaID]);
				}
			}elseif($type == 2){
				if(!in_array($metaID, $metaIDArr))
				{
					$temDataArr = $metaIDArr;
					$temDataArr[] = $metaID;
					$temDataArr = array_flip($temDataArr);
				}
			}elseif($type == 3)
			{
				if(is_array($metaIDStrArr) && count($metaIDStrArr))
				{
					foreach ($metaIDStrArr as $temval)
					{
						if(!in_array($temval, $metaIDArr))
						{
							$temDataArr1 = $metaIDArr;
							$temDataArr1[] = $temval;
						}
					}
					$temDataArr = array_flip($temDataArr1);
				}
				
			}elseif($type == 4)
			{
				if(is_array($metaIDStrArr) && count($metaIDStrArr))
				{
					$temDataArr = array_flip($metaIDArr);
					foreach ($metaIDStrArr as $temval)
					{
						if(in_array($temval, $metaIDArr))
						{
							unset($temDataArr[$temval]);
						}
					}
				}
			}
			$data =implode(",", array_flip($temDataArr));
			if($data)
			{
				cookie('datas',$data,array('expire'=>360000,'prefix'=>'metaid_'));
			}else
			{
				cookie('datas',null,array('expire'=>360000,'prefix'=>'metaid_'));
			}
			
		}else
		{
			if($type == 2)
			{
				$temDataArr[] = $metaID;
				$data =implode(",", $temDataArr);
				cookie('datas',$data,array('expire'=>360000,'prefix'=>'metaid_'));
			}elseif($type == 3)
			{

				$temDataArr = $metaIDStrArr;
				$data =implode(",", $temDataArr);
				cookie('datas',$data,array('expire'=>360000,'prefix'=>'metaid_'));
			}
		}
		
		$ret = array("status"=>"1","message"=>'操作成功。');
		echo json_encode($ret);	return;
	}
	
	/**
	 * 查看批量任务中的服务
	 */
	function looktask()
	{
		$this->display();
	}
	function checkfileFilter(){
		$Repertory = new RepertoryModel();
		$result=$Repertory->getFilterPlugeData($_GET);
		if($result['errorCode'] == 0){
			echo 0;//有数据需要显示
		}else{
			echo $result['errorMessage'];
		}
	}
	function getfileFilter(){
		$Repertory = new RepertoryModel();
		$result=$Repertory->getFilterPlugeData($_GET);
		if($result['errorCode'] == 0){
			$replacelist = $result['data']['replace'];
			$plugelist = $result['data']['pluge'];
			
			//模板赋值显示
			$this->assign('replacelist', $replacelist);
			$this->assign('plugelist', $plugelist);
			$this->display();
		}else{
			$this->error($result['errorMessage']);return;
		}
	}
	
	function updateFilterPluge(){
		$Repertory = new RepertoryModel();
		$result=$Repertory->updateFilterPluge($_POST);

		if($result['errorCode'] == "0"){
			$ret = array("statusCode"=>"1","message"=>'操作成功',"navTabId"=>$this->navTab);
			echo json_encode($ret);	return;
		}else{
			$msg = $result['errorMessage'];
			$ret = array("statusCode"=>"0","message"=>$msg);
			echo json_encode($ret);	return;
		}
	}
	
	function getcoverResource1(){
		$Repertory = new RepertoryModel();
		$result=$Repertory->getCoverReaourceData($_GET);
		if($result['errorCode'] == 0){
			$msg = $result['errorMessage'];
			$ret = array("statusCode"=>"2","message"=>$msg);
			echo json_encode($ret);	return;
		}else{
			$msg = $result['errorMessage'];
			$ret = array("statusCode"=>"30","message"=>$msg);
			echo json_encode($ret);	return;
		}
	}
	/**
	 * 获取是否覆盖resource目录的信息
	 */
	function getcoverResource(){
		$Repertory = new RepertoryModel();
		$result=$Repertory->getCoverReaourceData($_GET);
		if($result['errorCode'] == 0){
			$replace = $result['data']['replace'];
				
			//模板赋值显示
			$this->assign('replace', $replace);
			$this->assign('hidedata', $_GET);
			$this->display();
		}else{
			$msg = $result['errorMessage'];
			$ret = array("statusCode"=>"30","message"=>$msg);
			echo json_encode($ret);	return;
		}
	}
	
	function updatecoverResource(){
		$Repertory = new RepertoryModel();
		$result=$Repertory->updateCoverReaource($_POST);
	
		if($result['errorCode'] == "0"){
			$ret = array("statusCode"=>"200","message"=>'操作成功',"callbackType"=>"closeCurrent");
			echo json_encode($ret);	return;
		}else{
			$msg = $result['errorMessage'];
			$ret = array("statusCode"=>"0","message"=>$msg);
			echo json_encode($ret);	return;
		}
	}
	
	function getcoverInit1(){
		$Repertory = new RepertoryModel();
		$result=$Repertory->getCoverInitData($_GET);
		if($result['errorCode'] == 0){
			$msg = $result['errorMessage'];
			$ret = array("statusCode"=>"2","message"=>$msg);
			echo json_encode($ret);	return;
		}else{
			$msg = $result['errorMessage'];
			$ret = array("statusCode"=>"30","message"=>$msg);
			echo json_encode($ret);	return;
		}
	}
	/**
	 * 获取是否过滤init.sh下发
	 */
	function getcoverInit(){
		$Repertory = new RepertoryModel();
		$result=$Repertory->getCoverInitData($_GET);
		if($result['errorCode'] == 0){
			$replace = $result['data']['replace'];
	
			//模板赋值显示
			$this->assign('replace', $replace);
			$this->assign('hidedata', $_GET);
			$this->display();
		}else{
			$msg = $result['errorMessage'];
			$ret = array("statusCode"=>"30","message"=>$msg);
			echo json_encode($ret);	return;
		}
	}
	
	function updatecoverInit(){
		$Repertory = new RepertoryModel();
		$result=$Repertory->updateCoverReaource($_POST);
	
		if($result['errorCode'] == "0"){
			$ret = array("statusCode"=>"200","message"=>'操作成功',"callbackType"=>"closeCurrent");
			echo json_encode($ret);	return;
		}else{
			$msg = $result['errorMessage'];
			$ret = array("statusCode"=>"0","message"=>$msg);
			echo json_encode($ret);	return;
		}
	}
	
	function setshowcolum()
	{
		if(!empty($_POST))
		{
			
			if(is_array($_POST['showColum']) && count($_POST['showColum']))
			{
				$showColumStr = implode(",", $_POST['showColum']);
			}else
			{
				$ret = array("statusCode"=>"0","message"=>"请选择要显示的列。");
				echo json_encode($ret);	return;
			}
			$post['loginname'] = $_SESSION['cUserNo'];
			$post['menuSetting'] = $showColumStr;
			$Repertory = new RepertoryModel($post);
			$result=$Repertory->updatecolum($post);
			//保存对应的字段到数据库
			if($result['errorCode'] == "0"){
				$ret = array("statusCode"=>"1","message"=>'操作成功。',"navTabId"=>$this->navTab);
				echo json_encode($ret);	return;
			}else{
				$msg = $result['errorMessage'];
				$ret = array("statusCode"=>"0","message"=>$msg);
				echo json_encode($ret);	return;
			}
		}
		//去数据库中去出对应的登录的用户已经设置的字段的记录
		$Repertory = new RepertoryModel($post);
		$result=$Repertory->getShowColums($post);
		$tempolumArr = array();
		if(!empty($result))
		{
			$tempolumArr = explode(",", $result);
		}else
		{
			$tempolumArr = array_keys($this->showColums);
		}
		$this->assign("tempolumArr",$tempolumArr);
		$this->assign("showColums",$this->showColums);
		$this->display();
	}
	
}
