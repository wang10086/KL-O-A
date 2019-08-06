<include file="header" />

        <div class="wrapper row-offcanvas row-offcanvas-left">
            
			<include file="menu" />
            
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <?php echo P::SYSTEM_NAME."<small>".P::VERSION."（".P::VERSION_NAME."）</small>"; ?>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-home"></i> 首页</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                    	   
                         <?php 
						    $style = ".ion-loading-a, .ion-loading-b, .ion-loading-c, .ion-loading-d, .ion-looping, .ion-refreshing, .ion-ios7-reloading, .ionicons, .ion-alert, .ion-alert-circled, .ion-android-add, .ion-android-add-contact, .ion-android-alarm, .ion-android-archive, .ion-android-arrow-back, .ion-android-arrow-down-left, .ion-android-arrow-down-right, .ion-android-arrow-up-left, .ion-android-arrow-up-right, .ion-android-battery, .ion-android-book, .ion-android-calendar, .ion-android-call, .ion-android-camera, .ion-android-chat, .ion-android-checkmark, .ion-android-clock, .ion-android-close, .ion-android-contact, .ion-android-contacts, .ion-android-data, .ion-android-developer, .ion-android-display, .ion-android-download, .ion-android-dropdown, .ion-android-earth, .ion-android-folder, .ion-android-forums, .ion-android-friends, .ion-android-hand, .ion-android-image, .ion-android-inbox, .ion-android-information, .ion-android-keypad, .ion-android-lightbulb, .ion-android-locate, .ion-android-location, .ion-android-mail, .ion-android-microphone, .ion-android-mixer, .ion-android-more, .ion-android-note, .ion-android-playstore, .ion-android-printer, .ion-android-promotion, .ion-android-reminder, .ion-android-remove, .ion-android-search, .ion-android-send, .ion-android-settings, .ion-android-share, .ion-android-social, .ion-android-social-user, .ion-android-sort, .ion-android-star, .ion-android-stopwatch, .ion-android-storage, .ion-android-system-back, .ion-android-system-home, .ion-android-system-windows, .ion-android-timer, .ion-android-trash, .ion-android-volume, .ion-android-wifi, .ion-archive, .ion-arrow-down-a, .ion-arrow-down-b, .ion-arrow-down-c, .ion-arrow-expand, .ion-arrow-graph-down-left, .ion-arrow-graph-down-right, .ion-arrow-graph-up-left, .ion-arrow-graph-up-right, .ion-arrow-left-a, .ion-arrow-left-b, .ion-arrow-left-c, .ion-arrow-move, .ion-arrow-resize, .ion-arrow-return-left, .ion-arrow-return-right, .ion-arrow-right-a, .ion-arrow-right-b, .ion-arrow-right-c, .ion-arrow-shrink, .ion-arrow-swap, .ion-arrow-up-a, .ion-arrow-up-b, .ion-arrow-up-c, .ion-at, .ion-bag, .ion-battery-charging, .ion-battery-empty, .ion-battery-full, .ion-battery-half, .ion-battery-low, .ion-beaker, .ion-beer, .ion-bluetooth, .ion-bookmark, .ion-briefcase, .ion-bug, .ion-calculator, .ion-calendar, .ion-camera, .ion-card, .ion-chatbox, .ion-chatbox-working, .ion-chatboxes, .ion-chatbubble, .ion-chatbubble-working, .ion-chatbubbles, .ion-checkmark, .ion-checkmark-circled, .ion-checkmark-round, .ion-chevron-down, .ion-chevron-left, .ion-chevron-right, .ion-chevron-up, .ion-clipboard, .ion-clock, .ion-close, .ion-close-circled, .ion-close-round, .ion-cloud, .ion-code, .ion-code-download, .ion-code-working, .ion-coffee, .ion-compass, .ion-compose, .ion-connection-bars, .ion-contrast, .ion-disc, .ion-document, .ion-document-text, .ion-drag, .ion-earth, .ion-edit, .ion-egg, .ion-eject, .ion-email, .ion-eye, .ion-eye-disabled, .ion-female, .ion-filing, .ion-film-marker, .ion-flag, .ion-flash, .ion-flash-off, .ion-flask, .ion-folder, .ion-fork, .ion-fork-repo, .ion-forward, .ion-game-controller-a, .ion-game-controller-b, .ion-gear-a, .ion-gear-b, .ion-grid, .ion-hammer, .ion-headphone, .ion-heart, .ion-help, .ion-help-buoy, .ion-help-circled, .ion-home, .ion-icecream, .ion-icon-social-google-plus, .ion-icon-social-google-plus-outline, .ion-image, .ion-images, .ion-information, .ion-information-circled, .ion-ionic, .ion-ios7-alarm, .ion-ios7-alarm-outline, .ion-ios7-albums, .ion-ios7-albums-outline, .ion-ios7-arrow-back, .ion-ios7-arrow-down, .ion-ios7-arrow-forward, .ion-ios7-arrow-left, .ion-ios7-arrow-right, .ion-ios7-arrow-thin-down, .ion-ios7-arrow-thin-left, .ion-ios7-arrow-thin-right, .ion-ios7-arrow-thin-up, .ion-ios7-arrow-up, .ion-ios7-at, .ion-ios7-at-outline, .ion-ios7-bell, .ion-ios7-bell-outline, .ion-ios7-bolt, .ion-ios7-bolt-outline, .ion-ios7-bookmarks, .ion-ios7-bookmarks-outline, .ion-ios7-box, .ion-ios7-box-outline, .ion-ios7-briefcase, .ion-ios7-briefcase-outline, .ion-ios7-browsers, .ion-ios7-browsers-outline, .ion-ios7-calculator, .ion-ios7-calculator-outline, .ion-ios7-calendar, .ion-ios7-calendar-outline, .ion-ios7-camera, .ion-ios7-camera-outline, .ion-ios7-cart, .ion-ios7-cart-outline, .ion-ios7-chatboxes, .ion-ios7-chatboxes-outline, .ion-ios7-chatbubble, .ion-ios7-chatbubble-outline, .ion-ios7-checkmark, .ion-ios7-checkmark-empty, .ion-ios7-checkmark-outline, .ion-ios7-circle-filled, .ion-ios7-circle-outline, .ion-ios7-clock, .ion-ios7-clock-outline, .ion-ios7-close, .ion-ios7-close-empty, .ion-ios7-close-outline, .ion-ios7-cloud, .ion-ios7-cloud-download, .ion-ios7-cloud-download-outline, .ion-ios7-cloud-outline, .ion-ios7-cloud-upload, .ion-ios7-cloud-upload-outline, .ion-ios7-cloudy, .ion-ios7-cloudy-night, .ion-ios7-cloudy-night-outline, .ion-ios7-cloudy-outline, .ion-ios7-cog, .ion-ios7-cog-outline, .ion-ios7-compose, .ion-ios7-compose-outline, .ion-ios7-contact, .ion-ios7-contact-outline, .ion-ios7-copy, .ion-ios7-copy-outline, .ion-ios7-download, .ion-ios7-download-outline, .ion-ios7-drag, .ion-ios7-email, .ion-ios7-email-outline, .ion-ios7-eye, .ion-ios7-eye-outline, .ion-ios7-fastforward, .ion-ios7-fastforward-outline, .ion-ios7-filing, .ion-ios7-filing-outline, .ion-ios7-film, .ion-ios7-film-outline, .ion-ios7-flag, .ion-ios7-flag-outline, .ion-ios7-folder, .ion-ios7-folder-outline, .ion-ios7-gear, .ion-ios7-gear-outline, .ion-ios7-glasses, .ion-ios7-glasses-outline, .ion-ios7-heart, .ion-ios7-heart-outline, .ion-ios7-help, .ion-ios7-help-empty, .ion-ios7-help-outline, .ion-ios7-infinite, .ion-ios7-infinite-outline, .ion-ios7-information, .ion-ios7-information-empty, .ion-ios7-information-outline, .ion-ios7-ionic-outline, .ion-ios7-keypad, .ion-ios7-keypad-outline, .ion-ios7-lightbulb, .ion-ios7-lightbulb-outline, .ion-ios7-location, .ion-ios7-location-outline, .ion-ios7-locked, .ion-ios7-locked-outline, .ion-ios7-medkit, .ion-ios7-medkit-outline, .ion-ios7-mic, .ion-ios7-mic-off, .ion-ios7-mic-outline, .ion-ios7-minus, .ion-ios7-minus-empty, .ion-ios7-minus-outline, .ion-ios7-monitor, .ion-ios7-monitor-outline, .ion-ios7-moon, .ion-ios7-moon-outline, .ion-ios7-more, .ion-ios7-more-outline, .ion-ios7-musical-note, .ion-ios7-musical-notes, .ion-ios7-navigate, .ion-ios7-navigate-outline, .ion-ios7-paperplane, .ion-ios7-paperplane-outline, .ion-ios7-partlysunny, .ion-ios7-partlysunny-outline, .ion-ios7-pause, .ion-ios7-pause-outline, .ion-ios7-people, .ion-ios7-people-outline, .ion-ios7-person, .ion-ios7-person-outline, .ion-ios7-personadd, .ion-ios7-personadd-outline, .ion-ios7-photos, .ion-ios7-photos-outline, .ion-ios7-pie, .ion-ios7-pie-outline, .ion-ios7-play, .ion-ios7-play-outline, .ion-ios7-plus, .ion-ios7-plus-empty, .ion-ios7-plus-outline, .ion-ios7-pricetag, .ion-ios7-pricetag-outline, .ion-ios7-printer, .ion-ios7-printer-outline, .ion-ios7-rainy, .ion-ios7-rainy-outline, .ion-ios7-recording, .ion-ios7-recording-outline, .ion-ios7-redo, .ion-ios7-redo-outline, .ion-ios7-refresh, .ion-ios7-refresh-empty, .ion-ios7-refresh-outline, .ion-ios7-reload, .ion-ios7-rewind, .ion-ios7-rewind-outline, .ion-ios7-search, .ion-ios7-search-strong, .ion-ios7-skipbackward, .ion-ios7-skipbackward-outline, .ion-ios7-skipforward, .ion-ios7-skipforward-outline, .ion-ios7-snowy, .ion-ios7-speedometer, .ion-ios7-speedometer-outline, .ion-ios7-star, .ion-ios7-star-outline, .ion-ios7-stopwatch, .ion-ios7-stopwatch-outline, .ion-ios7-sunny, .ion-ios7-sunny-outline, .ion-ios7-telephone, .ion-ios7-telephone-outline, .ion-ios7-thunderstorm, .ion-ios7-thunderstorm-outline, .ion-ios7-time, .ion-ios7-time-outline, .ion-ios7-timer, .ion-ios7-timer-outline, .ion-ios7-trash, .ion-ios7-trash-outline, .ion-ios7-undo, .ion-ios7-undo-outline, .ion-ios7-unlocked, .ion-ios7-unlocked-outline, .ion-ios7-upload, .ion-ios7-upload-outline, .ion-ios7-videocam, .ion-ios7-videocam-outline, .ion-ios7-volume-high, .ion-ios7-volume-low, .ion-ios7-wineglass, .ion-ios7-wineglass-outline, .ion-ios7-world, .ion-ios7-world-outline, .ion-ipad, .ion-iphone, .ion-ipod, .ion-jet, .ion-key, .ion-knife, .ion-laptop, .ion-leaf, .ion-levels, .ion-lightbulb, .ion-link, .ion-load-a, .ion-load-b, .ion-load-c, .ion-load-d, .ion-location, .ion-locked, .ion-log-in, .ion-log-out, .ion-loop, .ion-magnet, .ion-male, .ion-man, .ion-map, .ion-medkit, .ion-mic-a, .ion-mic-b, .ion-mic-c, .ion-minus, .ion-minus-circled, .ion-minus-round, .ion-model-s, .ion-monitor, .ion-more, .ion-music-note, .ion-navicon, .ion-navicon-round, .ion-navigate, .ion-no-smoking, .ion-nuclear, .ion-paper-airplane, .ion-paperclip, .ion-pause, .ion-person, .ion-person-add, .ion-person-stalker, .ion-pie-graph, .ion-pin, .ion-pinpoint, .ion-pizza, .ion-plane, .ion-play, .ion-playstation, .ion-plus, .ion-plus-circled, .ion-plus-round, .ion-pound, .ion-power, .ion-pricetag, .ion-pricetags, .ion-printer, .ion-radio-waves, .ion-record, .ion-refresh, .ion-reply, .ion-reply-all, .ion-search, .ion-settings, .ion-share, .ion-shuffle, .ion-skip-backward, .ion-skip-forward, .ion-social-android, .ion-social-android-outline, .ion-social-apple, .ion-social-apple-outline, .ion-social-bitcoin, .ion-social-bitcoin-outline, .ion-social-buffer, .ion-social-buffer-outline, .ion-social-designernews, .ion-social-designernews-outline, .ion-social-dribbble, .ion-social-dribbble-outline, .ion-social-dropbox, .ion-social-dropbox-outline, .ion-social-facebook, .ion-social-facebook-outline, .ion-social-freebsd-devil, .ion-social-github, .ion-social-github-outline, .ion-social-googleplus, .ion-social-googleplus-outline, .ion-social-hackernews, .ion-social-hackernews-outline, .ion-social-linkedin, .ion-social-linkedin-outline, .ion-social-pinterest, .ion-social-pinterest-outline, .ion-social-reddit, .ion-social-reddit-outline, .ion-social-rss, .ion-social-rss-outline, .ion-social-skype, .ion-social-skype-outline, .ion-social-tumblr, .ion-social-tumblr-outline, .ion-social-tux, .ion-social-twitter, .ion-social-twitter-outline, .ion-social-vimeo, .ion-social-vimeo-outline, .ion-social-windows, .ion-social-windows-outline, .ion-social-wordpress, .ion-social-wordpress-outline, .ion-social-yahoo, .ion-social-yahoo-outline, .ion-social-youtube, .ion-social-youtube-outline, .ion-speakerphone, .ion-speedometer, .ion-spoon, .ion-star, .ion-stats-bars, .ion-steam, .ion-stop, .ion-thermometer, .ion-thumbsdown, .ion-thumbsup, .ion-trash-a, .ion-trash-b, .ion-umbrella, .ion-unlocked, .ion-upload, .ion-usb, .ion-videocamera, .ion-volume-high, .ion-volume-low, .ion-volume-medium, .ion-volume-mute, .ion-waterdrop, .ion-wifi, .ion-wineglass, .ion-woman, .ion-wrench, .ion-xbox";

