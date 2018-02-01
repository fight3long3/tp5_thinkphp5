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

class Rule extends Base
{
    protected $model;

    function __construct()
    {
        parent::__construct();
        $this->model = new \app\system\model\Rule();
    }

    /**
     * 显示资源列表
     * @return \think\Response
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $list = $this->model->getList();
        $this->assign('title', '规则管理');
        $this->assign('list', $list);
        return $this->fetch();
    }

    /**
     * 显示创建资源表单页
     *
     * @return \think\Response
     */
    public function create()
    {
        $this->assign('title', '添加管理员');
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
        $parent_id = $request->post('parent_id', 0);
        $grade = $request->post('grade');
        $sequence = $request->post('sequence');
        $url = $request->post('url');
        $controller = $request->post('controller');
        $action = $request->post('action');
        $state = $request->post('state');
        if (!$name) {
            return json_return(101);
        }

        $data = [
            'name' => $name,// 菜单名称
            'parent_id' => $parent_id,// 父菜单ID
            'grade' => $grade, // 菜单等级
            'sequence' => $sequence, // 排序
            'url' => $url, // 链接
            'controller' => $controller, // 控制器
            'action' => $action, // 方法
            'create_time' => time(), // 创建时间
            'state' => $state, // 状态
        ];

        $result = $this->model->insert($data);
        if ($result) {
            $last_id = $this->model->getLastInsID();
            if ($last_id) {
                return json_return(0, $last_id);
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
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function read($id)
    {
        $data = $this->model->find($id);
        $menu_model = new \app\system\model\Menu();
        $all_menus = $menu_model->getAllMenus();
        $can_do_menus = json_decode($data->rule, true)['where']['id'][1];
        $this->assign('title', '查看菜单');
        $this->assign('data', $data);
        $this->assign('all_menus', $all_menus);
        $this->assign('can_do_menus', $can_do_menus);
        return $this->fetch();
//        $tables = Db::query('show table status');
//        foreach ($tables as $key => $value) {
//            $table_info = Db::query("describe {$value['Name']}");
//            $tables[$key]['Columns'] = $table_info;
//        }
//        $this->assign('title', '查看菜单');
//        $this->assign('data', $data);
//        $this->assign('tables', $tables);
//        return $this->fetch();
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
        $data = $this->model->find($id);
        $menu_model = new \app\system\model\Menu();
        $all_menus = $menu_model->getAllMenus();
        $can_do_menus = json_decode($data->rule, true)['where']['id'][1];
        $this->assign('title', '编辑菜单');
        $this->assign('data', $data);
        $this->assign('all_menus', $all_menus);
        $this->assign('can_do_menus', $can_do_menus);
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
        $menu_ids = $_POST['menu_ids'];
        $state = $request->post('state');
        if (!$name) {
            return json_return(101);
        }
        $rule = [
            'name' => 'menu',
            'where' => [
                'id' => ['in', $menu_ids]
            ]
        ];
        $data = [
            'id' => $id,// ID
            'name' => $name,// 菜单名称
            'rule' => json_encode($rule),// 菜单名称
            'update_time' => time(), // 创建时间
            'state' => $state, // 状态
        ];
        $result = $this->model->update($data);
        if ($result) {
            return json_return(0);
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
        $result = $this->model->update(['delete_time' => time()], ['id' => $id]);
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