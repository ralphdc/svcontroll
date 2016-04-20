<?php
class MornodeModel extends CommunicationModel{
    
    private  $urls= array(
        //一、	新增监控节点信息
        "add"=>"/monitor/snmp/nodecreate",
        
        //二、获取单个监控节点信息
        "get"=>"/monitor/snmp/nodeget",
        
        //三、	分页查询监控节点信息
        "search"=>"/monitor/snmp/nodesearch",
        
        //四、	修改监控节点
        "edit"=>"/monitor/snmp/nodeupdate",
        
        //五、	删除监控节点
        "delete"=>"/monitor/snmp/nodedelete"
    );
    
    
    function findByPost ($post, $get) {
    
        $Num = $post['pageNum']!='' ? $post['pageNum'] : 1;
        if ($post['numPerPage']!='') {
            setcookie('MornodePerPage',$post['numPerPage']);
            $numPer = $post['numPerPage'];
        }
        else {
            $numPer = $_COOKIE['MornodePerPage']!=0 ?$_COOKIE['MornodePerPage'] : C('PAGE_LISTROWS');
        }
    
        $pdata = $post ? json_encode($post) : "";
        $reqStr = 'json='.$pdata.'&pageNo='.intval($Num).'&pageSize='.intval($numPer);
        $request = array(
            'content'=>$reqStr,
            'length'=>strlen($reqStr),
            'path'=>$this->urls['search']
        );
        $array = $this->request_by_other_v2($request);
        $array = json_decode($array,true);
        $result = $array['data'];
        $this->count = $array['total'];
        return $result;
    }
    
    /**
     * 根据POST过来的数据提取查询条件查询记录条数
     * @param array $post
     * @return int
     */
    function countByPost ($post, $get) {
        if(empty($this->count)){
            $this->count = 0;
        }
        return $this->count;
    }
    //删除一条记录；
    function delete($id)
    {
        $request = array(
            'content'=>"nodeId=".$id,
            'length'=>strlen("nodeId=".$id),
            'path'=>$this->urls['delete']
        );
        $result = $this->request_by_other_v2($request);
        $result = json_decode($result,true);
        return $result;
    }
    //获取一条信息；
    function get($id)
    {
        $request = array(
            'content'=>"nodeId=".$id,
            'length'=>strlen("nodeId=".$id),
            'path'=>$this->urls['get']
        );
        $result = $this->request_by_other_v2($request);
        $result = json_decode($result,true);
        return $result;
    }
    
    //新增操作；
    function add($post)
    {
        $request = array(
            'content'=>"json=".json_encode($post),
            'length'=>strlen(json_encode($post)),
            'path'=>$this->urls['add']
        );
        $result = $this->request_by_other_v2($request);
        $result = json_decode($result,true);
        return $result;
    }
    
    //新增操作；
    function edit($post)
    {
        $request = array(
            'content'=>"json=".json_encode($post),
            'length'=>strlen("json=".json_encode($post)),
            'path'=>$this->urls['edit']
        );
        $result = $this->request_by_other_v2($request);
        $result = json_decode($result,true);
        return $result;
    }
}