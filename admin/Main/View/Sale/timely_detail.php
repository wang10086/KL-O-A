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

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"></h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <div class="btn-group" id="catfont">
                                        <foreach name="timely" item="v">
                                            <a href="{:U('Sale/public_timely_detail',array('year'=>$year,'month'=>$month,'tit'=>$v,'uid'=>$uid))}" class="btn <?php if($title==$v){ echo 'btn-info';}else{ echo 'btn-default';} ?>">{$v}</a>
                                        </foreach>
                                    </div>

                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th class="taskOptions" width="60">序号</th>
                                            <th class="taskOptions">团号</th>
                                            <th class="taskOptions">项目名称</th>
                                            <th class="taskOptions">销售</th>
                                            <th class="taskOptions">状态</th>
                                        </tr>
                                        <foreach name="lists" key="k" item="v">
                                            <tr>
                                                <td class="taskOptions">{$k+1}</td>
                                                <td class="taskOptions">{$v.group_id}</td>
                                                <td class="taskOptions" style="max-width: 150px;"><a href="{:U('Op/plans_follow',array('opid'=>$v['op_id']))}">{$v.project}</a></td>
                                                <td class="taskOptions">{$v.create_user_name}</td>
                                                <td class="taskOptions"><?php echo $v['is_ok']?'<span class="green">正常</span>':'<span class="red">超时</span>'; ?></td>
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