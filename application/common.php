<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * 返回json值
 * @param mixed $data 返回的数据
 * @param integer $code 状态码:
 * 0：成功
 * 100：服务器错误
 * 101：缺少参数
 * 102：
 * 103：
 * 200：token验证失败
 * 201：用户名已存在
 * 202：用户名或密码错误
 * 203：图片验证码错误
 * 300
 * 400
 * @return \think\response\Json
 */
function json_return($code = 0, $data = [])
{
    $codes = [
        0 => '成功',
        100 => '服务器错误',
        101 => '缺少参数',
        102 => '验证失败',
        200 => 'token验证失败',
        201 => '用户名已存在',
        202 => '用户名或密码错误',
        203 => '请填写用户名和密码',
        204 => '图片验证码错误',
        205 => '激活码无效或已被使用',
        206 => '未登录或登录已过期',
        207 => '激活码无效',
        208 => '邀请人不存在',
        300 => '无数据',
    ];
    $result = [
        'code' => $code,
        'message' => $codes[$code],
        'data' => $data
    ];
    return json($result);
}

/**
 * 返回json值
 * @return \think\response\Json
 */
function json_ajax($msg = '', $o = false)
{
    $result = ['msg' => $msg];
    if($o){
        $result['o'] = 'yes';
    } else {
        $result['o'] = 'no';
    }
    return json($result);
}

/**
 * @desc 封闭curl的调用接口，post的请求方式。
 * @
 * @param $url
 * @param $data
 * @param int $timeout
 * @return bool|mixed
 */
function post($url, $data, $timeout = 30)
{
    if (empty($url)) {
        return '$url参数为空';
    }
    if (empty($data)) {
        return '$data参数为空';
    }
    $SSL = substr($url, 0, 8) == "https://" ? true : false;
    $ch = curl_init();//初始化curl
    curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
    curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_TIMEOUT, (int)$timeout);
    if ($SSL) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书
    }
    curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $result = curl_exec($ch);//运行curl
    if ($result === false) {
        echo 'Curl error: ' . curl_error($ch);
    }
    curl_close($ch);
    return $result;
}

/**
 * @desc 封闭curl的调用接口，get的请求方式。
 * @
 * @param $url
 * @param $data
 * @param int $timeout
 * @return bool|mixed
 */
function get($url, $data = [], $timeout = 30)
{
    if (empty($url)) {
        return '$url参数为空';
    }
    $SSL = substr($url, 0, 8) == "https://" ? true : false;
    $url = $url . '?' . http_build_query($data);
    $ch = curl_init((string)$url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, (int)$timeout);
    if ($SSL) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书
    }
    $result = curl_exec($ch);
    if ($result === false) {
        echo 'Curl error: ' . curl_error($ch);
    }
    curl_close($ch);
    return $result;
}

function curl_post()
{
    $CA = true;
    $timeout = 30;
    $data = array();
    $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxb69bce6a5c304107&secret=50a385eb5a34b6c1b8d99c41f244f08c';
    $cacert = './cacert.pem'; //CA根证书
    if (file_exists($cacert)) {
        echo "文件存在";
    } else {
        echo "222";
    }
    $SSL = substr($url, 0, 8) == "https://" ? true : false;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout - 2);
    if ($SSL && $CA) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);   // 只信任CA颁布的证书
        curl_setopt($ch, CURLOPT_CAINFO, $cacert); // CA根证书（用来验证的网站证书是否是CA颁布）
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 检查证书中是否设置域名，并且是否与提供的主机名匹配
    } else if ($SSL && !$CA) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1); // 检查证书中是否设置域名
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:')); //避免data数据过长问题
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); //data with URLEncode

    $ret = curl_exec($ch);
    var_dump(curl_error($ch));  //查看报错信息

    curl_close($ch);
    var_dump($ret);
}

