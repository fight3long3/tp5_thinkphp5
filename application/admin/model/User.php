<?php
/**
 * Created by IntelliJ IDEA.
 * User: fight
 * Date: 2017/4/7
 * Time: 16:36
 */

namespace app\admin\model;

use think\Model;

class User extends Model
{
    protected $resultSetType = 'collection';

    /**
     * @param $username
     * @param $password
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function check($username, $password)
    {
        $field = ['id', 'name', 'role_id'];
        $where = [
            'name' => $username,
            'password' => md5(sha1($password)),
            'state' => 0,
            'delete_time' => 0
        ];
        $result = $this->field($field)
            ->where($where)
            ->find()
            ->toArray();
        return $result;
    }

    public function getStatusAttr($value)
    {
        $status = [0 => '正常', 1 => '禁用'];
        return $status[$value];
    }
}