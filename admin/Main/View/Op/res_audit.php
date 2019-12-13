<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>审核需求信息</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Op/index')}"><i class="fa fa-gift"></i> 出团计划</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12" style="padding-bottom:200px;">

                            <div class="box box-warning" style="margin-top:15px;">
                                <div class="box-header">
                                    <h3 class="box-title">
                                    <?php 
									if($op['status']==1){ 
										$th = '';
										if($op['group_id']) $th = '&nbsp;&nbsp; <span style="font-weight:normal; color:#ff3300;">（团号：'.$op['group_id'].'）</span>';	 
										echo '<span class="green">项目已成团</span>'.$th;
									}elseif($op['status']==2){ 
										echo '<span class="red">项目不成团</span>&nbsp;&nbsp; <span style="font-weight:normal">（原因：'.$op['nogroup'].'）</span>';
									}else{ 
										echo ' <span style=" color:#999999;">该项目暂未成团</span>';
									} ?>
                                    </h3>
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"><span class="green">项目编号：{$op.op_id}</span> &nbsp;&nbsp;创建者：{$op.create_user_name}</h3>
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                <?php if ($type == 1) { ?>
                                    <!--委托设计工作交接单--设计-->
                                    <include file="op_res_design" />

                                    <?php if($design['audit_user_id'] == cookie('userid') && $design['audit_status'] != P::AUDIT_STATUS_PASS){ ?>
                                        <form method="post" action="{:U('op/public_save')}" id="audit_design">
                                            <input type="hidden" name="dosubmint" value="1">
                                            <input type="hidden" name="opid" value="{$op.op_id}">
                                            <input type="hidden" name="design_id" value="{$design.id}">
                                            <input type="hidden" name="type" value="{$type}">
                                            <input type="hidden" name="savetype" value="17">
                                            <input type="hidden" id="isAssign">
                                            <div class="content">
                                                <div class="form-group col-md-12" id="checkUid">
                                                    <label>审核需求信息：</label>
                                                    <input type="radio" name="info[audit_status]" value="1" <?php if ($design['audit_status'] == 1){echo 'checked';} ?>> &emsp;通过&emsp;&emsp;&emsp;
                                                    <input type="radio" name="info[audit_status]" value="2" <?php if ($design['audit_status'] == 2){echo 'checked';} ?>> &emsp;不通过
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label>备注：</label>
                                                    <textarea class="form-control"  name="info[audit_remark]">{$design['audit_remark']}</textarea>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label>指派负责人：</label>
                                                    <input type="text" name="info[exe_user_name]" value="{$design['exe_user_name']}" class="form-control" placeholder="执行人员" id="design_exe_user_name" required />
                                                    <input type="hidden" name="info[exe_user_id]" value="{$design['exe_user_id']}" class="form-control" id="design_exe_user_id" />
                                                </div>

                                            </div>

                                            <div style="width:100%; text-align:center;">
                                                <!--<input type="submit" class="btn btn-info btn-lg" value = '提交'>-->
                                                <a  href="javascript:;" class="btn btn-info btn-lg" onClick="javascript:saveResForm()">保存</a>
                                            </div>
                                        </form>
                                    <?php } ?>

                                    <?php if($design['exe_user_id'] == cookie('userid') && $design['status'] != 1){ ?>
                                        <form method="post" action="{:U('op/public_save')}" id="audit_design">
                                            <input type="hidden" name="dosubmint" value="1">
                                            <input type="hidden" name="opid" value="{$op.op_id}">
                                            <input type="hidden" name="design_id" value="{$design.id}">
                                            <input type="hidden" name="type" value="{$type}">
                                            <input type="hidden" name="savetype" value="18">
                                            <div class="content">
                                                <div class="form-group col-md-12">
                                                    <div class="callout callout-danger">
                                                        <h4>提示！</h4>
                                                        <p>工作完成后请及时填写完成信息，以免影响您的绩效考核!</p>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label>完成情况：</label>
                                                    <input type="radio" name="info[status]" value="0" <?php if ($design['status'] == 0){echo 'checked';} ?>> &emsp;未完成&emsp;&emsp;&emsp;
                                                    <input type="radio" name="info[status]" value="1" <?php if ($design['status'] == 1){echo 'checked';} ?>> &emsp;已完成
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>备注：</label>
                                                    <textarea class="form-control"  name="info[exe_remark]">{$design['exe_remark']}</textarea>
                                                </div>
                                            </div>

                                            <div style="width:100%; text-align:center;">
                                                <input type="submit" class="btn btn-info btn-lg" value = '提交'>
                                            </div>
                                        </form>
                                    <?php } ?>
                                <?php }else{ ?>
                                    <!--业务实施计划单--计调-->
                                    <include file="op_res_work_plan" />
                                    <?php if($work_plan['audit_user_id'] == cookie('userid') && $work_plan['audit_status'] != P::AUDIT_STATUS_PASS){ ?>
                                        <form method="post" action="{:U('op/public_save')}" id="audit_design">
                                            <input type="hidden" name="dosubmint" value="1">
                                            <input type="hidden" name="opid" value="{$op.op_id}">
                                            <input type="hidden" name="plan_id" value="{$work_plan.id}">
                                            <input type="hidden" name="type" value="{$type}">
                                            <input type="hidden" name="savetype" value="17">
                                            <div class="content">
                                                <div class="form-group col-md-12">
                                                    <label>审核需求信息：</label>
                                                    <input type="radio" name="info[audit_status]" value="1" <?php if ($work_plan['audit_status'] == 1){echo 'checked';} ?>> &emsp;通过&emsp;&emsp;&emsp;
                                                    <input type="radio" name="info[audit_status]" value="2" <?php if ($work_plan['audit_status'] == 2){echo 'checked';} ?>> &emsp;不通过
                                                </div>
                                            </div>

                                            <div style="width:100%; text-align:center;">
                                                <input type="submit" class="btn btn-info btn-lg" value = '提交'>
                                            </div>
                                        </form>
                                    <?php } ?>

                                    <?php if($work_plan['exe_user_id'] == cookie('userid') && $work_plan['status'] != 1){ ?>
                                        <form method="post" action="{:U('op/public_save')}" id="audit_design">
                                            <input type="hidden" name="dosubmint" value="1">
                                            <input type="hidden" name="opid" value="{$op.op_id}">
                                            <input type="hidden" name="plan_id" value="{$work_plan.id}">
                                            <input type="hidden" name="type" value="{$type}">
                                            <input type="hidden" name="savetype" value="18">
                                            <div class="content">
                                                <div class="form-group col-md-12">
                                                    <div class="callout callout-danger">
                                                        <h4>提示！</h4>
                                                        <p>工作完成后请及时填写完成信息，以免影响您的绩效考核!</p>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label>完成情况：</label>
                                                    <input type="radio" name="info[status]" value="0" <?php if ($work_plan['status'] == 0){echo 'checked';} ?>> &emsp;未完成&emsp;&emsp;&emsp;
                                                    <input type="radio" name="info[status]" value="1" <?php if ($work_plan['status'] == 1){echo 'checked';} ?>> &emsp;已完成
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>备注：</label>
                                                    <textarea class="form-control"  name="info[exe_remark]">{$work_plan['exe_remark']}</textarea>
                                                </div>
                                            </div>

                                            <div style="width:100%; text-align:center;">
                                                <input type="submit" class="btn btn-info btn-lg" value = '提交'>
                                            </div>
                                        </form>
                                    <?php } ?>
                                <?php } ?>


                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                    
                    
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />

