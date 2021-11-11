
var Profile = {

	current_page : 0,
	
	validateFormEdit: function(){
		if($('#edit_remark').val().length < 5){
			notify('กรุณาระบุเหตุผล', 'เหตุผลการแก้ไขจะต้องระบุให้ชัดเจน', 'danger', 'center', 'bottom');
		}else{
			this.saveEditForm();
		}
		return false;
	},

	saveEditForm: function(){
		$('#editModal').modal('hide');
		var frm_action = site_url('member/profile/update');

		if(!$('#post_iframe').attr('id')){
			var iframe = $('<iframe name="post_iframe" id="post_iframe" style="display: none"></iframe>');
			$("body").append(iframe);
		}
		
		var obj = $('#btnOpenSaveDialog');
		if(loading_on(obj) == true){
			
			if(!$('#temp_edit_remark').attr('id')){
				$('<input />').attr('type', 'hidden')
								.attr('id', 'temp_edit_remark')
								.attr('name', 'edit_remark')
								.attr('value', $('#edit_remark').val())
								.appendTo('#formEdit');
			}else{
					$('#temp_edit_remark').val($('#edit_remark').val());
			}
			
			var form = $('#formEdit');

			form.attr("action", frm_action);
			form.attr("method", "post");

			form.attr("encoding", "multipart/form-data");
			form.attr("enctype", "multipart/form-data");

			form.attr("target", "post_iframe");

			$('[name="'+ csrf_token_name +'"]').val($.cookie(csrf_cookie_name));

			try
			{
				form.submit();

				var c = 0;
				$("#post_iframe").on('load',function() {
					c++;
					if(c==1){

						iframeContents = this.contentWindow.document.body.innerHTML;
						var json_string = iframeContents.toString();
						if(json_string != ""){
							json_string = $("<div/>").html(json_string).text();
							try
							{
								var results = jQuery.parseJSON( json_string );
								if(results.is_successful){
									alert_type = 'success';

									$('#photo_preview').attr('src', results.photo);
									$('#photo_preview').css('width', 'auto');
									$('#photo_preview').css('height', 'auto');
								}else{
									alert_type = 'danger';
								}
								notify('บันทึกข้อมูล', results.message, alert_type, 'center');
								loading_on_remove(obj);
							}
							catch(err)
							{
								alert('Invalid json : ' + err + "\n\n" + json_string);
							}
						}else{
							alert('การดำเนินการล้มเหลว กรุณาลองใหม่อีกครั้ง');
							loading_on_remove(obj);
						}
					}
				});
			}
			catch(err)
			{
				alert(err);
			}
		}
	},
	
	saveQuestion : function(){
		var frm_action = site_url('member/profile/save_question');
		var obj = $('#btn_change_question');
		if(loading_on(obj) == true){


			var frm_data = $('#formChangeQuestion').serializeObject();
			frm_data[csrf_token_name] = $.cookie(csrf_cookie_name);

			$.ajax({
				method: 'POST',
				url: frm_action,
				dataType: 'json',
				data : frm_data,
				success: function (results) {

					if(results.is_successful){
						alert_type = 'success';
					}else{
						alert_type = 'danger';
					}
					notify('บันทึกคำถามเรียบร้อย', results.message, alert_type, 'center');
					loading_on_remove(obj);
					$('#modal_change_question').modal('hide');
				},
				error : function(jqXHR, exception){
					ajaxErrorMessage(jqXHR, exception);
						loading_on_remove(obj);
				}
			});
		}
		return false;
	}
}

