<include file="Index:header2" />

<script type="text/javascript">

</script>

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
                    <form method="post" action="{:U('Worder/worder_edit')}" name="myform" id="myform" onsubmit="return beforeSubmit(this)">
                    <input type="hidden" name="dosubmint" value="1">
                    <input type="hidden" name="id" value="{$id}">
                    <input type="hidden" name="info[op_id]" id="op_id" value="{$row.op_id}">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">工单计划</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                    	
                                        <div class="form-group col-md-8">
                                            <label>工单名称：</label><input type="text" name="info[worder_title]" value="{$row['worder_title']}" class="form-control" />
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>工单类型：</label>
                                            <select  class="form-control"  name="info[worder_type]" id="worder_type" onchange="chechWorderType()" required>
                                            <foreach name="worder_type" key="k" item="v">
                                                <option value="{$k}" <?php if($row['worder_type']==$k){ echo 'selected';} ?>>{$v}</option>
                                            </foreach>
                                            </select> 
                                        </div>

                                        <div class="form-group col-md-12" id="group_id">
                                            <label>项目团号：</label><input type="text" name="info[group_id]" value="{$row.group_id}" class="form-control" onblur="get_opid()" />
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>工单内容：</label><textarea class="form-control"  name="info[worder_content]" >{$row.worder_content}</textarea>
                                        </div>

                                        <div class="form-group col-md-12" id="urgentcheckbox">
                                            <label>工单紧急状态：</label>&#12288;
                                            <input type="radio" name="info[urgent]" value="0" <?php if($row['urgent']==0){ echo 'checked';} ?> > &#12288;一般
                                            &#12288;&#12288;&#12288;
                                            <input type="radio" name="info[urgent]" value="1" <?php if($row['urgent']==1){ echo 'checked';} ?> > &#12288;紧急
                                        </div>

                                        <div class="form-group col-md-12" id="urgent_con" >
                                            <div class="">
                                                <div class="callout callout-danger ">
                                                    <h4>提示！</h4>
                                                    <p>该工单必须由相关领导审核后才能显示紧急状态 ! 每人每月只能发送不超过 3 次紧急工单 !</p>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label>紧急原因 <span style="color: red">(必填)</span>：</label>
                                                <textarea name="info[urgent_cause]"  class="form-control" id="urgent_cause">{$row.urgent_cause}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-12"></div><!--/.col (right) -->

                                        <div class="form-group col-md-12">
                                            <label>工单受理部门：</label>
                                            <input type="hidden" name="info[exe_dept_id]" id="exe_1" value="{$row.exe_dept_id}">
                                            <input type="text" class="form-control keywords_exe" id="keywords_exe1" name="info[exe_dept_name]" value="{$row.exe_dept_name}"  placeholder="请输入执行部门名称"  style="width:100%; margin-right:10px;"/>
                                        </div>

                                        <div class="form-group col-md-12" >&nbsp;</div>

                                        {:upload_m('uploadfile','files',$attr,'上传文件附件')}

                                        <div class="form-group col-md-12" >&nbsp;</div>
                                        <div class="form-group col-md-12" >&nbsp;</div>
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
<!--<script src="__HTML__/js/jquery-1.7.2.min.js"></script>-->

    <script type="text/javascript">
        $(document).ready(function(i){
            $('#urgent_con').hide();
            $('#group_id').hide();

            //单选按钮绑定事件
            $("#urgentcheckbox").find('ins').each(function (index,element) {
                $(this).click(function(){
                    if(index == 1){
                        $("#urgent_con").show()
                    }else{
                        $("#urgent_con").hide()
                        $("#urgent_cause").val('')
                    }
                })
            })

            var worder_type = $('#worder_type').val();
            if(worder_type == 100){
                $("#group_id").show();
            }
        })

        function chechWorderType(){
            var worder_type = $('#worder_type').val();
            if(worder_type == 100){
                $("#group_id").show();
            }else{
                $("#group_id").hide();
                //$("input[name='info[op_id]']").val('');
            }
        }

        function get_opid() {
            var group_id    = $('input[name="info[group_id]"]').val();
            if (!group_id){
                art_show_msg('团号信息不能为空',3);
            }else{
                $.ajax({
                    type: 'POST',
                    dataType: 'JSON',
                    data: {group_id:group_id},
                    url : "{:U('Ajax/get_opid')}",
                    success: function (msg) {
                        if (!msg){
                            art_show_msg('团号输入错误');
                            return false;
                        }else{
                            $('#op_id').val(msg);
                        }
                    }
                });
            }
        }

        //检验表单
        function beforeSubmit(form){
            var urgent = $("input[name=info['urgent']]:checked").val()
            var u_cause= $("#urgent_cause").val();
            var worder_type = $('#worder_type').val();
            var op_id = $("#op_id").val();
            if (urgent==1 && u_cause == ''){
                alert("工单紧急原因不能为空!");
                return false;
            }else if(worder_type == 100 && op_id == ''){
                alert("项目编号信息不能为空!");
                return false;
            }else{
                $("#myform").submit;
            }
        }

        //添加工单执行人
        function task(obj){
            var i = parseInt($('#task_val').text())+1;
            $("#task_ti_"+i+"").show();
            $('#task_val').html(i);
            if (i >= 6){alert("不能再多了!");}
            i+=1;

        }

        //搜索框输入工单执行人
        $(document).ready(function(e){
            var keywords = <?php echo $userkey; ?>;
            $("#keywords_exe1").autocomplete(keywords, {
                matchContains: true,
                highlightItem: false,
                formatItem: function (row, i, max, term) {
                    return row.text;
                },
                formatResult: function (row) {
                    return row.user_name;
                }
            }).result(function (event, item) {
                $("#exe_1").val(item.id);
            });

        })


        //移除题目
        function del_timu(obj){
            $('#'+obj).remove();

        }


    </script>
