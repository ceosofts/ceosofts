function checkMainField(){
	$('#layer_show_link').text('').hide();
	var msg = '';
	if($('#txt_agree_value').val() == 'NO'){
		msg += '<p class="alert alert-warning">กรุณาอ่าน <a href="' + site_url('ci_readme') + '">ข้อตกลกและทำความเข้าใจก่อนใช้งานโปรแกรม</a></p>';
	}else{
		if($('[name^="field_pk_all["]').length < 1){
			msg += '<p class="alert alert-danger">ตารางที่เลือกจะต้องกำหนด Primary Key จึงจะสามารถใช้งานระบบนี้ได้</p>';
		}
	}
	return msg;
}

function loadMain(){
	if(!$('#myTab').attr('id')){
		window.location = site_url('');
	}
}

function getFormData(){
	//return status
	var elemTarget = $('.selectpicker:disabled');
	elemTarget.addClass('set_status');
	elemTarget.prop('disabled', false);

	var frm_data = $('#form_table_master_list').serializeObject();
	var frm_data2 = $('#table_field_master').serializeObject();
	var frm_data3 = $('#table_field_detail').serializeObject();
	// Merge object2 into object1, recursively
	$.extend( true, frm_data, frm_data2, frm_data3 );

	frm_data['table'] = $('#tableNameNow').val();
	frm_data['controller_name'] = $('#controller_name').val();
	frm_data['model_name'] = $('#model_name').val();
	frm_data['module_name'] = $('#module_name').val();
	frm_data['path_name'] = $('#path_name').val();
	frm_data['login_require'] = $('#login_require:checked').val();
	frm_data[csrf_token_name] = $.cookie(csrf_cookie_name);

	//set again
	$('.selectpicker.set_status').prop('disabled', true);
	$('.selectpicker.set_status').removeClass('set_status');

	return frm_data;
}

function loadField(table) {
	if(!table){
		table = $('#tableNameNow').val();
	}
	clearDivAll();
	$('#myTab a:first').tab('show');
	$('#showTableName').text(table);
	$('#tableNameNow').val(table);

	if ($('#tableNameNow').val() == '') {
		$('#fieldsContent').html("<p class='alert alert-warning'>เลือกตารางด้วยครับ</p>");
		return false;
	}

	var fdata = {
		table: table
	};
	fdata[csrf_token_name] = $.cookie(csrf_cookie_name);

	$.ajax({
	  	url: site_url('ci_dashboard/loadField'),
	  	method: "POST",
	  	data: fdata,
	  	success : function(result){
			$("#fieldsContent").html(result);
			$('select').select2({
				dropdownAutoWidth : true,
				width: '100%'
			});
		},
		error : function(jqXHR, exception){
			ajaxErrorMessage(jqXHR, exception, $("#fieldsContent"));
		}
	});
}

function loadController() {
		
	var fdata = getFormData();
	fdata['per_page'] = $('#per_page').val(); 
	
	clearDivAll();

	if ($('#tableNameNow').val() == '') {
		$('#controllerContent').html("<p  class='alert alert-warning'>เลือกตารางด้วยครับ</p>");
		return false;
	}
	
	if ($('#module_name').val() == '') {
		$('#controllerContent').html("<p  class='alert alert-warning'>กรุณาระบุ Module & Path ด้วยครับ</p>");
		return false;
	}
	
	var errMsg = checkMainField();
	if (errMsg != '') {
		$('#controllerContent').html("<p style='color:red'>" + errMsg + "</p>");
		return false;
	}
	
	$.ajax({
	  	url: site_url('ci_dashboard/loadController'),
	  	method: "POST",
	  	data: fdata,
		dataType : 'json',
		success : function(result){
			$("#controllerContent").html(result.content);
			$('#btn_create_controller').html(result.button).fadeIn();
			PR.prettyPrint();
		},
		error : function(jqXHR, exception){
			ajaxErrorMessage(jqXHR, exception, $("#controllerContent"));
		}
	});
}

