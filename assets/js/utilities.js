$.fn.serializeObject = function()
{
   var o = {};
   var a = this.serializeArray();
   $.each(a, function() {
       if (o[this.name]) {
           if (!o[this.name].push) {
               o[this.name] = [o[this.name]];
           }
           o[this.name].push(this.value || '');
       } else {
           o[this.name] = this.value || '';
       }
   });
   return o;
};

function site_url(url){
	if(!url){
		url = '';
	}
	return siteURL + url;
}

function base_url(param){
	if(!param){param='';}
    return baseURL + param;
}

var ci_notify;
function notify(strTitle, strMessage, strType, pPosition, pFrom){
	if(!strType){ strType = 'info';}
	if(!pPosition){ pPosition = 'right';}
	if(!pFrom){ pFrom = 'top';}
	ci_notify = $.notify({
		title: '<b>' + strTitle + ' : </b><br/>',
		message: strMessage,
	},{
		type: strType,
		placement: {
			from: pFrom,
			align: pPosition
		}
	});
}

function loading_after(obj){
	$(obj).after('<span id="loading_after">&nbsp;&nbsp;<i class="fa fa-refresh fa-spin"></i> Loading..</span>');
}

function loading_after_remove(){
	$('#loading_after').remove();
}

function loading_on(obj){
	var attr = obj.attr('prev_html');
	if (typeof attr !== typeof undefined && attr !== false) {
		return false;
	}else{
		$(obj).addClass('disabled');
		obj.attr('prev_html', $(obj).html());
		obj.html('<i class="fa fa-refresh fa-spin"></i> Loading..');
		return true;
	}
}

function loading_on_remove(obj){
	obj.removeClass('disabled');
	var prev_html = obj.attr('prev_html');
	obj.html(prev_html);
	obj.removeAttr('prev_html');
}

function setDropdownList(elem, box_width){
	if(!box_width){
		box_width = 'auto';
	}
	$(elem).select2({
		dropdownAutoWidth : true,
		width: box_width
	});
	var default_value = $(elem).attr('value');
	$(elem).val('').val(default_value).trigger('change');
}

function jsUcfirst(string)
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function formatNumber(number,dec,thousand,pnt,curr1,curr2,n1,n2) {
	if (isNaN(number)) { return 0};
	if (number=='') { return 0};
	num = number.toString().replace(/,/g, '');
	if(dec == undefined) dec = 2;
	if(thousand == undefined) thousand = ',';
	if(pnt == undefined) pnt = '.';
	if(curr1 == undefined) curr1 = '';
	if(curr2 == undefined) curr2 = '';
	if(n1 == undefined) n1 = '';
	if(n2 == undefined) n2 = '';

	var x = Math.round(num * Math.pow(10,dec));

	if (x >= 0) n1=n2='';

	var y = (''+Math.abs(x)).split('');var z = y.length - dec;

	if (z<0) z--; for(var i = z; i < 0; i++) y.unshift('0');
	if (z<0) z = 1; y.splice(z, 0, pnt);
	if(y[0] == pnt) y.unshift('0');

	while (z > 3) {
		z-=3;
		y.splice(z,0,thousand);
	}
	var r = curr1+n1+y.join('')+n2+curr2;

	if(dec == 0) r = r.replace(/\.$/, '');
	if(number < 0){
		return "-" + r;
	}else{
		return r;
	}
}

function removeComma(num){
	return num.toString().replace(/,/g, '');
}

function stringToNumber(num){
	if(isNaN(num)){
		return 0;
	}
	num = num.toString().replace(/ /g, '');
	return parseFloat(removeComma(num));
}

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46) {
        return false;
    }
    return true;
}

function isValidDate(s) {
  var bits = s.split('/');
  var d = new Date(bits[2] + '/' + bits[1] + '/' + bits[0]);
  return !!(d && (d.getMonth() + 1) == bits[1] && d.getDate() == Number(bits[0]));
}

