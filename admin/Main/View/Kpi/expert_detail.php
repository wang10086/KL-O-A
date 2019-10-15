<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>实施专家业绩贡献度</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">项目列表</h3>
                                    <div class="box-tools pull-right">
                                        <span class="green mr20">实施专家：{$username}</span>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="" width="80">编号</th>
                                        <th class="" >团号</th>
                                        <th class="">项目名称</th>
                                        <th class="taskOptions">销售</th>
                                        <th class="taskOptions">结算毛利</th>
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td>{$row.op_id}</td>
                                        <td>{$row.group_id}</td>
                                        <td><a href="{:U('Finance/settlement',array('opid'=>$row['op_id']))}" title="{$row.project}">{$row.project}</a></td>
                                        <td class="taskOptions">{$row.sale_user}</td>
                                        <td class="taskOptions">{$row.maoli}</td>
                                    </tr>
                                    </foreach>
                                    <tr class="black">
                                        <td colspan="2">合计: {$data.sum}</td>
                                        <td>协助销售毛利:  <?php echo $data['otherSum'].' * 40% = '.$data['other']; ?></td>
                                        <td colspan="2">本人销售毛利: {$data.self}</td>
                                    </tr>
                                </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                     </div>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->

<include file="Index:footer2" />