function createController() {
	var fdata = getFormData();
		fdata['per_page'] = $('#per_page').val(); 
	$.post(site_url('ci_dashboard/createController'), fdata, function( data ) {
		$( "#layer_show_link" ).html( data ).show();
	});
}

function loadModel() {
	clearDivAll();

	if ($('#tableNameNow').val() == '') {
		$('#modelContent').html("<p class='alert alert-warning'>เลือกตารางด้วยครับ</p>");
		return false;
	}
	
	if ($('#module_name').val() == '') {
		$('#modelContent').html("<p  class='alert alert-warning'>กรุณาระบุ Module & Path ด้วยครับ</p>");
		return false;
	}

	var errMsg = checkMainField();
	if (errMsg != '') {
		$('#modelContent').html("<p style='color:red'>" + errMsg + "</p>");
		return false;
	}

	var fdata = getFormData();

	$.ajax({
	  	url: site_url('ci_dashboard/loadModel'),
	  	method: "POST",
	  	data: fdata,
		dataType : 'json',
		success : function(result){
			$("#modelContent").html(result.content);
			$('#btn_create_model').html(result.button).fadeIn();
			PR.prettyPrint();
		},
		error : function(jqXHR, exception){
			ajaxErrorMessage(jqXHR, exception);
		}
	});

}

function createModel() {
	var fdata = getFormData();
	$.post(site_url('ci_dashboard/createModel'), fdata, function( data ) {
	  $( "#layer_show_link" ).html( data ).show();
	});
}

function loadTemplates(template) {
	clearDivAll();
		
	$('#templates ul.nav li.nav-item a').removeClass('active');
	
	if ($('#tableNameNow').val() == '') {
		$('#templatesContent').html("<p class='alert alert-warning'>เลือกตารางด้วยครับ</p>");
		return false;
	}
	
	var errMsg = checkMainField();
	if (errMsg != '') {
		$('#templatesContent').html("<p style='color:red'>" + errMsg + "</p>");
		return false;
	}

	var fdata = getFormData();

	if(!template){
		template = '';
	}
	fdata['template'] = template;

	$('#tab-templates').data('template-name', template);
	if(template != ''){
		$('#'+template).addClass('active');
	}else{
		$('#templates ul.nav li.nav-item a:first').addClass('active');
	}
	

	$.ajax({
	  	url: site_url('ci_dashboard/loadTemplates'),
	  	method: "POST",
	  	data: fdata,
		dataType : 'json',
		success : function(result){
			$("#templatesContent").html(result.content);
			$('#btn_create_template').html(result.button).fadeIn();
			$('#template_name').val(template);
			PR.prettyPrint();
		},
		error : function(jqXHR, exception){
			ajaxErrorMessage(jqXHR, exception);
		}
	});
}

function createTemplates() {
	var fdata = getFormData();
	fdata['template'] = $('#template_name').val();
	$.post(site_url('ci_dashboard/createViewTemplates'), fdata, function( data ) {
	  $( "#layer_show_link" ).html( data ).show();
	});
}

function hideCreateButton(){
	$('.btn_create').hide();
}

function clearDivAll() {
	$('#controllerContent').text('');
	$('#modelContent').text('');
	$('#templatesContent').text('');
	$('#viewContent').text('');
	$('#viewSetting').text('').hide();
	$('#layer_show_link').text('').hide();
}

//----------------------- View -----------------------------------

function clearView() {
	$('#viewContent').text('');
}


