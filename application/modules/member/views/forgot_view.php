<style>
    .form-signin {
		max-width: 600px;
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
    
	#formForgot{
		text-align : center;
	}
</style>

<form class="form-signin" role="form" method="post" id="formForgot"
onsubmit="return forgotPassword();return false;">
	
	{csrf_protection}
	<h4 class="text-primary"><i class="fa fa-lock fa-4x"></i></h4>
	<h2 class="text-center">ลืมรหัสผ่าน ?</h2>	
	<hr class="my-4" />
	<p>กรอกอีเมลที่ใช้สมัครสมาชิก เพื่อรับลิงค์สำหรับรีเซ็ตรหัสผ่านใหม่.</p>
	<div class="form-group">
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text">
					<i class="fa fa-envelope fa-3x"></i>
				</span>
			</div>
			<input id="forgot_email" name="forgot_email" 
			placeholder="Email address" class="form-control"  
			type="email" required   aria-describedby="basic-addon1"/>

		</div>
	</div>
	
	<div id="forgot_alert" class="alert" style="display:none"></div>
	
	<div class="form-group">
		<button type="submit" id="btn_submit_forgot" class="btn btn-xl btn-primary"><i class="fa fa-undo"></i> <b>Reset Password</b></button>
	</div>
</form>

