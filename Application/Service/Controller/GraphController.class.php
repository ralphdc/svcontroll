<?php

date_default_timezone_set("PRC");
use Think\Cache\Driver\Redis;
class GraphController extends CommonController{
    
    var $navTab = '2c9183e1532c1050015372f741e60005';
    var $pageSize = "5";
    var $pageNumShown = "5";
    
    
    public function __construct()
    {
        parent::__construct();
        $this->__init();
        
    }
    
    public function __init()
    {
         $this->redis = new \Redis;
        
         if(!$this->redis->connect(C('REDIS_HOST'),C('REDIS_PORT'))){
             $ret = array("statusCode"=>"0","message"=>'Redis服务无法连接！',"navTabId"=>$this->navTab,
    					"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
    			echo json_encode($ret); exit;
        }
        //redis初始化；
        $this->sid = session_id();
        $this->topo_hash = "topo:hash:tp:".$this->sid;
        //预览拓扑图，递归点击子拓扑记录轨迹；20160301
        $this->monitor_list = "topo:list:tp:monitor:".$this->sid;
        //保存当前操作类型；
        $this->action_name = "topo:action:".$this->sid;
        //保存当前编辑拓扑图ID;
        $this->edit_id = "topo:edit:id:".$this->sid;
    }
    
    
    public function index()
    {
         if($_GET['pageNum'])
        {
            $_REQUEST['numPerPage'] = empty($_REQUEST['numPerPage']) ?  ($_COOKIE['toponumPerPage']? $_COOKIE['toponumPerPage']:C('PAGE_LISTROWS') ): $_REQUEST['numPerPage'];
            $_REQUEST[C('VAR_PAGE')] = $_GET['pageNum'];
            $_POST['pageNum'] = $_GET['pageNum'];
        }
        $pageNum =empty($_REQUEST['numPerPage']) ?  ($_COOKIE['toponumPerPage']? $_COOKIE['toponumPerPage']:C('PAGE_LISTROWS') ): $_REQUEST['numPerPage'];
        $this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
        $this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
        $dataModel = new GraphModel();
        $result = $dataModel->findByPost($_POST,$_GET);
        $count = $dataModel->countByPost($_POST,$_GET);
        $this->assign ( 'totalCount', $count );
        $this->assign('list',$result);
        $this->assign('ctl',CONTROLLER_NAME);
        $this->display();
    }
    
    public function getDeviceList()
    {
        //获取设备列表和对应图标；
        $dtypeMode = new DeviceTypeModel();
        $dtypeList = $dtypeMode->query();
        if(count($dtypeList['data'])){
            $dtype= array();
            foreach ($dtypeList['data'] as $type){
                //在服务端加入判断，判断设备图标是否存在或被删除； 2016-03-16
                $dtype[$type['deviceid']] = file_exists('Public/Images/jtopo/'.$type['iconurl']) ? $type['iconurl'] : 'default.png';
            }
            //2016-02-25; 增加子拓扑图图标；
            $dtype['childtp'] = 'childtp.png';
            $dtype['default'] = 'default.png';
        }
        return $dtype;
    }
    
    public function getDeviceNameList()
    {
        //获取设备列表和对应图标；
        $dtypeMode = new DeviceTypeModel();
        $dtypeList = $dtypeMode->query();
        if(count($dtypeList['data'])){
            $dName= array();
            foreach ($dtypeList['data'] as $type){
                $dName[$type['deviceid']] = $type['deviceName'];
            }
        }
        return $dName;
    }
    
    public function add()
    {
        
        $this->redis->del($this->topo_hash);
        
       // $dtype = $this->getDeviceList();
       // $this->assign('dtype',json_encode($dtype));
       $this->redis->set($this->action_name,'add');
       $this->display();
    }

    public function graphSave()
    {
        
        if($_POST){
            $_POST['data']['creator'] = $_SESSION['cUserNo'];
            
            $nodeInfo = $this->redis->hgetall($this->topo_hash);
            if(empty($nodeInfo)){
                $ret = array("statusCode"=>"0","message"=>'您的拓扑图节点没有设置信息！',"navTabId"=>"",
                    "rel"=>"","forwardUrl"=>"","callbackType"=>"");
                echo json_encode($ret);	return;
            }
            
            //数据转换；
            foreach ($nodeInfo as $ink=>$inv){
                $nodeInfo[$ink] = json_decode($inv);
            }
            
            $_POST['data']['data'] = $nodeInfo;
            $jtopoModel = new GraphModel();
            
            if($_POST['data']['topoId']){
                $sa = $jtopoModel->edit($_POST);
            }else{
                $sa = $jtopoModel->save($_POST);
            }
            
            
            if(isset($sa['errorCode']) && $sa['errorCode'] == 0){
                $ret = array("statusCode"=>"1","message"=>'提交成功！',"navTabId"=>$this->navTab,
    					"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
    			echo json_encode($ret);	return;
            }else{
                $ret = array("statusCode"=>"0","message"=> $sa['errorMessage'],"navTabId"=>$this->navTab,
                    "rel"=>"","forwardUrl"=>"","callbackType"=>"");
                echo json_encode($ret);	return;
            }
        }
        
        if($_GET['tpname']) $this->assign('tpname',$_GET['tpname']);
        $this->display();
    }
    
    public function edit()
    {
        if($_GET['id']){
            
            $this->redis->del($this->topo_hash);
            
            $dataModel = new GraphModel();
            $info = $dataModel->findbyid($_GET);
            if(isset($info['errorCode']) && $info['errorCode'] == 0){
               $content = $info['data']['graph'];
                                
               $nodeinfo = json_decode($info['data']['data']);
               
               $nodeinfos = object2array($nodeinfo);
               
               foreach ($nodeinfos as $nk=>$nf){
                   $nodeinfos[$nk] = json_encode($nf);
               }
              $this->redis->hmset($this->topo_hash,$nodeinfos);
              
              $this->assign('topo',$content);
              
              $this->assign('tpname',$info['data']['topoName']);
              $this->assign('tpid',$info['data']['topoId']);
              
              //图标集合；
              //$dtype = $this->getDeviceList();
              //$this->assign('dtype',json_encode($dtype));
              $this->assign('dtype','');
              $this->redis->set($this->action_name,'edit');
              $this->redis->set($this->edit_id,strval($_GET['id']));
              $this->display();
              
            }else{
                $ret = array("statusCode"=>"0","message"=>'读取数据有误，请稍后再试！',"navTabId"=>$this->navTab,
                    "rel"=>"","forwardUrl"=>"","callbackType"=>"");
                echo json_encode($ret);	return;
            }
        }
    }
    
    public function preview()
    {
        if($_GET['id']){
    
            $this->redis->del($this->topo_hash);
    
            $dataModel = new GraphModel();
            $info = $dataModel->findbyid($_GET);
            if(isset($info['errorCode']) && $info['errorCode'] == 0){
                $content = $info['data']['graph'];
    
                $nodeinfo = json_decode($info['data']['data']);
                 
                $nodeinfos = object2array($nodeinfo);
                 
                foreach ($nodeinfos as $nk=>$nf){
                    $nodeinfos[$nk] = json_encode($nf);
                }
                $this->redis->hmset($this->topo_hash,$nodeinfos);
    
    
                $this->assign('topo',$content);
                $this->assign('tpid',$_GET['id']);
    
                $this->display();
    
            }else{
                $ret = array("statusCode"=>"0","message"=>'读取数据有误，请稍后再试！',"navTabId"=>$this->navTab,
                    "rel"=>"","forwardUrl"=>"","callbackType"=>"");
                echo json_encode($ret);	return;
            }
    
        }
         
    }
    
    //在线监控；
    public function monitor()
    {
        if($_GET['id']){
            $this->redis->del($this->topo_hash);
            $dataModel = new GraphModel();
            $info = $dataModel->findbyid($_GET);
            if(isset($info['errorCode']) && $info['errorCode'] == 0){
                $content = $info['data']['graph'];
                $nodeinfo = json_decode($info['data']['data']);
                $nodeinfos = object2array($nodeinfo);
                foreach ($nodeinfos as $nk=>$nf){
                    $nodeinfos[$nk] = json_encode($nf);
                }
                $this->redis->hmset($this->topo_hash,$nodeinfos);
                $this->assign('topo',$content);
                $this->assign('tpid',$_GET['id']);
    
                //图标集合；
               // $dtype = $this->getDeviceList();
                $this->assign('dtype','');
                
                /*
                //图标集合；
                $dtypes = $this->getDeviceNameList();
                //2016-02-25 添加子拓扑名称；
                $dtypes['childtp'] = "子拓扑图";
                $this->assign('dName',json_encode($dtypes));
                */
                //以下记录拓扑图访问轨迹，例如：从父拓扑图点击进入子拓扑图，再点击...
                //右进左出；
                //2016-03-01
                if(I('get.start',0,'intval') == 1){
                    //清空队列，保存点击轨迹；
                    $this->redis->del($this->monitor_list);
                   
                    $this->redis->rpush($this->monitor_list,json_encode(array($_GET['id'],$info['data']['topoName'],1)));
                }else{
                    //在原有队列基础上整理数据；
                    if(intval($this->redis->llen($this->monitor_list)) > 0){
                        $monitorList = $this->redis->lrange($this->monitor_list,0,-1);
                        $tmpid = array();
                        $tmp = "";
                        foreach ($monitorList as $m){
                            $tmp = json_decode($m,true);
                            $tmpid[] = $tmp[0];
                        }
                        
                        if(in_array($_GET['id'],$tmpid)){
                            $c_key = array_search($_GET['id'],$tmpid);
                            $this->redis->ltrim($this->monitor_list,0,$c_key);
                        }else{
                            $this->redis->rpush($this->monitor_list,json_encode(array($_GET['id'],$info['data']['topoName'])));
                        }
                        unset($tmp);
                        unset($tmpid);
                    }
                }
                
                $btrace =  $this->redis->lrange($this->monitor_list,0,-1);
                foreach ($btrace as $bk=>$bv){
                    $btrace[$bk] = json_decode($bv,true);
                }
               
                $this->assign('trace',$btrace);
                $this->display();
            }else{
                $ret = array("statusCode"=>"0","message"=>'读取数据有误，请稍后再试！',"navTabId"=>$this->navTab,
                    "rel"=>"","forwardUrl"=>"","callbackType"=>"");
                echo json_encode($ret); return;
            }
        }
    }     
    
    public function graphDel()
    {
        if($_GET['id']){
            $dataModel = new GraphModel();
            $del = $dataModel->delete($_GET);
            if(isset($del['errorCode']) && $del['errorCode'] == 0){
                $ret = array("statusCode"=>"1","message"=>'删除成功！',"navTabId"=>$this->navTab,
                    "rel"=>"","forwardUrl"=>"","callbackType"=>"");
                echo json_encode($ret);	return;
            }else{
                $ret = array("statusCode"=>"0","message"=> $del['errorMessage'],"navTabId"=>$this->navTab,
                    "rel"=>"","forwardUrl"=>"","callbackType"=>"");
                echo json_encode($ret);	return;
            }
        }
    }
    
    /**
     * 状态码：
     * 0： 失败；
     * 1： 成功；
     * 2：既有成功，又有失败；
     */
    public function graphBatchDel()
    {
        if($_POST['ids']){
            $dataModel = new GraphModel();
            $del = $dataModel->batchdelete($_POST);
            if(isset($del['errorCode']) && $del['errorCode'] == 0){
                $ret = array("statusCode"=>"1","message"=>'删除成功！',"navTabId"=>$this->navTab,
                    "rel"=>"","forwardUrl"=>"","callbackType"=>"");
            }elseif(isset($del['errorCode']) && $del['errorCode'] == 2){
                $ret = array("statusCode"=>"2","message"=> $del['errorMessage'],"navTabId"=>$this->navTab,
                    "rel"=>"","forwardUrl"=>"","callbackType"=>"");
            }else{
                 $ret = array("statusCode"=>"0","message"=> $del['errorMessage'],"navTabId"=>$this->navTab,
                    "rel"=>"","forwardUrl"=>"","callbackType"=>"");
            }
            echo json_encode($ret);	return;
        }else{
            $ret = array("statusCode"=>"0","message"=> '提交数据有误！',"navTabId"=>$this->navTab,
                "rel"=>"","forwardUrl"=>"","callbackType"=>"");
            echo json_encode($ret);	return;
        }
    }
    
    //编辑子节点；
    public function editNode()
    {
        
        $dType = new DeviceTypeModel();
        $device = $dType->query();
        $this->assign('device',$device['data']);

        //一次性获取所有产品；
        $proListModel = new ProiconModel();
        $proList = $proListModel->queryProList();
        if(isset($proList['errorCode']) && $proList['errorCode'] ===0){
            $this->assign('prolist',$proList['data']);
        }
        //搜索全部节点；
        $dataModel = new GraphSearchModel();
        $result = $dataModel->findByPost($_POST,$_GET);
        $this->assign('nodes',$result);
        $this->display();
    }
    
    //编辑子拓扑；
    public function editChildTP()
    {
         
        if($_GET['pageNum'])
        {
            $_REQUEST['numPerPage'] = empty($_REQUEST['numPerPage']) ?  ($_COOKIE['topochildnumPerPage']? $_COOKIE['topochildnumPerPage']:C('PAGE_LISTROWS') ): $_REQUEST['numPerPage'];
            $_REQUEST[C('VAR_PAGE')] = $_GET['pageNum'];
            $_POST['pageNum'] = $_GET['pageNum'];
        }
        
        $pageNum =empty($_REQUEST['numPerPage']) ?  ($_COOKIE['topochildnumPerPage']? $_COOKIE['topochildnumPerPage']:C('PAGE_LISTROWS') ): $_REQUEST['numPerPage'];
        $this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
        $this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
        
        
        $dataModel = new GraphModel();
        $result = $dataModel->findByPostForEditChildTp($_POST,$_GET);
        $count = $dataModel->countByPost($_POST,$_GET);
        $this->assign ( 'totalCount', $count );
        $this->assign('list',$result);
       
        
        $this->display('editChildTP');
        
    }
    
    /**
     * 保存编辑后的节点信息；
     */
    public function specailNode()
    {
       if($_POST){
           //同一张拓扑图，允许相同节点存在；20160118，赵总；
           $sid = I('post.service_nodeId');        //主机ID;
           $sname = I('post.service_nodeName');    //主机名hostName
           
            //判断数据完整性；
           if(empty($sid) || empty($sname)){
               $ret = array("statusCode"=>"0","message"=> '请选择设备！',"navTabId"=>"",
                   "rel"=>"","forwardUrl"=>"","callbackType"=>"");
               echo json_encode($ret);	return;
           }
           
             //根据节点ID查询详细信息；
            $nodeInfoModel = new GraphSearchModel();
            $nodeInfo = $nodeInfoModel->searchById(array('id'=>$sid));
            $devType = $nodeInfo['deviceType']; //这里假设节点对应的设备类型是不可信的；
            $deviceid = $nodeInfo['deviceid'];

           //验证设备类型信息；
           
            $nodeid = I('post.service_nodeId');            //节点ID;
            $create = array(
                'nodeType'       =>I('post.nodeType'),           //节点类型；
                'nodeGroup'      =>I('post.nodeGroup'),          //节点分组；
                'deviceType'     =>$devType,                    //设备类型；
                'nodeid'         =>I('post.service_nodeId'),     //主机ID;
                'nodename'       =>I('post.service_nodeName'),    //主机名hostName
                'nodeip'         =>I('post.service_nodeIp')        //主机IP
            );
            $node_json = json_encode($create);
            $this->redis->hset($this->topo_hash,$nodeid,$node_json);
            
            if($deviceid){
                $deviceTypeMode = new DeviceTypeModel();
                $device = $deviceTypeMode->findById(array('id'=>$deviceid));
                $dinfo = $device['data'];
                $icon = $dinfo['iconurl'];
            }
            
            $ret = array(
                "statusCode"=>"1",
                "message"=> '提交成功！',
                "navTabId"=>"",
                "rel"=>"",
                "forwardUrl"=>"",
                "callbackType"=>"closeCurrent",
                'icons'=>I('post.deviceType'),
                'nodeText'=>I('post.service_nodeName'),
                'nodeId'=>I('post.service_nodeId'),
                'icon'=>$icon,
                'deviceid'=>$deviceid
                );
            echo json_encode($ret);	return;
          
       }
    }
    
    /**
     * 子拓扑图-编辑后提交； 2016-02-25
     */
    public function saveChildTP()
    {
        $tpid = I('get.id',0,'intval');
        if($tpid){
            $action = $this->redis->get($this->action_name);
            if(empty($action)){
                $ret = array(
                    "statusCode"=>"0",
                    "message"=> '操作状态保存错误！',
                    "navTabId"=>$this->navTab,
                );
                echo json_encode($ret);	return;
            }
            
            if($action == 'edit'){
                $targetId = $this->redis->get($this->edit_id);
                if(empty($targetId)){
                    $ret = array(
                        "statusCode"=>"0",
                        "message"=> '要编辑的拓扑图ID保存错误！',
                        "navTabId"=>$this->navTab,
                    );
                    echo json_encode($ret);	return;
                }
                
                if($tpid == $targetId){
                    $ret = array(
                        "statusCode"=>"0",
                        "message"=> "不能选择自身作为拓扑节点！",
                        "navTabId"=>$this->navTab,
                    );
                    echo json_encode($ret);	return;
                }
            }
            
            $md = new GraphModel();
            $rts = $md->findbyid(array('id'=>$tpid));
            if(isset($rts['errorCode']) && $rts['errorCode'] === 0){
                $nodeid = 'ctp_'.$rts['data']['topoId'];
                $create = array(
                    'id'=>$rts['data']['topoId'],
                    'tname'=>$rts['data']['topoName']
                );
                $node_json = json_encode($create);
                $this->redis->hset($this->topo_hash,$nodeid,$node_json);
                
                $ret = array(
                    "statusCode"=>"1",
                    "message"=>'设置成功！',
                    "tpid"=>$rts['data']['topoId'],
                    "tpname"=>$rts['data']['topoName']
                );
            }else{
                $ret = array(
                    "statusCode"=>"0",
                    "message"=> $sa['errorMessage'] ? $sa['errorMessage'] : '接口返回数据数据为空！',
                    "navTabId"=>$this->navTab,
                );
            }
        }else{
            $ret = array(
                "statusCode"=>"0",
                "message"=> '错误！提交数据有误！'
            );
        }
         
            echo json_encode($ret);	return;
    }
    /**
     * 查询设备ID对应的节点信息；
     */
    public function queryDeviceNode()
    {
        if($_POST){
            $post['data']['deviceid'] = $_POST['deviceid'];
        }
        $dataModel = new GraphModel();
        $allNode = $dataModel->findByPost();
        $this->assign('nodes',$allNode);
    }
    
    public function getNodeInfo()
    {
        $node_id = I('post.nodeid');
        $dtype = I('post.dtype','','strval');
        if($node_id && strpos($node_id,"_")){
            $arr = explode("_",$node_id);
            if($dtype == 'childtp'){
                $model = new GraphModel();
                $sResult = $model->monitor_summary(array('topoIds'=>$arr[0]));
               
               if(!empty($nodeInfo)){
                   echo $nodeInfo; return;
               }else{
                   echo "Error!"; return;
               }
               
               
            }else{
                $node_want_key =$arr[0];
                $nodeInfoModel = new GraphSearchModel();
                $nodeInfo = $nodeInfoModel->searchById(array('id'=>$node_want_key));
                if(count($nodeInfo) > 1){
                    $ret = array(
                        "statusCode"=>1,
                        "message"=>'查询成功！',
                    );
                }else{
                    $ret = array(
                        "statusCode"=>0,
                        "message"=>'查询失败！',
                    );
                }
                echo json_encode(array_merge($ret,$nodeInfo));
                exit;
            }
        }
    }
    
    Public function clearRedis()
    {
        if($keys = $this->redis->keys("*topo*")){
            foreach($keys as $k){
                $this->redis->del($k);
            }
        }
    }

    public function detail()
    {
        $hid = trim($_GET['id']);    //节点ID;
        $tpid =trim($_GET['tpid']);  //拓扑图ID;

        if(empty($hid)){
            $ret =  array('statusCode' =>0,'message'=>'暂时不能查看，请稍后再试！',callbackType=>'' ,'navTabId'=>'' );
            echo json_encode($ret); exit;
        }

        $model = new GraphSearchModel();
        $searchResult = $model->searchById($_GET);


        $this->assign('tpid',$tpid);
        $this->assign('nodeinfo',$searchResult);
        $this->assign('environment',C('CONST_ENVIRONMENT'));
        
        //获取告警信息；
        $nodeInfo = $this->redis->hget($this->topo_hash,$hid);
        $nodeInfoArr = json_decode($nodeInfo,true);

        $requests['ip']=$nodeInfoArr['nodeip'];
        $newmodel = new GraphModel();
        $warnResult = $newmodel->monitor_node_summary($requests);
        $this->assign('warn',$warnResult['data']);
        
        $infoModel = new MonitorServiceModel();
        $sv = $infoModel->getServerBasicInfo('172.17.3.86');
        if(isset($sv['errorCode']) && $sv['errorCode'] == 0){
            //计算CPU使用率；
             $cup1 = $sv['data']['cpuUsages'][0];
             $cup2 = $sv['data']['cpuUsages'][1];
             $cupavg = intval(($cup1 + $cup2)/2);
             $sv['data']['cpu'] = $cupavg;
             $sv['data']['cpu1'] = $cup1;
             $sv['data']['cpu2'] = $cup2;
             
             //计算内存使用率；
             $mem1 = $sv['data']['usedMemory'];
             $mem2 = $sv['data']['totalMemory'];
             $memuse = intval(($mem1 / $mem2) * 100);
             $sv['data']['mem'] = $memuse;
             
             
             //计算磁盘容量；
             $storage1 = $sv['data']['usedStorage'];
             $storage2 = $sv['data']['totalStorage'];
             $memuse = intval(($storage1 / $storage2) * 100);
             $sv['data']['disk'] = $memuse;
             
             //计算磁盘分区；
             $sd_path = array();
             $sd_data = array();
             $ds_per = array();
             foreach ($sv['data']['storageDetail'] as $da){
                 $sd_path[] = $da['partition'];
                 $sd_data[] = ceil($da['used'] / $da['total']);
                 $sd_per[] = 100;
             }
              $this->assign('path',implode(",",$sd_path));
              $this->assign('skdata',implode(",",$sd_data));
              $this->assign('skper',implode(",",$sd_per));
              
              
              $this->assign('server',$sv['data']);
        }
        
        //服务进程；
        $infoModel = new MonitorServiceModel();
        $ps = $infoModel->getProcessInfo('172.17.3.86');
        if(isset($ps['errorCode']) && $ps['errorCode'] == 0){
            $this->assign('process',$ps['data']['servProInfoMap']);
        }
        //tcp链接；
        $tcp = $infoModel->getTcpBasicInfo('172.17.3.86');
        if(isset($tcp['errorCode']) && $tcp['errorCode'] == 0){
            $this->assign('tcp',$tcp['data']);
        }
        //CPU历史数据；
        $cpu = $infoModel->getCPUHistory('172.17.3.86',60*10);
        if(isset($cpu['errorCode']) && $cpu['errorCode'] == 0){
            if(count($cpu['data']) > 0){
                foreach ($cpu['data'] as $ck=>$cv){
                    $xdata[] = date("i:s",ceil($cv['time']/1000));
                    $ydata[] = $cv['avgUsage'];
                }
                $this->assign('xdata',implode(",",$xdata));
                $this->assign('ydata',implode(",",$ydata));
            }
        }
        
        $this->display('detail');
    }

    public function monitorNodeInfo()
    {
        if($_POST['ids']){
            $postArr = explode(",",$_POST['ids']);
            $post = array();
            $compare = array();
            foreach ($postArr as $ps){
                //需要过滤无效节点；
                if(strpos($ps,"_")){
                    $tmp = explode("_",$ps);
                    $post[] = $tmp[0];
                    $compare[$tmp[0]] = $ps;
                }
            }
            $postStr = implode(",",$post);
        }
        
        if($_POST['topoIds']){
            $postArr = explode(",",$_POST['topoIds']);
            $post = array();
            //$compare = array();
            foreach ($postArr as $ps){
                //需要过滤无效节点；
                if(strpos($ps,"_")){
                    $tmp = explode("_",$ps);
                    $post[] = $tmp[0];
                    $compare[$tmp[0]] = $ps;
                }
            }
            $postTpStr = implode(",",$post);
        }
        $model = new GraphModel();
        $sResult = $model->monitor_summary(array('ids'=>$postStr ? $postStr : "",'topoIds'=>$postTpStr ? $postTpStr : ""));
        
        /*  if(count($sResult['data']['serverInfo']) > 0){
            foreach ($sResult['data']['serverInfo'] as $sk=>$sv){
                $sResult['data']['serverInfo'][$sk]['id'] = $compare[$sResult['data']['serverInfo'][$sk]['id']];
            }
         } 
         if(count($sResult['data']['topoInfo']) > 0){
             foreach ($sResult['data']['topoInfo'] as $sk=>$sv){
                 $sResult['data']['topoInfo'][$sk]['topoId'] = $compare[$sResult['data']['topoInfo'][$sk]['topoId']];
             }
         } */
        if(isset($sResult['errorCode']) && $sResult['errorCode'] == 0){
            $ret = array("statusCode"=>"1","message"=>'获取成功！',"navTabId"=>$this->navTab,
                "rel"=>"","forwardUrl"=>"","callbackType"=>"","resinfo"=>$sResult['data']);
            echo json_encode($ret); return;
        }else{
            $ret = array("statusCode"=>"0","message"=> $sResult['errorMessage'],"navTabId"=>$this->navTab,
                "rel"=>"","forwardUrl"=>"","callbackType"=>"");
            echo json_encode($ret); return;
        }
        
        
        /* if($_POST){
            $postArr = explode(",",$_POST['ids']);
            $post = array();
            $compare = array();
            foreach ($postArr as $ps){
                //需要过滤无效节点；
                if(strpos($ps,"_")){
                    $tmp = explode("_",$ps);
                    $post[] = $tmp[0];
                    $compare[$tmp[0]] = $ps;
                }
            }
            
            $postStr = implode(",",$post);
            
            
            $model = new GraphModel();
            $sResult = $model->monitor_summary(array('ids'=>$postStr));
          
            if($sResult['data']){
                foreach ($sResult['data'] as $sk=>$sv){
                    $sResult['data'][$sk]['id'] = $compare[$sResult['data'][$sk]['id']];
                }
            }
             if(isset($sResult['errorCode']) && $sResult['errorCode'] == 0){
                $ret = array("statusCode"=>"1","message"=>'获取成功！',"navTabId"=>$this->navTab,
                    "rel"=>"","forwardUrl"=>"","callbackType"=>"","resinfo"=>$sResult['data']);
                echo json_encode($ret); return;
            }else{
                $ret = array("statusCode"=>"0","message"=> $sResult['errorMessage'],"navTabId"=>$this->navTab,
                    "rel"=>"","forwardUrl"=>"","callbackType"=>"");
                echo json_encode($ret); return;
            }
        } */
    }

    function Service()
    {
       if($_GET){
            $_GET['ip'] = str_replace("-", ".", $_GET['ip']);
            $model = new GraphModel();
            $sResult = $model->monitor_node_detail($_GET);
            $this->assign('sinfo',$sResult['data']);
            $this->display('service');
       }
    }

    /**
     * 清空画布；
     */
    
    function clear()
    {
        $this->redis->del($this->topo_hash);
    }
}