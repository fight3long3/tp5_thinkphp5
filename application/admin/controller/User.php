<?php
/**
 * Created by IntelliJ IDEA.
 * User: fight
 * Date: 2017/3/31
 * Time: 22:18
 */

namespace app\admin\controller;

use think\Controller;
use XSVerification\XSVerification;

class User Extends Controller
{
    public function login()
    {
        if (session('user_info')) {
            $this->redirect('/admin/');
        }
        if (!session('login_path')) {
            throw new \think\exception\HttpException(404, '页面不存在');
        }
        $XSVerification = new  XSVerification();  // 加载类 XSVerification.class.php
        $data = $XSVerification->getOkPng();
        $temp = array_chunk($data['data'], 20);
        $this->assign('left_pic', $temp[0]);
        $this->assign('right_pic', $temp[1]);
        $this->assign('pg_bg', $data['bg_pic']);
        $this->assign('ico_pic', $data['ico_pic']);
        $this->assign('y_point', $data['y_point']);
        session("XSVer_VAL_SUM", 1);
        return view();
    }

    public function logout()
    {
        session('user_info', null);
        $this->redirect(url('/admin/User/login'));
    }

    //校验
    public function XSValidation()
    {
        $point = input('post.point');
        if (empty($point)) {
            return json_return(204);
        }
        static $v_num = 1;
        $ret = XSVerification::checkData($point, session('XSVer'));
        $v_num += session("XSVer_VAL_SUM");
        if ($v_num > 6) {
            session("XSVer_SUM", null);
            return json_return(204);
        } else {
            session("XSVer_VAL_SUM", $v_num);
        }
        if ($ret['state'] == 0) {
            session("XSVer_VAL_SUM", 0x111);
            return json_return(0, session('XSVer'));
        } else {
            session("XSVer_VAL_SUM", null);
            return json_return(204);
        }
    }

    /**
     * 接收登录数据
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getData()
    {
        if (session("XSVer_VAL_SUM") !== 0x111) {
            return json_return(203);
        }
        $username = input('post.username');
        $password = input('post.password');
        if (!empty($username) || !empty($password)) {
            $user = new \app\admin\model\User;
            $result = $user->check($username, $password);
            if ($result) {
                session('user_info', $result);
                return json_return(0, '登录成功');
            }
            return json_return(202);
        }
        return json_return(101);


    }

}