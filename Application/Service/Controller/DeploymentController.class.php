<?php
/**
 * 服务管制-部署脚本
 * @author zengguangqiu
 *
 */
class DeploymentController extends CommonController {
	//var $navTab = 'D60603';
	var $navTab = '2c948cfb51ec5db00151ec975f99002b';
	var $typeProp=array(
		'1'=>'主机脚本 ',	
		'2'=>'节点脚本 ',			
	);
	
// 框架首页
	public function index() {
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		
		$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
		$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		$Deployment = new DeploymentModel($_POST,$_GET);
		$result = $Deployment->findByPost($_POST,$_GET);
		$count = $Deployment->countByPost($_POST,$_GET);
		$this->assign('typeProp',$this->typeProp);
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result );
		//dump($result);
		cookie('_currentUrl_', __SELF__);
				
		$this->display();
	}	
	
	public function add() {		
		if($_POST){
			$request = array();
			foreach($_POST as $k =>$v){
				$request[$k] = $v;
			}
		
			//组织要保存的数据
			$post['data']=array(
					"smId"=>$_POST['smId'],
					"smTyProperty"=>$_POST['smTyProperty'],
					"smName"=>$_POST['smName'],
					"smAddress"=>$_POST['smAddress'],
					"smParameters"=>$_POST['smParameters'],
					"smFunction"=>$_POST['smFunction'],
					"smDemo"=>$_POST['smDemo']
			);
			$post['form_act']='createShellscript';
				
			//调用java接口进行数据的操作
			$Deployment = new DeploymentModel($_POST,$_GET);
			$result = $Deployment->postSave($post);
			if($result['errorCode'] == "0"){
				$ret = array("statusCode"=>"1","message"=>'操作成功。',"navTabId"=>$this->navTab,
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				echo json_encode($ret);	return;
			}else{
				$msg = $result['errorMessage'];
				$ret = array("statusCode"=>"0","message"=>$msg,"navTabId"=>$this->navTab,
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				echo json_encode($ret);	return;
			}
		}
		
		$this->display();
	}
	
	public function edit() {
		if($_POST){
			$request = array();
			foreach($_POST as $k =>$v){
				$request[$k] = $v;
			}
	
			//组织要保存的数据
// 			dump($_POST);
			$post['id']=$_POST['smId'];
			$post['data']=array(
					"smTyProperty"=>$_POST['smTyProperty'],
					"smName"=>$_POST['smName'],
					"smAddress"=>$_POST['smAddress'],
					"smParameters"=>$_POST['smParameters'],
					"smFunction"=>$_POST['smFunction'],
					"smDemo"=>$_POST['smDemo']
			);
			$post['form_act']='updateShellscript';
			
			//调用java接口进行数据的操作
			$Deployment = new DeploymentModel($_POST,$_GET);
			$result = $Deployment->postSave($post);
			if($result['errorCode'] == "0"){
				$ret = array("statusCode"=>"1","message"=>'操作成功。',"navTabId"=>$this->navTab,
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				echo json_encode($ret);	return;
			}else{
				$msg = $result['errorMessage'];
				$ret = array("statusCode"=>"0","message"=>$msg,"navTabId"=>$this->navTab,
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				echo json_encode($ret);	return;
			}
		}
		$Deployment = new DeploymentModel($_POST,$_GET);
		$script_id=$_GET['script_id'];
		if(!$script_id){
			$ret = array("statusCode"=>"0","message"=>"选择不能为空!");
			echo json_encode($ret);	return;
		}
		$result = $Deployment->findById($script_id);
		
		$this->assign ( 'result', $result['data'] );
		$this->display();
	}
	
	public function delete(){

				
		$Deployment = new DeploymentModel($_POST,$_GET);
		$script_id = $_GET['script_id'];
		//dump($script_id);
		//alert($script_id);
		if($script_id){
			$result=$Deployment->deleteById($script_id);
		}else{
			$ret = array("statusCode"=>"0","message"=>"选择不能为空!");
			echo json_encode($ret);	return;			
		}

		//dump($result);
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
				"hostname"=>"",
				"mwid"=>"init",
				"environment"=>$_SESSION['WEB_ENVIRONMENT']
		);
		$ipProductTreeTemp = $Repertory->ipProductTree($_POST,$_GET);
		$ipProductTree = $ipProductTreeTemp['lastret'];
		//组装数据
	
	
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
					for($j=0;$j<sizeof($ipProductTree[$i]['child']);$j++ ){
	
						$tmp_result['ipProductTree']
						.= '<li><a href="javascript:;" tname="ipv" tvalue="'
								. $ipProductTree[$i]['child'][$j]['ipaddress']
								. '" class="level2">'
										. $ipProductTree[$i]['child'][$j]['ipname']
										. '</a></li>';
					}
				}
				$tmp_result['ipProductTree']	.= '</ul>';
				$tmp_result['ipProductTree']	.= '</li>';
			}
			$tmp_result['ipProductTree'] .='</ul>';
		}
		$sid = $_GET['scriptid'];
		$this->assign('sid',$sid);
		$this->assign ( 'ipProductTree', $tmp_result['ipProductTree'] );
		$this->display();
	}
	
	public function excuteorder(){
	
		$Repertory = new RepertoryModel($_POST,$_GET);
		$_POST["data"]=array(
				"ipv"=>$_POST['ip'],
				"hostname"=>$_POST['hostname'],
				"mwid"=>"init",
				"environment"=>$_SESSION['WEB_ENVIRONMENT']
		);
		$ipProductTreeTemp = $Repertory->ipProductTree($_POST,$_GET);
		$ipProductTree = $ipProductTreeTemp['lastret'];
		//组装数据
	
	
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
					for($j=0;$j<sizeof($ipProductTree[$i]['child']);$j++ ){
	
						$tmp_result['ipProductTree']
						.= '<li><a href="javascript:;" tname="ipv" tvalue="'
								. $ipProductTree[$i]['child'][$j]['ipaddress']
								. '" class="level2">'
										. $ipProductTree[$i]['child'][$j]['ipname']
										. '</a></li>';
					}
				}
				$tmp_result['ipProductTree']	.= '</ul>';
				$tmp_result['ipProductTree']	.= '</li>';
			}
			$tmp_result['ipProductTree'] .='</ul>';
		}
		$sid = $_GET['scriptid'];
		$this->assign('sid',$sid);
		$this->assign ( 'ipProductTree', $tmp_result['ipProductTree'] );
		$this->display();
	}
	
	
	
	/**
	 * 调用唐工的接口初始化机器
	 */
	public function initmechine()
	{
		$id = $_POST['scriptid'];
		$ipv =  $_POST['ips'];
		$Repertscrhis = new RepertscrhisModel();
		$post['data']=array(
				'id'=>$id,
				'ipv'=>$ipv,
				'person'=>$_SESSION['cUserNo']
		);
		$result = $Repertscrhis->initmechine($post);
		
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
	
	/**
	 * 调用唐工的接口初始化机器
	 */
	public function toexcuteorder()
	{
		$username = $_POST['username'];
		$scriptCmdtemp = $_POST['scriptCmd'];
		$pattern = "/&/i";
		$replacement = "|1@2|";
		/* $tempvalue = iconv("utf-8","gb2312",$scriptCmdtemp);
		$tempvalue64 =base64_encode($tempvalue); */
		$scriptCmd = preg_replace($pattern, $replacement, $scriptCmdtemp);
		$ipv =  $_POST['ips'];
		$Repertscrhis = new RepertscrhisModel();
		$post['data']=array(
				'username'=>$username,
				'scriptCmd'=>$scriptCmd,
				'ipv'=>$ipv,
				'person'=>$_SESSION['cUserNo']
		);
		$result = $Repertscrhis->excuteorder($post);
	
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
		
}