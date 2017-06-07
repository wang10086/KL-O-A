<include file="Index:header2" />

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>物资出库记录</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Material/stock')}">物资库存</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                   

                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                         <div class="col-md-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">物资出库记录</h3>
                                    <div class="pull-right box-tools">
                                        <button class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',500,160);"><i class="fa fa-search"></i> 查找</button>
                                        <if condition="rolemenu(array('Material/out'))">
                                        <a href="{:U('Material/out')}" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i> 申请出库</a>
                                        </if>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-bordered dataTable fontmini" id="tablelist">
                                        <tr role="row" class="orders" >
                                        	<th>ID</th>
                                            <th class="sorting" data="order_id">团号</th>
                                            <th class="sorting" data="name">出库单名称</th>
                                            <th>金额</th>
                                            <th class="sorting" data="receive_liable">领取人</th>
                                            <th class="sorting" data="storehouse_liable">库房负责人</th>
                                            <th class="sorting" data="out_time">申请时间</th>
                                            <th class="sorting" data="audit_status">状态</th>
                                            <if condition="rolemenu(array('Material/purchase_viwe'))">
                                            <th width="60" class="taskOptions">清单</th>
                                            </if>
                                        </tr>
                                        <foreach name="lists" item="row">
                                        <tr>
                                            <td>{$row.id}</td>
                                            <td>{$row.order_id}</td>
                                            <td><a href="{:U('Material/out_viwe',array('id'=>$row['id']))}"  title="清单" target="_blank" >{$row.name}</a></td>
                                            <td>{$row.total}</td>
                                            <td>{$row.receive_liable}</td>
                                            <td>{$row.storehouse_liable}</td>
                                            <td><if condition="$row['out_time']">{$row.out_time|date='Y-m-d H:i:s',###}</if></td>
                                            <?php 
                                            if($row['audit_status']== P::AUDIT_STATUS_NOT_AUDIT){
                                                $show  = '<td>等待审批</td>';	
                                            }else if($row['audit_status'] == P::AUDIT_STATUS_PASS){
                                                $show  = '<td><span class="green">通过</span></td>';	
                                            }else if($row['audit_status'] == P::AUDIT_STATUS_NOT_PASS){
                                                $show  = '<td><span class="red">不通过</span></td>';	
                                            }
                                            echo $show;
                                            ?>
                                            <if condition="rolemenu(array('Material/out_viwe'))">
                                            <td class="taskOptions">
                                            <a href="{:U('Material/out_viwe',array('id'=>$row['id']))}"  title="清单" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></a>
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

                            
                        </div><!-- right col -->
                    </div><!-- /.row (main row) -->

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->
		
        <div id="searchtext">
            <form action="" method="get" id="searchform">
            <input type="hidden" name="m" value="Main">
            <input type="hidden" name="c" value="Material">
            <input type="hidden" name="a" value="out_record">
            <div class="form-group col-md-6">
                <input type="text" name="oid" placeholder="团号" class="form-control"/>
            </div>
            <div class="form-group col-md-6">
                <input type="text" name="lqr" placeholder="领取人" class="form-control"/>
            </div>
            </form>
        </div>


        
<include file="Index:footer2" />