function loadViewList() {
	clearDivAll();
	$('#list_view_tab li a.active').removeClass('active');
	$('#li_all a').addClass('active');
	
	if ($('#tableNameNow').val() == '') {
		$('#viewContent').html("<p class='alert alert-warning'>เลือกตารางด้วยครับ</p>");
		return false;
	}
	
	if ($('#module_name').val() == '') {
		$('#viewContent').html("<p  class='alert alert-warning'>กรุณาระบุ Module & Path ด้วยครับ</p>");
		return false;
	}

	var errMsg = checkMainField();
	if (errMsg != '') {
		$('#viewContent').html("<p style='color:red'>" + errMsg + "</p>");
		return false;
	}

	var fdata = getFormData();

	$.ajax({
		url: site_url('ci_dashboard/loadViewList'),
		method: "POST",
		data: fdata,
		dataType : 'json',
		success : function(result){
			$("#viewContent").html(result.content);
			$('#btn_create_view').html(result.button).fadeIn();
			PR.prettyPrint();
			setViewMode('html');			
			$('#viewSetting').html(result.setting).show();
			
			var value_select = $( "#column_order_by").data('item-selected');
			var val = value_select.split(",");
			$('#column_order_by').val(val);
			$( "#column_order_by").select2({
				dropdownAutoWidth : true, width: '70%'
			});
		},
		error : function(jqXHR, exception){
			ajaxErrorMessage(jqXHR, exception);
		}
	});
}

function createViewList() {
	var fdata = getFormData();
	fdata['show_file_path'] = $('#view_list_path').text();
	$.post(site_url('ci_dashboard/createViewList'), fdata, function( data ) {
	  $( "#layer_show_link" ).html( data ).show();
	});
}

function loadViewAddnew() {
	clearDivAll();
	if ($('#tableNameNow').val() == '') {
		$('#viewContent').html("<p class='alert alert-warning'>เลือกตารางด้วยครับ</p>");
		return false;
	}
	
	if ($('#module_name').val() == '') {
		$('#viewContent').html("<p  class='alert alert-warning'>กรุณาระบุ Module & Path ด้วยครับ</p>");
		return false;
	}

	var errMsg = checkMainField();
	if (errMsg != '') {
		$('#viewContent').html("<p style='color:red'>" + errMsg + "</p>");
		return false;
	}

	var fdata = getFormData();

	$.ajax({
	  	url: site_url('ci_dashboard/loadViewAddnew'),
	  	method: "POST",
	  	data: fdata,
		dataType : 'json',
		success : function(result){
			$("#viewContent").html(result.content);
			$('#btn_create_view').html(result.button).fadeIn();
			PR.prettyPrint();
			setViewMode('html');
		},
		error : function(jqXHR, exception){
			ajaxErrorMessage(jqXHR, exception);
		}
	});
}
function createViewAddnew() {
	var fdata = getFormData();
	fdata['show_file_path'] = $('#view_add_path').text();
	$.post(site_url('ci_dashboard/createViewAdd'), fdata, function( data ) {
	  $( "#layer_show_link" ).html( data ).show();
	});
}

function loadViewEdit() {
	clearDivAll();
	if ($('#tableNameNow').val() == '') {
		$('#viewContent').html("<p class='alert alert-warning'>เลือกตารางด้วยครับ</p>");
		return false;
	}
	
	if ($('#module_name').val() == '') {
		$('#viewContent').html("<p  class='alert alert-warning'>กรุณาระบุ Module & Path ด้วยครับ</p>");
		return false;
	}

	var errMsg = checkMainField();
	if (errMsg != '') {
		$('#viewContent').html("<p style='color:red'>" + errMsg + "</p>");
		return false;
	}

	var fdata = getFormData();

	$.ajax({
	  	url: site_url('ci_dashboard/loadViewEdit'),
	  	method: "POST",
	  	data: fdata,
		dataType : 'json',
		success : function(result){
			$("#viewContent").html(result.content);
			$('#btn_create_view').html(result.button).fadeIn();
			PR.prettyPrint();
			setViewMode('html');
		},
		error : function(jqXHR, exception){
			ajaxErrorMessage(jqXHR, exception);
		}
	});
}
function createViewEdit() {
	var fdata = getFormData();
	fdata['show_file_path'] = $('#view_edit_path').text();
	$.post(site_url('ci_dashboard/createViewEdit'), fdata, function( data ) {
	  $( "#layer_show_link" ).html( data ).show();
	});
}

