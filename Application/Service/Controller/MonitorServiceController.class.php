<?php

class MonitorServiceController extends CommonController{
    
    function pushInfo()
    {
        if($_POST['ips']){
            $infoModel = new MonitorServiceModel();
            $sv = $infoModel->getServerBasicInfo($_POST['ips']);
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
                    $sd_data[] = floor(($da['used'] / $da['total']) * 100);
                }
                $sv['data']['path']     = $sd_path;
                $sv['data']['skdata']   = $sd_data;
                $ret = array("statusCode"=>"1","message"=> "SUCCESS","data"=>$sv['data'],"navTabId"=>$this->navTab,
                    "rel"=>"","forwardUrl"=>"","callbackType"=>"");
            }else{
                $ret = array("statusCode"=>"0","message"=> "没有读取到数据！","data"=>"","navTabId"=>$this->navTab,
                    "rel"=>"","forwardUrl"=>"","callbackType"=>"");
            }
            echo json_encode($ret); return;
        }
    }
    
    function getTCPInfo()
    {
        if($_POST['ips']){
            $infoModel = new MonitorServiceModel();
            $sv = $infoModel->getTcpBasicInfo($_POST['ips']);
            if(isset($sv['errorCode']) && $sv['errorCode'] == 0){
                $ret = array("statusCode"=>"1","message"=> "SUCCESS","data"=>$sv['data'],
                    "rel"=>"","forwardUrl"=>"","callbackType"=>"");
            }else{
                $ret = array("statusCode"=>"0","message"=> $sv['message'],"data"=>"",
                    "rel"=>"","forwardUrl"=>"","callbackType"=>"");
            }
            echo json_encode($ret); return;
        }
    }
    
    function getProcessInfo()
    {
        if($_POST['ips']){
            $infoModel = new MonitorServiceModel();
            $sv = $infoModel->getProcessInfo($_POST['ips']);
            if(isset($sv['errorCode']) && $sv['errorCode'] == 0){
                $ret = array("statusCode"=>"1","message"=> "SUCCESS","data"=>$sv['data'],
                    "rel"=>"","forwardUrl"=>"","callbackType"=>"");
            }else{
                $ret = array("statusCode"=>"0","message"=> $sv['errorMessage'],"data"=>"",
                    "rel"=>"","forwardUrl"=>"","callbackType"=>"");
            }
            echo json_encode($ret); return;
        }
    }
}