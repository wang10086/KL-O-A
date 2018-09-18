<include file="Index:header2" />
<script src="__HTML__/js/public.js?v=1.0.6" type="text/javascript"></script>
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>员工薪资</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Salary/salaryindex')}"><i class="fa fa-gift"></i>人力管理</a></li>
                        <li class="active">员工薪资</li>
                    </ol>

                </section>

                <!-- Main content -->
                <section class="content" >

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">人员薪资列表</h3>
                                    <div class="box-tools pull-right">
                                        <a href="{:U('Salary/salary_query')}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 数据录入</a>
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,160);"><i class="fa fa-search"></i> 搜索</a>
                                        <a class="btn btn-sm salary_moduser1" style="background-color:#398439;border: #398439"><i class="fa fa-plus"></i>生成工资表</a>
                                         
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:8px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" data="op_id">ID</th>
                                        <th class="sorting" data="group_id">员工姓名</th>
                                        <th class="sorting" data="group_id">员工编号</th>
                                        <th class="sorting" data="project">岗位薪酬标准</th>
                                        <th class="sorting" data="shouru">考勤扣款</th>
                                        <th class="sorting" data="number">绩效增减</th>
                                        <th class="sorting" data="shouru">带团补助</th>
                                        <th class="sorting" data="shouru">提成/补助/奖金</th>
                                        <th class="sorting" data="shouru">应发工资</th>
                                        <th class="sorting" data="maoli">五险一金</th>
                                        <th class="sorting" data="number">代扣代缴</th>
                                        <th class="sorting" data="number">实际工资</th>
                                        <th width="50" class="taskOptions">薪资月份</th>
                                        <th width="50" class="taskOptions">详情</th>
                                        </if>
                                        
                                    </tr>


                                    <foreach name="info" item="info">
                                    <tr>
                                        <td>{$info.account_id}</td>
                                        <td>{$info.nickname}</td>
                                        <td>{$info.employee_member}</td>
                                        <td>&yen; {$info.standard}</td>
                                        <td>&yen; {$info.withdrawing}</td>
                                        <td>&yen; {$info.Achievements_withdrawing}</td>
                                        <td>&yen; {$info.Subsidy}</td>
                                        <td>&yen; {$info.total}</td>
                                        <td>&yen; {$info.Should_distributed}</td>
                                        <td>&yen; {$info.risks}</td>
                                        <td>&yen; {$info.Withhold}</td>
                                        <td>&yen; {$info.money}</td>
                                        <td>{$info.datetime}</td>
                                        <td><a href="{:U('Salary/salarydetails',array('id'=>$info['account_id'],'datetime'=>$info['datetime']))}" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i>查看详情</a></td>

                                    </tr>
                                    </foreach>
                                </table>
                                </div><!-- /.box-body -->
                                 <div class="box-footer clearfix">
                                	<div class="pagestyle">{$page}</div>
                                </div>
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                     </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->


            <div id="searchtext">
                <script src="__HTML__/js/public.js?v=1.0.6" type="text/javascript"></script>

                <form action="{:U('Salary/salaryindex')}" method="post" id="searchform">

                <div class="form-group col-md-3">
                    <input type="text" class="form-control" name="id" placeholder="ID编号">
                </div>
                    <div class="form-group col-md-3">
                        <input type="text" class="form-control" name="employee_member" placeholder="员工编号">
                    </div>

                <div class="form-group col-md-3">
                    <input type="text" class="form-control" name="name" placeholder="员工姓名">
                </div>

                <div class="form-group col-md-3">
                    <input type="text" name="month" class="form-control monthly" placeholder="年月/201806" />
<!--                    <input type="date" class="form-control" name="salary_time" placeholder="年月" id="nowTime">-->
                </div>

                </form>
            </div>
<form class="form-horizontal" id="salary_pop1" action="{:U('user/updates')}" method="post" style="display: none">
    <input type="hidden" name="id" value="{$id}" />
    <div class="form-group">
        <label class="col-sm-2 control-label">用户名</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="user_login" value="{$user_login}" placeholder="请输入用户名" />
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <a class="btn btn-primary" id="ajaxform">提 交</a>
        </div>
    </div>
</form>


<include file="Index:footer2" />


<script>
    function p(s){ //时间格式
        return s < 10 ? '0' + s : s;
    }
   $('.salary_moduser1').click(function(){

       var myDate = new Date();
       //获取当前年
       var year=myDate.getFullYear();
        //获取当前月
       var month=myDate.getMonth()+1;
       var now=year+'-'+p(month)+"-"+p(20);
//       alert(now);
        if(!msg){
            var msg = '将生成'+now+'月份工资表，操作前请确认所有数据录入事项均已完成！';
        }
        art.dialog({
            title: '生成工资表',
            width:400,
            height:100,
            lock:true,
            fixed: true,
            content: '<span style="width:100%; text-align:center; font-size:18px;float:left; clear:both;">'+msg+'</span>',
            okValue:'数据录入',
            ok: function () {
                //window.location.href=url;
                //this.title('3秒后自动关闭').time(3);
                $('#'+obj).submit();
                return false;
            },
            cancelValue: '确定',
            cancel: function () {
            }
        });
    })
</script>
