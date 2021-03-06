<?php
/**
 * 质量监控-服务质量
 * @author zengguangqiu
 *
 */
class SerqualitymonController extends CommonController {
	//var $navTab = 'D60602';
	var $navTab = '2c948cfb51ebb03c0151ebb9ea470016';
	var $deploymentFlagArr = array('1'=>'未发布','2'=>'已发布');
	var $servicetype = array('1'=>'C服务','2'=>'Web服务','3'=>'Java服务');

	
// 框架首页
	public function index() {
			
		$Serqualitymon = new SerqualitymonModel($_POST,$_GET);
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
		$defaultTree = $Serqualitymon->defaultTree($_POST,$_GET);
		
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
					. '","url":"/index.php/Service/Serqualitymon/list_c?id='. $defaultTree[$i]["id"]. '&deploymentFlag='. $_POST['deploymentFlag']. '&desployenv='
. $_POST['desployenv']. '","target":"ajax","open":true,"children":[';
				
				if($defaultTree[$i]['child']){
					for($j=0;$j<sizeof($defaultTree[$i]['child']);$j++ ){
							
						$tmp_result['defaultTree']
							.= '{"id":"'
							. $defaultTree[$i]['child'][$j]['serviceid']
							. '","name":"'
							. $defaultTree[$i]['child'][$j]['servicename']
							. '","url":"/index.php/Service/Serqualitymon/list_a?id='
							. $defaultTree[$i]['child'][$j]['serviceid']. '&deploymentFlag='. $_POST['deploymentFlag']. '&desployenv='. $_POST['desployenv']
							. '","path":"'
							. $defaultTree[$i]['child'][$j]['desploypath']							
							. '","defaultcfgid":"'
							. $defaultTree[$i]['child'][$j]['defaultcfgid']
							. '","defaultcfg":"'
							. $defaultTree[$i]['child'][$j]['defaultcfg']																	
							. '","target":"ajax","open":true,"children":[';
							
						if($defaultTree[$i]['child'][$j]['datelist']){
							for($k=0;$k<sizeof($defaultTree[$i]['child'][$j]['datelist']);$k++ ){
								$tmp_result['defaultTree']
									.= '{"id":"'
									. $defaultTree[$i]['child'][$j]['serviceid']
									. '","name":"'
									. $defaultTree[$i]['child'][$j]['datelist'][$k]
									. '","url":"/index.php/Service/Serqualitymon/list_b?id='
									. $defaultTree[$i]['child'][$j]['serviceid']. '&deploymentFlag='. $_POST['deploymentFlag']. '&desployenv='
. $_POST['desployenv']
									. '&time='
									. $defaultTree[$i]['child'][$j]['datelist'][$k]
									. '","target":"ajax"},';
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
		
		$Serqualitymon = new SerqualitymonModel($_POST,$_GET);
		$result = $Serqualitymon->findByReqs($_POST,$_GET);
		$count = $Serqualitymon->countByReqs($_POST,$_GET);
		//dump($result);
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result );
		$this->assign ( 'map', array('service'=>'','level'=>'','startTime'=>'','endTime'=>'','desployenvp'=>'') );
		cookie('_currentUrl_', __SELF__);
		
		//根据环境设置对应显示的树形类型的字段
		if($_SESSION['WEB_ENVIRONMENT'] == 3 || $_SESSION['WEB_ENVIRONMENT'] == 4)
		{
			$treeType = 1;
		}elseif($_SESSION['WEB_ENVIRONMENT'] == 1 || $_SESSION['WEB_ENVIRONMENT'] == 2)
		{
			$treeType = 2;
		}
		$this->assign ( 'treeType', $treeType );
		$this->display();
	}
	
	public function add() {
		$this->display();
	}
	
	public function edit() {
		if($_POST){
			$_POST['cfgid'] = $_POST['editmrconfig_id'];
			$Serqualitymon = new SerqualitymonModel($_POST,$_GET);
			$result=$Serqualitymon->update($_POST,$_GET);
	
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
			$Serqualitymon = new SerqualitymonModel($_POST,$_GET);
			$defaultInfo = $Serqualitymon->getdefaultdesploy($_GET['mwId'],'ssid');
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
				
			$Serqualitymon = new SerqualitymonModel($_POST,$_GET);
			$result = $Serqualitymon->findById($_POST,$_GET);
			$count = $Serqualitymon->countById($_POST,$_GET);
				
			$this->assign ( 'totalCount', $count );
			$this->assign ( 'list', $result );
			$this->assign ( 'map', array('service'=>'','level'=>'','startTime'=>'','endTime'=>'') );
			cookie('_currentUrl_', __SELF__);
			$this->assign('deploymentFlagArr',$this->deploymentFlagArr);
			$this->assign ( 'servicetype', $this->servicetype);
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
				
			$Serqualitymon = new SerqualitymonModel($_POST,$_GET);
			$result = $Serqualitymon->findByTime($_POST,$_GET);
			$count = $Serqualitymon->countByTime($_POST,$_GET);
				
			$this->assign ( 'totalCount', $count );
			$this->assign ( 'list', $result );
			$this->assign ( 'map', array('service'=>'','level'=>'','startTime'=>'','endTime'=>'') );
			cookie('_currentUrl_', __SELF__);
			$this->assign('deploymentFlagArr',$this->deploymentFlagArr);
			$this->assign ( 'servicetype', $this->servicetype);
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
	
		$Serqualitymon = new SerqualitymonModel($_POST,$_GET);
		$result = $Serqualitymon->findByProduct($_POST,$_GET);
		$count = $Serqualitymon->countByProduct($_POST,$_GET);
	
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result );
		$this->assign ( 'map', array('service'=>'','level'=>'','startTime'=>'','endTime'=>'') );
		cookie('_currentUrl_', __SELF__);
		$this->assign('deploymentFlagArr',$this->deploymentFlagArr);
		$this->assign ( 'servicetype', $this->servicetype);
		$this->display('list');
	}
	
	public function select_info() {
		$Serqualitymon = new SerqualitymonModel($_POST,$_GET);
		$tmp_result = $Serqualitymon->repConfigTree($_POST,$_GET);
				
		$this->assign ( 'Serqualitymon_config_tree', $tmp_result );
		$this->display();
	}

	public function config_detail() {
		$_POST['id'] = intval($_GET['id']);
		$Serqualitymon = new SerqualitymonModel($_POST,$_GET);
		$tmp_result = $Serqualitymon->getInstanceDetail($_POST,$_GET);
	
		$this->assign ( 'data', $tmp_result );
		$this->display();
	}
		
	public function del(){
		
		$Serqualitymon = new SerqualitymonModel($_POST,$_GET);
		$id=$_GET['id'];
		if($id){
			$result=$Serqualitymon->deleteById($id);
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
				
			$Serqualitymon = new SerqualitymonModel($_POST,$_GET);
			$result = $Serqualitymon->findByReqs($_POST,$_GET);
			$count = $Serqualitymon->countByReqs($_POST,$_GET);
				
			$this->assign ( 'totalCount', $count );
			$this->assign ( 'list', $result );
			$this->assign ( 'map', array('service'=>'','level'=>'','startTime'=>'','endTime'=>'','desployenv'=>'') );
			cookie('_currentUrl_', __SELF__);
			$this->assign('deploymentFlagArr',$this->deploymentFlagArr);
			$this->assign ( 'servicetype', $this->servicetype);
			$this->display('list');
		}
	}

	public function importsvn(){
		set_time_limit(0);
		$Serqualitymon = new SerqualitymonModel($_POST,$_GET);
		$svnurl=$_POST['svnurl'];
		if($svnurl){
			$tempurl = explode("\n", $svnurl);
			$svnurl = implode('##', $tempurl);
			$result=$Serqualitymon->importByLink($svnurl);
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
		
		$Serqualitymon = new SerqualitymonModel($_POST,$_GET);
		$_POST["data"]=array(
				"ipv"=>"",
				"mwid"=>$_GET['mwId'],
				"hostname"=>"",
				"environment"=>$_SESSION['WEB_ENVIRONMENT']
		);
		$ipProductTreetemp = $Serqualitymon->ipProductTree($_POST,$_GET);
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
		$defaultInfo = $Serqualitymon->getdefaultdesploy($_GET['ssid']);
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
	
		$Serqualitymon = new SerqualitymonModel($_POST,$_GET);
		$_POST["data"]=array(
				"ipv"=>$_POST['ip'],
				"mwid"=>$_POST['mwId'],
				"hostname"=>$_POST['hostname'],
				"environment"=>$_SESSION['WEB_ENVIRONMENT']
		);
		$ipProductTreetemp = $Serqualitymon->ipProductTree($_POST,$_GET);
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
		$Serqualitymon = new SerqualitymonModel($_POST,$_GET);
		$result=$Serqualitymon->getInstanceDetail($_POST,$_GET);
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
		$Serqualitymon = new SerqualitymonModel($_POST,$_GET);
		if($_POST['disType'] == '2')
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
					$ret = $Serqualitymon->requestBySoap('DealNotice',$post_str);
				}
			}
				
		}
		$_POST['form_act']='createPlans';
		$_POST['data']=array(
			'ipv'=>explode(',',$_POST['ips']),
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
					
		$result=$Serqualitymon->postSave($_POST,$_GET);
		
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
						$tmp_result['result']['config_nodes']	.= '{"id":"' . $result[$k1]['child'][$k2]['id'] . '","name":"' . $result[$k1]['child'][$k2]['configItemName'] . '","url":"/index.php/Service/Serqualitymon/detail?type=a&id=' . $result[$k1]['child'][$k2]['id'] . '","target":"ajax"},';
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
							$tmp_result['result']['examples_nodes']	.= '{"id":"' . $result[$k1]['child'][$k2]['id'] . '","name":"' . $result[$k1]['child'][$k2]['configInstanceName'] . '","url":"/index.php/Service/Serqualitymon/config_detail?id=' . $result[$k1]['child'][$k2]['id'] . '","target":"ajax"},';
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
}
