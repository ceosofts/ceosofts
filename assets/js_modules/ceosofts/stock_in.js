
var StockIn = {

	current_page : 0,
	current_path : '',

	// load preview to modal
	loadPreview: function(id){
		$.ajax({
			method: 'GET',
			url: site_url('ceosofts/stock_in/preview/'+ id),
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
		var frm_action = site_url('ceosofts/stock_in/save');
		var obj = $('#btnConfirmSave');
		if(loading_on(obj) == true){


			var frm_data = $('#formAdd').serializeObject();
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
					notify('เพิ่มข้อมูล', results.message, alert_type, 'center');
					loading_on_remove(obj);

					if(results.is_successful){
						$("#frmUploadDetail").attr('title', '');
						$("#frmUploadDetail").css('background-color', '');
						$('#btnConfirmSave').removeClass('btn-primary ').addClass('btn-light success-save');
						$('#add_encrypt_id').val(results.encrypt_id);

						$('#detail_ref_sti_ref').val(results.sti_ref_encrypt_id);
						$('#detail_sti_ref').val(results.sti_ref_encrypt_id);

						$('#btnGotoEdit').attr('href', site_url('ceosofts/stock_in/edit/'+ encodeURIComponent(results.encrypt_id)));
						$('#btnGotoEdit, #btnAddListDialog, #btnImportListDialog').show();

						$('#btnConfirmSave').hide().removeClass('btn-primary ').addClass('btn-light success-save');
					}
				},
				error : function(jqXHR, exception){
					ajaxErrorMessage(jqXHR, exception);
						loading_on_remove(obj);
				}
			});
		}
		return false;
	},

	saveEditForm: function(){
		$('#editModal').modal('hide');
		var frm_action = site_url('ceosofts/stock_in/update');

		var frm_data = $('#formEdit').serializeObject();
		frm_data['edit_remark'] = $('#edit_remark').val();
		frm_data[csrf_token_name] = $.cookie(csrf_cookie_name);

		var obj = $('#btnSaveEdit');
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

				notify('บันทึกข้อมูล', results.message, alert_type, 'center');
				loading_on_remove(obj);

				if(results.is_successful){
					$("#frmUploadDetail").attr('title', '');
					$("#frmUploadDetail").css('background-color', '');
					$('#btnConfirmSave').removeClass('btn-primary ').addClass('btn-light success-save');
					$('#add_encrypt_id').val(results.encrypt_id);
					$('#btnGotoEdit').attr('href', site_url('ceosofts/stock_in/edit/'+ encodeURIComponent(results.encrypt_id)));
					$('#btnGotoEdit, #btnAddListDialog, #btnImportListDialog').show();

					$('#btnConfirmSave').hide().removeClass('btn-primary ').addClass('btn-light success-save');
				}
			},
			error : function(jqXHR, exception){
				ajaxErrorMessage(jqXHR, exception);
				loading_on_remove(obj);
			}
		});
	},

	confirmDelete: function (pId,  irow){
		$('[name="encrypt_id"]').val(pId);

		$('#xrow').text('['+ irow +']');
		var my_thead = $('#row_' + irow).closest('table').find('th:not(:first-child):not(:last-child)');
		var th = [];
		my_thead.each (function(index) {
			th.push($(this).text());
		});

		var active_row = $('#row_' + irow).find('td:not(:first-child):not(:last-child)');
		var detail = '<table class="table table-striped">';
		active_row.each (function(index) {
				detail += '<tr><td align="right"><b>' + th[index] + ' : </b></td><td> ' + $(this).html() + '</td></tr>';
		});
		detail += '</table>';
		$('#div_del_detail').html(detail);

		$('#confirmDelModal').modal('show');
	},

	// delete by ajax jquery
	deleteRecord: function(){
		var frm_action = site_url('ceosofts/stock_in/del');
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
						$(window.location).attr('href', site_url(StockIn.current_path));
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


	openAddListDialog: function(){
		$('#formAddList').attr('action', site_url('ceosofts/stock_in/save_detail_list'));
		StockIn.resetAddFormList();
		setDropdownList('#detail_sti_name');

		$('#addListModal').modal('show');
	},

	resetAddFormList: function(){
		$('#detail_encrypt_id').val(''); 
		$('#detail_sti_id').val('').attr('value','');
		$('#detail_sti_name').val('').attr('value','');
		$('#detail_sti_unit').val('').attr('value','');
		$('#detail_sti_qty').val('').attr('value','');
		$('#detail_sti_remark').val('').attr('value','');


	},

	saveDetailList: function(){
		var obj = $('#btnConfirmSaveList');
		if(loading_on(obj) == true){

		var frm_action = $('#formAddList').attr('action');
		var frm_data = $('#formAddList').serializeObject();
		frm_data[csrf_token_name] = $.cookie(csrf_cookie_name);

			$.ajax({
				method: 'POST',
				url: frm_action,
				dataType: 'json',
				data : frm_data,
				success: function (results) {

					if(results.is_successful){
						alert_type = 'success';

						StockIn.loadDetailList($('[name="encrypt_id"]').val());

						$('#formAddList')[0].reset();
						$('#addListModal').modal('hide');
					}else{
						alert_type = 'danger';
					}
					notify('เพิ่มรายการ', results.message, alert_type, 'center');
					loading_on_remove(obj);
				},
				error : function(jqXHR, exception){
					ajaxErrorMessage(jqXHR, exception);
					loading_on_remove(obj);
				}
			});
		}
		return false;
	},

	confirmDeleteList: function (pId,  irow){
		$('#detail_del_encrypt_id').val(pId);

		$('#xrow').text('['+ irow +']');
		var my_thead = $('#list_row_' + irow).closest('table').find('th:not(:first-child):not(:last-child)');
		var th = [];
		my_thead.each (function(index) {
			th.push($(this).text());
		});

		var active_row = $('#list_row_' + irow).find('td:not(:first-child):not(:last-child)');
		var detail = '<table class="table table-striped">';
		active_row.each (function(index) {
				detail += '<tr><td align="right"><b>' + th[index] + ' : </b></td><td> ' + $(this).html() + '</td></tr>';
		});
		detail += '</table>';
		$('#div_del_list_detail').html(detail);

		$('#confirmDelListModal').modal('show');
	},

	// delete by ajax jquery
	deleteRecordList: function(){
		var frm_action = site_url('ceosofts/stock_in/del_list');
		var frm_data = $('#formDeleteList').serialize();
		frm_data += '&' + csrf_token_name + '=' + $.cookie(csrf_cookie_name);
		var obj = $('#btn_confirm_delete_list');
		loading_on(obj);
		$.ajax({
			method: 'POST',
			url: frm_action,
			dataType: 'json',
			data : frm_data,
			success: function (results) {
				if(results.is_successful){
					alert_type = 'success';
					$('#confirmDelListModal').modal('hide');
					StockIn.loadDetailList($('[name="encrypt_id"]').val());
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

	previewDetailRecord: function (pId,  irow){
		$('[name="encrypt_id"]').val(pId);

		$('#detailPreviewModal').modal('show');
	},

	editDetailRecord: function (pId,  irow, url_encrypt_id){
		$('#formAddList')[0].reset();
		$.ajax({
			method: 'GET',
			url: site_url('ceosofts/stock_in/edit_list/'+ url_encrypt_id),
			success: function (json_string) {
				try
				{
					var results = jQuery.parseJSON( json_string );
					if(results.is_successful){
						var data = results.data;
						$('#detail_encrypt_id').val(data.detail_encrypt_id);
						$('#detail_sti_ref').val(data.detail_encrypt_sti_ref);
						$('#detail_sti_id').val(data.detail_record_sti_id);
						$('#detail_sti_name').attr('value', data.detail_record_sti_name);
						$('#detail_sti_name').val(data.detail_record_sti_name);
						$('#detail_sti_unit').val(data.detail_record_sti_unit);
						$('#detail_sti_qty').val(data.detail_record_sti_qty);
						$('#detail_sti_remark').val(data.detail_record_sti_remark);


						$('#addListModal').modal('show');
						$('#formAddList').attr('action', site_url('ceosofts/stock_in/update_list'));
						setDatePicker('.datepicker');
						setDropdownList('#detail_sti_name');

					}
				}
				catch(err)
				{
					alert('Invalid json : ' + err + "\n\n" + json_string);
				}
			},
			error : function(jqXHR, exception){
				ajaxErrorMessage(jqXHR, exception);
			}
		});
	},

	loadDetailList: function(ref_encrypt_id){
		$.ajax({
			method: 'GET',
			dataType: 'json',
			url: site_url('ceosofts/stock_in/load_detail/'+ ref_encrypt_id),
			success: function (results) {
	
				var decoded = $("<div/>").html(results.tbody).text();
				$('#tbody_detail_list').html(decoded);
			},
			error : function(jqXHR, exception){
				ajaxErrorMessage(jqXHR, exception);
			}
		});
	},

}

$(document).ready(function() {

	$(document).on('change','#set_order_by',function(){
		$('input[name="order_by"]').val($(this).val());
		$('button[name="submit"]').click();
	});

	$('#editModal').on('shown.bs.modal', function () {
		$('#edit_remark').focus();
	});

	$('#btnSave').click(function() {
		$('#addModal').modal('hide');
		StockIn.saveFormData();
		return false;
	});//click

	$('#btnSaveEdit').click(function() {
		return StockIn.validateFormEdit();
	});//click

	$(document).on('keypress','#edit_remark',function(e) {
	if(isEnter(e)) {
        return StockIn.validateFormEdit();
    }
	});//click

	//List view
	if(typeof param_search_field != 'undefined'){
		$('select[name="search_field"] option[value="'+ param_search_field +'"]').attr('selected','selected');
	}

	if(typeof param_current_page != 'undefined'){
		StockIn.current_page = Math.abs(param_current_page);
	}

	if(typeof param_current_path != 'undefined'){
		StockIn.current_path = param_current_path;
	}

	$(document).on('click','.btn-delete-row', function(){
		$('.btn-delete-row').removeClass('active_del');
		$(this).addClass('active_del');
		var row_num = $(this).attr('data-row-number');
		var pId = $(this).attr('data-id');

		StockIn.confirmDelete(pId,  row_num);
	});//click

	$(document).on('click','#btn_confirm_delete', function(){
		StockIn.deleteRecord();
	});

	$(document).on('click','#btnConfirmSaveList', function(){
		StockIn.saveDetailList();
		return false;
	});//click
	
	$(document).on('click','.btn-delete-list-row', function(){
		$('.btn-delete-row').removeClass('active_del');
		$(this).addClass('active_del');
		var row_num = $(this).attr('data-row-number');
		var pId = $(this).attr('data-id');

		StockIn.confirmDeleteList(pId,  row_num);
	});//click

	$(document).on('click','#btn_confirm_delete_list', function(){
		StockIn.deleteRecordList();
	});

	$(document).on('click','#btnAddListDialog', function(){
		StockIn.openAddListDialog();
		$('#detail_sti_ref').val($('#detail_ref_sti_ref').val());
	});

	$(document).on('click','.btn-preview-list-row', function(){
		var row_num = $(this).attr('data-row-number');
		var pId = $(this).attr('data-id');

		StockIn.previewDetailRecord(pId,  row_num);
	});

	$(document).on('click','.btn-edit-list-row', function(){
		var row_num = $(this).data('row-number');
		var url_encrypt_id = $(this).data('url-encrypt-id');
		var pId = $(this).attr('data-id');

		StockIn.editDetailRecord(pId,  row_num, url_encrypt_id);
	});

	$(document).on('change','#detail_sti_name',function(){
		$('#detail_sti_id').val($(this).find('option[value="'+$(this).val()+'"]').data('prb_id'));
		$('#detail_sti_unit').val($(this).find('option[value="'+$(this).val()+'"]').data('prb_unit'));
	});
	$('#detail_sti_id').attr('readonly', true);
	$('#detail_sti_unit').attr('readonly', true);
	setDropdownList('#sti_sup');
	setDropdownList('#sti_project_name');

	//Set default value
	var order_by = $('#set_order_by').attr('value');
	$('#set_order_by option[value="'+order_by+'"]').prop('selected', true);
	
	//Set default selected
	setDatePicker('.datepicker');

	$(document).on('click','.btn[onclick-action]', function(){
		var action_url = site_url('ceosofts/stock_in/' + $(this).attr('onclick-action'));
		var action_param = $(this).attr('action-param');
		action_param += '&' + csrf_token_name + '=' + $.cookie(csrf_cookie_name);
		var elem = $(this).attr('action-element');
		$.post(action_url, action_param, function( data ) {
			$(elem).html( data );
		});
	});

});
