<?php
/**
 * Created by PhpStorm.
 * User: fight
 * Date: 2018/1/29
 * Time: 17:11
 */

if (array_key_exists('id', $_POST)) {
    $id = $_POST['id'];
}

require_once 'Mysql.php';
$config = require_once '../ong/config.php';
$Db = new Mysql($config['write']);
$Db->insert('ay_dingdan', $data);

$field = [
    'name',
    'jine',
    'huobi',
];

$where = [
    'id' => $id
];
$Db->field($field)->where($where)->limit(1)->select();

var_dump($Db);