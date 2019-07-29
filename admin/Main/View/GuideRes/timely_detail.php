<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$pagetitle}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> 数据统计</a></li>
                        <li class="active">{$pagetitle}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"></h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th class="taskOptions" width="60">序号</th>
                                            <th class="taskOptions">团号</th>
                                            <th class="taskOptions">项目名称</th>
                                            <?php if ($type==1){ ?>
                                                <th class="taskOptions">结束时间</th>
                                                <th class="taskOptions">核实时间</th>
                                                <th class="taskOptions">核实人员</th>
                                            <?php } ?>
                                            <th class="taskOptions">状态</th>
                                        </tr>
                                        <foreach name="lists" key="k" item="v">
                                            <tr>
                                                <td class="taskOptions">{$k+1}</td>
                                                <td class="taskOptions">{$v.group_id}</td>
                                                <td class="taskOptions" style="max-width: 150px;"><a href="{:U('Op/plans_follow',array('opid'=>$v['op_id']))}">{$v.project}</a></td>
                                                <?php if ($type==1){ ?>
                                                    <td class="taskOptions">{$v.in_day|date='Y-m-d',###}</td>
                                                    <td class="taskOptions"><?php echo $v['heshi_time'] ? date('Y-m-d',$v['heshi_time']) : "<font color='#999'>未核实</font>" ?></td>
                                                    <td class="taskOptipons">{$v['nickname']}</td>
                                                <?php } ?>
                                                <td class="taskOptions">{$v.stau}</td>
                                            </tr>
                                        </foreach>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->

<include file="Index:footer2" />