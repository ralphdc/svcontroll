<?php
use Think\Controller;
use Org\Util\Rbac;

//Vendor('Hprose.SendLogin');

class PublicController extends Controller {//extends CommonController
    
    // 检查用户是否登录
    protected function checkUser() {
        if(!isset($_COOKIE['UserAccount'])) {
            $this->error('没有登录','Public/login/');
        }
    }

    // 顶部页面
    public function top() {
        C('SHOW_RUN_TIME',false);			// 运行时间显示
        C('SHOW_PAGE_TRACE',false);
        $model	=	M("Group");
        $list	=	$model->where('status=1')->getField('id,title');
        $this->assign('nodeGroupList',$list);
        $this->display();
    }

    public function drag(){
        C('SHOW_PAGE_TRACE',false);
        C('SHOW_RUN_TIME',false);			// 运行时间显示
        $this->display();
    }

    // 尾部页面
    public function footer() {
        C('SHOW_RUN_TIME',false);			// 运行时间显示
        C('SHOW_PAGE_TRACE',false);
        $this->display();
    }
    
    // 菜单页面
    public function menu() {
        $this->checkUser();
        if(isset($_SESSION[C('USER_AUTH_KEY')])) {
            //显示菜单项
            $menu  = array();
                //读取数据库模块列表生成菜单项
                $node    =   M("Node");
                $id =   $node->getField("id");
                $where['level']=2;
                $where['status']=1;
                $where['pid']=$id;
                $list   =   $node->where($where)->field('id,name,group_id,title')->order('sort asc')->select();
                $accessList = $_SESSION['_ACCESS_LIST'];
               
                foreach($list as $key=>$module) {
                     if(isset($accessList[strtoupper(APP_NAME)][strtoupper($module['name'])]) || $_SESSION['administrator']) {
                        //设置模块访问权限
                        $module['access'] =   1;

                        $menu[$module['group_id']][$key]  = $module;
                    }
                }
                //缓存菜单访问
                $_SESSION['menu'.$_SESSION[C('USER_AUTH_KEY')]] =   $menu;
                
            if(!empty($_GET['tag'])){
                $this->assign('menuTag',$_GET['tag']);
            }
            //获取导航菜单下的目录结构
            $groups=M("Group")->where(array('group_menu'=>"{$_GET['menu']}",'status'=>"1"))->order("sort desc,id desc")->select();
            $this->assign("groups",$groups);
            $this->assign('menu',$menu);
        }
        C('SHOW_RUN_TIME',false);           // 运行时间显示
        C('SHOW_PAGE_TRACE',false);
        $this->display();
    }

    // 后台首页 查看系统信息
    public function main() {
        $info = array(
            '操作系统'=>PHP_OS,
            '运行环境'=>$_SERVER["SERVER_SOFTWARE"],
            'PHP运行方式'=>php_sapi_name(),
            'ThinkPHP版本'=>THINK_VERSION.' [ <a href="http://thinkphp.cn" target="_blank">查看最新版本</a> ]',
            '上传附件限制'=>ini_get('upload_max_filesize'),
            '执行时间限制'=>ini_get('max_execution_time').'秒',
            '服务器时间'=>date("Y年n月j日 H:i:s"),
            '北京时间'=>gmdate("Y年n月j日 H:i:s",time()+8*3600),
            '服务器域名/IP'=>$_SERVER['SERVER_NAME'].' [ '.gethostbyname($_SERVER['SERVER_NAME']).' ]',
            '剩余空间'=>round((@disk_free_space(".")/(1024*1024)),2).'M',
            'register_globals'=>get_cfg_var("register_globals")=="1" ? "ON" : "OFF",
            'magic_quotes_gpc'=>(1===get_magic_quotes_gpc())?'YES':'NO',
            'magic_quotes_runtime'=>(1===get_magic_quotes_runtime())?'YES':'NO',
            );
        $this->assign('info',$info);
        $this->display();
    }

    // 用户登录页面
    public function login() {
       
        $jsid = cookie('JSID');
        if((strlen(strval($jsid)) < 1) || (intval($_SESSION['LoginState']) != 1)){
            $this->display();
        }else{
            $this->redirect('Index/index');
        }
    }
    
