<?php

//菜单管理
class MenuController extends CommonController {
	var $navTab = 'L10003';
	var $pageSize = "16";
	var $pageNumShown = "2";

    function index(){
    	$header = C('queryProducts');
    	$reqs = array("pageNo"=>1,"pageSize"=>20);
    	
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$reqs);
    	$products = $data['datalist'];
    	//print_r($data);
    	$this->assign ('products', $products );
    	
    	$productid = ($_COOKIE['productId'] == "")?$products[0]['id']:$_COOKIE['productId'];
    	$header = C('queryMenus');
    	$reqs = array("productId"=>$productid);
    	
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$reqs);
    	$menu = $data['menuList'];
    	$this->assign ('menu', $menu);

    	$this->display();
    }
   

    function detail(){
    	$data = array();
    	if($_POST['id'] != ""){
	    	$header = C('queryMenu');
	    	$request = array("id"=>$_POST['id']);
	    	 
	    	$data = $this->getById($header,$request);
	    	$menu = $data['menuList'];
    	}
    	echo json_encode($data);
    }
    
    //增，删，改
    function operate(){
    	if(!empty($_POST)){
    		$request = array();
    		foreach($_POST as $k =>$v){
    			$request[$k] = $v;
    		}
    		if($_POST['type'] == "1"){
    			$header = C('deleteMenu');
    			//删除传的是ids，修改传的id
    			$request["ids"] = $_POST['id'];
    		}elseif($_POST['type'] == "2"){
    			$header = C('addMenu');
    		}else{
    			$header = C('updateMenu');
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
    

    function getMenus(){
    	$header = C('queryMenus');
    	$reqs = array("productId"=>$_POST['productid']);
    	 
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$reqs);
    	$menu = $data['menuList'];
    	echo json_encode($menu);
    }
    
    /*
    function delete(){
    	if($_POST['id'] != ""){
    		$header = C('deleteMenu');
    		$request = array("ids"=>$_POST['id'],'productId'=>$_POST['productId']);
    		 
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
    
     function add(){
    	if(!empty($_POST)){
    		$header = C('addMenu');
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
    	//$this->display();
    }
    */
     
    
}