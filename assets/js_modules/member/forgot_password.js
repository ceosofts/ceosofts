//ลืมรหัสผ่าน
function forgotPassword(){
	var frm_action = site_url('member/forgot_password/process');
	var frm_data = { 
			forgot_email: $('#forgot_email').val()
		};
		frm_data[csrf_token_name] = $.cookie(csrf_cookie_name);

	loading_on($('#btn_submit_forgot'));
	$('#forgot_alert').html('').hide();
	$.ajax({
		method: "POST",
		url: frm_action,
		data : frm_data,
		success: function (json_string) {
			try{
				var results = jQuery.parseJSON( json_string );
				
				if(results.is_successful){
					results.message = '<b>ส่งรหัสยืนยันไปที่อีเมล ' + frm_data['forgot_email'] + ' กรุณาตรวจสอบกล่องจดหมายเข้าในอีเมลของท่าน หรือหากไม่พบ กรุณาตรวจสอบในกล่องจดหมายขยะอีกครั้ง</b>';
					strTitle = 'ส่งข้อมูลเรียบร้อย';
					strType = 'success';
					
				}else{
					strTitle = 'ขออภัย';
					strType = 'danger';
				}
				
				notify(strTitle, results.message, strType, 'center');
				
				$('#forgot_alert').addClass('alert-' + strType).fadeIn().html(results.message);
				loading_on_remove($('#btn_submit_forgot'));
			}
			catch(err)
			{
				alert('invalid json : ' + err + "\n\n" + json_string);
				loading_on_remove($('#btn_submit_forgot'));
			}
		},
		error : function(jqXHR, exception){
			$('#forgot_alert').addClass('alert-danger').show();
			ajaxErrorMessage(jqXHR, exception, $("#forgot_alert"));
			loading_on_remove($('#btn_register'));
		}
	});
	return false;//stop refresh
}

$("#btn_reset_pass").click(function() {
		
	var new_pass1, new_pass2, old_pass, err_message;
	new_pass1 = $('#resetPassword1').val();
	new_pass2 = $('#resetPassword2').val();
	confirm_code = $('#resetConfirmCode').val();
	err_message = '';
	if(new_pass1 == ''){
		err_message += '<br/>กรุณาป้อนรหัสผ่าน';
	}
	if(new_pass2.length < 6){
		err_message += '<br/>รหัสผ่านอย่างน้อย 6 ตัวอักษรขึ้นไป';
	}
	if(new_pass1 != new_pass2){
		err_message += '<br/>กรุณายืนยันรหัสผ่านให้ตรงกัน';
	}
	if(confirm_code == ''){
		err_message += '<br/>กรุณาป้อนรหัสยืนยัน 8 หลัก';
	}
	if(err_message != ''){
		notify("ตรวจสอบข้อมูล", err_message, 'danger', 'center');
		return false;
	}

	var data = { 
			key : $('#forgot_key').val(),
			member_id : $('#member_id').val(),
			refkey2 : $('#refkey2').val(),
			new_pass1 : new_pass1,
			new_pass : new_pass2,
			confirm_code : confirm_code
	};
	data[csrf_token_name] = $.cookie(csrf_cookie_name);

	loading_on($("#btn_reset_pass"));
	
	$.post(site_url("member/forgot_password/process_reset"), data,
		function(jdata){
			if(jdata.is_successful){
				jdata.message = '<b>ท่านสามารถล็อกอินเข้าใช้งานด้วยรหัสผ่านได้ทันที</b>';
				strTitle = 'เปลี่ยนรหัสผ่านเรียบร้อย';
				strType = 'success';
				$('#email').focus();
				
				setTimeout(function(){
					goto_page('member/login');
				}, 1000)
			}else{
				strTitle = 'ขออภัย';
				strType = 'danger';
			}
			notify(strTitle, jdata.message, strType, 'center');
			
			loading_on_remove($("#btn_reset_pass"));
	}, 'json').fail(function(xhr, status, error) {
		notify("เกิดข้อผิดพลาด : ", error, 'danger', 'center');
	});
});


