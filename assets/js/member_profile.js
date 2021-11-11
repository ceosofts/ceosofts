
var Profile = {

	current_page : 0,
	
	validateFormEdit: function(){
		if($('#edit_remark').val().length < 5){
			notify('กรุณาระบุเหตุผล', 'เหตุผลการแก้ไขจะต้องระบุให้ชัดเจน', 'warning', 'center', 'bottom');
		}else{
			this.saveEditForm();
		}
		return false;
	},

	saveEditForm: function(){
		$('#editModal').modal('hide');
		var frm_action = site_url('member_profile/update');
		var fdata = $('#formEdit').serialize();
		fdata += '&edit_remark=' + $('#edit_remark').val();
		fdata += '&' + csrf_token_name + '=' + $.cookie(csrf_cookie_name);

		var obj = $('#btnSaveEdit');
		loading_on(obj);
		$.ajax({
			method: 'POST',
			url: frm_action,
			dataType: 'json',
			data : fdata,
			success: function (results) {
				if(results.is_successful){
					alert_type = 'success';
				}else{
					alert_type = 'danger';
				}
				notify('บันทึกข้อมูล', results.message, alert_type, 'center');
				loading_on_remove(obj);
			},
			error : function(jqXHR, exception){
				ajaxErrorMessage(jqXHR, exception);
				loading_on_remove(obj);
			}
		});
	}
}

$(document).ready(function() {

	$('#btnSaveEdit').click(function() {
		return Profile.validateFormEdit();
	});//click

	if(typeof param_current_page != 'undefined'){
		Profile.current_page = Math.abs(param_current_page);
	}

});//ready