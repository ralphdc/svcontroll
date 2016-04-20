<?php
class DeviceInfoModel extends CommunicationModel {
    
    public $method = array(
        'index'     =>'asset.notcal.message.search',
        'add'       =>'asset.notcal.message.create',
        'getrow'    =>'asset.notcal.message.get',
        'update'    =>'asset.notcal.message.update',
        'delete'    =>'asset.notcal.message.delete',
        'deleteall' =>'asset.notcal.message.deletebatch',
        'load'      => 'asset.notcal.message.load',
        'uploadindex'=>' asset.message.result.search',
        'updelete'=>'asset.message.result.delete',
        'updeleteall'=>'asset.message.result.deletebatch'
    );
    
    public $server = '/omp/asset';
    
    
    /**
     * 根据POST过来的数据提取查询条件查询记录
     * @param array $post
     * @return array
     */
    function findByPost ($post, $get) {
        if(!Empty($post)){
            foreach ($post as $key=>$valus){
                $post[$key]=trim($valus," ");
            }
        }
        $Num = $post['pageNum']!='' ? $post['pageNum'] : 1;
        if ($post['numPerPage']!='') {
            $numPer = $post['numPerPage'];
        }
        else {
            $numPer = C('PAGE_LISTROWS') ? C('PAGE_LISTROWS') : 1;
        }
        
        $post['key']=$this->method['index'];
        
        //===================查询数据====================================
        $post['data']['deviceNumber']=trim($post['deviceNumber']);
        $post['data']['assetNumber']=trim($post['assetNumber']);
        $post['data']['businessAddress']=trim($post['businessAddress']);
        $post['data']['cabinetname']=trim($post['cabinetname']);
        
        
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
     * 删除单个的接口
     * @param string $id
     */
    function delete($id)
    {
        $post['key']=$this->method['delete'];
        $post['id'] = $id;
        $post = $this->formatPost($post);
        $array = $this->request_by_other($post);
        $array = json_decode($array,true);
        return $array;
    }
    
    /**
     * 删除单个的接口
     * @param string $id
     */
    function upDelete($id)
    {
        $post['key']=$this->method['updelete'];
        $post['id'] = $id;
        $post = $this->formatPost($post);
        $array = $this->request_by_other($post);
        $array = json_decode($array,true);
        return $array;
    }
    
    /**
     * 删除多个的接口
     * @param string $ids
     */
    function deleteAll($ids)
    {
        $post['key']=$this->method['deleteall'];
        $post['ids'] = $ids;
        $post = $this->formatPost($post);
        $array = $this->request_by_other($post);
        $array = json_decode($array,true);
        return $array;
    }
    /**
     * 删除多个的接口
     * @param string $ids
     */
    function upDeleteAll($ids)
    {
        $post['key']=$this->method['updeleteall'];
        $post['ids'] = $ids;
        $post = $this->formatPost($post);
        $array = $this->request_by_other($post);
        $array = json_decode($array,true);
        return $array;
    }
    
    function sendUrl($url,$filename)
    {
        $post['key']=$this->method['load'];
        $post['data']['excelurl'] = $url;
        $post['data']['filename'] = $filename;
        $post['data']['excelman'] = session('authId') ? session('authId') : session('cUserNo') ? session('cUserNo') : 'admin';
        $post = $this->formatPost($post);
        $array = $this->request_by_other($post);
        $array = json_decode($array,true);
        return $array;
    }
   
    function uploadSearch($post, $get)
    {
        if(!Empty($post)){
            foreach ($post as $key=>$valus){
                $post[$key]=trim($valus," ");
            }
        }
        $Num = $post['pageNum']!='' ? $post['pageNum'] : 1;
        if ($post['numPerPage']!='') {
            $numPer = $post['numPerPage'];
        }
        else {
            $numPer = C('PAGE_LISTROWS') ? C('PAGE_LISTROWS') : 1;
        }
        
        $post['key']=$this->method['uploadindex'];
        
        //===================查询数据====================================
        
        $post['data']['starttime']= $post['startTime'] ? strval($post['startTime']).' 00:00:00' : '';
        $post['data']['endtime']=$post['endTime'] ? strval($post['endTime']).' 23:59:59' : '';
        $post['data']['excelurl']=strval($post['excelurl']);
        if($post['startTime'])  unset($post['startTime']);
        if($post['endTime'])    unset($post['endTime']);
        if($post['excelurl'])    unset($post['excelurl']);
        
        
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
    
}