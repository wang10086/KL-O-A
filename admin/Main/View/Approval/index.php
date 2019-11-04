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
                                        <if condition="rolemenu(array('approval/upd_file'))">
                                        <a href="{:U('approval/upd_file')}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> 新增流转文件</a>
                                        </if>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" width="60" data="id">ID</th>
                                        <th class="sorting" width="" data="filename">文件名称</th>
                                        <th class="sorting" data="">上传日期</th>
                                        <th class="sorting" data="createUserName">上传人员</th>
                                        <th class="sorting" data="">附件信息</th>
                                        <th class="sorting" data="">状态</th>
                                        <if condition="rolemenu(array('Op/plans_info'))">
                                        <th class="taskOptions" width="120">
                                            编辑 | 详情 <if condition="rolemenu(array('Approval/file_delete'))">| 删除</if>
                                        </th>
                                        </if>
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td>{$row.id}</td>
                                        <td>{$row.}</td>
                                        <td>{$row.}</td>
                                        <td>{$row.}</td>
                                        <td>{$row.}</td>
                                        <td>{$row.}</td>
                                        <if condition="rolemenu(array('Approval/upd_file'))">
                                        <td class="taskOptions">
                                            <a href="{:U('Approval/Approval_Upload',array('id'=>$app['id']))}" title="编辑" class="btn btn-info btn-smsm" style="<?php if($app['userid']!==$_SESSION['userid']){echo 'display:none;';} ?>">
                                                <i class="fa fa-pencil"></i>
                                            </a> <?php if($app['userid']==$_SESSION['userid']){echo ' | ';} ?>
                                            <a href="{:U('Approval/Approval_Update',array('id'=>$app['id']))}" title="详情" class="btn btn-info btn-smsm">
                                                <i class="fa fa-bars"></i>
                                            </a>
                                            <if condition="rolemenu(array('Approval/file_delete'))">
                                                |  <a href="{:U('Approval/file_delete',array('id'=>$app['id']))}" title="删除" class="btn btn-warning btn-smsm">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </if>
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
