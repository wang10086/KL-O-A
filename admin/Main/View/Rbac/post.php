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
                                        <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',500,160);"><i class="fa fa-search"></i> 搜索</a>
                                         <!--<a href="{:U('Rbac/addpost')}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 新建岗位</a>-->
                                         <a href="javascript:;" onclick="art_show_msg('请优先编辑使用没有人员的岗位')" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 新建岗位</a>
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
                                        <if condition="rolemenu(array('Rbac/delpost'))">
                                        <th width="60" class="taskOptions">删除</th>
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
                                            <if condition="rolemenu(array('Rbac/delpost'))">
                                            <td class="taskOptions">
                                                <a href="javascript:;" onclick="ConfirmDel(`{:U('Rbac/delpost',array('id'=>$row['id']))}`,'请先在人员管理中确认该岗位无人员后再删除此岗位,确定删除此岗位吗?')"  title="删除"  class="btn btn-danger btn-smsm"><i class="fa fa-times"></i></a>
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
        <input type="hidden" name="a" value="post">

        <div class="form-group col-md-12"></div>
        <div class="form-group col-md-12">
            <input type="text" class="form-control" name="name" placeholder="岗位名称">
        </div>

        <div class="form-group col-md-12">
            <select name="department" class="form-control">
                <option value="">==请选择==</option>
                <foreach name="department" key="k" item="v">
                    <option value="{$k}">{$v}</option>
                </foreach>
            </select>
        </div>
    </form>
</div>

<include file="Index:footer2" />
