<include file="Index:header2" />



            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>审核品质检查</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Kpi/qa')}"><i class="fa fa-gift"></i> 品质检查</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            <!-- general form elements disabled -->
                            <form method="post" action="{:U('Kpi/appqa')}" name="myform" id="myform">
                			<input type="hidden" name="dosubmit" value="1">
                			<input type="hidden" name="editid" value="{$row.id}" >
                            <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">审核品质检查</h3>
                                    <div class="box-tools pull-right"> </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                        <div class="form-group box-float-8">
                                            <label>标题</label> 
                                            <input type="text" name="info[title]" value="{$row.title}" class="form-control" placeholder="如：关于对某某的某原因的奖惩" />
                                        </div>
                                        <div class="form-group box-float-4">
                                            <label>计入绩效月份</label> 
                                            <input type="text" name="info[month]"  value="{$row.month}"  class="form-control monthly"/>
                                        </div>
                                        <div class="form-group box-float-4">
                                            <label>责任人员</label>
                                            <input type="text"   name="info[rp_user_name]" value="{$row.rp_user_name}" class="form-control selectuser" />
                                        </div>
                                        
                                        <div class="form-group box-float-4">
                                            <label>所在部门</label>
                                            <input type="text" name="info[rp_post]" value="{$row.rp_post}"  class="form-control" />
                                        </div>
                                        
                                        <div class="form-group box-float-4">
                                            <label>直接领导</label>
                                            <input type="text" name="info[ld_user_name]" value="{$row.ld_user_name}"  class="form-control selectuser" />
                                        </div>
                                        
                                        
                                        <div class="form-group box-float-4">
                                            <label>发现人员</label>
                                            <input type="text"   name="info[fd_user_name]" value="{$row.fd_user_name}" class="form-control selectuser" />
                                        </div>
                                        
                                        <div class="form-group box-float-4">
                                            <label>发现时间</label>
                                            <input type="text" name="info[fd_date]"  value="{$row.fd_date}"  class="form-control inputdate" />
                                        </div>
                                        
                                        <div class="form-group box-float-4">
                                            <label>陪同人员</label>
                                            <input type="text" name="info[ac_user_name]" value="{$row.ac_user_name}"  class="form-control selectuser" />
                                        </div>
                                        
                                        
                                        <div class="form-group box-float-12">
                                            <label>不合格事实陈述及违反规定条款</label> 
                                            <textarea class="form-control" style="height:90px;" name="info[chen]">{$row.chen}</textarea>
                                        </div>
                                        
                                        <div class="form-group box-float-12">
                                            <label>原因分析</label>
                                            <textarea class="form-control" style="height:90px;" name="info[reason]">{$row.reason}</textarea>
                                        </div>
                                        
                                        <div class="form-group box-float-12">
                                            <label>纠正措施的验证</label>
                                            <textarea class="form-control" style="height:90px;" name="info[verif]">{$row.verif}</textarea>
                                        </div>
	                            	</div>
                              </div><!-- /.box-body -->
                          
                              
                           </div><!-- /.box -->     
                           
                           
                           <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">奖惩实施</h3>
                                </div>
                                <div class="box-body">
                                    <div class="content">
                                    	<div class="content" style="padding-top:0px; margin-top:-20px;"> 
                                            <div id="qaqclist">
                                                <div class="userlist">
                                                    <div class="unitbox us">奖惩人员</div>
                                                    <div class="unitbox">奖惩类型</div>
                                                    <div class="unitbox">分数</div>
                                                    <div class="unitbox bz">备注</div>
                                                </div>
                                                <?php if($userlist){ ?>
                                                <foreach name="userlist" key="k" item="v">
                                                <div class="userlist" id="userlist_{$v.id}">
                                                    <span class="title"><?php echo $k+1; ?></span>
                                                   <input type="text" class="form-control selectuser us" name="qadata[888{$v.id}][user_name]" value="{$v.user_name}">
                                                    <select class="form-control" name="qadata[888{$v.id}][type]">
                                                    	<option value="0" <?php if($v['type']==0){ echo 'selected';} ?>>惩罚</option>
                                                        <option value="1" <?php if($v['type']==1){ echo 'selected';} ?>>奖励</option>
                                                    </select>
                                                    <input type="text" class="form-control" name="qadata[888{$v.id}][score]" value="{$v.score}">
                                                    <input type="text" class="form-control bz" name="qadata[888{$v.id}][remark]" value="{$v.remark}">
                                                    <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('userlist_{$v.id}')">删除</a>
                                                </div>
                                                </foreach>
                                                <?php }else{ ?>
                                                <div class="userlist" id="delone">
                                                    <span class="title">1</span>
                                                    <input type="text" class="form-control selectuser us" name="qadata[0][user_name]" value="">
                                                    <select class="form-control" name="qadata[0][type]">
                                                    	<option value="0">惩罚</option>
                                                        <option value="1">奖励</option>
                                                    </select>
                                                    <input type="text" class="form-control" name="qadata[0][score]" value="">
                                                    <input type="text" class="form-control bz" name="qadata[0][remark]" value="">
                                                    <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('delone')">删除</a>
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <div id="qaqclist_val">1</div>
                                            <div class="form-group col-md-12" id="useraddbtns">
                                                <a href="javascript:;" class="btn btn-success btn-sm" onClick="add_qauser()"><i class="fa fa-fw fa-plus"></i> 新增人员</a> 
                                            </div>
                                            <div class="form-group">&nbsp;</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">审核</h3>
                                </div>
                                <div class="box-body">
                                    
                                    <div class="form-group col-md-12" style="margin-top:10px;">
                                        <div class="checkboxlist" id="applycheckbox" style="margin-top:10px;">
                                        <input type="radio" name="info[status]" value="1" <?php if($row['status']==1){ echo 'checked';} ?> > 通过 &nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" name="info[status]" value="2" <?php if($row['status']==2){ echo 'checked';} ?> > 不通过
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group col-md-12 ">
                                    	<div style="border-top:2px solid #dedede; margin-top:15px; padding-top:20px;">
                                            <label>审核意见</label>
                                            <input type="text" name="info[ex_reason]" class="form-control" value="{$row.ex_reason}" />
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">&nbsp;</div>
                                    
                                </div>
                                
                           </div>
                           
                           <div class="box-footer clearfix">
                                <div style="width:100%; text-align:center;">
	                            <button type="button" class="btn btn-info btn-lg" id="lrpd"  onClick="javascript:ConfirmSub('myform')">保存</button>
	                            </div>
	                            
                              </div>
                             
                          
                        </div><!--/.col (right) -->
                        </form>
                    </div>   <!-- /.row -->
                   
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />
<script type="text/javascript"> 

	$(document).ready(function(e) {
        selectuser();
		
    });
	
	function selectuser(){
		var keywords = <?php echo $userkey; ?>;	
		$('.selectuser').autocomplete(keywords, {
			 matchContains: true,
			 highlightItem: false,
			 formatItem: function(row, i, max, term) {
				 return '<span style=" display:none">'+row.pinyin+'</span>'+row.text;
			 },
			 formatResult: function(row) {
				 return row.user_name;
			 }
		}).result(function(event, item) {
		   
		});	
	}
	
	//新增奖惩人员
	function add_qauser(){
		var i = parseInt($('#qaqclist_val').text())+1;

		var html  = '<div class="userlist" id="qauser_'+i+'">';
		    html += '<span class="title"></span>';
			html += '<input type="text" class="form-control selectuser us" name="qadata['+i+'][user_name]" value="">';
            html += '<select class="form-control" name="qadata['+i+'][type]"><option value="0">惩罚</option><option value="1">奖励</option></select>';
            html += '<input type="text" class="form-control" name="qadata['+i+'][score]" value="">';
            html += '<input type="text" class="form-control bz" name="qadata['+i+'][remark]" value="">';
			html += '<a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'qauser_'+i+'\')">删除</a></div>';
		
		$('#qaqclist').append(html);	
		$('#qaqclist_val').html(i);
		orderno();
		selectuser();
		laydate.render({
			elem: '.monthly',type: 'month',format: 'yyyyMM'
		});
	}
	
	//编号
	function orderno(){
		$('#qaqclist').find('.title').each(function(index, element) {
            $(this).text(parseInt(index)+1);
        });
	}
	
	//移除
	function delbox(obj){
		$('#'+obj).remove();
		orderno();
	}
	
</script>	



