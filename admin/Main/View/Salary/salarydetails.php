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
                                            <p>员工ID：{$info['account'].id}</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>员工姓名：{$info['account'].nickname}</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>员工编号：{$info['account'].employee_member} </p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>员工部门：{$info['wages_month']['department']}</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>员工岗位：{$info['wages_month']['post_name']}</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>员工类别：<?php if($info['account']['formal']==0){ echo '试用';}elseif($info['account']['formal']==1){ echo'正式';}elseif($info['account']['formal']==3){ echo'劳务';}elseif($info['account']['formal']==4){ echo'实习';}?></p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>员工状态：<?php if($info['account']['status']==0){ echo "在职";}elseif($inf['account']['status']==1){echo "离职";} ?></p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>入职时间：<?php echo date('Y-m-d',$info['account']['entry_time']) ?></p>
                                        </div>

                                        <div class="form-group col-md-4 viwe searchtex_color_salary2">
                                            <p>工资发放月份：{$info['wages_month'].datetime}</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>档案所属：<?php if($info['account']['archives']==1){ echo '中心';}elseif($info['account']['archives']==2){ echo'科旅';}elseif($info['account']['archives']==3){ echo'科行';}?></p>
                                        </div>

                                    </div>
                                    <div>
                                        <div class="box-header">
                                            <h3 class="box-title">一 、岗位薪酬 = 基本工资 + 绩效工资</h3>
                                        </div><!-- /.box-header --><br>
                                        <div class="content">
                                            <div class="form-group col-md-4 viwe">
                                                <p>岗位薪酬标准：{$info['wages_month'].standard}（元）</p>
                                            </div>

                                            <div class="form-group col-md-4 viwe">
                                                <p>其中基本工资标准：{$info['wages_month']['basic_salary']}（元）</p>
                                            </div>

                                            <div class="form-group col-md-4 viwe">
                                                <p>其中绩效工资标准：{$info['wages_month']['performance_salary']}（元）</p>
                                            </div>

                                            <div class="form-group col-md-4 viwe">
                                                <p>考勤扣款：{$info['wages_month'].withdrawing}（元） </p>
                                            </div>
                                            <div class="form-group col-md-4 viwe">
                                                <p>应发基本工资：<?PHP echo sprintf("%.2f",$info['wages_month']['basic_salary']-$info['wages_month']['withdrawing']);?>（元）</p>
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
                                                        <td><?php echo  round($info['attendance']['late1'],2);?></td>
                                                        <td><?php echo  round($info['attendance']['late2'],2);?></td>
                                                        <td><?php echo  round($info['attendance']['leave_absence'],2);?></td>
                                                        <td><?php echo  round($info['attendance']['sick_leave'],2);?></td>
                                                        <td><?php echo  round($info['attendance']['absenteeism'],2);?></td>
                                                        <td><?php echo  round($info['attendance']['entry_data'],2);?></td>
                                                    </tr>

                                                <tr>
                                                    <td>扣款</td>
                                                    <td>{$info['attendance']['late1']*10}</td>
                                                    <td>{$info['attendance']['late2']*30}</td>
                                                    <td><?php echo  round($info['wages_month']['basic_salary']/21.75*$info['attendance']['leave_absence'],2);?></td>
                                                    <td><?php echo  round(($info['wages_month']['basic_salary']-($info['attendance']['lowest_wage']*0.8))/21.75*$info['attendance']['sick_leave'],2);?></td>
                                                    <td><?php echo  round($info['wages_month']['basic_salary']/21.75*$info['attendance']['absenteeism']*2,2);?></td>
                                                    <td><?php echo round($info['wages_month']['standard']/21.75*$info['attendance']['entry_data'],2);?></td>
                                                </tr>

                                            </table><br />
                                            <div class="form-group col-md-4 viwe">
                                                <p>绩效增减：{$info['wages_month']['Achievements_withdrawing']} (元)</p>
                                            </div>

                                            <div class="form-group col-md-4 viwe">
                                                <p >应发绩效工资：{$info['wages_month']['performance_salary']+$info['wages_month']['Achievements_withdrawing']} (元)</p>
                                            </div>
                                            <table class="table table-bordered dataTable fontmini" style="margin-top:10px;">
                                                <tr role="row" class="orders" >
                                                    <th class="sorting" data="op_id">绩效项目</th>
                                                    <th class="sorting" data="op_id">PDCA</th>
                                                    <th class="sorting" data="group_id">品质检查</th>
                                                    <th class="sorting" data="group_id">KPI</th>
                                                </tr>

                                                <tr>
                                                    <td>得分</td>
                                                    <td class="salary_detali_td1">{$info['fen'][0].total_score_show}<a href="{:U('Kpi/pdcainfo',array('id'=>$info['fen'][0]['id']))}" style="float:right;">[详细]</td>
                                                    <td class="salary_detali_td2">
                                                        {$info['fen'][0].show_qa_score}
                                                        <?php if($info['fen'][0]['total_qa_score']!=0){ ?>
                                                        <a href="{:U('Kpi/qa',array('uid'=>$info['fen'][0]['tab_user_id'],'type'=>2,'month'=>$info['fen'][0]['month']))}" style="float:right;">[详细]
                                                        </a>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="salary_detali_td3">
                                                        {$info['fen'][0].total_kpi_score}
                                                        <?php
                                                        $year = substr($info['fen'][0]['month'],0,4);
                                                        $month = ltrim(substr($info['fen'][0]['month'],4,2),0);
                                                        ?>
                                                        <a href="{:U('Kpi/kpiinfo',array('uid'=>$info['fen'][0]['tab_user_id'],'year'=>$year,'month'=>$month))}" style="float:right;">[详细]
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>增减</td>
                                                    <td class="salary_detali_score_td1">{$info['wages_month']['performance_salary']/100*$info['wages_month']['total_score_show']} (元)</td>
                                                    <td class="salary_detali_score_td3">{$info['wages_month']['performance_salary']/100*$info['wages_month']['show_qa_score']}(元)</td>
                                                    <td class="salary_detali_score_td2">{$info['wages_month']['performance_salary']/100*$info['wages_month']['sum_total_score']} (元)</td>

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
                                            <p>目标任务(季度)：<?PHP echo sprintf("%.2f",$info['kpi']['target']);?> (元)</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>完成(季度)：<?PHP echo sprintf("%.2f",$info['kpi']['complete']);?> (元)</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>业绩提成(季度)：<?PHP echo sprintf("%.2f",$info['kpi']['total']);?> (元)</p>
                                        </div><br/><br/><br/>
                                        <h5 style="color:#000000;">&nbsp;&nbsp;&nbsp;&nbsp;其他人员提成（计调、研发、资源）：<?PHP echo sprintf("%.2f",$info['bonus']['bonus']);?>（元）</h5><br/>
                                        <div class="form-group col-md-4 viwe">
                                            <p>带团补助（课时费）：<?PHP echo sprintf("%.2f",$info['wages_month']['Subsidy']);?></p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>住房补助：<?PHP echo sprintf("%.2f",$info['wages_month']['housing_subsidy']);?> </p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>外地补贴：<?PHP echo sprintf("%.2f",$info['subsidy']['foreign_subsidies']);?></p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>电脑补贴：<?PHP echo sprintf("%.2f",$info['subsidy']['computer_subsidy']);?></p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>年终奖：<?PHP echo sprintf("%.2f",$info['bonus']['annual_bonus']);?> </p>
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
                                                    <td>{$info['insurance']['birth_base']}</td>
                                                    <td>{$info['insurance']['injury_base']}</td>
                                                    <td>{$info['insurance'].pension_base}</td>
                                                    <td>{$info['insurance'].medical_care_base}</td>
                                                    <td style="text-align: center">---</td>
                                                    <td>{$info['insurance'].unemployment_base}</td>
                                                    <td>{$info['insurance'].accumulation_fund_base}</td>
                                                </tr>
                                                <tr>
                                                    <td>比例</td>
                                                    <td>{$info['insurance']['birth_ratio']}</td>
                                                    <td>{$info['insurance']['injury_ratio']}</td>
                                                    <td>{$info['insurance'].pension_ratio}</td>
                                                    <td>{$info['insurance'].medical_care_ratio}</td>
                                                    <td style="text-align: center">---</td>
                                                    <td>{$info['insurance'].unemployment_ratio}</td>
                                                    <td>{$info['insurance'].accumulation_fund_ratio}</td>
                                                </tr>
                                                <tr class="salary_details_personal_money">
                                                    <td>金额</td>
                                                    <td><?php echo $info['insurance']['birth_base']*$info['insurance']['birth_ratio'];?></td>
                                                    <td><?php echo $info['insurance']['injury_base']*$info['insurance']['injury_ratio'];?></td>
                                                    <td><?php echo $info['insurance']['pension_base']*$info['insurance']['pension_ratio'];?></td>
                                                    <td><?php echo $info['insurance']['medical_care_base']*$info['insurance']['medical_care_ratio'];?></td>
                                                    <td>{$info['insurance'].big_price}</td>
                                                    <td><?php echo $info['insurance']['unemployment_base']*$info['insurance']['unemployment_ratio'];?></td>
                                                    <td><?php echo $info['insurance']['accumulation_fund_base']*$info['insurance']['accumulation_fund_ratio'];?></td>
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
                                                    <td>{$info['insurance'].company_birth_base}</td>
                                                    <td>{$info['insurance'].company_injury_base}</td>
                                                    <td>{$info['insurance'].company_pension_base}</td>
                                                    <td>{$info['insurance'].company_medical_care_base}</td>
                                                    <td>---</td>
                                                    <td>{$info['insurance'].company_unemployment_base}</td>
                                                    <td>{$info['insurance'].company_accumulation_fund_base}</td>
                                                </tr>
                                                <tr>
                                                    <td>比例</td>
                                                    <td>{$info['insurance'].company_birth_ratio}</td>
                                                    <td>{$info['insurance'].company_injury_ratio}</td>
                                                    <td>{$info['insurance'].company_pension_ratio}</td>
                                                    <td>{$info['insurance'].company_medical_care_ratio}</td>
                                                    <td>---</td>
                                                    <td>{$info['insurance'].company_unemployment_ratio}</td>
                                                    <td>{$info['insurance'].company_accumulation_fund_ratio}</td>
                                                </tr>
                                                <tr>
                                                    <td>金额</td>
                                                    <td><?php echo $info['insurance']['company_birth_base']*$info['insurance']['company_birth_ratio'];?></td>
                                                    <td><?php echo $info['insurance']['company_injury_base']*$info['insurance']['company_injury_ratio'];?></td>
                                                    <td><?php echo $info['insurance']['company_pension_base']*$info['insurance']['company_pension_ratio'];?></td>
                                                    <td><?php echo $info['insurance']['company_medical_care_base']*$info['insurance']['company_medical_care_ratio'];?></td>
                                                    <td>{$info['insurance'].company_big_price}</td>
                                                    <td><?php echo $info['insurance']['company_unemployment_base']*$info['insurance']['company_unemployment_ratio'];?></td>
                                                    <td><?php echo $info['insurance']['company_accumulation_fund_base']*$info['insurance']['company_accumulation_fund_ratio'];?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>


                                    <div class="content">
                                        <div class="box-header" style="margin-left: -20px">
                                            <h3 class="box-title">五 、个税及工会会费、代扣代缴  共计 <u class="salary_individual_totala"><?PHP echo sprintf("%.2f",($info['wages_month']['summoney']+$info['wages_month']['personal_tax']+$info['bonus']['annual_bonus']+$info['wages_month']['Labour']));?></u>  元</h3>
                                        </div><!-- /.box-header --><br><br>

                                        <div class="form-group col-md-4 viwe">
                                            <!--   岗位薪酬 +  提成/补助/奖金     -->
                                            <p class="salary_aggregate_should">应发工资合计：<?PHP echo sprintf("%.2f",$info['wages_month']['Should_distributed']);?>(元)</p>
                                        </div>
                                        <!--   应发工资合计  - 员工五险一金 + 其他收入     -->
                                        <div class="form-group col-md-4 viwe">
                                            <p class="salary_individual_tax_assessment">个税计税工资：<?PHP echo sprintf("%.2f",$info['wages_month']['tax_counting']);?> (元)</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p class="salary_individual_tax_assessment1">个人所得税：<?PHP echo sprintf("%.2f",$info['wages_month']['personal_tax']);?>(元)</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p class="salary_individual_tax_assessment2">年终计税：<?PHP echo sprintf("%.2f",$info['wages_month']['yearend']);?>(元)</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>工会会费：<?PHP echo sprintf("%.2f",$info['wages_month']['Labour']);?>(元)</p>
                                        </div>

                                    </div>
                                    <div>
                                        <h5 style="color:#FF3333">代扣代缴</h5>
                                        <table class="table table-bordered dataTable fontmini" id="salarytablelist1" style="margin-top:10px;">
                                            <tr>
                                                <td>项目</td>
                                                <td>金额</td>
                                            </tr>
                                            <foreach name="info['withholding']" item="with">
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
                                            <foreach name="info['income']" item="inc">
                                                <tr>
                                                    <td>{$inc.income_name}</td>
                                                    <td class="money">{$inc.income_money}</td>
                                                </tr>
                                            </foreach>

                                        </table>
                                    </div>
                                    <div class="content">
                                        <div class="box-header" style="margin-left: -20px">
                                            <h3 class="box-title">六 、实发工资  共计 <u class="salary_Payroll">{$info['wages_month']['real_wages']}</u> 元</h3><p style="margin-top: 15px;">(实发工资=岗位薪酬+提成/补助/奖金+绩效增减-考勤扣款-员工五险一金-个税及工会会费、代扣代缴)</p>
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
                                                <td class="salary_Payroll1">{$info['wages_month']['real_wages']}</td>
                                                <td>{$info['wages_month']['standard']} (元)</td>
                                                <td class="salary_subsidy1">{$info['wages_month']['welfare']} (元)</td>
                                                <td class="salary_subsidy1">{$info['wages_month']['Achievements_withdrawing']} (元)</td>
                                                <td class="salary_subsidy1">{$info['wages_month']['withdrawing']} (元)</td>

                                                <td class="five_risks">{$info['wages_month']['insurance_Total']} (元)</td>
                                                <td class="salary_individual_totala1"><?PHP echo sprintf("%.2f",($info['wages_month']['summoney']+$info['wages_month']['personal_tax']+$info['bonus']['annual_bonus']+$info['wages_month']['Labour']));?> (元)</td>
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
