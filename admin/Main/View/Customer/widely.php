<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_pagetitle_}</h1>
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

                            <include file="Customer:widely_navigate" />

                            <div class="box box-warning mt20">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right">
                                        <a href="{:U('Customer/public_widely_add')}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> 新增活动计划</a>
                                    </div>
                                </div><!-- /.box-header -->

                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" data="">活动标题</th>
                                        <th class="sorting" data="">计划时间</th>
                                        <th class="sorting" data="">活动负责人</th>
                                        <th class="sorting" data="">活动类型</th>
                                        <th class="sorting" data="">活动费用(万元)</th>
                                        <th class="sorting" data="">活动方案</th>
                                        <th class="sorting" data="">状态</th>
                                        <th width="40" class="taskOptions">编辑</th>

                                        <if condition="rolemenu(array('Customer/delWidely'))">
                                        <th width="40" class="taskOptions">删除</th>
                                        </if>
                                    </tr>
                                    <foreach name="lists" item="row">
                                    <tr>
                                        <td><a href="{:U('Customer/public_widely_detail',array('id'=>$row['id']))}">{$row.title}</a></td>
                                        <td>{$row.in_time|date='Y-m-d',###}</td>
                                        <td>{$row.blame_name}</td>
                                        <td>{$process_data[$row['process_id']]}</td>
                                        <td>{$row['cost']/10000}万元</td>
                                        <td>{$row.}</td>
                                        <td>{$audit_status[$row['status']]}</td>
                                        <td class="taskOptions">
                                        <a href="{:U('Customer/public_widely_add',array('id'=>$row['id']))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                        </td>
                                        <if condition="rolemenu(array('Customer/delWidely'))">
                                        <td class="taskOptions">
                                        <button onClick="javascript:ConfirmDel(`{:U('Customer/delWidely',array('id'=>$row['id']))}`)" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
                                        </td>
                                        </if>
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


            <div id="searchtext">
                <form action="" method="get" id="searchform">
                <input type="hidden" name="m" value="Main">
                <input type="hidden" name="c" value="Customer">
                <input type="hidden" name="a" value="widely">

                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="title" placeholder="名称">
                </div>

                </form>
            </div>

<include file="Index:footer2" />


