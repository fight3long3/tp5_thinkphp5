<?php

namespace app\system\model;

use think\Model;

class Menu extends Model
{
    protected $resultSetType = 'collection';

    /**ID
     * @data 字段对应信息
     */
    protected $fields = [
        'id' => 'id',// ID
        'name' => 'name',// 菜单名称
        'parent_id' => 'parent_id',// 父菜单ID
        'grade' => 'grade', // 菜单等级
        'sequence' => 'sequence', // 排序
        'url' => 'url', // 链接
        'controller' => 'controller', // 控制器
        'action' => 'action', // 方法
        'create_time' => 'create_time', // 创建时间
        'update_time' => 'update_time', // 最近修改时间
        'state' => 'state', // 是否启用
        'delete_time' => 'delete_time', // 删除时间
    ];

    /**
     * 获取列表
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    function getList()
    {
        $field = [
            'id' => 'id',// ID
            'name' => 'name',// 菜单名称
            'parent_id' => 'parent_id',// 父菜单ID
            'grade' => 'grade', // 菜单等级
            'sequence' => 'sequence', // 排序
            'url' => 'url', // 链接
            'controller' => 'controller', // 控制器
            'action' => 'action', // 方法
            'create_time' => 'create_time', // 创建时间
            'state' => 'state', // 状态
        ];
        $where = [
            'delete_time' => 0
        ];
        $list = $this
            ->field($field)
            ->where($where)
            ->paginate(15);
        return $list;
    }

    /**
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function getTopMenus()
    {
        $filed = [
            'id',
            'name',
        ];
        $where['parent_id'] = 0;
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
        $filed = ['id','name'];
        $where['parent_id'] = $parent_id;
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
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function getAllMenus()
    {
        $menus = $this->getTopMenus();
        foreach ($menus as $key => $menu) {
            $child_menus = $this->getMenusByParentId($menu['id']);
            $menus[$key]['child_menus'] = $child_menus;
        }
        return $menus;
    }
}
