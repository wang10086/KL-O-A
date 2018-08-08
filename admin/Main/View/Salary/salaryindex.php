<include file="Index:header2" />

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
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">人员薪资列表</h3>
                                    <div class="box-tools pull-right">

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
                                        <th class="sorting" data="shouru">补助/奖金</th>
                                        <th class="sorting" data="shouru">应发工资</th>
                                        <th class="sorting" data="maoli">税费扣款</th>
                                        <th width="50" class="taskOptions">实发工资</th>
                                        <th width="50" class="taskOptions">薪资月份</th>
                                        <th width="50" class="taskOptions">详情</th>
                                        </if>
                                        
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>刘金磊</td>
                                        <td>zx123456</td>
                                        <td>&yen; 3000.00</td>
                                        <td>&yen; 200.00</td>
                                        <td><if condition="($row.achievements_status eq 1)">+ </if><if condition="($row.achievements_status eq 2)">-</if><if condition="($row.achievements_status eq 3)"></if>&yen; 200.00</td>
                                        <td>&yen; {$row.post_tax_wage}</td>

                                        <td>&yen; 100.00</td>
                                        <td>&yen; 122.00</td>
                                        <td style="width:100px">&yen; 300.00</td>
                                        <td>2018-08</td>
                                        <td><a href="{:U('Salary/salarydetails',array('id'=>$row['id']))}" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i>查看详情</a></td>

                                    </tr>

                                    <foreach name="list" item="row">
                                    <tr>
                                        <td>{$row.sid}</td>
                                        <td>{$row.nickname}</td>
                                        <td>{$row.employee_member}</td>
                                        <td>&yen; {$row.wages}</td>
                                        <td>&yen; {$row.deduction_money}</td>
                                        <td><if condition="($row.achievements_status eq 1)">+ </if><if condition="($row.achievements_status eq 2)">-</if><if condition="($row.achievements_status eq 3)"></if>&yen; {$row.achievements}</td>
                                        <td>&yen; {$row.post_tax_wage}</td>

                                        <td>&yen; {$row.post_tax_wage}</td>
                                        <td>&yen; {$row._money}</td>
                                        <td style="width:100px">&yen; {$row.post_tax_wage}</td>
                                        <td><?php echo date('Y-m-d',$row['salary_time']) ?></td>
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
