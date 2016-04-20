<?php
class ProiconModel extends CommunicationModel {
    
    public $method = array(
        'index'         =>'topo.products.list' ,        // 获取产品信息列表
        'get'           =>'topo.products.get' ,          // 获取单个产品信息
        'update'        =>'topo.products.update',
        'servicelist'   =>'topo.services.list '  ,      //获得服务信息列表
        'checkDelete'   =>'topo_producticon_delete',
        'productlist'   =>'topo.products.search'        //一次性获取所有产品列表；
    );
    
    public $server = '/omp/topo';
    
    private $icon = array('firewall.png','other.png','router.png','server.png','transfer.png');
    
    private $iconPath = "./Public/Images/jtopolg";
    /**
     * 根据POST过来的数据提取查询条件查询记录
     * @param array $post
     * @return array
     */
    function findByPost ($post, $get) {

        $Num = $post['pageNum']!='' ? $post['pageNum'] : 1;
        if ($post['numPerPage']!='') {
            $numPer = $post['numPerPage'];
        }
        else {
            $numPer = C('PAGE_LISTROWS') ? C('PAGE_LISTROWS') : 1;
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
        $post['key']=$this->method['get'];
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
        if(!is_dir($this->iconPath)){
            mkdir($this->iconPath,0777,true);
        }
        $imgs = scandir($this->iconPath);
        
        return $imgs;
    }
    
    //获取所有服务列表；
    //20130303
    function queryServiceList($post)
    {
        $post['key']=$this->method['servicelist'];
        $post = $this->formatPost($post);
        $array = $this->request_by_other($post);
        $array = json_decode($array,true);
        return $array;
    }
    
    function checkDelete($post)
    {
        $post['key']=$this->method['checkDelete'];
        $post = $this->formatPost($post);
        $array = $this->request_by_other($post);
        $array = json_decode($array,true);
        return $array;
    }
    /**
     * 一次性获取所有产品列表；
     * 2016-03-19；
     * @return unknown
     */
    function queryProList()
    {
        $post['key']=$this->method['productlist'];
        $post = $this->formatPost($post);
        $array = $this->request_by_other($post);
        $array = json_decode($array,true);
        return $array;
    }
}