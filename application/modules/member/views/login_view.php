<style>
    .form-signin {
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
    }

    .form-signin .form-signin-heading,
    .form-signin .checkbox {
        margin-bottom: 10px;
    }

    .form-signin .checkbox {
        font-weight: normal;
    }

    .form-signin .form-control {
        position: relative;
        height: auto;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        padding: 10px;
        font-size: 16px;
    }

    .form-signin .form-control:focus {
        z-index: 2;
    }

    .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }

    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
</style>

<form class="form-signin" role="form" method="post" id="frm_login" onsubmit="return LogIn();return false;" autocomplete="off">
    {csrf_protection}
    <h2 class="form-signin-heading">ลงชื่อเข้าใช้งาน :</h2>

    <input type="text" autocapitalize="off" autocorrect="off" autocomplete="off" autofocus="autofocus" name="ci_login_email" id="ci_login_email" class="form-control mb-1 input-block" placeholder="อีเมล/ชื่อผู้ใช้งาน" required />

    <input type="password" autocomplete="off" name="ci_login_password" id="ci_login_password" class="form-control" placeholder="รหัสผ่าน" required />

    <div id="alert_login" style="display:none"></div>

    <button class="btn btn-lg btn-primary btn-block" id="btn_login" type="submit">
        <i class="fa fa-lock" aria-hidden="true"></i> เข้าสู่ระบบ
    </button>


    <br />
    <a href="<?php echo site_url('member/forgot_password/question'); ?>" class="btn btn-lg btn-block btn-secondary">
        <i class="fas fa-undo fa-x2"></i> ลืมรหัสผ่าน ??</i>
    </a>
    <a href="<?php echo site_url('member/forgot_password'); ?>" class="btn btn-lg btn-block btn-warning">
        <i class="fas fa-undo fa-x2"></i> ลืมรหัสผ่าน ด้วย Email ??</i>
    </a>
    <a href="<?php echo site_url('member/regis'); ?>" class="btn btn-lg btn-block btn-success"><i class="fas fa-user-edit"></i> ลงทะเบียนสมาชิกใหม่!
    </a>

</form>