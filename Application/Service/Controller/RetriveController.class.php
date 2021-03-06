<?php 

class RetriveController extends CommonController{
    
    //var $navTab = 'D60623';
    var $navTab = '2c948cfb51ebb03c0151ebb84a6c0013';
    
    public function index()
    {
        
        $pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
		$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		
		$Retrive = new RetriveModel($_POST,$_GET);
		$result = $Retrive->findByPost($_POST,$_GET);
		$count = $Retrive->countByPost($_POST,$_GET);
		
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result );
		//dump($result);
		if(count($result) > 0){
		    $idsArr = array();
		    foreach($result as $r){
		        $idsArr[] =$r['serviceInstanceId'];
		    }
		    $idsStr = implode(",",$idsArr);
		    $this->assign('idsStr',$idsStr);
		}
		
		$this->assign ( 'map', array('cfginstanceid'=>'','servicename'=>'','ipv'=>''));
		cookie('_currentUrl_', __SELF__);
		$this->display();
    }
    
    public function retriveAll()
    {
        $ids = I('get.ids','','htmlspecialchars,strval,trim');
        $Retrive = new RetriveModel();
        $goes = $Retrive->RetriveModel_RetriveAll($ids);
        
        if(!empty($goes)){
            if(intval($goes['errorCode']) == 1){
                $ret = array("statusCode"=>"0","message"=>'操作失败，请稍后再试！',"navTabId"=>$this->navTab);
            }else{
                $ret = array("statusCode"=>"1","message"=>'操作成功！',"navTabId"=>$this->navTab);
            }
        }else{
            $ret = array("statusCode"=>"0","message"=>'操作失败！',"navTabId"=>$this->navTab);
        }
        echo json_encode($ret);
        exit;
    }
    
    public function retriveSelect()
    {
        $idsStr = I('post.ids','','strval,htmlspecialchars');
        if($idsStr){
            $Retrive = new RetriveModel();
            $goes = $Retrive->RetriveModel_RetriveSelected($idsStr);
            
            if(!empty($goes)){
                if(intval($goes['errorCode']) == 1){
                    $ret = array("statusCode"=>"0","message"=>'操作失败，请稍后再试！',"navTabId"=>$this->navTab);
                }else{
                    $ret = array("statusCode"=>"1","message"=>'操作成功！',"navTabId"=>$this->navTab);
                }
            }else{
                $ret = array("statusCode"=>"0","message"=>'操作失败！',"navTabId"=>$this->navTab);
            }
            echo json_encode($ret);
            exit;
        }
       
    }
    
}


