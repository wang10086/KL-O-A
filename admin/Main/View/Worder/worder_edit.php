<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>修改工单</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> 工单计划</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <form method="post" action="{:U('Worder/worder_edit')}" name="myform" id="myform">
                <input type="hidden" name="dosubmint" value="1">
                <input type="hidden" name="id" value="{$id}">
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
                                            <label>工单名称：</label><input type="text" name="info[worder_title]" value="{$row['worder_title']}" class="form-control" />
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>工单内容：</label><textarea class="form-control"  name="info[worder_content]">{$row['worder_content']}</textarea>
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>工单类型：</label>
                                            <select  class="form-control"  name="info[worder_type]" required>
                                            <foreach name="worder_type" key="k" item="v">
                                                <option value="{$k}" <?php if($row && ($row['worder_type'] == $k)){echo 'selected';} ?>>{$v}</option>
                                            </foreach>
                                            </select> 
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>发起人员：</label>
                                            <input type="text" class="form-control" name="info[ini_user_name]" value="{:session('nickname')}" readonly>
                                        </div>

                                        <div class="form-group col-md-12"></div>

                                        <div class="form-group col-md-6">
                                            <label>工单受理部门：</label>
                                            <input type="hidden" name="info[exe_dept_id]" value="{$row['exe_dept_id']}" id="exe_dept_id">
                                            <input type="text" class="form-control" name="info[exe_dept_name]" value="{$row['exe_dept_name']}" onfocus="dept_name()" id="exe_dept" />
                                        </div>

                                        <div class="form-group col-md-12" ></div>


                                        <div class="form-group col-md-12">
                                            <h2 style="font-size:16px; color:#ff3300; border-bottom:2px solid #dedede; padding-bottom:10px;">工单相关文件</h2>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>上传文件附件：</label>
                                            {:upload_m('uploadfile','files',$atts,'上传文件附件')}
                                        </div>

                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->


                            <div style="width:100%; text-align:center;">
                            <button type="submit" class="btn btn-info btn-lg" id="lrpd">修改工单</button>
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
        //搜索框输入工单执行人
        $(document).ready(function(e){
            var keywords = <?php echo $userkey; ?>;
            $("#exe_dept").autocomplete(keywords, {
                matchContains: true,
                highlightItem: false,
                formatItem: function(row, i, max, term) {
                    return row.text;
                },
                formatResult: function(row) {
                    return row.role_name;
                }
            }).result(function(event, item) {
                $('#exe_dept_id').val(item.id);
            });
        })


    </script>
