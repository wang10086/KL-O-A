<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>编辑工作记录</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Work/record')}"><i class="fa fa-gift"></i> 工作记录</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <form method="post" action="{:U('Work/addrecord')}" name="myform" id="myform">
                	<input type="hidden" name="dosubmint" value="1">
                    <input type="hidden" name="recid" value="{$rec.id}">
                    <input type="hidden" name="info[user_id]" id="user_id" value="{$rec.user_id}">
                    <input type="hidden" name="info[dept_id]" id="dept_id" value="{$rec.dept_id}">
                    <input type="hidden" name="info[dept_name]" id="dept_name" value="{$rec.dept_name}">
                    <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">编辑工作记录</h3>
                                </div>
                                <div class="box-body">
                                    <div class="content">
                                    	<div class="form-group col-md-12">
                                            <div class="callout callout-danger">
                                                <h4>提示！</h4>
                                                <p>在记录前请务必跟当事人员核实，记录如果有误请您及时撤销，以免影响当事人绩效考核</p>
                                            </div>
                                        </div>
                                    
                                        <div class="form-group col-md-4">
                                            <label>工作人员：</label><input type="text" name="info[user_name]" class="form-control keywords_user"  value="{$rec.user_name}" />
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>工作月份：</label><input type="text" name="info[month]" class="form-control monthly"  value="{$rec.month}" />
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>记录类型：</label>
                                            <select class="form-control" name="info[type]">
                                            	<option value="0">请选择</option>
                                            	<foreach name="kinds" item="v" key="k">
                                            	<option value="{$k}" <?php if($k==$rec['type']){ echo 'selected';} ?> >{$v}</option>
                                                </foreach>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>记录标题：</label><input type="text" name="info[title]" class="form-control" value="{$rec.title}" />
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>具体内容：</label>
                                            <textarea name="info[content]"  class="form-control">{$rec.content}</textarea>
                                        </div>
                                        
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
		
	})
	
</script>
		