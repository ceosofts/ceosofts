
var Members = {

	current_page : 0,

	confirmDelete: function (pUserid,  irow){
		$('[name="encrypt_userid"]').val(pUserid);

		$('#xrow').text(irow);
		var my_thead = $('#row_' + irow).closest('table').find('th:not(:first-child):not(:last-child)');
		var th = [];
		my_thead.each (function(index) {
			th.push($(this).text());
		});
		
		var active_row = $('#row_' + irow).find('td:not(:first-child):not(:last-child)');
		var detail = '<table class="table table-striped">';
		active_row.each (function(index) {
				detail += '<tr><td align="right"><b>' + th[index] + ' : </b></td><td> ' + $(this).text() + '</td></tr>';
		});
		detail += '</table>';
		$('#div_del_detail').html(detail);

		$('#confirmDelModal').modal('show');
	},
    
	// delete by ajax jquery 
	deleteRecord: function(){
		var frm_action = site_url('member/management/del'); 
		var frm_data = $('#formDelete').serialize();
		frm_data += '&' + csrf_token_name + '=' + $.cookie(csrf_cookie_name);
		var obj = $('#btn_confirm_delete');
		loading_on(obj);
		$.ajax({
			method: 'POST',
			url: frm_action,
			dataType: 'json',
			data : frm_data,
			success: function (results) {
				if(results.is_successful){
					alert_type = 'success';
					setTimeout(function(){ 
						$(window.location).attr('href', site_url('member/management/index/'+ this.current_page));
					}, 500);
				}else{
					alert_type = 'danger';
				}
				notify('ลบรายการ', results.message, alert_type, 'center');
				loading_on_remove(obj);
			},
				error : function(jqXHR, exception){
				loading_on_remove(obj);
				ajaxErrorMessage(jqXHR, exception);
			}
		});
	},

	// load preview to modal 
	loadPreview: function(id){ 
		$.ajax({
			method: 'GET',
			url: site_url('member/management/preview/'+ id),
			success: function (results) {
				$('#divPreview').html(results);
			},
			error : function(jqXHR, exception){
				ajaxErrorMessage(jqXHR, exception);
			}
		});
		$('#modalPreview').modal('show');
	},
	
	validateFormEdit: function(){
		if($('#edit_remark').val().length < 5){
				notify('กรุณาระบุเหตุผล', 'เหตุผลการแก้ไขจะต้องระบุให้ชัดเจน', 'warning', 'center', 'bottom');
		}else{
				this.saveEditForm();
		}
		return false;
	},

	saveFormData: function(){
		var frm_action = site_url('member/management/save');
		var frm_data = $('#formAdd').serialize();
		frm_data += '&' + csrf_token_name + '=' + $.cookie(csrf_cookie_name);

		var obj = $('#btnConfirmSave');
		loading_on(obj);		
		$.ajax({
			method: 'POST',
			url: frm_action,
			dataType: 'json',
			data : frm_data,
			success: function (results) {
				if(results.is_successful){
					alert_type = 'success';
					$('#formAdd')[0].reset();
				}else{
					alert_type = 'danger';
				}
					notify('เพิ่มข้อมูล', results.message, alert_type, 'center');
					loading_on_remove(obj);
				},
			error : function(jqXHR, exception){
				ajaxErrorMessage(jqXHR, exception);
					loading_on_remove(obj);
			}
		});
	},

	saveEditForm: function(){
		$('#editModal').modal('hide');
		var frm_action = site_url('member/management/update');
		
		if(!$('#post_iframe').attr('id')){
			var iframe = $('<iframe name="post_iframe" id="post_iframe" style="display: none"></iframe>');
			$("body").append(iframe);
		}
		
		
		var frm_data = $('#formEdit').serialize();
		frm_data += '&edit_remark=' + $('#edit_remark').val();
		frm_data += '&' + csrf_token_name + '=' + $.cookie(csrf_cookie_name);

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
	
	passwordReset : function(){
		var new_pass1, new_pass2, reset_pass_remark, adminPassword, err_message;
		new_pass1 = $('#password1').val();
		new_pass2 = $('#password2').val();
		adminPassword = $('#adminPassword').val();
		
		reset_pass_remark = $('#reset_pass_remark').val();
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
		if(adminPassword == ''){
			err_message += '<br/>- กรุณากรอกรหัสผ่านแอดมินผู้แก้ไข';
		}
		if(reset_pass_remark == ''){
			err_message += '<br/>- กรุณาระบุเหตุผล';
		}
		
		if(err_message != ''){
			notify("ตรวจสอบข้อมูล", err_message, 'danger', 'center');
			return false;
		}

		var frm_action = site_url('member/management/reset_password');
		
		var frm_data = $('#formResetMemberPass').serialize();
		frm_data += '&encrypt_userid=' + $('[name=encrypt_userid]').val();
		frm_data += '&edit_remark=' + $('#reset_pass_remark').val();
		frm_data += '&' + csrf_token_name + '=' + $.cookie(csrf_cookie_name);
		var obj = $('#btn_reset_pass');
		loading_on(obj);
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
				notify('เปลี่ยนแปลงรหัสผ่าน', results.message, alert_type, 'center');
				loading_on_remove(obj);
				
				if(alert_type == 'success'){
					$('#formResetMemberPass button').button('reset');
					$('#modal_reset_member_pass').modal('hide');
				}
			},
			error : function(jqXHR, exception){
				ajaxErrorMessage(jqXHR, exception);
				loading_on_remove(obj);
			}
		});
	},
	
	enablePasswordReset : function(){
		$('#password').attr('readonly', false).select();
		$('#password').data('old-pass', $('#password').val());
	},
	
	disablePasswordReset : function(){
		$('#password').attr('readonly', true);
		$('#password').val($('#password').data('old-pass'));
	}
}

