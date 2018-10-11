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

                                    <form method="post" action="{:U('op/public_save')}" id="feed_back">
                                        <input type="hidden" name="dosubmint" value="1">
                                        <input type="hidden" name="opid" value="{$op.op_id}">
                                        <input type="hidden" name="res_id" value="{$resource.id}">
                                        <input type="hidden" name="savetype" value="15">
                                        <div class="content">
                                            <div class="form-group col-md-12">
                                                <label>资源配置反馈信息：</label><textarea class="form-control"  name="info[res_feedback]">{$resource['res_feedback']}</textarea>
                                            </div>
                                        </div>

                                        <div style="width:100%; text-align:center;">
                                            <!--<button type="submit" class="btn btn-info btn-lg" id="lrpd">提交</button>-->
                                            <a  href="javascript:;" class="btn btn-info btn-lg" onClick="javascript:save('feed_back','<?php echo U('Op/public_save'); ?>');">保存</a>
                                        </div>
                                    </form>
                                    
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
     


