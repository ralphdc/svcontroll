<?php
use Think\Controller;
use Org\Util\Rbac;

class ProiconController extends Controller{
	
	public $navTab = '2c9183e1532c1050015372f8af300009';

	public function index() {
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
		$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		$proInfo = new ProiconModel($_POST,$_GET);
		$result = $proInfo->findByPost($_POST,$_GET);
		$count = $proInfo->countByPost($_POST,$_GET);
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result );
		$this->assign ( 'map', array('hostname'=>'','ipv'=>'','environment'=>'','isVirtual'=>''));
		$this->assign('environment',C('CONST_ENVIRONMENT'));
		cookie('_currentUrl_', __SELF__);
		
		$this->display();
	}

	public function add()
	{
		if($_POST){
			$_POST['data']['operator'] = $_SESSION['cUserNo'];
			if(!$_POST['imgName']){
			    $ret = array("statusCode"=>"0","message"=> '请选择设备图标！',"navTabId"=>$this->navTab,
			        "rel"=>"","forwardUrl"=>"","callbackType"=>"");
			    echo json_encode($ret);	return;
			}
			
			$deviceInfo = new ProiconModel($_POST,$_GET);
			$_POST['data']['iconurl'] = $_POST['imgName'];
			$rt = $deviceInfo->add($_POST);
			 if(isset($rt['errorCode']) && $rt['errorCode'] == 0){
                $ret = array("statusCode"=>"1","message"=>'提交成功！',"navTabId"=>$this->navTab,
    					"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
    			echo json_encode($ret);	return;
            }else{
                $ret = array("statusCode"=>"0","message"=> $rt['errorMessage'],"navTabId"=>$this->navTab,
                    "rel"=>"","forwardUrl"=>"","callbackType"=>"");
                echo json_encode($ret);	return;
            }
		}
		$this->display();
	}
	public function delete()
	{
		if($_GET['id']){
			$deviceInfo = new ProiconModel($_POST,$_GET);
			$rt = $deviceInfo->delete($_GET);
			 if(isset($rt['errorCode']) && $rt['errorCode'] == 0){
                $ret = array("statusCode"=>"1","message"=>'提交成功！',"navTabId"=>$this->navTab,
    					"rel"=>"","forwardUrl"=>"","callbackType"=>"");
    			echo json_encode($ret);	return;
            }else{
                $ret = array("statusCode"=>"0","message"=> $rt['errorMessage'],"navTabId"=>$this->navTab,
                    "rel"=>"","forwardUrl"=>"","callbackType"=>"");
                echo json_encode($ret);	return;
            }
		}
	}

	public function edit()
	{
		if($_GET['id']){
			$deviceInfo = new ProiconModel($_POST,$_GET);
			$rt = $deviceInfo->findById($_GET);

			 if(isset($rt['errorCode']) && $rt['errorCode'] == 0){
               $this->assign('product',$rt['data']);
               $this->display();
            }else{
                $ret = array("statusCode"=>"0","message"=> $rt['errorMessage'],"navTabId"=>$this->navTab,
                    "rel"=>"","forwardUrl"=>"","callbackType"=>"");
                echo json_encode($ret);	return;
            }
		}

		if($_POST){
			$proMod = new ProiconModel($_POST,$_GET);
			$_POST['data']['operator'] = $_SESSION['cUserNo'];
			if(!$_POST['imgName']){
			    $ret = array("statusCode"=>"0","message"=> '请选择设备图标！',"navTabId"=>$this->navTab,
			        "rel"=>"","forwardUrl"=>"","callbackType"=>"");
			    echo json_encode($ret);	return;
			}
			$_POST['data']['pdIcon'] = $_POST['imgName'];
			$update = $proMod->update($_POST);
			 if(isset($update['errorCode']) && $update['errorCode'] == 0){
                $ret = array("statusCode"=>"1","message"=>'提交成功！',"navTabId"=>$this->navTab,
    					"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
    			echo json_encode($ret);	return;
            }else{
                $ret = array("statusCode"=>"0","message"=> $update['errorMessage'] ? $update['errorMessage']: '提交失败！',"navTabId"=>$this->navTab,
                    "rel"=>"","forwardUrl"=>"","callbackType"=>"");
                echo json_encode($ret);	return;
            }
		}
	}

	public function deletebatch()
	{
		if($_POST['ids']){
			$deviceInfo = new ProiconModel($_POST,$_GET);
			$del = $deviceInfo->deletebatch($_POST);
			 if(isset($del['errorCode']) && $del['errorCode'] == 0){
                $ret = array("statusCode"=>"1","message"=>'提交成功！',"navTabId"=>$this->navTab,
    					"rel"=>"","forwardUrl"=>"","callbackType"=>"");
    			echo json_encode($ret);	return;
            }else{
                $ret = array("statusCode"=>"0","message"=> $del['errorMessage'] ? $del['errorMessage']: '提交失败！',"navTabId"=>$this->navTab,
                    "rel"=>"","forwardUrl"=>"","callbackType"=>"");
                echo json_encode($ret);	return;
            }
		}
	}

	function icon()
    {
    	if(I('post.act','','htmlspecialchars,trim') == 'upload'){
    	    $config = array(
    	        'maxSize'    =>    3145728,
    	        'rootPath'   =>    './Public/',
    	        'savePath'   =>    './Images/jtopolg/',
    	        'saveName'   =>    array('uniqid',''),
    	        'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
    	        'autoSub'    =>    false,
    	        'subName'    =>    array('date','Ymd'),
    	    );
    	    
    	    $upload = new \Think\Upload($config);// 实例化上传类 
	        // 上传文件
	        $info   =   $upload->upload();
	        $info = $info['Filedata'];
	        if(!$info) {// 上传错误提示错误信息
	            $ret = array("statusCode"=>"0","message"=>$upload->getError(),"navTabId"=>'',//$this->navTab
	            "rel"=>"","forwardUrl"=>"");
	        echo json_encode($ret);	return;
	        }else{// 上传成功 获取上传文件信息
	            Think\Log::write("\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\上传的文件是：".print_r($info,true)."\r\n上传时间是：".date("Y-m-d H:i:s"));
	            //裁剪图片,目标尺寸是：60*57；
	            $image = new \Think\Image();
	            if($image->open('./Public/Images/jtopolg/'.$info['savename'])){
	                $image->crop(60, 57)->save('./Public/Images/jtopolg/'.$info['savename']);
	            }
	            
	             $ret = array("statusCode"=>"1","message"=>"上传成功！","navTabId"=>'',//$this->navTab
	            "rel"=>"","forwardUrl"=>"",'image'=>$info['savename']);
	             Think\Log::write("\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ret：".print_r($ret,true)."\r\n上传时间是：".date("Y-m-d H:i:s"));
	        	echo json_encode($ret);	return;
	        }
	    }

        $model = new ProiconModel();
        $sResult = $model->getIcon();
        $tmp =array();
        foreach ($sResult as $s){
            $imgArr = explode(".",$s);
            if($imgArr[0] != 'default' && $imgArr[0] != 'node2' && $imgArr[0] != 'childtp' ){
                if(in_array($imgArr[1],array('jpg','jpeg','png'))){
                    $tmp[] = $s;
                }
            }
        }
        $this->assign('list',$tmp);
        $this->display();
    }
    
    
   function delicon()
   {
       $icon = trim($_GET['icon']);
       if($icon){
           $icon = str_replace("|",".",$icon);
           $model = new ProiconModel();
           $check = $model->checkDelete(array('iconUrl'=>$icon));
           if(isset($check['errorCode'])){
               if($check['errorCode'] === 0){
                   $dir = "./Public/Images/jtopolg/";
                   $files = scandir($dir);
                   foreach ($files as $f){
                       if($f == $icon){
                           $rt = unlink($dir.$f);
                       }
                   }
                   if($rt){
                       $ret = array("statusCode"=>"1","message"=>'删除成功！',"navTabId"=>"",
                           "rel"=>"","forwardUrl"=>"","callbackType"=>"");
                   }else{
                       $ret = array("statusCode"=>"0","message"=> '删除失败！',"navTabId"=>"",
                           "rel"=>"","forwardUrl"=>"","callbackType"=>"");
                   }
               }else{
                   $ret = array("statusCode"=>"0","message"=> '图片已经和产品绑定，请先解除关系！',"navTabId"=>"",
                       "rel"=>"","forwardUrl"=>"","callbackType"=>"");
               }
           }else{
               $ret = array("statusCode"=>"0","message"=> '接口返回数据错误！',"navTabId"=>"",
                   "rel"=>"","forwardUrl"=>"","callbackType"=>"");
           }
           echo json_encode($ret);	return;
       }
   }
}