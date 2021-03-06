<?
/**
 * 应用公用控制器
 *
 * 存放应用的公共方法
 *
 * @package	Action
 * @author	void
 * @since	2015-01-28
 */
abstract class AppAction extends Action
{
	/**
	 * 每页显示多少行
	 */
	public $rowNum  = 20;
	
	public $username = null;
	
	public $userId   = null;
	
	public $roleId   = null;
	/**
	 * 前置操作(框架自动调用)
	 * @author	void
	 * @since	2015-01-28
	 *
	 * @access	public
	 * @return	void
	 */
	public function before()
	{
	

	}

	/**
	 * 后置操作(框架自动调用)
	 * @author	void
	 * @since	2015-01-28
	 *
	 * @access	public
	 * @return	void
	 */
	public function after()
	{
		//自定义业务逻辑
	}

	/**
	 * 输出json数据
	 *
	 * @author	Xuni
	 * @since	2015-11-06
	 *
	 * @access	public
	 * @return	void
	 */
	protected function returnAjax($data=array())
	{
		$jsonStr = json_encode($data);
		exit($jsonStr);
	}

	private function getUser()
	{
		$userinfo = Session::get(COOKIE_USER);
		if ( empty($userinfo) ){
			$this->username = '';
			$this->userId 	= '';
			$this->isLogin 	= false;
			return false;
		}else{
			$userinfo = unserialize($userinfo);
		}
		$this->username = $userinfo['username'];
		$this->userId 	= $userinfo['userId'];
		$this->isLogin 	= true;
		return true;
	}

	//图片上传
	public function ajaxUploadPic()
    {
    	$kb = $this->input('size', 'int', 0);
        $msg = array(
            'code'  => 0,
            'msg'   => '',
            'img'   => '',
            );
        if ( empty($_FILES) || empty($_FILES['fileName']) ) {
            $msg['msg'] = '请上传图片';
            $this->returnAjax($msg);
        }
        if ( $kb > 0 && ($kb*1024 < $_FILES['fileName']['size']) ){
        	$msg['msg'] = "文件大小超过 $kb KB限制";
        	$this->returnAjax($msg);
        }
        $obj = $this->load('upload')->upload('fileName', 'img');
        if ( $obj->_imgUrl_ ){
            $msg['code']    = 1;
            $msg['img']     = $obj->_imgUrl_;
        }else{
            $msg['msg']     = $obj->msg;
        }
        $this->returnAjax($msg);
    }


	//获取来源页面地址并保存
	protected function getReferrUrl($action)
	{
		//配置项
		$referrArr 	= array(
			'internal_edit' => '/internal/index/',
			'viewuser' => '/visitlog/userlist/',
                        'patent_edit' => '/patent/index/',
			); 
		if ( empty($referrArr[$action]) ) return '/index/main/';

		$_referr 	= Session::get($action);
		if ( empty($_referr) ){
			if ( strpos($_SERVER['HTTP_REFERER'], $referrArr[$action]) !== false ){
				Session::set($action, $_SERVER['HTTP_REFERER']);
			}else{
				Session::set($action, $referrArr[$action]);
			}
		}else{
			if ( strpos($_SERVER['HTTP_REFERER'], $referrArr[$action]) !== false ){
				Session::set($action, $_SERVER['HTTP_REFERER']);
			}
		}
		return Session::get($action);
	}


}
?>
