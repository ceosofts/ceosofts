
var ChequeIn = {

	current_page : 0,
	current_path : '',

	// load preview to modal
	loadPreview: function(id){
		$.ajax({
			method: 'GET',
			url: site_url('ceosofts/cheque_in/preview/'+ id),
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
		var frm_action = site_url('ceosofts/cheque_in/save');
		var obj = $('#btnConfirmSave');
		if(loading_on(obj) == true){

			if(!$('#post_iframe').attr('id')){
				var iframe = $('<iframe name="post_iframe" id="post_iframe" style="display: none"></iframe>');
				$("body").append(iframe);
			}

			var form = $('#formAdd');

			form.attr("action", frm_action);
			form.attr("method", "post");

			form.attr("encoding", "multipart/form-data");
			form.attr("enctype", "multipart/form-data");

			form.attr("target", "post_iframe");

			$('[name="'+ csrf_token_name +'"]').val($.cookie(csrf_cookie_name));


			var chequein_price = removeComma($('#chequein_price').val());
			$('#chequein_price').val(chequein_price);

			form.submit();

			var c = 0;
			$("#post_iframe").on('load',function() {
				c++;
				if(c==1){

					var chequein_price = formatNumber($('#chequein_price').val(), 2);
					$('#chequein_price').val(chequein_price);

					iframeContents = this.contentWindow.document.body.innerHTML;
					var json_string = iframeContents.toString();
					if(json_string != ""){
						json_string = $("<div/>").html(json_string).text();
						try
						{
							var results = jQuery.parseJSON( json_string );
							if(results.is_successful){
								notify('แจ้งเตือน', 'บันทึกข้อมูลหลักเรียบร้อย ดำเนินการในขั้นตอนต่อไป', 'success', 'center');
								$("#frmUploadDetail :input").attr("disabled", false);

							}else{
								notify('เพิ่มข้อมูล', results.message, 'danger', 'center');
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

	saveEditForm: function(){
		$('#editModal').modal('hide');
		var frm_action = site_url('ceosofts/cheque_in/update');

		if(!$('#post_iframe').attr('id')){
			var iframe = $('<iframe name="post_iframe" id="post_iframe" style="display: none"></iframe>');
			$("body").append(iframe);
		}

		var obj = $('#btnSaveEdit');
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

			var chequein_price = removeComma($('#chequein_price').val());
			$('#chequein_price').val(chequein_price);

			form.submit();

			var c = 0;
			$("#post_iframe").on('load',function() {
				c++;
				if(c==1){

					var chequein_price = formatNumber($('#chequein_price').val(), 2);
					$('#chequein_price').val(chequein_price);

					iframeContents = this.contentWindow.document.body.innerHTML;
					var json_string = iframeContents.toString();
					if(json_string != ""){
						json_string = $("<div/>").html(json_string).text();
						try
						{
							var results = jQuery.parseJSON( json_string );
							if(results.is_successful){
								notify('แจ้งเตือน', 'บันทึกข้อมูลหลักเรียบร้อย ดำเนินการในขั้นตอนต่อไป', 'success', 'center');
								$("#frmUploadDetail :input").attr("disabled", false);

							}else{
								notify('เพิ่มข้อมูล', results.message, 'danger', 'center');
							}

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
		return false;
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
		var frm_action = site_url('ceosofts/cheque_in/del');
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
						$(window.location).attr('href', site_url(ChequeIn.current_path));
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

}

$(document).ready(function() {

	$(document).on('change','#set_order_by',function(){
		$('input[name="order_by"]').val($(this).val());
		$('button[name="submit"]').click();
	});

	$('#chequein_photo').change(function(){
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
		ChequeIn.saveFormData();
		return false;
	});//click

	$('#btnSaveEdit').click(function() {
		return ChequeIn.validateFormEdit();
	});//click

	$(document).on('keypress','#edit_remark',function(e) {
	if(isEnter(e)) {
        return ChequeIn.validateFormEdit();
    }
	});//click

	//List view
	if(typeof param_search_field != 'undefined'){
		$('select[name="search_field"] option[value="'+ param_search_field +'"]').attr('selected','selected');
	}

	if(typeof param_current_page != 'undefined'){
		ChequeIn.current_page = Math.abs(param_current_page);
	}

	if(typeof param_current_path != 'undefined'){
		ChequeIn.current_path = param_current_path;
	}

	$(document).on('click','.btn-delete-row', function(){
		$('.btn-delete-row').removeClass('active_del');
		$(this).addClass('active_del');
		var row_num = $(this).attr('data-row-number');
		var pId = $(this).attr('data-id');

		ChequeIn.confirmDelete(pId,  row_num);
	});//click

	$(document).on('click','#btn_confirm_delete', function(){
		ChequeIn.deleteRecord();
	});
	setDropdownList('#chequein_from');
	setDropdownList('#chequein_bookbank');
	setDropdownList('#chequein_status');

	//Set default value
	var order_by = $('#set_order_by').attr('value');
	$('#set_order_by option[value="'+order_by+'"]').prop('selected', true);
	
	//Set default selected
	setDatePicker('.datepicker');

	$(document).on('click','.btn[onclick-action]', function(){
		var action_url = site_url('ceosofts/cheque_in/' + $(this).attr('onclick-action'));
		var action_param = $(this).attr('action-param');
		action_param += '&' + csrf_token_name + '=' + $.cookie(csrf_cookie_name);
		var elem = $(this).attr('action-element');
		$.post(action_url, action_param, function( data ) {
			$(elem).html( data );
		});
	});

});
