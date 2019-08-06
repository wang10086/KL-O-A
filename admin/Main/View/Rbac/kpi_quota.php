<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        KPI指标管理
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li class="active">KPI指标管理</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">KPI指标管理</h3>
                                    <if condition="rolemenu(array('Rbac/add_quota'))">
                                    <div class="box-tools pull-right">
                                        <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',500,160);"><i class="fa fa-search"></i> 搜索</a>
                                         <a href="{:U('Rbac/add_quota')}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 发布指标</a>
                                    </div>
                                    </if>
                                </div><!-- /.box-header -->
                                <div class="box-body">
								<table class="table table-bordered dataTable fontmini">
                                    <tr role="row">
                                        <th width="60">ID</th>
                                        <th>指标名称</th>
                                        <th>考核周期</th>
                                        <th>权重</th>
                                        <!--<th>指标内容</th>-->
                                        <th width="140">更新时间</th>
                                        <if condition="rolemenu(array('Rbac/add_quota'))">
                                        <th width="60" class="taskOptions">编辑</th>
                                        </if>
                                        <if condition="rolemenu(array('Rbac/del_quota'))">
                                        <th width="60" class="taskOptions">删除</th>
                                        </if>
                                    </tr>
                                    <foreach name="datalist" item="row">
                                        <tr>
                                            <td>{$row.id}</td>
                                            <td>{$row.quota_title}</td>
                                            <td>{$row.cycle}</td>
                                            <td>{$row.weight}</td>
                                            <!--<td>{$row.quota_content}</td>-->
                                            <td>{$row.create_time|date='Y-m-d H:i:s',###}</td>
                                            
                                            <if condition="rolemenu(array('Rbac/add_quota'))">
                                            <td class="taskOptions">
                                            <button onClick="javascript:window.location.href='{:U('Rbac/add_quota',array('id'=>$row['id']))}';" title="修改" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></button>
                                            </td>
                                            </if>
                                            <if condition="rolemenu(array('Rbac/del_quota'))">
                                            <td class="taskOptions">
                                            <button onClick="javascript:ConfirmDel('{:U('Rbac/del_quota',array('id'=>$row['id']))}');" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
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
        <input type="hidden" name="a" value="kpi_quota">

        <div class="form-group col-md-12"></div>
        <div class="form-group col-md-12">
            <input type="text" class="form-control" name="tit" placeholder="请输入指标名称关键字">
        </div>
        <div class="form-group col-md-12">
            <input type="text" class="form-control" name="con" placeholder="请输入指标内容关键字">
        </div>
    </form>
</div>

<include file="Index:footer2" />
