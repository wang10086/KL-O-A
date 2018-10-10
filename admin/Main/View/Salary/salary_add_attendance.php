<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        考勤数据录入
                    </h1>

                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Salary/salaryindex')}"><i class="fa fa-gift"></i> 人力资源</a></li>
                        <li class="active">考勤数据录入</li>
                    </ol>

                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">

                                    <div class="box-tools pull-left">
                                       <h4>考勤数据添加</h4>
                    
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <div class="btn-group" id="salary_add_backcolor">
                                    <!-- 数据添加 -->
                                    <div style="float: left;margin-left: 2em;">
                                        <label>选择人员：</label>
                                        <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,160);"><i class="fa fa-search"></i> 搜索</a> (提示: 选择不到人员或基本信息不完整、错误时，请在“员工管理”->"人员管理"页面添加或编辑信息)<br><br>

                                        <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                            <tr role="row" class="orders" >
                                                <th class="sorting" style="width:4em;">ID</th>
                                                <th class="sorting" style="width:5em;">员工姓名</th>
                                                <th class="sorting" style="width:5em;">员工编号</th>
                                                <th class="sorting" style="width:6em;">员工部门</th>
                                                <th class="sorting" style="width:8em;">员工岗位</th>
                                                <th class="sorting" style="width:12em;">迟到/早退(15分钟)</th>
                                                <th class="sorting" style="width:12em;">迟到/早退(2小时)</th>
                                                <th class="sorting" style="width:5em;">事假</th>
                                                <th class="sorting" style="width:5em;">年假</th>
                                                <th class="sorting" style="width:5em;">病假</th>
                                                <th class="sorting" style="width:10em;">北京最低工资标准</th>
                                                <th class="sorting" style="width:5em;">旷工</th>
                                                <th class="sorting" style="width:10em;">缺勤天数</th>
                                                <th class="sorting" style="width:5em;">扣款</th>
                                                <th class="sorting" style="width:6em;">操作</th>
                                                </if>
                                            </tr>

                                            <foreach name="list" item="row">
                                                <tr class="salary_tr">
                                                    <td>{$row.aid}</td>
                                                    <td>{$row.nickname}</td>
                                                    <td>{$row.employee_member}</td>
                                                    <td>{$row.department}</td>
                                                    <td>{$row.post_name}</td>
                                                    <td><input type="text" name="aid" class="form-control late1" value="{$row.salary_attendance.late1}"/></td>
                                                    <td><input type="text" name="aid" class="form-control late2" value="{$row.salary_attendance.late2}"/></td>
                                                    <td><input type="text" name="aid" class="form-control leave_absence" value="{$row.salary_attendance.leave_absence}"/></td>
                                                    <td><input type="text" name="aid" class="form-control year_leave" value=""/></td>
                                                    <td><input type="text" name="aid" class="form-control sick_leave" value="{$row.salary_attendance.sick_leave}"/></td>
                                                    <td><input type="text" name="aid" class="form-control lowest_wage" value="" /></td>
                                                    <td><input type="text" name="aid" class="form-control absenteeism" value="{$row.salary_attendance.absenteeism}"/></td>
                                                    <td><input type="text" class="form-control salary_add_date" value="{$row.salary_attendance.entry_data}"></td>
                                                    <input type="hidden" class="salary_add_aid" value="{$row.aid}">
                                                    <input type="hidden" class="salary_add_hidden" value="{$row['salary']['standard_salary']*$row['salary']['basic_salary']/10}">
                                                    <input type="hidden" class="salary_add_hidden11" value="{$row['salary']['standard_salary']}">
                                                    <td class="salary_add_withdrawing">0.00</td>
                                                    <td><input type="button" value="保存" style="background-color:#00acd6;font-size:1em;" class="salary_add_button"></td>
                                                </tr>
                                            </foreach>
                                        </table>
                                    </div>
                                    <div class="box-footer clearfix">
                                        <div class="pagestyle">{$page}</div>
                                    </div>
                                </div><!-- /.box -->
                        </div><!-- /.col -->
                     </div>

                        <div id="searchtext">
                            <script src="__HTML__/js/public.js?v=1.0.6" type="text/javascript"></script>

                            <form action="{:U('Salary/salary_add_attendance')}" method="post" id="searchform">

                                <div class="form-group col-md-4">
                                    <input type="text" class="form-control" name="id" placeholder="ID编号">
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="text" class="form-control" name="employee_member" placeholder="员工编号">
                                </div>

                                <div class="form-group col-md-4">
                                    <input type="text" class="form-control" name="nickname" placeholder="员工姓名">
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="text" class="form-control" name="departmen" placeholder="部门">
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="text" class="form-control" name="posts" placeholder="岗位">
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="text" class="form-control" name="all" placeholder="输入'所有' 查询所有">
                                </div>
                            </form>
                        </div>
                </section><!-- /.content -->
                <!--   操作历史 -->

                <div class="salary_history_page">

                </div>

            </aside><!-- /.right-side -->


