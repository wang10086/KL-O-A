<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_action_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> 顾客满意度</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">

                            <div class="btn-group" id="catfont" style="padding-bottom:20px;">
                                <?php if($prveyear>2017){ ?>
                                    <a href="{:U('Inspect/unqualify',array('year'=>$prveyear,'month'=>'01'))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                <?php } ?>
                                <?php
                                    for($i=1;$i<13;$i++){
                                        $par            = array();
                                        $par['year']    = $year;
                                        $par['month']   = str_pad($i,2,"0",STR_PAD_LEFT);
                                        if($month==$i){
                                            echo '<a href="'.U('Inspect/unqualify',$par).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'月</a>';
                                        }else{
                                            echo '<a href="'.U('Inspect/unqualify',$par).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                                        }
                                    }
                                ?>
                                <?php if($year<date('Y')){ ?>
                                    <a href="{:U('Inspect/unqualify',array('year'=>$nextyear,'month'=>'01'))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                <?php } ?>
                            </div>

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right">
                                        <if condition="rolemenu(array('Inspect/unqualify_list'))">
                                            <a href="{:U('Inspect/unqualify_list')}" class="btn btn-info btn-sm">考核指标管理</a>
                                        </if>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <div class="btn-group" id="catfont">
                                        <a href="{:U('Inspect/unqualify',array('year'=>$year,'month'=>$month))}" class="btn <?php if(ACTION_NAME=='unqualify'){ echo 'btn-info';}else{ echo 'btn-default';} ?>">公司</a>
                                        <a href="{:U('Inspect/unqualify',array('year'=>$year,'month'=>$month))}" class="btn <?php if(ACTION_NAME=='unqualify1'){ echo 'btn-info';}else{ echo 'btn-default';} ?>">员工</a>
                                    </div>

                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th class="taskOptions" width="60">序号</th>
                                            <th class="taskOptions">工作项目</th>
                                            <th class="taskOptions">内容及时限</th>
                                            <th class="taskOptions">不合格数</th>
                                            <th class="taskOptions">处理数</th>
                                            <th class="taskOptions">处理率</th>
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
                                                    <!--<a href="{:U('Sale/public_timely_detail',array('tit'=>$v['title'],'year'=>$year,'month'=>$month))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></a>-->
                                                    <a href="javascript:;" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></a>
                                                </td>
                                            </tr>
                                        </foreach>
                                        <tr class="black">
                                            <td class="taskOptions" colspan="3">合计</td>
                                            <td class="taskOptions">{$sum.sum_num}</td>
                                            <td class="taskOptions">{$sum.ok_num}</td>
                                            <td class="taskOptions">{$sum.average}</td>
                                            <td class="taskOptions">
                                                <!--<a href="{:U('Sale/public_timely_detail',array('tit'=>'合计','year'=>$year,'month'=>$month))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></a>-->
                                                <a href="javascript:;" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></a>
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