$(document).ready(function() {

	$('#btnSaveEdit').click(function() {
		return Profile.validateFormEdit();
	});//click

	if(typeof param_current_page != 'undefined'){
		Profile.current_page = Math.abs(param_current_page);
	}
	
	$('#btnOpenSaveDialog').click(function(){
		$('#edit_remark').val('');
	});
	
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
		
		var frm_action = site_url('member/profile/change_passwd');
		var frm_data = $('#formChangePass').serialize();
			frm_data += '&' + csrf_token_name + '=' + $.cookie(csrf_cookie_name);
			
		loading_on($('#btn_change_pass'));
		$.ajax({
			method: "POST",
			url: frm_action,
			data : frm_data,
			success: function (json_string) {
				try
				{
					var results = jQuery.parseJSON( json_string );
					var strType = '';
					var strTitle = '';
					var strMsg = results.message;
					if(results.is_successful){
						strTitle = 'ดำเนินการเรียบร้อย';
						strType = 'success';
						$('#modal_change_pass').modal('hide');
						//strMsg += "<br/><p>กรุณาล็อกอินเข้าสู่ระบบอีกครั้ง</p>";
						//window.location = site_url();
					}else{
						strTitle = 'ขออภัย ไม่สามารถดำเนินการได้';
						strType = 'danger';
					}
					notify(strTitle, strMsg, strType, 'center');
					
					$('#formChangePass button').button('reset');
					loading_on_remove($('#btn_change_pass'));
				}
				catch(err)
				{
					alert('invalid json : ' + err + "\n\n" + json_string);
				}
			},
			error : function(jqXHR, exception){
				ajaxErrorMessage(jqXHR, exception);
			}
		});
		
	});
	
	$('#modal_change_pass').on('hidden.bs.modal', function () {
		$('#resetPassword1, #resetPassword2').val('');
		$('#uPasswordOld').val('');
	});
	
	
	$('#btn_change_question').click(function () {
		var quest, ans1, ans2, birth, err_message;
		quest = $('#question').val();
		ans1 = $('#answer').val();
		ans2 = $('#confirm_answer').val();
		birth = $('#birthday').val();
		err_message = '';
		if(quest == ''){
			err_message += '<br/>- กรุณาป้อนคำถาม';
		}
		
		if(ans1 == ''){
			err_message += '<br/>- กรุณาป้อนคำตอบ';
		}
		if(ans2 == ''){
			err_message += '<br/>- กรุณายืนยันคำตอบ';
		}
		
		if(ans1 != ans2){
			err_message += '<br/>- กรุณายืนยันคำตอบให้ตรงกัน';
		}
		
		if(birth == ''){
			err_message += '<br/>- กรุณาระบุวันเดือนปีเกิด';
		}
		
		if(err_message != ''){
			notify("ตรวจสอบข้อมูล", err_message, 'danger', 'center');
			return false;
		}
		
		
		Profile.saveQuestion();
	});
	
	function validateEmail(email) {
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}
	
	$('#btnUnsubscribe').click(function() {  
		var frm_action = site_url('member/profile/unsubscribe');
		var frm_data = csrf_token_name + '=' + $.cookie(csrf_cookie_name);
			frm_data += '&unsubscribe=' + $(this).data('unsubscribe');
		
		//Loading
		loading_on($('#btnUnsubscribe'));
		$.ajax({
			method: "POST",
			url: frm_action,
			data : frm_data,
			success: function (json_string) {
				loading_on_remove($('#btnUnsubscribe'));
				try
				{
					var results = jQuery.parseJSON( json_string );
					var strType = '';
					var strTitle = '';
					if(results.is_successful){
						strTitle = 'ดำเนินการเรียบร้อย';
						strType = 'success';
						if($('#btnUnsubscribe').hasClass('btn-success')){
							$('#btnUnsubscribe').removeClass('btn-success').addClass('btn-danger');
							$('#btnUnsubscribe').html('ไม่รับอีเมลข่าวสาร').attr('title', 'คลิกที่นี่ เพื่อเปิดรับอีเมลข่าวสาร');
						}else{
							$('#btnUnsubscribe').removeClass('btn-danger').addClass('btn-success');
							$('#btnUnsubscribe').html('รับอีเมลข่าวสาร').attr('title', 'คลิกที่นี่ เพื่อยกเลิกการรับอีเมลข่าวสาร');
						}
					}else{
						strTitle = 'ขออภัย ไม่สามารถดำเนินการได้';
						strType = 'danger';
					}
					notify(strTitle, results.message, strType, 'center');
				}
				catch(err)
				{
					alert('invalid json : ' + err + "\n\n" + json_string);
				}
				
			},
			error : function(jqXHR, exception){
				ajaxErrorMessage(jqXHR, exception);
				loading_on_remove($('#btnUnsubscribe'));
			}
		});
	});

	
	$('#modal_change_email').on('hidden.bs.modal', function () {
		$('#new_email').val('');
		$('#confirm_password').val('');
	});
	
	setDropdownList('#prefix');


	$('#photo').change(function(){
		var msg = '';
		var elem_preview = $(this).data('elem-preview');
		var elem_label = $(this).data('elem-label');
		if(this.value == ''){
			msg = 'กรุณาเลือกไฟล์ที่ต้องการอัพโหลด';
		}else{
			msg = this.value;
			previewPicture(this, '#' + elem_preview);
		}
		$('#' + elem_label).val(msg);
	});
	
	setDatePicker('#birthday', {
		yearRange : "-100:+0"
	});
	
	setDatePicker('.datepicker');

});//ready