<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>营员管理</h1>
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
                                    <h3 class="box-title">营员管理</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',600,160);"><i class="fa fa-search"></i> 搜索</a>
                                         <if condition="rolemenu(array('Customer/IC_edit'))">
                                         <a href="{:U('Customer/IC_edit')}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 录入营员</a>
                                         </if>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" width="60" data="id">ID</th>
                                        <th class="sorting" data="name">姓名</th>
                                        <th class="sorting" data="sex">性别</th>
                                        <th class="sorting" data="number">证件号</th>
                                        <th class="sorting" data="mobile">联系电话</th>
                                        <th class="sorting" data="ecname">家长姓名</th>
                                        <th class="sorting" data="ecmobile">家长电话</th>
                                        <th class="sorting" data="remark" width="15%">单位</th>
                                        <th>最近参营时间</th>
                                        <th class="sorting" data="source">维护人</th>
                                        <if condition="rolemenu(array('Customer/IC_edit'))">
                                        <th width="50" class="taskOptions">维护</th>
                                        </if>
                                        
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td>{$row.id}</td>
                                        <td>{$row.name}</td>
                                        <td>{$row.sex}</td>
                                        <td>{$row.number}</td>
                                        <td>{$row.mobile}</td>
                                        <td>{$row.ecname}</td>
                                        <td>{$row.ecmobile}</td>
                                        <td>{$row.remark}</td>
                                        <td>{$row.sales_time|date='Y-m-d H:i:s',###}</td>
                                        <td>{$row.user}</td>
                                        <if condition="rolemenu(array('Customer/IC_edit'))">
                                        <td class="taskOptions">
                                        <a href="{:U('Customer/IC_edit',array('id'=>$row['id']))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
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
                <input type="hidden" name="c" value="Customer">
                <input type="hidden" name="a" value="IC">
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="nm" placeholder="姓名">
                </div>
                
                <div class="form-group col-md-4">
                    <select class="form-control" name="sex">
                    	<option value="">性别</option>
                        <option value="男">男</option>
                        <option value="女">女</option>
                    </select>
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="no" placeholder="证件号">
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="tel" placeholder="电话">
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="dw" placeholder="单位">
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="ec" placeholder="家长姓名">
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="ectel" placeholder="家长电话">
                </div>
                
                </form>
            </div>

<include file="Index:footer2" />
