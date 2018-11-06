<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        签字管理
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Finance/sign')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">个人签字管理</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">签字信息</h3>
                                    <div class="box-tools pull-right">
                                        <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',350,100);"><i class="fa fa-search"></i> 搜索</a>
                                        <if condition="rolemenu(array('Finance/sign_add')) && ($mine eq null)">
                                        <a href="javascript:;" onClick="javascript:{:open_sign()}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 增加签字信息</a>
                                        </if>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" width="80" data="user_id">ID</th>
                                        <th class="sorting" data="name">姓名</th>
                                        <th class="sorting" data="department">部门</th>
                                        <th class="taskOptions" >签字详情</th>
                                        <th width="60" class="taskOptions">编辑</th>

                                        <if condition="rolemenu(array('Finance/delsign'))">
                                        <th width="60" class="taskOptions">删除</th>
                                        </if> 
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td>{$row.user_id}</td>
                                        <td>{$row.name}</td>
                                        <td>{$row.department}</td>
                                        <td><div style="display: inline-block"><img width="100" src="/{$row.file_url}" alt=""></div></td>
                                        <td class="taskOptions">
                                            <a href="javascript:;" onClick="javascript:{:open_sign($row['id'])}" title="编辑" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                        </td>
                                        <if condition="rolemenu(array('Finance/del_sign'))">
                                        <td class="taskOptions">
                                        <button onClick="javascript:ConfirmDel('{:U('Finance/del_sign',array('id'=>$row['id']))}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
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
                <input type="hidden" name="c" value="Finance">
                <input type="hidden" name="a" value="sign">

                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="title" placeholder="人员名称">
                </div>
                
                </form>
            </div>

<include file="Index:footer2" />
