<?php

//动作管理 
class ActController extends CommonController {
	var $navTab = 'L10003';
	var $pageSize = "17";
	var $pageNumShown = "5";
	
    function index(){
    	$header = C('queryProducts');
    	$reqs = array("pageNo"=>1,"pageSize"=>20);
    	 
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$reqs);
    	$products = $data['datalist'];
    	//print_r($data);
    	$this->assign ('products', $products );
    	
    	$header = C('queryActions');
    	$request = array();
    	if(!empty($_POST)){
    		$queryCon = array();
    		foreach($_POST as $k =>$v){
    			if($k == 'actCode' ||$k == 'actName'||$k=='productId' ){
    				$queryCon[$k] = $v;
    			}else{
    				$request[$k] = $v;
    			}
    		}
    		//$queryCon['productId'] =($queryCon['productId'] == "")?$products[0]['id']:$queryCon['productId'];
    		$request['queryCon'] = $queryCon;
    	}
    	
    	$request['pageNo'] = ($_POST['pageNum'] == "")? 1:$_POST['pageNum'];
    	$request['pageSize'] = $this->pageSize;
    	$request['queryCon']['productId'] = ($_COOKIE['productId'] == "")?$products[0]['id']:$_COOKIE['productId'];
    	
    	//设置cookie 搜索的时候不需要设置
    	if($_COOKIE['productName'] == ''){
	    	setcookie("productName",$products[0]['productName']);
	    	setcookie("productId",$products[0]['id']);
    	}
    	
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$request);
    	$actions = $data['datalist'];
    	//print_r($data);
    	$this->assign ('actions', $actions );
    	

    	//print_r($actions);
    	$this->assign ('totalCount', $data['totalnum']);
    	$this->assign ('currentPage', $request['pageNo'] );
    	$this->assign ('numStart', ($request['pageNo']-1)*$this->pageSize );
    	$this->assign ('numPerPage', $this->pageSize );
    	$this->assign ('pageNumShown', $this->pageNumShown );
    	$this->display();
    }
   
    function add(){
    	if(!empty($_POST)){
    		$header = C('addAction');
    		$request = array();
    		$actionList = array();
    		/*$tmp = array();
    		foreach($_POST as $k =>$v){
    			if($k == 'menuid'){
    				$request[$k] = $v;
    			}else{
    				$tmp[$k] = $v;
    			};
    			
    		}*/
    		$count = count($_POST['actName']);
    		for($i = 0;$i<$count;$i++){
    			$actionList[$i] = array('actName'=>$_POST['actName'][$i],'actCode'=>$_POST['actCode'][$i],'remark'=>$_POST['remark'][$i]);
    		}
    		$request['menuid'] = $_POST['menuid'];
    		$request["productId"] = $_COOKIE['productId'];
    		$request["actionList"] = $actionList;
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

    	$header = C('queryMenus');
    	$reqs = array("productId"=>$_COOKIE['productId']);
    	
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$reqs);
    	$menu = $data['menuList'];
    	//print_r($data);
    	$this->assign ('menu', $menu );
    	$this->display();
    }
    
    function detail(){
    	$this->display();
    }
    
    function edit($id){
        if(!empty($_POST)){
    		$request = array();
    		foreach($_POST as $k =>$v){
    			$request[$k] = $v;
    		}
    		
    		$header = C('updateAction');

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
    	
    	}else{
    		$header = C('queryAction');
    		$request = array('actId'=>$id);
    		
    		$action = $this->getById($header,$request);
    		//print_r($product);
    		$this->assign ('action', $action);
    		$this->display();
    	}
    }
    
    function delete($id){
    	if($id != ""){
    		$aid_pid = array();
    		$aid_pid = explode(",",$id);
    		$aid = $aid_pid[0];
    		$pid = $aid_pid[1];
    		
    		$header = C('deleteAction');
    		$request = array("ids"=>$aid,"productId"=>$pid);
    		 
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
    	echo json_encode(array());
    }
    
     
    
}