$arr = explode(" ",$style);
foreach($arr as $k=>$v){
	echo '<div class="col-lg-3 col-xs-6"><div class="small-box bg-yellow"><div class="inner"><h3>0</h3><p>'.trim(trim($v,','),'.').'</p></div><div class="icon"><i class="ion '.trim(trim($v,','),'.').'"></i></div><a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a></div></div>';
}
						    ?>
                    		
                    	   
                    </div><!-- /.row -->

                   

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        
        
        <div id="addtext" style="display:none">
            <form action="" method="get" id="searchform">
            <input type="hidden" name="c" value="Games">
            <input type="hidden" name="a" value="gamelist">
            <!--
            <div class="form-group col-md-6">
                <select  class="form-control"  name="status">
                    <option value="">游戏状态</option>
                    <option value="1">正常</option>
                    <option value="0">下线</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <select  class="form-control"  name="save_enabled">
                    <option value="">是否支持存档</option>
                    <option value="1">支持</option>
                    <option value="0">不支持</option>
                    
                </select>
            </div>
            -->
            <div class="form-group col-md-3">
                <input type="text" name="gameid" placeholder="表单信息" class="form-control"/>
            </div>
            <div class="form-group col-md-3">
                <input type="text" name="gamename" placeholder="表单信息" class="form-control">
            </div>
            <div class="form-group col-md-3">
                <input type="text" name="gamelevelmin" placeholder="表单信息" class="form-control"/>
            </div>
            <div class="form-group col-md-3">
                <input type="text" name="gamelevelmax" placeholder="表单信息" class="form-control"/>
            </div>
            <div class="form-group col-md-6">
                <input type="text" name="gameplayermin" placeholder="表单信息" class="form-control"/>
            </div>
            <div class="form-group col-md-6">
                <input type="text" name="gameplayermax" placeholder="表单信息" class="form-control"/>
            </div>
            
            </form>
        </div>

        
        
        <include file="footer" />
		 
		<script>
       // JavaScript Document
		var daysInMonth = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);    //每月天数
		var today = new Today();    //今日对象
		var year = today.year;      //当前显示的年份
		var month = today.month;    //当前显示的月份
		
		//页面加载完毕后执行fillBox函数
		$(function() {
			fillBox();
		});
		//今日对象
		function Today() {
			this.now = new Date();
			this.year = this.now.getFullYear();
			this.month = this.now.getMonth();
			this.day = this.now.getDate();
		}
		
		//根据当前年月填充每日单元格
		function fillBox() {
			updateDateInfo();                   //更新年月提示
			$("td.calBox").empty();             //清空每日单元格
		
			var dayCounter = 1;                 //设置天数计数器并初始化为1
			var cal = new Date(year, month, 1); //以当前年月第一天为参数创建日期对象
			var startDay = cal.getDay();        //计算填充开始位置
			//计算填充结束位置
			var endDay = startDay + getDays(cal.getMonth(), cal.getFullYear()) - 1;
		
			//如果显示的是今日所在月份的日程，设置day变量为今日日期
			var day = -1;
			if (today.year == year && today.month == month) {
				day = today.day;
			}
		
			//从startDay开始到endDay结束，在每日单元格内填入日期信息
			for (var i=startDay; i<=endDay; i++) {
			///////////////
			var tempmonth; var tempday;
			if(month+1<10 ){ tempmonth="0"+(month+1);}else{tempmonth=(month+1); }
			if(dayCounter<10 ){ tempday="0"+dayCounter;}else{ tempday= dayCounter; }
			////////////////////////
				if (dayCounter==day) {
					$("#calBox" + i).html("<div class='date today' id='" + year + "-" + tempmonth + "-" + tempday + "' onclick='openAddBox(this)'>" + dayCounter + "</div>");
				} else {
					$("#calBox" + i).html("<div class='date' id='" + year + "-" + tempmonth + "-" + tempday + "' onclick='openAddBox(this)'>" + dayCounter + "</div>");
				}
				dayCounter++;
			}
			getTasks();                         //从服务器获取任务信息
		  $('#load-ing').hide();
		}
		
		//从服务器获取任务信息
		function getTasks() {
			  $.post('<?php echo U('Index/db'); ?>',{month: year + "-" + (month +1)},function(e){
				if(e != null){
				 $(e).each(function(i){
					buildTask(e[i].builddate, e[i].id, e[i].task);
				  } );
				}
			},'json')
		}
		
		//根据日期、任务编号、任务内容在页面上创建任务节点
		function buildTask(buildDate, taskId, taskInfo) {
			$("#" + buildDate).parent().append("<div id='task" + taskId + "' class='task' onclick='editTask(this)'>" + taskInfo + "</div>");
		}
		
		//判断是否闰年返回每月天数
		function getDays(month, year) {
			if (1 == month) {
				if (((0 == year % 4) && (0 != (year % 100))) || (0 == year % 400)) {
					return 29;
				} else {
					return 28;
				}
			} else {
				return daysInMonth[month];
			}
		}
		
		//显示上月日程
		function prevMonth() {
			if ((month - 1) < 0) {
				month = 11;
				year--;
			} else {
				month--;
			}
			fillBox();              //填充每日单元格
		}
		
		//显示下月日程
		function nextMonth() {
			if((month + 1) > 11) {
				month = 0;
				year++;
			} else {
				month++;
			}
			fillBox();              //填充每日单元格
		}
		
		//显示本月日程
		function thisMonth() {
			year = today.year;
			month = today.month;
			fillBox();              //填充每日单元格
		}
		
		//更新年月提示
		function updateDateInfo() {
			$("#dateInfo").html(year + "年" + (month + 1) + "月");
		}
		
		
		//打开新建任务box
		function openAddBox(src) {
			//alert(src.id);
			//$("#taskDate").html(src.id);                    //设置新建日期
			//var elem = document.getElementById(obj);
			art.dialog({
				content:$('#addtext').html(),
				lock:true,
				title: '添加课程',
				width:800,
				height:400,
				okValue: '添加课程',
				ok: function () {
					$('.aui_content').find('input').filter(function(index) {
						return $(this).val() == '';
					}).remove();
					$('.aui_content').find('form').submit();	
				},
				cancelValue:'取消',
				cancel: function () {
				}
			}).show();	
		 
		
		}
		
		
		

        </script>
        