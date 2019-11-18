<include file="Index:header2" />

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
        <form method="post" action="{:U('Worder/new_worder')}" name="myform" id="myform" onsubmit="return beforeSubmit(this)">
        <input type="hidden" name="dosubmint" value="1">
        <input type="hidden" name="info[op_id]" id="op_id">
            <div class="row">
                 <!-- right column -->
                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-header">
                            <h3 class="box-title">工单计划</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="content">

                                <div class="form-group col-md-8">
                                    <label>工单名称：</label><input type="text" name="info[worder_title]" value="{$data.project}" class="form-control" />
                                </div>

                                <div class="form-group col-md-4">
                                    <label>工单类型：</label>
                                    <select  class="form-control"  name="info[worder_type]" id="worder_type" onchange="chechWorderType()" required>
                                        <option value="">===请选择=</option>
                                    <foreach name="worder_type" key="k" item="v">
                                        <option value="{$k}">{$v}</option>
                                    </foreach>
                                    </select>
                                </div>

                                <div class="form-group col-md-12" id="group_id">
                                    <label>项目团号：</label><input type="text" name="info[group_id]" value="{$data.group_id}" class="form-control" onblur="get_opid()" />
                                </div>

                                <div class="form-group col-md-12">
                                    <label>工单内容：</label><textarea class="form-control"  name="info[worder_content]" >{$data.context}</textarea>
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
                                        <textarea name="info[urgent_cause]"  class="form-control" id="urgent_cause"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12"></div><!--/.col (right) -->
                                <div class="form-group col-md-12" ></div>

                                {:upload_m('uploadfile','files',$attr,'上传文件附件')}

                            </div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->


                    <div class="box box-success">
                        <div class="box-header">
                            <h3 class="box-title">工单受理部门</h3>
                        </div>
                        <div class="box-body" style="padding-top:20px;">
                            <div class="content">
                                <div class="form-group col-md-12" id="addti_btn">
                                    <a href="javascript:;" class="btn btn-success btn-sm" onClick="task(1)" style="margin-right:10px;"><i class="fa fa-fw  fa-plus"></i> 添加工单受理部门</a>
                                </div>

                                <div class="tasklist worder_box" id="task_ti_1" >

                                    <div class="col-md-12">
                                        <input type="hidden" name="exe_info[1][exe_dept_id]" id="exe_1" value="">
                                        <input type="text" class="form-control keywords_exe" id="keywords_exe1" name="exe_info[1][exe_dept_name]"  placeholder="请输入执行部门名称"  style="width:100%; margin-right:10px;"/>
                                    </div>
                                </div>

                                <div class="tasklist worder_box" id="task_ti_2">
                                    <a class="worder_close" href="javascript:;" onClick="del_timu('task_ti_2')">×</a>

                                    <div class="col-md-12">
                                        <input type="hidden" name="exe_info[2][exe_dept_id]" id="exe_2" value="">
                                        <input type="text" class="form-control keywords_exe" id="keywords_exe2" name="exe_info[2][exe_dept_name]"  placeholder="请输入执行部门名称"  style="width:100%; margin-right:10px;"/>
                                    </div>
                                </div>

                                <div class="tasklist worder_box" id="task_ti_3">
                                    <a class="worder_close" href="javascript:;" onClick="del_timu('task_ti_3')" >×</a>
                                    <div class="col-md-12">
                                        <input type="hidden" name="exe_info[3][exe_dept_id]" id="exe_3" value="">
                                        <input type="text" class="form-control keywords_exe" id="keywords_exe3" name="exe_info[3][exe_dept_name]"  placeholder="请输入执行部门名称"  style="width:100%; margin-right:10px;"/>
                                    </div>
                                </div>

                                <div class="tasklist worder_box" id="task_ti_4" >
                                    <a class="worder_close" href="javascript:;"  onClick="del_timu('task_ti_4')">×</a>
                                    <div class="col-md-12">
                                        <input type="hidden" name="exe_info[4][exe_dept_id]" id="exe_4" value="">
                                        <input type="text" class="form-control keywords_exe" id="keywords_exe4" name="exe_info[4][exe_dept_name]"  placeholder="请输入执行部门名称"  style="width:100%; margin-right:10px;"/>
                                    </div>
                                </div>

                                <div class="tasklist worder_box" id="task_ti_5"  >
                                    <a class="worder_close" href="javascript:;" onClick="del_timu('task_ti_5')">×</a>
                                    <div class="col-md-12">
                                        <input type="hidden" name="exe_info[5][exe_dept_id]" id="exe_5" value="">
                                        <input type="text" class="form-control keywords_exe" id="keywords_exe5" name="exe_info[5][exe_dept_name]"  placeholder="请输入执行部门名称"  style="width:100%; margin-right:10px;"/>
                                    </div>
                                </div>

                                <div style="display:none" id="task_val">1</div>

                                <div id="daysbox"></div>
                                <div class="form-group">&nbsp;</div>
                                <div class="form-group">&nbsp;</div>
                            </div>
                        </div>
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
<!--<script src="__HTML__/js/jquery-1.7.2.min.js"></script>-->

    <script type="text/javascript">
        $(document).ready(function(i){
            $('#task_ti_2').hide();
            $('#task_ti_3').hide();
            $('#task_ti_4').hide();
            $('#task_ti_5').hide();
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

        //检验表单
        function beforeSubmit(form){
            var worder_type = $('#worder_type').val();
            if (!worder_type) { art_show_msg('请选择工单类型'); return false; }
            var urgent      = $("input[name=info['urgent']]:checked").val()
            var u_cause     = $("#urgent_cause").val();
            var worder_type = $('#worder_type').val();
            var op_id       = $("#op_id").val();
            if (urgent==1 && u_cause == ''){
                art_show_msg("工单紧急原因不能为空!",3);
                return false;
            }else if(worder_type == 100 && op_id == ''){
                art_show_msg("项目团号信息有误!",3);
                return false;
            }else{
                $("#myform").submit;
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

            //2
            $("#keywords_exe2").autocomplete(keywords, {
                matchContains: true,
                highlightItem: false,
                formatItem: function (row, i, max, term) {
                    return row.text;
                },
                formatResult: function (row) {
                    return row.user_name;
                }
            }).result(function (event, item) {
                $("#exe_2").val(item.id);
            });

            //3
            $("#keywords_exe3").autocomplete(keywords, {
                matchContains: true,
                highlightItem: false,
                formatItem: function (row, i, max, term) {
                    return row.text;
                },
                formatResult: function (row) {
                    return row.user_name;
                }
            }).result(function (event, item) {
                $("#exe_3").val(item.id);
            });

            //4
            $("#keywords_exe4").autocomplete(keywords, {
                matchContains: true,
                highlightItem: false,
                formatItem: function (row, i, max, term) {
                    return row.text;
                },
                formatResult: function (row) {
                    return row.user_name;
                }
            }).result(function (event, item) {
                $("#exe_4").val(item.id);
            });

            //5
            $("#keywords_exe5").autocomplete(keywords, {
                matchContains: true,
                highlightItem: false,
                formatItem: function (row, i, max, term) {
                    return row.text;
                },
                formatResult: function (row) {
                    return row.user_name;
                }
            }).result(function (event, item) {
                $("#exe_5").val(item.id);
            });
        })


        //移除题目
        function del_timu(obj){
            $('#'+obj).remove();

        }


    </script>