function getForgotQuestion(){
	if($('#forgot_username').val() == '' || $('#forgot_birthday').val() == ''){
		return false;
	}
	
	var forgot_username, forgot_birthday;
	var data = { 
			forgot_username : $('#forgot_username').val(),
			forgot_birthday : $('#forgot_birthday').val(),
	};
	data[csrf_token_name] = $.cookie(csrf_cookie_name);
	loading_on($("#forgot_question"));
	$("#forgot_question").removeClass('alert alert-info');
	$("#forgot_question").removeClass('text-danger');
	$.post(site_url("member/forgot_password/load_question"), data,
		function(jdata){
			if(jdata.is_successful){
				strTitle = 'กรุณาตอบคำถามที่ตั้งไว้';
				strType = 'info';
				$('#forgot_answer').focus();
				$("#forgot_question").addClass('alert alert-info');
			}else{
				strTitle = 'ขออภัย';
				strType = 'danger';
				$("#forgot_question").removeClass('alert alert-info');
				$("#forgot_question").addClass('text-danger');
			}
			notify(strTitle, jdata.message, strType, 'center');
			
			loading_on_remove($("#forgot_question"));
			
			$("#forgot_question").html(jdata.message + '?');
			
	}, 'json').fail(function(xhr, status, error) {
		notify("เกิดข้อผิดพลาด : ", error, 'danger', 'center');
	});
}

//ลืมรหัสผ่าน
function forgotPasswordQuestion(){
	if($('#forgot_question').hasClass('text-danger')){
		notify("ตรวจสอบข้อมูล", 'กรุณากรอกข้อมูล Username และ วัดเดือนปีเกิด ให้ถูกต้องเพื่อโหลดคำถาม และตอบคำถามให้ถูกต้องด้วยครับ', 'warning', 'center');
		return false;
	}
	
	var frm_action = site_url('member/forgot_password/process_question');
	var frm_data = { 
			forgot_username : $('#forgot_username').val(),
			forgot_birthday : $('#forgot_birthday').val(),
			forgot_answer : $('#forgot_answer').val()
		};
		frm_data[csrf_token_name] = $.cookie(csrf_cookie_name);

	loading_on($('#btn_submit_forgot_question'));
	$('#forgot_alert').html('').hide();
	$('#forgot_alert').removeClass('alert-danger');
	$('#forgot_alert').removeClass('alert-success');
	$.ajax({
		method: "POST",
		url: frm_action,
		data : frm_data,
		success: function (json_string) {
			try{
				var results = jQuery.parseJSON( json_string );
				
				if(results.is_successful){
					results.message = '<b>ตรวจคำตอบเรียบร้อย กำลังไปยังหน้าเปลี่ยนรหัสผ่าน...</b>';
					strTitle = 'ส่งข้อมูลเรียบร้อย';
					strType = 'success';
					
				}else{
					strTitle = 'ขออภัย';
					strType = 'danger';
				}
				
				//notify(strTitle, results.message, strType, 'center');
				
				$('#forgot_alert').addClass('alert-' + strType).fadeIn().html(results.message);
				loading_on_remove($('#btn_submit_forgot_question'));
				
				if(strType == 'success'){
					setTimeout(function(){
						goto_page('member/forgot_password/re_pass/'+ results.key_encode + '/' + results.random_pass);
					}, 2000)
				}
			}
			catch(err)
			{
				alert('invalid json : ' + err + "\n\n" + json_string);
				loading_on_remove($('#btn_submit_forgot_question'));
			}
		},
		error : function(jqXHR, exception){
			$('#forgot_alert').addClass('alert-danger').show();
			ajaxErrorMessage(jqXHR, exception, $("#forgot_alert"));
			loading_on_remove($('#btn_submit_forgot_question'));
		}
	});
	return false;//stop refresh
}

$("#forgot_username").change(function() {
	getForgotQuestion();
});

$("#forgot_birthday").change(function() {
	getForgotQuestion();
});

setDatePicker('#forgot_birthday', {
	yearRange : "-100:+0"
});
	
setDatePicker('.datepicker');