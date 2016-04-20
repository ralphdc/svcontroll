<?php

//产品管理
class ProductController extends CommonController {
	var $navTab = 'L10103';
	var $pageSize = "17";
	var $pageNumShown = "5";

    function index(){
    	$header = C('queryProducts');
    	$request = array();
    	if(!empty($_POST)){
    		foreach($_POST as $k =>$v){
    			if($k == "productName"){
    				$queryCon = array("productName" =>$v);
    			}else{
    				$request[$k] = $v;
    			}
    	
    		}
    		$request['queryCon'] = $queryCon;
    	}
    	
    	$request['pageNo'] = ($_POST['pageNum'] == "")? 1:$_POST['pageNum'];
    	$request['pageSize'] = $this->pageSize;
    	
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$request);
    	$products = $data['datalist'];
    	//print_r($data);
    	$this->assign ('products', $products );
    	
    	$this->assign ('totalCount', $data['totalnum']);
    	$this->assign ('currentPage', $request["pageNo"] );
    	$this->assign ('numPerPage', $this->pageSize );
    	$this->assign ('pageNumShown', $this->pageNumShown );
    	$this->display();
    }
   
    function add(){
    	if($_POST){
    		$productName = $_POST["productName"];
    		$productCode = $_POST["productCode"];
    		$productStatus = $_POST["productStatus"];
    		$productDesc  = $_POST["productDesc"];
    		$remark  = $_POST["remark"];
    		
    		$header = C('addProduct');
    		$request = array("productName"=>$productName,"productCode"=>$productCode,"productStatus"=>$productStatus,"productDesc"=>$productDesc,"remark"=>$remark);
    		 
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
    		$header = C('updateProduct');
    		
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
    		$product = $this->_getProductListById($id);
    		//print_r($product);
    		$this->assign ('product', $product);
    		$this->display();
    	}
    	
    }
    
    function delete($id){
    	if($id != "" ){
    		$header = C('deleteProduct');
    		$request = array('ids'=>$id);
    		 
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
    	$this->display();
    }
    
    
    protected  function _getProductListById($id){
    	$header = C('queryProduct');
    	$request = array('productId'=>$id);
    
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$request);
    	if($data['code'] == 0){
    		$product = $data['productinfo'];
    	}else{
    		$product = array();
    	}
    	return $product;
    }
    
    function search(){
    	$header = C('queryProducts');
    	//$request = array('productName'=>$_POST['productName']);
    	$request = array();
    	if(!empty($_POST)){
    		foreach($_POST as $k =>$v){
    			if($k == "productName"){
    				$queryCon = array("productName" =>$v);
    			}else{
    				$request[$k] = $v;
    			}
    			 
    		}
    		$request['queryCon'] = $queryCon;
    	}
    	
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$request);
    	if($data['code'] == 0){
    		$product = $data['datalist'];
    	}else{
    		$product = array();
    	}
    	echo json_encode($product) ;
    	
    }
     
    
}