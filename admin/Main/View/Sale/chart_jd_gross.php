<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        毛利率统计
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> 数据统计</a></li>
                        <li class="active">毛利率统计</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">

                            <!--<div class="btn-group" id="catfont" style="padding-bottom:20px;">
                                <?php /*if($prveyear>2019){ */?>
                                    <a href="{:U('Sale/chart_jd_gross',array('year'=>$prveyear,'uid'=>$uid))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                <?php /*} */?>
                                <?php
/*                                    for($i=1;$i<13;$i++){
                                        if (strlen($i)<2){ $i = str_pad($i,2,'0',STR_PAD_LEFT);}
                                        $par = array();
                                        $par['year']  = $year;
                                        $par['month'] = $i;
                                        $par['uid']   = $uid;
                                        if($month==$i){
                                            echo '<a href="'.U('Sale/chart_jd_gross',$par).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'月</a>';
                                        }else{
                                            echo '<a href="'.U('Sale/chart_jd_gross',$par).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                                        }
                                    }
                                */?>
                                <?php /*if($year<date('Y')){ */?>
                                    <a href="{:U('Sale/chart_jd_gross',array('year'=>$nextyear,'uid'=>$uid))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                <?php /*} */?>
                            </div>-->

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">毛利率统计</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <include file="chart_gross_nave" />

                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th class="taskOptions" rowspan="2">计调人员</th>
                                            <th class="taskOptions" rowspan="2">累计操作收入</th>
                                            <th class="taskOptions" rowspan="2">最低毛利额</th>
                                            <th class="taskOptions" rowspan="2">累计操作毛利</th>
                                            <th class="taskOptions" colspan="2">包含大交通</th>
                                            <th class="taskOptions" colspan="2">不包含大交通</th>
                                            <if condition="rolemenu(array('Sale/gross_jd_info'))">
                                            <th width="80" class="taskOptions" rowspan="2">详情</th>
                                            </if>
                                        </tr>
                                        <tr role="row" class="orders" >
                                            <!--<th class="taskOptions">累计操作毛利</th>-->
                                            <th class="taskOptions">累计操作毛利率</th>
                                            <th class="taskOptions">毛利率完成率</th>
                                            <!--<th class="taskOptions">累计操作毛利</th>-->
                                            <th class="taskOptions">累计操作毛利率</th>
                                            <th class="taskOptions">毛利率完成率</th>
                                        </tr>
                                        <foreach name="lists" key="k" item="v">
                                            <tr>
                                                <td class="taskOptions">{$k}</td>
                                                <td class="taskOptions">{$v['合计']['shouru']}</td>
                                                <td class="taskOptions">{$v['合计']['low_gross']}</td>
                                                <td class="taskOptions">{$v['合计']['maoli']}</td>
                                                <td class="taskOptions">{$v['合计']['maolilv']}</td>
                                                <td class="taskOptions">{$v['合计']['rate']}</td>
                                                <!--<td class="taskOptions">{$v['合计']['untraffic_maoli']}</td>-->
                                                <td class="taskOptions">{$v['合计']['untraffic_maolilv']}</td>
                                                <td class="taskOptions">{$v['合计']['untraffic_rate']}</td>
                                                <if condition="rolemenu(array('Sale/gross_jd_info'))">
                                                <td class="taskOptions">
                                                    <a href="{:U('Sale/gross_jd_info',array('jid'=>$v['合计']['jd_id'],'jname'=>$v['合计']['jd'],'year'=>$year))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></a>
                                                </td>
                                                </if>
                                            </tr>
                                        </foreach>
                                        <tr class="black">
                                            <td class="taskOptions">合计</td>
                                            <td class="taskOptions">{$sum['合计']['shouru']}</td>
                                            <td class="taskOptions">{$sum['合计']['low_gross']}</td>
                                            <td class="taskOptions">{$sum['合计']['maoli']}</td>
                                            <td class="taskOptions">{$sum['合计']['maolilv']}</td>
                                            <td class="taskOptions">{$sum['合计']['rate']}</td>
                                            <!--<td class="taskOptions">{$sum['合计']['untraffic_maoli']}</td>-->
                                            <td class="taskOptions">{$sum['合计']['untraffic_maolilv']}</td>
                                            <td class="taskOptions">{$sum['合计']['untraffic_rate']}</td>
                                            <if condition="rolemenu(array('Sale/gross_jd_info'))">
                                            <td class="taskOptions">
                                                <a href="{:U('Sale/gross_jd_info',array('jid'=>$sum['合计']['jd_id'],'jname'=>$sum['合计']['jd'],'year'=>$year))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></a>
                                            </td>
                                            </if>
                                        </tr>
                                        <tr>
                                            <td colspan="9" style="text-align: left;padding-left: 20px;">
                                                <p>说明：1、该数据从{$year-1}年12月26日起结算项目统计，本页面数据包含地接团数据。</p>
                                                <p>&emsp;&emsp;&emsp;2、各计调统计数据中不包括“南北极合作”项目和“其他”项目；公司合计数据中包括“南北极合作”项目和“其他”项目。</p>
                                            </td>
                                        </tr>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->

<include file="Index:footer2" />
