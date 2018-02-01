<?php

namespace app\system\model;

use think\Model;

class User extends Model
{
    protected $resultSetType = 'collection';

    /**ID
     * @data 字段对应信息
     */
    protected $fields = [
        'id' => 'id',// id
        'name' => 'name',// 登录名称
        'password' => 'password',// 密码
        'role_id' => 'role_id', // 角色ID
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
            'id' => 'id',// id
            'name' => 'name',// 登录名称
            'role_id' => 'role_id', // 角色ID
            'create_time' => 'create_time', // 创建时间
            'state' => 'state', // 状态
        ];
        $where = [
            'delete_time' => 0
        ];
        $list = $this
            ->with('role')
            ->field($field)
            ->where($where)
            ->paginate(15);
        return $list;
    }

    /**
     * 删除数据
     * @param $id
     * @return $this
     */
    function deleteById($id)
    {
        $where = [
            'id' => $id
        ];
        $data = [
            'delete_time' => time()
        ];
        $result = $this->where($where)->update($data);
        return $result;
    }

    /**
     * 关联角色
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function role()
    {
        return $this->belongsTo('Role');
    }
}