function setDatePicker(obj, options){//datepicker
	$(obj).each(function( i ) {



		var defaultDate = $(this).val().split("/");
		var defaultYear = defaultDate[2] - 543;
		var dateBefore = defaultDate[0] + "-" + defaultDate[1] + "-" + defaultYear;

		$(this).datepicker({
			dateFormat : 'dd-mm-yy',
			dayNamesMin : [ 'อา', 'จ', 'อ', 'พ',
					'พฤ', 'ศ', 'ส' ],
			monthNamesShort : [ 'มกราคม',
					'กุมภาพันธ์', 'มีนาคม',
					'เมษายน', 'พฤษภาคม',
					'มิถุนายน', 'กรกฎาคม',
					'สิงหาคม', 'กันยายน', 'ตุลาคม',
					'พฤศจิกายน', 'ธันวาคม' ],
			changeMonth : true,
			changeYear : true,
			beforeShow : function() {
				$(this).keydown(function(e) {
					// if(helper.zGetKey(e) !=
					// "9")$(this).datepicker(
					// "hide" );
				});// ไม่ให้พิมพ์เอง
				if ($(this).val() != ""
						&& $(this).val().length > 6) {
					var arrayDate = $(this).val()
							.split("/");
					arrayDate[2] = parseInt(arrayDate[2]) - 543;
					$(this).val(
							arrayDate[0] + "-"
									+ arrayDate[1]
									+ "-"
									+ arrayDate[2]);
				}
				setTimeout(
						function() {
							$
									.each(
											$(".ui-datepicker-year option"),
											function(
													j,
													k) {
												var textYear = parseInt($(
														".ui-datepicker-year option")
														.eq(
																j)
														.val()) + 543;
												$(
														".ui-datepicker-year option")
														.eq(
																j)
														.text(
																textYear);
											});
						}, 50);

			},
			onChangeMonthYear : function(year, month) {

				var day, thisMonth;

				var date = new Date();
					thisMonth = date.getMonth();

				if($(this).val() != ''){
					var arrayDate = $(this).val().split("-");
					day = arrayDate[0];
				}else{
					day = date.getDate();
				}
				$(this).val(day + '-' + month + '-' + year);
				dateBefore = $(this).val();

				setTimeout(
						function() {
							//Not this month
							if((month-1) != thisMonth){
								var tdDay = 'div#ui-datepicker-div td[data-month="'+ (month-1) +'"][data-year="'+year+'"] a.ui-state-default:contains('+ day +')';
								$(tdDay).filter(function(){return $(this).text() == day;}).addClass('ui-state-active');
							}

							$.each($(".ui-datepicker-year option")
								,function(j,k) {
									var textYear = parseInt($(
											".ui-datepicker-year option")
											.eq(
													j)
											.val()) + 543;
									$(
											".ui-datepicker-year option")
											.eq(
													j)
											.text(
													textYear);
							});
						}, 50);
			},
			onClose : function() {
				if ($(this).val() != "" && $(this).val() == dateBefore) {
					var arrayDate = dateBefore.split("-");
					if(isValidDate(arrayDate[0] + "/"+ arrayDate[1]+ "/"+ arrayDate[2]) == false){
						dateBefore = new Date(arrayDate[2], arrayDate[1] + 1, 0);
						alert(dateBefore);
					}
					arrayDate[2] = parseInt(arrayDate[2]) + 543;
					$(this).val(arrayDate[0] + "/"+ arrayDate[1]+ "/"+ arrayDate[2]);
				}
				if (options != undefined) {
					if (options.onClose)
						options.onClose();
				}
			},
			onSelect : function(dateText, inst) {
				dateBefore = $(this).val();
				var arrayDate = dateText.split("-");
				if(isValidDate(arrayDate[0] + "/"+ arrayDate[1]+ "/"+ arrayDate[2]) == false){
					dateBefore = new Date(arrayDate[2], arrayDate[1] + 1, 0);
					alert(dateBefore);
				}
				arrayDate[2] = parseInt(arrayDate[2]) + 543;
				$(this).val(
						arrayDate[0] + "/"
								+ arrayDate[1]
								+ "/"
								+ arrayDate[2]);
				if (options != undefined) {
					if (options.onSelect)
						options.onSelect();
				}
			}
		});
	});

	$(obj).on('keydown', function(e) {
		var keycode = getKeyCode(e);
		if(keycode != "9"){
			$( obj ).focus();
			return false;
		}
	});//ไม่ให้พิมพ์เอง

};

function getKeyCode(ev){
	return (ev.keyCode ? ev.keyCode : ev.which);
}

function isEnter(e){
	if(getKeyCode(e)==13){
		return true;
	}else{
		return false;
	}
}

function setSelectBox(element_obj, opt_value){
	$(element_obj + ' option[value="'+ opt_value +'"]').attr('selected', true);
	var slect_box_value = $(element_obj + ' option[selected]').val();
	$(element_obj).val(slect_box_value).trigger("change");
}

function jumpto(h){
    var url = location.href;               //Save down the URL without hash.
    location.href = "#"+h;                 //Go to the target element.
    history.replaceState(null,null,url);   //Don't like hashes. Changing it back.
}

