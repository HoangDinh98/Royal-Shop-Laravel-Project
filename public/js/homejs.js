$(document).ready(function () {
    $('.btn_login').click(function () {
        var email = $('#email').val();
        var password = $('#password').val();
        var remember_me;
        
        if($('#remember_me').prop('checked') == true) {
            remember_me = $('#remember_me').val();
        } else {
            remember_me = null;
        }
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "/user/login",
            data: {
                'email': email,
                'password': password,
                'remember_me': remember_me
            },
            success: function (data) {
//                console.log(data);

                if (data.numErr == 0) {
                    var action;
                    var path = data.path;

                    $('#btn_close').click();
                    alert('Đăng nhập thành công');

                    $('#login').remove();
                    $('#user_menu').remove();
                    if (data.role == "Admin") {
                        action = '<div class = "btn-group" >' +
                                '<a class = "btn btn-mini dropdown-toggle" data-toggle = "dropdown" href = "#" >' + data.username + '</a>' +
                                '<ul class = "dropdown-menu" >' +
                                '<li> <a href="' + path + 'ui/user/' + data.userid + '">Trang cá nhân</a></li>' +
                                '<li> <a href="' + path + 'admin/products" target="_blank">Quan trị trang</a></li>' +
                                '</ul></div>';
                    } else {
                        action = '<a href="' + path + 'ui/user/' + data.userid + '" class="btn btn-mini" ><span class="">' + data.username + '</span></a>';
                    }
                    
                    $('#user_btn').html(action);
//                    console.log(data);
                    location.reload(true);
                    
                } else {
                    if (data.emailErr != '') {
                        $("#email_box").addClass("has-error");
                        $('#email_Err').text(data.emailErr)
                    } else {
                        $("#email_box").removeClass("has-error");
                        $('#email_Err').text('')
                    }

                    if (data.passErr != '') {
                        $("#pass_box").addClass("has-error");
                        $('#pass_Err').text(data.passErr)
                    } else {
                        $("#pass_box").removeClass("has-error");
                        $('#pass_Err').text('')
                    }
                    
                    if (data.confirmErr != '') {
                        $('#not-verify').html(data.confirmErr)
                    } else {
                        $('#not-verify').html('')
                    }
                }
            }
        });
    });
});