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
onsubmit="return forgotPasswordQuestion();return false;">
	
	{csrf_protection}
	<h4 class="text-secondary"><i class="fa fa-lock fa-4x"></i></h4>
	<h2 class="text-center">ลืมรหัสผ่าน ?</h2>	
	
	<p>กรุณาตอบคำถามที่ท่านได้ตั้งค่าเอาไว้ เพื่อรีเซ็ตรหัสผ่านใหม่.</p>
	<hr class="my-4" />
	<p>Username</p>
	<div class="form-group">
		<div class="input-group">
			<input id="forgot_username" name="forgot_username" 
			placeholder="ชื่อผู้ใช้งาน..." class="form-control"  
			type="text" required aria-describedby="basic-addon1"
			autocorrect="off"
			/>

		</div>
	</div>
	<p>วันเดือนปีเกิด</p>
	<div class="form-group">
		<div class="input-group">
			<input id="forgot_birthday" name="forgot_birthday" 
			placeholder="ระบุวันเดือนปีเกิด..." class="form-control datepicker"  
			type="text" required aria-describedby="basic-addon1"
			autocorrect="off"
			/>

		</div>
	</div>
	<p id="forgot_question">...คำถามของคุณ...</p>
	<div class="form-group">
		<div class="input-group">
			<input id="forgot_answer" name="forgot_answer" 
			placeholder="คำตอบ..." class="form-control"  
			type="text" required aria-describedby="basic-addon1"
			autocorrect="off"
			/>

		</div>
	</div>
	
	<div id="forgot_alert" class="alert" style="display:none"></div>
	
	<div class="form-group">
		<button type="submit" id="btn_submit_forgot_question" class="btn btn-xl btn-primary"><i class="fa fa-undo"></i> <b>ส่งคำตอบ</b></button>
	</div>
</form>

