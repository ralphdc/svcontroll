<?php
class MonitorServiceModel extends CommunicationModel{
    
    private  $urls= array(
        //十二、	获取服务器基本信息
        "getServerBasicInfo"=>"/monitor/snmp/summary",
        // 十三、	获取TCP链接基本信息
        "getTcpBasicInfo"=>"/monitor/snmp/tcpconninfo",
        //十四、	获取服务进程统计信息
        "getProcessInfo" => "/monitor/snmp/serviceprocessinfo"
    );
    
    
    
    function getServerBasicInfo($ip)
    {
        $request = array(
            'content'=>"ip=".$ip,
            'length'=>strlen(strval("ip=".$ip)),
            'path'=>$this->urls['getServerBasicInfo']
        );
        $result = $this->request_by_other_v2($request);
        $result = json_decode($result,true);
        return $result;
    }
    
    
    function getTcpBasicInfo($ip)
    {
        $request = array(
            'content'=>"ip=".$ip,
            'length'=>strlen(strval("ip=".$ip)),
            'path'=>$this->urls['getTcpBasicInfo']
        );
        $result = $this->request_by_other_v2($request);
        $result = json_decode($result,true);
        return $result;
    }
    
    function getProcessInfo($ip)
    {
        $request = array(
            'content'=>"ip=".$ip,
            'length'=>strlen(strval("ip=".$ip)),
            'path'=>$this->urls['getProcessInfo']
        );
        $result = $this->request_by_other_v2($request);
        $result = json_decode($result,true);
        return $result;
    }
}