<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_pagetitle_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Approval/index')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',500,120);"><i class="fa fa-search"></i> 搜索</a>
                                        <if condition="rolemenu(array('approval/file_upload'))">
                                        <a href="{:U('approval/file_upload')}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> 新增流转文件</a>
                                        </if>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" width="40" data="id">ID</th>
                                        <th class="sorting" width="" data="file_name">文件名称</th>
                                        <th class="sorting" width="150" data="create_time">上传日期</th>
                                        <th class="sorting" width="80" data="create_user">上传人员</th>
                                        <th class="sorting" width="150" data="status">状态</th>
                                        <if condition="rolemenu(array('Approval/file_detail'))">
                                            <th class="taskOptions" width="70">详情</th>
                                        </if>

                                        <if condition="rolemenu(array('Approval/file_upload'))">
                                            <th class="taskOptions" width="70">编辑</th>
                                        </if>

                                        <if condition="rolemenu(array('Approval/file_del'))">
                                            <th class="taskOptions" width="70">删除</th>
                                        </if>

                                    </tr>
                                    <foreach name="list" item="row">
                                    <tr>
                                        <td class="taskOptions">{$row.id}</td>
                                        <td>{$row.file_name}</td>
                                        <td>{$row.create_time|date="Y-m-d H:i",###}</td>
                                        <td>{$row.create_user_name}</td>
                                        <td>{$file_status[$row['status']]}</td>
                                        <if condition="rolemenu(array('Approval/file_detail'))">
                                            <td class="taskOptions">
                                                <a href="{:U('Approval/file_detail',array('id'=>$row['id']))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></a>
                                            </td>
                                        </if>

                                        <if condition="rolemenu(array('Approval/file_upload'))">
                                            <td class="taskOptions">
                                                <?php if ($row['status'] == 0){ ?>
                                                    <a href="{:U('Approval/file_upload',array('id'=>$row['id']))}" title="编辑" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                                <?php }elseif($row['status'] == 3){ ?>
                                                    <a href="{:U('Approval/file_re_upload',array('id'=>$row['id']))}" title="编辑" class="btn btn-primary btn-smsm"><i class="fa fa-pencil"></i></a>
                                                <?php } ?>
                                            </td>
                                        </if>

                                        <if condition="rolemenu(array('Approval/file_del'))">
                                            <td class="taskOptions">
                                                <!--<a href="{:U('Approval/file_del',array('id'=>$row['id']))}" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></a>-->
                                                <a href="javascript:;" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></a>
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
                <input type="hidden" name="c" value="Approval">
                <input type="hidden" name="a" value="index">

                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="title" placeholder="文件名称">
                </div>

                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="uname" placeholder="上传人员">
                </div>
                
                </form>
            </div>

<include file="Index:footer2" />
