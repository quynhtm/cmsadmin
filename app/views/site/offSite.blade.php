{{ HTML::style('assets/site/countdown/assets/css/css.css'); }}
{{ HTML::style('assets/site/countdown/assets/css/styles.css'); }}
{{ HTML::style('assets/site/countdown/assets/countdown/jquery.countdown.css'); }}

{{HTML::script('assets/site/countdown/assets/js/html5.js');}}
{{HTML::script('assets/site/countdown/assets/js/jquery-1.7.1.min.js');}}
{{HTML::script('assets/site/countdown/assets/countdown/jquery.countdown.js');}}
{{HTML::script('assets/site/countdown/assets/countdown/countdown.js');}}
{{HTML::script('assets/site/countdown/assets/js/script.js');}}


<div class="form-group text-center" style="text-align: center">
    <img src="{{$url_src_icon}}">
    <div style="clear: both; margin-top: 50px"></div>
    <!-- dếm ngược

    <div id="countdown"></div>
    <p id="note"></p>-->

    <div style="text-align: center; float: left; position: relative">
    <script type="application/javascript">
    var myCountdown1 = new Countdown({
    								 	//time: 86400 * 3, // 86400 seconds = 1 day
    								 	time: {{$date_off}},
    									width:300,
    									height:60,
    									rangeHi:"day",
    									style:"flip"	// <- no comma on last item!
    									});
    $("#Stage_jbeeb_3").css({ left: "158%" });

    </script>
    </div>
</div>




