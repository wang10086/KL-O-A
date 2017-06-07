<include file="Index:header2" />

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>固定资产</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Material/asset')}">固定资产</a></li>
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
                                    <h3 class="box-title">资产列表</h3>
                                    <div class="pull-right box-tools">
                                        <button class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',500,120);sousuo();"><i class="fa fa-search"></i> 查找</button>
                                        <if condition="rolemenu(array('Material/addasset'))">
                                        <button onClick="javascript:window.location.href='{:U('Material/addasset')}';" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i> 新增</button>
                                        </if>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-bordered dataTable fontmini" id="tablelist">
                                        <tr role="row" class="orders" >
                                        	<th class="sorting" data="mid">资产编号</th>
                                            <!-- <th class="sorting" data="pinyin">拼音</th> -->
                                            <th class="sorting" data="material">资产名称</th>
                                            <th class="sorting" data="stock">库存数量</th>
                                            <th class="sorting" data="stages">分期</th>
                                            <th>入库价格</th>
                                            <th class="sorting" data="kind">资产类型</th>
                                            <th class="sorting" data="spec">规格</th>
                                            <th>最近领用时间</th>
                                            <th>最近入库时间</th>
                                            
                                            <if condition="rolemenu(array('Material/asset_in'))">
                                            <th width="60" class="taskOptions">入库</th>
                                            </if>
                                            <if condition="rolemenu(array('Material/asset_out'))">
                                            <th width="60" class="taskOptions">领用</th>
                                            </if>
                                            <if condition="rolemenu(array('Material/addasset'))">
                                            <th width="60" class="taskOptions">编辑</th>
                                            </if>
                                            
                                        </tr>
                                        <foreach name="lists" item="row">
                                        <tr>
                                            <td>{$row.mid}</td>
                                            <!-- <td>{$row.pinyin}</td> -->
                                            <td>{$row.material}</td>
                                            <td>{$row.stock} {$row.unit}</td>
                                            <td>{$row.stages} 期</td>
                                            <td>{$row.price}</td>
                                            <td><?php echo $kind[$row['kind']]; ?></td>
                                            <td>{$row.spec}</td>
                                            
                                            <td><if condition="$row['out_time']"><a href="{:U('Material/asset_out_record',array('material'=>$row['id']))}">{$row.out_time|date='Y-m-d H:i:s',###}</a></if></td>
                                            
                                            <td><if condition="$row['into_time']"><a href="{:U('Material/asset_in_record',array('material'=>$row['id']))}">{$row.into_time|date='Y-m-d H:i:s',###}</a></if></td>
                                            
                                            <if condition="rolemenu(array('Material/asset_in'))">
                                            <td class="taskOptions">
                                            <button onClick="javascript:window.location.href='{:U('Material/asset_in',array('id'=>$row['id']))}';" title="入库" class="btn btn-danger btn-smsm"><i class="fa fa-home"></i></button>
                                            </td>
                                            </if>
                                            <if condition="rolemenu(array('Material/asset_out'))">
                                            <td class="taskOptions">
                                            <button onClick="javascript:window.location.href='{:U('Material/asset_out',array('id'=>$row['id']))}';" title="领用" class="btn btn-success btn-smsm"><i class="fa fa-truck"></i></button>
                                            </td>
                                            </if>
                                            <if condition="rolemenu(array('Material/addasset'))">
                                            <td class="taskOptions">
                                            <button onClick="javascript:window.location.href='{:U('Material/addasset',array('id'=>$row['id']))}';" title="编辑" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></button>
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
            <input type="hidden" name="a" value="asset">
            
            <div class="form-group box-float-6">
                <input type="text" name="keywords" id="material_name" placeholder="资产名称" class="form-control"/>
            </div>
            
            <div class="form-group box-float-6">
                <select  class="form-control" name="kind">
                <option value="0">资产类型</option>
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
