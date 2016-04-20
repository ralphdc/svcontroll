<?php

//参数管理
class ParamController extends CommonController {
	var $navTab = 'L10003';
	var $pageSize = "17";
	var $pageNumShown = "5";

    function index(){
    	$header = C('queryParams');
    	if(!empty($_POST)){
    		$queryCon = array();
    		foreach($_POST as $k =>$v){
    			if($k == 'paramCode' ||$k == 'paramName' ){
    				$queryCon[$k] = $v; 
    			}else{
    				$reqs[$k]= $v;
    			}
    		}
    		$reqs['queryCon'] = $queryCon;
    	}
    	$reqs['pageNo'] = ($_POST['pageNum'] == "")? 1:$_POST['pageNum'];
    	$reqs['pageSize'] = $this->pageSize;
    	
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$reqs);
    	$params = $data['datalist'];
    	//print_r($data);
    	$this->assign ('params', $params );
    	
    	$this->assign ('totalCount', $data['totalnum']);
    	$this->assign ('currentPage', $reqs['pageNo'] );
    	$this->assign ('numPerPage', $this->pageSize );
    	$this->assign ('pageNumShown', $this->pageNumShown );
    	
    	$this->display();
    }
   
    function add(){
    	if(!empty($_POST)){
    		
    		$header = C('addParam');
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
    		$header = C('updateParam');
    		
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
    		$header = C('queryParam');
    		$request = array('paramId'=>$id);
    		$param = $this->getById($header,$request);
    		//print_r($param);
    		$this->assign ('param', $param);
    		$this->display();
    	}
    }
    
    function delete($id){
    	if($id != "" ){
    		$header = C('deleteParam');
    		$request = array('ids'=>$id);
    		$result = $this->_delete($header, $request);
    		echo $result;return;
    	}
    	$this->display();
    }
    
    function password(){
    	$this->display();
    }
    

     
     
    
}