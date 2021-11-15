
var Pob = {

	current_page : 0,
	current_path : '',

	// load preview to modal
	loadPreview: function(id){
		$.ajax({
			method: 'GET',
			url: site_url('ceosofts/pob/preview/'+ id),
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
		var frm_action = site_url('ceosofts/pob/save');
		var obj = $('#btnConfirmSave');
		if(loading_on(obj) == true){


			var pob_price = removeComma($('#pob_price').val());
			$('#pob_price').val(pob_price);

			var frm_data = $('#formAdd').serializeObject();
			frm_data[csrf_token_name] = $.cookie(csrf_cookie_name);

			$.ajax({
				method: 'POST',
				url: frm_action,
				dataType: 'json',
				data : frm_data,
				success: function (results) {

					var pob_price = formatNumber($('#pob_price').val(), 2);
					$('#pob_price').val(pob_price);

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

						$('#detail_ref_pob_ref').val(results.pob_ref_encrypt_id);
						$('#detail_pob_ref').val(results.pob_ref_encrypt_id);

						$('#btnGotoEdit').attr('href', site_url('ceosofts/pob/edit/'+ encodeURIComponent(results.encrypt_id)));
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
		var frm_action = site_url('ceosofts/pob/update');

			var pob_price = removeComma($('#pob_price').val());
			$('#pob_price').val(pob_price);

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

					var pob_price = formatNumber($('#pob_price').val(), 2);
					$('#pob_price').val(pob_price);

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
					$('#btnGotoEdit').attr('href', site_url('ceosofts/pob/edit/'+ encodeURIComponent(results.encrypt_id)));
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
		var frm_action = site_url('ceosofts/pob/del');
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
						$(window.location).attr('href', site_url(Pob.current_path));
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

	openImportListDialog: function(){
		$('#addImportListModal').modal('show');
	},


	openAddListDialog: function(){
		$('#formAddList').attr('action', site_url('ceosofts/pob/save_detail_list'));
		Pob.resetAddFormList();
		setDropdownList('#detail_pob_pr_id_ref');
		setDropdownList('#detail_pob_name');

		$('#addListModal').modal('show');
	},

	resetAddFormList: function(){
		$('#detail_encrypt_id').val(''); 
		$('#detail_pob_pr_id_ref').val('').attr('value','');
		$('#detail_pob_id').val('').attr('value','');
		$('#detail_pob_name').val('').attr('value','');
		$('#detail_pob_price').val('').attr('value','');
		$('#detail_pob_unit').val('').attr('value','');
		$('#detail_pob_qty').val('').attr('value','');
		$('#detail_pob_remark').val('').attr('value','');


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

					var pob_price = formatNumber($('#pob_price').val(), 2);
					$('#pob_price').val(pob_price);

					if(results.is_successful){
						alert_type = 'success';

						Pob.loadDetailList($('[name="encrypt_id"]').val());

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
		var frm_action = site_url('ceosofts/pob/del_list');
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
					Pob.loadDetailList($('[name="encrypt_id"]').val());
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
			url: site_url('ceosofts/pob/edit_list/'+ url_encrypt_id),
			success: function (json_string) {
				try
				{
					var results = jQuery.parseJSON( json_string );
					if(results.is_successful){
						var data = results.data;
						$('#detail_encrypt_id').val(data.detail_encrypt_id);
						$('#detail_pob_ref').val(data.detail_encrypt_pob_ref);
						$('#detail_pob_pr_id_ref').attr('value', data.detail_record_pob_pr_id_ref);
						$('#detail_pob_pr_id_ref').val(data.detail_record_pob_pr_id_ref);
						$('#detail_pob_id').val(data.detail_record_pob_id);
						$('#detail_pob_name').attr('value', data.detail_record_pob_name);
						$('#detail_pob_name').val(data.detail_record_pob_name);
						$('#detail_pob_price').val(data.detail_record_pob_price);
						$('#detail_pob_unit').val(data.detail_record_pob_unit);
						$('#detail_pob_qty').val(data.detail_record_pob_qty);
						$('#detail_pob_remark').val(data.detail_record_pob_remark);


						$('#addListModal').modal('show');
						$('#formAddList').attr('action', site_url('ceosofts/pob/update_list'));
						setDatePicker('.datepicker');
						setDropdownList('#detail_pob_pr_id_ref');
						setDropdownList('#detail_pob_name');

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

	loadDetailList: function(ref_encrypt_id){ //โหลด detail เพื่อมาแสดง
		$.ajax({
			method: 'GET', //รับข้อมูลชนิด get
			dataType: 'json',
			url: site_url('ceosofts/pob/load_detail/'+ ref_encrypt_id), //อ้างอิงการถอดรหัส
			success: function (results) {
	
				var decoded = $("<div/>").html(results.tbody).text();
				$('#tbody_detail_list').html(decoded); //ส่งข้อมูลไปที่ tbody

				if(results.fx_detail_grand_ราคารวม !== undefined && $('#fx_detail_grand_ราคารวม').length){ //การคำนวนผลรวมราคา
					$('#fx_detail_grand_ราคารวม').html(results.fx_detail_grand_ราคารวม);
				}
			},
			error : function(jqXHR, exception){
				ajaxErrorMessage(jqXHR, exception);
			}
		});
	},

	readExcel: function(){
		var frm_action = site_url('ceosofts/pob/read_excel');
		var obj = $('#btnReadExcel');
		if(loading_on(obj) == true){

			if(!$('#post_iframe_import').attr('id')){
				var iframe = $('<iframe name="post_iframe_import" id="post_iframe_import" style="display: none"></iframe>');
				$("body").append(iframe);
			}

			var form = $('#formImport');

			form.attr("action", frm_action);
			form.attr("method", "post");

			form.attr("encoding", "multipart/form-data");
			form.attr("enctype", "multipart/form-data");

			form.attr("target", "post_iframe_import");

			$('[name="'+ csrf_token_name +'"]').val($.cookie(csrf_cookie_name));

			form.submit();

			var c = 0;
			$("#post_iframe_import").on('load',function() {
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
								notify('การนำเข้าข้อมูล Excel', 'ดำเนินการในขั้นตอนต่อไป', 'info', 'center');
								
								var decoded = $("<div/>").html(results.table_list).text();
								$('#tbody_import_list').html(decoded);
								
								jumpto('#tbody_import_list');
								$('#btnSaveExcel').removeClass('d-none').show();
							}else{
								notify('นำเข้าข้อมูล Excel ผิดพลาด', results.message, 'danger', 'center');
							}

							loading_on_remove(obj);

						}
						catch(err)
						{
							alert('Invalid json : ' + err + "\n\n" + json_string);
							loading_on_remove(obj);
						}
					}else{
						alert('การดำเนินการล้มเหลว กรุณาลองใหม่อีกครั้ง');
						loading_on_remove(obj);
					}
				}
			});
		}
		return false;
	},
	
	saveExcel: function(){
		var frm_action = site_url('ceosofts/pob/save_excel_data');
		var obj = $('#btnSaveExcel');
		if(loading_on(obj) == true){
		
			var frm_data = $('#frmImportList').serializeObject();
			frm_data[csrf_token_name] = $.cookie(csrf_cookie_name);
			
			$.ajax({
				method: 'POST',
				url: frm_action,
				dataType: 'json',
				data : frm_data,
				success: function (results) {

					if(results.is_successful){
						alert_type = 'success';
						goto_page('ceosofts/pob');
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
	},
	
		
	validateSaveExcel: function(){
		var message = '';
		
		
		
		if(message == ''){
			this.saveExcel();
		}else{
			notify('กรุณาตรวจสอบข้อมูล', message, 'danger', 'center', 'bottom');
		}
		return false;
	},
			
	readExcelDetail: function(){
		var frm_action = site_url('ceosofts/pob/read_excel_detail');
		var obj = $('#btnReadExcelDetail');
		if(loading_on(obj) == true){

			if(!$('#post_iframe_import_detail').attr('id')){
				var iframe = $('<iframe name="post_iframe_import_detail" id="post_iframe_import_detail" style="display: none"></iframe>');
				$("body").append(iframe);
			}

			var form = $('#formImportDetail');

			form.attr("action", frm_action);
			form.attr("method", "post");

			form.attr("encoding", "multipart/form-data");
			form.attr("enctype", "multipart/form-data");

			form.attr("target", "post_iframe_import_detail");

			$('[name="'+ csrf_token_name +'"]').val($.cookie(csrf_cookie_name));

			form.submit();

			var c = 0;
			$("#post_iframe_import_detail").on('load',function() {
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
								notify('การนำเข้าข้อมูล Excel', 'ดำเนินการในขั้นตอนต่อไป', 'info', 'center');
								
								var decoded = $("<div/>").html(results.table_list).text();
								$('#tbody_import_list_detail').html(decoded);
								
								jumpto('#tbody_import_list_detail');
								$('#btnSaveExcelDetail').removeClass('d-none').show();
							}else{
								notify('นำเข้าข้อมูล Excel ผิดพลาด', results.message, 'danger', 'center');
							}

							loading_on_remove(obj);

						}
						catch(err)
						{
							alert('Invalid json : ' + err + "\n\n" + json_string);
							loading_on_remove(obj);
						}
					}else{
						alert('การดำเนินการล้มเหลว กรุณาลองใหม่อีกครั้ง');
						loading_on_remove(obj);
					}
				}
			});
		}
		return false;
	},
	
	saveExcelDetail: function(){
		var frm_action = site_url('ceosofts/pob/save_excel_data_detail');
		var obj = $('#btnSaveExcelDetail');
		if(loading_on(obj) == true){
			var frm_data = $('#frmImportListDetail').serializeObject();
			frm_data[csrf_token_name] = $.cookie(csrf_cookie_name);
			
			$.ajax({
				method: 'POST',
				url: frm_action,
				dataType: 'json',
				data : frm_data,
				success: function (results) {

					if(results.is_successful){
						alert_type = 'success';
						$('#addImportListModal').modal('hide');
						Pob.loadDetailList($('[name="encrypt_id"]').val());
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
	},
	
	
	validateSaveExcelDetail: function(){
		var message = '';
		
		if($('#import_detail_pob_ref').val() == ''){
			message += "- ไม่พบรหัสอ้างอิงตารางหลัก <br/>";
		}
		
		
		
		if(message == ''){
			this.saveExcelDetail();
		}else{
			notify('กรุณาตรวจสอบข้อมูล', message, 'danger', 'center', 'bottom');
		}
		return false;
	},
	
}

$(document).ready(function() {
	//On drop-down change

	$(document).on('change','#pob_pr_ref', function(){
		var opt = $(this).find('option[value="'+ $(this).val() +'"]');

		var change_val = opt.attr('data-pr_sup');
		$('#pob_sup').val(change_val).attr('value', change_val);
		setDropdownList('#pob_sup');

		var change_val = opt.attr('data-pr_project_name');
		$('#pob_project_name').val(change_val).attr('value', change_val);

		var change_val = opt.attr('data-pr_price');
		$('#pob_price').val(change_val).attr('value', change_val);
		var pr_ref_id = $(this).val();
		
		$.ajax(
			{
			type: "POST",
			url: "j",
			cache: false,
			data: "name=John&location=Boston",
			success: function(msg){
			  alert( "Data Call : " + msg);
			  $("p").append(msg);
			}
		  });


	});

	$(document).on('change','#set_order_by',function(){
		$('input[name="order_by"]').val($(this).val());
		$('button[name="submit"]').click();
	});

	$(document).on('click', '#btnReadExcel', function() {
		Pob.readExcel();
	});
		
	$(document).on('change', '#FileUpload', function() {
		$('#btnSaveExcel').hide();
		$('#tbody_import_list').html('');
	});
		
	$(document).on('click', '#btnSaveExcel', function() {
		return Pob.validateSaveExcel();
	});
		
	$(document).on('click', '#btnReadExcelDetail', function() {
		Pob.readExcelDetail();
	});
		
	$(document).on('change', '#FileUploadDetail', function() {
		$('#btnSaveExcelDetail').hide();
		$('#tbody_import_list_detail').html('');
	});
		
	$(document).on('click', '#btnSaveExcelDetail', function() {
		return Pob.validateSaveExcelDetail();
	});
		
	$('#FileUpload').change(function(){
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

	$('#FileUploadDetail').change(function(){
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

	$('#editModal').on('shown.bs.modal', function () {
		$('#edit_remark').focus();
	});

	$('#btnSave').click(function() {
		$('#addModal').modal('hide');
		Pob.saveFormData();
		return false;
	});//click

	$('#btnSaveEdit').click(function() {
		return Pob.validateFormEdit();
	});//click

	$(document).on('keypress','#edit_remark',function(e) {
	if(isEnter(e)) {
        return Pob.validateFormEdit();
    }
	});//click

	//List view
	if(typeof param_search_field != 'undefined'){
		$('select[name="search_field"] option[value="'+ param_search_field +'"]').attr('selected','selected');
	}

	if(typeof param_current_page != 'undefined'){
		Pob.current_page = Math.abs(param_current_page);
	}

	if(typeof param_current_path != 'undefined'){
		Pob.current_path = param_current_path;
	}

	$(document).on('click','.btn-delete-row', function(){
		$('.btn-delete-row').removeClass('active_del');
		$(this).addClass('active_del');
		var row_num = $(this).attr('data-row-number');
		var pId = $(this).attr('data-id');

		Pob.confirmDelete(pId,  row_num);
	});//click

	$(document).on('click','#btn_confirm_delete', function(){
		Pob.deleteRecord();
	});

	$(document).on('click','#btnConfirmSaveList', function(){
		Pob.saveDetailList();
		return false;
	});//click
	
	$(document).on('click','.btn-delete-list-row', function(){
		$('.btn-delete-row').removeClass('active_del');
		$(this).addClass('active_del');
		var row_num = $(this).attr('data-row-number');
		var pId = $(this).attr('data-id');

		Pob.confirmDeleteList(pId,  row_num);
	});//click

	$(document).on('click','#btn_confirm_delete_list', function(){
		Pob.deleteRecordList();
	});

	$(document).on('click','#btnAddListDialog', function(){
		Pob.openAddListDialog();
		$('#detail_pob_ref').val($('#detail_ref_pob_ref').val());
	});

	$(document).on('click','#btnImportListDialog', function(){
		Pob.openImportListDialog();
		$('#import_detail_pob_ref').val($('#detail_ref_pob_ref').val());
	});

	$(document).on('click','.btn-preview-list-row', function(){
		var row_num = $(this).attr('data-row-number');
		var pId = $(this).attr('data-id');

		Pob.previewDetailRecord(pId,  row_num);
	});

	$(document).on('click','.btn-edit-list-row', function(){
		var row_num = $(this).data('row-number');
		var url_encrypt_id = $(this).data('url-encrypt-id');
		var pId = $(this).attr('data-id');

		Pob.editDetailRecord(pId,  row_num, url_encrypt_id);
	});

	$(document).on('change','#detail_pob_pr_id_ref',function(){
		$('#detail_pob_name').val($(this).find('option[value="'+$(this).val()+'"]').data('pr_name'));
		$('#detail_pob_id').val($(this).find('option[value="'+$(this).val()+'"]').data('pr_id'));
		$('#detail_pob_price').val($(this).find('option[value="'+$(this).val()+'"]').data('pr_price'));
		$('#detail_pob_unit').val($(this).find('option[value="'+$(this).val()+'"]').data('pr_unit'));
		$('#detail_pob_qty').val($(this).find('option[value="'+$(this).val()+'"]').data('pr_qty'));
		$('#detail_pob_remark').val($(this).find('option[value="'+$(this).val()+'"]').data('pr_remark'));
	});
	$('#detail_pob_name').attr('readonly', true);
	$('#detail_pob_id').attr('readonly', true);
	$('#detail_pob_price').attr('readonly', true);
	$('#detail_pob_unit').attr('readonly', true);
	$('#detail_pob_qty').attr('readonly', true);
	$('#detail_pob_remark').attr('readonly', true);
	$(document).on('change','#detail_pob_name',function(){
		$('#detail_pob_id').val($(this).find('option[value="'+$(this).val()+'"]').data('prb_id'));
		$('#detail_pob_price').val($(this).find('option[value="'+$(this).val()+'"]').data('prb_price'));
		$('#detail_pob_unit').val($(this).find('option[value="'+$(this).val()+'"]').data('prb_unit'));
	});
	$('#detail_pob_id').attr('readonly', true);
	$('#detail_pob_price').attr('readonly', true);
	$('#detail_pob_unit').attr('readonly', true);
	setDropdownList('#pob_pr_ref');
	setDropdownList('#pob_sup');
	setDropdownList('#pob_pay_by');
	setDropdownList('#pob_status');

	//Set default value
	var order_by = $('#set_order_by').attr('value');
	$('#set_order_by option[value="'+order_by+'"]').prop('selected', true);
	
	//Set default selected
	setDatePicker('.datepicker');

	$(document).on('change','#detail_pob_name',function(){
		var val1 = $('#detail_pob_price').val();
		var val2 = $('#detail_pob_qty').val();
		var sum = calculator_value(val1, val2, 'multiply');
		$('#fx_detail_ราคารวม').val(formatNumber(sum)).trigger('change');
	});

	$(document).on('keypress','#detail_pob_name',function(){
		var val1 = $('#detail_pob_price').val();
		var val2 = $('#detail_pob_qty').val();
		var sum = calculator_value(val1, val2, 'multiply');
		$('#fx_detail_ราคารวม').val(formatNumber(sum)).trigger('change');
	});

	$(document).on('keyup','#detail_pob_name',function(){
		var val1 = $('#detail_pob_price').val();
		var val2 = $('#detail_pob_qty').val();
		var sum = calculator_value(val1, val2, 'multiply');
		$('#fx_detail_ราคารวม').val(formatNumber(sum)).trigger('change');
	});

	$(document).on('keypress','#detail_pob_price',function(){
		var val1 = $('#detail_pob_price').val();
		var val2 = $('#detail_pob_qty').val();
		var sum = calculator_value(val1, val2, 'multiply');
		$('#fx_detail_ราคารวม').val(formatNumber(sum)).trigger('change');
	});

	$(document).on('keyup','#detail_pob_price',function(){
		var val1 = $('#detail_pob_price').val();
		var val2 = $('#detail_pob_qty').val();
		var sum = calculator_value(val1, val2, 'multiply');
		$('#fx_detail_ราคารวม').val(formatNumber(sum)).trigger('change');
	});

	$(document).on('change','#detail_pob_price',function(){
		var val1 = $('#detail_pob_price').val();
		var val2 = $('#detail_pob_qty').val();
		var sum = calculator_value(val1, val2, 'multiply');
		$('#fx_detail_ราคารวม').val(formatNumber(sum)).trigger('change');
	});

	$(document).on('keypress','#detail_pob_qty',function(){
		var val1 = $('#detail_pob_price').val();
		var val2 = $('#detail_pob_qty').val();
		var sum = calculator_value(val1, val2, 'multiply');
		$('#fx_detail_ราคารวม').val(formatNumber(sum)).trigger('change');
	});

	$(document).on('keyup','#detail_pob_qty',function(){
		var val1 = $('#detail_pob_price').val();
		var val2 = $('#detail_pob_qty').val();
		var sum = calculator_value(val1, val2, 'multiply');
		$('#fx_detail_ราคารวม').val(formatNumber(sum)).trigger('change');
	});

	$(document).on('change','#detail_pob_qty',function(){
		var val1 = $('#detail_pob_price').val();
		var val2 = $('#detail_pob_qty').val();
		var sum = calculator_value(val1, val2, 'multiply');
		$('#fx_detail_ราคารวม').val(formatNumber(sum)).trigger('change');
	});

	$(document).on('click','.btn[onclick-action]', function(){
		var action_url = site_url('ceosofts/pob/' + $(this).attr('onclick-action'));
		var action_param = $(this).attr('action-param');
		action_param += '&' + csrf_token_name + '=' + $.cookie(csrf_cookie_name);
		var elem = $(this).attr('action-element');
		$.post(action_url, action_param, function( data ) {
			$(elem).html( data );
		});
	});

});
