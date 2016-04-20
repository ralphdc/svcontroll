<?php
class IceGroupServiceController extends CommonController {
    
   
    
    //20151116 弹出Group选择窗口；
	public function groupSelect()
	{
	    
	    $pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
	    $this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
	    $this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
	    
	    
	    $model = CM("IceGroupService");
	    $gpName = I('post.servicename','');
	    if($gpName){
	        $result = $model->sendJavaData('ice_group_info',$_REQUEST);
	       
	    }else{
	        $result = $model->sendJavaData('icegroupTree','');
	    }
	  
	    if($result['errorCode'] == 0){
	        $weightList = $result['data'];
	    }
	    $this->assign("list",$weightList);
	    $this->display();
	}
}