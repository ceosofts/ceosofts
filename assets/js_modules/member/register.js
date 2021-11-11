
function Register(){

	var frm_action = site_url('member/regis/save');
	var frm_data = $('#formRegis').serialize();
		frm_data += '&' + csrf_token_name + '=' + $.cookie(csrf_cookie_name);
	var reg_email = $('#reg_email').val();
	loading_on($('#btn_register'));
	$('#register_alert').removeClass('alert-danger,alert-success').html('').hide();
	
	$.ajax({
		method: "POST",
		url: frm_action,
		data : frm_data,
		success: function (json_string) {
			try{
				var results = jQuery.parseJSON( json_string );
				var strType = '';
				var strTitle = 'แจ้งเตือน';
				
				if(results.is_successful){
					$('#formRegis')[0].reset(); 
					strTitle = 'ลงทะเบียนเรียบร้อย';
					strType = 'success';
					var alertMsg = '<b>ส่งรหัสยืนยันไปที่อีเมล ' + reg_email + ' กรุณาตรวจสอบกล่องจดหมายเข้าในอีเมลของท่าน หรือหากไม่พบ กรุณาตรวจสอบในกล่องจดหมายขยะ อีกครั้ง</b>';
					$('#register_alert').addClass('alert-success').html(alertMsg).show();
				}else{
					strTitle = 'กรุณาตรวจสอบข้อมูล';
					strType = 'danger';
					
					$('#register_alert').addClass('alert-danger').html(results.message).show();
				}

				notify(strTitle, results.message, strType, 'right');

				loading_on_remove($('#btn_register'));
			}
			catch(err)
			{
				alert('invalid json : ' + err + "\n\n" + json_string);
				loading_on_remove($('#btn_register'));
			}
			
        },
		error : function(jqXHR, exception){
			$('#register_alert').addClass('alert-danger').show();
			ajaxErrorMessage(jqXHR, exception, $("#register_alert"));
			loading_on_remove($('#btn_register'));
		}
	});
		
	return false; 
}