function loadViewPreview() {
	clearDivAll();
	if ($('#tableNameNow').val() == '') {
		$('#viewContent').html("<p class='alert alert-warning'>เลือกตารางด้วยครับ</p>");
		return false;
	}
	
	if ($('#module_name').val() == '') {
		$('#viewContent').html("<p  class='alert alert-warning'>กรุณาระบุ Module & Path ด้วยครับ</p>");
		return false;
	}

	var errMsg = checkMainField();
	if (errMsg != '') {
		$('#viewContent').html("<p style='color:red'>" + errMsg + "</p>");
		return false;
	}

	var fdata = getFormData();

	$.ajax({
	  	url: site_url('ci_dashboard/loadViewPreview'),
	  	method: "POST",
	  	data: fdata,
		dataType : 'json',
		success : function(result){
			$("#viewContent").html(result.content);
			$('#btn_create_view').html(result.button).fadeIn();
			PR.prettyPrint();
			setViewMode('html');
		},
		error : function(jqXHR, exception){
			ajaxErrorMessage(jqXHR, exception);
		}
	});

}
function createViewPreview() {
	var fdata = getFormData();
	fdata['show_file_path'] = $('#view_preview_path').text();
	$.post(site_url('ci_dashboard/createViewPreview'), fdata, function( data ) {
	  $( "#layer_show_link" ).html( data ).show();
	});
}

function loadViewJS () {
	hideViewToolbar();
	clearDivAll();
	if ($('#tableNameNow').val() == '') {
		$('#viewContent').html("<p class='alert alert-warning'>เลือกตารางด้วยครับ</p>");
		return false;
	}
	
	if ($('#module_name').val() == '') {
		$('#viewContent').html("<p  class='alert alert-warning'>กรุณาระบุ Module & Path ด้วยครับ</p>");
		return false;
	}

	var errMsg = checkMainField();
	if (errMsg != '') {
		$('#viewContent').html("<p style='color:red'>" + errMsg + "</p>");
		return false;
	}

	var fdata = getFormData();
	fdata['file_path'] = $('#file_path').val();
	$.ajax({
	  	url: site_url('ci_dashboard/loadViewJS'),
	  	method: "POST",
	  	data: fdata,
		dataType : 'json',
		success : function(result){
			$("#viewContent").html(result.content);
			$('#btn_create_view').html(result.button).fadeIn();
			PR.prettyPrint();
		},
		error : function(jqXHR, exception){
			ajaxErrorMessage(jqXHR, exception);
		}
	});

}

function createViewJS () {
	var fdata = getFormData();
	fdata['show_file_path'] = $('#view_js_path').text();
	fdata['file_path'] = $('#file_path').val();
	$.post(site_url('ci_dashboard/createViewJS'), fdata, function( data ) {
		$( "#layer_show_link" ).html( data ).show();
	});
}

/* Function */
function setNewPath(){
	var ctrlName = $('#controller_name').val();
	$('#model_name').val(jsUcfirst(ctrlName));
	$('#path_name').val($('#module_name').val().toLowerCase() + '/' + ctrlName.toLowerCase());
}

function loadOptionFieldList(table_name, join_field){
	var fdata = {};
	fdata['table_name'] = table_name;
	fdata[csrf_token_name] = $.cookie(csrf_cookie_name);
	$.post(site_url('ci_dashboard/option_field_list'), fdata, function( data ) {
		var option_list = '<option value="">- เลือกฟิลด์เชื่อมโยง-</option>' + data;
		$( "#table_join_field_refer_" + join_field ).html( option_list );
		$( "#table_join_field_title_" + join_field ).html( data );
	});
}

function loadOptionDetailFieldList(table_name){
	var fdata = {};
	fdata['table_name'] = table_name;
	fdata[csrf_token_name] = $.cookie(csrf_cookie_name);
	$.post(site_url('ci_dashboard/option_field_list'), fdata, function( data ) {
		var option_list = '<option value="">- เลือกฟิลด์เชื่อมโยง-</option>' + data;
		$( "#detail_table_ref_field").html( option_list );
		$( "#detail_table_ref_field").select2({
			dropdownAutoWidth : true, width: '100%'
		});
	});
}

