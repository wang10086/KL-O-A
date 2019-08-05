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
                                            <p>员工ID：{$account_list.id}</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>员工姓名：{$account_list.nickname}</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>员工编号：{$account_list.employee_member} </p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>员工部门：{$wages_list['department']}</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>员工岗位：{$wages_list['post_name']}</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>员工类别：<?php if($account_list['formal']==0){ echo '试用';}elseif($account_list['formal']==1){ echo'正式';}elseif($account_list['formal']==3){ echo'劳务';}elseif($account_list['formal']==4){ echo'实习';}?></p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>员工状态：<?php if($account_list['status']==0){ echo "在职";}elseif($account_list['status']==1){echo "离职";} ?></p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>入职时间：<?php echo date('Y-m-d',$account_list['entry_time']) ?></p>
                                        </div>

                                        <div class="form-group col-md-4 viwe searchtex_color_salary2">
                                            <p>工资发放月份：{$wages_list['datetime']}</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>档案所属：<?php if($account_list['archives']==1){ echo '中心';}elseif($account_list['archives']==2){ echo'科旅';}elseif($account_list['archives']==3){ echo'科行';}?></p>
                                        </div>

                                    </div>
                                    <div>
                                        <div class="box-header">
                                            <h3 class="box-title">一 、岗位薪酬 = 基本工资 + 绩效工资</h3>
                                        </div><!-- /.box-header --><br>
                                        <div class="content">
                                            <div class="form-group col-md-4 viwe">
                                                <p>岗位薪酬标准：{$wages_list.standard}（元）</p>
                                            </div>

                                            <div class="form-group col-md-4 viwe">
                                                <p>其中基本工资标准：{$wages_list['basic_salary']}（元）</p>
                                            </div>

                                            <div class="form-group col-md-4 viwe">
                                                <p>其中绩效工资标准：{$wages_list['performance_salary']}（元）</p>
                                            </div>

                                            <div class="form-group col-md-4 viwe">
                                                <p>考勤扣款：{$wages_list.withdrawing}（元） </p>
                                            </div>
                                            <div class="form-group col-md-4 viwe">
                                                <p>应发基本工资：<?PHP echo sprintf("%.2f",$wages_list['basic_salary']-$wages_list['withdrawing']);?>（元）</p>
                                            </div>
                                            <table class="table table-bordered dataTable fontmini">
                                                <tr role="row" class="orders" >
                                                    <th class="sorting" data="op_id">考勤/扣款</th>
                                                    <th class="sorting" data="op_id">迟到/早退（15分钟以内）</th>
                                                    <th class="sorting" data="group_id">迟到/早退（15分钟~2小时）</th>
                                                    <th class="sorting" data="group_id">事假</th>
                                                    <th class="sorting" data="project">病假</th>
                                                    <th class="sorting" class="project">旷工</th>
                                                    <th class="sorting" class="project">缺勤天数</th>

                                                </tr>

                                                    <tr>
                                                        <td>次数</td>
                                                        <td><?php echo  round($attendance_list['late1'],2);?></td>
                                                        <td><?php echo  round($attendance_list['late2'],2);?></td>
                                                        <td><?php echo  round($attendance_list['leave_absence'],2);?></td>
                                                        <td><?php echo  round($attendance_list['sick_leave'],2);?></td>
                                                        <td><?php echo  round($attendance_list['absenteeism'],2);?></td>
                                                        <td><?php echo  round($attendance_list['entry_data'],2);?></td>
                                                    </tr>

                                                <tr>
                                                    <td>扣款</td>
                                                    <td>{$attendance_list['late1']*10}</td>
                                                    <td>{$attendance_list['late2']*30}</td>
                                                    <td><?php echo  round($wages_list['basic_salary']/21.75*$attendance_list['leave_absence'],2);?></td>
                                                    <td><?php echo  round(($wages_list['basic_salary']-($attendance_list['lowest_wage']*0.8))/21.75*$attendance_list['sick_leave'],2);?></td>
                                                    <td><?php echo  round($wages_list['basic_salary']/21.75*$attendance_list['absenteeism']*2,2);?></td>
                                                    <td><?php echo round($wages_list['standard']/21.75*$attendance_list['entry_data'],2);?></td>
                                                </tr>

                                            </table><br />
                                            <div class="form-group col-md-4 viwe">
                                                <p>绩效增减：{$wages_list['Achievements_withdrawing']} (元)</p>
                                            </div>

                                            <div class="form-group col-md-4 viwe">
                                                <p >应发绩效工资：{$wages_list['performance_salary']+$wages_list['Achievements_withdrawing']} (元)</p>
                                            </div>
                                            <table class="table table-bordered dataTable fontmini" style="margin-top:10px;">
                                                <tr role="row" class="orders" >
                                                    <th class="sorting" data="">绩效项目</th>
                                                    <th class="sorting" data="">PDCA</th>
                                                    <th class="sorting" data="">品质检查</th>
                                                    <th class="sorting" data="">KPI</th>
                                                </tr>

                                                <tr>
                                                    <td>得分</td>
                                                    <td class="salary_detali_td1">{$wages_list.sum_total_score}<a href="{:U('Kpi/pdcainfo',array('id'=>$pdca_id))}" style="float:right;">[详细]</td>
                                                    <td class="salary_detali_td2">
                                                        {$wages_list.show_qa_score}
                                                        <?php if($wages_list['show_qa_score']!=0){ ?>
                                                        <a href="{:U('Kpi/qa',array('uid'=>$wages_list['account_id'],'type'=>2,'month'=>$wages_list['month']))}" style="float:right;">[详细]
                                                        </a>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="salary_detali_td3">
                                                        {$wages_list.total_score_show}
                                                        <?php
                                                        $year = substr($wages_list['month'],0,4);
                                                        $month = ltrim(substr($wages_list['month'],4,2),0);
                                                        ?>
                                                        <a href="<?php echo U('Kpi/kpiinfo',array('uid'=>$wages_list['account_id'],'year'=>substr($wages_list['datetime'],0,4),'month'=>substr($wages_list['datetime'],4,2))); ?>" style="float:right;">[详细]
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>增减</td>
                                                    <td class="salary_detali_score_td1">{$wages_list['basic_salary']/100*$wages_list['sum_total_score']} (元)</td>
                                                    <td class="salary_detali_score_td3">{$wages_list['performance_salary']/100*$wages_list['show_qa_score']}(元)</td>
                                                    <td class="salary_detali_score_td2">{$wages_list['performance_salary']/100*$wages_list['total_score_show']} (元)</td>

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
                                            <p>目标任务(季度)：<?PHP echo $wages_list['target'];?> (元)</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>完成(季度)：<?PHP echo sprintf("%.2f",$info['kpi']['complete']);?> (元)</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>业绩提成(季度)：<?PHP echo $wages_list['total'];?> (元)</p>
                                        </div><br/><br/><br/>
                                        <h5 style="color:#000000;">&nbsp;&nbsp;&nbsp;&nbsp;其他人员提成（计调、研发、资源提成或手动录入带团补助）：<?PHP echo sprintf("%.2f",$bonus_list['bonus']);?>（元）</h5><br/>
                                        <div class="form-group col-md-4 viwe">
                                            <p>带团补助（课时费）：<?PHP echo sprintf("%.2f",$wages_list['Subsidy']);?></p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>住房补助：<?PHP echo sprintf("%.2f",$wages_list['housing_subsidy']);?> </p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>外地补贴：<?PHP echo sprintf("%.2f",$subsidy_list['foreign_subsidies']);?></p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>电脑补贴：<?PHP echo sprintf("%.2f",$subsidy_list['computer_subsidy']);?></p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>年终奖：<?PHP echo sprintf("%.2f",$bonus_list['annual_bonus']);?> </p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>季度奖金包：<?PHP echo sprintf("%.2f",$bonus_list['foreign_bonus']);?> </p>
                                        </div>
                                    </div>
                                    <div class="content" style="margin-left: -25px">
                                        <div class="box-header" >
                                            <h3 class="box-title">三 、员工五险一金</h3>
                                        </div><br>
                                        <div class="box-body">
                                            <table class="table table-bordered dataTable fontmini" id="tablelist1" style="text-align: center">
                                                <tr role="row" class="orders">
                                                    <th></th>
                                                    <th class="taskOptions">生育保险</th>
                                                    <th class="taskOptions">工伤保险</th>
                                                    <th class="taskOptions">养老保险</th>
                                                    <th class="taskOptions">医疗保险</th>
                                                    <th class="taskOptions">大额医疗</th>
                                                    <th class="taskOptions">失业保险</th>
                                                    <th class="taskOptions">公积金</th>
                                                    <if condition="$insurance_list.social_security_subsidy neq 0">
                                                        <th class="taskOptions">社保补缴</th>
                                                    </if>
                                                </tr>
                                                <tr>
                                                    <td>基数</td>
                                                    <td>{$insurance_list['birth_base']}</td>
                                                    <td>{$insurance_list['injury_base']}</td>
                                                    <td>{$insurance_list.pension_base}</td>
                                                    <td>{$insurance_list.medical_care_base}</td>
                                                    <td style="text-align: center">---</td>
                                                    <td>{$insurance_list.unemployment_base}</td>
                                                    <td>{$insurance_list.accumulation_fund_base}</td>
                                                    <if condition="$insurance_list.social_security_subsidy neq 0">
                                                        <td></td>
                                                    </if>
                                                </tr>
                                                <tr>
                                                    <td>比例</td>
                                                    <td>{$insurance_list['birth_ratio']}</td>
                                                    <td>{$insurance_list['injury_ratio']}</td>
                                                    <td>{$insurance_list.pension_ratio}</td>
                                                    <td>{$insurance_list.medical_care_ratio}</td>
                                                    <td style="text-align: center">---</td>
                                                    <td>{$insurance_list.unemployment_ratio}</td>
                                                    <td>{$insurance_list.accumulation_fund_ratio}</td>
                                                    <if condition="$insurance_list.social_security_subsidy neq 0">
                                                        <td></td>
                                                    </if>
                                                </tr>
                                                <tr class="salary_details_personal_money">
                                                    <td>金额</td>
                                                    <td><?php echo $insurance_list['birth_base']*$insurance_list['birth_ratio'];?></td>
                                                    <td><?php echo $insurance_list['injury_base']*$insurance_list['injury_ratio'];?></td>
                                                    <td><?php echo $insurance_list['pension_base']*$insurance_list['pension_ratio'];?></td>
                                                    <td><?php echo $insurance_list['medical_care_base']*$insurance_list['medical_care_ratio'];?></td>
                                                    <td>{$insurance_list.big_price}</td>
                                                    <td><?php echo $insurance_list['unemployment_base']*$insurance_list['unemployment_ratio'];?></td>
                                                    <td><?php echo round($insurance_list['accumulation_fund_base']*$insurance_list['accumulation_fund_ratio']);?></td>
                                                    <if condition="$insurance_list.social_security_subsidy neq 0">
                                                        <td>{$insurance_list['social_security_subsidy']}</td>
                                                    </if>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="content" style="margin-left: -25px">
                                        <div class="box-header" >
                                            <h3 class="box-title">四 、公司五险一金</h3>
                                        </div><br>
                                        <div class="box-body">
                                            <table class="table table-bordered dataTable fontmini" id="tablelist2" style="text-align: center">
                                                <tr role="row" class="orders" >
                                                    <th></th>
                                                    <th style="text-align: center">生育保险</th>
                                                    <th style="text-align: center">工伤保险</th>
                                                    <th style="text-align: center">养老保险</th>
                                                    <th style="text-align: center">医疗保险</th>
                                                    <th style="text-align: center">大额医疗</th>
                                                    <th style="text-align: center">失业保险</th>
                                                    <th style="text-align: center">公积金</th>
                                                </tr>
                                                <tr>
                                                    <td>基数</td>
                                                    <td>{$insurance_list.company_birth_base}</td>
                                                    <td>{$insurance_list.company_injury_base}</td>
                                                    <td>{$insurance_list.company_pension_base}</td>
                                                    <td>{$insurance_list.company_medical_care_base}</td>
                                                    <td>---</td>
                                                    <td>{$insurance_list.company_unemployment_base}</td>
                                                    <td>{$insurance_list.company_accumulation_fund_base}</td>
                                                </tr>
                                                <tr>
                                                    <td>比例</td>
                                                    <td>{$insurance_list.company_birth_ratio}</td>
                                                    <td>{$insurance_list.company_injury_ratio}</td>
                                                    <td>{$insurance_list.company_pension_ratio}</td>
                                                    <td>{$insurance_list.company_medical_care_ratio}</td>
                                                    <td>---</td>
                                                    <td>{$insurance_list.company_unemployment_ratio}</td>
                                                    <td>{$insurance_list.company_accumulation_fund_ratio}</td>
                                                </tr>
                                                <tr>
                                                    <td>金额</td>
                                                    <td><?php echo $insurance_list['company_birth_base']*$insurance_list['company_birth_ratio'];?></td>
                                                    <td><?php echo $insurance_list['company_injury_base']*$insurance_list['company_injury_ratio'];?></td>
                                                    <td><?php echo $insurance_list['company_pension_base']*$insurance_list['company_pension_ratio'];?></td>
                                                    <td><?php echo $insurance_list['company_medical_care_base']*$insurance_list['company_medical_care_ratio'];?></td>
                                                    <td>{$insurance_list.company_big_price}</td>
                                                    <td><?php echo $insurance_list['company_unemployment_base']*$insurance_list['company_unemployment_ratio'];?></td>
                                                    <td>{$wages_list['accumulation_fund']}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="content">
                                        <div class="box-header" style="margin-left: -20px">
                                            <h3 class="box-title">五 、专项附加扣除</h3>
                                        </div><!-- /.box-header --><br />
                                        <div class="box-body">
                                            <table class="table table-bordered dataTable fontmini" style="margin-top:10px; text-align: center;">
                                                <tr role="row" class="orders" >
                                                    <th class="taskOptions">子女教育</th>
                                                    <th class="taskOptions">继续教育</th>
                                                    <th class="taskOptions">大病医疗</th>
                                                    <th class="taskOptions">住房贷款</th>
                                                    <th class="taskOptions">租房租金</th>
                                                    <th class="taskOptions">赡养老人</th>
                                                </tr>
                                                <tr>
                                                    <td>&yen;<?php echo $specialdeduction_list['children_education']?$specialdeduction_list['children_education']:'0.00'; ?></td>
                                                    <td>&yen;<?php echo $specialdeduction_list['continue_education']?$specialdeduction_list['continue_education']:'0.00'; ?></td>
                                                    <td>&yen;<?php echo $specialdeduction_list['health']?$specialdeduction_list['health']:'0.00'; ?></td>
                                                    <td>&yen;<?php echo $specialdeduction_list['buy_house']?$specialdeduction_list['buy_house']:'0.00'; ?></td>
                                                    <td>&yen;<?php echo $specialdeduction_list['rent_house']?$specialdeduction_list['rent_house']:'0.00'; ?></td>
                                                    <td>&yen;<?php echo $specialdeduction_list['support_older']?$specialdeduction_list['support_older']:'0.00'; ?></td>
                                                </tr>

                                            </table><br/>
                                        </div>
                                    </div>


                                    <div class="content">
                                        <div class="box-header" style="margin-left: -20px">
                                            <h3 class="box-title">六 、个税及工会会费、代扣代缴  共计 <u class="salary_individual_totala"><?PHP echo sprintf("%.2f",($wages_list['summoney']+$wages_list['personal_tax']+$bonus_list['annual_bonus']+$wages_list['Labour']));?></u>  元</h3>
                                        </div><!-- /.box-header --><br><br>

                                        <div class="form-group col-md-4 viwe">
                                            <!--   岗位薪酬 +  提成/补助/奖金     -->
                                            <p class="salary_aggregate_should">应发工资合计：<?PHP echo sprintf("%.2f",$wages_list['Should_distributed']);?>(元)</p>
                                        </div>
                                        <!--   应发工资合计  - 员工五险一金 + 其他收入     -->
                                        <div class="form-group col-md-4 viwe">
                                            <p class="salary_individual_tax_assessment">个税计税工资：<?PHP echo sprintf("%.2f",$wages_list['tax_counting']);?> (元)</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p class="salary_individual_tax_assessment1">个人所得税：<?PHP echo sprintf("%.2f",$wages_list['personal_tax']);?>(元)</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p class="salary_individual_tax_assessment2">年终计税：<?PHP echo sprintf("%.2f",$wages_list['yearend']);?>(元)</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>工会会费：<?PHP echo sprintf("%.2f",$wages_list['Labour']);?>(元)</p>
                                        </div>

                                    </div>
                                    <div>
                                        <h5 style="color:#FF3333">代扣代缴</h5>
                                        <table class="table table-bordered dataTable fontmini" id="salarytablelist1" style="margin-top:10px;">
                                            <tr>
                                                <td>项目</td>
                                                <td>金额</td>
                                            </tr>
                                            <foreach name="withholding_list" item="with">
                                                <tr>
                                                    <td>{$with.project_name}</td>
                                                    <td class="money">{$with.money}</td>
                                                </tr>
                                            </foreach>

                                        </table><br/><br/>
                                        <h5 style="color:#FF3333">其他收入</h5>
                                        <table class="table table-bordered dataTable fontmini" id="salarytablelist2" style="margin-top:10px;">
                                            <tr>
                                                <td>项目</td>
                                                <td>金额</td>
                                            </tr>
                                            <foreach name="income_list" item="inc">
                                                <tr>
                                                    <td>{$inc.income_name}</td>
                                                    <td class="money">{$inc.income_money}</td>
                                                </tr>
                                            </foreach>

                                        </table>
                                    </div>
                                    <div class="content">
                                        <div class="box-header" style="margin-left: -20px">
                                            <h3 class="box-title">七 、实发工资  共计 <u class="salary_Payroll">{$wages_list['real_wages']}</u> 元</h3><p style="margin-top: 15px;">(实发工资=岗位薪酬+提成/补助/奖金+绩效增减-考勤扣款-员工五险一金-个税及工会会费、代扣代缴)</p>
                                        </div><!-- /.box-header --><br />
                                        <!--   1+2-3-5    -->
                                        <table class="table table-bordered dataTable fontmini"  style="margin-left:-15px;">
                                            <tr role="row" class="orders" >
                                                <th class="sorting" data="op_id">实发工资</th>
                                                <th class="sorting" data="op_id">岗位薪酬</th>
                                                <th class="sorting" data="op_id">提成/补助/奖金</th>
                                                <th class="sorting" data="op_id">绩效增减</th>
                                                <th class="sorting" data="op_id">考勤扣款</th>
                                                <th class="sorting" data="group_id">员工五险一金</th>
                                                <th class="sorting" data="group_id">个税及工会会费、代扣代缴</th>
                                            </tr>
                                            <tr>
                                                <td class="salary_Payroll1">{$wages_list['real_wages']}</td>
                                                <td>{$wages_list['standard']} (元)</td>
                                                <td class="salary_subsidy1">{$wages_list['welfare']} (元)</td>
                                                <td class="salary_subsidy1">{$wages_list['Achievements_withdrawing']} (元)</td>
                                                <td class="salary_subsidy1">{$wages_list['withdrawing']} (元)</td>

                                                <td class="five_risks">{$wages_list['insurance_Total']} (元)</td>
<!--                                                {$wages_list['summoney']+$wages_list['personal_tax']+$wages_list['Labour']}-->
                                                <td class="salary_individual_totala1"><?PHP echo sprintf("%.2f",($wages_list['summoney']+$wages_list['personal_tax']+$bonus_list['annual_bonus']+$wages_list['Labour']));?> (元)</td>
                                            </tr>
                                        </table>
                                        <br>

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
