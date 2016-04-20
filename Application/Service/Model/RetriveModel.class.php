<?php
/**
 * 服务管制-仓库中心-仓库模型
 * @author zengguangqiu
 *
 */
class RetriveModel extends CommunicationModel {
    
    public function __construct()
    {
       // parent::__construct();
        $this->env = trim($_SESSION['WEB_ENVIRONMENT']);
    }
    
    
	public $method = array(
	        'index'        =>'config.serviceinstanceparam.search',
	        'retriveall'   =>'config.recoverallconfig.create',
	        'retriveselected'=>'config.recoverconfig.create'
	);

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
		if(!Empty($post)){
			foreach ($post as $key=>$valus){
				$post[$key]=trim($valus," ");
			}
		}
		$this->Num = $post['pageNum']!='' ? $post['pageNum'] : 1;
		if ($post['numPerPage']!='') {
			setcookie('numPerPage',$post['numPerPage']);
			$this->numPer = $post['numPerPage'];
		}
		else {
			$this->numPer = $_COOKIE['numPerPage']!=0 ?$_COOKIE['numPerPage'] : 20;
		}
		$limit1 = (intval($Num)-1)*intval($numPer);
		$limit = array(intval($numPer),$limit1);
		
		$post['key']=$this->method['index'];
		
		$post = $this->constructData($post,$get);
		$array = $this->request_by_other($post);
		
		$array = json_decode($array,true);
		
		if(intval($array['errorCode']) == 0){
		    $result = $array['data'];
		    $this->count = $array['total'];
		}else{
		    $result = array();
		}
		return $result;
	}
	
	private function constructData()
	{
	    date_default_timezone_set('Asia/Shanghai');
	    $data['key']=$this->method['index'];
	    $data['page']=array('pageNo'=>$this->Num,'pageSize'=>$this->numPer);
	    $data['data']=array(
	        "desployEnv"=>$this->env,
	        "submitor"=>"admin",
	        "ipv"=>I("post.ipv"),
	        "serviceName"=>I("post.servicename")
	    );
	    
	    return $data;
	}
	
	public function RetriveModel_RetriveAll($ids)
	{
	    $data['key']=$this->method['retriveall'];
	    $data['data']['desployEnv'] = $this->env;
	    $data['data']['submitor'] = 'admin';
	    $command = $this->request_by_other($data);
	    $parse = json_decode($command,true);
	    return $parse;
	}
	
	public function RetriveModel_RetriveSelected($idsStr)
	{
	    $data['key']=$this->method['retriveselected'];
	    $data['data']['desployEnv'] = $this->env;
	    $data['data']['submitor'] = 'admin';
	    $data['data']['ids'] = $idsStr;
	    $command = $this->request_by_other($data);
	    $parse = json_decode($command,true);
	    return $parse;
	}
	
}