function loadTableDetailFieldList(table_name){
	var fdata = {};
	fdata['table_name'] = table_name;
	fdata[csrf_token_name] = $.cookie(csrf_cookie_name);
	//Loading
	loading_on($('#tbody_detail_list'));
	$.post(site_url('ci_dashboard/getTableDetailList'), fdata, function( results_list ) {
		$('#tbody_detail_list').html(results_list);
		$('select.detail_selectpicker').select2({
			dropdownAutoWidth : true, width: '150'
		});
	});
}

function loadOptionDetailJoinList(table_name){
	var fdata = {};
	fdata['table_name'] = table_name;
	fdata[csrf_token_name] = $.cookie(csrf_cookie_name);
	$.post(site_url('ci_dashboard/option_field_list'), fdata, function( data ) {
		var option_list = '<option value="">- เลือกฟิลด์เชื่อมโยง-</option>' + data;
		$( "#table_join_detail_field_refer").html( option_list );
		$( "#table_join_detail_field_title").html( data );
	});
}

function LogIn(){
    var pUrl = site_url('ci_members/login/process');
    var data = $('#frm_login').serialize();

	//Loading
	loading_on($('#btn_login'));

    $.ajax({
        method: "POST",
        url: pUrl,
        dataType: "json",
        data : data,
        success: function (results) {
            if(results.is_successful == true){
                window.location = site_url();
            }else{
				notify('แจ้งเตือน', results.message, 'danger', 'right');

				loading_on_remove($('#btn_login'));
            }
        }
    });
	return false;
}

function setPerPage(pValue){
	var fdata = {};
	fdata['per_page'] = pValue;
	fdata[csrf_token_name] = $.cookie(csrf_cookie_name);
	
	$.post(site_url('ci_dashboard/set_per_page'), fdata);
}

function setColumnOrderBy(pValue){
	var fdata = {};
	fdata['column_order_by'] = pValue;
	fdata[csrf_token_name] = $.cookie(csrf_cookie_name);
	
	$.post(site_url('ci_dashboard/set_column_order_by'), fdata);
}

function setDisplaySourceName(elemObj){
	var input_source = elemObj.val();
	var elemName = elemObj.attr('name');
	var matchName = elemName.match(/\[(.*?)\]/);
	var input_field = matchName[1];
	
	var sourceRef = $('input[name="source_ref['+input_field+']"]');
	
	if(input_source == 'manual_input'){
		sourceRef.val('').hide();
	}else if(input_source == 'uri_segment'){
		sourceRef.val(4).show();
	}else{
		sourceRef.val(input_field).show();
	}
}

function setDisplayAuthen(elem){
	if (elem.checked) {
        $('.col_authen').show(); 
    } else {
        $('.col_authen').hide();
		$('.col_authen input').val('');
    }
}


// Events
$('#fields').on('keyup', '#controller_name', function() {
	setNewPath();
});

$('#fields').on('keyup', '#module_name', function() {
	setNewPath();
});

// for treeview
$('li.treeview a').click(function() {
	$('.treeview').removeClass('active');
	$(this).closest('.treeview').addClass('active');
});

$('.navbar-nav li a').click(function(){
	$('.navbar-nav li a.active').removeClass('active');
	$(this).addClass('active');
});

$('.nav.nav-tabs.nav-pills li a').click(function(){
	$('.nav.nav-tabs.nav-pills li a.active').removeClass('active');
	$(this).addClass('active');
});


$('#myTab a').click(function(e) {
	e.preventDefault();
	$(this).tab('show');
});

$('#viewTable').click(function(e) {
	$('#divTableName').slideToggle();
});

// JOIN TABLE
$(document).on('change','select.select_table_join', function(){
	var frm = $(this).closest("div.table-join-content").find("select.select_field_title");
	frm.val('').trigger('change');

	frm = $(this).closest("div.table-join-content").find("select.select_field_refer");
	frm.val('').trigger('change');

	if($(this).val() != ''){
		loadOptionFieldList($(this).val(), $(this).attr('data-field-name'));
	}
});

