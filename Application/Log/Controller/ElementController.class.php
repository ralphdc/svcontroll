<?php

//元素管理类
class ElementController extends CommonController {
	var $navTab = 'L10003';
	var $pageSize = "17";
	var $pageNumShown = "5";

    function index(){
    	$header = C('queryProducts');
    	$reqs = array("pageNo"=>1,"pageSize"=>20);
    	
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$reqs);
    	$products = $data['datalist'];
    	$this->assign ('products', $products );
    	$header = C('queryElements');
    	if(!empty($_POST)){
    		$queryCon = array();
    		foreach($_POST as $k =>$v){
    			if($k == 'elementCode' ||$k == 'elementName'||$k=='productId' ){
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
    	$request['queryCon']['productId'] = ($_COOKIE['productId'] == "")? $products[0]['id']:$_COOKIE['productId'];
    	
    	//设置cookie 搜索的时候不需要设置
    	if($_COOKIE['productName'] == ''){
	    	setcookie("productName",$products[0]['productName']);
	    	setcookie("productId",$products[0]['id']);
    	}
    	
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$request);
    	$Elements = $data['datalist'];
    	//print_r($data);
    	$this->assign ('elements', $Elements );
    	
    	$this->assign ('totalCount', $data['totalnum']);
    	$this->assign ('currentPage', $request['pageNum'] );
    	$this->assign ('numPerPage', $this->pageSize );
    	$this->assign ('pageNumShown', $this->pageNumShown );
    	
    	$this->display();
    }
   
    function add(){
    	if(!empty($_POST)){
    		$request = array();
    		foreach($_POST as $k=>$v){
    			$request[$k] = $v;
    		}
    		
    		$header = C('addElement');
    		$request['productId'] = $_COOKIE['productId'];
    		 
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
    		$request['id'] = $id;
    		$header = C('updateElement');

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
    		$header = C('queryElement');
    		$request = array('id'=>$id);
    		
    		$element = $this->getById($header,$request);
    		//print_r($element);
    		$this->assign ('element', $element);
    		$this->display();
    	}
    }
    
    function delete($id){
    	if($id != ""){
    		$productId = $_COOKIE['productId'];
    		
    		$header = C('deleteElement');
    		$request = array("ids"=>$id,"productId"=>$productId);
    		 
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
    
    function password(){
    	$this->display();
    }
     
    
}