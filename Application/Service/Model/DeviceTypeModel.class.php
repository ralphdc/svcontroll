<?php
class DeviceTypeModel extends CommunicationModel {
    
    public $method = array(
        'index'         =>'topo.devicetype.search',         //分页获取设备类型信息
        'typelist'      =>'topo.devicetype.list',           //获取设备类型列表
        'add'           =>'topo.devicetype.create',         //添加设备类型信息
        'update'        =>'topo.devicetype.update',         //更新设备类型信息
        'delete'        =>'topo.devicetype.delete',         //删除设备类型信息
        'deletebatch'   =>'topo.devicetype.deletebatch',    //批量删除设备类型信息
        'load'          =>'topo.devicetype.get',            //获取单个设备类型信息
        'checkDelete'   =>'topo_deviceicon_delete'
    );
    
    public $server = '/omp/topo';
    
    private $icon = array('firewall.png','other.png','router.png','server.png','transfer.png');
    
    private $iconPath = "./Public/Images/jtopo";
    /**
     * 根据POST过来的数据提取查询条件查询记录
     * @param array $post
     * @return array
     */
    function findByPost ($post, $get) {

        $Num = $post['pageNum']!='' ? $post['pageNum'] : 1;
        if ($post['numPerPage']!='') {
            setcookie('deviceTypePerPage',$post['numPerPage']);
            $numPer = $post['numPerPage'];
        }
        else {
            $numPer = $_COOKIE['deviceTypePerPage']!=0 ?$_COOKIE['deviceTypePerPage'] : C('PAGE_LISTROWS');
        }
        
        
        $post['key']=$this->method['index'];
        
        
        //===================分页信息====================================
        $post['page']['pageNo']=intval($Num);
        $post['page']['pageSize']=intval($numPer);
        //===================构造数据，发送请求=============================
        $post = $this->formatPost($post,$get);
        $array = $this->request_by_other($post,$get);
        $array = json_decode($array,true);
        $result = $array['data'];
        $this->count = $array['total'];
        return $result;
    }
    /*
     * 新增；
     */
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
     * 根据ID获取一行记录
     * @param int $id
     */
    function getRowInfo($id)
    {
        $post['id'] = $id;
        $post['key']=$this->method['getrow'];
        $post = $this->formatPost($post);
        $array = $this->request_by_other($post);
        $array = json_decode($array,true);
        return $array['data'];
    }

    /**
     * [add description]
     * @param [type] $post [description]
     */
    function add($post)
    {
        $post['key']=$this->method['add'];
        $post = $this->formatPost($post);
        $array = $this->request_by_other($post);
        $array = json_decode($array,true);
        return $array;
    }
    
    function delete($post)
    {
        $post['key']=$this->method['delete'];
        $post = $this->formatPost($post);
        $array = $this->request_by_other($post);
        $array = json_decode($array,true);
        return $array;
    }

    
    function findById($post)
    {
        $post['key']=$this->method['load'];
        $post = $this->formatPost($post);
        $array = $this->request_by_other($post);
        $array = json_decode($array,true);
        return $array;
    }

    function update($post)
    {
        $post['key']=$this->method['update'];
        $post = $this->formatPost($post);
        $array = $this->request_by_other($post);
        $array = json_decode($array,true);
        return $array;
    }

     function deletebatch($post)
    {
        $post['key']=$this->method['deletebatch'];
        $post = $this->formatPost($post);
        $array = $this->request_by_other($post);
        $array = json_decode($array,true);
        return $array;
    }

    function query()
    {
         $post['key']=$this->method['typelist'];
        $post = $this->formatPost($post);
        $array = $this->request_by_other($post);
        $array = json_decode($array,true);
        return $array;
    }

    function getIcon()
    {
        $imgs = scandir($this->iconPath);
        return $imgs;
    }
    
    function checkDelete($post)
    {
        $post['key']=$this->method['checkDelete'];
        $post = $this->formatPost($post);
        $array = $this->request_by_other($post);
        $array = json_decode($array,true);
        return $array;
    }
}