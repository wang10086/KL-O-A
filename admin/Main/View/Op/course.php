<?php use Sys\P; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo P::SYSTEM_NAME; ?></title>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<link href="__HTML__/css/artDialog.css" rel="stylesheet" type="text/css"  />
<link href="__HTML__/css/date.css" rel="stylesheet" type="text/css" />
<style type="text/css">
td{ padding:4px;}
.task_blue{width: 94%;
margin:0 3%;
  overflow: hidden;
  height: 23px;
  line-height: 22px; 
  background: #00c0ef;
  border-radius: 4px;
  text-decoration:none;
  border: 1px solid #FFF;
  float:left; clear:both;
  color: #FFF;
  cursor: pointer;
  text-indent:10px;  
  }
.task_red{width: 94%;
margin:0 3%;
  overflow: hidden;
  height: 23px;
  line-height: 22px; 
  background: #f56954;
  border-radius: 4px;
  text-decoration:none;
  border: 1px solid #FFF;
  float:left; clear:both;
  color: #FFF;
  cursor: pointer;
  text-indent:10px;  
  }
 .task_gray{width: 94%;
margin:0 3%;
  overflow: hidden;
  height: 23px;
  line-height: 22px; 
  background: #cccccc;
  border-radius: 4px;
  text-decoration:none;
  border: 1px solid #FFF;
  float:left; clear:both;
  color: #FFF;
  cursor: pointer;
  text-indent:10px;  
  }
</style>
</head>

