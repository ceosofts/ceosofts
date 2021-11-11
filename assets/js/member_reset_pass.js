$('#btn_change_pass').click(function() {  
	var new_pass1, new_pass2, old_pass, err_message;
	new_pass1 = $('#resetPassword1').val();
	new_pass2 = $('#resetPassword2').val();
	old_pass = $('#uPasswordOld').val();
	err_message = '';
	if(new_pass1 == ''){
		err_message += '<br/>- กรุณาป้อนรหัสผ่าน';
	}
	if(new_pass2.length < 6){
		err_message += '<br/>- รหัสผ่านอย่างน้อย 6 ตัวอักษรขึ้นไป';
	}
	if(new_pass1 != new_pass2){
		err_message += '<br/>- กรุณายืนยันรหัสผ่านให้ตรงกัน';
	}
	if($('#uPasswordOld').val() == ''){
		err_message += '<br/>- รหัสผ่านเดิม';
	}
	if(err_message != ''){
		notify("ตรวจสอบข้อมูล", err_message, 'danger', 'center');
		return false;
	}

	var faction = site_url('member_profile/change_passwd');
	var fdata = $('#formChangePass').serialize();
	fdata += '&' + csrf_token_name + '=' + $.cookie(csrf_cookie_name);
	$.post(faction, fdata, function(jdata){   
		var strType = '';
		var strTitle = '';
		if(jdata.is_successful){
			strTitle = 'ดำเนินการเรียบร้อย';
			strType = 'success';
		}else{
			strTitle = 'ขออภัย ไม่สามารถดำเนินการได้';
			strType = 'danger';
		}
		notify(strTitle, jdata.message, strType, 'center');
		
		$('#formChangePass button').button('reset');
		$('#modal_change_pass').modal('hide');
	},'json');
	
});