$(document).ready(function() {
	
	$(document).on('change','#set_order_by',function(){
		$('input[name="order_by"]').val($(this).val());
		$('button[name="submit"]').click();
	});
	
	//Set default value
	var order_by = $('#set_order_by').attr('value');
	$('#set_order_by option[value="'+order_by+'"]').prop('selected', true);
	
	$('#btnSave').click(function() {            
		$('#addModal').modal('hide');
		Members.saveFormData();
		return false;            
	});//click

	$('#btnSaveEdit').click(function() {            
		return Members.validateFormEdit();
	});//click

	//List view
	if(typeof param_search_field != 'undefined'){
		$('select[name="search_field"] option[value="'+ param_search_field +'"]').attr('selected','selected');
	}

	if(typeof param_current_page != 'undefined'){
		Members.current_page = Math.abs(param_current_page);
	}

	$('.btn-delete-row').click(function() {
		$('.btn-delete-row').removeClass('active_del');
		$(this).addClass('active_del');
		var row_num = $(this).attr('data-row-number');
		var pUserid = $(this).attr('data-userid');

		Members.confirmDelete(pUserid,  row_num);
	});//click

	$('#btn_confirm_delete').click(function(){
		Members.deleteRecord();
	});
	
	$('#chk_reset_pass').click(function(){
		if ($(this).is(':checked')) {
			Members.enablePasswordReset();
		}else{
			Members.disablePasswordReset();
		}
	});
	
	$('#btn_reset_pass').click(function(){
		Members.passwordReset();
	});

	/*
	$('#department_id').select2({
		dropdownAutoWidth : true,
		width: 'auto'
	});
	var department_id = $('#department_id').attr('value');
	$('#department_id').val('').val(department_id).trigger('change');
	*/
	setDropdownList('#department_id');
	
	/*
	$('#level').select2({
		dropdownAutoWidth : true,
		width: 'auto'
	});
	var level = $('#level').attr('value');
	$('#level').val('').val(level).trigger('change');
	*/
	setDropdownList('#level');
	
	setDropdownList('#void');
	
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
});//ready