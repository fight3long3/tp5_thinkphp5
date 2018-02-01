<?php

namespace app\merchant\model;

use think\Model;

class Merchant extends Model
{
    protected $resultSetType = 'collection';

    /**
     * 字段对应信息
     */
    protected $fields = [
        'id' => 'id',//id
        'name' => 'name', // 用户账号
        'password' => 'password', // 用户密码
        'user_money' => 'user_money', // 账户余额
        'rate' => 'rate', // 提现费率
        'user_tel' => 'user_tel', // 用户手机
        'user_name' => 'user_name', // 用户姓名
        'key' => 'key', // 用户key
        'security_remind' => 'security_remind', // 安全金额提醒
        'audit_switch' => 'audit_switch', // 大额审核开关
        'white_list' => 'white_list', // 白名单
        'times' => 'times', // 每人每天最多提现次数（不包含1元）
        'role_id' => 'role_id', // 权限id
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
    function getList($where)
    {
        $field = [
            'id' => 'id',//id
            'name' => 'name', // 用户账号
            'user_money' => 'user_money', // 账户余额
            'rate' => 'rate', // 提现费率
            'user_tel' => 'user_tel', // 用户手机
            'user_name' => 'user_name', // 用户姓名
            'key' => 'key', // 用户key
            'security_remind' => 'security_remind', // 安全金额提醒
            'audit_switch' => 'audit_switch', // 大额审核开关
            'white_list' => 'white_list', // 白名单
            'times' => 'times', // 每人每天最多提现次数（不包含1元）
            'create_time' => 'create_time', // 创建时间
            'state' => 'state', // 是否启用
        ];
        $list = $this
            ->field($field)
            ->where($where)
            ->paginate(10);
        return $list;
    }

    /**
     * 添加数据
     * @param $phone
     * @return int|string
     * @internal param $name
     * @internal param $type
     * @internal param $logo
     * @internal param $url
     * @internal param $sequence
     * @internal param $remarks
     */
    function insertData($phone)
    {
        $data = [
            'phone' => $phone, // 手机号
            'create_time' => time(), // 手机号
        ];

        $result = $this->insert($data);
        $last_id = 0;
        if ($result) {
            $last_id = $this->getLastInsID();
        }
        return $last_id;
    }

    /**
     * 读取数据
     * @param $id
     * @return array
     * @throws \think\Exception
     */
    function readById($id)
    {
        $field = [
            'id' => 'id',//id
            'name' => 'name', // 用户账号
            'user_money' => 'user_money', // 账户余额
            'rate' => 'rate', // 提现费率
            'user_tel' => 'user_tel', // 用户手机
            'user_name' => 'user_name', // 用户姓名
            'key' => 'key', // 用户key
            'security_remind' => 'security_remind', // 安全金额提醒
            'audit_switch' => 'audit_switch', // 大额审核开关
            'white_list' => 'white_list', // 白名单
            'times' => 'times', // 每人每天最多提现次数（不包含1元）
            'create_time' => 'create_time', // 创建时间
            'state' => 'state', // 是否启用
        ];
        $where = [
            $this->fields['id'] => $id
        ];
        $result = $this
            ->field($field)
            ->where($where)
            ->find()
            ->toArray();
        return $result;
    }

    /**
     * 更新数据
     * @param $id
     * @param $phone
     * @return $this
     * @internal param $name
     * @internal param $type
     * @internal param $logo
     * @internal param $url
     * @internal param $sequence
     * @internal param $remarks
     */
    function updateDataById($id, $phone)
    {
        $where = [
            $this->fields['id'] => $id
        ];
        $data = [
            'phone' => $phone, // 手机号
            'update_time' => time(), // 最近修改时间
        ];
        $result = $this->where($where)->update($data);
        return $result;
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
}
