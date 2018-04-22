<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h3>增加课程信息</h3>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Op/index')}"><i class="fa fa-gift"></i> 项目计划</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <form method="post" action="{:U('Project/lines_add')}" name="myform" id="myform">
                <input type="hidden" name="dosubmint" value="1">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                                  
                            
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">课程信息</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                    	
                                        <div class="form-group col-md-4">
                                            <label>课程名称：</label><input type="text" name="info[name]" class="form-control" required />
                                        </div>

                                        
                                        <div class="form-group col-md-4">
                                            <label>项目类型：</label>
                                            <select  class="form-control"  name="info[kind_id]" onchange="check_field()" id="k_id" required>
                                                <option value="" selected disabled>请选择项目类型</option>
                                                <foreach name="kinds" item="v">
                                                    <option value="{$v.id}" <?php if ($row && ($v['id'] == $row['kind'])) echo ' selected'; ?> >{:tree_pad($v['level'], true)} {$v.name}</option>
                                                </foreach>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>学科领域：</label>
                                            <select  class="form-control"  name="info[f_id]" id="field">
                                                <option value="" selected disabled>请选择项目类型</option>
                                                <if condition="$row['f_id']">
                                                    <option value="{$row.f_id}" >{$row.fname}</option>
                                                    <else />
                                                    <option value="" selected disabled>请选择学科领域</option>
                                                </if>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>学科分类：</label><input type="text" name="info[type]"  class="form-control" />
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>课时：</label><input type="text" name="info[les_hours]" class="form-control" />
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>课程类型：</label>
                                            <select  name="info[les_type]" class="form-control">
                                                <option value="" selected disabled>请选择课程类型</option>
                                                <foreach name="les_types" key="k"  item="v">
                                                    <option value="{$k}">{$v}</option>
                                                </foreach>
                                            </select>
                                        </div>
                                       
                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                           
                            <div style="width:100%; text-align:center;">
                            <button type="submit" class="btn btn-info btn-lg" id="lrpd">确认添加</button>
                            </div>
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                    </form>
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />

<script type="text/javascript">
    function check_field(){
        var kid = $('#k_id').val();
        $.ajax({
            type:"POST",
            url:"{:U('Ajax/fields')}",
            data:{id:kid},
            success:function(msg){
                if(msg){
                    $("#field").empty();
                    var count = msg.length;
                    var i= 0;
                    var b="";
                    b+='<option value="" disabled selected>请选择学科领域</option>';
                    for(i=0;i<count;i++){
                        b+="<option value='"+msg[i].id+"'>"+msg[i].fname+"</option>";
                    }
                    $("#field").append(b);
                }else{
                    $("#field").empty();
                    var b='<option value="" disabled selected>无学科领域信息</option>';
                    $("#field").append(b);
                }

            }
        })
    }
</script>