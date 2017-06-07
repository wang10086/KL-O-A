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
			var tempmonth; var tempday;
			if(month+1<10 ){ tempmonth="0"+(month+1);}else{tempmonth=(month+1); }
			if(dayCounter<10 ){ tempday="0"+dayCounter;}else{ tempday= dayCounter; }
			
			jin = year + "-" + tempmonth + "-" + tempday;
			
			if (dayCounter==day) {
				//$("#calBox" + i).html("<div class='date today' id='" + year + "-" + tempmonth + "-" + tempday + "' onclick='openAddBox(\""+jin+"\",0)'>" + dayCounter + "</div>");
				$("#calBox" + i).html("<div class='nodate today' id='" + year + "-" + tempmonth + "-" + tempday + "'>" + dayCounter + "</div>");
			}else if (dayCounter<day || year<today.year || month<today.month) {
				$("#calBox" + i).html("<div class='nodate' id='" + year + "-" + tempmonth + "-" + tempday + "'>" + dayCounter + "</div>");
			} else {
				$("#calBox" + i).html("<div class='date' id='" + year + "-" + tempmonth + "-" + tempday + "' onclick='openAddBox(\""+jin+"\",0)'>" + dayCounter + "</div>");
			}
			dayCounter++;
		}
		getTasks();                         //从服务器获取任务信息
	  $('#load-ing').hide();
	}
	
	//从服务器获取任务信息
	function getTasks() {
		  $.post(web_path+'op.php?m=Main&c=Plan&a=schedule',{month: year + "-" + (month +1)},function(e){
			if(e != null){
			 $(e).each(function(i){
				buildTask(e[i].builddate, e[i].id, e[i].task, e[i].style, e[i].status);
			  } );
			}
		},'json')
	}
	
	//根据日期、任务编号、任务内容在页面上创建任务节点
	function buildTask(buildDate, taskId, taskInfo, style, status) {
		$("#" + buildDate).parent().append("<div id='task" + taskId + "' class='" + style + "' onclick='Taskinfo("+taskId+","+ status +")'>" + taskInfo + "</div>");
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
	function openAddBox(ondate,id,re) {
		art.dialog.open(web_path+'op.php?m=Main&c=Plan&a=plan_add&date='+ondate+'&id='+id+'&re='+re,{
			lock:true,
			title: '编辑计划',
			width:860,
			height:500,
			okValue: '提交',
			ok: function () {
				this.iframe.contentWindow.gosubmint();
				return false;
			},
			cancelValue:'取消',
			cancel: function () {
			}
		});	
	}
	
	//获取签到二维码
	function signcode(id) {
		art.dialog.open(web_path+'op.php?m=Main&c=Plan&a=signcode&id='+id,{
			lock:true,
			padding: 0,
			title: '签到二维码',
			width:480,
			height:500,
		});	
	}
	
	
	//开课
	function startTask(id){
		art.dialog.open(web_path+'op.php?m=Main&c=Plan&a=implement&id='+id,{
			width: '100%',
			height: '100%',
			left: '0%',
			top: '0%',
			title: '培训实施',
			fixed: true,
			resize: false,
			drag: false
		})
	}
	
	
	//课堂记录
	function record(id){
		art.dialog.open(web_path+'op.php?m=Main&c=Plan&a=record_add&save=1&id='+id,{
			width: '100%',
			height: '100%',
			left: '0%',
			top: '0%',
			title: '课堂记录',
			fixed: true,
			resize: false,
			drag: false
		})
	}
	
	//查看详情
	function Taskinfo(id,status) {
		
		//编辑按钮
		var btn_edit   = {name: '编辑',callback: function () {openAddBox('',id);},focus: true}
		//重新开课
		var btn_re     = {name: '重新开课',callback: function () {openAddBox('',id,1);},focus: true}
		//生成二维码按钮
		var btn_code   = {name: '签到二维码',callback: function () {signcode(id);},focus: true}
		//课堂记录
		var btn_record = {name:'课堂记录',callback:function(){ record(id); },focus:true}
		//开课
		var btn_start = {name:'开始上课',callback:function(){ startTask(id); },focus:true}
		
		
		if(status == 1){
			var btns = [btn_start,btn_record];	
		}
		if(status==2){
			var btns = [btn_edit];	
		}
		if(status==3){
			var btns = [btn_re];	
		}
		
		art.dialog.open(web_path+'op.php?m=Main&c=Plan&a=plan_info&id='+id,{
			lock:true,
			title: '课程介绍',
			width:860,
			height:500,
			okValue: '提交',
			button: btns
		});	
		
	}