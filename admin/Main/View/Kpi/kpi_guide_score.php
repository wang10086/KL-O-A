<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_action_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> KPI详情</a></li>
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
                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr>
                                            <th class="taskOptions">团号</th>
                                            <th class="taskOptions">项目名称</th>
                                            <th class="taskOptions">业务</th>
                                            <!--<th class="taskOptions">得分</th>-->
                                        </tr>
                                        <foreach name="lists" key="k" item="v">
                                            <tr>
                                                <td class="sorting">{$v['group_id']}</td>
                                                <td class="sorting"><a href="{:U('Inspect/score_info',array('opid'=>$v['op_id']))}">{$v['project']}</a></td>
                                                <td class="taskOptions">{$v['create_user_name']}</td>
                                                <!--<td class="taskOptions"><?php /*echo $v['average']?$v['average']:"<font color='#999999'>未评分</font>"; */?></td>-->
                                            </tr>
                                        </foreach>
                                        <tr class="black">
                                            <td>合计</td>
                                            <td>总项目数：{$num}</td>
                                            <td>总满意度：{$complete}</td>
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
