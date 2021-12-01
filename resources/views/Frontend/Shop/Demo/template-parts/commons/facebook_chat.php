<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<!-- Your customer chat code -->
<div class="fb-customerchat"
     attribution=setup_tool
     page_id="2428809380682169"
     logged_in_greeting="Bạn cần cắt HTML/CSS? Hãy chat ngay với chúng tôi"
     logged_out_greeting="Bạn cần cắt HTML/CSS? Hãy chat ngay với chúng tôi">
</div>
<script>
    defer(function() {
        window.fbAsyncInit = function() {
            FB.init({
                xfbml            : true,
                version          : 'v5.0'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    }, 5000);
</script>