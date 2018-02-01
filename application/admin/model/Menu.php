<?php
/**
 * Created by IntelliJ IDEA.
 * User: fight
 * Date: 2017/4/7
 * Time: 16:36
 */

namespace app\admin\model;

use think\Db;
use think\Model;
use think\Request;

class Menu extends Model
{
    protected $resultSetType = 'collection';
    protected $where = [];
    /**
     * @data 字段对应信息
     */
    protected $fields = [
        'id' => 'id',//id
        'name' => 'name', // 名称
        'parent_id' => 'parent_id', // parent_id
        'grade' => 'grade', // 等级
        'sequence' => 'sequence', // 排序
        'url' => 'url', // 菜单路由
        'module' => 'module', // 菜单路由
        'controller' => 'controller', // 菜单路由
        'action' => 'action', // 菜单路由
        'create_time' => 'create_time', // 创建时间
        'update_time' => 'update_time', // 最近修改时间
        'state' => 'state', // 是否启用
        'delete_time' => 'delete_time', // 删除时间
    ];

    /**
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function getTopMenus()
    {
        $filed = [
            $this->fields['id'] => 'id',
            $this->fields['name'] => 'name',
            $this->fields['module'] => 'module',
            $this->fields['controller'] => 'controller',
            $this->fields['action'] => 'action',
        ];
        $where = $this->where;
        $where['parent_id'] = 0;
        $where['state'] = 0;
        $where['delete_time'] = 0;
        $order = [
            'sequence'
        ];
        $menus = $this->field($filed)
            ->where($where)
            ->order($order)
            ->select()
            ->toArray();
        return $menus;
    }

    /**
     * @param $parent_id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function getMenusByParentId($parent_id)
    {
        $filed = [
            $this->fields['id'] => 'id',
            $this->fields['name'] => 'name',
            $this->fields['module'] => 'module',
            $this->fields['controller'] => 'controller',
            $this->fields['action'] => 'action',
        ];
        $where = $this->where;
        $where['parent_id'] = $parent_id;
        $where['state'] = 0;
        $where['delete_time'] = 0;
        $order = [
            $this->fields['sequence'] => 'sequence'
        ];
        $menus = $this->field($filed)
            ->where($where)
            ->order($order)
            ->select()
            ->toArray();
        return $menus;
    }

    /**
     * @param $parent_id
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function getCanDoMenus()
    {
        $filed = [
            $this->fields['id'] => 'id',
            $this->fields['name'] => 'name',
            $this->fields['module'] => 'module',
            $this->fields['controller'] => 'controller',
            $this->fields['action'] => 'action',
        ];
        $where = $this->where;
        $where['delete_time'] = 0;
        $order = [
            $this->fields['sequence'] => 'sequence'
        ];

        $request = Request::instance();
        $can_do = false;
        $menus = $this->field($filed)
            ->where($where)
            ->order($order)
            ->select()
            ->toArray();
        foreach ($menus as $menu) {
            if ($menu['module'] . $menu['controller'] . $menu['action'] == $request->module() . $request->controller() . $request->action()) {
                $can_do = true;
            }
        }
        if ($can_do) {
            return true;
        } else {
            throw new \think\exception\HttpException(404, '页面不存在');
        }

    }

    /**
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function getAllMenus()
    {
        $role_model = new \app\system\model\Role();
        $roles = $role_model->with('rules')->find(session('user_info.role_id'));
        foreach ($roles->rules as $rule) {
            if ($rule->rule) {
                $rule = json_decode($rule->rule, true);
                if ($rule[''] == 'menu') {
                    $this->where = $rule['where'];
                } elseif ($rule['table']) {
                }
            }
        }

        $this->getCanDoMenus();
        $menus = $this->getTopMenus();
        foreach ($menus as $key => $menu) {
            $child_menus = $this->getMenusByParentId($menu['id']);
            $menus[$key]['child_menus'] = $child_menus;
        }
        return $menus;
    }
}