<?php
/**
 * Created by IntelliJ IDEA.
 * User: fight
 * Date: 2017/9/5
 * Time: 11:50
 */

namespace app\common\validate;

use think\Validate;

class ActivationCode extends Validate
{
    protected $rule = [
        'num' => 'require|token',
        'duration_time' => 'require',
    ];

}