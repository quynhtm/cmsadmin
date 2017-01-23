jQuery(document).ready(function($){
	USER_CUSTOMMER.register();
	USER_CUSTOMMER.login();
	USER_CUSTOMMER.changeInfo();
	USER_CUSTOMMER.forgetpass();
	USER_CUSTOMMER.getNewPass();
	
	USER_CUSTOMMER.clickLoginFacebook();
	USER_CUSTOMMER.clickLoginGoogle();
});

USER_CUSTOMMER = {
	register:function(){
		jQuery('.clickRegister').click(function(){
			jQuery('.content-popup-show').modal('hide');
			jQuery('#sys-popup-register').modal('show');
			jQuery('#btnRegister').click(function(){
				var token = jQuery('#frmRegister input[name="_token"]');
				var email = jQuery('#sys_reg_email');
				var pass = jQuery('#sys_reg_pass');
				var repass = jQuery('#sys_reg_re_pass');
				var full_name = jQuery('#sys_reg_full_name');
				var phone = jQuery('#sys_reg_phone');
				var address = jQuery('#sys_reg_address');
				
				var error = '';
				if(email.val() == ''){
					email.addClass('error');
					error = 'Email không được trống!<br/>';
				}else{
					var regex = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
					var checkMail = regex.test(email.val());
					if(!checkMail){
						email.addClass('error');
						error = 'Email không đúng định dạng!<br/>';
					}else{
						email.removeClass('error');
						error = '';
					}
				}
				if(pass.val() == ''){
					pass.addClass('error');
					error = error + 'Mật khẩu không được trống!<br/>';
				}
				if(repass.val() == ''){
					repass.addClass('error');
					error = error + 'Nhập lại mật khẩu không được trống!<br/>';
				}
				if(pass.val() != repass.val()){
					pass.addClass('error');
					repass.addClass('error');
					error = error + 'Mật khẩu không khớp!<br/>';
				}else{
					if(pass.val() == '' && repass.val() == ''){
						pass.addClass('error');
						repass.addClass('error');
					}else{
						pass.removeClass('error');
						repass.removeClass('error');
					}
				}
				if(full_name.val() == ''){
					full_name.addClass('error');
					error = error + 'Họ tên không được trống!<br/>';
				}else{
					full_name.removeClass('error');
				}
				if(phone.val() == ''){
					phone.addClass('error');
					error = error + 'Điện thoại không được trống!<br/>';
				}else{
					phone.removeClass('error');
				}
				if(address.val() == ''){
					address.addClass('error');
					error = error + 'Địa chỉ không được trống!<br/>';
				}else{
					address.removeClass('error');
				}
				
				if(error != ''){
					jQuery('#error-register').html(error);
				}else{
					//Check ajax
					var url = WEB_ROOT + '/dang-ky.html';
					jQuery('body').append('<div class="loading"></div>');
					jQuery.ajax({
						type: "POST",
						url: url,
						data: "sys_reg_email="+encodeURI(email.val()) + "&sys_reg_pass="+encodeURI(pass.val()) + "&sys_reg_re_pass="+encodeURI(repass.val()) + "&sys_reg_full_name="+encodeURI(full_name.val()) + "&sys_reg_phone="+encodeURI(phone.val()) + "&sys_reg_address="+encodeURI(address.val()) + "&token="+encodeURI(token.val()),
						success: function(data){
							jQuery('body').find('div.loading').remove();
							if(data == ''){
								jAlert('Bạn đăng ký tài khoản thành công! Kiểm tra mail để kích hoạt.', 'Thông báo');
								jQuery("#popup_ok").click(function(){
									jQuery('#frmRegister input').val('');
									window.location.reload();
								});
							}else{
								jQuery('#error-register').html(data);
								return false;
							}
						}
					});
				}
			});
		});
	},
	login:function(){
		jQuery('.clickLogin, .aRegPost').unbind('click').click(function(){
			jQuery('.content-popup-show').modal('hide');
			jQuery('#sys-popup-login').modal('show');
			jQuery('#btnLogin').click(function(){
				var token = jQuery('#frmLogin input[name="_token"]');
				var email = jQuery('#sys_login_mail');
				var pass = jQuery('#sys_login_pass');
				var error = '';
				if(email.val() == ''){
					email.addClass('error');
					error = 'Email không được trống!<br/>';
				}else{
					var regex = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
					var checkMail = regex.test(email.val());
					if(!checkMail){
						email.addClass('error');
						error = 'Email không đúng định dạng!<br/>';
					}else{
						email.removeClass('error');
						error = '';
					}
				}
				if(pass.val() == ''){
					pass.addClass('error');
					error = error + 'Mật khẩu không được trống!';
				}
				if(error != ''){
					jQuery('#error-login').html(error);
				}else{
					//Check ajax
					var url = WEB_ROOT + '/dang-nhap.html';
					jQuery('body').append('<div class="loading"></div>');
					jQuery.ajax({
						type: "POST",
						url: url,
						data: "sys_login_mail="+encodeURI(email.val()) + "&sys_login_pass="+encodeURI(pass.val()) + "&token="+encodeURI(token.val()),
						success: function(data){
							jQuery('body').find('div.loading').remove();
							if(data == ''){
								window.location.reload();
							}else{
								jQuery('#error-login').html(data);
								return false;
							}
						}
					});
				}
			});
		});
	},
	changeInfo:function(){
		jQuery('#btnChangeInfo').click(function(){
			var email = jQuery('#sys_change_email');
			var full_name = jQuery('#sys_change_full_name');
			var phone = jQuery('#sys_change_phone');
			var address = jQuery('#sys_change_address');
			
			var error = '';
			if(email.val() == ''){
				email.addClass('error');
				error = 'Email không được trống!<br/>';
			}else{
				var regex = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
				var checkMail = regex.test(email.val());
				if(!checkMail){
					email.addClass('error');
					error = 'Email không đúng định dạng!<br/>';
				}else{
					email.removeClass('error');
					error = '';
				}
			}
			if(full_name.val() == ''){
				full_name.addClass('error');
				error = error + 'Họ tên không được trống!<br/>';
			}else{
				full_name.removeClass('error');
			}
			if(phone.val() == ''){
				phone.addClass('error');
				error = error + 'Điện thoại không được trống!<br/>';
			}else{
				phone.removeClass('error');
			}
			if(address.val() == ''){
				address.addClass('error');
				error = error + 'Địa chỉ không được trống!<br/>';
			}else{
				address.removeClass('error');
			}
			
			if(error != ''){
				jQuery('#error-change-info').html(error);
				return false;
			}
		});
	},
	forgetpass:function(){
		jQuery('.clickForgetPass').click(function(){
			jQuery('.content-popup-show').modal('hide');
			jQuery('#sys-popup-forgetpass').modal('show');
			jQuery('#btnForgetpass').click(function(){
				var token = jQuery('#frmForgetPass input[name="_token"]');
				var email = jQuery('#sys_forget_mail');
				var error = '';
				if(email.val() == ''){
					email.addClass('error');
					error = 'Email không được trống!<br/>';
				}else{
					var regex = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
					var checkMail = regex.test(email.val());
					if(!checkMail){
						email.addClass('error');
						error = 'Email không đúng định dạng!<br/>';
					}else{
						email.removeClass('error');
						error = '';
					}
				}
				if(error != ''){
					jQuery('#error-forgetpass').html(error);
				}else{
					//Check ajax
					var url = WEB_ROOT + '/quen-mat-khau.html';
					jQuery('body').append('<div class="loading"></div>');
					jQuery.ajax({
						type: "POST",
						url: url,
						data: "sys_forget_mail="+encodeURI(email.val()) + "&token="+encodeURI(token.val()),
						success: function(data){
							jQuery('body').find('div.loading').remove();
							if(data == '1'){
								jAlert('Thông tin đăng nhập mới được gửi tới mail của bạn.', 'Thông báo');
								jQuery("#popup_ok").click(function(){
									window.location.reload();
								});
							}else{
								jQuery('#error-forgetpass').html(data);
								return false;
							}
						}
					});
				}
			});
		});
	},
	getNewPass:function(){
		jQuery('#btnChangeNewPass').click(function(){
			
			var pass = jQuery('#sys_change_new_pass');
			var repass = jQuery('#sys_change_new_re_pass');
			var error = '';
			
			if(pass.val() == ''){
				pass.addClass('error');
				error = error + 'Mật khẩu không được trống!<br/>';
			}
			if(repass.val() == ''){
				repass.addClass('error');
				error = error + 'Nhập lại mật khẩu không được trống!<br/>';
			}
			if(pass.val() != repass.val()){
				pass.addClass('error');
				repass.addClass('error');
				error = error + 'Mật khẩu không khớp!<br/>';
			}else{
				pass.removeClass('error');
				repass.removeClass('error');
			}
			
			if(error != ''){
				jQuery('#error-change-new-pass').html(error);
				return false;
			}
		});
	},
	getDistrictInforCustomer:function(){
		var customer_province_id = $('#customer_province_id').val();
		if(parseInt(customer_province_id) > 0){
			jQuery.ajax({
				type: "POST",
				url: WEB_ROOT + '/thong-tin-quan-huyen-cua-khach.html',
				data: {customer_province_id : customer_province_id},
				dataType: 'json',
				success: function(res) {
					if(res.isIntOk === 1){
						$('#customer_district_id').html(res.html_option);
					}else{
						jAlert(res.msg, 'Thông báo');
					}
				}
			});
		}
	},
	changePassCustomer:function(){
		var customer_password = $('#customer_password').val();
		jConfirm('Bạn muốn thay đổi mật khẩu [OK]:Đồng ý [Cancel]:Bỏ qua?)', 'Xác nhận', function(r) {
			if(r && customer_password != ''){
				jQuery.ajax({
					type: "POST",
					url: WEB_ROOT + '/thay-doi-mat-khau.html',
					data: {customer_password : customer_password},
					dataType: 'json',
					success: function(res) {
						jAlert(res.msg, 'Thông báo');
					}
				});
			}
		});
	},
	setTopItems:function(item_id){
		jConfirm('Bạn muốn up top tin đăng này? [OK]:Đồng ý [Cancel]:Bỏ qua?)', 'Xác nhận', function(r) {
			if(r && parseInt(item_id) > 0){
				jQuery.ajax({
					type: "POST",
					url: WEB_ROOT + '/up-top-tin-dang.html',
					data: {item_id : item_id},
					dataType: 'json',
					success: function(res) {
						jAlert(res.msg, 'Thông báo');
					}
				});
			}
		});
	},
	removeItems:function(item_id){
		jConfirm('Bạn thực sự muốn xóa tin này? [OK]:Đồng ý [Cancel]:Bỏ qua?)', 'Xác nhận', function(r) {
			if(r && parseInt(item_id) > 0){
				jQuery.ajax({
					type: "POST",
					url: WEB_ROOT + '/xoa-tin-dang.html',
					data: {item_id : item_id},
					dataType: 'json',
					success: function(res) {
						if(res.isIntOk == 1){
							jAlert(res.msg, 'Thông báo');
							window.location.reload();
						}else{
							jAlert(res.msg, 'Thông báo');
						}
					}
				});
			}
		});
	},
	
	//Login Social
	clickLoginFacebook:function(){
		jQuery('#clickLoginFacebook').click(function(){
			$.oauthPopup({
	            path: WEB_ROOT+'/facebooklogin',
				width:800,
				height:570,
	            callback: function(){
	                window.location.reload();
	            }
	        });
		});
	},
	clickLoginGoogle:function(){
		jQuery('#clickLoginGoogle').click(function(){
			$.oauthPopup({
	            path: WEB_ROOT+'/googlelogin',
				width:800,
				height:570,
	            callback: function(){
	                window.location.reload();
	            }
	        });
		});
	},
};

(function(jQuery){
	jQuery.oauthPopup = function(options){
		options.windowName = options.windowName || 'ConnectWithOAuth';
        options.windowOptions = options.windowOptions || 'location=0,status=0,width='+options.width+',height='+options.height+',scrollbars=1';
        options.callback = options.callback || function(){
            window.location.reload();
        };
        var that = this;
        that._oauthWindow = window.open(options.path, options.windowName, options.windowOptions);
        that._oauthInterval = window.setInterval(function(){
            if (that._oauthWindow.closed) {
                window.clearInterval(that._oauthInterval);
                options.callback();
            }
        }, 2000);
    };
})(jQuery);