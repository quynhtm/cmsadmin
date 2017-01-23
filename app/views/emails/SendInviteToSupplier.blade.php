<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<div style=" border: 1px solid #166ead;margin: 0 auto;min-height: 100%;width: 100%; display:inline-block; background:#166ead">
   			<div style="height: 50px;margin: 0 auto;width: 100%; margin-bottom: 2px; display: inline-block; color: #fff;">
  				 <div style="float: left;margin: 0 auto;width: 25%;">
			        <div style="padding-top: 10px;padding-left: 15px;">
			           <a href="{{URL::route('site.home')}}"><img style="margin-top:5px; max-height: 30px; height:30px" id="logo" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/img/logo-mail.png" /></a>
				    </div>
				 </div>
    			<div style="display:inline-block;float:right;color:#fff; line-height:50px;padding-right:20px; font-style: italic;">{{CGlobal::phoneSupport}}</div>
	    	</div>
	    	<div style="background: #fff;margin: 0 auto;min-height: 200px;padding: 3% 2%;width: 88%;">
						<b>Chào:</b> Quý khách<br/>
						- Bạn có <b>sản phẩm để bán?</b><br/>
	    				- Bạn đã có <b>cửa hàng để trưng bày sản phẩm</b>?<br/>
	    				- Bạn có <b>một máy tính kết nối internet</b>, mạng xã hội?<br/>
	    				- Nhưng bạn chưa có <b style="color:#ff0000">Website để giới thiệu sản phẩm</b> tới người tiêu dùng..?<br/><br/>

	    				<b>Shopcuatui.com.vn</b> sẽ đáp ứng yêu cầu đó:<br/>
	    				- <b>Quản lý shop</b><br/>
	    				- <b>Quản lý sản phẩm online</b><br/>
	    				- <b>Quản lý đơn hàng online</b><br/>
	    				- <b>Tiếp cận tới nhiều người tiêu dùng</b><br/>
	    				- <b>Chức năng đơn giản, tiện dụng, dễ sử dụng</b><br/>
	    				- Quan trọng hơn là <b style="color:#ff0000">Miễn Phí tạo account và up nhiều sản phẩm</b> ngay khi <a href="{{URL::route('site.shopRegister')}}">đăng ký</a><br/><br/>
	    				<a href="{{URL::route('site.home')}}/shop-70/Phu-kien-thoi-trang.html"><img style="max-width:100%; width:100%" src="{{URL::route('site.home')}}/uploads/default/thoitrangphukien.jpg" /></a><br/>
	    	</div>
	  		<div style="max-height: 34px; height:34px; width: 100%;">
		        <div style="margin: 0 auto;width: 100%;">
		            <span style="color:#fff; padding-right: 15px;float: right; padding-top: 10px;">&copy; <a style="text-decoration: none; color:#fff;" href="{{URL::route('site.home')}}">{{CGlobal::web_name}}</a> 2015-{{date('Y')}}.</span>
		        </div>
    		</div>
	  	</div>
	</body>
</html>
