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
                                        <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,160);"><i class="fa fa-search"></i> 搜索</a>
                                        <if condition="rolemenu(array('Salary/salary_query'))">
                                            <a href="{:U('Salary/salary_query')}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 数据录入</a>
                                        </if>
                                        <if condition="rolemenu(array('Salary/salary_excel_list'))">
                                            <a class="btn btn-sm salary_moduser1" style="background-color:#398439;border: #398439"><i class="fa fa-plus"></i> 生成工资表</a>
                                        </if>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:8px;">
                                        <tr role="row" class="orders" >
                                            <th class="sorting" data="">ID</th>
                                            <th class="sorting" data="">员工姓名</th>
                                            <th class="sorting" data="">员工部门</th>
                                            <th class="sorting" data="">岗位薪酬标准</th>
                                            <th class="sorting" data="">考勤扣款</th>
                                            <th class="sorting" data="">绩效增减</th>
                                            <th class="sorting" data="">带团补助</th>
                                            <th class="sorting" data="">提成/补助/奖金</th>
                                            <th class="sorting" data="">应发工资</th>
                                            <th class="sorting" data="">五险一金</th>
                                            <th class="sorting" data="">代扣代缴</th>
                                            <th class="sorting" data="">实发工资</th>
                                            <th width="50" class="taskOptions">薪资月份</th>
                                            <th width="50" class="taskOptions">详情</th>

                                        </tr>

                                        <foreach name="lists" item="info">
                                            <tr>
                                                <td>{$info.account_id}</td>
                                                <td>{$info.user_name}</td>
                                                <td>{$info.department}</td>
                                                <td>&yen; {$info.standard}</td>
                                                <td>&yen; {$info.withdrawing}</td>
                                                <td>&yen; {$info.Achievements_withdrawing}</td>
                                                <td>&yen;{$info.Subsidy}</td>
                                                <!--<td>&yen; {$info.welfare}</td>-->
                                                <td>&yen; {$info.total}</td>
                                                <td>&yen; {$info.Should_distributed}</td>
                                                <td>&yen; {$info.insurance_Total}</td>
                                                <td>&yen; {$info.summoney}</td>
                                                <td>&yen; {$info.real_wages}</td>
                                                <td> {$info.datetime}</td>
                                                <td><a href="{:U('Salary/salarydetails',array('id'=>$info['id']))}" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i>查看详情</a></td>
                                            </tr>
                                        </foreach>
                                    </table>
                                    <?php if(count($info)==0){ echo '<br><br><br></center><h2 style="text-align: center;">抱歉!暂无您的工资信息!</h2><br><br>';}?>

                                </div><!-- /.box-body -->
                                 <div class="box-footer clearfix">
                                	<div class="pagestyle">{$pages}</div>
                                </div>
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                     </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->

        <!--<form class="form-horizontal" id="salary_pop1" action="{:U('user/updates')}" method="post" style="display: none">
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
        </form>-->

<div id="searchtext">
    <form action="{:U('Salary/salaryindex')}" method="post" id="searchform">
        <div class="form-group col-md-6">
            <input type="text" class="form-control" name="name" placeholder="姓名">
        </div>
        <div class="form-group col-md-6">
            <input type="text" class="form-control" name="id" placeholder="员工ID">
        </div>
        <div class="form-group col-md-6">
            <input type="text" class="form-control" name="department" placeholder="部门">
        </div>
        <div class="form-group col-md-6">
            <input type="text" class="form-control monthly" name="month" placeholder="年月/201806" />
        </div>
    </form>
</div>


<include file="Index:footer2" />


<script>
    function p(s){ //时间格式
        return s < 10 ? '0' + s : s;
    }
    function Atime(y,m,d){

        //if(d < 16){
        if(d < 30){
            if(m==1){
                m=13;
            }
            m = m-1;
                return  m;//查询年月
        }
        return m;
    }
   $('.salary_moduser1').click(function(){
       var myDate       = new Date();
       var year         = myDate.getFullYear();//获取当前年
       var month        = myDate.getMonth()+1;//获取当前月
       var date         = myDate.getDate();//当前日
       var Appointime   = Atime(year,month,date);//工资月分

       if(Appointime==12 && date < 16){
           year = year-1;
       }
       var currenttime  = year+p(Appointime).toString();//当前时间

       var msg = '将生成'+' '+currenttime+' '+'月份工资表，操作前请确认所有数据录入事项均已完成！';
       var url ='/index.php?m=Main&c=Salary&a=salary_excel_list&datetime='+currenttime;
       //var url1 ="{:U('Salary/salary_query')}";
       art.dialog({
               content:msg,
           lock:true,
           title: "生成工资表",
           width:'500px',
           height:'200px',
           button:[
               {name:'生成工资发放表',
                   class:'aui_state_highlight',
                   callback:function(){
                       window.location.href=url;
                       return false;
                   }
               }/*,
               {name:'录入数据',
                   class:'aui_state_highlight',
                   callback:function(){
                       window.location.href=url1;
                       return false;
                   }
               },*/
               ],

           cancelValue:'取消',
           cancel: function () {
           }
       }).show();

       $('.aui_buttons button').addClass('aui_state_highlight');

    })



</script>
