<?php
/**
 * Created by PhpStorm.
 * User: fight
 * Date: 2017/12/11
 * Time: 14:15
 */

namespace app\system\controller;


use app\admin\controller\Base;
use think\Db;
use think\Request;

class Role extends Base
{
    protected $model;

    function __construct()
    {
        parent::__construct();
        $this->model = new \app\system\model\Role();
    }

    /**
     * 显示资源列表
     * @return \think\Response
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $list = $this->model->getList();
        $this->assign('title', '角色管理');
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
        $user_model = new \app\system\model\User();
        $users = $user_model->getList();
        $this->assign('title', '添加角色');
        $this->assign('users', $users);
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
        $user_ids = $_POST['user_ids'];
        if (!$name) {
            return json_return(101);
        }
        $data = [
            'name' => $name,
            'create_time' => time()
        ];
        $insert_id = $this->model->insertGetId($data);
        if ($insert_id) {
            $user_model = new \app\system\model\User();
            foreach ($user_ids as $user_id) {
                $data = [
                    'id' => $user_id,
                    'role_id' => $insert_id
                ];
                $user_model->update($data);
            }
            return json_return(0, $insert_id);
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
        $data = $this->model->with('users,rules')->find($id);
        $user_model = new \app\system\model\User();
        $users = $user_model->where(['state' => 0, 'delete_time' => 0])->select();
        $rule_model = new \app\system\model\Rule();
        $rules = $rule_model->where(['state' => 0, 'delete_time' => 0])->select();
        $this->assign('title', '查看角色');
        $this->assign('data', $data);
        $this->assign('users', $users);
        $this->assign('rules', $rules);
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
        $data = $this->model->with('users')->find($id);
        $user_model = new \app\system\model\User();
        $users = $user_model->where(['state' => 0, 'delete_time' => 0])->select();
        $rule_model = new \app\system\model\Rule();
        $rules = $rule_model->where(['state' => 0, 'delete_time' => 0])->select();
        $this->assign('title', '编辑角色');
        $this->assign('data', $data);
        $this->assign('users', $users);
        $this->assign('rules', $rules);
        return $this->fetch();
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request $request
     * @param  int $id
     * @return \think\Response
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function update(Request $request, $id)
    {
        $name = $request->post('name');
        $user_ids = array_key_exists('user_ids', $_POST) ? $_POST['user_ids'] : [];
        $rule_ids = array_key_exists('rule_ids', $_POST) ? $_POST['rule_ids'] : [];
        if (!$name) {
            return json_return(101);
        }
        $data = [
            'id' => $id,
            'name' => $name,
            'update_time' => time(),
        ];
        $result = $this->model->update($data);
        if ($result) {
            $user_model = new \app\system\model\User();
            $user_model->where('role_id', $id)->update(['role_id' => 0]);
            if ($user_ids) {
                $user_model->where('id', 'in', $user_ids)->update(['role_id' => $id]);
            }
            $rule_table = Db::name('role_rule');
            $rule_table->where('role_id', $id)->delete();
            if ($rule_ids) {
                foreach ($rule_ids as $rule_id) {
                    $rule_role_data[] = [
                        'role_id' => $id,
                        'rule_id' => $rule_id
                    ];
                }
                $rule_table->insertAll($rule_role_data);
            }
            return json_return(0, $id);
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
        $video_type_model = new \app\system\model\Role();
        $result = $video_type_model->deleteById($id);
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
        $video_type_model = new \app\system\model\Role();
        $result = $video_type_model->update(['delete_time' => time()], ['id' => ['in', $ids]]);
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
        $video_type_model = new \app\system\model\Role();
        $result = $video_type_model->update(['state' => $state], ['id' => $id]);
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
        $video_type_model = new \app\system\model\Role();
        $result = $video_type_model->update(['state' => $state], ['id' => ['in', $ids]]);
        if ($result) {
            return json_return(0);
        }
        return json_return(101);
    }
}