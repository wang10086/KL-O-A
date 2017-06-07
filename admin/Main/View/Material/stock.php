<include file="Index:header2" />

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>物资库存</h1>
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
                                    <h3 class="box-title">物资列表</h3>
                                    <div class="pull-right box-tools">
                                        <button class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',500,120);sousuo();"><i class="fa fa-search"></i> 查找</button>
                                        <if condition="rolemenu(array('Material/add'))">
                                        <button onClick="javascript:window.location.href='{:U('Material/add')}';" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i> 新增</button>
                                        </if>
                                        <if condition="rolemenu(array('Export/material'))">
                                        <button onclick="javascript:window.location.href='{:U('Export/material')}';" class="btn btn-success btn-sm"><i class="fa fa-arrow-circle-down"></i> 导出</button>
                                        </if>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-bordered dataTable fontmini" id="tablelist">
                                        <tr role="row" class="orders" >
                                        	 <th class="sorting" data="id">ID</th>
                                            <!-- <th class="sorting" data="pinyin">拼音</th> -->
                                            <th class="sorting" data="material">物资名称</th>
                                            <th class="sorting" data="stock">库存数量</th>
                                            <th class="sorting" data="kind">物资类型</th>
                                            <th class="sorting" data="type">属性</th>
                                            <!-- <th class="sorting" data="spec">规格</th>-->
                                            <th class="sorting" data="price">最新入库价</th>
                                            <th class="sorting" data="stages">分期</th>
                                            <th>最近入库时间</th>
                                            <th>最近出库时间</th>
                                            <if condition="rolemenu(array('Material/add'))">
                                            <th width="60" class="taskOptions">编辑</th>
                                            </if>
                                            
                                        </tr>
                                        <foreach name="lists" item="row">
                                        <tr>
                                            <td>{$row.id}</td>
                                            <!-- <td>{$row.pinyin}</td> -->
                                            <td>{$row.material}</td>
                                            <td>{$row.stock} {$row.unit}</td>
                                            <td><?php echo $kind[$row['kind']]; ?></td>
                                            <td><?php echo $material_type[$row['type']]; ?></td>
                                            <!-- <td>{$row.spec}</td> -->
                                            <td>{$row.price}</td>
                                            <td>{$row.stages} 期</td>
                                            <td><if condition="$row['into_time']"><a href="{:U('Material/into_record',array('material'=>$row['id']))}">{$row.into_time|date='Y-m-d H:i:s',###}</a></if></td>
                                            <td><if condition="$row['out_time']"><a href="{:U('Material/out_record',array('material'=>$row['id']))}">{$row.out_time|date='Y-m-d H:i:s',###}</a></if></td>
                                            
                                            <if condition="rolemenu(array('Material/add'))">
                                            <td class="taskOptions">
                                            <button onClick="javascript:window.location.href='{:U('Material/add',array('id'=>$row['id']))}';" title="编辑" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></button>
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
            <input type="hidden" name="a" value="stock">
            
            <div class="form-group box-float-6">
                <input type="text" name="keywords" id="material_name" placeholder="物资名称" class="form-control"/>
            </div>
            
            <div class="form-group box-float-6">
                <select  class="form-control" name="kind">
                <option value="0">物资类型</option>
                <foreach name="material_class" item="v">
                    <option value="{$v.id}">{$v.name}</option>
                </foreach>
                </select>
            </div>
            
            </form>
        </div>

        
		<include file="Index:footer2" />

		<script type="text/javascript">
            function sousuo(){
				var keywords = <?php echo $keywords; ?>;
                $("#material_name").autocomplete(keywords, {
                     matchContains: true,
                     highlightItem: false,
                     formatItem: function(row, i, max, term) {
                         return '<span style=" display:none">'+row.pinyin+'</span>'+row.material;
                     },
                     formatResult: function(row) {
                         return row.material;
                     }
                });
            };
        </script>
