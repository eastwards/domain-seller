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
	$this->set('domain', $_SERVER['HTTP_HOST']);
	$this->display();
    }

}
?>
