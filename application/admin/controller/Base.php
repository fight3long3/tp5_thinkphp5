<?php
/**
 * Created by IntelliJ IDEA.
 * User: fight
 * Date: 2017/4/7
 * Time: 19:02
 */

namespace app\admin\controller;


use app\admin\model\Menu;
use think\Controller;
use think\Request;
use think\Session;

class Base extends Controller
{
    /**
     * 析构函数
     */
    function __construct()
    {
        header("Cache-control: private");  // history.back返回后输入框值丢失问题 参考文章 http://www.tp-shop.cn/article_id_1465.html  http://blog.csdn.net/qinchaoguang123456/article/details/29852881
        parent::__construct();
    }

    /**
     * 初始化操作
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected function _initialize()
    {
        if (Session::has('user_info')) {
            $menu_model = new Menu();
            $menus = $menu_model->getAllMenus();
            $this->assign('menus', $menus);
            $request = Request::instance();
            $this->assign('module', $request->module());
            $this->assign('controller', $request->controller());
            $this->assign('action', $request->action());
        } else {
            throw new \think\exception\HttpException(404, '页面不存在');
//            $this->redirect(url('/admin/user/login'));
        }

    }

    protected function token()
    {
        if (!Session::has('__token__')) {
            // 令牌数据无效
            return false;
        }

        $request = Request::instance();
        // 令牌验证
        if ($request->request('__token__') && Session::get('__token__') === $request->request('__token__')) {
            // 防止重复提交
            Session::delete('__token__'); // 验证完成销毁session
            return true;
        }
        // 开启TOKEN重置
        Session::delete('__token__');
        return false;
    }
}
