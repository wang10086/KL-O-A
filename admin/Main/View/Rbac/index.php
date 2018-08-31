<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        组织结构和权限
                        <small>设置系统用户、部门和权限等</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Rbac/index')}"><i class="fa fa-gift"></i> 组织结构和权限</a></li>
                        <li class="active">用户列表</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">用户列表</h3>
                                    <if condition="rolemenu(array('Rbac/adduser'))">
                                    <div class="box-tools pull-right">
                                    	<a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',600,160);"><i class="fa fa-search"></i> 搜索</a>
                                        <a href="{:U('Rbac/adduser')}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 新增用户</a>
                                    </div>
                                    </if>
                                </div><!-- /.box-header -->
                                <div class="box-body">
								<table class="table table-bordered dataTable fontmini" id="tablelist">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" data="id">ID</th>
                                        <th class="sorting" data="username">登录账号</th>
                                        <th class="sorting" data="nickname">姓名</th>
                                        <th class="sorting" data="group_role">部门/角色</th>
                                        <th class="sorting" data="postid">岗位</th>
                                        <th class="sorting" data="entry_time">入职时间</th>
                                        <th class="sorting" data="formal">是否转正</th>
                                        <th class="sorting" data="update_time">最近登陆时间</th>
                                        <th class="sorting" data="status">状态</th>
                                        <if condition="rolemenu(array('Rbac/password'))">
                                        <th width="60" class="taskOptions">密码</th>
                                        </if>
                                        <if condition="rolemenu(array('Rbac/adduser'))">
                                        <th width="60" class="taskOptions">编辑</th>
                                        </if>
                                        <if condition="rolemenu(array('Rbac/deluser'))">
                                        <th width="60" class="taskOptions">删除</th>
                                        </if>
                                    </tr>
                                    <foreach name="users" item="row">
                                        <tr>
                                            <td>{$row.id}</td>
                                            <td>{$row.username}</td>
                                            <td>{$row.nickname}</td>
                                            <td><a title="{:get_role_name($row['roleid'])}{$row.group_role}">{$roles[$row['roleid']]}</a></td>
                                            <td>{$posts[$row['postid']]}</td>
                                            <td><if condition="$row['entry_time']">{$row.entry_time|date='Y-m-d',###}</if></td>
                                            <td><?php if($row['formal']==1){ echo '<span class="green">正式</span>';}else if($row['formal']==0){ echo '<span class="red">试用</span>';}else if($row['formal']==3){ echo '<span class="red">劳务</span>';}else if($row['formal']==4){ echo '<span class="red">,实习</span>';} ?></td>
                                            <td><if condition="$row['update_time']">{$row.update_time|date='Y-m-d H:i:s',###}</if></td>
                                            <td><?php if($row['status']==0){ echo '<span class="green">正常</span>';}else{ echo '<span class="red">停用</span>';} ?></td>
                                            <if condition="rolemenu(array('Rbac/password'))">
                                            <td class="taskOptions">
                                            <button onClick="javascript:window.location.href='{:U('Rbac/password',array('id'=>$row['id']))}';" title="修改密码" class="btn btn-success btn-smsm"><i class="fa fa-lock"></i></button>
                                            </td>
                                            </if>
                                            <if condition="rolemenu(array('Rbac/adduser'))">
                                            <td class="taskOptions">
                                            <button onClick="javascript:window.location.href='{:U('Rbac/adduser',array('id'=>$row['id']))}';" title="修改资料" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></button>
                                            </td>
                                            </if>
                                            <if condition="rolemenu(array('Rbac/deluser'))">
                                            <td class="taskOptions">
                                            <?php  if($row['username']!=C('RBAC_SUPER_ADMIN')){ ?>
                                            <button onClick="javascript:ConfirmDel('{:U('Rbac/deluser',array('id'=>$row['id']))}');" title="删除用户" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
                                            <?php } ?>
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
                <input type="hidden" name="c" value="Rbac">
                <input type="hidden" name="a" value="index">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="key" placeholder="关键字">
                </div>

                <div class="form-group col-md-6">
                    <select class="form-control" name="departmentid">
                        <option value="0">所在部门</option>
                        <foreach name="department" key="k" item="v">
                            <option value="{$k}">{$v}</option>
                        </foreach>
                    </select>
                </div>
                
                <div class="form-group col-md-6">
                    <select class="form-control" name="role">
                        <option value="0">所属角色</option>
                        <foreach name="roles" key="k" item="v">
                        <option value="{$k}">{$v}</option>
                        </foreach>
                    </select>
                </div>
                
                <div class="form-group col-md-6">
                    <select class="form-control" name="post">
                        <option value="0">所属职位</option>
                        <foreach name="posts" key="k" item="v">
                        <option value="{$k}">{$v}</option>
                        </foreach>
                    </select>
                </div>
                
                
                </form>
            </div>

<include file="Index:footer2" />
