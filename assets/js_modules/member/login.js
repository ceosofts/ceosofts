function LogIn(){
    var pUrl = site_url('member/login_only/process');
    var data = $('#frm_login').serialize();
	data += '&' + csrf_token_name + '=' + $.cookie(csrf_cookie_name);
	//Loading
	loading_on($('#btn_login'));

    $.ajax({
        method: "POST",
        url: pUrl,
        data : data,
        success: function (json_string) {
            try
			{
				var results = jQuery.parseJSON( json_string );
                if(results.is_successful == true){
					if(results.redirect_url){
						window.location = results.redirect_url;
					}else{
						window.location = site_url();
					}
                }else{
    				notify('แจ้งเตือน', results.message, 'danger', 'right');
    				loading_on_remove($('#btn_login'));
                }
            }
			catch(err)
			{
				alert('invalid json : ' + err + "\n\n" + json_string);
			}
        },
		error : function(jqXHR, exception){
			$('#alert_login').addClass('alert-danger').show();
			ajaxErrorMessage(jqXHR, exception, $("#alert_login"));
		}
    });
	return false;
}