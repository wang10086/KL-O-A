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

                            <include file="Cour:cour_navigate" />

                            <div class="box box-warning mt20">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right">
                                        <if condition="rolemenu(array('Cour/add_cour_record'))">
                                        <a href="{:U('Cour/add_cour_record')}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> 新增培训记录</a>
                                        </if>
                                    </div>
                                </div><!-- /.box-header -->

                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" data="">培训标题</th>
                                        <th class="sorting" data="">完成时间</th>
                                        <th class="sorting" data="">培训负责人</th>
                                        <th class="sorting" data="">培训类型</th>
                                        <if condition="rolemenu(array('Cour/add_cour_record'))">
                                        <th width="40" class="taskOptions">编辑</th>
                                        </if>

                                        <if condition="rolemenu(array('Cour/del_cour_record'))">
                                        <th width="40" class="taskOptions">删除</th>
                                        </if>
                                    </tr>
                                    <foreach name="lists" item="row">
                                    <tr>
                                        <td>{$row.}</td>
                                        <td>{$row.}</td>
                                        <td>{$row.}</td>
                                        <td>{$row.}</td>
                                        <td>{$row.}</td>
                                        <td>{$row.}</td>
                                        <td>{$row.}</td>
                                        <if condition="rolemenu(array('Cour/add_cour_record'))">
                                        <td class="taskOptions">
                                        <a href="{:U('Cour/add_cour_record',array('id'=>$row['id']))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                        </td>
                                        </if>
                                        <if condition="rolemenu(array('Cour/del_cour_record'))">
                                        <td class="taskOptions">
                                        <button onClick="javascript:ConfirmDel(`{:U('Cour/del_cour_record',array('id'=>$row['id']))}`)" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
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
                <input type="hidden" name="c" value="Cour">
                <input type="hidden" name="a" value="courRecord">

                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="title" placeholder="培训标题">
                </div>
                </form>
            </div>

<include file="Index:footer2" />


