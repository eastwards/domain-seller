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

    public function index()
    {
	exit('coming soon');
	$this->set('domain', $_SERVER['HTTP_HOST']);
	$this->display();
    }

}
?>
