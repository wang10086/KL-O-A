		<include file="Index:header2" />
        
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <include file="Index:menu" />

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>新增培训记录</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Cour/pptlist')}">培训记录</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <form method="post" action="{:U('Cour/ppt_add')}" name="myform" id="myform">
                        <input type="hidden" name="dosubmint" value="1" />
                        <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                        <!-- right column -->
                        <div class="col-md-12">
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">新增记录</h3>
                                </div>
                                <div class="box-body" style="padding-top:20px;" id="form_tip">
                                    <!-- text input -->
                                    <div class="form-group col-md-8">
                                        <label>标题</label>
                                        <input type="text" value="" name="info[ppt_title]" id="courtitle"  class="form-control" />
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>课件</label>
                                        <select name="info[cour_id]" class="form-control">
                                        	<option value="0">请选择</option>
                                            <foreach name="courlist" item="v" key="k">
                                            <option value="{$k}">{$v}</option>
                                            </foreach>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>培训日期</label>
                                        <input type="text" value="" name="info[lecture_date]" class="form-control inputdate" />
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>培训地点</label>
                                        <input type="text" value="" name="info[lecture_address]" class="form-control" />
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>听课人数</label>
                                        <input type="text" value="" name="info[number]" class="form-control" />
                                    </div>
                                    
                                    
                                    <div class="form-group col-md-12">
                                        <label>培训描述</label>
                                        <textarea class="form-control" name="info[ppt_content]"></textarea>
                                    </div>
                                    
                                   
                                    <div class="form-group">&nbsp;</div>
                                    {:upload_m('uploadfile','files',$atts,'上传培训照片')}
                                    
                                    <div class="form-group">&nbsp;</div>
                                    <div class="form-group">&nbsp;</div>
                                    
                                    
                                </div>
                            </div><!-- /.box -->
                            
                            <div id="formsbtn">
                            	<button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                            </div>
                            
                        </div><!--/.col (right) -->
                        
                        
                       
                        
                       
                        
                        
                        
                        </form>
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        
        
        <include file="Index:footer2" />
        
		<script type="text/javascript">
		function task_tag(){
			
			var i = parseInt($('#task_tag_val').text())+1;
			
			var html = '<div class="col-md-2 pd" id="tag_'+i+'"><div class="input-group"><input type="text" placeholder="标签" name="tag[]" class="form-control"><span class="input-group-addon" style="width:32px;"><a href="javascript:;"  onClick="deltag(\'tag_'+i+'\')">X</a></span></div></div>';
			
			$('#task_tag_list').append(html);	
			$('#task_tag_val').html(i);
		}
		
		
		function deltag(obj){
			$('#'+obj).remove();
		}
		
		
		
		
		</script>
        
        
        
       