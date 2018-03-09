<include file="Index:header2" />

<style>
    .exe_worder{width: 300px; height: 34px;}
</style>

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>执行工单</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> 工单计划</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <form method="post" action="{:U('Worder/exe_worder')}" name="myform" id="myform">
                <input type="hidden" name="dosubmint" value="1">
                <input type="hidden" name="id" value="{$id}">
                <input type="hidden" name="ini_user_id" value="{$data[ini_user_id]}">
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
                                            <label>工单名称：</label><input type="text" value="{$data[worder_title]}" class="form-control" readonly />
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>工单内容：</label><textarea class="form-control" readonly>{$data.worder_content}</textarea>
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>工单类型：</label>
                                            <input type="text" class="form-control" value="{$data['type']}" readonly>
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>工单申请时间：</label>
                                            <input type="text" class="form-control" value="{$data.create_time|date='Y-m-d H:i:s',###}" readonly>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>工单发起人所在部门：</label>
                                            <input type="text" class="form-control" value="{$data.ini_dept_name}" readonly>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>工单发起人姓名：</label>
                                            <input type="text" class="form-control" value="{$data.ini_user_name}" readonly>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <!--<label >相关文件：</label>-->
                                            <h2 style="font-size:14px;  border-bottom:2px solid #dedede; padding-bottom:10px;">相关文件</h2>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <div id="showimglist">
                                                <foreach name="atts" key="k" item="v">
                                                    <?php if(isimg($v['filepath'])){ ?>
                                                        <a href="{$v.filepath}" target="_blank"><div class="fileext"><?php echo isimg($v['filepath']); ?></div></a>
                                                    <?php }else{ ?>
                                                        <a href="{$v.filepath}" target="_blank"><img src="{:thumb($v['filepath'],100,100)}" style="margin-right:15px; margin-top:15px;"></a>
                                                    <?php } ?>
                                                </foreach>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>执行意见:</label>
                                            <textarea class="form-control" name="exe_complete_content"></textarea>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <input type="checkbox" class="form-control" name="refuse" value="-1" >&#12288;
                                            <label>拒绝该工单(如果有异议,可勾选此选项拒绝该工单)</label>
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
                            <button type="submit" class="btn btn-info btn-lg" id="lrpd">执行工单</button>
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
