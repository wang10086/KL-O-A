<include file="Index:header2" />

<style>
    .exe_worder{width: 300px;height: 34px;border-color: #DDDDDD;}
</style>

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>发起工单</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> 工单计划</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <form method="post" action="{:U('Worder/new_worder')}" name="myform" id="myform">
                <input type="hidden" name="dosubmint" value="1">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                                  
                            
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">工单计划</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                    	
                                        <div class="form-group col-md-12">
                                            <label>工单名称：</label><input type="text" name="info[worder_title]" class="form-control" />
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>工单内容：</label><textarea class="form-control"  name="info[worder_content]"></textarea>
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>工单类型：</label>
                                            <select  class="form-control"  name="info[worder_type]" required>
                                            <foreach name="worder_type" key="k" item="v">
                                                <option value="{$k}">{$v}</option>
                                            </foreach>
                                            </select> 
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>发起人员：</label>
                                            <input type="text" class="form-control" name="info[ini_user_name]" value="{:session('nickname')}" readonly>
                                        </div>

                                        <!--<div class="form-group col-md-4">
                                            <label>工单优先级：</label>
                                            <select  class="form-control"  name="info[kind]" required>
                                                <foreach name="worder_type" key="key" item="value">
                                                    <option value="{$key}">{$value}</option>
                                                </foreach>
                                            </select>
                                        </div>-->

                                        <div class="form-group col-md-12"></div>
                                        <div class="form-group col-md-12">
                                            <label>工单受理组/人：</label>&#12288;
                                            <select name="info[exe_dept_id]" id="group" onchange="check_group()" class="exe_worder">
                                                <option value="" disabled selected>请选择受理组</option>
                                                <foreach name="group" item="v">
                                                    <option value="{$v.id}">{:tree_pad($v['level'])}{$v.role_name}</option>
                                                </foreach>
                                            </select>
                                            <select name="info[exe_user_id]" id="member" class="exe_worder">
                                                <option value="" disabled selected>请选择员工姓名</option>

                                            </select>
                                        </div>

                                        <div class="form-group col-md-12"></div>

                                        <div class="form-group col-md-12">
                                            <label>上传文件附件：</label>
                                            {:upload_m('uploadfile','files',$attr,'上传文件附件')}
                                        </div>

                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                           
                            <div style="width:100%; text-align:center;">
                            <button type="submit" class="btn btn-info btn-lg" id="lrpd">发起工单</button>
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
            function check_group(){
                var id = $('#group').val();
                $.ajax({
                    type:"POST",
                    url:"{:U('Worder/member')}",
                    data:{id:id},
                    success:function(msg){
                        $("#member").empty();
                        var count = msg.length;
                        var i= 0;
                        var b="";
                        for(i=0;i<count;i++){
                            b+="<option value='"+msg[i].id+"'>"+msg[i].nickname+"</option>";
                        }
                        $("#member").append(b);
                    }
                })

            }

        </script>
