<?php
/**
 * Created by IntelliJ IDEA.
 * User: fight
 * Date: 2017/3/31
 * Time: 19:34
 */

namespace app\admin\controller;


class Index Extends Base
{
    public function index()
    {
        // dump(session('user_info'));
        $this->assign('title', '后台首页');
        return view();
    }
}
