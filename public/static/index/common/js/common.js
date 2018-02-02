// JsonUrl="http://www.yongsheng2828.com/json.php";
// InterfaceUrl="http://app.yongsheng2828.com";
InterfaceUrl = "https://api.1688wc.com";
/**
 * set cookie
 *
 * @param name{String}
 *
 * @param value{String}
 *
 * @param hour{Number}
 *
 * @return void
 */
setCookie = function (name, value, hour) {
    var exp = new Date();
    exp.setTime(exp.getTime() + hour * 60 * 60 * 1000);
    document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString();
};

/**
 * read cookie
 *
 * @param name(String)
 *            cookie key
 * @return cookie value
 * @memberOf Tool
 */
getCookie = function (name) {
    var arr = document.cookie.match(new RegExp("(^| )" + name + "=([^;]*)(;|$)"));
    if (arr !== null) {
        return unescape(arr[2]);
    }
    return null;
};


<!--获取token-->
function getToken() {
    var _token;
    if (getCookie("token")) {
        _token = getCookie("token");
        return _token;
    } else {
        $.ajax({
            url: InterfaceUrl + '/v2/Member/getToken',
            type: 'post',
            async: false,
            timeout: 2000,
            dataType: 'json',
            data: {
                pass_check: 'dy'
            },
            success: function (data) {
                var code = data.code;
                if (code === 0) {
                    _token = data.data.token;
                    setCookie("token", _token, 2);
                } else {
                    var message = data.message;
                    layer.msg(message);
                }
            },
            error: function (data, textStatus, errorThrown) {
                if (textStatus === 'timeout') {
                    layer.msg("网络开小差了! 请检查一下网络(●'◡'●)");
                }
                else {
                    //其他错误的逻辑
                    layer.msg("网络开小差了! 请检查一下网络(●'◡'●)");
                }

            }
        });
        return _token;
    }
}

