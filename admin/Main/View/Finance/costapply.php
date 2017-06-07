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
                                    <h3 class="box-title">{$_action_}</h3>
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <div class="btn-group" id="catfont">
                                    <button onClick="javascript:window.location.href='#';" class="btn <?php if($status=='-1'){ echo 'btn-info';}else{ echo 'btn-default';} ?>">所有的</button>
                                    <button onClick="javascript:window.location.href='#';" class="btn <?php if($status==0){ echo 'btn-info';}else{ echo 'btn-default';} ?>">未确认</button>
                                    <button onClick="javascript:window.location.href='#';" class="btn <?php if($status==1){ echo 'btn-info';}else{ echo 'btn-default';} ?>">已确认</button>
                                    <button onClick="javascript:window.location.href='#';" class="btn <?php if($status==2){ echo 'btn-info';}else{ echo 'btn-default';} ?>">已完成</button>
                                </div>
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" data="op_id">团号</th>
                                        <th class="sorting" data="product_name">产品名称</th>
                                        <th class="sorting" data="departure">出行时间</th>
                                        <th class="sorting" data="number">总计利润</th>
                                        <th class="sorting" data="sale_cost">申请人</th>
                                        <th class="sorting" data="days">申请金额</th>
                                        <th class="sorting" data="destination">审核状态</th>
                                        <th class="sorting" data="create_user_name">支付状态</th>
                                        
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td><a href="{:U('Op/plans_info',array('opid'=>$row['op_id']))}">{$row.op_id}</a></td>
                                        <td>{$row.product_name}</td>
                                        <td>{$row.departure}</td>
                                        <td>&yen;3780</td>
                                        <td>张三</td>
                                        <td>&yen;800</td>
                                        <td>未审批</td>
                                        <td>未支付</td>
                                        
                                       
                                    </tr>
                                    </foreach>					
                                </table>
                                </div><!-- /.box-body -->
                                <div class="box-footer clearfix">
                                    <ul class="pagination pagination-sm no-margin pull-right">
                                        {$pages}
                                    </ul>
                                </div>
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                     </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->

<include file="Index:footer2" />
