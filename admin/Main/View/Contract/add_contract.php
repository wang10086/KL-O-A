<include file="Index:header2" />



            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {$_pagetitle_}
                        <small>{$_pagedesc_}</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('ScienceRes/res')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            <!-- general form elements disabled -->
                            <form method="post" action="{:U('Contract/add')}" name="myform" id="myform" onsubmit="return beforeSubmit(this)">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body_bak">
                                    
                                    <input type="hidden" name="dosubmit" value="1" />
                                    <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                                    <input type="hidden" name="id" value="{$row.id}" />
                                    
                                    <!-- text input -->
                                    
                                    <div class="form-group col-md-12">
                                   		<h2 style="font-size:16px; color:#ff3300; border-bottom:2px solid #dedede; padding-bottom:10px;">合同信息</h2>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>合同类型</label>
                                        <select name="info[type]" class="form-control" id="type">
                                            <option value="1">团内合同</option>
                                            <option value="2">非团合同</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-8 nop-contract">
                                        <label>合同标题</label>
                                        <input type="text" class="form-control" name="project">
                                    </div>

                                    <div class="form-group col-md-4" id="need_tpl_or_not">
                                        <label>是否选择合同模板：</label>
                                        <div class="form-control no-border">
                                            <input type="radio" name="is_tpl" value="1"  <?php if($rad==1){ echo 'checked';} ?>> &nbsp;选择 &#12288;&#12288;
                                            <input type="radio" name="is_tpl" value="0"  <?php if($rad==0){ echo 'checked';} ?>> &nbsp;不选择
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4" id="tpl-box">
                                        <label>请选择模板</label>
                                        <select name="info[tpl_id]" class="form-control">
                                            <option value="">==请选择==</option>
                                            <foreach name="tpl_list" key="k" item="v">
                                                <option value="{$k}">{$v}</option>
                                            </foreach>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>是否需要律师审核</label>
                                        <select name="info[lawyer]" class="form-control">
                                            <option value="1">需要律师审核</option>
                                            <option value="2">不需要律师审核</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>合同金额</label>
                                        <input type="text" name="info[contract_amount]" id="contract_amount"   value="{$row.contract_amount}" class="form-control" required />
                                    </div>
                                    
                                    <div class="form-group col-md-4 op-contract">
                                        <label>团号<small>（如无团号信息可暂不填写）</small></label>
                                        <input type="text" name="info[group_id]" value="{$row.group_id}" class="form-control" />
                                    </div>

                                    <div class="form-group col-md-4 op-contract">
                                        <label>出团时间</label>
                                        <input type="text" name="info[dep_time]" id="dep_time"   value="{$row.dep_time}" class="form-control inputdate" />
                                    </div>
                                    
                                    <div class="form-group col-md-4 op-contract">
                                        <label>结束时间</label>
                                        <input type="text"  name="info[end_time]" id="end_time"   value="{$row.end_time}" class="form-control inputdate" />
                                    </div>
                                    
                                    
                                    <div class="form-group col-md-12">
                                        <label>备注</label>
                                        <textarea class="form-control" name="info[remarks]">{$row.remarks}</textarea>
                                    </div>
                                    
                                    
                            		<div class="form-group col-md-12">
                                   		<h2 style="font-size:16px; color:#ff3300; border-bottom:2px solid #dedede; padding-bottom:10px;">合同相关文件<small>（为了方便后期审核,请尽量上传word类型文件）</small></h2>
                                    </div>
                                    <div class="form-group col-md-12">
                                    {:upload_m('uploadfile','files',$atts,'上传文件')}
                                    </div>


                                </div>
                            </div><!-- /.box -->

                            <div class="form-group col-md-12" id="formsbtn">
                            	<button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                            </div>
                            </form>
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->

  </div>
</div>
            
<include file="Index:footer2" />

<script type="text/javascript">

    $(function () {
        $('#tpl-box').hide();
        //$('.op-contract').hide();
        $('.nop-contract').hide();

        $('#need_tpl_or_not').find('ins').each(function (index,ele) {
            $(this).click(function () {
                let is_tpl      = $(this).prev('input').val();
                if (is_tpl == 1){ //需要模板
                    $('#tpl-box').show();
                    $('select[name="info[tpl_id]"]').attr('required',true);
                }else{
                    $('#tpl-box').hide();
                    $('select[name="info[tpl_id]"]').removeAttr('required');
                    $('select[name="info[tpl_id]"]').val('');
                }
            })
        })
    })

    $('#type').on('change',function () {
        let type                = $(this).val();
        if (type == 1){ //团内合同
            $('.nop-contract').hide();
            $('.op-contract').show();
            $('input[name="project"]').val('');
        }else{ //非团合同
            $('.nop-contract').show();
            $('.op-contract').hide();
            $('input[name="info[dep_time]"]').val('');
            $('input[name="info[end_time]"]').val('');
            $('input[name="info[group_id]"]').val('');
        }
    });
</script>