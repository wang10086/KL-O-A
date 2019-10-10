<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {$pagetitle}
                        <small>{$_action_}</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> {$pagetitle}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$year}年{$_action_}</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                <div class="btn-group" id="catfont" style="padding-bottom:5px;">
                                    <?php if($prveyear>2018){ ?>
                                        <a href="{:U('Rbac/HR_cost',array('year'=>$prveyear,'month'=>'01'))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                    <?php } ?>
                                    <?php
                                        for($i=1;$i<13;$i++){
                                            $par = array();
                                            $par['year']  	= $year;
                                            $par['month'] 	= str_pad($i,2,"0",STR_PAD_LEFT);
                                            $par['pin']     = $pin;
                                            if($month==str_pad($i,2,"0",STR_PAD_LEFT)){
                                                echo '<a href="'.U('Rbac/HR_cost',$par).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'月</a>';
                                            }else{
                                                echo '<a href="'.U('Rbac/HR_cost',$par).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                                            }
                                        }
                                    ?>
                                    <?php if($year<date('Y')){ ?>
                                        <a href="{:U('Rbac/HR_cost',array('year'=>$nextyear,'month'=>'01'))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                    <?php } ?>
                                </div>

                                    <div class="btn-group" id="catfont" style="padding-bottom:5px; float: right;clear: both;">
                                        <a href="{:U('Rbac/HR_cost',array('year'=>$year,'month'=>$month,'pin'=>0))}" class="btn <?php echo $pin==0 ? 'btn-info' : 'btn-default'; ?>" style="padding:8px 18px;">月度统计</a>
                                        <a href="{:U('Rbac/HR_cost',array('year'=>$year,'month'=>$month,'pin'=>1))}" class="btn <?php echo $pin==1 ? 'btn-info' : 'btn-default'; ?>" style="padding:8px 18px;">月度累计统计</a>
                                    </div>

								<table class="table table-bordered dataTable" id="tablelist">
                                    <tr role="row" class="orders" >
                                        <th class="taskOptions">类别</th>
                                        <th class="taskOptions">细项</th>
                                        <th class="taskOptions"><a href="{:U('Rbac/public_cost_detail',array('year'=>$year,month=>$month,pin=>$pin,'uids'=>$uids['公司']))}">公司</a></th>
                                        <th class="taskOptions"><a href="{:U('Rbac/public_cost_detail',array('year'=>$year,month=>$month,pin=>$pin,'uids'=>$uids['京区业务中心']))}">京区业务中心</a></th>
                                        <th class="taskOptions"><a href="{:U('Rbac/public_cost_detail',array('year'=>$year,month=>$month,pin=>$pin,'uids'=>$uids['京外业务中心']))}">京外业务中心</a></th>
                                        <th class="taskOptions"><a href="{:U('Rbac/public_cost_detail',array('year'=>$year,month=>$month,pin=>$pin,'uids'=>$uids['南京项目部']))}">南京项目部</a></th>
                                        <th class="taskOptions"><a href="{:U('Rbac/public_cost_detail',array('year'=>$year,month=>$month,pin=>$pin,'uids'=>$uids['武汉项目部']))}">武汉项目部</a></th>
                                        <th class="taskOptions"><a href="{:U('Rbac/public_cost_detail',array('year'=>$year,month=>$month,pin=>$pin,'uids'=>$uids['沈阳项目部']))}">沈阳项目部</a></th>
                                        <th class="taskOptions"><a href="{:U('Rbac/public_cost_detail',array('year'=>$year,month=>$month,pin=>$pin,'uids'=>$uids['长春项目部']))}">长春项目部</a></th>
                                        <th class="taskOptions"><a href="{:U('Rbac/public_cost_detail',array('year'=>$year,month=>$month,pin=>$pin,'uids'=>$uids['市场部']))}">市场部</a></th>
                                        <th class="taskOptions"><a href="{:U('Rbac/public_cost_detail',array('year'=>$year,month=>$month,pin=>$pin,'uids'=>$uids['常规业务中心']))}">常规业务中心</a></th>
                                        <th class="taskOptions"><a href="{:U('Rbac/public_cost_detail',array('year'=>$year,month=>$month,pin=>$pin,'uids'=>$uids['机关部门']))}">机关部门</a></th>
                                    </tr>
                                    <tr>
                                        <td class="taskOptions" colspan="2"><?php echo $pin==1 ? "01月 - $month月合计" : "$month月合计"; ?>{$month}月合计</td>
                                        <td class="taskOptions">{$thisMonthSum['公司']}</td>
                                        <td class="taskOptions">{$thisMonthSum['京区业务中心']}</td>
                                        <td class="taskOptions">{$thisMonthSum['京外业务中心']}</td>
                                        <td class="taskOptions">{$thisMonthSum['南京项目部']}</td>
                                        <td class="taskOptions">{$thisMonthSum['武汉项目部']}</td>
                                        <td class="taskOptions">{$thisMonthSum['沈阳项目部']}</td>
                                        <td class="taskOptions">{$thisMonthSum['长春项目部']}</td>
                                        <td class="taskOptions">{$thisMonthSum['市场部']}</td>
                                        <td class="taskOptions">{$thisMonthSum['常规业务中心']}</td>
                                        <td class="taskOptions">{$thisMonthSum['机关部门']}</td>
                                    </tr>
                                    <tr>
                                        <td class="taskOptions" rowspan="5">岗位薪酬</td>
                                        <td class="taskOptions">合计</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['公司']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['京区业务中心']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['京外业务中心']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['南京项目部']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['武汉项目部']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['沈阳项目部']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['长春项目部']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['市场部']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['常规业务中心']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['机关部门']['sum']}</td>
                                    </tr>
                                    <tr>
                                        <td class="taskOptions">基本工资</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['公司']['really_basic_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['京区业务中心']['really_basic_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['京外业务中心']['really_basic_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['南京项目部']['really_basic_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['武汉项目部']['really_basic_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['沈阳项目部']['really_basic_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['长春项目部']['really_basic_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['市场部']['really_basic_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['常规业务中心']['really_basic_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['机关部门']['really_basic_salary']}</td>
                                    </tr>
                                    <tr>
                                        <td class="taskOptions">绩效工资</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['公司']['really_performance_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['京区业务中心']['really_performance_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['京外业务中心']['really_performance_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['南京项目部']['really_performance_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['武汉项目部']['really_performance_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['沈阳项目部']['really_performance_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['长春项目部']['really_performance_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['市场部']['really_performance_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['常规业务中心']['really_performance_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['机关部门']['really_performance_salary']}</td>
                                    </tr>
                                    <tr>
                                        <td class="taskOptions">标准基本工资</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['公司']['basic_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['京区业务中心']['basic_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['京外业务中心']['basic_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['南京项目部']['basic_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['武汉项目部']['basic_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['沈阳项目部']['basic_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['长春项目部']['basic_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['市场部']['basic_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['常规业务中心']['basic_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['机关部门']['basic_salary']}</td>
                                    </tr>
                                    <tr>
                                        <td class="taskOptions">标准绩效工资</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['公司']['performance_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['京区业务中心']['performance_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['京外业务中心']['performance_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['南京项目部']['performance_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['武汉项目部']['performance_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['沈阳项目部']['performance_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['长春项目部']['performance_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['市场部']['performance_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['常规业务中心']['performance_salary']}</td>
                                        <td class="taskOptions">{$thisMonthPostSalary['机关部门']['performance_salary']}</td>
                                    </tr>

                                    <!--奖金-->
                                    <tr>
                                        <td class="taskOptions" rowspan="4">奖金</td>
                                        <td class="taskOptions">合计</td>
                                        <td class="taskOptions">{$thisMonthBonus['公司']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['京区业务中心']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['京外业务中心']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['南京项目部']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['武汉项目部']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['沈阳项目部']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['长春项目部']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['市场部']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['常规业务中心']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['机关部门']['sum']}</td>
                                    </tr>
                                    <tr>
                                        <td class="taskOptions">业绩提成</td>
                                        <td class="taskOptions">{$thisMonthBonus['公司']['royalty']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['京区业务中心']['royalty']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['京外业务中心']['royalty']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['南京项目部']['royalty']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['武汉项目部']['royalty']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['沈阳项目部']['royalty']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['长春项目部']['royalty']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['市场部']['royalty']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['常规业务中心']['royalty']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['机关部门']['royalty']}</td>
                                    </tr>
                                    <tr>
                                        <td class="taskOptions">奖金包</td>
                                        <td class="taskOptions">{$thisMonthBonus['公司']['bonus']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['京区业务中心']['bonus']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['京外业务中心']['bonus']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['南京项目部']['bonus']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['武汉项目部']['bonus']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['沈阳项目部']['bonus']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['长春项目部']['bonus']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['市场部']['bonus']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['常规业务中心']['bonus']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['机关部门']['bonus']}</td>
                                    </tr>
                                    <tr>
                                        <td class="taskOptions">年终奖</td>
                                        <td class="taskOptions">{$thisMonthBonus['公司']['yearEndBonus']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['京区业务中心']['yearEndBonus']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['京外业务中心']['yearEndBonus']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['南京项目部']['yearEndBonus']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['武汉项目部']['yearEndBonus']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['沈阳项目部']['yearEndBonus']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['长春项目部']['yearEndBonus']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['市场部']['yearEndBonus']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['常规业务中心']['yearEndBonus']}</td>
                                        <td class="taskOptions">{$thisMonthBonus['机关部门']['yearEndBonus']}</td>
                                    </tr>

                                    <!--补助-->
                                    <tr>
                                        <td class="taskOptions" rowspan="5">补助</td>
                                        <td class="taskOptions">合计</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['公司']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['京区业务中心']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['京外业务中心']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['南京项目部']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['武汉项目部']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['沈阳项目部']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['长春项目部']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['市场部']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['常规业务中心']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['机关部门']['sum']}</td>
                                    </tr>
                                    <tr>
                                        <td class="taskOptions">带团补助</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['公司']['op_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['京区业务中心']['op_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['京外业务中心']['op_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['南京项目部']['op_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['武汉项目部']['op_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['沈阳项目部']['op_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['长春项目部']['op_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['市场部']['op_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['常规业务中心']['op_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['机关部门']['op_subsidy']}</td>
                                    </tr>
                                    <tr>
                                        <td class="taskOptions">电脑补助</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['公司']['computer_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['京区业务中心']['computer_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['京外业务中心']['computer_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['南京项目部']['computer_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['武汉项目部']['computer_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['沈阳项目部']['computer_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['长春项目部']['computer_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['市场部']['computer_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['常规业务中心']['computer_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['机关部门']['computer_subsidy']}</td>
                                    </tr>
                                    <tr>
                                        <td class="taskOptions">外地补助</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['公司']['foreign_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['京区业务中心']['foreign_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['京外业务中心']['foreign_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['南京项目部']['foreign_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['武汉项目部']['foreign_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['沈阳项目部']['foreign_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['长春项目部']['foreign_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['市场部']['foreign_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['常规业务中心']['foreign_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['机关部门']['foreign_subsidy']}</td>
                                    </tr>
                                    <tr>
                                        <td class="taskOptions">其他收入变动</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['公司']['other_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['京区业务中心']['other_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['京外业务中心']['other_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['南京项目部']['other_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['武汉项目部']['other_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['沈阳项目部']['other_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['长春项目部']['other_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['市场部']['other_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['常规业务中心']['other_subsidy']}</td>
                                        <td class="taskOptions">{$thisMonthSubsidy['机关部门']['other_subsidy']}</td>
                                    </tr>

                                    <!--公司五险一金-->
                                    <tr>
                                        <td class="taskOptions" rowspan="3">公司五险一金</td>
                                        <td class="taskOptions">合计</td>
                                        <td class="taskOptions">{$thisMonthInsurance['公司']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthInsurance['京区业务中心']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthInsurance['京外业务中心']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthInsurance['南京项目部']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthInsurance['武汉项目部']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthInsurance['沈阳项目部']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthInsurance['长春项目部']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthInsurance['市场部']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthInsurance['常规业务中心']['sum']}</td>
                                        <td class="taskOptions">{$thisMonthInsurance['机关部门']['sum']}</td>
                                    </tr>
                                    <tr>
                                        <td class="taskOptions">公司五险</td>
                                        <td class="taskOptions">{$thisMonthInsurance['公司']['fiveRisks']}</td>
                                        <td class="taskOptions">{$thisMonthInsurance['京区业务中心']['fiveRisks']}</td>
                                        <td class="taskOptions">{$thisMonthInsurance['京外业务中心']['fiveRisks']}</td>
                                        <td class="taskOptions">{$thisMonthInsurance['南京项目部']['fiveRisks']}</td>
                                        <td class="taskOptions">{$thisMonthInsurance['武汉项目部']['fiveRisks']}</td>
                                        <td class="taskOptions">{$thisMonthInsurance['沈阳项目部']['fiveRisks']}</td>
                                        <td class="taskOptions">{$thisMonthInsurance['长春项目部']['fiveRisks']}</td>
                                        <td class="taskOptions">{$thisMonthInsurance['市场部']['fiveRisks']}</td>
                                        <td class="taskOptions">{$thisMonthInsurance['常规业务中心']['fiveRisks']}</td>
                                        <td class="taskOptions">{$thisMonthInsurance['机关部门']['fiveRisks']}</td>
                                    </tr>
                                    <tr>
                                        <td class="taskOptions">公司一金</td>
                                        <td class="taskOptions">{$thisMonthInsurance['公司']['oneFund']}</td>
                                        <td class="taskOptions">{$thisMonthInsurance['京区业务中心']['oneFund']}</td>
                                        <td class="taskOptions">{$thisMonthInsurance['京外业务中心']['oneFund']}</td>
                                        <td class="taskOptions">{$thisMonthInsurance['南京项目部']['oneFund']}</td>
                                        <td class="taskOptions">{$thisMonthInsurance['武汉项目部']['oneFund']}</td>
                                        <td class="taskOptions">{$thisMonthInsurance['沈阳项目部']['oneFund']}</td>
                                        <td class="taskOptions">{$thisMonthInsurance['长春项目部']['oneFund']}</td>
                                        <td class="taskOptions">{$thisMonthInsurance['市场部']['oneFund']}</td>
                                        <td class="taskOptions">{$thisMonthInsurance['常规业务中心']['oneFund']}</td>
                                        <td class="taskOptions">{$thisMonthInsurance['机关部门']['oneFund']}</td>
                                    </tr>

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

<include file="Index:footer2" />
