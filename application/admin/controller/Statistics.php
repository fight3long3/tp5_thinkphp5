<?php
/**
 * Created by IntelliJ IDEA.
 * User: fight
 * Date: 2017/9/14
 * Time: 15:37
 */

namespace app\admin\controller;


use think\Db;

class Statistics extends Base
{
    function index()
    {
//        $today_sql_use = 'start_time > 0 AND DATE_FORMAT(FROM_UNIXTIME(create_time), "%Y-%m-%d") = CURDATE()';
//        $today_sql = 'DATE_FORMAT(FROM_UNIXTIME(create_time), "%Y-%m-%d") = CURDATE()';
//
//        $day_group = "SELECT
//                  t2.day,
//                  IFNULL(t3.count, 0) AS count
//                FROM
//                  (SELECT @create_date := DATE_FORMAT(date_add(@create_date, INTERVAL -1 DAY), '%Y-%m-%d') day
//                   FROM
//                     (SELECT @create_date := CURDATE()
//                      FROM `fight_vip_activation_code`
//                      LIMIT 31) t1 ORDER BY day) t2
//                  LEFT JOIN
//                  (SELECT
//                     DATE_FORMAT(FROM_UNIXTIME(`create_time`),'%Y-%m-%d') AS create_day,
//                     count(1) AS count
//                   FROM `fight_vip_activation_code`
//                   WHERE CURDATE() <= DATE_ADD(DATE_FORMAT(FROM_UNIXTIME(`create_time`), '%Y-%m-%d'), INTERVAL 31 MONTH)
//                   GROUP BY DATE_FORMAT(FROM_UNIXTIME(`create_time`), '%Y-%m-%d')) t3
//                    ON t2.day = t3.create_day;";
//
//
//        $member_table = Db::name('member');
//        $code_table = Db::name('vip_activation_code');
//        $member_count = $member_table->count();
//        $member_count_today = $member_table->where($today_sql)->count();
//        $code_count_today = $code_table->where($today_sql)->count();
//        $code_count = $code_table->count();
//        $code_count_use = $code_table->where('start_time', '>', 0)->count();
//        $code_count_use_today = $code_table->where($today_sql_use)->count();
//        $day_group_results = Db::query($day_group);
//
//
//        $this->assign('title', '数据统计');
//        $this->assign('member_count', $member_count);
//        $this->assign('member_count_today', $member_count_today);
//        $this->assign('code_count', $code_count);
//        $this->assign('code_count_today', $code_count_today);
//        $this->assign('code_count_use', $code_count_use);
//        $this->assign('code_count_use_today', $code_count_use_today);
//        $this->assign('day_group_results', $day_group_results);
//        return $this->fetch();
    }
}