<?php

class SnmpController extends CommonController{

	 private $navTab;
	 
	 public function __construct()
	 {
	     parent::__construct();
	     $this->navTab = session('menuId');
	 }
	 
	 
	 public function index()
	 {
	     if($_GET['pageNum'])
	     {
	         $_REQUEST['numPerPage'] = empty($_REQUEST['numPerPage']) ?  ($_COOKIE['snmpPerPage']? $_COOKIE['snmpPerPage']:C('PAGE_LISTROWS') ): $_REQUEST['numPerPage'];
	         $_REQUEST[C('VAR_PAGE')] = $_GET['pageNum'];
	         $_POST['pageNum'] = $_GET['pageNum'];
	     }
	     $pageNum =empty($_REQUEST['numPerPage']) ?  ($_COOKIE['snmpPerPage']? $_COOKIE['snmpPerPage']:C('PAGE_LISTROWS') ): $_REQUEST['numPerPage'];
	     $this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
	     $this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
	     $dataModel = new SnmpModel();
	     $result = $dataModel->findByPost($_POST,$_GET);
	     $count = $dataModel->countByPost();
	     $this->assign ( 'totalCount', $count );
	     $this->assign('list',$result);
	     $this->display();
	 }
	 
	 public function add()
	 {
	     if($_POST){
	         $model = new SnmpModel(); 
	         //启用状态：默认开启 2016-04-05；
	         $_POST['enabled'] = 1;
	         $sv = $model->add($_POST);
	         if(isset($sv['errorCode']) && $sv['errorCode'] == 0){
	             $ret = array("statusCode"=>"1","message"=>'提交成功！',"navTabId"=>$this->navTab,
	                 "rel"=>"","forwardUrl"=>"","callbackType"=>"");
	             echo json_encode($ret);	return;
	         }else{
	             $ret = array("statusCode"=>"0","message"=> $sv['errorMessage'],"navTabId"=>$this->navTab,
	                 "rel"=>"","forwardUrl"=>"","callbackType"=>"");
	             echo json_encode($ret);	return;
	         }
	     }
	 }
	 
	 public function edit()
	 {
	     if($_GET['id']){
	         $model = new SnmpModel();
	         $sv = $model->get($_GET['id']);
	         if(isset($sv['errorCode']) && $sv['errorCode'] == 0){
	            $this->assign('data',$sv['data']);
	            $this->display();
	         }else{
	             $ret = array("statusCode"=>"0","message"=> $sv['errorMessage'],"navTabId"=>$this->navTab,
	                 "rel"=>"","forwardUrl"=>"","callbackType"=>"");
	             echo json_encode($ret);	return;
	         }
	     }
	     
	     if($_POST['templateId']){
	         $model = new SnmpModel();
	         //启用状态：默认开启 2016-04-05；
	         $_POST['enabled'] = 1;
	         $sv = $model->update($_POST);
	         if(isset($sv['errorCode']) && $sv['errorCode'] == 0){
	              $ret = array("statusCode"=>"1","message"=>'提交成功！',"navTabId"=>$this->navTab,
	                 "rel"=>"","forwardUrl"=>"","callbackType"=>"");
	             echo json_encode($ret);	return;
	         }else{
	             $ret = array("statusCode"=>"0","message"=> $sv['errorMessage'],"navTabId"=>$this->navTab,
	                 "rel"=>"","forwardUrl"=>"","callbackType"=>"");
	             echo json_encode($ret);	return;
	         }
	     }
	 }
	 
	 function batchdel()
	 {
	    if($_POST['templateIds']){
	        $model = new SnmpModel();
	        $sv = $model->batchdel($_POST['templateIds']);
	        if(isset($sv['errorCode']) && $sv['errorCode'] == 0){
	            $ret = array("statusCode"=>"1","message"=>'删除成功！',"navTabId"=>$this->navTab,
	                "rel"=>"","forwardUrl"=>"","callbackType"=>"");
	        }else if(isset($sv['errorCode']) && $sv['errorCode'] == 1){
	            $ret = array("statusCode"=>"0","message"=> $sv['errorMessage'],"navTabId"=>$this->navTab,
	                "rel"=>"","forwardUrl"=>"","callbackType"=>"");
	        }else if(isset($sv['errorCode']) && $sv['errorCode'] == 2){
	            $ret = array("statusCode"=>"1","message"=> $sv['errorMessage'],"navTabId"=>$this->navTab,
	                "rel"=>"","forwardUrl"=>"","callbackType"=>"");
	        }
	        echo json_encode($ret);	return;
	    }
	 }
	 
	 function delete()
	 {
	     if($_GET['id']){
	         $model = new SnmpModel();
	         $sv = $model->delete($_GET['id']);
	         if(isset($sv['errorCode']) && $sv['errorCode'] == 0){
	             $ret = array("statusCode"=>"1","message"=>'删除成功！',"navTabId"=>$this->navTab,
	                 "rel"=>"","forwardUrl"=>"","callbackType"=>"");
	         }else if(isset($sv['errorCode']) && $sv['errorCode'] == 1){
	             $ret = array("statusCode"=>"0","message"=> $sv['errorMessage'],"navTabId"=>$this->navTab,
	                 "rel"=>"","forwardUrl"=>"","callbackType"=>"");
	         }
	         echo json_encode($ret);	return;
	     }
	 }
	 
}