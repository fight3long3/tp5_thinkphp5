function getToken() {
    var token = '';
    $.ajax({
        type: 'GET',
        url: '/getToken',
        async: false,//请求是否异步，默认为异步
        dataType: 'json',
        success: function (data) {
            if (data.code === 0) {
                token = data.data
            } else {
                layer.msg(data.message, {icon: 5, time: 1000});
            }
        },
        error: function () {
            layer.msg('服务器错误', {icon: 5, time: 1000}, function () {
            });
        }
    });
    return token;
}

function delete_this(url, id) {
    layer.confirm('确定删除？', {
        btn: ['确定', '取消'] //按钮
    }, function () {
        $.ajax({
            type: 'post',
            data: {
                __token__: getToken()
            },
            url: url + id,
            dataType: 'json',
            success: function (data) {
                if (data.code === 0) {
                    layer.msg(data.message, {icon: 6, time: 1000}, function () {
                        window.location.href = '';
                    });
                } else {
                    layer.msg(data.message, {icon: 5, time: 1000});
                }
            }
        })
    });
}

function save(form, url, redirect_url) {
    $.ajax({
        type: 'post',
        url: url,
        data: $(form).serialize(),
        dataType: 'json',
        success: function (data) {
            if (data['code'] !== 0) {
                layer.msg(data['message'], {icon: 5, time: 1000}, function () {
                    // window.location.href = '';
                });
            } else {
                layer.msg('添加成功', {icon: 6, time: 1000}, function () {
                    window.location.href = redirect_url;
                });
            }
        },
        error: function () {
            layer.msg('服务器错误', {icon: 5, time: 1000}, function () {
                // window.location.href = '';
            });
        }
    })
}

function update(form, url, redirect_url) {
    $.ajax({
        type: 'post',
        url: url,
        data: $(form).serialize(),
        dataType: 'json',
        success: function (data) {
            if (data['code'] !== 0) {
                layer.msg(data['message'], {icon: 5, time: 1000}, function () {
                    // window.location.href = '';
                });
            } else {
                layer.msg('保存成功', {icon: 6, time: 1000}, function () {
                    window.location.href = redirect_url;
                });
            }
        },
        error: function () {
            layer.msg('服务器错误', {icon: 5, time: 1000}, function () {
                // window.location.href = '';
            });
        }
    })
}

function update_items(url, state) {
    var ids = '';
    $("input[name=id]:checked").each(function () {
        ids += $(this).attr('id') + ',';
    });
    if (ids === '') {
        return false;
    }
    $.ajax({
        type: 'post',
        url: url,
        data: {
            ids: ids,
            __token__: getToken(),
            state: state
        },
        dataType: 'json',
        success: function (data) {
            if (data['code'] !== 0) {
                layer.msg(data['message'], {icon: 5, time: 1000}, function () {
                    window.location.href = '';
                });
            } else {
                layer.msg('保存成功', {icon: 6, time: 1000}, function () {
                    window.location.href = '';
                });
            }
        },
        error: function () {
            layer.msg('服务器错误', {icon: 5, time: 1000}, function () {
                // window.location.href = '';
            });
        }
    })
}

function update_this(url, id, state) {
    $.ajax({
        type: 'post',
        url: url,
        data: {
            id: id,
            __token__: getToken(),
            state: state
        },
        dataType: 'json',
        success: function (data) {
            if (data['code'] !== 0) {
                layer.msg(data['message'], {icon: 5, time: 1000}, function () {
                    // window.location.href = '';
                });
            } else {
                layer.msg('保存成功', {icon: 6, time: 1000}, function () {
                    window.location.href = '';
                });
            }
        },
        error: function () {
            layer.msg('服务器错误', {icon: 5, time: 1000}, function () {
                // window.location.href = '';
            });
        }
    })
}

$("#setBox").click(function () {
    if ($(this).prop("checked")) {
        $("input[name=id]").prop("checked", true)
    } else {
        $("input[name=id]").prop("checked", false)
    }
});

function delete_items(url) {
    layer.confirm('确定删除？', {
        btn: ['确定', '取消'] //按钮
    }, function () {
        var ids = '';
        $("input[name=id]:checked").each(function () {
            ids += $(this).attr('id') + ',';
        });
        if (ids === '') {
            return false;
        }
        $.ajax({
            type: 'post',
            url: url,
            data: {
                ids: ids,
                __token__: getToken()
            },
            dataType: 'json',
            success: function (data) {
                if (data['code'] !== 0) {
                    layer.msg(data['message'], {icon: 5, time: 1000}, function () {
                        // window.location.href = '';
                    });
                } else {
                    layer.msg('删除成功', {icon: 6, time: 1000}, function () {
                        window.location.href = '';
                    });
                }
            },
            error: function () {
                layer.msg('服务器错误', {icon: 5, time: 1000}, function () {
                    // window.location.href = '';
                });
            }
        })
    });
}

function check_items(id) {
    var this_item = $('#' + id);
    if (this_item.prop("checked")) {
        this_item.prop("checked", false);
    } else {
        this_item.prop("checked", true);
    }
}

$(function () {
    $('#start_time').datetimepicker();
    $('#end_time').datetimepicker();
});
