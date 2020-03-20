<include file="Index:header2" />

        <div class="wrapper row-offcanvas row-offcanvas-left">

			<include file="menu" />

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {:P::SYS_NAME}流程管理系统<?php echo "<small>&nbsp;版本号：".P::ZVERSION."</small>"; ?>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href=""><i class="fa fa-home"></i> 首页</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <!--<div class="mqe">
                        	<i class="fa fa-bell lefts"> 公告：</i>
                            <div class="indexmarquee">
                            	<foreach name="notice" item="row">
                                <a href="javascript:;" <?php /*if($row['source']==1){ echo ' onClick="qadetail('.$row['source_id'].')"';}else{ echo 'onClick="show_notice('.$row['id'].')"';} */?> >{$row.title}</a>
                                </foreach>
                            </div>
                            <i class="fa fa-bars rights"></i>
                        </div>-->
                        <div style="margin-top:15px;"></div>
                    </div><!-- /.row -->

                    <!-- Main row -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">待办事项</h3>
                                </div>
                                <div class="box-body">
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
                                </div>
                            </div>
                        </div>
                    </div><!-- /.row (main row) -->

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->


        <div id="addtext" style="display:none">
            <form action="" method="get" id="searchform">
            <input type="hidden" name="c" value="Games">
            <input type="hidden" name="a" value="gamelist">
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


        <div id="textinfo" style="display:none">

        </div>



        <include file="footer2" />

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
					$("#calBox" + i).html("<div class='date today' id='" + year + "-" + tempmonth + "-" + tempday + "'>" + dayCounter + "</div>");
				} else {
					$("#calBox" + i).html("<div class='date' id='" + year + "-" + tempmonth + "-" + tempday + "' >" + dayCounter + "</div>");
				}
				dayCounter++;
			}
			getTasks();                         //从服务器获取任务信息
		  $('#load-ing').hide();
		}

		//从服务器获取任务信息
		function getTasks() {
			  /*$.post('<?php echo U('Index/public_db'); ?>',{month: year + "-" + (month +1)},function(e){
				if(e != null){
				 $(e).each(function(i){
					buildTask(e[i].builddate, e[i].id, e[i].task);
				  } );
				}
			},'json')*/
		}

		//根据日期、任务编号、任务内容在页面上创建任务节点
		function buildTask(buildDate, taskId, taskInfo) {
            <?php if(in_array(cookie('userid'),array(11,77)) || cookie('username')==C('RBAC_SUPER_ADMIN')){ ?>
                $("#" + buildDate).parent().append("<a href='index.php?m=Main&c=Op&a=plans_follow&opid="+taskId+"' title='" + taskInfo + "' class='task_blue' target='_blank'>" + taskInfo + "</a>");
            <?php }else{ ?>
                $("#" + buildDate).parent().append("<a href='index.php?m=Main&c=Sale&a=goods&opid="+taskId+"' title='" + taskInfo + "' class='task_blue' target='_blank'>" + taskInfo + "</a>");
            <?php } ?>
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


		$(document).ready(function(e) {
            $('.indexmarquee').liMarquee({
				 runshort: false
			});
        });


		 //查看详情
		function qadetail(id) {
			art.dialog.open('index.php?m=Main&c=Kpi&a=qadetail&id='+id,{
				lock:true,
				title: '品质检查详情',
				width:800,
				height:'90%',
				fixed: true,

			});
		}



        </script>
