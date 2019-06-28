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

                            <div class="btn-group" id="catfont" style="padding-bottom:20px;">
                                <?php if($prveyear>2019){ ?>
                                    <a href="{:U('Sale/chart_jd_gross',array('year'=>$prveyear,'uid'=>$uid))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                <?php } ?>
                                <?php
                                    for($i=1;$i<13;$i++){
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
                                ?>
                                <?php if($year<date('Y')){ ?>
                                    <a href="{:U('Sale/chart_jd_gross',array('year'=>$nextyear,'uid'=>$uid))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                <?php } ?>
                            </div>

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">毛利率统计</h3>
                                    <div class="box-tools pull-right">
                                        <!--<a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',800,220);"><i class="fa fa-search"></i> 搜索</a>
                                        <if condition="rolemenu(array('Sale/plans'))">
                                            <a href="{:U('Sale/plans')}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 项目计划</a>
                                        </if>-->
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <include file="chart_gross_nave" />

                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th class="taskOptions">计调人员</th>
                                            <th class="taskOptions">业务类型</th>
                                            <th class="taskOptions">累计操作收入</th>
                                            <th class="taskOptions">最低毛利额</th>
                                            <th class="taskOptions">累计操作毛利</th>
                                            <th class="taskOptions">累计操作毛利率</th>
                                            <th class="taskOptions">毛利率完成率</th>
                                            <th width="80" class="taskOptions">详情</th>
                                            <!--<if condition="rolemenu(array('Sale/plans_info'))">
                                            </if>-->
                                        </tr>
                                        <foreach name="lists" key="k" item="v">
                                            <tr>
                                                <td class="taskOptions" rowspan="<?php echo $v['rowspan']; ?>">{$k}</td>
                                                <td class="taskOptions">{$v['info']?$v['info'][0]['kind']:$v['合计']['kind']}</td>
                                                <td class="taskOptions">{$v['info']?$v['info'][0]['shouru']:$v['合计']['shouru']}</td>
                                                <td class="taskOptions">{$v['info']?$v['info'][0]['low_gross']:$v['合计']['low_gross']}</td>
                                                <td class="taskOptions">{$v['info']?$v['info'][0]['maoli']:$v['合计']['maoli']}</td>
                                                <td class="taskOptions">{$v['info']?$v['info'][0]['maolilv']:$v['合计']['maolilv']}</td>
                                                <td class="taskOptions"></td>
                                                <!--<if condition="rolemenu(array('Sale/plans_follow'))">-->
                                                <td class="taskOptions">
                                                    <a href="javascript:;" onclick="art_show_msg('加班开发中...')" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></a>
                                                </td>
                                                <!--</if>-->
                                            </tr>
                                            <?php if (count($v['info'])>0){ ?>
                                            <foreach name="v['info']" key="kk" item="vv">
                                                <tr <?php if (!$v['info'][($kk+1)]['num']) echo "class='black'" ?>>
                                                    <td class="taskOptions"><?php echo $v['info'][($kk+1)]['kind']?$v['info'][($kk+1)]['kind']:$v['合计']['kind']; ?></td>
                                                    <td class="taskOptions"><?php echo $v['info'][($kk+1)]['shouru']?$v['info'][($kk+1)]['shouru']:$v['合计']['shouru']; ?></td>
                                                    <td class="taskOptions"><?php echo $v['info'][($kk+1)]['low_gross']?$v['info'][($kk+1)]['low_gross']:$v['合计']['low_gross']; ?></td>
                                                    <td class="taskOptions"><?php echo $v['info'][($kk+1)]['maoli']?$v['info'][($kk+1)]['maoli']:$v['合计']['maoli']; ?></td>
                                                    <td class="taskOptions"><?php echo $v['info'][($kk+1)]['maolilv']?$v['info'][($kk+1)]['maolilv']:$v['合计']['maolilv']; ?></td>
                                                    <td class="taskOptions"><?php echo $v['info'][($kk+1)]['']?$v['info'][($kk+1)]['']:$v['合计']['']; ?></td>
                                                    <!--<if condition="rolemenu(array('Sale/plans_follow'))">-->
                                                    <td class="taskOptions">
                                                        <a href="javascript:;" onclick="art_show_msg('加班开发中...')" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></a>
                                                    </td>
                                                    <!--</if>-->
                                                </tr>
                                            </foreach>
                                            <?php } ?>
                                        </foreach>
                                        <tr class="black">
                                            <td class="taskOptions" colspan="2">{$sum['合计']['kind']}</td>
                                            <td class="taskOptions">{$sum['合计']['shouru']}</td>
                                            <td class="taskOptions">{$sum['合计']['low_gross']}</td>
                                            <td class="taskOptions">{$sum['合计']['maoli']}</td>
                                            <td class="taskOptions">{$sum['合计']['maolilv']}</td>
                                            <td class="taskOptions">{$sum['合计']['']}</td>
                                            <!--<if condition="rolemenu(array('Sale/plans_follow'))">-->
                                            <td class="taskOptions">
                                                <a href="javascript:;" onclick="art_show_msg('加班开发中...')" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></a>
                                            </td>
                                            <!--</if>-->
                                        </tr>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->

<include file="Index:footer2" />