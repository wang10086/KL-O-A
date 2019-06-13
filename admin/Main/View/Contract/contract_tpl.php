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
                        <li><a href="{:U('Contract/index')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
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
                                        <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',400,150);"><i class="fa fa-search"></i> 搜索</a>
                                        <a href="{:U('Contract/add_tpl')}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> 新建合同模板</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                	<table class="table table-bordered dataTable fontmini" id="tablelist">
                                        <tr role="row" class="orders" >
                                        	<th class="taskOptions" width="60">ID</th>
                                        	<th class="sorting" data="title">模板标题</th>
                                            <th class="sorting" data="create_time">创建时间</th>
                                            <if condition="rolemenu(array('Contract/tpl_detail'))">
                                            <th width="60" class="taskOptions">详情</th>
                                            </if>
                                            <if condition="rolemenu(array('Contract/add_tpl'))">
                                            <th width="60" class="taskOptions">编辑</th>
                                            </if>

                                            <if condition="rolemenu(array('Contract/del_tpl'))">
                                            <th width="60" class="taskOptions">删除</th>
                                            </if>
                                        </tr>
                                        <foreach name="lists" item="row">                      
                                        <tr>
                                        	<td>{$row.id}</td>
                                            <td><a href="{:U('Contract/tpl_detail', array('id'=>$row['id']))}">{$row.title}</a></td>
                                            <td>{$row.create_time|date='y-m-d H:i',###}</td>
                                            <if condition="rolemenu(array('Contract/tpl_detail'))">
                                            <td class="taskOptions">
                                            <button onClick="javascript:window.location.href='{:U('Contract/tpl_detail',array('id'=>$row['id']))}';" title="详情" class="btn btn-success  btn-smsm"><i class="fa  fa-building-o"></i></button>
                                            </td>
                                            </if>
                                            <if condition="rolemenu(array('Contract/add_tpl'))">
                                            <td class="taskOptions">
                                            <button onClick="javascript:window.location.href='{:U('Contract/add_tpl',array('id'=>$row['id']))}';" title="修改" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></button>
                                            </td>
                                            </if>

                                            <if condition="rolemenu(array('Contract/del_tpl'))">
                                            <td class="taskOptions">
                                            <button onClick="javascript:ConfirmDel('{:U('Contract/del_tpl',array('id'=>$row['id']))}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
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
        
        <div id="searchtext">
            <form action="" method="get" id="searchform">
            <input type="hidden" name="m" value="Main">
            <input type="hidden" name="c" value="Contract">
            <input type="hidden" name="a" value="contract_tpl">
            <div class="form-group col-md-12">
                <input type="text" class="form-control" name="tit" placeholder="模板标题关键字">
            </div>
            
            <div class="form-group col-md-12">
                <input type="text" class="form-control" name="con" placeholder="模板内容关键字">
            </div>
            </form>
        </div>