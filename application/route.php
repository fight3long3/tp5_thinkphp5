<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

Route::rule('login', function () {
    session('login_path', 1);
    return '<script>location.href = "/admin/User/login";</script>';
});

Route::rule('getToken', function () {
    $request = \think\Request::instance();
    return json_return(0, $request->token());
});
