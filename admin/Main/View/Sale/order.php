<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>销售记录</h1>
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
                                    <h3 class="box-title">销售记录</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',600,160);"><i class="fa fa-search"></i> 搜索</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" width="100" data="o.order_id">订单号</th>
                                        <th class="sorting" data="p.project" width="160">项目名称</th>
                                        <th class="sorting" data="o.amount">销售数量</th>
                                        <th class="sorting" data="o.number">合计人数</th>
                                        <th class="sorting" data="o.actual_cost">实收金额</th>
                                        <th class="sorting" data="o.sales_person">销售人</th>
                                        <th class="sorting" data="o.sales_time">销售时间</th>
                                        <if condition="rolemenu(array('Sale/order_viwe'))">
                                        <th width="50" class="taskOptions">详情</th>
                                        </if>
                                        
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td>{$row.order_id}</td>
                                        <td><div class="tdbox"><a href="{:U('Sale/order_viwe',array('oid'=>$row['order_id']))}" title="{$row.project}">{$row.project}</a></div></td>
                                        <td>{$row.amount}</td>
                                        <td>{$row.number}</td>
                                        <td><if condition="$row['actual_cost']">&yen;{$row.actual_cost}</if></td>
                                        <td>{$row.sales_person}</td>
                                        <td><if condition="$row['sales_time']">{$row.sales_time|date='Y-m-d H:i:s',###}</if></td>
                                        <if condition="rolemenu(array('Sale/order_viwe'))">
                                        <td class="taskOptions">
                                        <a href="{:U('Sale/order_viwe',array('oid'=>$row['order_id']))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></a>
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
                <input type="hidden" name="c" value="Sale">
                <input type="hidden" name="a" value="order">
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="orderid" placeholder="订单号">
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="opid" placeholder="项目编号">
                </div>
                
                 <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="groupid" placeholder="团号">
                </div>
                
                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="keywords" placeholder="项目名称">
                </div>
                
               
                
                </form>
            </div>

<include file="Index:footer2" />
