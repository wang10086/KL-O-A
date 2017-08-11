<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>制定PDCA计划</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Kpi/pdca')}"><i class="fa fa-gift"></i> PDCA</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <form method="post" action="{:U('Op/plans')}" name="myform" id="myform">
                <input type="hidden" name="dosubmint" value="1">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                                  
                            
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">PDCA计划</h3>
                                    <div class="box-tools pull-right">
                                    	<span class="rtxt">月份：2017-08 &nbsp;&nbsp; 制表人：成利</span>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                    	    <div class="box-body table-responsive no-padding" id="pdcalist">
                                                <table class="table table-hover">
                                                    <tbody>
                                                    <tr>
                                                        <th rowspan="2" class="line2">序号</th>
                                                        <th rowspan="2" class="line2">P:计划工作项目</th>
                                                        <th rowspan="2" class="line2">P:完成时间</th>
                                                        <th rowspan="2" class="line2">P:细项及标准</th>
                                                        <th rowspan="2" class="line2">D：执行方法</th>
                                                        <th rowspan="2" class="line2">D：应急问题处理</th>
                                                        <th colspan="2" class="line1">C：检查及调整策略</th>
                                                        <th rowspan="2" class="line2">A：新策略</th>
                                                        <th rowspan="2" class="line2">权重</th>
                                                        <th rowspan="2" class="line2">评分值</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="line1">完成情况</th>
                                                        <th class="line1">未完成原因或进度</th>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    
                                                	</tbody>
                                                </table>
                                            </div>
                                            
                                            <a href="javascript:;" class="btn btn-success btn-sm" style="margin-top:15px;" onClick="add_material()"><i class="fa fa-fw fa-plus"></i> 新增项目</a> 
                                            
                                            <div class="form-group">&nbsp;</div>
                                       
                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                           
                            <div style="width:100%; text-align:center;">
                            <button type="submit" class="btn btn-info btn-lg" id="lrpd">我要立项</button>
                            </div>
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                    </form>
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />
		<!--
		<script type="text/javascript">
            function sousuo(){
				var keywords = <?php echo $keywords; ?>;
                $("#customer_name").autocomplete(keywords, {
                     matchContains: true,
                     highlightItem: false,
                     formatItem: function(row, i, max, term) {
                         return '<span style=" display:none">'+row.pinyin+'</span>'+row.company_name;
                     },
                     formatResult: function(row) {
                         return row.company_name;
                     }
                });
            };
			
			$(document).ready(function(e) {
                sousuo();
            });
        </script>
        -->