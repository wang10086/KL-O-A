<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>项目比价</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">项目比价记录</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',800,160);"><i class="fa fa-search"></i> 搜索</a>
                                         <a href="{:U('Op/relprice',array('opid'=>$opid,'type'=>$type))}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 创建比价</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
                               
                                
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" width="40" data="id">编号</th>
                                        <th class="sorting" data="op_id">项目编号</th>
                                        <th class="sorting" data="business_name">业务名称</th>
                                        <th class="sorting" data="type">类型</th>
                                        <th class="sorting" data="op_user_name">计调</th>
                                        <th class="sorting" data="create_time">发布时间</th>
                                        <!--<th class="sorting" data="status">状态</th>-->
                                        <if condition="rolemenu(array('Op/relprice'))">
                                        <th width="40" class="taskOptions">编辑</th>
                                        </if>
                                        <if condition="rolemenu(array('Op/delrel'))">
                                        <th width="40" class="taskOptions">删除</th>
                                        </if> 
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td>{$row.id}</td>
                                        <td><a href="{:U('Op/plans_follow',array('opid'=>$row['op_id']))}" title="{$row.project}">{$row.op_id}</a></td>
                                        <td>{$row.business_name}</td>
                                        <td>{$row.kinds}</td>
                                        <td>{$row.op_user_name}</td>
                                        <td>{$row.create_time}</td>
                                        <!--<td>{$row.status}</td>-->
                                        <if condition="rolemenu(array('Op/relprice'))">
                                        <td class="taskOptions">
                                        <a href="{:U('Op/relprice',array('relid'=>$row['id'],'opid'=>$row['op_id']))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                        </td>
                                        </if>
                                        <if condition="rolemenu(array('Op/delrel'))">
                                        <td class="taskOptions">
                                        <button onClick="javascript:ConfirmDel('{:U('Op/delrel',array('relid'=>$row['id']))}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
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
                <input type="hidden" name="c" value="Op">
                <input type="hidden" name="a" value="relpricelist">
                
                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="title" placeholder="业务名称">
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="opid" placeholder="项目编号">
                </div>
                
                <div class="form-group col-md-4">
                    <select class="form-control" name="type">
                        <option value="0">请选择</option>
                        <foreach name="kinds" item="v" key="k">
                        <option value="{$k}">{$v}</option>
                        </foreach>
                    </select>
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="op" placeholder="计调">
                </div>
                
                
                </form>
            </div>

<include file="Index:footer2" />
