var token = getToken();
<!--获取所有资源分类-->
$.ajax({
    url: InterfaceUrl + '/v2/Type/getAllVideoTypes',
    type: 'post',
    dataType: 'json',
    data: {
        token: token
    },
    success: function (data) {
        layer.closeAll('loading');
        var code = data.code;
        if (code === 0) {
            var nav = $('.navbar-nav');
            var html = '';
            for (var i = 0; i < data.data.length; i++) {
                var name = data.data[i].name;
                var logo = data.data[i].logo;
                var type = data.data[i].type;
                var url = data.data[i].url;
                html += '<li class="nav-item">' +
                    '<a class="nav-link" href="#" datatype="' + url + '">' + name + '</a>' +
                    '</li>';
            }
            nav.html(html);

        } else {
            var message = data.message;
            layer.msg(message);
        }
    },
    error: function (data, textStatus, errorThrown) {
        console.log(data);
        layer.msg("登录失败");
    }
});