    public function showlogin(){
    	$this->display('login');
    }

    public function index() {
        //如果通过认证跳转到首页
        redirect(__MODULE__);
    }

    // 用户登出
    public function logout() {
        
        if(isset($_SESSION[C('USER_AUTH_KEY')])) {
            unset($_SESSION[C('USER_AUTH_KEY')]);
            unset($_SESSION['LoginState']);
            unset($_SESSION);
            //setcookie ("UserAccount" , '',time()-3600);
            cookie('UserAccount',null);
            cookie('JSID',null);
            session_destroy();
            $this->success('登出成功！',__CONTROLLER__.'/login/');
        }else {
            //$this->error('已经登出！');
            session_destroy();
            $this->success('登出成功！',__CONTROLLER__.'/login/');
        }
       
    }
    //对话框登录验证
    public function checkLogin2() {
    	if(empty($_POST['account'])) {
    		$this->error('帐号错误！');
    	}elseif (empty($_POST['password'])){
    		$this->error('密码必须！');
    	}elseif (empty($_POST['verify'])){
    		$this->error('验证码必须！');
    	}
    	//3.2.1 的 验证码 检验方法
    	$verify = $_POST['verify'] ;
    	if(!$this->check_verify($verify)){
    		$this->error('验证码输入错误！');
    	}
    	$ip = get_client_ip();
    	$passwd = md5(trim($_POST['password']));
    	$header = C('loginIn');
    	$request = array("userNo"=>$_POST['account'],"passwd"=>$passwd,"productId"=>C('PRIVATE_PRODUCTID'),"ip"=>$ip,"userType"=>"B");
    	 
    	$SendMessage= new SendLogin;
    	$result =$SendMessage ->send($header,$request);
    
    	$code = $result['code'];
    	if($code === "0"){
    		$_SESSION[C('USER_AUTH_KEY')]	=	$result['userName'];
    		$_SESSION['login_count']	=	$result['userId'];
    		$_SESSION['xgdSessionId']	=	$result['xgdSessionId'];
    		$_SESSION['cUserNo']	=	$_POST['account'];//$result['xgdSessionId'];
    		//setcookie ("UserAccount" , $_POST['account'],time ()+ 3600*4 );   /* expire in 4 hour */
    		setcookie ("UserAccount" , $_POST['account'],C('maxlifetime'));
    		// 缓存访问权限
    		RBAC::saveAccessList();
    		$this->success('登录成功！',__MODULE__.'/Index/index');
    		//header('Location:'. __MODULE__.'/Index/index');
    	}else{
    		$this->error($result['msg']);
    		 
    	}
    }

    // 登录检测
    public function checkLogin1() {
    	/* header('Location:'. __MODULE__.'/Index/index');
    	return; */
        if(empty($_POST['account'])) {
            $this->error('帐号错误！');
        }elseif (empty($_POST['password'])){
            $this->error('密码必须！');
        }/* elseif (empty($_POST['verify'])){
            $this->error('验证码必须！');
        } */
        //3.2.1 的 验证码 检验方法
        /* $verify = $_POST['verify'] ;
        if(!$this->check_verify($verify)){
        	$this->error('验证码输入错误！');
        } */
        $ip = get_client_ip();
        $passwd = md5(trim($_POST['password']));
        $header = C('loginIn');
        $request = array("userNo"=>$_POST['account'],"passwd"=>$passwd,"productId"=>C('PRIVATE_PRODUCTID'),"ip"=>$ip,"userType"=>"E");
         
        $SendMessage= new SendLogin;
        $result =$SendMessage ->send($header,$request);

        $code = $result['code'];
        if($code === "0"){
        	$_SESSION[C('USER_AUTH_KEY')]	=	$result['userName'];
        	$_SESSION['login_count']	=	$result['userId'];
        	$_SESSION['xgdSessionId']	=	$result['xgdSessionId'];
        	$_SESSION['cUserNo']	=	$_POST['account'];//$result['xgdSessionId'];
        	$_SESSION['WEB_ENVIRONMENT'] = 5;
        	//setcookie ("UserAccount" , $_POST['account'],time ()+ 3600*4 );   /* expire in 4 hour */
        	setcookie ("UserAccount",$_POST['account'],C('maxlifetime'));
        	// 缓存访问权限
        	//RBAC::saveAccessList();
        	//$this->success('登录成功！',__MODULE__.'/Index/index');
        	header('Location:'. __MODULE__.'/Index/index');
        }else{
        	$this->error($result['msg']);
        	
        }
        
        
        
    }
    
