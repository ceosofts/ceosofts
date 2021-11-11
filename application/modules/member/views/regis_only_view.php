<style>
    .form-signin {
        max-width: 650px;
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

    #formRegis {
        text-align: center;
    }
</style>
<div class="text-center">
    <form class="form-signin" role="form" method="post" id="formRegis" onsubmit="return Register();return false;">
        <div class="text-center">
            {csrf_protection}
            <h4 class="form-signin-heading">ลงทะเบียนสมาชิกใหม่</h4>
            <p class="alert alert-light">* หลังจากบันทึกข้อมูลเรียบร้อย จะมีอีเมลยืนยันการลงทะเบียนเพื่อเริ่มใช้งานอีกครั้ง</p>
            <hr class="my-4">

            <div class="form-group">
                <input type="text" class="form-control" id="reg_email" name="reg_email" placeholder="อีเมล" required autofocus max="100" />
            </div> <!-- /.form-group -->

            <div class="form-group">
                <input type="text" class="form-control" id="reg_fname" name="reg_fname" placeholder="ชื่อ" max="50" required />
            </div> <!-- /.form-group -->

            <div class="form-group">
                <input type="text" class="form-control" id="reg_lname" name="reg_lname" placeholder="นามสกุล" max="50" required />
            </div> <!-- /.form-group -->

            <p id="register_alert" class="alert" style="display:none"></p>

            <div class="form-group">
                <button type="submit" id="btn_register" class="btn btn-lg btn-success">
                    <i class="fas fa-user-check"></i> <b>สมัครสมาชิก</b>
                </button>
            </div>
        </div>
    </form>
</div>