<?php

//机构管理
class BanrchController extends CommonController {
	var $navTab = 'L10003';
	var $pageSize = "16";
	var $pageNumShown = "2";

    function index(){
    	$header = C('queryOrgs');
    	//这个参数不需要"pageNo"=>1,"pageSize"=>100
    	$reqs = array();
    	
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$reqs);
    	$orgs = $data['datalist'];
    	$this->assign ('orgs', $orgs);
    	//print_r($data);
    	$this->display();
    }
   
    function detail(){
    	$data = array();
    	if($_POST['id'] != ""){
	    	$header = C('queryOrg');
	    	$request = array("id"=>$_POST['id']);
	    	 
	    	$data = $this->getById($header,$request);
	    	$menu = $data['menuList'];
    	}
    	echo json_encode($data);
    }
    
    //增，删，改
    function operate(){
    	if($_POST){
    		$request = array();
    		foreach($_POST as $k =>$v){
    			$request[$k] = $v;
    		}
    		if($_POST['type'] == '1'){
    			$header = C('deleteOrg');
    			$request['ids'] = $_POST['id'];
    		}elseif($_POST['type'] == '2'){
    			$header = C('addOrg');
    		}else{
    			$header = C('updateOrg');
    		}
    		
    		$SendMessage= new SendMessage;
    		$data = $SendMessage ->send($header,$request);
    		if($data['code'] == 0){
    			$ret = array("statusCode"=>"1","message"=>'正确',"navTabId"=>'',//$this->navTab
    					"rel"=>"","forwardUrl"=>"","callbackType"=>"");
    			echo json_encode($ret);	return;
    		}else{
    			$ret = array("statusCode"=>"300","message"=>$data['msg'],"navTabId"=>'',//$this->navTab
    					"rel"=>"","forwardUrl"=>"","callbackType"=>"");
    			echo json_encode($ret);	return;
    		}
    	}
    }
    
    function getBanrchs(){
    	$header = C('queryOrgs');
    	$reqs = array("pageNo"=>1,"pageSize"=>100);
    	 
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$reqs);
    	$orgs = $data['datalist'];
    	echo json_encode($orgs);
    }
    /*
    function add(){
    	if(!empty($_POST)){
    		$header = C('addOrg');
    		$request = array();
    		foreach ($_POST as $k=>$v){
    			$request[$k] = $v;
    		}
    		$SendMessage= new SendMessage;
    		$data = $SendMessage ->send($header,$request);
    		if($data['code'] == "0"){
    			$ret = array("statusCode"=>"1","message"=>'正确',"navTabId"=>'',//$this->navTab
    					"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
    			echo json_encode($ret);	return;
    		}else{
    			$ret = array("statusCode"=>"300","message"=>$data['msg'],"navTabId"=>'',//$this->navTab
    					"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
    			echo json_encode($ret);	return;
    		}
    	}
    }

    function edit(){
    	if($_POST){
    		$request = array();
    		foreach($_POST as $k =>$v){
    			$request[$k] = $v;
    			 
    		}
    		$header = C('updateOrg');
    		$SendMessage= new SendMessage;
    		$data = $SendMessage ->send($header,$request);
    		if($data['code'] == 0){
    			$ret = array("statusCode"=>"1","message"=>'正确',"navTabId"=>'',//$this->navTab
    					"rel"=>"","forwardUrl"=>"","callbackType"=>"");
    			echo json_encode($ret);	return;
    		}else{
    			$ret = array("statusCode"=>"300","message"=>$data['msg'],"navTabId"=>'',//$this->navTab
    					"rel"=>"","forwardUrl"=>"","callbackType"=>"");
    			echo json_encode($ret);	return;
    		}
    		
    	}
    }
    
    function delete(){
    	if(!empty($_POST['id'])){
    		$mid_pid = array();
	    	$header = C('deleteOrg');
	    	$request = array("id"=>$_POST['id']);
	    	 
    		$SendMessage= new SendMessage;
    		$data = $SendMessage ->send($header,$request);
    		if($data['code'] === 0){
    			$ret = array("statusCode"=>"1","message"=>'正确',"navTabId"=>'',//$this->navTab
    					"rel"=>"","forwardUrl"=>"","callbackType"=>"");
    			echo json_encode($ret);	return;
    		}else{
    			$ret = array("statusCode"=>"300","message"=>$data['msg'],"navTabId"=>'',//$this->navTab
    					"rel"=>"","forwardUrl"=>"","callbackType"=>"");
    			echo json_encode($ret);	return;
    		}
    	}
    	echo json_encode(array());
    }
       */
    
}