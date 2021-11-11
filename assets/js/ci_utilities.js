(function($){
	$.fn.serializeObject = function () {
		"use strict";

		var result = {};
		var extend = function (i, element) {
			var node = result[element.name];

	// If node with same name exists already, need to convert it to an array as it
	// is a multi-value field (i.e., checkboxes)

			if ('undefined' !== typeof node && node !== null) {
				if ($.isArray(node)) {
					node.push(element.value);
				} else {
					result[element.name] = [node, element.value];
				}
			} else {
				result[element.name] = element.value;
			}
		};

		$.each(this.serializeArray(), extend);
		return result;
	};
})(jQuery);

function site_url(url){
	if(!url){
		url = '';
		if(siteURL.slice(-1) == '/'){
			siteURL = siteURL.slice(0, -1); 
		}
	}
	return siteURL + url;
}

function base_url(param){
	if(!param){param='';}
    return baseURL + param;
}


var ci_notify;
function notify(strTitle, strMessage, strType, pPosition, pFrom, pDelay){
	if(!strType){ strType = 'info';}
	if(!pPosition){ pPosition = 'right';}
	if(!pFrom){ pFrom = 'top';}
	if(!pDelay){ pDelay = 5000;}
	ci_notify = $.notify({
		title: '<b>' + strTitle + ' : </b><br/>',
		message: strMessage,
	},{
		type: strType,
		delay: pDelay,
		placement: {
			from: pFrom,
			align: pPosition
		}
	});
}

function loading_after(obj){
	$(obj).after('<span id="loading_after">&nbsp;&nbsp;<i class="fas fa-sync fa-spin"></i> Loading..</span>');
}

function loading_after_remove(){
	$('#loading_after').remove();
}

function loading_on(obj, pTitle){
	var attr = obj.attr('prev_html');
	if (typeof attr !== typeof undefined && attr !== false) {
		return false;
	}else{
		if(!pTitle){
			pTitle = 'Loading';
		}
		obj.addClass('disabled');
		obj.attr('prev_html', $(obj).html());
		obj.html('<i class="fas fa-sync fa-spin"></i> '+ pTitle +'..');
		return true;
	}
}

function loading_on_remove(obj){
	obj.removeClass('disabled');
	var prev_html = obj.attr('prev_html');
	obj.html(prev_html);
	obj.removeAttr('prev_html');
}

function copyTextToClipboard(text) {
  var textArea = document.createElement("textarea");

  // Place in top-left corner of screen regardless of scroll position.
  textArea.style.position = 'fixed';
  textArea.style.top = 0;
  textArea.style.left = 0;

  // Ensure it has a small width and height. Setting to 1px / 1em
  // doesn't work as this gives a negative w/h on some browsers.
  textArea.style.width = '2em';
  textArea.style.height = '2em';

  // We don't need padding, reducing the size if it does flash render.
  textArea.style.padding = 0;

  // Clean up any borders.
  textArea.style.border = 'none';
  textArea.style.outline = 'none';
  textArea.style.boxShadow = 'none';

  // Avoid flash of white box if rendered for any reason.
  textArea.style.background = 'transparent';


  textArea.value = text;

  document.body.appendChild(textArea);

  textArea.select();

  try {
    var successful = document.execCommand('copy');
    var msg = successful ? 'successful' : 'unsuccessful';
    console.log('Copying text command was ' + msg);
  } catch (err) {
    console.log('Oops, unable to copy');
  }

  document.body.removeChild(textArea);
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
	if(default_value){
		default_value = default_value.split(",");
		$(elem).val('').val(default_value).trigger('change');
	}
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
	if(num){
		return num.toString().replace(/,/g, '');
	}else{
		return num;
	}
}