function validateJoin(fieldName){
	var $message = '';
	if($('#table_join_'+fieldName).val() == ''){
		 $message += '<p>- เลือกตาราง</p>';
	}
	if($('#table_join_field_refer_'+fieldName).val() == ''){
		 $message += '<p>- เลือกฟิลด์เชื่อมโยง</p>';
	}
	if($('#table_join_field_title_'+fieldName).val() == ''){
		 $message += '<p>- เลือกฟิลด์แสดงผล</p>';
	}
	return $message;
}

$(document).on('click','.btn-set-master-join', function(){
	var btnJoin = $(this).closest("td").find(".btn_join");
	var fieldName = btnJoin.data('field-name');

	var $message = validateJoin(fieldName);
	if($message == ''){
		if(ci_notify){
			ci_notify.close();//clear notify
		}
		btnJoin.addClass('btn-info');

		var elem_name = '[name="input_format['+fieldName+']"]';
		var selectField = $(elem_name);

		selectField.attr('value', 'single_choice_dropdown');
		setDropdownList(elem_name, '100%');

		selectField.prop("disabled", true);
		selectField.closest('td').attr('title','ตัวเลือกนี้จะไม่สามารถเลือกได้ เมื่อมีการกำหนดการ JOIN ของฟิลด์นี้ไว้แล้ว');

		$('#join_' + fieldName).modal('hide');
	}else{
		notify('กรุณาตรวจสอบ', $message, 'danger');
	}
});

$(document).on('click','.btn-reset-master-join', function(){
	var frm = $(this).closest("div.join-table").find("select");
	frm.val('').trigger('change');

	var btnJoin = $(this).closest("td").find(".btn_join");
	btnJoin.removeClass('btn-info');

	var fieldName = btnJoin.data('field-name');
	var selectField = $('[name="input_format['+fieldName+']"');
	selectField.prop("disabled", false)
	selectField.closest('td').attr('title','');
});

// Detail TABLE
$(document).on('change','select#detail_table_name', function(){
	if($(this).val() != ''){
		loadOptionDetailFieldList($(this).val());
		loadTableDetailFieldList($(this).val());
	}
});

// JOIN table detail field
$(document).on('click', '.btn_detail_join', function(){
	clearDetailJoin();
	var ref_key = $(this).attr('data-ref-row');
	$('#join_table_detail').modal('show');
	$('#refer_detail_row').val(ref_key);
	var td = $(this).closest("td");

	var table = td.find("input.join_tb").val();
	var refer = td.find("input.join_refer").val();
	var title = td.find("input.join_title").val();

	setValueDetailJoin(table, refer, title);
});

// Detail TABLE JOIN
$(document).on('change','select#table_join_detail', function(){
	setValueDetailJoin($(this).val(),'','');
	if($(this).val() != ''){
		loadOptionDetailJoinList($(this).val());
	}
});

function setDetailJoin(){
	var ref_key = $('#refer_detail_row').val();
	$('button[data-ref-row="'+ref_key+'"]').addClass('btn-info');

	$('#detail_join_table_' + ref_key).val($('#table_join_detail').val());
	$('#detail_join_field_refer_' + ref_key).val($('#table_join_detail_field_refer').val());
	$('#detail_join_field_title_' + ref_key).val($('#table_join_detail_field_title').val());

	var comma = '';
	var label = '';
	$('#table_join_detail_field_title option:selected').each(function( index ) {
		label += comma + $(this).text().split('-').pop().trim();
		comma = ',';
	});
	$('#detail_join_field_comment_' + ref_key).val(label);

	$('#join_table_detail').modal('hide');
}

function setValueDetailJoin(table, refer, title){
	$('#table_join_detail').val(table).select2({
		dropdownAutoWidth : true, width: '100%'
	});
	$('#table_join_detail_field_refer').val(refer).select2({
		dropdownAutoWidth : true, width: '100%'
	});
	$('#table_join_detail_field_title').val(title).select2({
		dropdownAutoWidth : true, width: '100%'
	});
}

function clearDetailJoin(){
	var ref_key = $('#refer_detail_row').val();
	$('button[data-ref-row="'+ref_key+'"]').removeClass('btn-info');

	setValueDetailJoin('', '', '');
}

