<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_action_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i>绩效管理</a></li>
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
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"><span class="green"><if condition="$data['uname']" >教务：{$data['uname']}</if></span> &nbsp;&nbsp;</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="callout callout-danger">
                                        <h4>提示！</h4>
                                        <p>1、如果有未评分项目,请及时联系该项目业务人员为您评分,以免影响您的KPI；</p>
                                    </div>
                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr class="orders">
                                            <th class="taskOptions">团号</th>
                                            <th class="taskOptions">项目名称</th>
                                            <th class="taskOptions">业务</th>
                                            <th class="taskOptions">得分</th>
                                        </tr>
                                        <foreach name="lists" key="k" item="v">
                                            <tr>
                                                <td class="sorting">{$v['group_id']}</td>
                                                <td class="sorting"><a href="{:U('Op/evaluate',array('opid'=>$v['op_id']))}">{$v['project']}</a></td>
                                                <td class="taskOptions">{$v['sale_user']}</td>
                                                <td class="taskOptions"><?php echo $v['average']?$v['average']:"<span class='red'>未评分</span>"; ?></td>
                                            </tr>
                                        </foreach>
                                        <tr class="black">
                                            <td>总项目数：{$data.sum_num}</td>
                                            <td>已评分项目数：{$data.score_num}</td>
                                            <td>已评分满意度：{$data.score_average}</td>
                                            <td>总满意度：{$data.sum_average}</td>
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
