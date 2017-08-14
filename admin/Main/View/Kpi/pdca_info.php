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
                                                <table class="table">
                                                    <tbody>
                                                    <tr>
                                                        <th rowspan="2" width="50" class="line2">序号</th>
                                                        <th rowspan="2" class="line2" style="text-align:left;">P:计划工作项目</th>
                                                        <th rowspan="2" width="100" class="line2">P:完成时间</th>
                                                        <th rowspan="2" width="90" class="line2">P:细项及标准</th>
                                                        <th rowspan="2" width="90" class="line2">D:执行方法</th>
                                                        <th rowspan="2" width="90" class="line2">D:应急处理</th>
                                                        <th colspan="2" width="160" class="line1">C:检查及调整策略</th>
                                                        <th rowspan="2" width="80" class="line2">A:新策略</th>
                                                        <th rowspan="2" width="50" class="line2">权重</th>
                                                        <th rowspan="2" width="50" class="line2">评分</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="line1" width="80" >完成情况</th>
                                                        <th class="line1" width="80" >未完成情况</th>
                                                    </tr>
                                                    <tr valign="middle">
                                                        <td align="center">1</td>
                                                        <td>计调部工作管理及品质监督、检查</td>
                                                        <td align="center">考核期、随时</td>
                                                        <td align="center"><a href="" title="1.选择资质齐全、口碑好的地接社；2.按规定比价；3.确认件；4.保证安全提示；5.按约定标准监督实施；6.保证付款方式约定不影响团队运行">详情</a></td>
                                                        <td align="center"><a href="" title="1.选择资质齐全、口碑好的地接社；2.按规定比价；3.确认件；4.保证安全提示；5.按约定标准监督实施；6.保证付款方式约定不影响团队运行">详情</a></td>
                                                        <td align="center"><a href="" title="1.选择资质齐全、口碑好的地接社；2.按规定比价；3.确认件；4.保证安全提示；5.按约定标准监督实施；6.保证付款方式约定不影响团队运行">详情</a></td>
                                                        <td align="center"><a href="" title="1.选择资质齐全、口碑好的地接社；2.按规定比价；3.确认件；4.保证安全提示；5.按约定标准监督实施；6.保证付款方式约定不影响团队运行">详情</a></td>
                                                        <td align="center"><a href="" title="1.选择资质齐全、口碑好的地接社；2.按规定比价；3.确认件；4.保证安全提示；5.按约定标准监督实施；6.保证付款方式约定不影响团队运行">详情</a></td>
                                                        <td align="center"><a href="" title="1.选择资质齐全、口碑好的地接社；2.按规定比价；3.确认件；4.保证安全提示；5.按约定标准监督实施；6.保证付款方式约定不影响团队运行">详情</a></td>
                                                        <td align="center">10</td>
                                                        <td align="center">20</td>
                                                        
                                                    </tr>
                                                    
                                                	</tbody>
                                                </table>
                                            </div>
                                            
                                            <a href="javascript:;" class="btn btn-success btn-sm" style="margin-top:15px;" onClick="add_pdca()"><i class="fa fa-fw fa-plus"></i> 新增项目</a> 
                                            
                                            <div class="form-group">&nbsp;</div>
                                       
                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                    </form>
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  		</div>
	</div>

	<include file="Index:footer2" />
    
    <script>
    //打开新建任务box
	function add_pdca() {
		
		art.dialog.open('index.php?m=Main&c=Kpi&a=editpdca',{
			lock:true,
			title: '新建PDCA项目',
			width:860,
			height:500,
			okValue: '提交',
			fixed: true,
			ok: function () {
				this.iframe.contentWindow.gosubmint();
				return false;
			},
			cancelValue:'取消',
			cancel: function () {
			}
		});	
	}
    </script>
		