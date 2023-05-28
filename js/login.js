function showloginload(div) {
    var loadspinner = '<div id="loginloader" class="page-loader" style="background-color: rgba(0, 0, 0, 0.27);"><div class="page-loader__spinner"><svg viewBox="25 25 50 50"><circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle></svg></div></div>';
    $('#' + div).append(loadspinner);
}
function hideloginload() {
    $("#loginloader").remove();
}
function successlogin() {
    $('#login').prepend('<div class="alert alert-success" role="alert" style="padding: 6px;">Login successful, <a href="index" class="alert-link">press this</a>.</div>');
}
function errorlogin(msg) {
    $('#login').prepend('<div class="alert alert-danger alert-dismissible fade show" role="alert" style="padding: 6px;"><button type="button" style="padding: 6px;" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + msg + '.</div>');
}
function errorreg(msg) {
    $('#register').prepend('<div class="alert alert-danger alert-dismissible fade show" role="alert" style="padding: 6px;"><button type="button" style="padding: 6px;" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + msg + '.</div>');
}
function successreg() {
    $('#register').prepend('<div class="alert alert-success" role="alert" style="padding: 6px;">Your account has been created, <a href="login" class="alert-link">login now</a>.</div>');
}
function successrecover() {
    $('#forgot').prepend('<div class="alert alert-success" role="alert" style="padding: 6px;">New password sent to your contacts! <a href="login" class="alert-link">Login now</a>.</div>');
}
function errorrecover(msg) {
    $('#forgot').prepend('<div class="alert alert-danger alert-dismissible fade show" role="alert" style="padding: 6px;"><button type="button" style="padding: 6px;" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + msg + '.</div>');
}
function previewstyle() {
    var bgcolor = localStorage.getItem('bgcolor');
    var bgsize = localStorage.getItem('bgsize');
    var bgattach = localStorage.getItem('bgattach');
    var bgpos = localStorage.getItem('bgpos');
    var bgimage = localStorage.getItem('bgimage');
    var logoimg = localStorage.getItem('logoimg');
    if (bgcolor) {
        $('body').css("background-color", bgcolor);
    }
    if (bgsize) {
        $('body').css("background-size", bgsize);
    }
    if (bgattach) {
        $('body').css("background-attachment", bgattach);
    }
    if (bgpos) {
        $('body').css("background-position", bgpos);
    }
    if (bgimage) {
        $('body').css("background-image", "url(" + bgimage + ")");
    } else {
        $('body').css("background-image", "none");
    }
    if (logoimg) {
        $('img')[0].src = logoimg
    }
}

$(function () {
    $('#login').submit(function (e) {
        e.preventDefault();
        var m_method = $(this).attr('method');
        var m_action = $(this).attr('action');
        var m_data = $(this).serialize();
        $.ajax({
            type: m_method,
            url: m_action,
            data: m_data,
            beforeSend: showloginload('login'),
            success: function (msg) {
                if (msg == 'success') {
                    window.location.replace("index");
                    successlogin();
                } else {
                    errorlogin(msg);
                    $('#captchalog').attr('src', 'captcha/captcha?' + Math.random());
                }
                hideloginload();
            },
            error: function (msg) {
                $("#result").html("<font color='#ff0000'>Ajax loading error, please try again.</font>").show();
                hideloginload();
            }
        });
    });
    $('#register').submit(function (e) {
        e.preventDefault();
        var m_method = $(this).attr('method');
        var m_action = $(this).attr('action');
        var m_data = $(this).serialize();
        $.ajax({
            type: m_method,
            url: m_action,
            data: m_data,
            beforeSend: showloginload('register'),
            success: function (msg) {
                if (msg == 'success') {
                    successreg();
                } else {
                    errorreg(msg);
                    $('#captchalogreg').attr('src', 'captcha/captcha?' + Math.random());
                }
                hideloginload();
            },
            error: function (msg) {
                $("#result").html("<font color='#ff0000'>Ajax loading error, please try again.</font>").show();
                hideloginload();
            }
        });
    });
    $('#forgot').submit(function (e) {
        e.preventDefault();
        var m_method = $(this).attr('method');
        var m_action = $(this).attr('action');
        var m_data = $(this).serialize();
        $.ajax({
            type: m_method,
            url: m_action,
            data: m_data,
            beforeSend: showloginload('forgot'),
            success: function (msg) {
                if (msg == 'success') {
                    successrecover();
                } else {
                    errorrecover(msg);
                    $('#captchalogforgot').attr('src', 'captcha/captcha?' + Math.random());
                }
                hideloginload();
            },
            error: function (msg) {
                $("#result").html("<font color='#ff0000'>Ajax loading error, please try again.</font>").show();
                hideloginload();
            }
        });
    });
});