<include file="Index:footer2" />


<script>
    $(function () {
        $(document).click(function(event){
            $('.salary_tr').each(function () {
                var late1               = Number($(this).find(".late1").val());// 早退 15分钟以
                var late2               = Number($(this).find(".late2").val());//早退 15分钟以上
                var leave_absence       = Number($(this).find(".leave_absence").val());//事假
                var sick_leave          = Number($(this).find(".sick_leave").val());//病假 天数
                var absenteeism         = Number($(this).find(".absenteeism").val());//旷工
                var salary_add_hidden   = Number($(this).find(".salary_add_hidden").val());//基本薪资标准
                var salary_date         = Number($(this).find(".salary_add_date").val());//缺勤天数
                var money               = Number($(this).find(".lowest_wage").val());//北京最低工资标准的80%是病假扣费
                var num                 = Number($(this).find(".salary_add_hidden11").val());//岗位薪资
                var sum                 = late1*10+late2*30+(salary_add_hidden/21.75)*leave_absence+(salary_add_hidden-(money*0.8))/21.75*sick_leave+(salary_add_hidden/21.75)*absenteeism*2+(num/21.75*salary_date);

                var count               = Number(Math.floor(sum*100)/100);
               // var salary_add_withdrawing = $(".salary_add_withdrawing").text();
                $(this).find('.salary_add_withdrawing').text(count);
            });

        });

        $.ajax({
            url:"{:U('Salary/salary_list')}",
            type:"GET",
            data:{'status':12},
            dataType:"html",
            success:function(result){
                $('.salary_history_page').html(result);
            }
        });
    });
    function salary_list(page){
        $.ajax({
            url:"{:U('Salary/salary_list')}",
            type:"GET",
            data:{'status':12,'page':page},
            dataType:"html",
            success:function(result){
                $('.salary_history_page').html(result);
            }
        });
    }

    $('.salary_add_button').click(function(){
        var late1               = $(this).parents('tr').find(".late1").val();
        var late2               = $(this).parents('tr').find(".late2").val();
        var leave_absence       = $(this).parents('tr').find(".leave_absence").val();
        var sick_leave          = $(this).parents('tr').find(".sick_leave").val();
        var absenteeism         = $(this).parents('tr').find(".absenteeism").val();
        var withdrawing         = $(this).parents('tr').find(".salary_add_withdrawing").text();
        var account_id          = $(this).parents('tr').find(".salary_add_aid").val();
        var salary_date         = $(this).parents('tr').find(".salary_add_date").val();//入离职天数
        var money               = $(this).parents('tr').find(".lowest_wage").val();//北京最低工资标准的80%是病假扣费
        var year_leave          = $(this).parents('tr').find(".year_leave").val();//年假
        $.ajax({
            type: "post",
            url: "{:U('Ajax/salaryattendance')}", //url
            data: {'account_id':account_id,'late1':late1,'late2':late2,'leave_absence':leave_absence,'sick_leave':sick_leave,'absenteeism':absenteeism,'salary_date':salary_date,'withdrawing':withdrawing,'money':money,'year_leave':year_leave},
            dataType: "json", //数据格式
            success: function (data) {
                if(data.sum==1){
                    alert(data.msg);die;
                }
                if(data.sum==0){
                    alert(data.msg);die;
                }
            }
        });

    })


</script>
