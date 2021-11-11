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

<form class="form-signin" role="form" method="post" id="frm_login" 
	onsubmit="return LogIn();return false;">
    {csrf_protection_field}
    <h2 class="form-signin-heading">ลงชื่อเข้าใช้งาน :</h2> 
	<input type="text" name="input_username"  id="input_username" class="form-control" 
		placeholder="ชื่อล็อกอิน" required autofocus>   
    <input type="password" name="input_password"  id="input_password" class="form-control"  		
		placeholder="รหัสผ่าน" required autofocus>        
    <button class="btn btn-lg btn-primary btn-block" id="btn_login" type="submit">เข้าสู่ระบบ</button>
</form>