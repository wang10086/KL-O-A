		<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>KPI项目计划</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Kpi/kpi')}"><i class="fa fa-gift"></i> KPI</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
               
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                                  
                            
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title"><span class="red">{:username($kpi['user_id'])} [{$kpi.month}]</span> KPI计划</h3>
                                    <div class="box-tools pull-right">
                                    	
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                    	<span class="rtxt" style="margin-top:-10px;">
                                        月份：{$kpi.month} &nbsp;&nbsp;&nbsp;&nbsp;
                                        被考评人：{:username($kpi['user_id'])} &nbsp;&nbsp;&nbsp;&nbsp;
                                        考评人：{$kpi.kaoping} &nbsp;&nbsp;&nbsp;&nbsp;
                                        考评得分：{$kpi.total_score} &nbsp;&nbsp;&nbsp;&nbsp;
                                        状态：{$kpi.status_str}
                                        </span> 
                                        
                                        <?php 
										if($kpi['status'] < 5 || cookie('roleid')==10 || C('RBAC_SUPER_ADMIN')==cookie('username') ){
										if(cookie('userid')==$kpi['user_id'] || cookie('roleid')==$kpi['app_role']){
											if(rolemenu(array('Kpi/editkpi'))){
										?>
                                        <a href="javascript:;" class="btn btn-success btn-sm" style="float:right;"  onClick="edit_kpi(0)"><i class="fa fa-fw fa-plus"></i> 新增项目</a> 
                                        <?php 
											}
										}
										}
										?>
                                        <div class="box-body table-responsive no-padding">
                                        <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                            <tr role="row" class="orders" >
                                                <th width="50">序号</th>
                                                <th>工作项目</th>
                                                <th width="180">完成时间</th>
                                                <th width="100">录入时间</th>
                                                <th width="100">权重分</th>
                                                <th width="100">考评得分</th>
                                                <?php 
												if($kpi['status'] < 5 || cookie('roleid')==10 || C('RBAC_SUPER_ADMIN')==cookie('username') ){
												if(cookie('userid')==$kpi['mk_user_id'] || cookie('roleid')==10 || C('RBAC_SUPER_ADMIN')==cookie('username') ){
												?>
                                                <if condition="rolemenu(array('Kpi/unitscore'))">
                                                <th width="50" class="taskOptions">评分</th>
                                                </if>
                                                <?php 
												}
												?>
                                                <?php 
												if(cookie('userid')==$kpi['user_id'] || cookie('userid')==$kpi['mk_user_id']){
												?>
                                                <if condition="rolemenu(array('Kpi/editkpi'))">
                                                <th width="50" class="taskOptions">编辑</th>
                                                </if>
                                                <if condition="rolemenu(array('Kpi/delkpiterm'))">
                                                <th width="50" class="taskOptions">删除</th>
                                                </if>
                                                <?php } }?>
                                            </tr>
                                            <foreach name="lists" key="key" item="row"> 
                                            <tr>
                                                <td align="center"><?php echo $key+1; ?></td>
                                                <td><a href="javascript:;" onClick="kpi({$row.id})">{$row.work_plan}</a></td>
                                                <td>{$row.complete_time}</td>
                                                <td><if condition="$row['create_time']">{$row.create_time|date='m-d H:i',###}</if></td>
                                                <td>{$row.weight}</td>
                                                <td>{$row.score}</td>
                                                <?php 
												if($kpi['status'] < 5 || cookie('roleid')==10 || C('RBAC_SUPER_ADMIN')==cookie('username') ){
												if(cookie('userid')==$kpi['mk_user_id'] || cookie('roleid')==10 || C('RBAC_SUPER_ADMIN')==cookie('username') ){
												?>
                                                <if condition="rolemenu(array('Kpi/unitscore'))">
                                                <td class="taskOptions">
                                                <a href="javascript:;" onClick="unitscore({$row.id})" title="评分" class="btn btn-success btn-smsm"><i class="fa fa-star"></i></a>
                                                </td>
                                                </if>
                                                <?php 
												}
												?>
                                                <?php 
												if(cookie('userid')==$kpi['user_id'] || cookie('userid')==$kpi['mk_user_id']){
												?>
                                                <if condition="rolemenu(array('Kpi/editkpi'))">
                                                <td class="taskOptions">
                                                <a href="javascript:;" onClick="edit_kpi({$row.id})" title="编辑" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                                </td>
                                                </if>
                                                <if condition="rolemenu(array('Kpi/delkpiterm'))">
                                                <td class="taskOptions">
                                                <button onclick="javascript:ConfirmDel('{:U('Kpi/delkpiterm',array('id'=>$row['id']))}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
                                               
                                                </td>
                                                </if>
                                                <?php } }?>
                                            </tr>
                                            </foreach>					
                                        </table> 
                                        
                                          
                                        </div>
                                        
                                        
                                        
                                        <div class="form-group">&nbsp;</div>
                                       
                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                            
                            
                            
                            
                            
                            
                            
                        </div><!--/.col (right) -->
                        
                        <?php 
						if($kpi['status']<4 && ( cookie('userid')==$kpi['mk_user_id'] || cookie('userid')==$kpi['user_id'] )){
						?>
                        <div class="col-md-12">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">审核</h3>
                                </div>
                                <div class="box-body">
                                	<?php 
									if($kpi['status']==1 && cookie('userid')==$kpi['mk_user_id'] ){
									?>
                                    <form method="post" action="{:U('Kpi/kpi_applyscore')}" name="myform" id="myform">
                                    <input type="hidden" name="dosubmint" value="1" />
                                    <input type="hidden" name="kpiid" value="{$kpi.id}">
                                    <div class="form-group col-md-12" style=" margin-top:20px;">
                                        <div class="checkboxlist" id="applycheckbox">
                                        <input type="radio" name="status" value="2"> 通过 &nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" name="status" value="3"> 不通过
                                        </div>
                                    </div>
                                    
                                    <div class="form-group col-md-12 select_2 ">
                                    	<textarea class="form-control"  placeholder="不通过原因" name="app_remark" ></textarea>
                                    </div>
                                    
                                    <div class="form-group col-md-12" style="text-align:center; margin-top:20px;">
                                    <button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                                    </div>
                                    
                                    </form>
                                    <?php } ?>
                                    
                                    
                                    <?php 
									if($kpi['status']==0 && cookie('userid')==$kpi['user_id']){
									?>
									<form method="post" action="{:U('Kpi/kpi_applyscore')}" name="myform" id="myform">
									<input type="hidden" name="dosubmint" value="1">
									<input type="hidden" name="kpiid" value="{$kpi.id}">
									<input type="hidden" name="status" value="1">
									<div class="form-group col-md-12" style="text-align:center; margin-top:20px;">
									<button type="submit" class="btn btn-info btn-lg" id="lrpd">申请审核</button>
									</div>
									</form>
									<?php 
									}
									?>
									
									<?php 
									if($kpi['status']==2 && cookie('userid')==$kpi['user_id']){
									?>
									<form method="post" action="{:U('Kpi/kpi_applyscore')}" name="myform" id="myform">
									<input type="hidden" name="dosubmint" value="1">
									<input type="hidden" name="kpiid" value="{$kpi.id}">
									<input type="hidden" name="status" value="4">
									<div class="form-group col-md-12" style="text-align:center; margin-top:20px;">
									<button type="submit" class="btn btn-info btn-lg" id="lrpd">申请评分</button>
									</div>
									</form>
									<?php 
									}
									?>
                            
                            
                                    
                                    <div class="form-group col-md-12" id="apptab" style="margin-top:40px;">
                                        <div class="box-body no-padding">
                                            <table class="table">
                                                <tr>
                                                    <th width="150">审核日期</th>
                                                    <th width="150">审核结果</th>
                                                    <th width="150">审核者</th>
                                                    <th>备注</th>
                                                </tr>
                                                <foreach name="applist" key="k" item="v">
                                                <tr>
                                                	<td><if condition="$v['apply_time']">{$v.apply_time|date='Y-m-d H:i',###}</if></td>
                                                    <td>{$v.status}</td>
                                                    <td>{$v.apply_user_nme}</td>
                                                    <td>{$v.remark}</td>
                                                </tr>
                                                </foreach>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group">&nbsp;</div>
                                    
                                
                                </div>
                            </div>
                        </div>
                        
                        <?php 
						}
						?>
                        
                        
                        
                        <?php 
						if($kpi['status']==4 && cookie('userid')==$kpi['mk_user_id']){
						?>
						<form method="post" action="{:U('Kpi/score')}" name="myform" id="myform">
						<input type="hidden" name="dosubmint" value="1">
						<input type="hidden" name="kpiid" value="{$kpi.id}">
                        <div class="form-group col-md-12" style="text-align:center; margin-top:20px;">
                        {$totalstr}
                        </div>
						<div class="form-group col-md-12" style="text-align:center; margin-top:20px;">
						<button type="submit" class="btn btn-info btn-lg" id="lrpd">确定评分</button>
						</div>
						</form>
						<?php 
						}
						?>
                                    
                        
                        
                        
                        <?php 
						if($kpi['status']==5 && ( cookie('userid')==$kpi['mk_user_id'] || cookie('userid')==$kpi['user_id'] )){
						?>
                        <div class="col-md-12">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">总结</h3>
                                </div>
                                <div class="box-body">
                                	
                                    <form method="post" action="{:U('Kpi/addkpi')}" name="myform" id="myform">
                                    <input type="hidden" name="dosubmint" value="1" />
                                    <input type="hidden" name="com" value="1" />
                                    <input type="hidden" name="editid" value="{$kpi.id}">
                                    
                                    
                                    <div class="form-group col-md-12 " style="margin-top:20px;">
                                    	<textarea class="form-control"  placeholder="请您总结" name="info[summary]" style="height:200px;" >{$kpi.summary}</textarea>
                                    </div>
                                    
                                    <div class="form-group col-md-12" style="text-align:center; margin-top:20px;">
                                    <button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                                    </div>
                                    
                                    </form>
                                    
                                    <div class="form-group">&nbsp;</div>
                                    
                                
                                </div>
                            </div>
                        </div>
                        
                        <?php 
						}
						?>
                        
                    
                    </div>   <!-- /.row -->
                    
                    
                    
                    
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  		</div>
	</div>

	<include file="Index:footer2" />
    
    <script>
    //编辑KPI项目
	function edit_kpi(id) {
		var kpiid = '{$kpi.id}';
		art.dialog.open('index.php?m=Main&c=Kpi&a=editkpi&kpiid='+kpiid+'&id='+id,{
			lock:true,
			title: '新建KPI项目',
			width:1000,
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
	
	//单项评分
	function unitscore(id) {
		art.dialog.open('index.php?m=Main&c=Kpi&a=unitscore&id='+id,{
			lock:true,
			title: 'KPI项目评分',
			width:700,
			height:300,
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
	
	
	 //查看KPI项目
	function kpi(id) {
		art.dialog.open('index.php?m=Main&c=Kpi&a=kpidetail&id='+id,{
			lock:true,
			title: 'KPI项目详情',
			width:1000,
			height:'90%',
			fixed: true,
			
		});	
	}
    
	/*
	$(document).ready(function(e) {
		$('#applycheckbox').find('ins').each(function(index, element) {
			$(this).click(function(){
				if(index==0){
					$('.select_1').show();
					$('.select_2').hide();	
				}else{
					$('.select_2').show();
					$('.select_1').hide();	
				}
			})
		});
	});
	*/
	</script>