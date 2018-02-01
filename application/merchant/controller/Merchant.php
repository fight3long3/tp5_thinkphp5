<?php

namespace app\merchant\controller;

use app\admin\controller\Base;
use think\Request;

class Merchant extends Base
{
    protected $model;

    function __construct()
    {
        parent::__construct();
        $this->model = new \app\merchant\model\Merchant();
    }

    /**
     * 显示资源列表
     *
     * @return \think\Response
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $post = input('post.');
        if (input('get.page')){
            $where = session('where_search');
        } else {
            $where = [
                'delete_time' => 0,
            ];
        }
        $search = [];
        //用户id
        if (isset($post['id']) && !empty($post['id'])) {
            $where['id'] = $post['id'];
            $search['id'] = $post['id'];
        }

        //用户账号
        if (isset($post['name']) && !empty($post['name'])) {
            $where['name'] = $post['name'];
            $search['name'] = $post['name'];
        }

        //用户手机
        if (isset($post['user_tel']) && !empty($post['user_tel'])) {
            $where['user_tel'] = $post['user_tel'];
            $search['user_tel'] = $post['user_tel'];
        }

        //用户名称
        if (isset($post['user_name']) && !empty($post['user_name'])) {
            $where['user_name'] = $post['user_name'];
            $search['user_name'] = $post['user_name'];
        }

        //时间搜索
        if (isset($post['start_time']) && !empty($post['start_time'])) {
            if (!isset($post['end_time']) || empty($post['end_time'])) {
                $post['end_time'] = date('Y-m-d H:i:s');
            }
            $where['create_time'] = array('between time', array($post['start_time'], $post['end_time']));
            $search['start_time'] = $post['start_time'];
            $search['end_time'] = $post['end_time'];
        }

        //状态
        if (isset($post['state']) && !empty($post['state'])) {
            $where['state'] = ['=', $post['state'] - 1];
            $search['state'] = $post['state'];
        }

        $list = $this->model->getList($where);
        $this->assign('title', '商户管理');
        $this->assign('list', $list);
        $this->assign('search', $search);
        return $this->fetch();
    }

    /**
     * 显示创建资源表单页
     *
     * @return \think\Response
     */
    public function create()
    {
        $this->assign('title', '添加代理');
        return $this->fetch();
    }

    /**
     * 保存新建的资源
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $name = $request->post('name');
        $password = $request->post('password');
        $user_money = $request->post('user_money');
        $rate = $request->post('rate');
        $user_tel = $request->post('user_tel');
        $user_name = $request->post('user_name');
        $key = $request->post('key');
        $security_remind = $request->post('security_remind');
        $audit_switch = $request->post('audit_switch');
        $white_list = $request->post('white_list');
        $times = $request->post('times');
        $state = $request->post('state', 0);
        if (!$name && !$password && !$user_tel && !$user_name && !$key) {
            return json_return(101);
        }
        $data = [
            'name' => $name, // 用户账号
            'password' => md5(sha1(md5($password))), // 用户密码
            'user_money' => $user_money, // 账户余额
            'rate' => $rate, // 提现费率
            'user_tel' => $user_tel, // 用户手机
            'user_name' => $user_name, // 用户姓名
            'key' => $key, // 用户key
            'security_remind' => $security_remind, // 安全金额提醒
            'audit_switch' => $audit_switch, // 大额审核开关
            'white_list' => $white_list, // 白名单
            'times' => $times, // 每人每天最多提现次数（不包含1元）
            'create_time' => time(), // 创建时间
            'state' => $state, // 是否启用
        ];
        $result = $this->model->insert($data);
        if ($result) {
            $last_id = $this->model->getLastInsID();
            if ($last_id) {
                return json_return(0, $result);
            }
        }
        return json_return(100);
    }

    /**
     * 显示指定的资源
     *
     * @param  int $id
     * @return \think\Response
     * @throws \think\Exception
     */
    public function read($id)
    {
        $data = $this->model->readById($id);
        $this->assign('title', '查看代理');
        $this->assign('data', $data);
        return $this->fetch();
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int $id
     * @return \think\Response
     * @throws \think\Exception
     */
    public function edit($id)
    {
        $data = $this->model->readById($id);
        $this->assign('title', '编辑商户');
        $this->assign('data', $data);
        return $this->fetch();
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request $request
     * @param  int $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        $name = $request->post('name');
        $password = $request->post('password', 0);
        $user_money = $request->post('user_money');
        $rate = $request->post('rate');
        $user_tel = $request->post('user_tel');
        $user_name = $request->post('user_name');
        $key = $request->post('key');
        $security_remind = $request->post('security_remind');
        $audit_switch = $request->post('audit_switch');
        $white_list = $request->post('white_list');
        $times = $request->post('times');
        $state = $request->post('state', 0);
        if (!$name && !$user_tel && !$user_name && !$key) {
            return json_return(101);
        }
        $data = [
            'id' => $id, // 用户id
            'name' => $name, // 用户账号
            'user_money' => $user_money, // 账户余额
            'rate' => $rate, // 提现费率
            'user_tel' => $user_tel, // 用户手机
            'user_name' => $user_name, // 用户姓名
            'key' => $key, // 用户key
            'security_remind' => $security_remind, // 安全金额提醒
            'audit_switch' => $audit_switch, // 大额审核开关
            'white_list' => $white_list, // 白名单
            'times' => $times, // 每人每天最多提现次数（不包含1元）
            'create_time' => time(), // 创建时间
            'state' => $state, // 是否启用
        ];
        if ($password) {
            $data['password'] = md5(sha1(md5($password)));
        }
        $result = $this->model->update($data);
        if ($result) {
            return json_return(0, $result);
        }
        return json_return(100);
    }

    /**
     * 删除指定资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $result = $this->model->deleteById($id);
        if ($result) {
            return json_return(0, $result);
        }
        return json_return(100);
    }

    /**
     * 删除指定资源
     * @return \think\Response
     */
    public function deleteItems()
    {
        $ids = input('post.ids');
        $ids = explode(',', $ids);
        $result = $this->model->update(['delete_time' => time()], ['id' => ['in', $ids]]);
        if ($result) {
            return json_return(0);
        }
        return json_return(101);
    }

    /**
     * 设置状态
     * @return \think\response\Json
     */
    public function setState()
    {
        $state = input('post.state');
        $id = input('post.id');
        $result = $this->model->update(['state' => $state], ['id' => $id]);
        if ($result) {
            return json_return(0);
        }
        return json_return(101);
    }

    /**
     * 设置状态批量
     * @return \think\response\Json
     */
    public function setStates()
    {
        $state = input('post.state');
        $ids = input('post.ids');
        $ids = explode(',', $ids);
        $result = $this->model->update(['state' => $state], ['id' => ['in', $ids]]);
        if ($result) {
            return json_return(0);
        }
        return json_return(101);
    }
}
