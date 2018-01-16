<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$deptname}个人业绩排行榜</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li class="active">{$deptname}个人业绩排行榜</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
					
                    
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-warning">
                                <div class="box-body">
                                     <p>提示：以下累计数据从2018年1月1日起已完成结算项目中采集</p>
                                	 <table id="example2" class="table table-striped table-bordered table-hover" >
                                        <thead>
                                            <tr role="row" class="orders" >
                                            	<th width="40">序号</th>
                                                <th>姓名</th>
                                                <th>所在部门</th>
                                                <th class="orderth">累计收入(元)</th>
                                                <th class="orderth">累计毛利(元)</th>
                                                <th class="orderth">累计毛利率(%)</th>
                                                <th class="orderth">当月收入(元)</th>
                                                <th class="orderth">当月毛利(元)</th>
                                                <th class="orderth">当月毛利率(%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <foreach name="lists" item="row" key="k">                      
                                            <tr>
                                            	<td class="orderNo"></td>
                                                <td><a href="{:U('Chart/finance',array('xs'=>$row['create_user_name'],'st'=>'2018-01-01'))}">{$row.create_user_name}</a></td>
                                                <td>{$row.rolename}</td>
                                                <td>{$row.zsr}</td>
                                                <td>{$row.zml}</td>
                                                <td>{$row.mll}</td>
                                                <td>{$row.ysr}</td>
                                                <td>{$row.yml}</td>
                                                <td>{$row.yll}</td>
                                            </tr>
                                            </foreach>	
                                        </tbody>	
                                        
                                    </table>
                                
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                     </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->

        <include file="Index:footer2" />
        <script type="text/javascript">
		$('#example2').dataTable({
			"bPaginate": false,
			"bLengthChange": false,
			"bFilter": false,
			"bSort": true,
			"bInfo": false,
			"aaSorting" : [[4, "desc"]],
			"bAutoWidth": true,
			"aoColumnDefs": [{ "bSortable": false, "aTargets": [ 0,1,2] }]
		});
		
		$(document).ready(function(e) {
			$('.orderNo').each(function(index, element) {
				$(this).text(index+1);
			});	
				
			$('.orderth').click(function(){
				$('.orderNo').each(function(index, element) {
					$(this).text(index+1);
				});	
			})
		});
        </script>
        