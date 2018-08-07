<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>员工薪资</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Salary/salaryindex')}"><i class="fa fa-gift"></i>{$ptitle}</a></li>
                        <li class="active">{$title}</li>
                    </ol>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">人员薪资列表</h3>
                                    <div class="box-tools pull-right">
                                        <a href="{:U('Salary/salaryadd')}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 新增顶级分类</a>
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,160);"><i class="fa fa-search"></i> 搜索</a>
                                         
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" data="op_id">ID</th>
                                        <th class="sorting" data="group_id">姓名</th>
                                        <th class="sorting" data="group_id">员工编号</th>
                                        <th class="sorting" data="project">岗位薪酬标准</th>
                                        <th class="sorting" data="number">考勤扣款</th>
                                        <th class="sorting" data="number">绩效增减</th>
                                        <th class="sorting" data="shouru">应发工资</th>
                                        <th class="sorting" data="maoli">各项扣款</th>
                                        <th width="50" class="taskOptions">详情</th>
                                        </if>
                                        
                                    </tr>
                                    <tr>
                                        <td>122</td>
                                        <td>刘金磊</td>
                                        <td>564654</td>
                                        <td>&yen; 5888.00</td>
                                        <td>&yen; 500.00</td>
                                        <td>&yen; 9000.00<if condition="($row.achievements_status eq 1)">+</if><if condition="($row.achievements_status eq 2)">-</if><if condition="($row.achievements_status eq 3)"></if>{$row.achievements}</td>
                                        <td>&yen; 899.00</td>
                                        <td>&yen; 588888.00(元)</td>
                                        <td><a href="{:U('Salary/salarydetails',array('id'=>$row['id']))}" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i>查看详情</a></td>

                                    </tr>
                                    <foreach name="list" item="row">
                                    <tr>
                                        <td>{$row.id}</td>
                                        <td>{$row.user_name}</td>
                                        <td>{$row.employee_member}</td>
                                        <td>&yen; {$row.wages}</td>
                                        <td>&yen; {$row.deduction_money}</td>
                                        <td>&yen; <if condition="($row.achievements_status eq 1)">+</if><if condition="($row.achievements_status eq 2)">-</if><if condition="($row.achievements_status eq 3)"></if>{$row.achievements}</td>
                                        <td>&yen; {$row.post_tax_wage}</td>
                                        <td>&yen; {$row.deduction_money}(考勤扣款)+&yen; {$row.personal_income_tax}(个人所得税)+&yen; {$row.year_end_personal_income_tax}(年终奖个税)+&yen; {$row.trade_union_fee}(工会会费)+&yen; {$row.insu_money}(五险一金)=&yen; {$row._money}(元)</td>
                                        <td><a href="{:U('Salary/salarydetails',array('id'=>$row['id']))}" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i>查看详情</a></td>

                                    </tr>
                                    </foreach>
                                </table>
                                </div><!-- /.box-body -->
                                 <div class="box-footer clearfix">
                                	<div class="pagestyle">{$pages}</div>
                                </div>
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                     </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->


            <div id="searchtext">
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
                    <select name="staff_style" class="form-control">
                        <option value="0">员工类别</option>
                        <option value="1">新入职</option>
                        <option value="2">转正</option>
                        <option value="3">正式</option>
                        <option value="4">实习</option>
                        <option value="6">试用</option>
                        <option value="7">劳务</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <input type="date" class="form-control" name="salary_time" placeholder="年月" id="nowTime">
                </div>

                </form>
            </div>

<include file="Index:footer2" />
<script type="text/javascript">
    function current(){
        var d=new Date(),str='';
        str +=d.getFullYear()+'年'; //获取当前年份
        str +=d.getMonth()+1+'月'; //获取当前月份（0——11）
        //str +=d.getDate()+'日';
        //str +=d.getHours()+'时';
        //str +=d.getMinutes()+'分';
        //str +=d.getSeconds()+'秒';
        return str;
    }
    setInterval(function(){
        $("#nowTime").html(current)
    },1000); //显示时分秒，并且秒数可以跳动

    //$("#nowTime").html(current);
</script>