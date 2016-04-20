<?php
/**
 * 质量监控-服务质量
 * @author zengguangqiu
 *
 */
class BatchprocessController extends CommonController {
	//var $navTab = 'D60622';
	var $navTab = '2c948cfb51ebb03c0151ebbaba760018';
	var $deploymentFlagArr = array('1'=>'未发布','2'=>'已发布');
	var $servicetype = array('1'=>'C服务','2'=>'Web服务','3'=>'Java服务');
	var $taskstate = array('1'=>'未完成','2'=>'完成');

	
// 框架首页
	public function index() {
			
		$Batchprocess = new BatchprocessModel($_POST,$_GET);
		if( $_GET['from'] ==  1)
		{
			//来自批量任务获取对应的批量任务ID然后生成新的一个任务
			$metaIDStr = cookie('metaid_datas');
			$batchadd = $_COOKIE['batchadd'];//右键点击添加元素
			if(!empty($batchadd)){
				$ptaskid = $_COOKIE['taskId'];
				$_SESSION['deletedSucess'] = $ptaskid;
				$result = $Batchprocess->createElementDB($ptaskid,$metaIDStr);
				if($result['errorCode'] ==0)
				{
					setcookie('batchadd',null,0,'/');
					setcookie('taskId',null,0,'/');
					cookie('datas',null,array('expire'=>360000,'prefix'=>'metaid_'));
					//Think\Log::write("sssssssssssssssssssssssssssssssssssssssssssss");
				}else{
					setcookie('batchadd',null,0,'/');
					setcookie('taskId',null,0,'/');
					cookie('datas',null,array('expire'=>360000,'prefix'=>'metaid_'));
					$this->error($result['errorMessage']);
				}
			}else{
				if(!empty($metaIDStr))
				{
					$result = $Batchprocess->createtask($metaIDStr);
					if($result['errorCode'] ==0)
					{
						cookie('datas',null,array('expire'=>360000,'prefix'=>'metaid_'));
						setcookie('batchadd',null,0,'/');
					}
				}
			}
			$_POST['flag'] = 'new';
			$_REQUEST['flag'] = 'new';
		}elseif( $_GET['from'] ==  2)
		{
			$_POST['flag'] = 'new';
			$_REQUEST['flag'] = 'new';
		}
		
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
		$_POST['taskstatetree'] = 1;
		$defaultTree = $Batchprocess->defaultTree($_POST,$_GET);
		$_POST['taskstatetree'] = 2;
		$completeTree = $Batchprocess->defaultTree($_POST,$_GET);
		//组装数据
		$tmp_result['defaultTree']	= '{"name":"未完成","url":"/index.php/Service/Batchprocess/list_b?deploymentFlag='. $_POST['deploymentFlag']. '&desployenv='
. $_POST['desployenv']. '&taskstate=1","target":"ajax","open":true';
		
		if(is_array($defaultTree) && count($defaultTree))
		{
			$tmp_result['defaultTree']	.=',"children": [';
			for($i=0;$i<sizeof($defaultTree);$i++){
					
				$tmp_result['defaultTree']
					.= '{"id":"'
					. $defaultTree[$i]["ptaskid"]
					. '","name":"'
					. $defaultTree[$i]["taskname"]
					. '","url":"/index.php/Service/Batchprocess/list_c?id='. $defaultTree[$i]["ptaskid"]. '&deploymentFlag='. $_POST['deploymentFlag']. '&desployenv='
. $_POST['desployenv']. '&showbutton=1","target":"ajax","open":true,"addElement":"1","children":[';
				
				if($defaultTree[$i]['child']){
					for($j=0;$j<sizeof($defaultTree[$i]['child']);$j++ ){
							
						$tmp_result['defaultTree']
							.= '{"id":"'
							. $defaultTree[$i]['child'][$j]['mwid']
							. '","name":"'
							. $defaultTree[$i]['child'][$j]['servicename']
							. '","url":"/index.php/Service/Batchprocess/list_a?ptaskid='
							. $defaultTree[$i]["ptaskid"]. '&id='
							. $defaultTree[$i]['child'][$j]['mwid']. '&deploymentFlag='. $_POST['deploymentFlag']. '&desployenv='. $_POST['desployenv']																
							. '","target":"ajax"},';
					}
				}
				$tmp_result['defaultTree']	.= ']},';
			}
			$tmp_result['defaultTree']	.= ']';
		}
		$tmp_result['defaultTree'] .='}';
		
		
		$tmp_result['completeTree']	= '{"name":"完成","url":"/index.php/Service/Batchprocess/list_b?deploymentFlag='. $_POST['deploymentFlag']. '&desployenv='
. $_POST['desployenv']. '&taskstate=2","target":"ajax","open":true';
		
		if(is_array($completeTree) && count($completeTree))
		{
			$tmp_result['completeTree']	.=',"children": [';
			for($i=0;$i<sizeof($completeTree);$i++){
					
				$tmp_result['completeTree']
				.= '{"id":"'
						. $completeTree[$i]["ptaskid"]
						. '","name":"'
								. $completeTree[$i]["taskname"]
								. '","url":"/index.php/Service/Batchprocess/list_c?id='. $completeTree[$i]["ptaskid"]. '&deploymentFlag='. $_POST['deploymentFlag']. '&desployenv='
								. $_POST['desployenv']. '&showbutton=1","target":"ajax","open":true,"addElement":"0","children":[';
		
				if($completeTree[$i]['child']){
					for($j=0;$j<sizeof($completeTree[$i]['child']);$j++ ){
							
						$tmp_result['completeTree']
						.= '{"id":"'
								. $completeTree[$i]['child'][$j]['mwid']
								. '","name":"'
										. $completeTree[$i]['child'][$j]['servicename']
										. '","url":"/index.php/Service/Batchprocess/list_a?ptaskid='
												. $completeTree[$i]["ptaskid"]. '&id='
												. $completeTree[$i]['child'][$j]['mwid']. '&deploymentFlag='. $_POST['deploymentFlag']. '&desployenv='. $_POST['desployenv']
												. '","target":"ajax"},';
					}
				}
				$tmp_result['completeTree']	.= ']},';
			}
			$tmp_result['completeTree']	.= ']';
		}
		$tmp_result['completeTree'] .='}';
		
		$this->assign ( 'servicetype', $this->servicetype);
		$this->assign ( 'taskstate', $this->taskstate);
		$this->assign ( 'defaultTree', $tmp_result['defaultTree'] );
		$this->assign ( 'completeTree', $tmp_result['completeTree'] );
		$this->assign('deploymentFlagArr',$this->deploymentFlagArr);
		
		$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
		$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		
		$Batchprocess = new BatchprocessModel($_POST,$_GET);
		if($_SESSION['deletedSucess'] > 0)
		{
			$_POST['id'] = $_SESSION['deletedSucess'];
			$result = $Batchprocess->findByProduct($_POST,$_GET);
			$count = $Batchprocess->countByProduct($_POST,$_GET);
			if(empty($result) && $count==0)
			{
				$result = $Batchprocess->findByReqs($_POST,$_GET);
				$count = $Batchprocess->countByReqs($_POST,$_GET);
			}
		}else
		{
			$result = $Batchprocess->findByReqs($_POST,$_GET);
			$count = $Batchprocess->countByReqs($_POST,$_GET);
		}
		//dump($result);
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result );
		$this->assign ( 'map', array('service'=>'','flag'=>'','desployenvp'=>'') );
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
		$this->assign ( 'showbutton', $_GET['showbutton'] );
		$this->assign("deletedSucess",$_SESSION['deletedSucess']);
		unset($_SESSION['deletedSucess']);
		$this->display();
	}
	
	public function add() {
		$this->display();
	}
	
	public function edit() {
		if($_POST){
			$_POST['id'] = $_POST['taskId'];
			$Batchprocess = new BatchprocessModel($_POST,$_GET);
			$result=$Batchprocess->update($_POST,$_GET);
	
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
		$this->assign ( 'taskId', $_GET['taskId'] );
		$this->assign ( 'taskname', $_GET['name'] );
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
				
			$Batchprocess = new BatchprocessModel($_POST,$_GET);
			$result = $Batchprocess->findById($_POST,$_GET);
			$count = $Batchprocess->countById($_POST,$_GET);
				
			$this->assign ( 'totalCount', $count );
			$this->assign ( 'list', $result );
			$this->assign ( 'map', array('service'=>'','level'=>'','startTime'=>'','endTime'=>'') );
			cookie('_currentUrl_', __SELF__);
			$this->assign('deploymentFlagArr',$this->deploymentFlagArr);
			$this->assign ( 'servicetype', $this->servicetype);
			$this->assign ( 'taskstate', $this->taskstate);
			$this->assign ( 'showbutton', $_GET['showbutton'] );
			$this->display('list');
	}
	
	public function list_b() {
			$request = array();
			foreach($_POST as $k =>$v){
				$request[$k] = $v;
			}
				
			C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
			C ( 'SHOW_PAGE_TRACE', false );
			
			if($_GET['taskstate'] -0 > 0)
			{
				$_POST['taskstate'] = $_GET['taskstate'];
				$_REQUEST['taskstate'] = $_GET['taskstate'];
			}
			
			$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
			$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
			$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
				
			$Batchprocess = new BatchprocessModel($_POST,$_GET);
			$result = $Batchprocess->findByTime($_POST,$_GET);
			$count = $Batchprocess->countByTime($_POST,$_GET);
				
			$this->assign ( 'totalCount', $count );
			$this->assign ( 'list', $result );
			$this->assign ( 'map', array('taskstate'=>'') );
			cookie('_currentUrl_', __SELF__);
			$this->assign('deploymentFlagArr',$this->deploymentFlagArr);
			$this->assign ( 'servicetype', $this->servicetype);
			$this->assign ( 'taskstate', $this->taskstate);
			$this->assign ( 'showbutton', $_GET['showbutton'] );
			$this->display('list');
	}
	
	public function list_c() {
		$request = array();
		foreach($_POST as $k =>$v){
			$request[$k] = $v;
		}
	
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		if($_GET['id'] -0 > 0)
		{
			$_POST['id'] = $_GET['id'];
			$_REQUEST['ptaskid'] = $_GET['id'];
		}
		$_POST['data']['deploymentFlag'] = $_GET['deploymentFlag'];
		$_POST['data']['desployenv'] = $_GET['desployenv'];
		$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
		$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
	
		$Batchprocess = new BatchprocessModel($_POST,$_GET);
		$result = $Batchprocess->findByProduct($_POST,$_GET);
		$count = $Batchprocess->countByProduct($_POST,$_GET);
	
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result );
		$this->assign ( 'map', array('service'=>'','id'=>'','ptaskid'=>'') );
		cookie('_currentUrl_', __SELF__);
		$this->assign('deploymentFlagArr',$this->deploymentFlagArr);
		$this->assign ( 'servicetype', $this->servicetype);
		$this->assign ( 'taskstate', $this->taskstate);
		$this->assign ( 'showbutton', $_GET['showbutton'] );
		$this->assign ( 'ptaskid', $_GET['id'] );
		$this->display('list');
	}
	
	public function select_info() {
		$Batchprocess = new BatchprocessModel($_POST,$_GET);
		$tmp_result = $Batchprocess->repConfigTree($_POST,$_GET);
				
		$this->assign ( 'Batchprocess_config_tree', $tmp_result );
		$this->display();
	}

	public function config_detail() {
		$_POST['id'] = intval($_GET['id']);
		$Batchprocess = new BatchprocessModel($_POST,$_GET);
		$tmp_result = $Batchprocess->getInstanceDetail($_POST,$_GET);
	
		$this->assign ( 'data', $tmp_result );
		$this->display();
	}
	
	public function call(){
	
		$Batchprocess = new BatchprocessModel($_POST,$_GET);
		$_POST["data"]=array(
				"ipv"=>"",
				"ptaskid"=>$_GET['ptaskid'],
				"mwid"=>$_GET['mwId'],
				"hostname"=>"",
				"environment"=>$_SESSION['WEB_ENVIRONMENT']
		);
		$ipProductTreetemp = $Batchprocess->ipProductTree($_POST,$_GET);
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
		$defaultInfo = $Batchprocess->getdefaultdesploy($_GET['mwId'],$_GET['ptaskid']);
		
		$this->assign('serName',$_GET['sername']);
		$this->assign('version',$_GET['version']);
		$this->assign('ptaskid',$_GET['ptaskid']);
		$this->assign('mwId',$_GET['mwId']);
		$this->assign('deploymentFlag',$_GET['deploymentFlag']);
		$this->assign('ips',$ips);
		$this->assign('serUser',$defaultInfo['owner']);
		$this->assign('serGroup',$defaultInfo['instanceGroup']);
		$this->assign('processNum',$defaultInfo['process']);
		$this->assign('desploypath',$defaultInfo['path']);
		$this->assign ( 'ipProductTree', $tmp_result['ipProductTree'] );
		$this->assign('defaultInfo',$defaultInfo);
		$this->display();
	}
	

	
	public function createconfig(){
	
		if(empty($_POST['ips']))
		{
			$msg = '机器未选择';
			$ret = array("statusCode"=>"0","message"=>$msg,"navTabId"=>'',//$this->navTab
					"rel"=>"createconfig","forwardUrl"=>"","callbackType"=>"");
			exit(json_encode($ret));
		}
		$Batchprocess = new BatchprocessModel($_POST,$_GET);
		/* if($_POST['disType'] == '2')
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
					$ret = $Batchprocess->requestBySoap('DealNotice',$post_str);
				}
			}
	
		} */
		$_POST['form_act']='createconfig';
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
				'environment'=>trim($_SESSION['WEB_ENVIRONMENT']),
				'ptaskid'=>$_POST['ptaskid'],
		);
		
		$result=$Batchprocess->postSave($_POST,$_GET);
	
		if($result['errorCode'] == "0"){
			$ret = array("statusCode"=>"1","message"=>'操作成功。',"rel"=>"createconfig","forwardUrl"=>"","callbackType"=>"closeCurrent");
			echo json_encode($ret);	return;
		}else{
			$msg = $result['errorMessage'];
			$ret = array("statusCode"=>"0","message"=>$msg,"navTabId"=>'',//$this->navTab
					"rel"=>"createconfig","forwardUrl"=>"","callbackType"=>"");
			echo json_encode($ret);	return;
		}
	}
		
	public function del(){
		
		$Batchprocess = new BatchprocessModel($_POST,$_GET);
		$id=$_GET['id'];
		$taskid=$_GET['taskid'];
		if($id > 0 && $taskid > 0){
			$result=$Batchprocess->deleteById($taskid,$id);
		}else{
			$ret = array("statusCode"=>"0","message"=>"选择不能为空!");
			echo json_encode($ret);	return;			
		}
		
		if($result['errorCode'] == "0"){
			$ret = array("statusCode"=>"1","message"=>'操作成功。',"navTabId"=>$this->navTab);
			$_SESSION['deletedSucess'] = $taskid;
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
				
			$Batchprocess = new BatchprocessModel($_POST,$_GET);
			$result = $Batchprocess->findByReqs($_POST,$_GET);
			$count = $Batchprocess->countByReqs($_POST,$_GET);
			$this->assign ( 'totalCount', $count );
			$this->assign ( 'list', $result );
			$this->assign ( 'map', array('desployenv'=>'','taskstate'=>'','ptaskid'=>'') );
			cookie('_currentUrl_', __SELF__);
			$this->assign('deploymentFlagArr',$this->deploymentFlagArr);
			$this->assign ( 'servicetype', $this->servicetype);
			$this->assign ( 'taskstate', $this->taskstate);
			$this->display('list');
		}
	}

	public function delete(){
	
		//dump($_POST);
		$Batchprocess = new BatchprocessModel($_POST,$_GET);
		$result=$Batchprocess->deleteByTaskId($_POST['id']);
		if($result['errorCode'] == "0"){
			$ret = array("statusCode"=>"200","message"=>'操作成功',"forwardUrl"=>'/index.php/Service/Batchprocess/index/from/2');
			
			echo json_encode($ret);	return;
		}else{
			$msg = $result['errorMessage'];
			$ret = array("statusCode"=>"0","message"=>$msg);
			echo json_encode($ret);	return;
		}
	}
	/*
	 * 进行批量部署
	 */
	public function gobatchprocess()
	{
		if(empty($_POST['mwid']))
		{
			$ret = array("statusCode"=>"1","message"=>'请选择批量部署的服务');
			echo json_encode($ret);	return;
		}
		$Batchprocess = new BatchprocessModel($_POST,$_GET);
		$result=$Batchprocess->gobatchprocess($_POST,$_GET);
		if($result['errorCode'] == "0"){
			$ret = array("statusCode"=>"200","message"=>'操作成功。');
			echo json_encode($ret);	return;
		}else{
			$msg = $result['errorMessage'];
			$ret = array("statusCode"=>"0","message"=>$msg);
			echo json_encode($ret);	return;
		}
		
	}
	
	//判断是否已经生成 
	function checkComplete(){
		$ptaskid = $_REQUEST['taskId'];
		$Batchprocess = new BatchprocessModel($_POST,$_GET);
		$metaIDStr = '';
		$result = $Batchprocess->createElementDB($ptaskid,$metaIDStr);
		if($result['errorCode'] ==0)
		{
			echo "1";
		}else{
			echo $result['errorMessage'];
		}
		
	}
}