    // 临时去掉菜单的权限服务修改为自己设定的固定账号登陆
    public function checkLogin() {
    	/* header('Location:'. __MODULE__.'/Index/index');
    	 return; */
    	if(empty($_POST['account'])) {
    		$this->error('帐号错误！');
    	}elseif (empty($_POST['password'])){
    		$this->error('密码必须！');
    	}
    	$ip = get_client_ip();
    	
    	//登录
    	$flag = false;
    	foreach(C("AccountPassword") as $key=>$AccountPassword){
    		if((trim($_POST['account'])==$AccountPassword['account'])&&(trim($_POST['password'])==$AccountPassword['password'])){
    			$_SESSION[C('USER_AUTH_KEY')]	=	$AccountPassword['USER_AUTH_KEY'];
	    		$_SESSION['login_count']	=	$AccountPassword['account'];
	    		$_SESSION['xgdSessionId']	=	$AccountPassword['account'];
	    		$_SESSION['cUserNo']	=	$AccountPassword['account'];
	    		$_SESSION['WEB_ENVIRONMENT'] = 5;
	    		$_SESSION['SYSTEM_FLAG'] = '1';
	    		setcookie ("UserAccount",$_POST['account'],'');
	    		
    			$flag = true;
    			break;
    		}
    	}
    	if($flag){
    		header('Location:'. __MODULE__.'/Index/index');
    	}else{
    		$this->error("用户名或者密码错误");
    	}
    }
    
      public function validateLogin()
    {
        $usr = I('post.account','');
        $pwd = I('post.password','');
        
        if(empty($usr)) {
            $this->error('帐号错误！');
        }elseif (empty($pwd)){
            $this->error('请输入密码！');
        }
        \Think\Log::write("\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\输入的用户名和密码分别是：".print_r("用户名：".$usr.",密码：".$pwd,true));
       $request = new CommunicationModel();
       $login = $request->do_service(C('loginRequest'),array('name'=>$usr,'password'=>$pwd));
       
       $login_res = strval($login);
       
       if(strlen($login_res) > 0){
           
          $first = substr($login_res,strpos($login_res,'{'));
          $end = strrpos($first,'}');
          $end ++;
          $res_json = substr($first,0,$end);
          
          $login_info = json_decode($res_json,true);
          \Think\Log::write("\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\登录信息返回的JSON：".print_r($res_json,true));
          \Think\Log::write("\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\登录信息解析后的结果是：".print_r($login_info,true));
          if(empty($login_info['error']) && (strlen(strval($login_info['JSESSIONID'])) > 0))
          {
              //登录成功！
              $_SESSION[C('USER_AUTH_KEY')]	   =	$login_info['userName'];
              $_SESSION['xgdSessionId']	       =	$login_info['JSESSIONID'];
              $_SESSION['cUserNo']	               =	$usr;
              $_SESSION['WEB_ENVIRONMENT']        =    5;
              $_SESSION['SYSTEM_FLAG']            =    '1';
              $_SESSION['LoginState']              =   1;
               
              cookie('UserAccount',$usr);
              cookie('JSID',$login_info['JSESSIONID']);
               
              header('Location:'. __MODULE__.'/Index/index');
          }else{
          
              $loginErr = empty($login_info['error']) ? '登录失败，请检查用户名或密码' : $login_info['error'];
              $this->error($loginErr);
          }
       }else{
           $this->error("登录失败，消息传递错误！");
       }
    } 
    
