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
                                            <!--<th class="taskOptions">计调人员</th>-->
                                            <th class="taskOptions">累计操作收入</th>
                                            <th class="taskOptions">最低毛利额</th>
                                            <th class="taskOptions">累计操作毛利</th>
                                            <th class="taskOptions">累计操作毛利率</th>
                                            <th class="taskOptions">毛利率完成率</th>
                                            <th width="80" class="taskOptions">详情</th>
                                            <!--<if condition="rolemenu(array('Sale/plans_info'))">
                                                <th width="80" class="taskOptions">详情</th>
                                            </if>-->
                                        </tr>

                                        <tr>
                                            <!--<td></td>-->
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <!--<if condition="rolemenu(array('Sale/plans_follow'))">-->
                                                <td class="taskOptions">
                                                    <a href="javascript:;" onclick="art_show_msg('加班开发中...')" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
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
