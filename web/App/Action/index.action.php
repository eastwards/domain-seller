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
    public $caches  	= array('index');
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
	}
	$this->set('domain', $_SERVER['HTTP_HOST']);
	$this->display();
    }

}
?>
