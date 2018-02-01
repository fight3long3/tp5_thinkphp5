<?php

namespace app\system\model;

use think\Model;

class Role extends Model
{
    /**ID
     * @data 字段对应信息
     */
    protected $fields = [
        'id' => 'id',// id
        'name' => 'name',// 登录名称
        'rule' => 'rule', // 规则ID
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
            'create_time' => 'create_time', // 创建时间
            'state' => 'state', // 状态
        ];
        $where = [
            $this->fields['delete_time'] => 0
        ];
        $list = $this
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
            $this->fields['id'] => $id
        ];
        $data = [
            $this->fields['delete_time'] => time()
        ];
        $result = $this->where($where)->update($data);
        return $result;
    }

    public function users()
    {
        return $this->hasMany('User');
    }

    public function rules()
    {
        return $this->belongsToMany('Rule');
    }
}
