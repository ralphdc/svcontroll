<?php

class GraphSearchModel extends CommunicationModel {
    

    public $server = "/omp/topo";
    
    private $device = array('server'=>'服务器','router'=>'路由器','transfer'=>'交换机','firewall'=>'防火墙','desktop'=>'桌面机','web'=>'WEB站点','virtual'=>'虚拟主机','balance'=>'负载均衡','other'=>'其他');
    
    
    var $method = array(
        'search' => 'topo.server.list',     //根据IP或者主机名查找服务器信息
        'searchbyid'=>'topo.server.get',	//根据ID获取服务器信息
    );
    
    function postSave($post,$get=null){
        $result = '';
        if($post['form_act']=='create'){
            $post['key'] = $this->method['add'];
            $post = $this->formatPost($post,$get);
            $result =$this->request_by_other( $post);
        }elseif($post['form_act']=='update'){
            $post['key'] = $this->method['update'];
            $post = $this->formatPost($post,$get);
            $result = $this->request_by_other($post);
        }
        return json_decode($result,true);
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
    
    /**
     * 根据POST过来的数据提取查询条件查询记录
     * @param array $post
     * @return array
     */
    function findByPost ($post, $get) {
        if(!empty($post)){
            foreach ($post as $key=>$valus){
                $post[$key]=trim($valus," ");
            }
        }
        $Num = $post['pageNum']!='' ? $post['pageNum'] : 1;
        if ($post['numPerPage']!='') {
            setcookie('jpnumPerPage',$post['numPerPage']);
            $numPer = $post['numPerPage'];
        }
        else {
            $numPer = $_COOKIE['jpnumPerPage']!=0 ?$_COOKIE['jpnumPerPage'] : 20;
        }
        $post['key']=$this->method['search'];
        $post['data']['iphost'] = empty($post['hostip']) ? (empty($post['hostname']) ? '' :  $post['hostname']) : $post['hostip'];
        $post['page']['pageNo']=intval($Num);
        $post['page']['pageSize']=intval($numPer);
        $post = $this->formatPost($post,$get);
        $array = $this->request_by_other($post,$get);
        $array = json_decode($array,true);
        $result = $array['data'];
        $this->count = $array['total'];
        return $result;
    }
   
    public  function search($post)
    {
        $post['key']=$this->method['search'];
        $post['data']['iphost'] = $post['host'];
        if($post['did'] != 'alldevice'){
            $post['data']['deviceid'] = $post['did'];
        }else{
            $post['data']['deviceid'] = "";
        }
        
        $post = $this->formatPost($post,$get);
        $array = $this->request_by_other($post,$get);
        $array = json_decode($array,true);
        $result = $array['data'];
        return $result;
    }
    
    public  function searchVersion($post)
    {
        $post['key']=$this->method['search'];
        $post = $this->formatPost($post,$get);
        $array = $this->request_by_other($post,$get);
        $array = json_decode($array,true);
        $result = $array['data'];
        return $result;
    }
    
    public  function searchPdAndDevice($post)
    {
        $post['key']=$this->method['search'];
        $post = $this->formatPost($post,$get);
        $array = $this->request_by_other($post,$get);
        $array = json_decode($array,true);
        $result = $array['data'];
        return $result;
    }

     public  function searchById($post)
    {
        $post['key']=$this->method['searchbyid'];
        $post = $this->formatPost($post,$get);
        $array = $this->request_by_other($post,$get);
        $array = json_decode($array,true);
        $result = $array['data'];
        return $result;
    }
    
}