function get_rand_char($length)
{
    $str = null;
    $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
    $max = strlen($strPol) - 1;

    for ($i = 0; $i < $length; $i++) {
        $str .= $strPol[rand(0, $max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
    }
    return $str;
}

function get_ip()
{
    $realip = '';
    $unknown = 'unknown';
    if (isset($_SERVER)) {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown)) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($arr as $ip) {
                $ip = trim($ip);
                if ($ip != 'unknown') {
                    $realip = $ip;
                    break;
                }
            }
        } else if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP']) && strcasecmp($_SERVER['HTTP_CLIENT_IP'], $unknown)) {
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown)) {
            $realip = $_SERVER['REMOTE_ADDR'];
        } else {
            $realip = $unknown;
        }
    } else {
        if (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), $unknown)) {
            $realip = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), $unknown)) {
            $realip = getenv("HTTP_CLIENT_IP");
        } else if (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), $unknown)) {
            $realip = getenv("REMOTE_ADDR");
        } else {
            $realip = $unknown;
        }
    }
    $realip = preg_match("/[\d\.]{7,15}/", $realip, $matches) ? $matches[0] : $unknown;
    return $realip;
}

function get_ip_lookup($ip = '')
{
    if (empty($ip)) {
        $ip = get_ip();
    }
    $res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);
    if (empty($res)) {
        return false;
    }
    $jsonMatches = array();
    preg_match('#\{.+?\}#', $res, $jsonMatches);
    if (!isset($jsonMatches[0])) {
        return false;
    }
    $json = json_decode($jsonMatches[0], true);
    if (isset($json['ret']) && $json['ret'] == 1) {
        $json['ip'] = $ip;
        unset($json['ret']);
    } else {
        return false;
    }
    return $json;
}

function tree($arr, $parent_id = 0, $level = 0)
{
    static $tree = array();
    foreach ($arr as $v) {
        if ($v['parent_id'] == $parent_id) {
            $v['level'] = $level;
            $tree[] = $v;
            tree($arr, $v['id'], $level + 1);
        }
    }
    return $tree;
}

function restful($method, $uri, array $body = [], array $headers = [])
{
    $default_headers = [
        'Content-Type: application/json',
        'Connection: Keep-Alive'
    ];
    $method = strtoupper($method);
    $ch = curl_init();
    $options = array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => true,
        CURLOPT_HTTPHEADER => (empty($headers) ? $default_headers : $headers),
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.75 Safari/537.36',
        CURLOPT_CONNECTTIMEOUT => 20,
        CURLOPT_TIMEOUT => 120,
        CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
        CURLOPT_URL => $uri,
        CURLOPT_CUSTOMREQUEST => ('UPLOAD' == $method) ? 'POST' : $method
    );
    if (!empty($body)) {
        if ('UPLOAD' == $method) {
            if (class_exists('\CURLFile')) {
                $options[CURLOPT_SAFE_UPLOAD] = true;
                $options[CURLOPT_POSTFIELDS] = ['filename' => new \CURLFile($body['path'])];
            } else {
                # TODO
                if (defined('CURLOPT_SAFE_UPLOAD')) {
                    $options[CURLOPT_SAFE_UPLOAD] = false;
                    $options[CURLOPT_POSTFIELDS] = '';
                }
            }
        } else {
            $options[CURLOPT_POSTFIELDS] = json_encode($body);
        }
    }
    curl_setopt_array($ch, $options);
    $output = curl_exec($ch);
    if ($output === false) {
        return "Error Code:" . curl_errno($ch) . ", Error Message:" . curl_error($ch);
    } else {
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header_text = substr($output, 0, $header_size);
        $body = substr($output, $header_size);
        $headers = array();
        foreach (explode("\r\n", $header_text) as $i => $line) {
            if (!empty($line)) {
                if ($i === 0) {
                    $headers[0] = $line;
                } else if (strpos($line, ": ")) {
                    list ($key, $value) = explode(': ', $line);
                    $headers[$key] = $value;
                }
            }
        }
        $response['headers'] = $headers;
        $response['body'] = json_decode($body, true);
        $response['http_code'] = $httpCode;
    }
    curl_close($ch);
    return $response;
}