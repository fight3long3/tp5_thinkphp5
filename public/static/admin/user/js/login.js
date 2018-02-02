function login() {
    var username = $('#username');
    var password = $('#password');

    if (username.val() === '') {
        dialog.error('用户名不能为空', username);
        return false;
    }
    if (password.val() === '') {
        dialog.error('密码不能为空', password);
        return false;
    }

    $.ajax({
        type: 'post',
        url: '/admin/user/getData',
        data: {username: md5(username.val()), password: md5(password.val())},
        dataType: 'json',
        success: function (data) {
            if (data === '101') {
                password.val('');
                dialog.error('用户名不正确', username);
            } else if (data === '102') {
                password.val('');
                dialog.error('密码不正确', password);
            } else {
                dialog.successTipe('登录成功', '/admin');
            }
        }
    })
}

