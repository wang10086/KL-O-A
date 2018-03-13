<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        工单管理
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
                                    <h3 class="box-title">工单项列表</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',800,160);"><i class="fa fa-search"></i> 搜索</a>
                                        <if condition="rolemenu(array('Worder/dept_worder_add'))">
                                         <a href="{:U('Worder/dept_worder_add')}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 新增工单项</a>
                                        </if>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
                                <div class="btn-group" id="catfont">
                                    <!--<a href="javascript:;" class="btn">所有工单项</a>-->
                                    <!--<a href="{:U('Worder/worder_list',array('pin'=>0))}" class="btn <?php /*if($pin==0){ echo 'btn-info';}else{ echo 'btn-default';} */?>">所有工单项</a>-->
                                </div>
                                
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" width="80" data="id">id</th>
                                        <th class="sorting" data="pro_title">项目类型</th>
                                        <th class="sorting" data="dept">执行单位</th>
                                        <th class="sorting" width="160" data="type">工单类型</th>
                                        <th class="sorting" data="use_time">完成时间</th>
                                        <if condition="rolemenu(array('Worder/dept_worder_upd'))">
                                        <th width="40" class="taskOptions">编辑</th>
                                        </if>
                                        
                                        <if condition="rolemenu(array('Worder/dept_worder_del'))">
                                        <th width="40" class="taskOptions">删除</th>
                                        </if> 
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td>{$row.id}</td>
                                        <td>{$row.pro_title}</td>
                                        <td>{$row.dept}</td>
                                        <td>{$row.type}</td>
                                        <td>{$row.use_time}个工作日</td>
                                        <!--<td>{$row.use_time|date='Y-m-d H:i:s',###}</td>-->
                                        <if condition="rolemenu(array('Worder/dept_worder_upd'))">
                                            <td><a href="{:U('Worder/dept_worder_upd',array('id'=>$row['id']))}" title="编辑" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a></td>
                                        </if>
                                        <if condition="rolemenu(array('Worder/dept_worder_del'))">
                                        <td class="taskOptions">
                                        <button onClick="javascript:ConfirmDel('{:U('Worder/dept_worder_del',array('id'=>$row['id']))}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
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
                <input type="hidden" name="c" value="Worder">
                <input type="hidden" name="a" value="dept_worder_list">

                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="pro_title" placeholder="项目类型">
                </div>

                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="dept" placeholder="执行单位">
                </div>
                </form>
            </div>

<include file="Index:footer2" />
