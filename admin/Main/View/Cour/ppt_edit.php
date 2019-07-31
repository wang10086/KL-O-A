		<include file="Index:header2" />
        
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <include file="Index:menu" />

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>修改培训记录</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Cour/pptlist')}">培训记录</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <form method="post" action="{:U('Cour/ppt_edit')}" name="myform" id="myform" onsubmit="return check_myform()">
                        <input type="hidden" name="dosubmint" value="1" />
                        <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                        <input type="hidden" name="ppt_id" value="{$row.id}" />
                        <!-- right column -->
                        <div class="col-md-12">
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">修改记录</h3>
                                </div>
                                <div class="box-body" style="padding-top:20px;">
                                    
                                    
                                    <!-- text input -->
                                    <div class="form-group col-md-12">
                                        <label>标题</label>
                                        <input type="text" name="info[ppt_title]" value="{$row.ppt_title}"  class="form-control" />
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>课件</label>
                                        <select name="info[cour_id]" class="form-control">
                                        	<option value="0">请选择</option>
                                            <foreach name="courlist" item="v" key="k">
                                            <option value="{$k}"  <?php if($row['cour_id']==$k){ echo 'selected';} ?> >{$v}</option>
                                            </foreach>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>性质</label>
                                        <select name="info[type]" class="form-control" onchange="check_ctype($(this).val())" required>
                                            <option value="1" <?php if ($row['type']==1){ echo "selected"; } ?>>团内培训</option>
                                            <option value="2" <?php if ($row['type']==2){ echo "selected"; } ?>>非团培训</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4" id="typeDiv">
                                        <label>团号</label>
                                        <input type="text" value="{$row['group_id']}" name="info[group_id]" id="group_id" onblur="check_cour($(this).val())"  class="form-control" required />
                                        <input type="hidden" value="{$row['op_id']}" name="info[op_id]" id="opid"  class="form-control"/>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>培训日期</label>
                                        <input type="text" name="info[lecture_date]" class="form-control inputdate"  value="<?php echo $row['lecture_date'] ? date('Y-m-d',$row['lecture_date']) : ''; ?>"/>
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>培训地点</label>
                                        <input type="text" name="info[lecture_address]" class="form-control" value="{$row.lecture_address}" />
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>听课人数</label>
                                        <input type="text" name="info[number]" class="form-control" value="{$row.number}"/>
                                    </div>
                                    
                                    
                                    <div class="form-group col-md-12">
                                        <label>培训描述</label>
                                        <textarea class="form-control" name="info[ppt_content]">{$row.ppt_content}</textarea>
                                    </div>
                                    
                                    
                                    <div class="form-group">&nbsp;</div>
                                    {:upload_m('uploadfile','files',$atts,'上传培训照片')}
                                    
                                    <div class="form-group">&nbsp;</div>
                                    <div class="form-group">&nbsp;</div>
                                </div><!-- /.box-body -->
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
            $(function () {
                var type            = {$row['type']};
                if (type == 2){
                    var uname_html  = '<label>讲师</label> <input type="text" value="{:session('nickname')}" name="info[lecturer_uname]"  class="form-control" readonly />';
                    $('#typeDiv').html(uname_html)
                }
            })

		function task_tag(){
			var i = parseInt($('#task_tag_val').text())+1;
			var html = '<div class="col-md-2 pd" id="tag_'+i+'"><div class="input-group"><input type="text" placeholder="标签" name="tag[]" class="form-control"><span class="input-group-addon" style="width:32px;"><a href="javascript:;"  onClick="deltag(\'tag_'+i+'\')">X</a></span></div></div>';
			$('#task_tag_list').append(html);	
			$('#task_tag_val').html(i);
		}

		function deltag(obj){
			$('#'+obj).remove();
		}

        function check_ctype(type) {
            var group_html = '<label>团号</label> <input type="text" value="{$row[group_id]}" name="info[group_id]" id="group_id" onblur="check_cour($(this).val())" class="form-control" required /> <input type="hidden" value="{$row[op_id]}" name="info[op_id]" id="opid"  class="form-control"/>';
            var uname_html = '<label>讲师</label> <input type="text" value="{:session('nickname')}" name="info[lecturer_uname]"  class="form-control" readonly />'
            if (type == 1){ //团内
                $('#typeDiv').html(group_html);
            }else{
                $('#typeDiv').html(uname_html);
            }
        }

        function check_cour(group_id) {
            var userid          = {:session('userid')};
            if (group_id){
                $.ajax({
                    type: 'POST',
                    url : "{:U('Ajax/get_cour_info')}",
                    data: {group_id:group_id,userid:userid},
                    dateType: 'JSON',
                    success: function (data) {
                        console.log(data);
                        if (data.num==1){
                            $('#opid').val(data.opid);
                        }else{
                            art_show_msg(data.msg,2);
                            return false;
                        }
                    }
                })
            }else{
                art_show_msg('请输入团号信息',2);
                return false;
            }
        }

        function check_myform(){
            var title           = $('#courtitle').val().trim();
            var type            = $('select[name="info[type]"]').val();
            var opid            = $('#opid').val();
            if (!title){ art_show_msg('培训标题不能为空',2); return false; }
            if (type==1 && !opid){ art_show_msg('团号信息输入有误',2); return false; }
            $('#myform').submit();
        }
	
		
			
		</script>