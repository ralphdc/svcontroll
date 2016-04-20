<?php

//授权管理
class GrantController extends CommonController {
	var $navTab = 'L10004';
	var $pageSize = "5";
	var $pageNumShown = "5";
    function index(){
    	$header = C('queryUsers');
    	$pageNum = ($_POST['pageNum'] == "" )?"1":$_POST['pageNum'];
    	$reqs = array("pageNo"=>$pageNum,"pageSize"=>$this->pageSize);
    	if($_POST['userName']){
    		$reqs['queryCon']['userName'] = $_POST['userName'];
    	}
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$reqs);
    	$authusers = $data['datalist'];
    	
    	$this->assign ('authUsers', $authusers );
    	
    	$this->assign ('totalCount', $data['totalnum']);
    	$this->assign ('currentPage', $pageNum );
    	$this->assign ('numPerPage', $this->pageSize );
    	$this->assign ('pageNumShown', $this->pageNumShown );
    	$this->assign ('numStart', ($pageNum-1)*$this->pageSize );
    	//被授权用户
    	
    	$header = C('queryUsers');
    	$pageNum2 = ($_POST['pageNum2'] == "" )?"1":$_POST['pageNum2'];
    	$reqs2 = array("pageNo"=>$pageNum2,"pageSize"=>$this->pageSize);
    	
    	$reqs2['queryCon']['userName'] = $_POST['userName2'];
    	
    	$SendMessage= new SendMessage;
    	$data2 = $SendMessage ->send($header,$reqs2);
    	$authusers2 = $data2['datalist'];
    	
    	$this->assign ('authUsers2', $authusers2 );
    	$this->assign ('totalCount2', $data2['totalnum']);
    	$this->assign ('currentPage2', $pageNum2);
    	$this->assign ('numPerPage2', $this->pageSize );
    	$this->assign ('pageNumShown2', $this->pageNumShown );
    	$this->display();
    }
   
    
    function edit($id){
    	$grantuerid = $_GET['id'];
    	$regrantuserids = $_GET['regantid'];
    	
    	$header = C('queryProducts');
    	$request = array();
    	if($request["pageNo"] == ""){
    		$request["pageNo"] = 1;
    	}
    	if($request["pageSize"] == ""){
    		$request["pageSize"] = $this->pageSize;
    	}
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$request);
    	$products = $data['datalist'];
    	
    	$this->assign ('grantuerid', $grantuerid);
    	$this->assign ('regrantuserids', $regrantuserids);
    	$this->assign ('products', $products);
    	//print_r($products);
    	$this->display();
    }
    

	function grant(){
		$grantuerid = $_POST['grantuerid'];
		$regrantuserids = $_POST['regrantuserids'];
		$products = $_POST['product'];
		$from = $_POST['fromtime'];
		$endtime = $_POST['endtime'];
		$dates = $_POST['dates'];
				
		$header = C('grantToUser');
		$request = array('authorizerId'=>$grantuerid,"handlerIds"=>$regrantuserids,"begindate"=>$from,"enddate"=>$endtime, "productIds"=>$products);
		$SendMessage= new SendMessage;
		$data = $SendMessage ->send($header,$request);

		if($data['code'] == "0"){
			$ret = array("statusCode"=>"1","message"=>'正确',"navTabId"=>'',//$this->navTab
					"rel"=>"","forwardUrl"=>"","callbackType"=>"");
			echo json_encode($ret);	return;
		}else{
			$ret = array("statusCode"=>"300","message"=>$data['msg'],"navTabId"=>'',//$this->navTab
					"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
			echo json_encode($ret);	return;
		}
		
	}
	//查看被授权的用户和组
	function getGrantUserOrGroup(){
		$header = C('queryPrivilege');
		$request = array('authorizerId'=>$_POST['authorizerId'],'pageNo'=>1,'pageSize'=>20);
		$SendMessage= new SendMessage;
		$data = $SendMessage ->send($header,$request);
		$users = $data['dataList'];
		$this->assign ('users', $users );
		$this->display();
		//echo json_encode($users);
	}
	

	//点击分页查找可以授权的人
	function showGrantUser(){
		$header = C('queryUsers');
		$pageNum = ($_POST['pageNum'] == "" )?"1":$_POST['pageNum'];
		$reqs = array("pageNo"=>$pageNum,"pageSize"=>$this->pageSize);
		if($_POST['userName']){
			$reqs['queryCon']['userName'] = $_POST['userName'];
		}
		$SendMessage= new SendMessage;
		$data = $SendMessage ->send($header,$reqs);
		$authusers = $data['datalist'];
			
		$this->assign ('authUsers', $authusers );
		$this->assign ('totalCount', $data['totalnum']);
		$this->assign ('currentPage', $pageNum );
		$this->assign ('numPerPage', $this->pageSize );
		$this->assign ('pageNumShown', $this->pageNumShown );
		$this->assign ('numStart', ($pageNum-1)*$this->pageSize );
		$this->display();
	
	}
	
	//点击分页查找被授权人
	function showGrantedUser(){
		$header = C('queryUsers');
    	$pageNum = ($_POST['pageNum'] == "" )?"1":$_POST['pageNum'];
    	$reqs = array("pageNo"=>$pageNum,"pageSize"=>$this->pageSize);
    	if($_POST['userName']){
    		$reqs['queryCon']['userName'] = $_POST['userName'];
    	}
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$reqs);
    	$authusers = $data['datalist'];
    	
    	$this->assign ('authUsers', $authusers );
    	$this->assign ('totalCount', $data['totalnum']);
    	$this->assign ('currentPage', $pageNum );
    	$this->assign ('numPerPage', $this->pageSize );
    	$this->assign ('pageNumShown', $this->pageNumShown );
    	$this->assign ('numStart', ($pageNum-1)*$this->pageSize );
    	$this->display();
		
	}
	
	
     
    
}