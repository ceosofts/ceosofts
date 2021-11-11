
var EmployeesSalarySlip = {

	current_page : 0,
	current_path : '',

	// load preview to modal
	loadPreview: function(id){
		$.ajax({
			method: 'GET',
			url: site_url('ceosofts/employees_salary_slip/preview/'+ id),
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
		var frm_action = site_url('ceosofts/employees_salary_slip/save');
		var obj = $('#btnConfirmSave');
		if(loading_on(obj) == true){


			var slip_ems_salary = removeComma($('#slip_ems_salary').val());
			$('#slip_ems_salary').val(slip_ems_salary);

			var slip_ems_ot = removeComma($('#slip_ems_ot').val());
			$('#slip_ems_ot').val(slip_ems_ot);

			var slip_ems_advance = removeComma($('#slip_ems_advance').val());
			$('#slip_ems_advance').val(slip_ems_advance);

			var slip_ems_ss = removeComma($('#slip_ems_ss').val());
			$('#slip_ems_ss').val(slip_ems_ss);

			var slip_ems_absent = removeComma($('#slip_ems_absent').val());
			$('#slip_ems_absent').val(slip_ems_absent);

			var slip_tax = removeComma($('#slip_tax').val());
			$('#slip_tax').val(slip_tax);

			var slip_net = removeComma($('#slip_net').val());
			$('#slip_net').val(slip_net);

			var frm_data = $('#formAdd').serializeObject();
			frm_data[csrf_token_name] = $.cookie(csrf_cookie_name);

			$.ajax({
				method: 'POST',
				url: frm_action,
				dataType: 'json',
				data : frm_data,
				success: function (results) {

					var slip_ems_salary = formatNumber($('#slip_ems_salary').val(), 2);
					$('#slip_ems_salary').val(slip_ems_salary);

					var slip_ems_ot = formatNumber($('#slip_ems_ot').val(), 2);
					$('#slip_ems_ot').val(slip_ems_ot);

					var slip_ems_advance = formatNumber($('#slip_ems_advance').val(), 2);
					$('#slip_ems_advance').val(slip_ems_advance);

					var slip_ems_ss = formatNumber($('#slip_ems_ss').val(), 2);
					$('#slip_ems_ss').val(slip_ems_ss);

					var slip_ems_absent = formatNumber($('#slip_ems_absent').val(), 2);
					$('#slip_ems_absent').val(slip_ems_absent);

					var slip_tax = formatNumber($('#slip_tax').val(), 2);
					$('#slip_tax').val(slip_tax);

					var slip_net = formatNumber($('#slip_net').val(), 2);
					$('#slip_net').val(slip_net);

					if(results.is_successful){
						alert_type = 'success';
					}else{
						alert_type = 'danger';
					}
					notify('เพิ่มข้อมูล', results.message, alert_type, 'center');
					loading_on_remove(obj);

					if(results.is_successful){
						window.location = site_url('ceosofts/employees_salary_slip');
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
		var frm_action = site_url('ceosofts/employees_salary_slip/update');

			var slip_ems_salary = removeComma($('#slip_ems_salary').val());
			$('#slip_ems_salary').val(slip_ems_salary);

			var slip_ems_ot = removeComma($('#slip_ems_ot').val());
			$('#slip_ems_ot').val(slip_ems_ot);

			var slip_ems_advance = removeComma($('#slip_ems_advance').val());
			$('#slip_ems_advance').val(slip_ems_advance);

			var slip_ems_ss = removeComma($('#slip_ems_ss').val());
			$('#slip_ems_ss').val(slip_ems_ss);

			var slip_ems_absent = removeComma($('#slip_ems_absent').val());
			$('#slip_ems_absent').val(slip_ems_absent);

			var slip_tax = removeComma($('#slip_tax').val());
			$('#slip_tax').val(slip_tax);

			var slip_net = removeComma($('#slip_net').val());
			$('#slip_net').val(slip_net);

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

					var slip_ems_salary = formatNumber($('#slip_ems_salary').val(), 2);
					$('#slip_ems_salary').val(slip_ems_salary);

					var slip_ems_ot = formatNumber($('#slip_ems_ot').val(), 2);
					$('#slip_ems_ot').val(slip_ems_ot);

					var slip_ems_advance = formatNumber($('#slip_ems_advance').val(), 2);
					$('#slip_ems_advance').val(slip_ems_advance);

					var slip_ems_ss = formatNumber($('#slip_ems_ss').val(), 2);
					$('#slip_ems_ss').val(slip_ems_ss);

					var slip_ems_absent = formatNumber($('#slip_ems_absent').val(), 2);
					$('#slip_ems_absent').val(slip_ems_absent);

					var slip_tax = formatNumber($('#slip_tax').val(), 2);
					$('#slip_tax').val(slip_tax);

					var slip_net = formatNumber($('#slip_net').val(), 2);
					$('#slip_net').val(slip_net);

				if(results.is_successful){
					alert_type = 'success';
				}else{
					alert_type = 'danger';
				}

				notify('บันทึกข้อมูล', results.message, alert_type, 'center');
				loading_on_remove(obj);

				if(results.is_successful){
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
		var frm_action = site_url('ceosofts/employees_salary_slip/del');
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
						$(window.location).attr('href', site_url(EmployeesSalarySlip.current_path));
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

	readExcel: function(){
		var frm_action = site_url('ceosofts/employees_salary_slip/read_excel');
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
		var frm_action = site_url('ceosofts/employees_salary_slip/save_excel_data');
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
						goto_page('ceosofts/employees_salary_slip');
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
			
}

$(document).ready(function() {
	//On drop-down change

	$(document).on('change','#slip_ems_id', function(){
		var opt = $(this).find('option[value="'+ $(this).val() +'"]');

		var change_val = opt.attr('data-ems_fname');
		$('#slip_ems_fname').val(change_val).attr('value', change_val);

		var change_val = opt.attr('data-ems_lname');
		$('#slip_ems_lname').val(change_val).attr('value', change_val);

		var change_val = opt.attr('data-ems_salary');
		$('#slip_ems_salary').val(change_val).attr('value', change_val);

	});

	$(document).on('change','#set_order_by',function(){
		$('input[name="order_by"]').val($(this).val());
		$('button[name="submit"]').click();
	});

	$(document).on('click', '#btnReadExcel', function() {
		EmployeesSalarySlip.readExcel();
	});
		
	$(document).on('change', '#FileUpload', function() {
		$('#btnSaveExcel').hide();
		$('#tbody_import_list').html('');
	});
		
	$(document).on('click', '#btnSaveExcel', function() {
		return EmployeesSalarySlip.validateSaveExcel();
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

	$('#editModal').on('shown.bs.modal', function () {
		$('#edit_remark').focus();
	});

	$('#btnSave').click(function() {
		$('#addModal').modal('hide');
		EmployeesSalarySlip.saveFormData();
		return false;
	});//click

	$('#btnSaveEdit').click(function() {
		return EmployeesSalarySlip.validateFormEdit();
	});//click

	$(document).on('keypress','#edit_remark',function(e) {
	if(isEnter(e)) {
        return EmployeesSalarySlip.validateFormEdit();
    }
	});//click

	//List view
	if(typeof param_search_field != 'undefined'){
		$('select[name="search_field"] option[value="'+ param_search_field +'"]').attr('selected','selected');
	}

	if(typeof param_current_page != 'undefined'){
		EmployeesSalarySlip.current_page = Math.abs(param_current_page);
	}

	if(typeof param_current_path != 'undefined'){
		EmployeesSalarySlip.current_path = param_current_path;
	}

	$(document).on('click','.btn-delete-row', function(){
		$('.btn-delete-row').removeClass('active_del');
		$(this).addClass('active_del');
		var row_num = $(this).attr('data-row-number');
		var pId = $(this).attr('data-id');

		EmployeesSalarySlip.confirmDelete(pId,  row_num);
	});//click

	$(document).on('click','#btn_confirm_delete', function(){
		EmployeesSalarySlip.deleteRecord();
	});
	setDropdownList('#slip_ems_id');

	//Set default value
	var order_by = $('#set_order_by').attr('value');
	$('#set_order_by option[value="'+order_by+'"]').prop('selected', true);
	
	//Set default selected
	setDatePicker('.datepicker');

	$(document).on('click','.btn[onclick-action]', function(){
		var action_url = site_url('ceosofts/employees_salary_slip/' + $(this).attr('onclick-action'));
		var action_param = $(this).attr('action-param');
		action_param += '&' + csrf_token_name + '=' + $.cookie(csrf_cookie_name);
		var elem = $(this).attr('action-element');
		$.post(action_url, action_param, function( data ) {
			$(elem).html( data );
		});
	});

});