function validateDetailJoin(){
	var $message = '';
	if($('#table_join_detail').val() == ''){
		 $message += '<p>- เลือกตาราง</p>';
	}
	if($('#table_join_detail_field_refer').val() == ''){
		 $message += '<p>- เลือกฟิลด์เชื่อมโยง</p>';
	}
	if($('#table_join_detail_field_title').val() == ''){
		 $message += '<p>- เลือกฟิลด์แสดงผล</p>';
	}
	return $message;
}

$(document).on('click', '#btn_set_detail_join', function(){
	var $errorMsg =  validateDetailJoin();
	if($errorMsg == ''){
		if(ci_notify){
			ci_notify.close();
		}
		setDetailJoin();
		$('#refer_detail_row').val('');
	}else{
		notify('กรุณาตรวจสอบ', $errorMsg, 'danger');
	}
});

$(document).on('click', '#btn_reset_detail_join', function(){
	clearDetailJoin();
	$('#refer_detail_row').val('');
});

$(document).on('change', '[name^="detail_input_source"]', function(){
	var input_key = $(this).data('item-input');
	var obj = $('[name="detail_input_source_key['+input_key+']"]');
	if($(this).val() == '' || $(this).val() == 'auto_input'){
		obj.addClass('d-none');
	}else{
		obj.removeClass('d-none');
		if($(this).val() == 'session_input'){
			obj.val('user_id');
		}
	}
});

$(document).on('change', '#detail_table_ref_field', function(){
	var ref_value = $(this).val();
	var obj = $('.detail_field_'+ref_value);
	
	$('.ref_input').removeClass('d-none').removeClass('ref_input');
	obj.addClass('d-none').addClass('ref_input');
});

function CopyToClipboard(containerid) {
	if (document.selection) {
		var range = document.body.createTextRange();
		range.moveToElementText(document.getElementById(containerid));
		range.select().createTextRange();
		document.execCommand("copy");
		document.selection.empty();
	} else if (window.getSelection) {
		var range = document.createRange();
		range.selectNode(document.getElementById(containerid));
		window.getSelection().addRange(range);
		document.execCommand("copy");
		window.getSelection().removeAllRanges();
	}
	notify('Coppy', 'คัดลอกข้อมูลเรียบร้อย', 'info', 'right');
}

function hideViewToolbar(){
	$('#btn-html-mode, #btn-display-mode').hide();
	$('#viewContent, #btn-copy-clipboard').show();
	$('#viewContent_displayMode').html('').hide();
}

function setViewMode(strMode){
	$('#btn-html-mode, #btn-display-mode').show();
	if(strMode == 'html'){
		$('#btn-display-mode').removeClass('btn-warning').addClass('btn-secondary');
		$('#btn-html-mode').addClass('btn-warning').removeClass('btn-secondary');
		$('#viewContent, #btn-copy-clipboard').show();
		$('#viewContent_displayMode').html('').hide();
	}else{
		$('#btn-display-mode').addClass('btn-warning').removeClass('btn-secondary');
		$('#btn-html-mode').removeClass('btn-warning').addClass('btn-secondary');
		$('#viewContent_displayMode').html($('#viewContent').text()).show();
		$('#viewContent, #btn-copy-clipboard').hide();
	}
}

$(document).on('click', '.btn-toggle-mode', function(){
	var this_id = $(this).attr('id');
	var strMode = '';
	if(this_id == 'btn-html-mode'){
		strMode = 'html';
	}else{
		strMode = 'display';
	}
	setViewMode(strMode);

	setDatePicker('.datepicker');
});

$(document).on('click', '#tab-templates', function(){
	var template = $(this).data('template-name');
	loadTemplates(template);
});

$(document).on('change', '#per_page', function(){
	setPerPage($(this).val());
});

$(document).on('change', '#column_order_by', function(){
	setColumnOrderBy($(this).val());
});

$(document).on('change', '[name^="source["]', function(){
	setDisplaySourceName($(this));
});

$(document).on('change', '#login_require', function(){
	setDisplayAuthen(this);
});