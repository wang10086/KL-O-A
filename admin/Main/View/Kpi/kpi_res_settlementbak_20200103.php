<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_pagetitle_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Rbac/index')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
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
                                    <div class="box-tools pull-right">
                                    	 <!--<a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',500,160);"><i class="fa fa-search"></i> 搜索</a>-->
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th>团号</th>
                                        <th>项目名称</th>
                                        <th>模块名称</th>
                                        <th>结算毛利</th>
                                        <th>销售人员</th>
                                        <th>结算时间</th>
                                    </tr>
                                    <foreach name="list" item="row">
                                    <tr>
                                        <td>{$row.group_id}</td>
                                        <td>{$row.project}</td>
                                        <td>{$row.renshu}</td>
                                        <td>{$row.maoli}</td>
                                        <td>{$row.create_user_name}</td>
                                        <td>{$row.audit_time|date='Y-m-d',###}</td>
                                    </tr>
                                    </foreach>

                                    <tr class="black">
                                        <td>合计</td>
                                        <td></td>
                                        <td></td>
                                        <td>{$total}</td>
                                        <td></td>
                                        <td></td>
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
