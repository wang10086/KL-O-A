<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        岗位管理
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li class="active">岗位管理</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">岗位管理</h3>
                                    <if condition="rolemenu(array('Rbac/addpost'))">
                                    <div class="box-tools pull-right">
                                         <a href="{:U('Rbac/addpost')}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 新建岗位</a>
                                    </div>
                                    </if>
                                </div><!-- /.box-header -->
                                <div class="box-body">
								<table class="table table-bordered dataTable fontmini">
                                    <tr role="row">
                                        <th width="60">ID</th>
                                        <th>岗位名称</th>
                                        <th>部门名称</th>
                                        <if condition="rolemenu(array('Rbac/addpost'))">
                                        <th width="60" class="taskOptions">编辑</th>
                                        </if>
                                        <if condition="rolemenu(array('Rbac/rolequto'))">
                                        <th width="60" class="taskOptions">考核</th>
                                        </if>
                                    </tr>
                                    <foreach name="datalist" item="row">
                                        <tr>
                                            <td>{$row.id}</td>
                                            <td>{$row.post_name}</td>
                                            <td>{$department.$row[departmentid]}</td>
                                            <if condition="rolemenu(array('Rbac/addpost'))">
                                            <td class="taskOptions">
                                            <a href="{:U('Rbac/addpost',array('id'=>$row['id']))}" title="修改" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                            </td>
                                            </if>
                                            
                                            <if condition="rolemenu(array('Rbac/rolequto'))">
                                            <td class="taskOptions">
                                            <a href="{:U('Rbac/rolequto',array('postid'=>$row['id']))}" title="KPI考核指标"  class="btn btn-success btn-smsm"><i class="fa fa-check"></i></a>
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

<include file="Index:footer2" />
