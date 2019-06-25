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
                                <?php if($prveyear>2017){ ?>
                                    <a href="{:U('Sale/timely',array('year'=>$prveyear,'month'=>'01','pin'=>$pin))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                <?php } ?>
                                <?php
                                    for($i=1;$i<13;$i++){
                                        $par            = array();
                                        $par['year']    = $year;
                                        $par['month']   = str_pad($i,2,"0",STR_PAD_LEFT);
                                        $par['pin']     = $pin;
                                        if($month==$i){
                                            echo '<a href="'.U('Sale/timely',$par).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'月</a>';
                                        }else{
                                            echo '<a href="'.U('Sale/timely',$par).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                                        }
                                    }
                                ?>
                                <?php if($year<date('Y')){ ?>
                                    <a href="{:U('Sale/timely',array('year'=>$nextyear,'month'=>'01','pin'=>$pin))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                <?php } ?>
                            </div>

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right">
                                        <!--<a href="javascript:;" onclick="edit_timely()" class="btn btn-info btn-sm">考核指标管理</a>-->
                                        <a href="{:U('Sale/timely_list')}" class="btn btn-info btn-sm">考核指标管理</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <include file="timely_nave" />

                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th class="taskOptions" width="60">序号</th>
                                            <th class="taskOptions">工作项目</th>
                                            <th class="taskOptions">时限</th>
                                            <th class="taskOptions">工作项目数</th>
                                            <th class="taskOptions">及时数</th>
                                            <th class="taskOptions">及时率</th>
                                            <if condition="rolemenu(array('Sale/gross_op_list'))">
                                            <th width="80" class="taskOptions">详情</th>
                                            </if>
                                        </tr>
                                        <foreach name="lists" key="k" item="v">
                                            <tr>
                                                <td class="taskOptions"></td>
                                                <td class="taskOptions"></td>
                                                <td class="taskOptions"></td>
                                                <td class="taskOptions"></td>
                                                <td class="taskOptions"></td>
                                                <td class="taskOptions"></td>
                                                <if condition="rolemenu(array('Sale/gross_op_list'))">
                                                <td class="taskOptions">
                                                    <a href="{:U('Sale/gross_op_list',array('opids'=>$v['opids']))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></a>
                                                </td>
                                                </if>
                                            </tr>
                                        </foreach>
                                        <tr class="black">
                                            <td class="taskOptions">合计</td>
                                            <td class="taskOptions"></td>
                                            <td class="taskOptions"></td>
                                            <td class="taskOptions"></td>
                                            <td class="taskOptions"></td>
                                            <td class="taskOptions"></td>
                                            <td class="taskOptions"></td>
                                        </tr>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->

<include file="Index:footer2" />