<include file="Index:header2" />
<script src="__HTML__/js/public.js?v=1.0.6" type="text/javascript"></script>
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>工资表</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Salary/salaryindex')}"><i class="fa fa-gift"></i>人力管理</a></li>
                        <li class="active">生成工资表</li>
                    </ol>

                </section>

                <!-- Main content -->
                <section class="content" >

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box" style="width:180em;">
                                <div class="box-header">
                                    <h3 class="box-title">员工薪资列表</h3>

                                </div><!-- /.box-header --><br>
                                <div  style="margin-left:20em;">
                                        <a href="{:U('Salary/salary_excel_list')}" class="btn <?php if($status=="" || $status==0){ echo 'btn-info';}else{ echo 'btn-default';} ?>" style="width:10em;">待提交审核</a>
                                        <a href="{:U('Salary/salary_excel_list',array('status'=>1))}" class="btn <?php if($status==1){ echo 'btn-info';}else{ echo 'btn-default';} ?>" style="width:10em;">待提交批准</a>
                                        <a href="{:U('Salary/salary_excel_list',array('status'=>2))}" class="btn <?php if($status==2){ echo 'btn-info';}else{ echo 'btn-default';} ?>" style="width:10em;">待批准</a>
                                        <a href="{:U('Salary/salary_excel_list',array('status'=>3))}" class="btn <?php if($status==3){ echo 'btn-info';}else{ echo 'btn-default';} ?>" style="width:10em;">已批准</a>
                                </div><!-- /.box-header --><br>
                                <div class="box-header">
                                </div><br>
                                <div class="box-body">
                                    <div class="btn-group" id="catfont">
                                        <a href="{:U('Salary/salary_excel_list')}" class="btn <?php if($type=="" || $type==0){ echo 'btn-info';}else{ echo 'btn-default';} ?>">所有</a>
                                        <a href="{:U('Salary/salary_excel_list',array('archives'=>1))}" class="btn <?php if($type==1){ echo 'btn-info';}else{ echo 'btn-default';} ?>">中心</a>
                                        <a href="{:U('Salary/salary_excel_list',array('archives'=>2))}" class="btn <?php if($type==2){ echo 'btn-info';}else{ echo 'btn-default';} ?>">科旅</a>
                                        <a href="{:U('Salary/salary_excel_list',array('archives'=>3))}" class="btn <?php if($type==3){ echo 'btn-info';}else{ echo 'btn-default';} ?>">科行</a>
                                        <a href="{:U('Salary/salary_excel_list',array('archives'=>4))}" class="btn <?php if($type==4){ echo 'btn-info';}else{ echo 'btn-default';} ?>">行管局</a>
                                    </div>

                                <br><br>
                                    <div class="btn-group">
                                        <table class="table table-bordered dataTablev">
                                            <tr role="row" class="orders" >
                                                <th class="sorting" style="width:8em">ID</th>
                                                <th class="sorting" style="width:8em">员工姓名</th>
                                                <th class="sorting" style="width:8em">岗位名称</th>
                                                <th class="sorting" style="width:8em">所属部门</th>
                                                <th class="sorting" style="width:12em">岗位薪酬标准</th>
                                                <th class="sorting" style="width:12em">其中基本工资标准</th>
                                                <th class="sorting" style="width:8em">考勤扣款</th>
                                                <th class="sorting" style="width:12em">其中绩效工资标准</th>
                                                <th class="sorting" style="width:8em">绩效增减</th>
                                                <th class="sorting" style="width:8em">业绩提成</th>
                                                <th class="sorting" style="width:8em">奖金</th>
                                                <th class="sorting" style="width:8em">住房补贴</th>
                                                <th class="sorting" style="width:8em">其他补款</th>
                                                <th class="sorting" style="width:8em">应发工资</th>
                                                <th class="sorting" style="width:8em">医疗保险</th>
                                                <th class="sorting" style="width:8em">养老保险</th>
                                                <th class="sorting" style="width:8em">失业保险</th>
                                                <th class="sorting" style="width:8em">公积金</th>
                                                <th class="sorting" style="width:12em">个人保险合计</th>
                                                <th class="sorting" style="width:8em">计税工资</th>
                                                <th class="sorting" style="width:10em">个人所得税</th>
                                                <th class="sorting" style="width:8em">税后扣款</th>
                                                <th class="sorting" style="width:8em">工会会费</th>
                                                <th class="sorting" style="width:8em">实发工资</th>
                                            </tr>

                                            <foreach name="info" item="info">
                                            <tr class="excel_list_money2">
                                                <td>{$info['account']['id']}</td>
                                                <td>{$info['account']['nickname']}</td>
                                                <td>{$info['posts'][0]['post_name']}</td>
                                                <td>{$info['department'][0]['department']}</td>
                                                <td>&yen; {$info['salary'][0]['standard_salary']}</td>
                                                <td>&yen; {$info['salary'][0]['standard_salary']/10*$info['salary'][0]['basic_salary']}</td>
                                                <td>&yen; {$info['attendance'][0]['withdrawing']}</td>
                                                <td>&yen; {$info['salary'][0]['standard_salary']/10*$info['salary'][0]['performance_salary']}</td>
                                                <td>&yen; {$info['Achievements']['count_money']}</td>
                                                <td>&yen; {$info['Extract']['total']}</td>
                                                <td>&yen; {$info['bonus'][0]['bonus']}</td>
                                                <td>&yen; {$info['subsidy'][0]['housing_subsidy']}</td>
                                                <td>&yen; {$info['Other']}</td>
                                                <td>&yen; {$info['salary'][0]['standard_salary']/10*$info['salary'][0]['performance_salary']+$info['Achievements']['count_money']}</td>
                                                <td>&yen; {$info['insurance'][0]['medical_care_base']*$info['insurance'][0]['medical_care_ratio']}</td>
                                                <td>&yen; {$info['insurance'][0]['pension_base']*$info['insurance'][0]['pension_ratio']}</td>
                                                <td>&yen; {$info['insurance'][0]['unemployment_base']*$info['insurance'][0]['unemployment_ratio']}</td>
                                                <td>&yen; {$info['insurance'][0]['accumulation_fund_base']*$info['insurance'][0]['accumulation_fund_ratio']}</td>
                                                <td>&yen; {$info['insurance_Total']}</td>
                                                <td>&yen; {$info['tax_counting']}</td>
                                                <td>&yen; {$info['personal_tax']}</td>
                                                <td>&yen; {$info['summoney']}</td>
                                                <td>&yen; {$info['Labour']}</td>
                                                <td>&yen; {$info['real_wages']}</td>

                                                <td style="display:none">{$info['account']['departmentid']}</td>
                                                <td style="display:none">{$info['account']['postid']}</td>
                                                <td style="display:none">{$info['salary'][0]['id']}</td>
                                                <td style="display:none">{$info['salary'][0]['standard_salary']}</td>
                                                <td style="display:none">{$info['attendance'][0]['id']}</td>
                                                <td style="display:none">{$info['bonus'][0]['id']}</td>
                                                <td style="display:none">{$info['income'][0]['income_token']}</td>
                                                <td style="display:none">{$info['insurance'][0]['id']}</td>
                                                <td style="display:none">{$info['Extract']['total']+$info['insurance'][0]['big_price']}</td>
                                                <td style="display:none">{$info['subsidy'][0]['id']}</td>
                                                <td style="display:none">{$info['withholding'][0]['token']}</td>
                                                <td style="display:none">{$info['Achievements']['total_score_show']}</td>
                                                <td style="display:none">{$info['Achievements']['show_qa_score']}</td>
                                                <td style="display:none">{$info['Achievements']['sum_total_score']}</td>
                                                <td style="display:none">{$info['Achievements']['count_money']}</td>
                                                <td style="display:none">{$info['Extract']['target']}</td>
                                                <td style="display:none">{$info['Extract']['complete']}</td>
                                                <td style="display:none">{$info['yearend']}</td>
                                            </tr>
                                            </foreach>
                                            <foreach name="sum" item="sum">
                                            <tr class="excel_list_money2">
                                                <td colspan="3" style="text-align: center;">{$sum['name']}</td>
                                                <td>{$sum['department']}</td>
                                                <td>&yen; {$sum['standard_salary']}</td>
                                                <td>&yen; {$sum['basic']}</td>
                                                <td>&yen; {$sum['withdrawing']}</td>
                                                <td>&yen; {$sum['performance_salary']}</td>
                                                <td>&yen; {$sum['count_money']}</td>
                                                <td>&yen; {$sum['total']}</td>
                                                <td>&yen; {$sum['bonus']}</td>
                                                <td>&yen; {$sum['housing_subsidy']}</td>
                                                <td>&yen; {$sum['Other']}</td>
                                                <td>&yen; {$sum['Should']}</td>
                                                <td>&yen; {$sum['care']}</td>
                                                <td>&yen; {$sum['pension']}</td>
                                                <td>&yen; {$sum['unemployment']}</td>
                                                <td>&yen; {$sum['accumulation']}</td>
                                                <td>&yen; {$sum['insurance_Total']}</td>
                                                <td>&yen; {$sum['tax_counting']}</td>
                                                <td>&yen; {$sum['personal_tax']}</td>
                                                <td>&yen; {$sum['summoney']}</td>
                                                <td>&yen; {$sum['Labour']}</td>
                                                <td>&yen; {$sum['real_wages']}</td>
                                            </tr>
                                            </foreach>
                                                <tr>
                                                    <td colspan="3" style="text-align: center;">{$count['name']}</td>
                                                    <td>&yen; {$count['standard_salary']}</td>
                                                    <td>&yen; {$count['basic']}</td>
                                                    <td>&yen; {$count['withdrawing']}</td>
                                                    <td>&yen; {$count['performance_salary']}</td>
                                                    <td>&yen; {$count['count_money']}</td>
                                                    <td>&yen; {$count['total']}</td>
                                                    <td>&yen; {$count['bonus']}</td>
                                                    <td>&yen; {$count['housing_subsidy']}</td>
                                                    <td>&yen; {$count['Other']}</td>
                                                    <td>&yen; {$count['Should']}</td>
                                                    <td>&yen; {$count['care']}</td>
                                                    <td>&yen; {$count['pension']}</td>
                                                    <td>&yen; {$count['unemployment']}</td>
                                                    <td>&yen; {$count['accumulation']}</td>
                                                    <td>&yen; {$count['insurance_Total']}</td>
                                                    <td>&yen; {$count['tax_counting']}</td>
                                                    <td>&yen; {$count['personal_tax']}</td>
                                                    <td>&yen; {$count['summoney']}</td>
                                                    <td>&yen; {$count['Labour']}</td>
                                                    <td>&yen; {$count['real_wages']}</td>
                                                </tr>
                                        </table>
                                    </div>
                                </div><!-- /.box-body -->
                                 <div class="box-footer clearfix">
                                	<div class="pagestyle">{$page}</div>
                                </div>
                                <div>
<!--                                  --><?php //if($stat="" && $userid==77){?>
                                        <a  class="btn btn-info salary_excel1_submit" style="width:10em;margin-left:45em;">提交审核</a>
<!--                                    --><?php //}?>
                                    <?php if($stat=1 && $userid ==55){?>
                                        <a  class="btn btn-info salary_excel1_submit" style="width:10em;margin-left:45em;">提交批准</a>
                                        <a  class="btn btn-info salary_excel1_submit" style="width:10em;">驳回</a>
                                    <?php }?>
                                    <?php if($stat=2 && $userid ==11){?>
                                        <a  class="btn btn-info salary_excel1_submit" style="width:10em;margin-left:45em;">批准</a>
                                        <a  class="btn btn-info salary_excel1_submit" style="width:10em;">驳回</a>
                                    <?php }?>
                                    </div><br><br>
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



<include file="Index:footer2" />
<script>

</script>
