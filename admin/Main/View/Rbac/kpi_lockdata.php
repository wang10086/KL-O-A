<include file="Index:header2" />



            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>锁定KPI数据</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li class="active">锁定KPI数据</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            <!-- general form elements disabled -->
                            <form method="post" action="{:U('Rbac/kpi_lockdata')}" name="myform" id="myform">   
                            <input type="hidden" name="dosubmit" value="1" />
                            <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">锁定KPI数据</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body" id="tab_1">
                                    
                                    <div class="form-group col-md-6">
                                        <label>锁定月份</label>
                                        <input type="text" name="month" class="form-control monthly" placeholder="月份"/>
                                    	
                                    </div>
                                    
                                    <div class="form-group col-md-6">
                                        <label>锁定类型</label>
                                        <select class="form-control" name="type" onChange="taguser(this)">
                                        	<option value="0">全部人员</option>
                                            <option value="1">指定人员</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-md-12" id="kpiname" style="display:none;">
                                        <label>考核人员</label>
                                        <input type="text" name="uname" class="form-control keywords_bkpr" placeholder="被考评人"/>
                                        <input type="hidden" name="uid" id="bkpr" value="0">
                                    </div>
                                    
                                   
                                    <div class="form-group">&nbsp;</div>
                                        
									<div id="formsbtn">
                                        <button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                                    </div>
                                    
                                    <div class="form-group">&nbsp;</div>
                                    <div class="form-group">&nbsp;</div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                            </form>
                            
                            
                            <div class="box box-warning" style="margin-top:15px;">
                                    <div class="box-header">
                                        <h3 class="box-title">锁定记录</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="content" style="padding:10px 30px;">
                                            <table rules="none" border="0">
                                            	<tr>
                                                	<th style="border-bottom:2px solid #06E0F3; font-weight:bold;" width="160">操作时间</th>
                                                    <th style="border-bottom:2px solid #06E0F3; font-weight:bold;" width="100">操作人</th>
                                                    <th style="border-bottom:2px solid #06E0F3; font-weight:bold;" width="500">操作说明</th>
                                                </tr>
                                                <foreach name="record" item="v">
                                                <tr>
                                                	<td style="padding:20px 0 0 0">{$v.op_time|date='Y-m-d H:i:s',###}</td>
                                                    <td style="padding:20px 0 0 0">{$v.op_uname}</td>
                                                    <td style="padding:20px 0 0 0">{$v.remarks}</td>
                                                </tr>
                                                </foreach>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->

  </div>
</div>

<script>
	function taguser(obj){
		var type = $(obj).val();
		if(type==1){
			$('#kpiname').show();
		}else{
			$('#kpiname').hide();	
		}
	}
	
	
	$(document).ready(function(e) {
		var keywords = <?php echo $userkey; ?>;
		
		$(".keywords_bkpr").autocomplete(keywords, {
			 matchContains: true,
			 highlightItem: false,
			 formatItem: function(row, i, max, term) {
				 return '<span style=" display:none">'+row.pinyin+'</span>'+row.text;
			 },
			 formatResult: function(row) {
				 return row.user_name;
			 }
		}).result(function(event, item) {
		   $('#bkpr').val(item.id);
		});
		
	})
	
</script>


<include file="Index:footer2" />
 