function stringToNumber(num){
	if(!num){
		return num;
	}
	var new_num;
	new_num = num.toString().replace(/ /g, '');
	new_num = removeComma(new_num);
	if(isNaN(new_num)){
		return num;
	}
	return parseFloat(new_num);
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
		
		var myYearRange;
		if(options && options.yearRange  !== undefined){
			myYearRange = options.yearRange;
		}else{
			myYearRange = "-20:+20";
		}

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
			yearRange : myYearRange,
			changeMonth : true,
			changeYear : true,
			beforeShow : function() {
				$(this).keydown(function(e) {
					// if(helper.zGetKey(e) !=
					// "9")$(this).datepicker(
					// "hide" );
				});// ไม่ให้พิมพ์เอง
				
				$('select.ui-datepicker-year').select2();
				$('select.ui-datepicker-month').select2();
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
							$.each($(".ui-datepicker-year option")
										,function(j,k) {
												var textYear = parseInt($(".ui-datepicker-year option")
														.eq(j)
														.val()) + 543;
												$(".ui-datepicker-year option")
														.eq(j)
														.text(textYear);
							});
							$('select.ui-datepicker-year').select2();
							$('select.ui-datepicker-month').select2();
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
							
							$('select.ui-datepicker-year').select2();
							$('select.ui-datepicker-month').select2();
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
				$('select.ui-datepicker-year').select2();
				$('select.ui-datepicker-month').select2();
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
				$(this).trigger('change');
				$('select.ui-datepicker-year').select2();
				$('select.ui-datepicker-month').select2();
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

function goto_page(page_link){
	window.location = site_url(page_link);
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

//////////////
//VERSION 0.6	
//////////////
function ci_calculator(val1, val2, opt){
	var sum = 0;
	switch (opt) {
        case 'plus':
            sum = val1 + val2;
            break;
        case 'minus':
            sum = val1 - val2;
            break;
        case 'multiply':
            sum = val1 * val2;
            break;
        case 'divide':
            sum = val1 / val2;
            break;
        default:
            console.log('Missing parameters "Operator"');
    }
	return sum;
}

function calculator_input(input01, input02, opt, input_result){
	var val1 = stringToNumber($('#'+input01).val());
	var val2 = stringToNumber($('#'+input01).val());
	var sum = ci_calculator(val1, val2, opt);
	$('#'+input_result).val(formatNumber(sum));
}

function calculator_value(val1, val2, opt, callback){
	var val1 = stringToNumber(val1);
	var val2 = stringToNumber(val2);
	var sum = ci_calculator(val1, val2, opt);
	if(callback){
		callback(sum);
	}else{
		return sum;
	}
}

function modalPopup(title, content)
{
	if(!$('#modal-window-popup').attr('id')){
		var html =  `<div class="modal fade" id="modal-window-popup" tabindex="-1" role="dialog" aria-labelledby="#modal-window-popup_Label" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header" style="background-color : #8dc5d7 !important">
									<h5 class="modal-title" id="modal-window-popup_Label">${title}</h5>
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
								</div>
								<div class="modal-body">`;
		html += content;
			html +=  `			</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" id="btn-modal-window-popup-close"  data-dismiss="modal">ปิด</button>
									<button type="button" class="btn btn-primary" id="btn-modal-window-popup-ok">&nbsp;ตกลง&nbsp;</button>
								</div>
							</div>
						</div>
					</div>`;
		$("body").append(html);
	}
	$('#modal-window-popup_Label').html(title);
	$('#modal-window-popup .modal-body').html(content);
    $("#modal-window-popup").modal('show');
}

function modalPopupHide(){
	$('#modal-window-popup_Label').html('');
	$('#modal-window-popup .modal-body').html('');
	$("#modal-window-popup").modal('hide');
}

function triggerClick(elem_ref){
	$(elem_ref).trigger('click');
}

function setFocusList(elem, on_esc, on_enter){
	if($(elem).attr('id')){
		var obj_li = $(elem + ' > li');
		var obj_sel;
		$(window).on('keydown', function(e){
			if($(elem).is(":visible")){
				obj_sel = obj_li.eq($(elem + ' li.active').index());
				var selected;
				if(e.which === 40){
					if(obj_sel){
						obj_sel.removeClass('active');
						next = obj_sel.next();
						if(next.length > 0){
							obj_sel = next.addClass('active');
						}else{
							obj_sel = obj_li.eq(0).addClass('active');
						}
					}else{
						obj_sel = obj_li.eq(0).addClass('active');
					}
				}else if(e.which === 38){
					if(obj_sel){
						obj_sel.removeClass('active');
						next = obj_sel.prev();
						if(next.length > 0){
							obj_sel = next.addClass('active');
						}else{
							obj_sel = obj_li.last().addClass('active');
						}
					}else{
						obj_sel = obj_li.last().addClass('active');
					}
				}else if(e.which === 27){
					if(typeof on_esc !== 'undefined'){
						on_esc();
					}
				}else if(e.which === 13){
					if(typeof on_enter !== 'undefined'){
						on_enter();
					}
				}
			}
		});
	}
}