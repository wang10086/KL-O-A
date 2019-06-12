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
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"><span class="green"><if condition="$lists[0]['jd']" >计调：{$lists[0]['jd']}</if></span> &nbsp;&nbsp;</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th class="taskOptions">业务类型</th>
                                            <th class="taskOptions">项目数</th>
                                            <th class="taskOptions">累计结算收入</th>
                                            <th class="taskOptions">最低毛利额</th>
                                            <th class="taskOptions">累计操作毛利</th>
                                            <th class="taskOptions">累计操作毛利率</th>
                                            <th class="taskOptions">毛利率完成率</th>
                                            <if condition="rolemenu(array('Sale/gross_op_list'))">
                                            <th width="80" class="taskOptions">详情</th>
                                            </if>
                                        </tr>
                                        <foreach name="lists" key="k" item="v">
                                            <tr <?php if (in_array($v['kind'],array('合计','公司合计'))) echo 'class="black"'; ?>>
                                                <td class="taskOptions">{$v['kind']}</td>
                                                <td class="taskOptions">{$v['num']}</td>
                                                <td class="taskOptions">{$v['shouru']}</td>
                                                <td class="taskOptions">{$v['low_gross']}</td>
                                                <td class="taskOptions">{$v['maoli']}</td>
                                                <td class="taskOptions">{$v['maolilv']}</td>
                                                <td class="taskOptions">{$v['rate']}</td>
                                                <if condition="rolemenu(array('Sale/gross_op_list'))">
                                                <td class="taskOptions">
                                                    <a href="{:U('Sale/gross_op_list',array('opids'=>$v['opids']))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></a>
                                                </td>
                                                </if>
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
