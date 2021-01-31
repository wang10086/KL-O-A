<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        员工统计
                        <small></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Rbac/chart_personnel')}"><i class="fa fa-gift"></i> 员工统计</a></li>
                        <li class="active">详情</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">{$year}年{$month}月用户列表</h3>
                                    <if condition="rolemenu(array('Rbac/adduser'))">
                                    <div class="box-tools pull-right">
                                    	<a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',500,120);"><i class="fa fa-search"></i> 搜索</a>
                                    </div>
                                    </if>
                                </div><!-- /.box-header -->
                                <div class="box-body">
								<table class="table table-bordered dataTable fontmini" id="tablelist">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" width="80" data="a.id">ID</th>
                                        <th class="sorting" data="a.nickname">姓名</th>
                                        <th class="sorting" data="a.departmentid">部门</th>
                                        <th class="sorting" data="a.postid">岗位</th>
                                        <th class="sorting" data="a.entry_time">入职时间</th>
                                        <th class="sorting" data="a.status">状态</th>
                                        <th class="sorting" data="s.standard">工资信息</th>
                                    </tr>
                                    <foreach name="lists" item="row">
                                        <tr>
                                            <td>{$row.id}</td>
                                            <td>{$row.nickname}</td>
                                            <td><a title="{:get_role_name($row['roleid'])}{$row.group_role}">{$departments[$row['departmentid']]}</a></td>
                                            <td>{$posts[$row['postid']]}</td>
                                            <td><if condition="$row['entry_time']">{$row.entry_time|date='Y-m-d',###}</if></td>
                                            <td><?php if($row['status']==0){ echo '<span class="green">正常</span>';}else{ echo '<span class="red">停用</span>';} ?></td>
                                            <td>{$row.standard}</td>
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
                <input type="hidden" name="a" value="public_chart_personnel_detail">
                <input type="hidden" name="uids" value="{$uids}">
                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="key" placeholder="关键字">
                </div>

                <div class="form-group col-md-12">
                    <select class="form-control" name="departmentid">
                        <option value="0">所在部门</option>
                        <foreach name="departments" key="k" item="v">
                            <option value="{$k}">{$v}</option>
                        </foreach>
                    </select>
                </div>
                
                </form>
            </div>

<include file="Index:footer2" />
