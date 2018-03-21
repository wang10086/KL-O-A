<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>新建巡检记录</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Inspect/record')}"><i class="fa fa-gift"></i> 巡检记录</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <form method="post" action="{:U('Inspect/edit_ins')}" name="myform" id="myform">
                	<input type="hidden" name="dosubmint" value="1">
                    <input type="hidden" name="insid" value="{$row.id}">
                    <input type="hidden" name="info[liable_uid]" id="user_id" value="{$rec.user_id}">
                    <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">编辑巡检记录</h3>
                                </div>
                                <div class="box-body">
                                    <div class="content">
                                    
                                    	<!--
                                    	<div class="form-group col-md-12">
                                            <div class="callout callout-danger">
                                                <h4>提示！</h4>
                                                <p>在记录前请务必跟当事人员核实，记录如果有误请您及时撤销，以免影响当事人绩效考核</p>
                                            </div>
                                        </div>
                                        -->
                                    
                                        
                                        <div class="form-group col-md-3">
                                            <label>巡检日期：</label><input type="text" name="info[ins_date]" class="form-control inputdate"  value="<?php if($row['ins_date']){ echo date('Y-m-d',$row['ins_date']);} ?>" />
                                        </div>
                                        
                                        <div class="form-group col-md-3">
                                            <label>巡检类型：</label>
                                            <select class="form-control" name="info[type]" onChange="selectkinds(this)">
                                            	<foreach name="type" item="v" key="k">
                                            	<option value="{$k}" <?php if($k==$row['type']){ echo 'selected';} ?> >{$v}</option>
                                                </foreach>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-md-3 ins_bus" <?php if($row['type']==2){ echo ' style="display:none;"';} ?> >
                                            <label>项目团号：</label><input type="text" name="info[group_id]" class="form-control"  value="{$row.group_id}" />
                                        </div>
                                        
                                        <div class="form-group col-md-3 ins_dept" <?php if($row['type']==1 || !$row){ echo ' style="display:none;"';} ?>>
                                            <label>巡检部门：</label>
                                            <select class="form-control" name="info[ins_dept_id]">
                                            	<option value="0">请选择</option>
                                            	<foreach name="deptlist" item="v" key="k">
                                            	<option value="{$k}" <?php if($k==$row['ins_dept_id']){ echo 'selected';} ?> >{$v}</option>
                                                </foreach>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-md-3">
                                            <label>业务或部门负责人：</label><input type="text" name="info[liable_uname]" class="form-control keywords_user"  value="{$row.liable_uname}" />
                                        </div>
                                        
                                        
                                        <div class="form-group col-md-12">
                                            <label>巡检标题：</label><input type="text" name="info[title]" class="form-control" value="{$row.title}" />
                                        </div>
                                        
                                        <div class="form-group col-md-12">
                                            <label>巡检内容：</label>
                                            <textarea name="info[content]"  class="form-control" style="height:100px;">{$row.content}</textarea>
                                        </div>
                                        
                                        <div class="form-group col-md-12" style="margin-top:15px;">
                                            <div class="checkboxlist" id="problemcheckbox">
                                            <input type="radio" name="info[problem]" value="0" <?php if($row['problem']==0){ echo 'checked';} ?> > 未发现问题
                                            &nbsp;&nbsp;
                                            <input type="radio" name="info[problem]" value="1" <?php if($row['problem']==1){ echo 'checked';} ?> > 已发现问题 
                                            </div>
                                        </div>
                            
                                        <div class="form-group col-md-12 problembox" <?php if($row['problem']==0){ echo ' style="display:none;"';} ?>>
                                            <textarea name="info[problem_desc]"  class="form-control" placeholder="问题描述" style="height:100px;">{$row.problem_desc}</textarea>
                                        </div>
                                        
                                        <div class="form-group col-md-12 problembox" style="margin-top:15px;<?php if($row['problem']==0){ echo ' display:none;';} ?>">
                                            <div class="checkboxlist" id="issolvecheckbox">
                                            <input type="radio" name="info[issolve]" value="0" <?php if($row['issolve']==0){ echo 'checked';} ?> > 问题未解决
                                            &nbsp;&nbsp;
                                            <input type="radio" name="info[issolve]" value="1" <?php if($row['issolve']==1){ echo 'checked';} ?> > 问题已解决 
                                            </div>
                                        </div>
                            
                                        <div class="form-group col-md-12 problembox issolvebox" <?php if($row['problem']==0){ echo ' style="display:none;"';} ?>>
                                            <textarea name="info[resolvent]"  class="form-control"  placeholder="解决方案" style="height:100px;">{$row.resolvent}</textarea>
                                        </div>
                                        
                                        <div class="form-group">&nbsp;</div>
                                        {:upload_m('uploadfile','files',$atts,'上传巡检资料')}
                                        
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div style="width:100%; text-align:center; margin-top:30px;">
                            <button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                            </div>
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                    </form>
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />

<script>
	$(document).ready(function(e) {
		
		
		var keywords = <?php echo $userkey; ?>;
		
		$(".keywords_user").autocomplete(keywords, {
			 matchContains: true,
			 highlightItem: false,
			 formatItem: function(row, i, max, term) {
				 return '<span style=" display:none">'+row.pinyin+'</span>'+row.text;
			 },
			 formatResult: function(row) {
				 return row.user_name;
			 }
		}).result(function(event, item) {
		   $('#user_id').val(item.id);
		   $('#dept_id').val(item.role);
		   $('#dept_name').val(item.role_name);
		});
		
	
		$('#problemcheckbox').find('ins').each(function(index, element) {
			$(this).click(function(){
				if(index==0){
					$('.problembox').hide();
				}else{
					$('.problembox').show();
				}
			})
		});
		
		/*
		$('#issolvecheckbox').find('ins').each(function(index, element) {
			$(this).click(function(){
				if(index==0){
					$('.issolvebox').hide();
				}else{
					$('.issolvebox').show();
				}
			})
		});
		*/
	});
       
        
	
	function selectkinds(obj){
		var k = $(obj).val();
		if(k==1){
			$('.ins_bus').show();
			$('.ins_dept').hide();
		}else{
			$('.ins_bus').hide();
			$('.ins_dept').show();
		}
	}
	
	
	
	
</script>
		