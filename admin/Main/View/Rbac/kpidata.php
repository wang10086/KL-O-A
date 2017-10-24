		<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$year}年度KPI任务 【{$user.nickname}】</h1>
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
                            
                                  
                            <div class="btn-group" id="catfont" style="padding-bottom:20px;">
                            	<a href="{:U('Rbac/kpi_data',array('year'=>$prveyear,'uid'=>$uid))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
								<?php 
                                for($i=1;$i<13;$i++){
                                    $par = array();
                                    $par['year']  = $year;
                                    $par['month'] = $i;
									$par['uid']   = $uid;
                                    if($month==$i){
                                        echo '<a href="'.U('Rbac/kpi_data',$par).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'月</a>';
                                    }else{
                                        echo '<a href="'.U('Rbac/kpi_data',$par).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                                    }
                                }
                                ?>
                                <a href="{:U('Rbac/kpi_data',array('year'=>$nextyear,'uid'=>$uid))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                            </div>
                                    
                            
                            <form method="post" action="{:U('Rbac/save_kpi_data')}" name="myform" id="myform">
                            <input type="hidden" name="dosubmint" value="1">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">考核指标</h3>
                                    <div class="box-tools pull-right">
                                    	
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                    	<span class="rtxt" style="margin-top:-10px;">
                                        月份：{$year}-{$month} &nbsp;&nbsp;&nbsp;&nbsp;
                                        被考核人：{$user.nickname} &nbsp;&nbsp;&nbsp;&nbsp;
                                        所属岗位：{$user.postname}
                                        </span> 
                                        
                                        <a href="{:u('Kpi/addkpi',array('year'=>$year,'uid'=>$uid))}" class="btn btn-danger btn-sm" style="float:right;"><i class="fa fa-fw  fa-refresh"></i> 获取全年指标</a> 
                                        
                                        <a href="{:u('Kpi/addkpi',array('year'=>$year,'month'=>$month,'uid'=>$uid))}" class="btn btn-success btn-sm" style="float:right; margin-right:10px;"><i class="fa fa-fw  fa-refresh"></i> 获取本月指标</a> 
                                        
                                        <div class="box-body table-responsive no-padding">
                                        <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                            <tr role="row" class="orders" >
                                                <th width="50">序号</th>
                                                <th>指标名称</th>
                                                <th width="140">考核开始</th>
                                                <th width="140">考核结束</th>
                                                <th width="100">目标</th>
                                                <th width="100">权重</th>
                                                <th width="50" class="taskOptions">删除</th>
                                            </tr>
                                            <foreach name="lists" key="key" item="row"> 
                                            <tr>
                                                <td style="line-height:34px;" align="center"><?php echo $key+1; ?></td>
                                                <td style="line-height:34px;"><a href="javascript:;" onClick="kpi({$row.quota_id})">{$row.quota_title}</a></td>
                                                <td><input type="text" class="form-control" name="info[{$row.id}][start_date]" value="{$row.start_date|date='Y-m-d',###}"></td>
                                                <td><input type="text" class="form-control" name="info[{$row.id}][end_date]" value="{$row.end_date|date='Y-m-d',###}"></td>
                                                <td><input type="text" class="form-control" name="info[{$row.id}][target]" value="{$row.target}"></td>
                                                <td><input type="text" class="form-control" name="info[{$row.id}][weight]" value="{$row.weight}"></td>
                                                <td   style="line-height:34px;" class="taskOptions">
                                                <a href="javascript:;" onClick="javascript:ConfirmDel('{:U('Rbac/del_kpi_data',array('id'=>$row['id']))}','您真的要删除此项KPI考核？')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></a>
                                                </td>
                                                
                                            </tr>
                                            </foreach>					
                                        </table> 
                                        
                                        </div>
                                        
                                        <div class="form-group">&nbsp;</div>
                                       
                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!--/.col (right) -->
                        
                        
                        <div class="col-md-12">
                            <div class="box box-warning">
                                <div class="box-body">
                                	
                                    <if condition="rolemenu(array('Rbac/save_kpi_data'))">
									<div class="form-group col-md-12" style="text-align:center; margin-top:20px;">
									<button type="submit" class="btn btn-info btn-lg" id="lrpd">保存数据</button>
									</div>
                                	</if>
                                    
                        
                           
                                    <div class="form-group col-md-12" id="apptab" style="margin-top:40px;">
                                        <div class="box-body no-padding">
                                            <table class="table">
                                                <tr>
                                                    <th width="150">配置时间</th>
                                                    <th width="150">操作者</th>
                                                    <th>备注</th>
                                                </tr>
                                                <foreach name="applist" key="k" item="v">
                                                <tr>
                                                	<td><if condition="$v['op_time']">{$v.op_time|date='Y-m-d H:i',###}</if></td>
                                                    <td>{$v.op_user_name}</td>
                                                    <td>{$v.remarks}</td>
                                                </tr>
                                                </foreach>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">&nbsp;</div>
                                    
                                
                                </div>
                            </div>
                        </div>
                        
                       
                        
                        
                        </form>
                        
                                    
                        
                        
                        
                       
                        
                    
                    </div>   <!-- /.row -->
                    
                    
                    
                    
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  		</div>
	</div>

	<include file="Index:footer2" />
    
    <script>
    //编辑KPI指标
	function edit_kpi(id) {
		var kpiid = '{$kpi.id}';
		art.dialog.open('index.php?m=Main&c=Kpi&a=editkpi&kpiid='+kpiid+'&id='+id,{
			lock:true,
			title: '新建KPI指标',
			width:1000,
			height:400,
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
		art.dialog.open('index.php?m=Main&c=Kpi&a=kpi_unitscore&id='+id,{
			lock:true,
			title: 'KPI指标评分',
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
	
	
	 //查看KPI指标
	function kpi(id) {
		art.dialog.open('index.php?m=Main&c=Kpi&a=kpidetail&id='+id,{
			lock:true,
			title: 'KPI指标详情',
			width:800,
			height:400,
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