<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>资源需求反馈</h1>
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

                                <include file="op_res_nfeedback" />
                                <?php if($resource['audit_user_id'] == cookie('userid') && $resource['audit_status'] != 1){ ?>
                                    <form method="post" action="{:U('op/public_save')}" id="feed_back">
                                        <input type="hidden" name="dosubmint" value="1">
                                        <input type="hidden" name="opid" value="{$op.op_id}">
                                        <input type="hidden" name="res_id" value="{$resource.id}">
                                        <input type="hidden" name="savetype" value="20">
                                        <div class="content">
                                            <div class="form-group col-md-12">
                                                <label>审核需求信息：</label>
                                                <input type="radio" name="info[audit_status]" value="1" <?php if ($resource['audit_status'] == 1){echo 'checked';} ?>> &emsp;通过&emsp;&emsp;&emsp;
                                                <input type="radio" name="info[audit_status]" value="2" <?php if ($resource['audit_status'] == 2){echo 'checked';} ?>> &emsp;不通过
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label>指派负责人：</label>
                                                <input type="text" name="info[exe_user_name]" value="{$resource['exe_user_name']}" class="form-control" placeholder="审核人员" id="res_exe_user_name" required />
                                                <input type="hidden" name="info[exe_user_id]" value="{$resource['exe_user_id']}" class="form-control" id="res_exe_user_id" />
                                            </div>
                                        </div>

                                        <div style="width:100%; text-align:center;">
                                            <a  href="javascript:;" class="btn btn-info btn-lg" onClick="javascript:save('feed_back','<?php echo U('Op/public_save'); ?>');">保存</a>
                                        </div>
                                    </form>
                                <?php } ?>

                                <?php if($resource['exe_user_id'] == cookie('userid') && $resource['status'] != 1){ ?>
                                    <form method="post" action="{:U('op/public_save')}" id="feed_back">
                                        <input type="hidden" name="dosubmint" value="1">
                                        <input type="hidden" name="opid" value="{$op.op_id}">
                                        <input type="hidden" name="res_id" value="{$resource.id}">
                                        <input type="hidden" name="savetype" value="15">
                                        <div class="content">
                                            <div class="form-group col-md-12">
                                                <div class="callout callout-danger">
                                                    <h4>提示！</h4>
                                                    <p>工作完成后请及时填写完成信息，以免影响您的绩效考核!</p>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label>完成情况：</label>
                                                <input type="radio" name="info[status]" value="1" <?php if ($resource['status'] == 1){echo 'checked';} ?>> &emsp;已完成&emsp;&emsp;&emsp;
                                                <input type="radio" name="info[status]" value="2" <?php if ($resource['status'] == 2){echo 'checked';} ?>> &emsp;未完成
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label>资源配置反馈信息：</label><textarea class="form-control"  name="info[res_feedback]">{$resource['res_feedback']}</textarea>
                                            </div>
                                        </div>

                                        <div style="width:100%; text-align:center;">
                                            <a  href="javascript:;" class="btn btn-info btn-lg" onClick="javascript:save('feed_back','<?php echo U('Op/public_save'); ?>');">保存</a>
                                        </div>
                                    </form>
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
        autocom('res_exe_user_name','res_exe_user_id');
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

    //保存信息
    function save(id,url){
        $.ajax({
            type: "POST",
            url: url,
            dataType:'json',
            data: $('#'+id).serialize(),
            success:function(data){
                if(parseInt(data)>0){
                    art.dialog.alert('保存成功','success');
                }else{
                    art.dialog.alert('保存失败','warning');
                }
            }
        });

        setTimeout("history.go(0)",1000);
    }

    artDialog.alert = function (content, status) {
        return artDialog({
            id: 'Alert',
            icon: status,
            width:300,
            height:120,
            fixed: true,
            lock: true,
            time: 1,
            content: content,
            ok: true
        });
    };

    function print_part(){
        var op_kind = <?php echo $op_kind; ?>;
        if (op_kind == 60){
            document.body.innerHTML=document.getElementById('after_lession').innerHTML;
        }else{
            document.body.innerHTML=document.getElementById('res_need_table').innerHTML;
        }
        window.print();
    }
</script>
     


