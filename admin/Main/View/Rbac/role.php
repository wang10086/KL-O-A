<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {$_pagetitle_}
                        <small>{$_pagedesc_}</small>
                    </h1>
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
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right">
                                         <a href="{:U('Rbac/addrole')}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 新增</a>
                                         <!-- <a href="javascript:;" onclick="art_show_msg('请先修改没有人的角色')" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 新增</a> -->
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist">
                                    <tr role="row" class="orders" >
                                        <th>ID</th>
                                        <!--<th>标识</th>-->
                                        <th width="45%">名称</th>
                                        <th>级别</th>
                                        <th>职位</th>
                                        <th>状态</th>
                                        <th>操作</th>
                                    </tr>
   
                                    <foreach name="roles" item="row">
                                        <tr>
                                            <td>{$row.id}</td>
                                            <!--<td>{$row.name}</td>-->
                                            <td>{:tree_pad($row['level'])} {$row.role_name} <a class="pull-right" href="{:U('Rbac/addrole',array('pid'=>$row['id']))}"><i class="fa fa-plus"></i> 子部门</a>&nbsp; </td>
                                            <td>{$row.level}</td>
                                            <td><if condition="$row['isend']==1">是<else/>否</if></td>
                                            <td><if condition="$row['status']==1">启用<else/>停用</if></td>
                                            <td>
                                            <a href="{:U('Rbac/addrole',array('id'=>$row['id']))}">修改</a>&nbsp; | &nbsp; 
                                            <if condition="$row['isend']" >
                                            <a href="{:U('Rbac/priv',array('roleid'=>$row['id']))}">配置权限</a>&nbsp; | &nbsp; 
                                            </if>
                                            
                                            <if condition="$row['pid'] gt 0" >
                                            <a onClick="return confirm('将要删除[{$row.role_name}]和所有的下属部门和角色，不可恢复，确认要删除吗？');" href="{:U('Rbac/delrole',array('id'=>$row['id']))}">删除</a>
                                            <else/>
                                            <a href="javascript:;" alt="禁止删除" title="禁止删除">&nbsp; <i class="fa fa-lock"></i></a>
                                            </if>
                                            </td>
                                        </tr>
                                    </foreach>										
                                </table>
                                </div><!-- /.box-body -->
                                <div class="box-footer clearfix">
                                    <ul class="pagination pagination-sm no-margin pull-right">
                                        {$pages}
                                    </ul>
                                </div>
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                     </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->

<include file="Index:footer2" />
