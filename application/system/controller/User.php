<?php
/**
 * Created by PhpStorm.
 * User: fight
 * Date: 2017/12/11
 * Time: 14:15
 */

namespace app\system\controller;


use app\admin\controller\Base;
use think\Request;

class User extends Base
{
    protected $model;

    function __construct()
    {
        parent::__construct();
        $this->model = new \app\system\model\User();
    }

    /**
     * 显示资源列表
     * @return \think\Response
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $list = $this->model->getList();
        $this->assign('title', '管理员管理');
        $this->assign('list', $list);
        return $this->fetch();
    }

    /**
     * 显示创建资源表单页
     *
     * @return \think\Response
     * @throws \think\exception\DbException
     */
    public function create()
    {
        $role_model = new \app\system\model\Role();
        $roles = $role_model->getList();
        $this->assign('title', '添加管理员');
        $this->assign('roles', $roles);
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
        $role_id = $request->post('role_id');
        $state = $request->post('state', 0);
        if (!$role_id && !$password && !$role_id) {
            return json_return(101);
        }
        if ($this->token()) {
            return json_return(200);
        }
        $data = [
            'name' => $name, // 用户账号
            'password' => md5(sha1(md5($password))), // 用户密码
            'role_id' => $role_id, // 账户余额
            'create_time' => time(), // 创建时间
            'state' => $state, // 是否启用
        ];
        $result = $this->model->insert($data);
        if ($result) {
            return json_return(0, $result);
        }
        return json_return(100);
    }

    /**
     * 显示指定的资源
     *
     * @param  int $id
     * @return \think\Response
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function read($id)
    {
        $data = $this->model->with('role')->find($id);
        $this->assign('title', '查看管理员');
        $this->assign('data', $data);
        return $this->fetch();
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int $id
     * @return \think\Response
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function edit($id)
    {
        $data = $this->model->with('role')->find($id);
        $role_model = new \app\system\model\Role();
        $roles = $role_model->getList();
        $this->assign('title', '编辑管理员');
        $this->assign('data', $data);
        $this->assign('roles', $roles);
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
        $role_id = $request->post('role_id');
        $state = $request->post('state', 0);
        if (!$name && !$role_id) {
            return json_return(101);
        }
        if ($this->token()) {
            return json_return(200);
        }
        $data = [
            'id' => $id, // 用户id
            'name' => $name, // 用户账号
            'role_id' => $role_id, // 账户余额
            'update_time' => time(), // 更新时间
            'state' => $state, // 是否启用
        ];

        if ($password) {
            $data['password'] = md5(sha1(md5($password))); // 用户密码
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
