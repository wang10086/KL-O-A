<include file="Index:header2" />

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>物资入库记录</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Material/into_record')}">物资入库记录</a></li>
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
                                    <h3 class="box-title">物资入库记录</h3>
                                    <div class="pull-right box-tools">
                                        <button class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',500,160);"><i class="fa fa-search"></i> 查找</button>
                                        <if condition="rolemenu(array('Material/into'))">
                                        <button onClick="javascript:window.location.href='{:U('Material/into')}';" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i> 物资入库</button>
                                        </if>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-bordered dataTable fontmini" id="tablelist">
                                        <tr role="row" class="orders" >
                                        	<th>ID</th>
                                            
                                            <th class="sorting" data="material">物资名称</th>
                                            <th class="sorting" data="amount">入库数量</th>
											<th class="sorting" data="unit_price">单价</th>
                                            <th class="sorting" data="total">合计</th>
                                            <!-- <th class="sorting" data="department">采购部门</th> -->
                                            <th class="sorting" data="op_liable">计调责任人</th>
                                            <th class="sorting" data="purchase_liable">采购责任人</th>
                                            <th class="sorting" data="storehouse_liable">库房责任人</th>
                                            <th class="sorting" data="order_id">团号</th>
                                            <th class="sorting" data="into_time">入库时间</th>
                                            <th class="sorting" data="type">类型</th>
                                            <th class="sorting" data="audit_status">状态</th>
                                        </tr>
                                        <foreach name="lists" item="row">
                                        <tr>
                                            <td>{$row.id}</td>
                                            
                                            <td><a href="{:U('Material/stock',array('keywords'=>$row['material']))}">{$row.material}</a></td>
                                            <td>{$row.amount}</td>
											<td>{$row.unit_price}</td>
                                            <td>{$row.total}</td>
                                            <!-- <td><?php echo $rolelist[$row['department']]; ?></td> -->
                                            <td>{$row.op_liable}</td>
                                            <td>{$row.purchase_liable}</td>
                                            <td>{$row.storehouse_liable}</td>
                                            <td>{$row.order_id}</td>
                                            <td><if condition="$row['into_time']">{$row.into_time|date='Y-m-d H:i:s',###}</if></td>
                                            <?php 
                                            if($row['type']){
                                                echo '<td><span class="green">物资归还</span></td>';	
                                            }else{
                                                echo '<td>采购入库</td>';	
                                            }
                                            ?>
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
            <input type="hidden" name="a" value="into_record">
            <div class="form-group col-md-6">
                <input type="text" class="form-control" name="keywords" placeholder="关键字">
            </div>
            <div class="form-group col-md-6">
                <select  class="form-control"  name="type">
                    <option value="-1">入库类型</option>
                    <option value="0">采购入库</option>
                    <option value="1">物资归还</option>
                </select>
            </div>
           
            </form>
        </div>


        
<include file="Index:footer2" />