<script>
    var keywords = <?php echo $userkey; ?>;
    $(document).ready(function(e){
        autocom('design_exe_user_name','design_exe_user_id');

        $('#checkUid').find('ins').each(function (index,ele) {
            $(this).click(function () {
                var isneed = $(this).prev('input[name="info[audit_status]"]').val();
                if (isneed == 1){
                    $('#isAssign').val(1);
                }else{
                    $('#isAssign').val('');
                }
            })
        })
    });

    function autocom(username,userid){
        $("#"+username+"").autocomplete(keywords, {
            matchContains: true,
            highlightItem: false,
            formatItem: function(row, i, max, term) {
                return '<span style=" display:none">'+row.pinyin+'</span>'+row.text;
            },
            formatResult: function(row) {
                return row.text;
            }
        }).result(function (event, item) {
            $("#"+userid+"").val(item.id);
        });
    }

    function saveResForm() {
        let uid         = $('#design_exe_user_id').val();
        let isAssign    = $('#isAssign').val();
        if (isAssign ==1){
            if ( uid && uid !=0){
                $("#audit_design").submit();
            }else{
                art_show_msg('请正确填写实施人员信息');
                return false;
            }
        }else{
            $("#audit_design").submit();
        }

    }

    /*function print_design(){
        document.body.innerHTML=document.getElementById('design').innerHTML;
        window.print();
    }*/

    function print_part(id){
        document.body.innerHTML=document.getElementById(id).innerHTML;
        window.print();
    }
</script>
     


