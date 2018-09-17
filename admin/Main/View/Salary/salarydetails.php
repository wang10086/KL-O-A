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
                                            <p>员工部门：{$info['department'].department}</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>员工岗位：{$info['posts'].post_name}</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>员工类别：<?php if($info['account']['formal']==0){ echo '转正';}elseif($info['account']['formal']==1){ echo'未转正';}elseif($info['account']['formal']==2){ echo'劳务';}elseif($info['account']['formal']==3){ echo'实习';}?></p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>员工状态：<?php if($info['account']['status']==0){ echo "在职";}elseif($inf['account']['status']==1){echo "离职";} ?></p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>入职时间：<?php echo date('Y-m-d',$info['account']['entry_time']) ?></p>
                                        </div>

                                        <?php if($type == 1){ ?>
                                        <div class="form-group col-md-4 viwe searchtex_color_salary1">
                                            <p>工资发放月份：<input type="text" class="monthly" style="width:10em;"></p>
                                        </div>
                                        <?php }?>
                                        <?php if($type == 2){ ?>
                                            <div class="form-group col-md-4 viwe searchtex_color_salary2">
                                                <p>工资发放月份：{$info['month'].datetime}</p>
                                            </div>
                                        <?php }?>
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
                                                <p>岗位薪酬标准：{$info['salary'].standard_salary}（元）</p>
                                            </div>

                                            <div class="form-group col-md-4 viwe">
                                                <p>其中基本工资标准：{$info['calculation']['basic']}（元）</p>
                                            </div>

                                            <div class="form-group col-md-4 viwe">
                                                <p>其中绩效工资标准：{$info['calculation']['achievements']}（元）</p>
                                            </div>

                                            <div class="form-group col-md-4 viwe">
                                                <p>考勤扣款：{$info['attendance'].withdrawing}（元） </p>
                                            </div>
                                            <div class="form-group col-md-4 viwe">
                                                <p>应发基本工资：{$info['calculation']['grant']}（元）</p>
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
                                                        <td>{$info['attendance']['late1']}</td>
                                                        <td>{$info['attendance']['late2']}</td>
                                                        <td>{$info['attendance']['leave_absence']}</td>
                                                        <td>{$info['attendance']['sick_leave']}</td>
                                                        <td>{$info['attendance']['absenteeism']}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>扣款</td>
                                                        <td>{$info['attendance']['late1']*10}</td>
                                                        <td>{$info['attendance']['late2']*30}</td>
                                                        <td><?php echo  floor($info['calculation']['basic']/21.75*$info['attendance']['leave_absence']*100)/100;?></td>
                                                        <td><?php echo  floor($info['attendance']['lowest_wage']/21.75*$info['attendance']['sick_leave']*20)/100;?></td>
                                                        <td><?php echo  floor($info['calculation']['basic']/21.75*$info['attendance']['absenteeism']*200)/100;?></td>
                                                    </tr>
                                            </table><br />
                                            <div class="form-group col-md-4 viwe">
                                                <p class="salary_achievements_decrease">绩效增减：0.00 (元)</p>
                                            </div>

                                            <div class="form-group col-md-4 viwe">
                                                <p class="salary_should_paid">应发绩效工资：0.00 (元)</p>
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
                                                    <td class="salary_detali_td1">{$info['score'][0].total_score_show}<a href="{:U('Kpi/pdcainfo',array('id'=>$info['score'][0]['id']))}" style="float:right;">[详细]</td>
                                                    <td class="salary_detali_td2">
                                                        {$info['score'][0].show_qa_score}
                                                        <?php if($info['score'][0]['total_qa_score']!=0){ ?>
                                                        <a href="{:U('Kpi/qa',array('uid'=>$info['score'][0]['tab_user_id'],'type'=>2,'month'=>$info['score'][0]['month']))}" style="float:right;">[详细]
                                                        </a>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="salary_detali_td3">
                                                        {$info['score'][0].total_kpi_score}
                                                        <?php
                                                        $year = substr($info['score'][0]['month'],0,4);
                                                        $month = ltrim(substr($info['score'][0]['month'],4,2),0);
                                                        ?>
                                                        <a href="{:U('Kpi/kpiinfo',array('uid'=>$info['score'][0]['tab_user_id'],'year'=>$year,'month'=>$month))}" style="float:right;">[详细]
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>增减</td>
                                                    <td class="salary_detali_score_td1">0.00 (元)</td>
                                                    <td class="salary_detali_score_td2">0.00 (元)</td>
                                                    <td class="salary_detali_score_td3">0.00 (元)</td>
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
                                            <p>目标任务：{$info['list'].target} (元)</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>季度完成：{$info['list'].complete} (元)</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>业绩提成：{$info['list']['total']} (元)</p>
                                        </div><br/><br/><br/>
                                        <h5 style="color:#000000;">&nbsp;&nbsp;&nbsp;&nbsp;其他人员提成（计调、研发、资源）：{$info['bonus'].bonus} （元）</h5><br/>
                                        <div class="form-group col-md-4 viwe">
                                            <p>带团补助（课时费）：{$info['bonus'].extract}</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>住房补助：{$info['subsidy'].housing_subsidy} </p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>外地补贴：{$info['subsidy'].foreign_subsidies}</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>电脑补贴：{$info['subsidy'].computer_subsidy}</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>年终奖：{$info['bonus'].annual_bonus} </p>
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
                                            <h3 class="box-title">五 、个税及工会会费、代扣代缴  共计 <u class="salary_individual_totala">0.00</u>  元</h3>
                                        </div><!-- /.box-header --><br><br>

                                        <div class="form-group col-md-4 viwe">
                                            <!--   岗位薪酬 +  提成/补助/奖金     -->
                                            <p class="salary_aggregate_should">应发工资合计：0.00 (元)</p>
                                        </div>
                                        <!--   应发工资合计  - 员工五险一金 + 其他收入     -->
                                        <div class="form-group col-md-4 viwe">
                                            <p class="salary_individual_tax_assessment">个税计税工资：0.00 (元)</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p class="salary_individual_tax_assessment1">个人所得税：0.00 (元)</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p class="salary_individual_tax_assessment2">年终奖计税：0.00 (元)</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>工会会费：<?php echo ($info['calculation']['basic']-500)*0.01;?> (元)</p>
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
                                            <h3 class="box-title">六 、实发工资  共计 <u class="salary_Payroll">0.00</u> 元</h3><p style="margin-top: 15px;">(实发工资=岗位薪酬+提成/补助/奖金-员工五险一金-个税及工会会费、代扣代缴)</p>
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
                                                <td class="salary_Payroll1">0.00</td>
                                                <td>{$info['salary'].standard_salary} (元)</td>
                                                <td class="salary_subsidy1">0.00 (元)</td>
                                                <td class="five_risks">0.00 (元)</td>
                                                <td class="salary_individual_totala1">0.00 (元)</td>
                                            </tr>
                                        </table>
                                        <br><br><br>


                                        <!--   确定保存数据 -->
                                        <?php if($type==1){?>
                                        <br>
                                        <div class="searchtex_color_salary" style="width:20em;margin:0 auto" >

                                            <input type="submit" class="form-control" value="保存数据" style="background-color:#00acd6;">

                                        </div>
                                        <?php }?>
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
<script>
       //绩效增减
       var score1                   = $('.salary_detali_td1').html();
       var score2                   = $('.salary_detali_td2').html();
       var score3                   = $('.salary_detali_td3').html();

       var scoreclass1              = $('.salary_detali_td1 span').attr('class');//获取class
       var scoreclass2              = $('.salary_detali_td2 span').attr('class');//获取class
       var scoreclass3              = $('.salary_detali_td3 span').attr('class');//获取class
       var achievements             = "<?php echo $info['calculation']['achievements'];?>";//绩效工资

       if(scoreclass1=='green'){
           var str_score1           = $.trim((((score1.replace('<span class="green">','')).replace('</span>','')).split("<span>"))[0]);//去除多余的标签
       }
       if(scoreclass2=='green'){
           var str_score2           = $.trim((((score2.replace('<span class="green">','')).replace('</span>','')).split("<span>"))[0]);//去除多余的标签
       }
       if(scoreclass3=='green'){
           var str_score3           = $.trim((((score3.replace('<span class="green">','')).replace('</span>','')).split("<span>"))[0]);//去除多余的标签
       }
       if(scoreclass1=='red'){
           var str_score1           = $.trim((((score1.replace('<span class="red">','')).replace('</span>','')).split("<span>"))[0]);//去除多余的标签
       }
       if(scoreclass2=='red'){
           var str_score2           = $.trim((((score2.replace('<span class="red">','')).replace('</span>','')).split("<span>"))[0]);//去除多余的标签
       }
       if(scoreclass3=='red'){
           var str_score3           = $.trim((((score3.replace('<span class="red">','')).replace('</span>','')).split("<span>"))[0]);//去除多余的标签
       }
       if(scoreclass1=='green' || scoreclass1=='red'){
           var str_score1_Addition      = str_score1.substring(0,1);//获取加减号
           var str_score1_subtraction   = Number(str_score1.substring(1));//获取绩效增减分
        }
       if(scoreclass2=='green' || scoreclass2=='red'){
           var str_score2_Addition      = str_score2.substring(0,1);
           var str_score2_subtraction   = Number(str_score2.substring(1));
       }
       if(scoreclass3=='green' || scoreclass3=='red'){
           var str_score3_Addition      = str_score3.substring(0,1);
           var str_score3_subtraction   = Number(str_score3.substring(1));
       }

       var score_Addition           = achievements/100;//获取每分金额
       var score                    = 100;//共一百分

       var td1                      = "";
       if(str_score1_Addition =='+'){

           score                    = score+str_score1_subtraction;//加分计算
           td1                      = str_score1_Addition+score_Addition*str_score1_subtraction+' (元)';//分数金额计算
       }
       if(str_score1_Addition =='-'){
           score                    = score-str_score1_subtraction;//减分计算
           td1                      = str_score1_Addition+score_Addition*str_score1_subtraction+' (元)';//分数金额计算
       }
       if(str_score1_Addition !=='+' && str_score1_Addition !=='-'){
           td1 = '0.00 (元)';
       }

       var td2                      = "";
       $('.salary_detali_score_td1').html(td1);
       if(str_score2_Addition=='+'){
           score                    = score+str_score2_subtraction;
           td2                      = str_score2_Addition+score_Addition*str_score2_subtraction+' (元)';
       }
       if(str_score2_Addition =='-'){
           score                    = score-str_score2_subtraction;
           td2                      = str_score2_Addition+score_Addition*str_score2_subtraction+' (元)';
       }
       if(str_score2_Addition !=='+' && str_score2_Addition !=='-'){
           td2 = '0.00 (元)';
       }

       $('.salary_detali_score_td2').html(td2);

       var td3                      = "";
       if(str_score3_Addition=='+'){
           score                    = score+str_score3_subtraction;
           td3                      = str_score3_Addition+score_Addition*str_score3_subtraction+' (元)';
       }
       if(str_score3_Addition =='-'){
           score                    = score-str_score3_subtraction;
           td3                      = str_score3_Addition+score_Addition*str_score3_subtraction+' (元)';
       }
       if(str_score3_Addition !=='+' && str_score3_Addition !=='-'){
           td3                      = '0.00 (元)';
       }
       $('.salary_detali_score_td3').html(td3);

       var money                    = '应发绩效工资 : '+score_Addition*score+' (元)';//显示效果绩效工资
       var subtraction              = '绩效增减 : '+(achievements-score_Addition*score)+' (元)';//显示效果绩效增减

       if(subtraction.indexOf('-')>0){
           subtraction = subtraction.replace('-','+');
       }else{
           subtraction =subtraction.replace('+','-');
       }
       $('.salary_should_paid').html(money);//应得绩效工资
       $('.salary_achievements_decrease').html(subtraction);//绩效增减

       //提成/奖金/补助
       var bonus                    ="<?php echo $info['list']['total']+$info['bonus']['bonus']+$info['bonus']['extract']+$info['subsidy']['housing_subsidy']+$info['subsidy']['foreign_subsidies']+$info['subsidy']['computer_subsidy']+$info['bonus']['annual_bonus'];?>";

       var bonus_str                = bonus+' (元)';
       $('.salary_subsidy1').html(bonus_str);//实发工资 -> 提成/奖金/补助

       //应发工资合计
       var count                    = score_Addition*score+Number(bonus)+Number(<?php echo $info['calculation']['grant'];?>);
       var html                     = '应发工资合计：'+count+' (元)';
        $('.salary_aggregate_should').html(html);

       //个税计税工资
        var content                 ="<?php echo $info['insurance']['birth_base']*$info['insurance']['birth_ratio']+$info['insurance']['injury_base']*$info['insurance']['injury_ratio']+$info['insurance']['pension_base']*$info['insurance']['pension_ratio']+$info['insurance']['medical_care_base']*$info['insurance']['medical_care_ratio']+$info['insurance']['big_price']+$info['insurance']['unemployment_base']*$info['insurance']['unemployment_ratio']+$info['insurance']['accumulation_fund_base']*$info['insurance']['accumulation_fund_ratio'];?>";//五险一金
       var content1                 = count-Number(content);//个税计税工资
       var content2                 = '个税计税工资 ： '+content1+' (元)';
       $('.salary_individual_tax_assessment').html(content2);

       var content_str              = content+' (元)';
       $('.five_risks').html(content_str);//实发工资 -> 五险一金

       //个人所得税
        if(content1 <= 5000){
            var counting            = '0.00';
        }else{
            var  cout               = content1-5000;

            if(cout <= 3000){
                var counting        = cout*0.03;
            }
            if(cout > 3000 && cout <= 12000){
                var counting        = cout*0.10-210;
            }
            if(cout > 12000 && cout <= 25000){
                var counting        = cout*0.20-1410;
            }
            if(cout > 25000 && cout <= 35000){
                var counting        = cout*0.25-2660;
            }
            if(cout > 35000 && cout <= 55000){
                var counting        = cout*0.30-4410;
            }
            if(cout > 55000 && cout <= 80000){
                var counting        = cout*0.35-7160;
            }
            if(cout > 80000){
                var counting        = cout*0.45-15160;
            }
        }
       var Tax_counting = '个人所得税 : '+(Math.floor(counting*100))/100+' (元)';
       $('.salary_individual_tax_assessment1').html(Tax_counting);

       //年终奖计税
       var bonus_money              = "<?php echo $info['bonus']['annual_bonus'];?>";//年中奖
       var bonus_price              = Number(bonus_money)/12;

       if(bonus_price < 1500){
           var price1               = bonus_price*0.03;
       }
       if(bonus_price > 1500 && bonus_price < 4500){
           var price1               = bonus_price*0.1-105;
       }
       if(bonus_price > 4500 && bonus_price < 9000){
           var price1               = bonus_price*0.2-555;
       }
       if(bonus_price > 9000 && bonus_price < 35000){
           var price1               = bonus_price*0.25-1055;
       }
       if(bonus_price > 35000 && bonus_price < 55000){
           var price1               = bonus_price*0.3-2755;
       }
       if(bonus_price > 55000 && bonus_price < 80000){
           var price1               = bonus_price*0.35-5505;
       }
       if(bonus_price>80000){
           var price1               = bonus_price*0.45-13505;
       }
       var price2                   = (Math.floor(price1*100))/100;
       var price3                   ='年终奖计税 : '+price2+' (元)';

       $('.salary_individual_tax_assessment2').html(price3);

       //实发工资->代扣代缴
       var listmoney =0;
       $('#salarytablelist1 tr').each(function(){
           var listmone             = $(this).children('.money').html();
           if(listmone !=='' || listmone !== null ){
               listmoney            += Number(listmone);
           }
       });
       //实发工资->其他收入
       var salarymoney =0;
       $('#salarytablelist2 tr').each(function(){
           var listsalarymoney      = $(this).children('.money').html();
           if(listsalarymoney !=='' || listsalarymoney !== null ){
               salarymoney          += Number(listsalarymoney);
           }
       });

       // 个税及工会会费、代扣代缴
       var count1                   = "<?php echo($info['calculation']['basic']-500)*0.01;?>";//工会会费
       var count_sum                = (Math.floor((counting+price2+Number(count1)+listmoney)*100))/100;//代扣代缴总数
       $('.salary_individual_totala').html(count_sum);
       var count_sum1               = count_sum+' (元)';
       $('.salary_individual_totala1').html(count_sum1);

       var Payroll                  = ({$info['salary'].standard_salary}- {$info['attendance']['withdrawing']}- achievements-score_Addition*score+ {$info['list']['total']}+{$info['bonus']['bonus']}+{$info['subsidy']['housing_subsidy']}+{$info['subsidy']['foreign_subsidies']}+{$info['bonus']['extract']}+{$info['subsidy']['computer_subsidy']}+{$info['bonus']['annual_bonus']}-content-count_sum-listmoney).toFixed(2);//
       var Payroll1                 = Payroll+(' (元)');
       $('.salary_Payroll').html(Payroll);
       $('.salary_Payroll1').html(Payroll1);


    $('.searchtex_color_salary').click(function(){
        //提交数据状态
        var account_id              = "{$info['account']['id']}";//用户id
        var datetime                = Number($('.searchtex_color_salary1 .monthly').val());//发放日期
        var salary_id               = "{$info['salary']['id']}";//岗位工资id
        var attendance_id           = "{$info['attendance']['id']}";//考勤id
        var bonus_id                = "{$info['bonus']['id']}";//提成/奖金/年终奖 id
        var department_id           = "{$info['account']['departmentid']}";//部门id
        var post_id                 = "{$info['account']['postid']}";//职务
        var income_token1           = "{$info['income'][0]['income_token']}";//其他收入
        var insurance_id            = "{$info['insurance']['id']}";//五险一金表
        var subsidy_id              = "{$info['subsidy']['id']}";//补贴
        var withholding_token       = "{$info['withholding'][0]['token']}";//代扣代缴
        Payroll;//实发工资
        var standard                = "{$info['salary'].standard_salary}";//岗位标准薪资
        var withdrawing             = "{$info['attendance'].withdrawing}";//考勤扣款
        var Achieve_withdrawing     = Number(achievements-score_Addition*score);//绩效扣款
        var Subsidy                 = "{$info['bonus']['extract']}";//带团补助
        var total1                  = "{$info['list']['total']}";//提成
        count ;//应发工资
        content;//五险一金
        count_sum;//代扣代缴
        if(account_id=="" || datetime=="" || salary_id=="" || attendance_id=="" || department_id=="" || post_id=="" || income_token1=="" || insurance_id=="" || Payroll=="" || standard==""|| count=="" || content==""){
            alert("数据不完整!请填写完整后提交!");return false;
        }
        var url                         = "index.php?m=Main&c=Ajax&a=Ajax_salary_details_add";
        $.ajax({
            type: "POST",
            url: url, //url
            data: {
                'account_id':Number(account_id),
                'datetime':Number(datetime),
                'salary_id':Number(salary_id),
                'attendance_id':Number(attendance_id),
                'bonus_id':Number(bonus_id),
                'department_id':Number(department_id),
                'post_id':Number(post_id),
                'income_token1':Number(income_token1),
                'insurance_id':Number(insurance_id),
                'subsidy_id':Number(subsidy_id),
                'withholding_token':Number(withholding_token),
                'Payroll':Number(Payroll),
                'standard':Number(standard),
                'withdrawing':Number(withdrawing),
                'Achievements_withdrawing':Number(Achieve_withdrawing),
                'Subsidy':Number(Subsidy),
                'total1':Number(total1),
                'count':Number(count),
                'content':Number(content),
                'count_sum':Number(count_sum),
            },
            dataType: "json", //数据格式
            success: function (data) {
                if (data.sum == 1) {
                    alert(data.msg);
                    return false;
                }
                if (data.sum == 0) {
                    alert(data.msg);
                    return false;
                }
            }
        });
    })

</script>