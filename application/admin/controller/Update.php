<?php
/**
 * Created by IntelliJ IDEA.
 * User: fight
 * Date: 17-10-10
 * Time: 上午10:51
 */

namespace app\admin\controller;


use think\Db;

class Update extends Base
{
    /**
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $db = Db::name('version_manager');
        $list = $db->field(['id', 'version', 'download_link'])->select();
        $this->assign('title', 'app版本管理');
        $this->assign('list', $list);
        return $this->fetch();
    }

    /**
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function edit()
    {
        $db = Db::name('version_manager');
        $list = $db->field(['id', 'version', 'download_link'])->select();
        $this->assign('title', 'app版本管理');
        $this->assign('list', $list);
        return $this->fetch();
    }

    /**
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function update()
    {
        $android_version = input('post.android_version');
        $android_download_link = input('post.android_download_link');
        $ios_version = input('post.ios_version');
        $ios_download_link = input('post.ios_download_link');
        $db = Db::name('version_manager');
        $db->where('id', 1)->update(['version' => $android_version, 'download_link' => $android_download_link]);
        $db->where('id', 2)->update(['version' => $ios_version, 'download_link' => $ios_download_link]);
        return json_return(0);
    }

}