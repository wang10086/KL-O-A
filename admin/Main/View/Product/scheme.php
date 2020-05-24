<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>项目方案管理</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Product/line')}"><i class="fa fa-gift"></i> {$_action_}</a></li>

                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">

                            <include file="Product:pro_navigate" />

                            <div class="box box-warning mt20">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right">
                                    	<a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',600,160);"><i class="fa fa-search"></i> 搜索</a>
                                        <if condition="rolemenu(array('Product/add_scheme'))">
                                        <a href="{:U('Product/add_scheme')}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> 新增方案</a>
                                        </if>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <!--<div class="btn-group" id="catfont">
                                    <button onClick="javascript:window.location.href='{:U('Product/line',array('status'=>'-1'))}';" class="btn <?php /*if($status=='-1'){ echo 'btn-info';}else{ echo 'btn-default';} */?>">所有的</button>
                                    <button onClick="javascript:window.location.href='{:U('Product/line',array('status'=>0))}';" class="btn <?php /*if($status==0){ echo 'btn-info';}else{ echo 'btn-default';} */?>">未审批</button>
                                    <button onClick="javascript:window.location.href='{:U('Product/line',array('status'=>1))}';" class="btn <?php /*if($status==1){ echo 'btn-info';}else{ echo 'btn-default';} */?>">已通过</button>
                                    <button onClick="javascript:window.location.href='{:U('Product/line',array('status'=>2))}';" class="btn <?php /*if($status==2){ echo 'btn-info';}else{ echo 'btn-default';} */?>">未通过</button>
                                </div>-->
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" data="id">ID</th>
                                        <th class="sorting" data="project">项目名称</th>
                                        <th class="sorting" data="">上传人员</th>
                                        <th class="sorting" data="">业务</th>
                                        <th class="sorting" data="">审核状态</th>
                                        <if condition="rolemenu(array('Product/add_scheme'))">
                                        <th width="50" class="taskOptions">编辑</th>
                                        </if>
                                        <if condition="rolemenu(array('Product/del_scheme'))">
                                        <th width="50" class="taskOptions">删除</th>
                                        </if>
                                    </tr>
                                    <foreach name="lists" item="row">
                                        <tr>
                                            <td>{$row.id}</td>
                                            <td><a href="{:U('Product/public_view_scheme', array('id'=>$row['id']))}">{$row.project}</a></td>
                                            <td>{$row.create_user_name}</td>
                                            <td>{$row.audit_user_name}</td>
                                            <td>{$audit_status[$row['audit_status']]}</td>

                                            <if condition="rolemenu(array('Product/add_scheme'))">
                                            <td class="taskOptions">
                                            <button onClick="javascript:window.location.href='{:U('Product/add_scheme',array('id'=>$row['id']))}';" title="修改" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></button>
                                            </td>
                                            </if>
                                            <if condition="rolemenu(array('Product/del_scheme'))">
                                            <td class="taskOptions">
                                            <button onClick="javascript:ConfirmDel('{:U('Product/del_scheme',array('id'=>$row['id']))}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
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
                <input type="hidden" name="c" value="Product">
                <input type="hidden" name="a" value="line">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="key" placeholder="关键字">
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="mdd" placeholder="目的地">
                </div>
                <div class="form-group col-md-6">
                    <select class="form-control" name="kind">
                        <option value="-1">类型</option>
                        <foreach name="kindlist" item="v">
                            <option value="{$v.id}">{$v.name}</option>
                        </foreach>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <select  class="form-control"  name="status">
                        <option value="-1">状态</option>
                        <option value="0">未审批</option>
                        <option value="1">通过审批</option>
                        <option value="2">未通过审批</option>
                    </select>
                </div>
                </form>
            </div>
<include file="Index:footer2" />
