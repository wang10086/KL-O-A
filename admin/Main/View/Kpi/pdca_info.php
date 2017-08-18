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
                                        <div class="box-body table-responsive no-padding">
                                        <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                            <tr role="row" class="orders" >
                                                <th width="50">序号</th>
                                                <th class="sorting" data="work_plan">工作项目</th>
                                                <th width="180" class="sorting" data="complete_time">完成时间</th>
                                                <th width="80" class="sorting" data="weight">权重</th>
                                                <th width="80" class="sorting" data="score">评分</th>
                                                <th width="100" class="sorting" data="create_time">创建时间</th>
                                                <if condition="rolemenu(array('Kpi/editpdca'))">
                                                <th width="50" class="taskOptions">编辑</th>
                                                </if>
                                                <if condition="rolemenu(array('Kpi/delpdcaterm'))">
                                                <th width="50" class="taskOptions">删除</th>
                                                </if>
                                            </tr>
                                            <foreach name="lists" item="row"> 
                                            <tr>
                                                <td align="center">1</td>
                                                <td><a href="javascript:;" onClick="pdca({$row.id})">{$row.work_plan}</a></td>
                                                <td>{$row.complete_time}</td>
                                                <td>{$row.weight}</td>
                                                <td>{$row.score}</td>
                                                <td><if condition="$row['create_time']">{$row.create_time|date='m-d H:i',###}</if></td>
                                                <if condition="rolemenu(array('Kpi/editpdca'))">
                                                <td class="taskOptions">
                                                <a href="javascript:;" onClick="edit_pdca({$row.id})" title="编辑" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                                </td>
                                                </if>
                                                <if condition="rolemenu(array('Kpi/delpdcaterm'))">
                                                <td class="taskOptions">
                                                <button onclick="javascript:ConfirmDel('{:U('Kpi/delpdcaterm',array('id'=>$row['id']))}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
                                               
                                                </td>
                                                </if>
                                               
                                            </tr>
                                            </foreach>					
                                        </table>    
                                        </div>
                                        
                                        <a href="javascript:;" class="btn btn-success btn-sm" style="margin-top:15px;" onClick="edit_pdca(0)"><i class="fa fa-fw fa-plus"></i> 新增项目</a> 
                                        
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
    //编辑PDCA项目
	function edit_pdca(id) {
		art.dialog.open('index.php?m=Main&c=Kpi&a=editpdca&id='+id,{
			lock:true,
			title: '新建PDCA项目',
			width:900,
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
	
	
	 //查看PDCA项目
	function pdca(id) {
		art.dialog.open('index.php?m=Main&c=Kpi&a=pdcadetail&id='+id,{
			lock:true,
			title: 'PDCA项目',
			width:900,
			height:500,
			fixed: true,
			cancelValue:'关闭',
			cancel: function () {
			}
		});	
	}
    </script>
		