/**
 * Display images before upload
 */
function previewPicture(input, elem_display, h) {
	if (input.files && input.files[0]) {
		if(!h){h = 300}
		var reader = new FileReader();
		reader.onload = function (e) {
			$(elem_display).attr('src', e.target.result);
		}

		var rFilter = /^(image\/bmp|image\/cis-cod|image\/gif|image\/ief|image\/jpeg|image\/jpeg|image\/jpeg|image\/pipeg|image\/png|image\/svg\+xml|image\/tiff|image\/x-cmu-raster|image\/x-cmx|image\/x-icon|image\/x-portable-anymap|image\/x-portable-bitmap|image\/x-portable-graymap|image\/x-portable-pixmap|image\/x-rgb|image\/x-xbitmap|image\/x-xpixmap|image\/x-xwindowdump)$/i;
        var file = input.files[0];
        if (!rFilter.test(file.type)) {
			$(elem_display).attr({'src' : '', 'height' : 0});

			var extall="pdf,sql,txt,mp4,mp3";
			var file_value = input.value;
			var ext = file_value.split('.').pop().toLowerCase();
			if(parseInt(extall.indexOf(ext)) >= 0)
			{
				if(!$(elem_display + '_iframe').attr('id')){
					var iframe_preview = '<iframe id="'+ elem_display.replace('#', '') +'_iframe" frameborder="0" scrolling="no" width="400" height="600" style="border : 1px solid #ccc"></iframe>';
					$(elem_display).after(iframe_preview);
				}
				if(ext == 'mp3'){
					h = 50;
				}
				previewUpload(input, elem_display + '_iframe', h);
			}else{
				$(elem_display + '_iframe').remove();
			}
			return;
		}else{
			$(elem_display + '_iframe').remove();
			$(elem_display).attr({'height' : h});
		}

		reader.readAsDataURL(input.files[0]);
	}
}

function previewUpload(input, elem_display, h) {
	if(!h){h = 350}
	pdffile =  input.files[0];
	pdffile_url = URL.createObjectURL(pdffile);
	if(pdffile_url){
		$(elem_display).attr({'src': pdffile_url, 'height' : h});
	}
}

$(document).ready(function() {
	$(document).on('keypress','.isNumberOnly',function(){
		return isNumber(event);
	});
});

function autoTab(obj){
        var pattern=new String("__:__:_"); // กำหนดรูปแบบในนี้
        var pattern_ex=new String(":"); // กำหนดสัญลักษณ์หรือเครื่องหมายที่ใช้แบ่งในนี้

        var returnText=new String("");
        var obj_l=obj.value.length;
        var obj_l2=obj_l-1;
        for(i=0;i<pattern.length;i++){
            if(obj_l2==i && pattern.charAt(i+1)==pattern_ex){
                returnText+=obj.value+pattern_ex;
                obj.value=returnText;
            }
        }
        if(obj_l>=pattern.length){
            obj.value=obj.value.substr(0,pattern.length);
        }
}

function ajaxErrorMessage(jqXHR, exception, elem) {
	var message;
	var statusErrorMap = {
		'400' : "Server understood the request, but request content was invalid.",
		'401' : "Unauthorized access.",
		'403' : "Forbidden resource can't be accessed.",
		'500' : "Internal server error.",
		'503' : "Service unavailable."
	};
	if (jqXHR.status) {
		message = statusErrorMap[jqXHR.status];
		if(!message){
			  message="Unknown Error. \n";
		}
    }else if (jqXHR.status === 0) {
		message = 'Requested JSON parse failed.';
	} else if (exception === 'parsererror') {
		message = 'Requested JSON parse failed.';
	} else if (exception === 'timeout') {
		message = 'Time out error.';
	} else if (exception === 'abort') {
		message = 'Ajax request aborted.';
	} else {
		message = 'Uncaught Error. \n';// + jqXHR.responseText;
	}
	var responseTitle= $(jqXHR.responseText).filter('title').get(0);
	var detail = $(responseTitle).text();

	var other_detail = '';
	var obj = $(jqXHR.responseText).filter('div').get(0);
	other_detail = $(obj).find("p").eq(1).text();
	if(other_detail == ''){
		other_detail = '> ' + $(obj).find("p").text();
	}

	detail += ' - ' + other_detail;

    alert(message + "\n\n" + detail);
    if(elem){
        elem.html(message + '('+jqXHR.status+')' + "\n\n" + jqXHR.responseText + "\n\n" );
    }
}