<body>

	
    <!-- 日历表格 -->
    <table id="calTable">
        <tr>
            <td colspan="7">
                <span id="dateInfo" style="float:left"></span>
                <div style="float:right">
                <button class="btn btn-default btn-sm fa fa-caret-left"  onClick="prevMonth()">上月</button>
                <button class="btn btn-default btn-sm fa "  onClick="thisMonth()">本月</button>
                <button class="btn btn-default btn-sm fa fa-caret-right"  onClick="nextMonth()">下月</button>
                </div>
            </td>
        </tr>
        <tr>
            <td class="day">周日</td>
            <td class="day">周一</td>
            <td class="day">周二</td>
            <td class="day">周三</td>
            <td class="day">周四</td>
            <td class="day">周五</td>
            <td class="day">周六</td>
        </tr>
        <tr>
            <td class="calBox sun" id="calBox0"></td>
            <td class="calBox" id="calBox1"></td>
            <td class="calBox" id="calBox2"></td>
            <td class="calBox" id="calBox3"></td>
            <td class="calBox" id="calBox4"></td>
            <td class="calBox" id="calBox5"></td>
            <td class="calBox sat" id="calBox6"></td>
        </tr>
        <tr>
            <td class="calBox sun" id="calBox7"></td>
            <td class="calBox" id="calBox8"></td>
            <td class="calBox" id="calBox9"></td>
            <td class="calBox" id="calBox10"></td>
            <td class="calBox" id="calBox11"></td>
            <td class="calBox" id="calBox12"></td>
            <td class="calBox sat" id="calBox13"></td>
        </tr>
        <tr>
            <td class="calBox sun" id="calBox14"></td>
            <td class="calBox" id="calBox15"></td>
            <td class="calBox" id="calBox16"></td>
            <td class="calBox" id="calBox17"></td>
            <td class="calBox" id="calBox18"></td>
            <td class="calBox" id="calBox19"></td>
            <td class="calBox sat" id="calBox20"></td>
        </tr>
        <tr>
            <td class="calBox sun" id="calBox21"></td>
            <td class="calBox" id="calBox22"></td>
            <td class="calBox" id="calBox23"></td>
            <td class="calBox" id="calBox24"></td>
            <td class="calBox" id="calBox25"></td>
            <td class="calBox" id="calBox26"></td>
            <td class="calBox sat" id="calBox27"></td>
        </tr>
        <tr>
            <td class="calBox sun" id="calBox28"></td>
            <td class="calBox" id="calBox29"></td>
            <td class="calBox" id="calBox30"></td>
            <td class="calBox" id="calBox31"></td>
            <td class="calBox" id="calBox32"></td>
            <td class="calBox" id="calBox33"></td>
            <td class="calBox sat" id="calBox34"></td>
        </tr>
        <tr>
            <td class="calBox sun" id="calBox35"></td>
            <td class="calBox" id="calBox36"></td>
            <td class="calBox" id="calBox37"></td>
            <td class="calBox" id="calBox38"></td>
            <td class="calBox" id="calBox39"></td>
            <td class="calBox" id="calBox40"></td>
            <td class="calBox sat" id="calBox41"></td>
        </tr>
    </table>
    <p style="font-size:14px; font-family:'微软雅黑'; color:#333">请点击日期排课，点击已排课程（蓝条）可移除该课程</p>
                    
    <!-- add new calendar event modal -->
    <!-- jQuery 1.11.1 -->
    <script src="__HTML__/js/jquery-1.7.2.min.js"></script> 
	<script src="__HTML__/js/artDialog.js"></script> 
    <script src="__HTML__/js/iframeTools.js"></script> 
	
    <script>
       // JavaScript Document
		var daysInMonth = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);    //每月天数
		var today = new Today();    //今日对象
		var year = today.year;      //当前显示的年份
		var month = today.month;    //当前显示的月份
		var timer;
		var jiesuan = <?php echo $jiesuan; ?>;
		
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
					$("#calBox" + i).html("<div class='date today' onclick='addTask(\"" + year + "-" + tempmonth + "-" + tempday + "\")' id='" + year + "-" + tempmonth + "-" + tempday + "'>" + dayCounter + "</div>");
				} else {
					$("#calBox" + i).html("<div class='date' onclick='addTask(\"" + year + "-" + tempmonth + "-" + tempday + "\")'  id='" + year + "-" + tempmonth + "-" + tempday + "' >" + dayCounter + "</div>");
				}
				dayCounter++;
			}
			getTasks();                         //从服务器获取任务信息
		  $('#load-ing').hide();
		}
		
		//增加
		function addTask(date){
			if(parseInt(jiesuan)==1){
				art.dialog.alert('项目已结算，不可变更课期','warning');
				return false;
			}else{
				$.get("<?php echo U('Op/addcourse'); ?>",{date:date,op_id:<?php echo $op_id; ?>,guide_id:<?php echo $guide_id; ?>}, function(result){
					if(result){
						buildTask(date, result, <?php echo cookie('userid'); ?>);
						remoTask();
						return false;
					}
				});	
				
			}
		}
		
		//删除
		function remoTask(){
			
			$('.task_blue').each(function(index, element) {
                $(this).click(function(){
					if(parseInt(jiesuan)==1){
						art.dialog.alert('项目已结算，不可变更课期','warning');
						return false;
					}else{
						var id = parseInt($(this).attr('date'));
						//alert(id);
						$.get("<?php echo U('Op/delcourse'); ?>",{id:id}, function(data,status){
							if(data){
								$('#t_'+id).remove();
								return false;
							}
						});	
					}
				
				})
            });
			
			
			$('.task_red').each(function(index, element) {
                $(this).click(function(){
					art.dialog.alert('您没有权限变更此排期','warning');
					return false;
				})
            });
			
			$('.task_gray').each(function(index, element) {
                $(this).click(function(){
					art.dialog.alert('项目已结算，不可变更课期','warning');
					return false;
				})
            });
			
			
		}
		
		//从服务器获取任务信息
		function getTasks() {
			$.post('index.php?m=Main&c=Op&a=courselist&opid=<?php echo $op_id; ?>&id=<?php echo $guide_id; ?>',{month: year + "-" + (month +1)},function(e){
				if(e != null){
					$(e).each(function(i){
						buildTask(e[i].builddate, e[i].id, e[i].task);
						remoTask();
					} );
				}
			},'json')
		}
		
		//根据日期、任务编号、任务内容在页面上创建任务节点
		function buildTask(buildDate, taskId, taskInfo) {
			if(parseInt(jiesuan)==1){
				$("#" + buildDate).parent().append("<a href='javascript:;'  date='"+taskId+"' id='t_"+parseInt(taskId)+"'  class='task_gray' target='_blank'>✔ " + taskId + "</a>");
			}else{
				if(parseInt(taskInfo) == parseInt(<?php echo cookie('userid'); ?>)){
					$("#" + buildDate).parent().append("<a href='javascript:;'  date='"+taskId+"' id='t_"+parseInt(taskId)+"'  class='task_blue' target='_blank'>✔ " + taskId + "</a>");
				}else{
					$("#" + buildDate).parent().append("<a href='javascript:;'  date='"+taskId+"' id='t_"+parseInt(taskId)+"'  class='task_red' target='_blank'>✔ " + taskId + "</a>");
				}
			}
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
			remoTask();
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
			remoTask();
		}
		
		//显示本月日程
		function thisMonth() {
			year = today.year;
			month = today.month;
			fillBox();              //填充每日单元格
			remoTask();
		}
		
		//更新年月提示
		function updateDateInfo() {
			$("#dateInfo").html(year + "年" + (month + 1) + "月");
		}
		
		
		$(document).ready(function(e) {
            remoTask();
        });
		
		
		
		artDialog.alert = function (content, status) {
			return artDialog({
				id: 'Alert',
				icon: status,
				width:300,
				height:120,
				fixed: true,
				lock: true,
				time: 1,
				content: content,
				ok: true
			});
		};

        </script>                          
		
        
                

    </body>
</html>                               
                                    
                                    
      	
        