<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_action_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> 数据统计</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">

                            <div class="btn-group" id="catfont" style="padding-bottom:20px;">
                                <?php if($prveyear>2019){ ?>
                                    <a href="{:U('Finance/public_timely',array('year'=>$prveyear,'quarter'=>'1'))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                <?php } ?>
                                <?php
                                    for($i=1;$i<5;$i++){
                                        $par            = array();
                                        $par['year']    = $year;
                                        $par['quarter'] = $i;
                                        if($quarter==$i){
                                            echo '<a href="'.U('Finance/public_timely',$par).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'季度</a>';
                                        }else{
                                            echo '<a href="'.U('Finance/public_timely',$par).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'季度</a>';
                                        }
                                    }
                                ?>
                                <?php if($year<date('Y')){ ?>
                                    <a href="{:U('Finance/public_timely',array('year'=>$nextyear,'quarter'=>'1'))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                <?php } ?>
                            </div>

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right">
                                        <if condition="rolemenu(array('Finance/timely_list'))">
                                            <a href="{:U('Finance/timely_list')}" class="btn btn-info btn-sm">考核指标管理</a>
                                        </if>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <!--<include file="timely_nave" />-->

                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th class="taskOptions" width="60">序号</th>
                                            <th class="taskOptions">工作项目</th>
                                            <th class="taskOptions">内容及时限</th>
                                            <th class="taskOptions">工作项目数</th>
                                            <th class="taskOptions">及时数</th>
                                            <th class="taskOptions">及时率</th>
                                            <th width="80" class="taskOptions">详情</th>
                                        </tr>
                                        <foreach name="lists" key="k" item="v">
                                            <tr>
                                                <td class="taskOptions">{$k+1}</td>
                                                <td class="taskOptions">{$v.title}</td>
                                                <td class="taskOptions" style="max-width: 150px;">{$v.content}</td>
                                                <td class="taskOptions">{$v.sum_num}</td>
                                                <td class="taskOptions">{$v.ok_num}</td>
                                                <td class="taskOptions">{$v.average}</td>
                                                <td class="taskOptions">
                                                    <?php if ($v['title'] == '报账及时性'){ ?>
                                                    <a href="{:U('Finance/public_reimbursement_detail',array('tit'=>$v['title'],'year'=>$year,'month'=>$month))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></a>
                                                    <?php }else{ ?>
                                                    <a href="{:U('Finance/public_timely_detail',array('tit'=>$v['title'],'year'=>$year,'month'=>$month))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        </foreach>
                                        <tr class="black">
                                            <td class="taskOptions" colspan="3">合计</td>
                                            <td class="taskOptions">{$sum.sum_num}</td>
                                            <td class="taskOptions">{$sum.ok_num}</td>
                                            <td class="taskOptions">{$sum.average}</td>
                                            <td class="taskOptions">
                                                <!--<a href="{:U('Finance/public_timely_detail',array('tit'=>'合计','year'=>$year,'month'=>$month))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></a>-->
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
