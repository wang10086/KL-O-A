<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>团队总体业绩排行榜</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li class="active">团队总体业绩排行榜</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
					
                    <div class="btn-group" id="catfont">
                        <a href="{:U('Chart/pplist')}" class="btn btn-default">个人业绩排行榜</a>
                        <a href="{:U('Chart/tplist')}" class="btn btn-info">团队总体业绩排行榜</a>
                        <a href="{:U('Chart/tpavglist')}" class="btn btn-default">团队人均排行榜</a>
                    </div>
                    
                    <div class="row" style="margin-top:20px;">
                        <div class="col-xs-12">
                            <div class="box box-warning">
                                
                                <div class="box-body">
                                	<p>提示：以下累计数据从2018年1月1日起已完成结算项目中采集</p>
                                    <table id="example2" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr role="row" class="orders" >
                                                <th width="40" data="">序号</th>
                                                <th>团队</th>
                                                <th width="12%">负责人</th>
                                                <th width="12%" class="orderth">累计收入(元)</th>
                                                <th width="12%" class="orderth">累计毛利(元)</th>
                                                <th width="12%" class="orderth">累计毛利率(%)</th>
                                                <th width="12%" class="orderth">当月收入(元)</th>
                                                <th width="12%" class="orderth">当月毛利(元)</th>
                                                <th width="12%" class="orderth">当月毛利率(%)</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                        <foreach name="lists" item="row" key="k">                      
                                            <tr>
                                                <td class="orderNo"></td>
                                                <td>{$row.rolename}</td>
                                                <td>{$row.fzr}</td>
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
                                </div>
                                
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
			"aoColumnDefs": [{ "bSortable": false, "aTargets": [ 0,1,2 ] }]
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