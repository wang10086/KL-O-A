		<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>PDCA评分</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Kpi/pdca')}"><i class="fa fa-gift"></i> PDCA</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
               
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                                  
                            
                            <form method="post" action="{:U('Kpi/score')}" name="myform" id="myform">
                			<input type="hidden" name="dosubmint" value="1">
                            <input type="hidden" name="pdcaid" value="{$pdca.id}">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">PDCA计划</h3>
                                    <div class="box-tools pull-right">
                                    	
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                    	<span class="rtxt" style="margin-top:-10px;">
                                        月份：{$pdca.month} &nbsp;&nbsp;&nbsp;&nbsp;
                                        被考评人：{:username($pdca['tab_user_id'])} &nbsp;&nbsp;&nbsp;&nbsp;
                                        <?php 
										if($pdca['status']==2){
										?>
                                        考评人：{:username($pdca['eva_user_id'])} &nbsp;&nbsp;&nbsp;&nbsp;
                                        <?php 
										}
										?>
                                        考评得分：{$pdca.total_score}
                                        </span> 
                                        <span class="totalscore">总分合计：<i id="fenshu">{$pdca.total_score}</i> 分</span>
                                        <div class="box-body table-responsive no-padding">
                                        <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                            <tr role="row" class="orders" >
                                                <th width="50">序号</th>
                                                <th>工作项目</th>
                                                <th width="180">完成时间</th>
                                                <th width="100">录入时间</th>
                                                <th width="80">权重</th>
                                                <th width="80">评分</th>
                                                <if condition="rolemenu(array('Kpi/editpdca'))">
                                                <th width="50" class="taskOptions">编辑</th>
                                                </if>
                                                <if condition="rolemenu(array('Kpi/delpdcaterm'))">
                                                <th width="50" class="taskOptions">删除</th>
                                                </if>
                                            </tr>
                                            <foreach name="lists" key="key" item="row"> 
                                            <tr>
                                                <td align="center" style="line-height:34px;"><?php echo $key+1; ?></td>
                                                <td style="line-height:34px;"><a href="javascript:;" onClick="pdca({$row.id})">{$row.work_plan}</a></td>
                                                <td style="line-height:34px;">{$row.complete_time}</td>
                                                <td style="line-height:34px;"><if condition="$row['create_time']">{$row.create_time|date='m-d H:i',###}</if></td>
                                                <td style="line-height:34px;">{$row.weight}</td>
                                                <td><input type="text" name="pdca[{$row.id}]" value="{$row.score}" class="form-control unitscore" onChange="unitscore()"></td>
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
                                        
                                        
                                        
                                        <div class="form-group">&nbsp;</div>
                                       
                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                           
                            
                            <div style="width:100%; text-align:center;">
                            <button type="submit" class="btn btn-info btn-lg" id="lrpd">保存评分</button>
                            </div>
                            </form>
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                    
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  		</div>
	</div>

	<include file="Index:footer2" />
    
    <script>
    //编辑PDCA项目
	function edit_pdca(id) {
		var pdcaid = '{$pdca.id}';
		art.dialog.open('index.php?m=Main&c=Kpi&a=editpdca&pdcaid='+pdcaid+'&id='+id,{
			lock:true,
			title: '新建PDCA项目',
			width:'80%',
			height:'90%',
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
			title: 'PDCA项目详情',
			width:900,
			height:'90%',
			fixed: true,
			
		});	
	}
	
	
	function unitscore(){
		var total = 0;
		$('.unitscore').each(function(index, element) {
            var score = parseInt($(this).val());
			if(!score){
				score = 0;	
			}
			total += score;
        });	
		$('#fenshu').text(total);
	}
	
    </script>
		