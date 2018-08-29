<include file="Index:header2" />



            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        员工薪资详情
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Salary/salaryindex')}"><i class="fa fa-gift"></i> 员工薪资</a></li>
                        <li class="active">员工薪资详情</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                           
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">基本信息</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <div class="content">

                                        <div class="form-group col-md-4 viwe">
                                            <p>员工ID：{$user.id}</p>
                                        </div>
                                        
                                        <div class="form-group col-md-4 viwe">
                                            <p>员工姓名：{$user.user_name}</p>
                                        </div>
                                        
                                        <div class="form-group col-md-4 viwe">
                                            <p>员工编号：{$user.employee_member} </p>
                                        </div>
                                        
                                        <div class="form-group col-md-4 viwe">
                                            <p>员工部门：{$user.department}</p>
                                        </div>
                                        
                                        <div class="form-group col-md-4 viwe">
                                            <p>员工岗位：{$user.position}</p>
                                        </div>
                                        
                                        <div class="form-group col-md-4 viwe">
                                            <p>员工类别：<?php if($user['staff_style']==1){ echo '新入职';}elseif($user['staff_style']==2){ echo'转正';}elseif($user['staff_style']==3){ echo'正式';}elseif($user['staff_style']==4){ echo'实习';}elseif($user['staff_style']==5){ echo'离职';}elseif($user['staff_style']==6){ echo'试用';}elseif($user['staff_style']==7){ echo'劳务';}?></p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>员工状态：<?php if($user['style']==1){ echo "在职";}elseif($user['style']==2){echo "离职";} ?></p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>入职时间：<?php echo date('Y-m-d',$user['entry_time']) ?></p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>工资发放时间：<?php echo date('Y-m',$row['salary_time']) ?></p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>档案所属：文化传播中心</p>
                                        </div>
                                        
                                    </div>
                                    <div>
                                        <div class="box-header">
                                            <h3 class="box-title">一 、岗位薪酬 = 基本工资 + 绩效工资</h3>
                                        </div><!-- /.box-header --><br>
                                        <div class="content">
                                            <div class="form-group col-md-4 viwe">
                                                <p>岗位薪酬标准：{$row.wages}（元）</p>
                                            </div>

                                            <div class="form-group col-md-4 viwe">
                                                <p>其中基本工资标准：{$row.base_pay}</p>
                                            </div>

                                            <div class="form-group col-md-4 viwe">
                                                <p>其中绩效工资标准：{$row.merit_pay}</p>
                                            </div>

                                            <div class="form-group col-md-4 viwe">
                                                <p>考勤扣款：{$row.deduction_money} </p>
                                            </div>
                                            <div class="form-group col-md-4 viwe">
                                                <p>应发基本工资：{$row.money_pay} </p>
                                            </div>
                                            <table class="table table-bordered dataTable fontmini">
                                                <tr role="row" class="orders" >
                                                    <th class="sorting" data="op_id">考勤/扣款</th>
                                                    <th class="sorting" data="op_id">迟到/早退（15分钟以内）</th>
                                                    <th class="sorting" data="group_id">迟到/早退（15分钟~2小时）</th>
                                                    <th class="sorting" data="group_id">事假</th>
                                                    <th class="sorting" data="project">病假</th>
                                                    <th class="sorting" class="project">矿工</th>

                                                </tr>

                                                    <tr>
                                                        <td>次数</td>
                                                        <td>{$row.user_name}</td>
                                                        <td>{$row.employee_member}</td>
                                                        <td>&yen; {$row.wages}</td>
                                                        <td>&yen; {$row.wages}</td>
                                                        <td>&yen; {$row.deduction_money}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>扣款</td>
                                                        <td>{$row.user_name}</td>
                                                        <td>{$row.employee_member}</td>
                                                        <td>&yen; {$row.wages}</td>
                                                        <td>&yen; {$row.wages}</td>
                                                        <td>&yen; {$row.deduction_money}</td>
                                                    </tr>
                                            </table><br />
                                            <div class="form-group col-md-4 viwe">
                                                <p>绩效增减：{$row.base_pay}</p>
                                            </div>

                                            <div class="form-group col-md-4 viwe">
                                                <p>应发绩效工资：{$row.merit_pay}</p>
                                            </div>
                                            <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                                <tr role="row" class="orders" >
                                                    <th class="sorting" data="op_id">绩效项目</th>
                                                    <th class="sorting" data="op_id">PDCA</th>
                                                    <th class="sorting" data="group_id">品质检查</th>
                                                    <th class="sorting" data="group_id">KPI</th>
                                                </tr>

                                                <tr>
                                                    <td>得分</td>
                                                    <td>{$row.user_name}</td>
                                                    <td>{$row.employee_member}</td>
                                                    <td>&yen; {$row.wages}</td>
                                                </tr>
                                                <tr>
                                                    <td>增减</td>
                                                    <td>{$row.user_name}</td>
                                                    <td>{$row.employee_member}</td>
                                                    <td>&yen; {$row.wages}</td>
                                                </tr>
                                            </table>
                                        </div>

                                    </div>

                                    <div class="content" style="margin-left: -20px">
                                        <div class="box-header">
                                            <h3 class="box-title">二 、提成/补助/奖金</h3>
                                        </div><!-- /.box-header --><br>
                                        <h5 style="color:#FF3333">业务人员提成</h5><br/>
                                        <div class="form-group col-md-4 viwe">
                                            <p>目标任务：{$row.total_percentage}</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>季度完成：{$row.money_pay} </p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>业绩提成：{$row.total_percentage}</p>
                                        </div><br/><br/><br/>
                                        <h5 style="color:#000000;">&nbsp;&nbsp;&nbsp;&nbsp;其他人员提成（计调、研发、资源）： （元）</h5><br/>
                                        <div class="form-group col-md-4 viwe">
                                            <p>带团补助（课时费）：{$row.total_percentage}</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>住房补助：{$row.money_pay} </p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>外地补贴：{$row.total_percentage}</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>电脑补贴：{$row.total_percentage}</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>年终奖：{$row.money_pay} </p>
                                        </div>
                                    </div>
                                    <div class="content" style="margin-left: -25px">
                                        <div class="box-header" >
                                            <h3 class="box-title">三 、员工五险一金</h3>
                                        </div><br>
                                        <div class="box-body">
                                            <table class="table table-bordered dataTable fontmini" id="tablelist">
                                                <tr role="row" class="orders" >
                                                    <th></th>
                                                    <th>生育保险</th>
                                                    <th>工伤保险</th>
                                                    <th>养老保险</th>
                                                    <th>医疗保险</th>
                                                    <th>失业保险</th>
                                                    <th>公积金</th>
                                                </tr>
                                                <tr>
                                                    <td>基数</td>
                                                    <td>{$insurance.birth}</td>
                                                    <td>{$insurance.injury}</td>
                                                    <td>&yen;{$insurance.pension}</td>
                                                    <td>&yen;{$insurance.medical_care}</td>
                                                    <td>{$insurance.unemployment}</td>
                                                    <td>{$insurance.accumulation_fund}</td>
                                                </tr>
                                                <tr>
                                                    <td>比例</td>
                                                    <td>{$insurance.birth}</td>
                                                    <td>{$insurance.injury}</td>
                                                    <td>&yen;{$insurance.pension}</td>
                                                    <td>&yen;{$insurance.medical_care}</td>
                                                    <td>{$insurance.unemployment}</td>
                                                    <td>{$insurance.accumulation_fund}</td>
                                                </tr>
                                                <tr>
                                                    <td>金额</td>
                                                    <td>{$insurance.birth}</td>
                                                    <td>{$insurance.injury}</td>
                                                    <td>&yen;{$insurance.pension}</td>
                                                    <td>&yen;{$insurance.medical_care}</td>
                                                    <td>{$insurance.unemployment}</td>
                                                    <td>{$insurance.accumulation_fund}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="content" style="margin-left: -25px">
                                        <div class="box-header" >
                                            <h3 class="box-title">四 、公司五险一金</h3>
                                        </div><br>
                                        <div class="box-body">
                                            <table class="table table-bordered dataTable fontmini" id="tablelist">
                                                <tr role="row" class="orders" >
                                                    <th></th>
                                                    <th>生育保险</th>
                                                    <th>工伤保险</th>
                                                    <th>养老保险</th>
                                                    <th>医疗保险</th>
                                                    <th>失业保险</th>
                                                    <th>公积金</th>
                                                </tr>
                                                <tr>
                                                    <td>基数</td>
                                                    <td>{$insurance.birth}</td>
                                                    <td>{$insurance.injury}</td>
                                                    <td>&yen;{$insurance.pension}</td>
                                                    <td>&yen;{$insurance.medical_care}</td>
                                                    <td>{$insurance.unemployment}</td>
                                                    <td>{$insurance.accumulation_fund}</td>
                                                </tr>
                                                <tr>
                                                    <td>比例</td>
                                                    <td>{$insurance.birth}</td>
                                                    <td>{$insurance.injury}</td>
                                                    <td>&yen;{$insurance.pension}</td>
                                                    <td>&yen;{$insurance.medical_care}</td>
                                                    <td>{$insurance.unemployment}</td>
                                                    <td>{$insurance.accumulation_fund}</td>
                                                </tr>
                                                <tr>
                                                    <td>金额</td>
                                                    <td>{$insurance.birth}</td>
                                                    <td>{$insurance.injury}</td>
                                                    <td>&yen;{$insurance.pension}</td>
                                                    <td>&yen;{$insurance.medical_care}</td>
                                                    <td>{$insurance.unemployment}</td>
                                                    <td>{$insurance.accumulation_fund}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>


                                    <div class="content">
                                        <div class="box-header" style="margin-left: -20px">
                                            <h3 class="box-title">五 、个税及工会会费、代扣代缴  共计 <u>30000.00</u> 元</h3>
                                        </div><!-- /.box-header --><br><br>

                                        <div class="form-group col-md-4 viwe">
                                            <!--   岗位薪酬 +  提成/补助/奖金     -->
                                            <p>应发工资合计：{$row.bonus}</p>
                                        </div>
                                        <!--   应发工资合计  - 员工五险一金 + 其他收入     -->
                                        <div class="form-group col-md-4 viwe">
                                            <p>个税计税工资：{$row.housing_subsidy}</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>个人所得税：{$row.other_subsidie} </p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>年终奖计税：{$row.tax_payroll}</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>工会会费：{$row.year_end_money}</p>
                                        </div>

                                    </div>
                                    <div>
                                        <h5 style="color:#FF3333">代扣代缴</h5><br/>
                                        <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                            <tr>
                                                <td>项目</td>
                                                <td>金额</td>
                                            </tr>
                                            <tr>
                                                <td>房屋住宿</td>
                                                <td>2000.00元</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="content">
                                        <div class="box-header" style="margin-left: -20px">
                                            <h3 class="box-title">六 、实发工资  共计 <u>9999.99</u> 元</h3><p style="margin-top: 15px;">(实发工资=岗位薪酬+提成/补助/奖金-员工五险一金-个税及工会会费、代扣代缴)</p>
                                        </div><!-- /.box-header --><br />
                                        <!--   1+2-3-5    -->
                                        <table class="table table-bordered dataTable fontmini"  style="margin-left:-15px;">
                                            <tr role="row" class="orders" >
                                                <th class="sorting" data="op_id">实发工资</th>
                                                <th class="sorting" data="op_id">岗位薪酬</th>
                                                <th class="sorting" data="op_id">提成/补助/奖金</th>
                                                <th class="sorting" data="group_id">员工五险一金</th>
                                                <th class="sorting" data="group_id">个税及工会会费、代扣代缴</th>
                                            </tr>
                                            <tr>
                                                <td>10000.00</td>
                                                <td>{$row.user_name}</td>
                                                <td>{$row.employee_member}</td>
                                                <td>{$row.employee_member}</td>
                                                <td>&yen; {$row.wages}</td>
                                            </tr>
                                        </table>

                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
  </div>
</div>

            
<include file="Index:footer2" />