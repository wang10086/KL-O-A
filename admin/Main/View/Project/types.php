<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {$_pagetitle_}
                        <small>课程信息.学科领域</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Project/index')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">学科分类</h3>
                                    <div class="box-tools pull-right">
                                        <if condition="rolemenu(array('Project/types_add'))">
                                        <a href="javascript:;" onClick="javascript:{:open_type()}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 录入新分类</a>
                                        </if>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <div class="btn-group" id="catfont">
                                        <a href="{:U('Project/lession',array('pin'=>0))}" class="btn <?php if($pin==0){ echo 'btn-info';}else{ echo 'btn-default';} ?>">课程信息</a>
                                        <a href="{:U('Project/fields',array('pin'=>1))}" class="btn <?php if($pin==1){ echo 'btn-info';}else{ echo 'btn-default';} ?>">学科领域</a>
                                        <a href="{:U('Project/types',array('pin'=>2))}" class="btn <?php if($pin==2){ echo 'btn-info';}else{ echo 'btn-default';} ?>">学科分类</a>
                                    </div>

                                <table class="table table-bordered dataTable fontmini" id="tablelist">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" data="id">ID</th>
                                        <!--<th class="sorting" data="name">课程名称</th>-->
                                        <th class="sorting" data="kind">项目类型</th>
                                        <th class="sorting" data="fname">学科领域</th>
                                        <th class="sorting" data="tname">学科分类</th>

                                        <if condition="rolemenu(array('Project/types_add'))">
                                        <th width="60" class="taskOptions">编辑</th>
                                        </if>
                                        <if condition="rolemenu(array('Project/types_del'))">
                                        <th width="60" class="taskOptions">删除</th>
                                        </if>
                                    </tr>
                                    <foreach name="lists" item="row">
                                        <tr>
                                            <td>{$row.id}</td>
                                            <!--<td><a href="{:U('Project/view', array('id'=>$row['id']))}">{$row.name}</a></td>-->
                                            <!--<td>{:get_prj_kind_name($row[kind])}</td>-->
                                            <td>{$row[kind]}</td>
                                            <td>{$row.fname}</td>
                                            <td>{$row.tname}</td>

                                            <if condition="rolemenu(array('Project/types_add'))">
                                            <td class="taskOptions">
                                                <a href="javascript:;" onClick="javascript:{:open_type($row['id'])}"><button title="修改" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></button></a>
                                            </td>
                                            </if>
                                            <if condition="rolemenu(array('Project/types_del'))">
                                            <td class="taskOptions">
                                            <button onClick="javascript:ConfirmDel('{:U('Project/types_del',array('id'=>$row['id']))}');" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
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
