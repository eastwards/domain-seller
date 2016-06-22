<?
/**
 * 网站首页
 *
 * 网站首页
 *
 * @package     Action
 * @author      void
 * @since       2014-12-17
 */
class IndexAction extends AppAction
{
    //public $caches  	= array('index');
    public $cacheId 	= 'redisHtml';
    public $expire  	= 36000;//1小时

    public function index()
    {
	$strDomain = C('ALLOW');
	$arrDomain = $tmpArr = explode(',', $strDomain);
	$tmpArr = array_map(function($n){return 'www.'.$n;}, $tmpArr);
	$arr = array_merge($arrDomain, $tmpArr);
	$domain = $_SERVER['HTTP_HOST'];
	if ( !in_array($domain, $arr) ){
	    $deny = explode(',',C('OTHERS'));
	    $this->redirect('', $deny[array_rand($deny)]);
	}else{
	    $num = intval($this->com('redisHtml')->get($domain.date('_Ymd')));
	    $this->com('redisHtml')->set($domain.date('_Ymd'), ++$num);
	}
	$this->set('domain', $_SERVER['HTTP_HOST']);
	$this->display();
    }

    public function clear()
    {
	$cid = $this->input('cid', 'int', -1);
	//redis默认15个数据库，如redis配置文件修改，这里也要修改
	if ( $cid < 0 || !in_array($cid, range(0,14)) ){
	    $this->returnAjax(array('code'=>2,'msg'=>'参数错误'));
	}

	//清除缓存（注意：清除前要关闭缓存配置，否则不会执行到这里）
	$this->com('qcache')->select($cid)->clear();
	$this->returnAjax(array('code'=>1));
    }
	
}
?>
