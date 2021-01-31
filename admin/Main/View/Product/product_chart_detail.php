<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {$pageTitle}
                        <small>{$_pagedesc_}</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Product/public_product_chart')}"><i class="fa fa-gift"></i> {$pageTitle}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right"></div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="taskOptions" width="100">项目编号</th>
                                        <th class="taskOptions">团号</th>
                                        <th class="taskOptions">项目名称</th>
                                        <th class="taskOptions">项目成本</th>
                                        <th class="taskOptions">项目类型</th>
                                        <th class="taskOptions">是否标准化</th>
                                    </tr>
                                    <foreach name="lists" item="row">
                                        <tr>
                                            <td class="taskOptions">{$row.op_id}</td>
                                            <td class="taskOptions">{$row.group_id}</td>
                                            <td class="taskOptions">{$row.project}</td>
                                            <td class="taskOptions">{$row.budget}</td>
                                            <td class="taskOptions">{$kinds[$row['kind']]}</td>
                                            <td class="taskOptions"><?php echo $row['standard']==1 ? "<span class='green'>标准化</span>" : '非标准化'; ?></td>
                                        </tr>
                                    </foreach>
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