   /*  public function validateLogin()
    {
        $usr = I('post.account','');
        $pwd = I('post.password','');
    
         if($usr != 'admin' || $pwd != '123456'){
             $this->error('帐号或密码错误！');
         }
         
        //登录成功！
        $_SESSION[C('USER_AUTH_KEY')]	   =	'Admin';
        $_SESSION['xgdSessionId']	       =	'djfoiefuh89543uouihf';
        $_SESSION['cUserNo']	           =     'Admin';
        $_SESSION['WEB_ENVIRONMENT']        =    5;
        $_SESSION['SYSTEM_FLAG']            =    '1';
        $_SESSION['LoginState']              =   1;
         
        cookie('UserAccount',$usr);
        cookie('JSID','1138DEA86A4FC79B9AFE0A3C2035E289');
         
        header('Location:'. __MODULE__.'/Index/index');
        
       
    } */

    
    // 更换密码
    public function changePwd() {
        
        //登录验证；
        $jsid = cookie('JSID');
        if((strlen(strval($jsid)) < 1) || (intval($_SESSION['LoginState']) != 1)){
            $this->error('用户未登录，修改密码失败！');
            exit;
        }
        
        //对表单提交处理进行处理或者增加非表单数据
        //3.2.1 的 验证码 检验方法
        $verify = $_POST['verify'] ;
        if(!$this->check_verify($verify)){
            $this->error('验证码输入错误！');
        } 
       
        //检查用户
        $oldPassword = trim($_POST['oldpassword']);
        $password = trim($_POST['password']);
       
        $request = new CommunicationModel();
        $changePwd = $request->do_service(C('loginPWD'),array('oriPassword'=>$oldPassword,'password'=>$password));
         
        if(strlen(strval($changePwd)) > 0){
            
            $first = substr($changePwd,strpos($changePwd,"{"));
            $end = strrpos($first,"}");
            $end ++;
            $parse_pwd = substr($first,0,$end);
            $parse = json_decode($parse_pwd,true);
            \Think\Log::write("\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\修改密码返回的JSON：".print_r($parse_pwd,true));
            \Think\Log::write("\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\修改密码解析后的结果是：".print_r($parse,true));
            
            if(is_array($parse)){
                if(!isset($parse['error'])){
                    $ret = array("statusCode"=>1,'message'=>'修改成功！','callbackType'=>'closeCurrent');
                }else{
                    $ret = array("statusCode"=>0,'message'=>$parse['error'],'callbackType'=>'');
                }
            }else{
                $ret = array("statusCode"=>0,'message'=>'返回信息解析错误！','callbackType'=>'closeCurrent');
                
            }
            
        }else{
            $ret = array("statusCode"=>0,'message'=>'消息传递错误！','callbackType'=>'');
        }
        echo json_encode($ret); exit;
       
    }
    
    // 用户资料
    public function profile() {
        $this->checkUser();
        $User	 =	 M("User");
        $vo	=	$User->getById($_SESSION[C('USER_AUTH_KEY')]);
        $this->assign('vo',$vo);
        $this->display();
    } 
	
    // 检测输入的验证码是否正确，$code为用户输入的验证码字符串	  
	public function check_verify($code, $id = ''){
		$verify = new \Think\Verify();
		return $verify->check($code, $id);
	}	
	
	//生成  验证码 图片的方法
	public function verify() {
        //3.2.1  中的生成 验证码 图片的方法        
        $Verify = new \Think\Verify();
        // 设置验证码字符为纯数字
        $Verify->codeSet = '0123456789'; 
        $Verify->length   = 4;
        $Verify->fontSize = 25;
        $Verify->useNoise = false;
        $Verify->useCurve = false;
        $Verify->entry();                      
    }	
	
    // 修改资料
    public function change() {
        $this->checkUser();
        $User	 =	 D("User");
        if(!$User->create()) {
            $this->error($User->getError());
        }
        $result	=	$User->save();
        if(false !== $result) {
            $this->success('资料修改成功！');
        }else{
            $this->error('资料修改失败!');
        }
    }

    public function nav(){
        $volist=M("GroupClass")->where(array('status'=>1))->order("sort desc, id desc")->select();
        $this->volist=$volist;
        $this->display();
    }
}