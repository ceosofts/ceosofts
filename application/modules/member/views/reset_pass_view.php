<?php
if(empty($reset_data)){
    echo "<h3 class='redprice'>$error_message</h3>";
    echo "<p>$error_url</p>";
    echo "<p>$expire</p>";
}else{

?>

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
    
</style>
            
<form class="form-signin" role="form" onsubmit>
	{csrf_protection}
	<h4 class="form-signin-heading">เปลี่ยนแปลงรหัสผ่านใหม่ {user_full_name}</h4>			
	<hr class="my-4">
	
	<input type="hidden" id="forgot_key" value="<?php echo $forgot_key;?>" />
	<input type="hidden" id="member_id" name="member_id" value="<?php echo $encrypt_member_id;?>" />
	<input type="hidden" id="refkey2" name="refkey2" value="<?php echo $encrypt_member_email;?>" />
	<div class="form-group">
		<label class='col-sm-4 control-label' for='resetPassword1'>รหัสผ่าน  :</label>
		<div class="input-group">
			<input type="password" class="form-control" id="resetPassword1" name="resetPassword1" 
				placeholder="รหัสผ่านใหม่" max="50" />
			<label for="resetPassword1" class="input-group-addon glyphicon glyphicon-lock"></label>
		</div>
	</div> <!-- /.form-group -->

	<div class="form-group">
		<label class='col-sm-4 control-label' for='resetPassword2'>ยืนยันรหัสผ่าน  :</label>
		<div class="input-group">
			<input type="password" class="form-control" id="resetPassword2" 
				name="reset_password" placeholder="ยืนยันรหัสผ่านใหม่อีกครั้ง">
			<label for="resetPassword2" class="input-group-addon glyphicon glyphicon-lock"></label>
		</div> <!-- /.input-group -->
	</div> <!-- /.form-group -->

	<div class='form-group'>           
		<label class='col-sm-6 control-label' for='resetConfirmCode'>รหัสยืนยัน 8 หลัก <span class="{rand_pass_remark}">(ที่ได้รับในอีเมล)</span>  :</label>
		<div class="input-group">
			<input type="text" {rand_pass_readonly}
					class="form-control" id="resetConfirmCode" value="{rand_pass}"
					name="resetConfirmCode" placeholder="รหัสยืนยัน 8 หลัก ">
			<label for="resetConfirmCode" class="input-group-addon glyphicon glyphicon-lock"></label>
		</div> <!-- /.input-group -->    
	</div>

	<div class='form-group'>           
		<label class='col-sm-4 control-label' for='resetConfirmCode'></label>
		<div class="input-group pull-left">
			<button type="button" id="btn_reset_pass" class="btn btn-lg btn-warning">
				<b>เปลี่ยนรหัสผ่าน</b>
			</button>
			<label ></label>
		</div> <!-- /.input-group -->    
	</div>                

	<div style="clear:both"></div>
</form>
        
       
<?php 
}


?>