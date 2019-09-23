<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {$pagetitle}
                        <small>{$_action_}</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Rbac/chart_personnel')}"><i class="fa fa-gift"></i> {$pagetitle}</a></li>
                        <li class="active">{$_action_}</li>
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
                                    	<a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',400,120);"><i class="fa fa-search"></i> 搜索</a>
                                    </div>
                                    </if>
                                </div><!-- /.box-header -->
                                <div class="box-body">
								<table class="table table-bordered dataTable fontmini" id="tablelist">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" data="id" width="80">ID</th>
                                        <th class="sorting" data="nickname">姓名</th>
                                        <if condition="rolemenu(array('Rbac/adduser'))">
                                            <th class="taskOptions" width="80">详情</th>
                                        </if>
                                    </tr>
                                    <foreach name="lists" item="row">
                                        <tr>
                                            <td>{$row.id}</td>
                                            <td>{$row.nickname}</td>
                                            <if condition="rolemenu(array('Rbac/adduser'))">
                                                <td class="taskOptions">
                                                    <!--<button onClick="javascript:window.location.href='{:U('Rbac/adduser',array('id'=>$row['id']))}';" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></button>-->
                                                    <a href="javascript:;" onclick="art_show_msg('加班开发中...',3)" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></a>
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
                <input type="hidden" name="a" value="chart_personnel">
                <div class="form-group col-md-12"></div>
                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="key" placeholder="人员名称关键字">
                </div>
                </form>
            </div>

<include file="Index:footer2" />
